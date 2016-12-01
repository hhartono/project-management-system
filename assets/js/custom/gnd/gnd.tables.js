(function($) {
    $(document).ready(function(e) {
        // r = $("table#da-gnd-datatable-numberpaging").DataTable({
        //     sPaginationType: "full_numbers"
        // });
        // r.destroy();

        // set focus to search box
        // $('div#da-gnd-datatable-numberpaging_filter input').focus();

        // make the text field ready for the next input
        // $("div#da-gnd-datatable-numberpaging_filter input").keypress(function(event) {
        //     if(event.keyCode == 13) {
        //         this.select();
        //     }
        // });
        var element = document.getElementById('gnd');
        element.classList.add("active");

        $('#nav-menu').empty();
        $('#nav-menu').html('<a href="#">GND</a>');
        $('#nav-submenu').empty();
        $('#nav-submenu').html('<span>Generator No Dokumen</span>');
        $('#nav-submenu').addClass('active');
    });
}) (jQuery);