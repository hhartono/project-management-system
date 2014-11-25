(function($) {
    $(document).ready(function(e) {
        /*
            Modal Controller for Creating
         */
        $("#da-item-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah Barang",
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
                },
                unit: {
                    required: true
                },
                category: {
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

            /* get the option for unit */
            $('#item-create-unit')
                .find('option')
                .remove()
                .end();

            $.get( "/item/get_all_item_units", function(data) {
                $.each(data, function(key, value){
                    $('#item-create-unit')
                        .append($("<option></option>")
                        .attr("value", value.id)
                        .text(value.name));
                });
            }, "json" );

            /* get the option for category */
            $('#item-create-category')
                .find('option')
                .remove()
                .end();

            $.get( "/item/get_all_item_categories", function(data) {
                $.each(data, function(key, value){
                    $('#item-create-category')
                        .append($("<option></option>")
                            .attr("value", value.id)
                            .text(value.name));
                });
            }, "json" );
        });

        /*
            Modal Controller for Editing
         */
        $("#da-item-edit-form-div").dialog({
            autoOpen: false,
            title: "Ubah Barang",
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
                },
                unit: {
                    required: true
                },
                category: {
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

            /* get the option for unit */
            $('#item-edit-unit')
                .find('option')
                .remove()
                .end();

            $.get( "/item/get_all_item_units", function(data) {
                $.each(data, function(key, value){
                    $('#item-edit-unit')
                        .append($("<option></option>")
                        .attr("value", value.id)
                        .text(value.name));
                });
            }, "json" );

            var id = $(this).data("value");
            $.get( "/item/get_item_detail/" + id, function(data) {
                $("#item-edit-id").val(id);
                $("#item-edit-unit").val(data.unit_id);
                $("#item-edit-name").val(data.name);
                $("#item-edit-notes").val(data.notes);
            }, "json" );

            /* get the option for category */
            $('#item-edit-category')
                .find('option')
                .remove()
                .end();

            $.get( "/item/get_all_item_categories", function(data) {
                $.each(data, function(key, value){
                    $('#item-edit-category')
                        .append($("<option></option>")
                            .attr("value", value.id)
                            .text(value.name));
                });
            }, "json" );
        });
    });
}) (jQuery);