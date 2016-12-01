(function($) {
	$(document).ready(function(e) {
        $("table#da-purchaseorder-datatable-numberpaging").DataTable({
            sPaginationType: "full_numbers",
            order: [0, "desc"],
            columnDefs: [
                {
                    "targets": [0],
                    "visible": false
                }
            ]
        });

        // set focus to search box
        $('div#da-purchaseorder-datatable-numberpaging_filter input').focus();

        // make the text field ready for the next input
        $("div#da-purchaseorder-datatable-numberpaging_filter input").keypress(function(event) {
            if(event.keyCode == 13) {
                this.select();
            }
        });

        var element = document.getElementById('purchaseorder');
        element.classList.add("active");

        $('#nav-menu').empty();
        // $('#nav-menu').html('<a href="#">Purchase Order</a>');
        $('#nav-submenu').empty();
        $('#nav-submenu').html('<span>Purchase Order</span>');
        $('#nav-submenu').addClass('active');
	});
}) (jQuery);