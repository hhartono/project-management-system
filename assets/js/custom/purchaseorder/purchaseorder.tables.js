(function($) {
	$(document).ready(function(e) {
        $("table#da-purchaseorder-datatable-numberpaging").DataTable({
            sPaginationType: "full_numbers",
            order: [0, "desc"]
        });

        // set focus to search box
        $('div#da-purchaseorder-datatable-numberpaging_filter input').focus();

        // make the text field ready for the next input
        $("div#da-purchaseorder-datatable-numberpaging_filter input").keypress(function(event) {
            if(event.keyCode == 13) {
                this.select();
            }
        });
	});
}) (jQuery);