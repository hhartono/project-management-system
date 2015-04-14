/*
 * Dandelion Admin v2.0 - Wizard Demo JS
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
	$(document).ready(function() {
		
		var v_validate = $("#wizard-validate").validate({ onsubmit: false });
		$("#wizard-validate").wizard({
			onLeaveStep: function( currentStep ) {
				return v_validate.form();
			}, 
			onBeforeSubmit: function( wizard ) {
				return v_validate.form();
			}
		});

		var v1_validate = $("#wizard-forward").validate({ onsubmit: false });
		$("#wizard-forward").wizard({
			forwardOnly: true, 
			onLeaveStep: function( currentStep ) {
				return v1_validate.form();
			}, 
			onBeforeSubmit: function( wizard ) {
				return v1_validate.form();
			}
		});

		var v2_validate = $("#wizard-ajax").validate({ onsubmit: false });
		$("#wizard-ajax").wizard({
			forwardOnly: true, 
			onLeaveStep: function( currentStep ) {
				return v2_validate.form();
			}, 
			onBeforeSubmit: function( wizard ) {
				return v2_validate.form();
			}, 
			ajaxSubmit: true, 
			ajaxFormOptions: {
				success: function( responseText, textStatus, xhr, form ) {
					if( confirm( 'Reset the wizard?' ) ) {
						form && form.wizard( 'reset' );
					}
				}
			}
		});

		$("#wizard-default").wizard();
	});
}) (jQuery);