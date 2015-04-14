/*
 * Dandelion Admin v2.0 - Dashboard Demo JS
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
	$(window).load(function(e) {
		
		var v_validate = $("#da-ex-wizard-form").validate({ onsubmit: false });
		$("#da-ex-wizard-form").wizard({
			onLeaveStep: function( currentStep ) {
				return v_validate.form();
			}, 
			onBeforeSubmit: function( wizard ) {
				return v_validate.form();
			}, 
			ajaxSubmit: true, 
			ajaxFormOptions: {
				success: function( responseText, textStatus, xhr, form ) {
					alert( responseText );
					if( confirm( 'Reset the wizard?' ) ) {
						form && form.wizard( 'reset' );
					}
				}
			}
		});
		
		$("#da-ex-calendar-gcal").fullCalendar({
			events: 'http://www.google.com/calendar/feeds/usa__en%40holiday.calendar.google.com/public/basic',
				
			eventClick: function(event) {
				// opens events in a popup window
				window.open(event.url, 'gcalevent', 'width=700,height=600');
				return false;
			}
		});
		
		if( $.plot ) {
			var 
				s = [100, 35, 35, 30, 105, 40, 35, 30, 40, 20, 15], 
				p = [12, 6, 0, 9, 15, 3, 18, 3, 6, 7, 9], 
				v = [54, 105, 35, 45, 75, 6, 20, 15, 30, 35, 45], 
				sales = [], 
				supportRequests = [], 
				pageViews = [], 
				previousPoint = null;
			for(var i = 0; i < s.length; i++) {
				sales.push([new Date(Date.UTC(2012, 5, i + 1)), s[i]]);
				supportRequests.push([new Date(Date.UTC(2012, 5, i + 1)), p[i]]);
				pageViews.push([new Date(Date.UTC(2012, 5, i + 1)), v[i]]);
			}
			
			var opts = {
				series: {
					lines: { show: true }, 
					points: { show: true }
				}, 
				tooltip: true, 
				tooltipOpts: {
					defaultTheme: false
				}, 
				xaxis: {
					mode: "time", 
					min: new Date(Date.UTC(2012, 5, 1)).getTime(),
					max: new Date(Date.UTC(2012, 5, 11)).getTime()
				}, 
				grid: { 
					hoverable: true, 
					clickable: true, 
					borderWidth: null
				}
			};
			
			var plot = $.plot($("#da-ex-flot"), 
				[
				 { data: sales, label: "Sales", color: "#E15656"}, 
				 { data: supportRequests, label: "Support Requests", color: "#A6D037"}, 
				 { data: pageViews, label: "Page Views", color: "#61A5E4"}
				], 
				opts
			);
		}

		$(".circular-stat-wrap li").CircularStat();
	});
}) (jQuery);