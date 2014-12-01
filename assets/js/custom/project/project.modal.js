(function($) {
    $(document).ready(function(e) {
        /*
            Modal Controller for Creating
         */
        $("#da-unit-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah Satuan",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-unit-create-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-unit-create-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                abbreviation: {
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
                    $("#da-unit-create-validate-error").html(message).show();
                } else {
                    $("#da-unit-create-validate-error").hide();
                }
            }
        });

        $("#da-unit-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-unit-create-form-div").dialog("option", {modal: true}).dialog("open");
        });

        /*
            Modal Controller for Editing
         */
        $("#da-unit-edit-form-div").dialog({
            autoOpen: false,
            title: "Ubah Satuan",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-unit-edit-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-unit-edit-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                abbreviation: {
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
                    $("#da-unit-edit-validate-error").html(message).show();
                } else {
                    $("#da-unit-edit-validate-error").hide();
                }
            }
        });

        $(".da-unit-edit-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-unit-edit-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            $.get( "/unit/get_unit_detail/" + id, function(data) {
                $("#unit-edit-id").val(id);
                $("#unit-edit-abbreviation").val(data.abbreviation);
                $("#unit-edit-name").val(data.name);
                $("#unit-edit-notes").val(data.notes);
            }, "json" );
        });
    });
}) (jQuery);