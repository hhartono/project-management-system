(function($) {
    $(document).ready(function(e) {
        /*
            Modal Controller for Creating
         */
        $("#da-customer-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah Customer",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-customer-create-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-customer-create-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                name: {
                    required: true
                }
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Atribut yang diberi tanda wajib diisi.';
                    $("#da-customer-create-validate-error").html(message).show();
                } else {
                    $("#da-customer-create-validate-error").hide();
                }
            }
        });

        $("#da-customer-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-customer-create-form-div").dialog("option", {modal: true}).dialog("open");
        });

        /*
            Modal Controller for Editing
        */
        $("#da-customer-edit-form-div").dialog({
            autoOpen: false,
            title: "Ubah Customer",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-customer-edit-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-customer-edit-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                name: {
                    required: true
                }
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Atribut yang diberi tanda wajib diisi.';
                    $("#da-customer-edit-validate-error").html(message).show();
                } else {
                    $("#da-customer-edit-validate-error").hide();
                }
            }
        });

        $(".da-customer-edit-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-customer-edit-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            $.get( "/customer/get_customer_detail/" + id, function(data) {
                $("#customer-edit-id").val(id);
                $("#customer-edit-name").val(data.name);
                $("#customer-edit-address").val(data.address);
                $("#customer-edit-city").val(data.city);
                $("#customer-edit-postal-code").val(data.postal_code);
                $("#customer-edit-province").val(data.province);
                $("#customer-edit-phone-1").val(data.phone_number_1);
                $("#customer-edit-phone-2").val(data.phone_number_2);
                $("#customer-edit-phone-3").val(data.phone_number_3);
                $("#customer-edit-fax").val(data.fax);
                $("#customer-edit-email").val(data.email);
            }, "json" );
        });

        /*
         Modal Controller for Viewing
         */
        $("#da-customer-view-form-div").dialog({
            autoOpen: false,
            title: "Lihat Customer",
            modal: true,
            width: "640",
            buttons: [{
                text: "Keluar",
                click: function() {
                    $("#da-customer-view-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        });

        $(".da-customer-view-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-customer-view-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            $.get( "/customer/get_customer_detail/" + id, function(data) {
                $("#customer-view-name").val(data.name);
                $("#customer-view-address").val(data.address);
                $("#customer-view-city").val(data.city);
                $("#customer-view-postal-code").val(data.postal_code);
                $("#customer-view-province").val(data.province);
                $("#customer-view-phone-1").val(data.phone_number_1);
                $("#customer-view-phone-2").val(data.phone_number_2);
                $("#customer-view-phone-3").val(data.phone_number_3);
                $("#customer-view-fax").val(data.fax);
                $("#customer-view-email").val(data.email);
            }, "json" );
        });
    });
}) (jQuery);