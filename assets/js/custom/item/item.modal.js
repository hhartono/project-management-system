(function($) {
    $(document).ready(function(e) {
        /*
            Modal Controller for Creating
         */
        $("#da-item-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah Item",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-item-create-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-item-create-form-div").dialog("option", {modal: true}).dialog("close");
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
                    $("#da-item-create-validate-error").html(message).show();
                } else {
                    $("#da-item-create-validate-error").hide();
                }
            }
        });

        $("#da-item-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-item-create-form-div").dialog("option", {modal: true}).dialog("open");
        });

        /*
            Modal Controller for Upload Image
         */
        $("#da-item-upload-form-div").dialog({
            //var id = $(this).data("value");
            autoOpen: false,
            title: "Masukkan Gambar",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-test-image').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-item-upload-form-div").dialog("option", {modal: true}).dialog("close");
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
                    $("#da-item-upload-validate-error").html(message).show();
                } else {
                    $("#da-item-upload-validate-error").hide();
                }
            }
        });

        $(".da-item-upload-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-item-upload-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            $('#id_image').val(id);
        });

        /*
            Modal Controller for Editing
        */
        $("#da-item-edit-form-div").dialog({
            autoOpen: false,
            title: "Ubah Item",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-item-edit-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-item-edit-form-div").dialog("option", {modal: true}).dialog("close");
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
                    $("#da-item-edit-validate-error").html(message).show();
                } else {
                    $("#da-item-edit-validate-error").hide();
                }
            }
        });

        $(".da-item-edit-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-item-edit-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            $.get( "/intivo/get_item_detail/" + id, function(data) {
                $("#item-edit-id").val(id);
                $("#item-edit-group").val(data.blg_group_name);
                $("#item-edit-code").val(data.blg_code);
                $("#item-edit-description").val(data.blg_description);
                $("#item-edit-quantity").val(data.blg_parts_quantity);
                $("#item-edit-price").val(data.blg_price);
            }, "json" );
        });
    });
}) (jQuery);
