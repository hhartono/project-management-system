/*
 * Dandelion Admin v2.0 - Form Demo JS
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
		if($.fn.autocomplete) {
			var availableTags = [
				"ActionScript",
				"AppleScript",
				"Asp",
				"BASIC",
				"C",
				"C++",
				"Clojure",
				"COBOL",
				"ColdFusion",
				"Erlang",
				"Fortran",
				"Groovy",
				"Haskell",
				"Java",
				"JavaScript",
				"Lisp",
				"Perl",
				"PHP",
				"Python",
				"Ruby",
				"Scala",
				"Scheme"
			];
			
			$( "#da-ex-autocomplete" ).autocomplete({
				source: availableTags
			});
		}
		
		$.fn.iButton && $(".i-button").iButton();
		
		$.fn.select2 && $(".select2-select").select2();

		$.fn.fileInput && $('.da-custom-file').fileInput();
	
		if($.fn.ColorPicker) {
			$("#da-ex-colorpicker").ColorPicker({
				onSubmit: function(hsb, hex, rgb, el) {
					$(el).val(hex);
					$(el).ColorPickerHide();
				}, 
				onBeforeShow: function () {
					$(this).ColorPickerSetColor(this.value);
				}
			});
		}
		
		$.fn.picklist && $("#da-ex-picklist").picklist();

        if( $.fn.spinner ) {

            $('.da-spinner').spinner();

            $('.da-decimal-spinner').spinner({
                step: 0.01,
                numberFormat: "n"
            });

            $.widget( "ui.timespinner", $.ui.spinner, {
                options: {
                    // seconds
                    step: 60 * 1000,
                    // hours
                    page: 60
                },
         
                _parse: function( value ) {
                    if ( typeof value === "string" ) {
                        // already a timestamp
                        if ( Number( value ) == value ) {
                            return Number( value );
                        }
                        return +Globalize.parseDate( value );
                    }
                    return value;
                },
         
                _format: function( value ) {
                    return Globalize.format( new Date(value), "t" );
                }
            });

            $( ".da-time-spinner" ).timespinner({
                value: new Date().getTime()
            });
		}

		if($.fn.autosize)
			$("#da-ex-autosize").autosize();
			
		if($.fn.elrte) {
			var opts = {
				cssClass : 'el-rte',
				height   : 300,
				toolbar  : 'normal',
				cssfiles : ['plugins/elrte/css/elrte-inner.css'], 
				fmAllow: true, 
				fmOpen : function(callback) {
					$('<div id="myelfinder"></div>').elfinder({
						url : 'plugins/elfinder/connectors/php/connector.php', 
						lang : 'en', 
						height: 300, /*
						toolbar : [
							['back', 'reload'], 
							['select', 'open'], 
							['quicklook', 'info', 'rename'], 
							['resize', 'icons', 'list', 'help']
						], 
						contextmenu : {
							// Commands that can be executed for current directory
							cwd : ['reload', 'delim', 'info'], 
							// Commands for only one selected file
							file : ['select', 'open', 'rename'], 
						}, */
						dialog : { width : 640, modal : true, title : 'Select Image' }, 
						closeOnEditorCallback : true,
						editorCallback : callback
					});
				}
			}
			$('#da-ex-wysiwyg').elrte(opts);
		}
	});
}) (jQuery);