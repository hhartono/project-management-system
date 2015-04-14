(function($) {
    $(document).ready(function(e) {
        /*
            Modal Controller for Creating
         */
        $("#da-supplier-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah Supplier",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-supplier-create-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-supplier-create-form-div").dialog("option", {modal: true}).dialog("close");
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
                    $("#da-supplier-create-validate-error").html(message).show();
                } else {
                    $("#da-supplier-create-validate-error").hide();
                }
            }
        });

        $("#da-supplier-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-supplier-create-form-div").dialog("option", {modal: true}).dialog("open");
        });

        /*
            Modal Controller for Editing
         */
        $("#da-supplier-edit-form-div").dialog({
            autoOpen: false,
            title: "Ubah Supplier",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-supplier-edit-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-supplier-edit-form-div").dialog("option", {modal: true}).dialog("close");
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
                    $("#da-supplier-edit-validate-error").html(message).show();
                } else {
                    $("#da-supplier-edit-validate-error").hide();
                }
            }
        });

        $(".da-supplier-edit-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-supplier-edit-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            $.get( "/supplier/get_supplier_detail/" + id, function(data) {
                $("#supplier-edit-id").val(id);
                $("#supplier-edit-name").val(data.name);
                $("#supplier-edit-address").val(data.address);
                $("#supplier-edit-city").val(data.city);
                $("#supplier-edit-postal-code").val(data.postal_code);
                $("#supplier-edit-province").val(data.province);
                $("#supplier-edit-phone-1").val(data.phone_number_1);
                $("#supplier-edit-phone-2").val(data.phone_number_2);
                $("#supplier-edit-phone-3").val(data.phone_number_3);
                $("#supplier-edit-fax").val(data.fax);
                $("#supplier-edit-email").val(data.email);
                $("#supplier-edit-website").val(data.website);
            }, "json" );
        });

        /*
         Modal Controller for Viewing
         */
        $("#da-supplier-view-form-div").dialog({
            autoOpen: false,
            title: "Lihat Supplier",
            modal: true,
            width: "640",
            buttons: [{
                text: "Keluar",
                click: function() {
                    $("#da-supplier-view-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        });

        $(".da-supplier-view-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-supplier-view-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            $.get( "/supplier/get_supplier_detail/" + id, function(data) {
                $("#supplier-view-name").val(data.name);
                $("#supplier-view-address").val(data.address);
                $("#supplier-view-city").val(data.city);
                $("#supplier-view-postal-code").val(data.postal_code);
                $("#supplier-view-province").val(data.province);
                $("#supplier-view-phone-1").val(data.phone_number_1);
                $("#supplier-view-phone-2").val(data.phone_number_2);
                $("#supplier-view-phone-3").val(data.phone_number_3);
                $("#supplier-view-fax").val(data.fax);
                $("#supplier-view-email").val(data.email);
                $("#supplier-view-website").val(data.website);
            }, "json" );
        });
    });
}) (jQuery);