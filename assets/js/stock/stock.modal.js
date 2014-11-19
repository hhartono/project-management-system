(function($) {
    $(document).ready(function(e) {
        /*
            Modal Controller for Creating
         */
        $("#da-stock-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah Stok",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-stock-create-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-stock-create-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                name: {
                    required: true
                },
                item_count: {
                    required: true
                },
                supplier: {
                    required: true
                }
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Atribut yang diberi tanda wajib diisi.';
                    $("#da-stock-create-validate-error").html(message).show();
                } else {
                    $("#da-stock-create-validate-error").hide();
                }
            }
        });

        $("#da-stock-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-stock-create-form-div").dialog("option", {modal: true}).dialog("open");

            $.get( "/stock/get_all_stock_item_names", function(data) {
                $( "#stock-create-name" ).autocomplete({
                    source: data,
                    change: function() {
                        get_unit_by_item_name();
                    }
                });
            }, "json" );

            $.get( "/stock/get_all_stock_supplier_names", function(data) {
                $( "#stock-create-supplier" ).autocomplete({
                    source: data
                });
            }, "json" );

            /* get the option for unit */
            /*
            $('#stock-create-unit')
                .find('option')
                .remove()
                .end();

            $.get( "/stock/get_all_stock_units", function(data) {
                $.each(data, function(key, value){
                    $('#stock-create-unit')
                        .append($("<option></option>")
                        .attr("value", value.id)
                        .text(value.name));
                });
            }, "json" );
            */
        });

        function get_unit_by_item_name(){
            var item_name = $("#stock-create-name").val();
            var item_name_encoded = encodeURIComponent(item_name);

            $.get( "/stock/get_unit_by_item_name/" + item_name_encoded, function(data) {
                if(data != null && data.name != null){
                    $('#stock-create-item-count-label').text(data.name);
                }else{
                    $('#stock-create-item-count-label').text('');
                }
            }, "json" );
        }

        /*
        $("#stock-create-name").select(function() {
            alert('detected selected!');
        });

        $("#stock-create-name").change(function() {
            alert('detected!');
            var item_name = $("#stock-create-name").val();

            $.get( "/stock/get_unit_by_item_name/" + item_name, function(data) {
                if(data != null && data.name != null){
                    $('#stock-create-item-count-label').text(data.name);
                }else{
                    $('#stock-create-item-count-label').text('');
                }
            }, "json" );
        });
        */

        /*
            Modal Controller for Editing
         */
        $("#da-stock-edit-form-div").dialog({
            autoOpen: false,
            title: "Ubah Stok",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-stock-edit-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-stock-edit-form-div").dialog("option", {modal: true}).dialog("close");
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
                    $("#da-stock-edit-validate-error").html(message).show();
                } else {
                    $("#da-stock-edit-validate-error").hide();
                }
            }
        });

        $(".da-stock-edit-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-stock-edit-form-div").dialog("option", {modal: true}).dialog("open");

            /* get the option for unit */
            /*
            $('#stock-edit-unit')
                .find('option')
                .remove()
                .end();

            $.get( "/stock/get_all_stock_units", function(data) {
                $.each(data, function(key, value){
                    $('#stock-edit-unit')
                        .append($("<option></option>")
                        .attr("value", value.id)
                        .text(value.name));
                });
            }, "json" );
            */

            var id = $(this).data("value");
            $.get( "/stock/get_stock_detail/" + id, function(data) {
                $("#stock-edit-id").val(id);
                $("#stock-edit-name").val(data.name);
            }, "json" );
        });

        /*
         Modal Controller for Viewing
         */
        $("#da-stock-view-form-div").dialog({
            autoOpen: false,
            title: "Lihat Stok",
            modal: true,
            width: "640",
            buttons: [{
                text: "Keluar",
                click: function() {
                    $("#da-stock-view-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        });

        $(".da-stock-view-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-stock-view-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            $.get( "/stock/get_stock_detail/" + id, function(data) {
                $("#stock-view-name").val(data.name);
                $("#stock-view-unit").val(data.unit);
                $("#stock-view-supplier").val(data.supplier);
            }, "json" );
        });
    });
}) (jQuery);