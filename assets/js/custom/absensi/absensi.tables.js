(function($) {
	$(document).ready(function(e) {
        $("table#da-absensi-datatable-numberpaging").DataTable({
            sPaginationType: "full_numbers"
        });
        $("#absensi-create-join-date").datepicker({showOtherMonths:true, dateFormat: 'yy-mm-dd'});

        $("#date-cari").datepicker({showOtherMonths:true, dateFormat: 'yy-mm-dd'});

        // set focus to search box
        $('div#da-absensi-datatable-numberpaging_filter input').focus();


        // make the text field ready for the next input
        $("div#da-absensi-datatable-numberpaging_filter input").keypress(function(event) {
            if(event.keyCode == 13) {
                this.select();
            }
        });

        var element = document.getElementById('absensi');
        element.classList.add("active");

        $('#nav-menu').empty();
        $('#nav-menu').html('<a href="#">Absensi</a>');
        $('#nav-submenu').empty();
        $('#nav-submenu').html('<span>Kategori Barang</span>');
        $('#nav-submenu').addClass('active');
	});
}) (jQuery);