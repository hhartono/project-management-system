(function($) {
    $(document).ready(function(e) {
        var returnsupplierTable = $("table#da-returnsupplier-datatable-numberpaging").DataTable({
            bPaginate: false,
            bFilter: false,
            bSort: false,
            fnCreatedRow: function(nRow, aData, iDataIndex) {
                $(nRow).find("td:eq(0)").attr("name", "item_stock_code");
                $(nRow).find("td:eq(1)").attr("name", "item_name");
                $(nRow).find("td:eq(2)").attr("name", "item_stock");
                $(nRow).find("td:eq(3)").attr("name", "item_usage").append('<input name="item_usage_input" type="text" class="span12" value="1">');
                $(nRow).find("td:eq(4)").attr("name", "supplier");
                $(nRow).find("td:eq(5)").attr("name", "stock_id");

            }
            //sPaginationType: "full_numbers"
        });
        var totalItem = 0;

        // set focus to search box
        $('#returnsupplier-insert-code').focus();

        $('#da-returnsupplier-insert-add').on( 'click', function (event) {
            event.preventDefault();
            add_item_to_preview_table(returnsupplierTable);
        });

        $("#returnsupplier-insert-code").keypress(function(event) {
            if(event.keyCode == 13) {
                event.preventDefault();
                add_item_to_preview_table(returnsupplierTable);
            }
        });

        $.get( "/returnsupplier/get_all_returnsupplier_supplier_names", function(data) {
            $( "#returnsupplier-create-supplier" ).autocomplete({
                source: data
            });
        }, "json" );

        $('#da-returnsupplier-submit').on('click', function(event) {
            event.preventDefault();

            // get all the value from preview table
            var tableValue = [];
            var walk = 0;
            var overflowStatus = false;

            // get input detail
            var returnsupplier_supplier = $('#returnsupplier-create-supplier').val();
            
            $("#da-returnsupplier-detail-error").hide();
            $("#da-returnsupplier-table-error").hide();

            // prepare check stock status
            var stock_count_per_item = {};
            var usage_count_per_item = {};

                if(totalItem > 0){
                    $('table#da-returnsupplier-datatable-numberpaging tr').each(function(outer_index) {
                        var stock_count = 0;
                        var usage_count = 0;
                        var item_stock_code = '';

                        if(outer_index > 0){
                            tableValue[walk] = {};
                            $.each(this.cells, function(index, element){
                                if($(element).attr("name")){
                                    var column_name = $(element).attr("name");
                                    var column_value = $(element).text();

                                    if($(element).children('input').length > 0 && column_name == 'item_usage'){
                                        column_value = $(element).children("input").val();
                                    }
                                    tableValue[walk][column_name] = column_value;

                                    // prepare value to check overflow
                                    if(column_name == 'item_stock_code'){
                                        item_stock_code = column_value;
                                    }

                                    // prepare value to check overflow
                                    if(column_name == 'item_stock'){
                                        stock_count = parseInt(column_value);
                                    }

                                    // prepare value to check overflow
                                    if(column_name == 'item_usage'){
                                        usage_count = parseInt(column_value);
                                    }
                                }
                            });

                            // aggregate to find out stock status
                            stock_count_per_item[item_stock_code] = stock_count;
                            if(usage_count_per_item[item_stock_code]){
                                usage_count_per_item[item_stock_code] += usage_count;
                            }else{
                                usage_count_per_item[item_stock_code] = usage_count;
                            }

                            // check if all item have enough stock
                            if(usage_count_per_item[item_stock_code] > stock_count_per_item[item_stock_code]){
                                overflowStatus = true;
                            }
                            
                            walk++;
                        }
                    });

                    if(overflowStatus == false){
                        // create JSON
                        var returnsupplierItemValues = JSON.stringify(tableValue);
                        $('#da-returnsupplier-submit-item-values').val(returnsupplierItemValues);

                        // submit form
                        $('form#da-returnsupplier-detail-form-val').submit();
                    }else{
                        var message = "Return melebihi stok barang.";
                        $("#da-returnsupplier-table-error").html(message).show();
                    }
                }else{
                    var message = "Tidak ada barang untuk di return.";
                    $("#da-returnsupplier-table-error").html(message).show();
                }
        });
        
        var supplierCondition = '';
        /*
         Common Function
         */
        function add_item_to_preview_table(returnsupplierTable){
            
            // get input value
            var item_code = $('#returnsupplier-insert-code').val();

            // prepare error message
            $("#da-returnsupplier-insert-error").hide();
            $('#returnsupplier-insert-code').focus();

            // add error checking when input is blank
            if(item_code){
                // clear all the text fields
                $('#returnsupplier-insert-code').val('');
                var item_code_encoded = encodeURIComponent(item_code);

                $.get( "/returnsupplier/get_stock_detail_by_item_stock_code/" + item_code_encoded, function(data) {
                    if(data != null && data.id != null){
                        $("#da-returnsupplier-table-error").hide();

                        // update table
                        totalItem++;
                        var table_array = [];
                        table_array[0] = data.item_stock_code;
                        table_array[1] = data.item_name;
                        table_array[2] = data.item_count;
                        table_array[3] = '';
                        table_array[4] = data.supplier;
                        table_array[5] = data.id;

                        if(supplierCondition == ""){
                            supplierCondition = data.supplier;
                        }
                        if(supplierCondition == data.supplier){
                            returnsupplierTable.row.add(table_array).draw();
                        }else{
                            var message = "Supplier tidak sama, masukkan barang yang supplier-nya sama";
                            $("#da-returnsupplier-insert-error").html(message).show();
                        }
                    }else{
                        // error message
                        var message = "Kode barang tidak ditemukan dalam sistem.";
                        $("#da-returnsupplier-insert-error").html(message).show();
                    }
                }, "json" );
            }else{
                var message = "Kode barang wajib diisi.";
                $("#da-returnsupplier-insert-error").html(message).show();
            }
        }
    });
}) (jQuery);