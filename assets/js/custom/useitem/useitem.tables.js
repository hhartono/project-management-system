(function($) {
	$(document).ready(function(e) {
        var poTable = $("table#da-useitem-datatable-numberpaging").DataTable({
            bPaginate: false,
            bFilter: false,
            bSort: false,
            fnCreatedRow: function(nRow, aData, iDataIndex) {
                $(nRow).find("td:eq(0)").attr("name", "item_stock_code");
                $(nRow).find("td:eq(1)").attr("name", "item_name");
                $(nRow).find("td:eq(2)").attr("name", "item_stock");
                $(nRow).find("td:eq(3)").attr("name", "item_usage").append('<input name="item_usage_input" type="text" class="span3" value="1">');
                $(nRow).find("td:eq(4)").attr("name", "item_unit");

            }
            //sPaginationType: "full_numbers"
        });
        var totalItem = 0;

        // set focus to search box
        $('#useitem-insert-code').focus();

        $('#da-useitem-insert-add').on( 'click', function (event) {
            event.preventDefault();
            add_item_to_preview_table(poTable);
        });

        $("#useitem-insert-code").keypress(function(event) {
            if(event.keyCode == 13) {
                event.preventDefault();
                add_item_to_preview_table(poTable);
            }
        });

        $('#da-useitem-submit').on('click', function(event) {
            event.preventDefault();

            // get all the value from preview table
            var tableValue = [];
            var walk = 0;
            var overflowStatus = false;

            // get input detail
            var po_project = $('#useitem-detail-project').val();
            var po_subproject = $('#useitem-detail-subproject').val();
            $("#da-useitem-detail-error").hide();
            $("#da-useitem-table-error").hide();

            // prepare check stock status
            var stock_count_per_item = {};
            var usage_count_per_item = {};

            if(po_project && po_subproject){
                if(totalItem > 0){
                    $('table#da-useitem-datatable-numberpaging tr').each(function(outer_index) {
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
                        var poItemValues = JSON.stringify(tableValue);
                        $('#da-useitem-submit-item-values').val(poItemValues);

                        // submit form
                        $('form#da-useitem-detail-form-val').submit();
                    }else{
                        var message = "Pemakaian melebihi stok barang.";
                        $("#da-useitem-table-error").html(message).show();
                    }
                }else{
                    var message = "Tidak ada barang untuk pemakaian.";
                    $("#da-useitem-table-error").html(message).show();
                }
            }else{
                var message = "Project dan Subproject wajib diisi.";
                $("#da-useitem-detail-error").html(message).show();
            }
        });

        /*
         Common Function
         */
        function add_item_to_preview_table(poTable){
            // get input value
            var item_code = $('#useitem-insert-code').val();

            // prepare error message
            $("#da-useitem-insert-error").hide();
            $('#useitem-insert-code').focus();

            // add error checking when input is blank
            if(item_code){
                // clear all the text fields
                $('#useitem-insert-code').val('');
                var item_code_encoded = encodeURIComponent(item_code);

                $.get( "/useitem/get_stock_detail_by_item_stock_code/" + item_code_encoded, function(data) {
                    if(data != null && data.id != null){
                        $("#da-useitem-table-error").hide();

                        // update table
                        totalItem++;
                        var table_array = [];
                        table_array[0] = data.item_stock_code;
                        table_array[1] = data.item_name;
                        table_array[2] = data.item_count;
                        table_array[3] = '';
                        table_array[4] = data.item_unit;
                        poTable.row.add(table_array).draw();
                    }else{
                        // error message
                        var message = "Kode barang tidak ditemukan dalam sistem.";
                        $("#da-useitem-insert-error").html(message).show();
                    }
                }, "json" );
            }else{
                var message = "Kode barang wajib diisi.";
                $("#da-useitem-insert-error").html(message).show();
            }
        }
	});
}) (jQuery);