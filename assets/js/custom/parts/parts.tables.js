(function($) {
	$(document).ready(function(e) {
        $("table#da-parts-datatable-numberpaging").DataTable({
            sPaginationType: "full_numbers"
        });

        // set focus to search box
        $('div#da-parts-datatable-numberpaging_filter input').focus();

        // make the text field ready for the next input
        $("div#da-parts-datatable-numberpaging_filter input").keypress(function(event) {
            if(event.keyCode == 13) {
                this.select();
            }
        });
	});
}) (jQuery);