/*
 * Dandelion Admin v2.0 - Customizer JS
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

;(function( $, window, document, undefined ) {

	var Customizer = function( ) {
		return this.init();
	}

	Customizer.prototype = {
		defaults: {
			baseUrl: '/dandelion', 
			backgroundPatterns: {
				blueprint: {
					name: 'Blueprint', 
					file: 'assets/images/bg/blueprint.png'
				}, 
				bricks: {
					name: 'Bricks', 
					file: 'assets/images/bg/bricks.png'
				}, 
				carbon: {
					name: 'Carbon', 
					file: 'assets/images/bg/carbon.png'
				}, 
				circuit: {
					name: 'Circuit', 
					file: 'assets/images/bg/circuit.png'
				}, 
				holes: {
					name: 'Holes', 
					file: 'assets/images/bg/holes.png'
				}, 
				mozaic: {
					name: 'Mozaic', 
					file: 'assets/images/bg/mozaic.png'
				}, 
				roof: {
					name: 'Roof', 
					file: 'assets/images/bg/roof.png'
				}, 
				stripes: {
					name: 'Stripes', 
					file: 'assets/images/bg/stripes.png'
				}
			}, 
			headerPatterns: {
				carbon: {
					name: 'Carbon', 
					file: 'assets/images/headers/carbon.png'
				}, 
				linen: {
					name: 'Linen', 
					file: 'assets/images/headers/linen.png'
				}, 
				leather: {
					name: 'Leather', 
					file: 'assets/images/headers/leather.png'
				}, 
				wood: {
					name: 'Wood', 
					file: 'assets/images/headers/wood.png'
				}
			}
		}, 

		init: function( options ) {
			this.options = $.extend( {}, this.defaults, options );

			var that = this;

			// Register Background Patterns
			this._registerBackgroundPatterns();

			// Register Header Patterns
			this._registerHeaderPatterns();

			// Listen for Layout Change Requests
			this._bindLayoutChanges();

			// Initialize CSS Dialog
			if( $.fn.dialog ) {
				var dialog = $('<div id="da-customizer-dialog"><textarea readonly="readonly" id="da-customizer-css"></textarea></div>');

				dialog.hide().appendTo('body')
					.dialog({
						modal: true, 
						autoOpen: false, 
						title: 'Get CSS Style', 
						resizable: false, 
						width: 450
					});

				// Listen to get CSS button
				$( '#da-customizer #da-customizer-button button' ).on( 'click', function( e ) {
					dialog.find('textarea').val( that._getCSS() ).end().dialog( 'open' );
					e.preventDefault();
				});
			}

			// Bind Pulldown Button
			$( '#da-customizer' )
				.addClass( 'active' )
				.find("#da-customizer-pulldown").on('click', function(e) {
					customizer = $(this).parents('#da-customizer');
					if(customizer.hasClass('toggled')) {
						customizer.stop().animate({ top: -that._calculateCustomizerHeight() }, function() {
							customizer.removeClass('toggled');
						});
					} else {
						customizer.stop().animate({ top: 0 }, function() {
							customizer.addClass('toggled');
						});
					}
					e.preventDefault();
				});

			this._updateCustomizerTopOffset();

			return this;
		}, 

		_registerBackgroundPatterns: function() {
			var select = $('<select id="da-body-pat"></select>');
			var that = this;

			select.on('change', function(e) {
				$('body').css('background-image', 'url(' + that.options.backgroundPatterns[ $(this).val() ].file + ')');
				e.preventDefault();
			});

			$.each( this.options.backgroundPatterns, function( i, bg ) {
				var option = $('<option></option>');
				option.val( i ).text( bg.name );
				option.appendTo( select );
			});
				
			$("#da-customizer #da-customizer-body-bg").append( select );
		}, 

		_registerHeaderPatterns: function() {
			var select = $('<select id="da-header-pat"></select>');
			var that = this;

			select.on('change', function(e) {
				$('div#da-header #da-header-top').css('background-image', 'url(' + that.options.headerPatterns[ $(this).val() ].file + ')');
				e.preventDefault();
			});

			$.each( this.options.headerPatterns, function( i, bg ) {
				var option = $('<option></option>');
				option.val( i ).text( bg.name );
				option.appendTo( select );
			});
				
			$("#da-customizer #da-customizer-header-bg").append( select );
		}, 

		_bindLayoutChanges: function() {
			$("#da-customizer-fixed, #da-customizer-fluid").on('change', function() {
				$('body #da-wrapper').toggleClass('fixed', $("#da-customizer-fixed").is(':checked') );
			}).trigger('change');
		}, 

		_getCSS: function() {
			var bg = this.options.backgroundPatterns[ $('#da-customizer #da-body-pat').val() ].file;
			var header = this.options.headerPatterns[ $('#da-customizer #da-header-pat').val() ].file;
				
			return '/* Paste the following code in /css/dandelion.theme.css */\n\nbody\n{\n\tbackground-image:url(../../'+bg+');\n}\n\ndiv#da-header #da-header-top\n{\n\tbackground-image:url(../../'+header+');\n}\n';
		}, 

		_calculateCustomizerHeight: function() {
			return $('#da-customizer #da-customizer-content').outerHeight();
		}, 

		_updateCustomizerTopOffset: function() {
			$( '#da-customizer' ).css( 'top', -this._calculateCustomizerHeight() );
		}
	};

	$(document).ready(function(e) {
		new Customizer();
	});		

}) ( jQuery, window, document );