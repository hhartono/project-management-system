(function($) {
    $(document).ready(function(e) {
        $("#da-unit-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah Satuan",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-unit-create-form-val').submit();
                }}]
        }).find('form').validate({
            rules: {
                abbreviation: {
                    required: true
                },
                name: {
                    required: true
                },
                notes: {
                    required: true
                }
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Semua atribut wajib diisi.';
                    $("#da-unit-create-validate-error").html(message).show();
                } else {
                    $("#da-unit-create-validate-error").hide();
                }
            }
        });

        $("#da-unit-create-dialog").bind("click", function(event) {
            $("#da-unit-create-form-div").dialog("option", {modal: true}).dialog("open");
            event.preventDefault();
        });

        $("#da-unit-edit-form-div").dialog({
            autoOpen: false,
            title: "Ubah Satuan",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-unit-edit-form-val').submit();
                }}]
        }).find('form').validate({
            rules: {
                abbreviation: {
                    required: true
                },
                name: {
                    required: true
                },
                notes: {
                    required: true
                }
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Semua atribut wajib diisi.';
                    $("#da-unit-edit-validate-error").html(message).show();
                } else {
                    $("#da-unit-edit-validate-error").hide();
                }
            }
        });

        $(".da-unit-edit-dialog").bind("click", function(event) {
            $("#da-unit-edit-form-div").dialog("option", {modal: true}).dialog("open");

            /*
            $(this).parent("td").parent("tr").find("td").each(function() {
                alert("Hello");
            });
            */

            var abbreviation = $(this).parent("td").parent("tr").find(".abbreviation-row").html();
            var name = $(this).parent("td").parent("tr").find(".name-row").html();
            var notes = $(this).parent("td").parent("tr").find(".notes-row").html();

            $("#unit-edit-abbreviation").val(abbreviation);
            $("#unit-edit-name").val(name);
            $("#unit-edit-notes").val(notes);
            event.preventDefault();
        });
    });
}) (jQuery);