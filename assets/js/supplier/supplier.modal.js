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
            var name = $(this).parent("td").parent("tr").find(".name-row").html();

            $("#supplier-edit-id").val(id);
            $("#supplier-edit-name").val(name);
        });
    });
}) (jQuery);