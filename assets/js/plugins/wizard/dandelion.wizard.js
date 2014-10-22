/*
 * Dandelion Admin v2.0 - Wizard Form JS
 *
 * This file is part of Dandelion Admin, an Admin template build for sale at ThemeForest.
 * For questions, suggestions or support request, please mail me at maimairel@yahoo.com
 *
 * Development Started:
 * March 25, 2012
 * Last Update:
 * December 07, 2012
 *
 * 'Highly configurable' mutable plugin boilerplate
 * Author: @markdalgleish
 * Further changes, comments: @addyosmani
 * Licensed under the MIT license
 *
 */

;(function($, window, document, undefined) {
	// our plugin constructor
	var Wizard = function( element, options ) {
		if( arguments.length ) {
			this._init( element, options );
		}
    };
	
	// the plugin prototype
	Wizard.prototype = {
		defaults: {
			element: 'fieldset', 
			labelElement: 'legend', 

			buttonContainerClass: 'btn-row', 
			nextButtonClass: 'btn btn-danger pull-left', 
			prevButtonClass: 'btn pull-left', 
			submitButtonClass: 'btn btn-primary', 
			activeIconClass: 'icol-accept', 

			nextButtonLabel: 'Next', 
			prevButtonLabel: 'Prev', 
			submitButtonLabel: 'Submit',

			submitButtonName: 'dnd-wizard', 
			forwardOnly: false, 

			onLeaveStep: null, // function( wizard, step )
			onShowStep: null, // function( wizard, step )
			onBeforeSubmit: null, // function( wizard, form )

			ajaxSubmit: false, 
			ajaxFormOptions: {}
		}, 
		
		_init: function( element, options ) {

			this.element = $( element );
			this.options = $.extend( {}, this.defaults, options, this.element.data() );

			//Global Variables
			this._activeWzdId = -1;
			this._navigationLocked = false;
			this._activatedSteps = [];

			// Parse Options
			this._parseOptions();

			// Retrieve the steps
			this.steps = this.element.find( this.options.element );

			// Hide the steps
			this.steps.hide();

			// Build Navigation
			this.nav = this._buildNavigation( this.steps );

			// Build Buttons
			this.buttons = this._buildButtons();

			// Insert navigation
			this.element.before( $( '<div class="dwizard-nav"></div>' ).append( this.nav ) );

			// Append Buttons
			this.element.append( $( '<div class="btn-row"></div>' ).append( $.map( this.buttons, function( v, k ) { return v; } ) ) );

			// Bind Events
			this._bindEventHandlers();

			// Goto first step
			this._navigate( this.steps.eq( 0 ).data( 'wzd-id' ), true );
		}, 

		_callFunction: function( fn, args ) {
			return !$.isFunction( fn )? true : fn.apply( this, args );
		}, 

		_parseOptions: function() {
			// Prepare Ajax Form
			if( this.options.ajaxSubmit && $.fn.ajaxSubmit ) {
				var formOptionsSuccess = this.options.ajaxFormOptions.success;
				var formOptionsComplete = this.options.ajaxFormOptions.complete;
				var formOptionsError = this.options.ajaxFormOptions.error;
				var formOptionsBeforeSend = this.options.ajaxFormOptions.beforeSend;
				var formOptionsBeforeSubmit = this.options.ajaxFormOptions.beforeSubmit;
				var formOptionsBeforeSerialize = this.options.ajaxFormOptions.beforeSerialize;

				this.options.ajaxFormOptions = $.extend( {}, this.options.ajaxFormOptions, {
					success: function( responseText, textStatus, xhr, form ) {
						$.isFunction( formOptionsSuccess ) && formOptionsSuccess.call( this, responseText, textStatus, xhr, form );
					}, 

					complete: function( xhr, textStatus ) {
						$.isFunction( formOptionsComplete ) && formOptionsComplete.call( this, xhr, textStatus );
					}, 

					error: function( xhr, textStatus ) {
						$.isFunction( formOptionsError ) && formOptionsError.call( this, xhr, textStatus );
					}, 

					beforeSubmit: function( data, form, options ) {
						if( $.isFunction( formOptionsBeforeSubmit ) ) {
							return formOptionsBeforeSubmit.call( this, arr, form, options );
						}
						return true;
					}, 

					beforeSend: function( xhr ) {
						if( $.isFunction( formOptionsBeforeSend ) ) {
							return formOptionsBeforeSend.call( this, xhr );
						}
						return true;
					}, 

					beforeSerialize: function( form, options ) {
						if( $.isFunction( formOptionsBeforeSerialize ) ) {
							return formOptionsBeforeSerialize.call( this, form, options );
						}
						return true;
					}
				});

				this.element.ajaxForm( this.options.ajaxFormOptions );
			}
		}, 

		_generateRandomId: function() {
			var guid = new Date().getTime().toString(32), i;

			for (i = 0; i < 3; i++) {
				guid += Math.floor(Math.random() * 65535).toString(32);
			}

			return 'wzd_' + guid;
		}, 

		_retrieveIcons: function( index, stepTitle ) {
			var data = stepTitle.data();
			var icon = $( '<i class="wzd-icon"></i>' );

			return [
				(data['icon'] !== undefined? icon.addClass( data['icon'] ) : icon.html( ++index )), 
				$( '<i class="wzd-active-icon"></i>' ).addClass( this.options.activeIconClass )
			];
		}, 

		_buildNavigation: function( steps ) {
			var that = this;
			var nav = $( '<ul></ul>' );
			var stepCount = steps.length;

			$.each( steps, function( i, step ) {

				var item = $( '<li></li>' );
				var title = $( step ).find( that.options.labelElement ).hide();

				var link = $( '<span class="wzd-link"></span>' );
				var label = $( '<span class="wzd-label"></span>' ).text( title.text() );

				var icons = that._retrieveIcons( i, title );
				var dim = (100.0 / stepCount) + '%';

				item.append( link.append( icons ) ).append( label ).appendTo( nav );
				item.css({'width': dim });

				$( step ).add( item ).attr( 'data-wzd-id', that._generateRandomId() );
			});

			return $( nav.append( $( '<li></li>' ).addClass( 'progress' ) ) );
		}, 

		_buildButtons: function() {
			var btn = $( '<button type="button"></button>' );

			var prevButton = btn.clone().addClass( this.options.prevButtonClass ).text( this.options.prevButtonLabel );
			var nextButton = btn.clone().addClass( this.options.nextButtonClass ).text( this.options.nextButtonLabel );
			var submitButton = btn.clone().addClass( this.options.submitButtonClass ).text( this.options.submitButtonLabel ).attr('name', this.options.submitButtonName);

			return { prev: prevButton, next: nextButton, submit: submitButton };
		}, 

		_refreshButtons: function() {
			this.buttons.prev.attr( 'disabled', this._isFirstStep( this._activeWzdId ) );
			this.buttons.next.attr( 'disabled', this._isLastStep( this._activeWzdId ) );

			this.buttons.submit.toggle( this._isLastStep( this._activeWzdId ) );
		}, 

		_bindEventHandlers: function() {
			var that = this;

			this.nav.on( 'click', '.wzd-link', function( e ) {
				that._navigate( $( this ).parents('li').data('wzd-id') );
				e.preventDefault();
			});

			this.buttons.prev.on( 'click', function( e ) {
				that.prev();
				e.preventDefault();
			});

			this.buttons.next.on( 'click', function( e ) {
				that.next();
				e.preventDefault();
			});

			this.buttons.submit.on( 'click', function( e ) {
				that.submitForm();
				e.preventDefault();
			});

		}, 

		_canNavigate: function( wzdId ) {
			var step = this._findStep( wzdId );
			var currentStep = this._findStep( this._activeWzdId );

			return !this._navigationLocked && !(this.options.forwardOnly && step && currentStep && step.index() <= currentStep.index());
		}, 

		_stepActivated: function( wzdId ) {
			return this._validWzdId( wzdId ) && $.inArray( wzdId, this._activatedSteps ) > -1;
		}, 

		_activateStep: function( wzdId ) {
			if ( this._validWzdId( wzdId ) ) {
				var stepIndex = this._findNav( wzdId ).index();
				for( var i = 0; i < stepIndex; ++i) { 
					if( $.inArray( this.steps.eq( i ).data( 'wzd-id' ), this._activatedSteps ) === -1 ) {
						return;
					}
				}
				( $.inArray( wzdId, this._activatedSteps ) === -1 ) && this._activatedSteps.push( wzdId );
			}
		}, 

		_setActiveIcon: function( wzdId ) {
			if ( this._validWzdId( wzdId ) ) {
				this._findNav( wzdId ).addClass( 'wzd-done' );
			}
		}, 

		_findStep: function( wzdId ) {
			return this.steps.filter( '[data-wzd-id="' + wzdId + '"]' ).first();
		}, 

		_findNav: function( wzdId ) {
			return this.nav.children('li').filter( '[data-wzd-id="' + wzdId + '"]' ).first();
		}, 

		_navigate: function( wzdId, ignore ) {
			if( this._validWzdId( wzdId ) ) {
				if( ignore || ( this._canNavigate( wzdId ) && this._callFunction( this.options.onLeaveStep, [ this, this._findStep( this._activeWzdId )[0] ] ) ) ) {
					this._activateStep( wzdId );
					this._showStep( wzdId );
				}
			}
		}, 

		_showStep: function( wzdId ) {
			if( this._validWzdId( wzdId ) ) {
				if( this._activeWzdId === -1 ) {
					this.steps.hide();
					this._findStep( wzdId ).show();
					this._updateNav( wzdId );
					this._activeWzdId = wzdId;
					this._refreshButtons();
				} else if( wzdId !== this._activeWzdId && this._stepActivated( wzdId ) ) {

					var activeStep = this._findStep( this._activeWzdId );
					var that = this;
					that._setActiveIcon( that._activeWzdId );
					this._navigationLocked = true;

					activeStep.fadeOut( 'fast', function() {
						that._updateNav( wzdId );

						var newStep = that._findStep( wzdId );
						newStep.fadeIn( 'fast', function() {
							that._activeWzdId = wzdId;
							that._navigationLocked = false;
							that._refreshButtons();

							that._callFunction( that.options.onShowStep, [ that, newStep ] )
						});
					});
				}
			}
		}, 

		_updateNav: function( wzdId ) {
			if( this._validWzdId( wzdId ) ) {
				var index = this._findNav( wzdId ).index();
				var progress = this.nav.children().filter( '.progress' );
				var navCount = this.nav.children().filter( ':not(.progress)' ).length;
				var dim = ((100.0 / navCount) * ++index).toString() + '%';

				progress.css({ 'width': dim });
			}
		}, 

		_isLastStep: function( wzdId ) {
			return this._validWzdId( wzdId ) && wzdId === this.steps.last().data('wzd-id');
		}, 

		_isFirstStep: function( wzdId ) {
			return this._validWzdId( wzdId ) && wzdId === this.steps.first().data('wzd-id');
		}, 

		_validWzdId: function( wzdId ) {
			return typeof( wzdId ) === 'string' && wzdId.indexOf( 'wzd_' ) === 0;
		}, 

		next: function() {
			if( !this._isLastStep( this._activeWzdId ) )
				this._navigate( this._findStep( this._activeWzdId ).next().data( 'wzd-id' ) );
		}, 

		prev: function() {
			if( !this._isFirstStep( this._activeWzdId ) )
				this._navigate( this._findStep( this._activeWzdId ).prev().data( 'wzd-id' ) );
		}, 

		submitForm: function() {
			if( this._callFunction( this.options.onBeforeSubmit, [ this, this.element ] ) )
				this.element.submit();
		}, 

		reset: function() {
			// Reset Variables
			this._activatedSteps = [];
			this._activeWzdId = -1;
			this._navigationLocked = false;

			// Hide Steps
			this.steps.hide();

			// Clear form fields
			$.fn.clearForm && this.element.clearForm();

			// Reset Nav
			this.nav.children('li').removeClass('wzd-done');

			// Go to first step
			this._navigate( this.steps.eq( 0 ).data( 'wzd-id' ), true );
		}, 

		option: function( key, value ) {
			
			if ( arguments.length === 0 ) {
				// don't return a reference to the internal hash
				return $.extend( {}, this.options );
			}

			if  (typeof key === "string" ) {
				if ( value === undefined ) {
					return this.options[ key ];
				}

				this.options[ key ] = value;
			}

			return this;
		}
	}
	
	$.fn.wizard = function(options) {

		var isMethodCall = typeof options === "string",
			args = Array.prototype.slice.call( arguments, 1 ),
			returnValue = this;

		// prevent calls to internal methods
		if ( isMethodCall && options.charAt( 0 ) === "_" ) {
			return returnValue;
		}

		if ( isMethodCall ) {
			this.each(function() {
				var instance = $.data( this, 'wizard' ),
					methodValue = instance && $.isFunction( instance[options] ) ?
						instance[ options ].apply( instance, args ) :
						instance;

				if ( methodValue !== instance && methodValue !== undefined ) {
					returnValue = methodValue;
					return false;
				}
			});
		} else {
			this.each(function() {
				var instance = $.data( this, 'wizard' );
				if ( !instance ) {
					$.data( this, 'wizard', new Wizard( this, options ) );
				}
			});
		}

		return returnValue;
	};

})(jQuery, window , document);
