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
                unit_id: {
                    required: true
                },
                category_id: {
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
                $('#item-create-unit')
                    .append($("<option></option>")
                        .attr("value", "")
                        .text("-- Silahkan Pilih --"));

                $.each(data, function(key, value){
                    $('#item-create-unit')
                        .append($("<option></option>")
                        .attr("value", value.id)
                        .text(value.name));
                });
            }, "json" );

            /* get the option for supplier unit */
            $('#item-create-supplier-unit')
                .find('option')
                .remove()
                .end();

            $.get( "/item/get_all_item_units", function(data) {
                $('#item-create-supplier-unit')
                    .append($("<option></option>")
                        .attr("value", "")
                        .text("-- Silahkan Pilih --"));

                $.each(data, function(key, value){
                    $('#item-create-supplier-unit')
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
                $('#item-create-category')
                    .append($("<option></option>")
                        .attr("value", "")
                        .text("-- Silahkan Pilih --"));

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
                    $("#item-edit-category").prop("disabled", false);
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
                unit_id: {
                    required: true
                },
                category_id: {
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

            // fill unit with all possible values
            var id = $(this).data("value");
            prepareEditUnit(id);
            prepareEditStockUnit(id);
        });

        function prepareEditUnit(id) {
            /* get the option for unit */
            $('#item-edit-unit')
                .find('option')
                .remove()
                .end();

            $.get( "/item/get_all_item_units", function(data) {
                $('#item-edit-unit')
                    .append($("<option></option>")
                        .attr("value", "")
                        .text("-- Silahkan Pilih --"));

                $.each(data, function(key, value){
                    $('#item-edit-unit')
                        .append($("<option></option>")
                            .attr("value", value.id)
                            .text(value.name));
                });

                // fill category with all possible values
                prepareEditCategory(id);
            }, "json" );
        }

        function prepareEditStockUnit(id) {
            /* get the option for unit */
            $('#item-edit-stock-unit')
                .find('option')
                .remove()
                .end();

            $.get( "/item/get_all_item_stock_units", function(data) {
                $('#item-edit-unit')
                    .append($("<option></option>")
                        .attr("value", "")
                        .text("-- Silahkan Pilih --"));

                $.each(data, function(key, value){
                    $('#item-edit-stock-unit')
                        .append($("<option></option>")
                            .attr("value", value.id)
                            .text(value.name));
                });

                // fill category with all possible values
                prepareEditCategory(id);
            }, "json" );
        }

        function prepareEditCategory(id) {
            /* get the option for category */
            $('#item-edit-category')
                .find('option')
                .remove()
                .end();

            $.get( "/item/get_all_item_categories", function(data) {
                $('#item-edit-category')
                    .append($("<option></option>")
                        .attr("value", "")
                        .text("-- Silahkan Pilih --"));

                $.each(data, function(key, value){
                    $('#item-edit-category')
                        .append($("<option></option>")
                            .attr("value", value.id)
                            .text(value.name));
                });

                // fill the known value
                fillEdit(id);
            }, "json" );
        }

        function fillEdit(id){
            $.get( "/item/get_item_detail/" + id, function(data) {
                $("#item-edit-id").val(id);
                $("#item-edit-unit").val(data.unit_id);
                $("#item-edit-stock-unit").val(data.stock_unit_id);
                $("#item-edit-category").val(data.category_id);
                $("#item-edit-name").val(data.name);
                $("#item-edit-notes").val(data.notes);
            }, "json" );
        }
    });
}) (jQuery);