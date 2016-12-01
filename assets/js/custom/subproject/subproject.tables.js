(function($) {
	$(document).ready(function(e) {
        $("table#da-subproject-datatable-numberpaging").DataTable({
            sPaginationType: "full_numbers"
        });

        // set focus to search box
        $('div#da-subproject-datatable-numberpaging_filter input').focus();

        // make the text field ready for the next input
        $("div#da-subproject-datatable-numberpaging_filter input").keypress(function(event) {
            if(event.keyCode == 13) {
                this.select();
            }
        });

        var element = document.getElementById('project');
        element.classList.add("active");

        $('#nav-menu').empty();
        $('#nav-menu').html('<a href="#">Project</a>');
        $('#nav-submenu').empty();
        $('#nav-submenu').html('<span>Subproject</span>');
        $('#nav-submenu').addClass('active');
	});
}) (jQuery);