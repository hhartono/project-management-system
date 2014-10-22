/*
 * Dandelion Admin v2.0 - Core JS
 *
 * This file is part of Dandelion Admin, an Admin template build for sale at ThemeForest.
 * For questions, suggestions or support request, please mail me at maimairel@yahoo.com
 *
 * Development Started:
 * March 25, 2012
 * Last Update:
 * December 07, 2012
 *
 */

(function($) {
	$(document).ready(function(e) {

		// Bootstrap Dropdown Workaround
		$(document).on('touchstart.dropdown.data-api', '.dropdown-menu', function (e) { e.stopPropagation() });

		/* Notification Messages */
		$('.da-message').on('click', function(e) {
			$(this).animate({ opacity: 0 }, function() {
				$(this).slideUp( 'normal', function() {
					$(this).css( 'opacity', '' );
				});
			});
			e.preventDefault();
		});
		
		/* Main navigation on mobile */		
		$('#da-sidebar-toggle').on('click', function(e) {
			$('#da-main-nav').slideToggle('normal', function() { $(this).removeAttr('style').toggleClass('open'); });
			e.preventDefault();
		});
		
		/* Checkable Tables */
		$( 'table thead th.checkbox-column :checkbox' ).on('change', function() {
			var checked = $( this ).prop( 'checked' );
			$( this ).parents('table').children('tbody').each(function(i, tbody) {
				$(tbody).find('.checkbox-column').each(function(j, cb) {
					$( ':checkbox', $(cb) ).prop( 'checked', checked ).trigger('change');
				});
			});
		});

		/* Collapsible Panels */
		$( '.da-panel.collapsible' ).each(function(i, element) {
			var p = $( element ),	
				header = p.find( '.da-panel-header' );

			if( header && header.length) {
				var btn = $('<div class="da-panel-toggler"><span></span></div>').appendTo(header);
				$(btn).on( 'click', function(e) {
					var p = $( this ).parents( '.da-panel' );
					if( p.hasClass('collapsed') ) {
						p.removeClass( 'collapsed' )
							.children( '.da-panel-inner-wrap' ).hide().slideDown( 250 );
					} else {
						p.children( '.da-panel-inner-wrap' ).slideUp( 250, function() {
							p.addClass( 'collapsed' );
						});
					}
					e.preventDefault();
				});
			}

			if( !p.children( '.da-panel-inner-wrap' ).length ) {
				p.children( ':not(.da-panel-header)' )
					.wrapAll( $('<div></div>').addClass( 'da-panel-inner-wrap' ) );
			}
		});
				
		/* Dropdown Navigation */
		$('div#da-content #da-main-nav > ul > li').on('click', ' > a, > span', function(e) {
			if( $(this).next('ul').length ) {
				$(this).next('ul').first().slideToggle('normal', function() {
					$(this).toggleClass('closed');
				});
				e.preventDefault();
			}
		});

		/* Placeholder */
		$.fn.placeholder && $('[placeholder]').placeholder();

		/* Tooltips */
		$.fn.tooltip && $('[rel="tooltip"]').tooltip();

		/* Popovers */
		$.fn.popover && $('[rel="popover"]').popover();
		
	});
}) (jQuery);