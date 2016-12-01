(function($) {
	$(document).ready(function(e) {
        $("table#da-division-datatable-numberpaging").DataTable({
            sPaginationType: "full_numbers"
        });

        // set focus to search box
        $('div#da-division-datatable-numberpaging_filter input').focus();

        // make the text field ready for the next input
        $("div#da-division-datatable-numberpaging_filter input").keypress(function(event) {
            if(event.keyCode == 13) {
                this.select();
            }
        });

        var element = document.getElementById('tukang');
        element.classList.add("active");

        $('#nav-menu').empty();
        $('#nav-menu').html('<a href="#">Tukang</a>');
        $('#nav-submenu').empty();
        $('#nav-submenu').html('<span>Divisi Tukang</span>');
        $('#nav-submenu').addClass('active');
	});
}) (jQuery);