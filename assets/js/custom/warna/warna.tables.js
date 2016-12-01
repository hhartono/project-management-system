(function($) {
	$(document).ready(function(e) {
        $("table#da-warna-datatable-numberpaging").DataTable({
            sPaginationType: "full_numbers"
        });

        // set focus to search box
        $('div#da-warna-datatable-numberpaging_filter input').focus();

        // make the text field ready for the next input
        $("div#da-warna-datatable-numberpaging_filter input").keypress(function(event) {
            if(event.keyCode == 13) {
                this.select();
            }
        });

        var element = document.getElementById('warna');
        element.classList.add("active");

        $('#nav-menu').empty();
        $('#nav-menu').html('<a href="#">Warna</a>');
        $('#nav-submenu').empty();
        $('#nav-submenu').html('<span>Warna</span>');
        $('#nav-submenu').addClass('active');
	});
}) (jQuery);