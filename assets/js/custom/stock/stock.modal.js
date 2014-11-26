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
                        var item_name = $("#stock-create-name").val();
                        get_unit_by_item_name(item_name, '#stock-create-item-count-label');
                    }
                });
            }, "json" );

            $.get( "/stock/get_all_stock_supplier_names", function(data) {
                $( "#stock-create-supplier" ).autocomplete({
                    source: data
                });
            }, "json" );
        });

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
                    $("#da-stock-edit-validate-error").html(message).show();
                } else {
                    $("#da-stock-edit-validate-error").hide();
                }
            }
        });

        $(".da-stock-edit-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-stock-edit-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            $.get( "/stock/get_stock_detail/" + id, function(data) {
                $("#stock-edit-id").val(id);
                $("#stock-edit-name").val(data.name);
                $("#stock-edit-item-count").val(data.item_count);
                $("#stock-edit-supplier").val(data.supplier);
                $("#stock-edit-subproject").val(data.subproject_id);
                $("#stock-edit-po-detail-id").val(data.po_detail_id);
                $("#stock-edit-item-price").val(data.item_price);

                get_unit_by_item_name(data.name, '#stock-edit-item-count-label');
            }, "json" );

            $.get( "/stock/get_all_stock_supplier_names", function(data) {
                $( "#stock-edit-supplier" ).autocomplete({
                    source: data
                });
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
                $("#stock-view-item-stock-code").val(data.item_stock_code);
                $("#stock-view-name").val(data.name);
                $("#stock-view-item-count").val(data.item_count);
                $("#stock-view-unit").val(data.unit);
                $("#stock-view-supplier").val(data.supplier);
                $("#stock-view-subproject").val(data.subproject_id);
                $("#stock-view-po-detail-id").val(data.po_detail_id);
                $("#stock-view-item-price").val(data.item_price);

                var item_name = data.name;
                get_unit_by_item_name(item_name, '#stock-view-item-count-label');
            }, "json" );
        });

        /*
         Common Function
         */
        function get_unit_by_item_name(item_name, target_textplace){
            var item_name_encoded = encodeURIComponent(item_name);

            $.get( "/stock/get_unit_by_item_name/" + item_name_encoded, function(data) {
                if(data != null && data.name != null){
                    $(target_textplace).text(data.name);
                }else{
                    $(target_textplace).text('');
                }
            }, "json" );
        }
    });
}) (jQuery);