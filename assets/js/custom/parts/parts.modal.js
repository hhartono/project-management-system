(function($) {
    $(document).ready(function(e) {
        /*
            Modal Controller for Creating
         */
        $("#da-parts-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah Parts",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-parts-create-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-parts-create-form-div").dialog("option", {modal: true}).dialog("close");
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
                    $("#da-parts-create-validate-error").html(message).show();
                } else {
                    $("#da-parts-create-validate-error").hide();
                }
            }
        });

        $("#da-parts-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-parts-create-form-div").dialog("option", {modal: true}).dialog("open");

            var name = $(this).data("value");
            $("#parts-create-group").val(name);
        });

        /*
            Modal Controller for Upload Image
         */
        $("#da-parts-upload-form-div").dialog({
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
                    $("#da-parts-upload-form-div").dialog("option", {modal: true}).dialog("close");
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
                    $("#da-parts-upload-validate-error").html(message).show();
                } else {
                    $("#da-parts-upload-validate-error").hide();
                }
            }
        });

        $(".da-parts-upload-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-parts-upload-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            var group = $(this).data("group");
            $('#id_image').val(id);
            $('#group_image').val(group);
        });

        /*
            Modal Controller for Editing
        */
        $("#da-parts-edit-form-div").dialog({
            autoOpen: false,
            title: "Ubah Parts",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-parts-edit-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-parts-edit-form-div").dialog("option", {modal: true}).dialog("close");
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
                    $("#da-parts-edit-validate-error").html(message).show();
                } else {
                    $("#da-parts-edit-validate-error").hide();
                }
            }
        });

        $(".da-parts-edit-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-parts-edit-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            $.get( "/parts/get_parts_detail/" + id, function(data) {
                $("#parts-edit-id").val(id);
                $("#parts-edit-group").val(data.group_name);
                $("#parts-edit-image").val(data.part_img_path);
                $("#parts-edit-code").val(data.code);
                $("#parts-edit-description").val(data.description);
                $("#parts-edit-quantity").val(data.quantity);
            }, "json" );
        });
    });
}) (jQuery);
