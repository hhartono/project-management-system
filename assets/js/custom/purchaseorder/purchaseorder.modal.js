(function($) {
    $(document).ready(function(e) {
    	$("#da-project-create-form-div").dialog({
            autoOpen: false,
            title: "Pembayaran",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-project-create-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-project-create-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                project_initial: {
                    required: true
                },
                name: {
                    required: true
                },
                customer_name: {
                    required: true
                },
                start_date: {
                    required: true
                }
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Atribut yang diberi tanda wajib diisi.';
                    $("#da-project-create-validate-error").html(message).show();
                } else {
                    $("#da-project-create-validate-error").hide();
                }
            }
        });

        $("#bayar").bind("click", function(event) {
            event.preventDefault();
            $("#da-project-create-form-div").dialog("option", {modal: true}).dialog("open");
            $("#project-create-start-date").datepicker({showOtherMonths:true, dateFormat: 'dd-mm-yy'});

            $.get( "/project/get_all_project_customer_names", function(data) {
                $( "#project-create-customer" ).autocomplete({
                    source: data
                });
            }, "json" );
        });

        $("#bayar").bind("click", function(event) {
            event.preventDefault();
            $("#da-project-create-form-div").dialog("option", {modal: true}).dialog("open");
            $("#project-create-start-date").datepicker({showOtherMonths:true, dateFormat: 'dd-mm-yy'});

            $.get( "/project/get_all_project_company_names", function(data) {
                $( "#project-create-company" ).autocomplete({
                    source: data
                });
            }, "json" );
        });

        /*
            Modal Controller for Creating Cetak
         */
        $("#da-cetak-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah Attn",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-cetak-create-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $(this).find("form#da-cetak-create-form-val").submit();
                    location.reload();
                }}]
        }).find('form').validate({
            rules: {
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Atribut yang diberi tanda wajib diisi.';
                    $("#da-project-create-validate-error").html(message).show();
                } else {
                    $("#da-project-create-validate-error").hide();
                }
            }
        });

        $("#da-cetak-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-cetak-create-form-div").dialog("option", {modal: true}).dialog("open");
            $("#cetak-create-start-date").datepicker({showOtherMonths:true, dateFormat: 'dd-mm-yy'});

        });
    });
}) (jQuery);