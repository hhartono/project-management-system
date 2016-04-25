(function($) {
    $(document).ready(function(e) {
        /*
            Modal Controller for Creating
         */
        $("#da-warna-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah warna",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-warna-create-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-warna-create-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                warna_initial: {
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
                    $("#da-warna-create-validate-error").html(message).show();
                } else {
                    $("#da-warna-create-validate-error").hide();
                }
            }
        });

        $("#da-warna-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-warna-create-form-div").dialog("option", {modal: true}).dialog("open");
            $("#warna-create-start-date").datepicker({showOtherMonths:true, dateFormat: 'dd-mm-yy'});

            $.get( "/warna/get_all_warna_customer_names", function(data) {
                $( "#warna-create-customer" ).autocomplete({
                    source: data
                });
            }, "json" );
        });

        $("#da-warna-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-warna-create-form-div").dialog("option", {modal: true}).dialog("open");
            $("#warna-create-start-date").datepicker({showOtherMonths:true, dateFormat: 'dd-mm-yy'});

            $.get( "/warna/get_all_warna_company_names", function(data) {
                $( "#warna-create-company" ).autocomplete({
                    source: data
                });
            }, "json" );
        });

        /*
            Modal Controller for Editing
         */
        $("#da-warna-edit-form-div").dialog({
            autoOpen: false,
            title: "Ubah warna",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-warna-edit-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-warna-edit-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                kode_warna: {
                    required: true
                },
                nama_warna: {
                    required: true
                },
                kode_pantone: {
                    required: true
                },
                hexadecimal: {
                    required: true
                }
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Atribut yang diberi tanda wajib diisi.';
                    $("#da-warna-edit-validate-error").html(message).show();
                } else {
                    $("#da-warna-edit-validate-error").hide();
                }
            }
        });

        $(".da-warna-edit-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-warna-edit-form-div").dialog("option", {modal: true}).dialog("open");
            //$("#warna-edit-start-date").datepicker({showOtherMonths:true, dateFormat: 'dd-mm-yy'});

            $.get( "/warna/get_all_warna_customer_names", function(data) {
                $( "#warna-edit-customer" ).autocomplete({
                    source: data
                });
            }, "json" );

            var id = $(this).data("value");
            $.get( "/warna/get_warna_detail/" + id, function(data) {
                $("#warna-edit-id").val(id);
                $("#warna-edit-warna-initial").val(data.warna_initial);
                $("#warna-edit-name").val(data.name);
                $("#warna-edit-customer").val(data.customer_name);
                $("#warna-edit-start-date").val(data.formatted_start_date);
                $("#warna-edit-address").val(data.address);
                $("#warna-edit-notes").val(data.notes);
            }, "json" );
        });
    });
}) (jQuery);