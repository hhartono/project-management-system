(function($) {
	$(document).ready(function(e) {
        var poTable = $("table#da-purchaseorder-createpo-datatable-numberpaging").DataTable({
            bPaginate: false,
            bFilter: false,
            fnCreatedRow: function(nRow, aData, iDataIndex) {
                $(nRow).find("td:eq(0)").attr("name", "item_id");
                $(nRow).find("td:eq(1)").attr("name", "item_name");
                $(nRow).find("td:eq(2)").attr("name", "item_count");
                $(nRow).find("td:eq(3)").attr("name", "item_notes");
            }
            //sPaginationType: "full_numbers"
        });
        var totalItem = 0;

        $.get( "/kirimpress/get_all_bahandasar_names", function(data) {
            $( "#kirimpress-createpress-insert-name" ).autocomplete({
                source: data,
            });
        }, "json" );

        $.get( "/kirimpress/get_all_sisi1", function(data) {
            $( "#kirimpress-createpress-insert-sisi1" ).autocomplete({
                source: data,
            });
        }, "json" );

        $.get( "/kirimpress/get_all_sisi2", function(data) {
            $( "#kirimpress-createpress-insert-sisi2" ).autocomplete({
                source: data,
            });
        }, "json" );

        $.get( "/kirimpress/get_all_po_supplier_names", function(data) {
            $( "#kirimpress-createpress-detail-supplier" ).autocomplete({
                source: data
            });
        }, "json" );

        $.get( "/kirimpress/get_all_po_project_names", function(data) {
            $( "#kirimpress-createpress-detail-project" ).autocomplete({
                source: data
            });
        }, "json" );

        $('#da-purchaseorder-createpress-insert-add').on( 'click', function (event) {
            event.preventDefault();

            // get input value
            var item_name = $('#purchaseorder-createpress-insert-name').val();
            var item_count = $('#purchaseorder-createpress-insert-item-count').val();
            var item_notes = $('#purchaseorder-createpress-insert-notes').val();

            // prepare error message
            $("#da-purchaseorder-createpress-insert-error").hide();

            // add error checking when input is blank
            if(item_name && item_count){
                var table_array = [];
                table_array[0] = 0;
                table_array[1] = item_name;
                table_array[2] = item_count;
                table_array[3] = item_notes;

                // clear all the text fields
                $('#purchaseorder-createpo-insert-name').val('');
                $('#purchaseorder-createpo-insert-item-count').val('');
                $('#purchaseorder-createpo-insert-item-count-label').text('');
                $('#purchaseorder-createpo-insert-notes').val('');

                get_item_id_by_item_name(poTable, table_array);
            }else{
                var message = "Nama dan jumlah barang wajib diisi.";
                $("#da-purchaseorder-createpo-insert-error").html(message).show();
            }
        });

        $('#da-purchaseorder-createpo-insert-clear').on( 'click', function (event) {
            event.preventDefault();

            // hide error message
            $("#da-purchaseorder-createpo-insert-error").hide();

            // clear all the text fields
            $('#purchaseorder-createpo-insert-name').val('');
            $('#purchaseorder-createpo-insert-item-count').val('');
            $('#purchaseorder-createpo-insert-notes').val('');
        });

        $('#da-purchaseorder-createpo-submit').on('click', function(event) {
            event.preventDefault();

            // get all the value from preview table
            var tableValue = [];
            var walk = 0;

            // get input detail
            var po_supplier = $('#purchaseorder-createpo-detail-supplier').val();
            var po_project = $('#project_id').val();
            var po_subproject = $('#subproject_id').val();
            $("#da-purchaseorder-createpo-detail-error").hide();
            $("#da-purchaseorder-createpo-table-error").hide();

            if(po_supplier && po_project && po_subproject){
                if(totalItem > 0){
                    $('table#da-purchaseorder-createpo-datatable-numberpaging tr').each(function(outer_index) {
                        if(outer_index > 0){
                            tableValue[walk] = {};
                            $.each(this.cells, function(index, element){
                                if($(element).attr("name")){
                                    var column_name = $(element).attr("name");
                                    var column_value = $(element).text();
                                    tableValue[walk][column_name] = column_value;
                                }
                            });
                            walk++;
                        }
                    });

                    // create JSON
                    var poItemValues = JSON.stringify(tableValue);
                    $('#da-purchaseorder-createpo-submit-item-values').val(poItemValues);

                    // submit form
                    $('form#da-purchaseorder-createpo-detail-form-val').submit();
                }else{
                    var message = "Tidak ada barang untuk PO.";
                    $("#da-purchaseorder-createpo-table-error").html(message).show();
                }
            }else{
                var message = "Supplier dan project wajib diisi.";
                $("#da-purchaseorder-createpo-detail-error").html(message).show();
            }
        });

        /*
         Common Function
         */
        function get_unit_by_item_name(item_name, target_textplace){
            var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
            var item_name_encoded = encodeURIComponent(Base64.encode(item_name));
            console.log(item_name_encoded);
            $.get( "/purchaseorder/get_unit_by_item_name/" + item_name_encoded, function(data) {
                if(data != null && data.name != null){
                    $(target_textplace).text(data.name);
                }else{
                    $(target_textplace).text('');
                }
            }, "json" );
        }

        function get_item_id_by_item_name(poTable, table_array){
            var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
            var item_name_encoded = encodeURIComponent(Base64.encode(table_array[1]));
            console.log(item_name_encoded);
            $.get( "/purchaseorder/get_item_detail_by_item_name/" + item_name_encoded, function(data) {
                if(data != null && data.id != null){
                    $("#da-purchaseorder-createpo-table-error").hide();

                    // update table
                    totalItem++;
                    table_array[0] = data.id;
                    poTable.row.add(table_array).draw();
                }else{
                    // error message
                    var message = "Barang tidak ditemukan dalam sistem.";
                    $("#da-purchaseorder-createpo-insert-error").html(message).show();
                }
            }, "json" );
        }
	});
}) (jQuery);