(function($) {
	$(document).ready(function(e) {
        $("table#da-planning-datatable-numberpaging").DataTable({
            sPaginationType: "full_numbers"
        });

        // set focus to search box
        $('div#da-planning-datatable-numberpaging_filter input').focus();

        // make the text field ready for the next input
        $("div#da-planning-datatable-numberpaging_filter input").keypress(function(event) {
            if(event.keyCode == 13) {
                this.select();
            }
        });

        var element = document.getElementById('planning');
        element.classList.add("active");

        $('#nav-menu').empty();
        // $('#nav-menu').html('<a href="#">Barang</a>');
        $('#nav-submenu').empty();
        $('#nav-submenu').html('<span>Perencanaan Bahan</span>');
        $('#nav-submenu').addClass('active');
	});
}) (jQuery);