(function($) {
    $(document).ready(function(e) {
        /*
            Modal Controller for Creating
         */
        $("#da-category-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah Kategori",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-category-create-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-category-create-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                prefix: {
                    required: true
                },
                name: {
                    required: true
                }
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Atribut yang diberi tanda wajib diisi.';
                    $("#da-category-create-validate-error").html(message).show();
                } else {
                    $("#da-category-create-validate-error").hide();
                }
            }
        });

        $("#da-category-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-category-create-form-div").dialog("option", {modal: true}).dialog("open");
        });

        /*
            Modal Controller for Editing
         */
        $("#da-category-edit-form-div").dialog({
            autoOpen: false,
            title: "Ubah Kategori",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-category-edit-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-category-edit-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                prefix: {
                    required: true
                },
                name: {
                    required: true
                }
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Atribut yang diberi tanda wajib diisi.';
                    $("#da-category-edit-validate-error").html(message).show();
                } else {
                    $("#da-category-edit-validate-error").hide();
                }
            }
        });

        $(".da-category-edit-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-category-edit-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            $.get( "/category/get_category_detail/" + id, function(data) {
                $("#category-edit-id").val(id);
                $("#category-edit-prefix").val(data.prefix);
                $("#category-edit-name").val(data.name);
            }, "json" );
        });
    });
}) (jQuery);