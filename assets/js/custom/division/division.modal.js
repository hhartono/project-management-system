(function($) {
    $(document).ready(function(e) {
        /*
            Modal Controller for Creating
         */
        $("#da-division-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah Divisi",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-division-create-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-division-create-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                division_code: {
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
                    $("#da-division-create-validate-error").html(message).show();
                } else {
                    $("#da-division-create-validate-error").hide();
                }
            }
        });

        $("#da-division-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-division-create-form-div").dialog("option", {modal: true}).dialog("open");
        });

        /*
            Modal Controller for Editing
         */
        $("#da-division-edit-form-div").dialog({
            autoOpen: false,
            title: "Ubah Divisi",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-division-edit-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-division-edit-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                division_code: {
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
                    $("#da-division-edit-validate-error").html(message).show();
                } else {
                    $("#da-division-edit-validate-error").hide();
                }
            }
        });

        $(".da-division-edit-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-division-edit-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            $.get( "/division/get_division_detail/" + id, function(data) {
                $("#division-edit-id").val(id);
                $("#division-edit-code").val(data.division_code);
                $("#division-edit-name").val(data.name);
                $("#division-edit-notes").val(data.notes);
            }, "json" );
        });
    });
}) (jQuery);