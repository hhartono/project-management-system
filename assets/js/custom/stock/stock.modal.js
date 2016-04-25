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
                },
                project: {
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

            $.get( "/stock/get_all_stock_project_names", function(data) {
                $( "#stock-create-project" ).autocomplete({
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
                min_stock: {
                    required: true
                },
                supplier: {
                    required: true
                },
                project: {
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
                $("#stock-edit-minimal").val(data.min_stock);
                $("#stock-edit-supplier").val(data.supplier);
                $("#stock-edit-project").val(data.project);
                $("#stock-edit-po-detail-id").val(data.po_detail_id);
                $("#stock-edit-item-price").val(data.item_price);

                get_unit_by_item_name(data.name, '#stock-edit-item-count-label');
            }, "json" );

            $.get( "/stock/get_all_stock_supplier_names", function(data) {
                $( "#stock-edit-supplier" ).autocomplete({
                    source: data
                });
            }, "json" );

            $.get( "/stock/get_all_stock_project_names", function(data) {
                $( "#stock-edit-project" ).autocomplete({
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
                $("#stock-view-project").val(data.project);
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
            var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
            var item_name_encoded = encodeURIComponent(Base64.encode(item_name));
            
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