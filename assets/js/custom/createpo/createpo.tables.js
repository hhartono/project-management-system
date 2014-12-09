(function($) {
	$(document).ready(function(e) {
        var poTable = $("table#da-createpo-datatable-numberpaging").DataTable({
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

        $.get( "/createpo/get_all_po_item_names", function(data) {
            $( "#createpo-insert-name" ).autocomplete({
                source: data,
                change: function() {
                    var item_name = $("#createpo-insert-name").val();
                    get_unit_by_item_name(item_name, '#createpo-insert-item-count-label');
                }
            });
        }, "json" );

        $.get( "/createpo/get_all_po_supplier_names", function(data) {
            $( "#createpo-detail-supplier" ).autocomplete({
                source: data
            });
        }, "json" );

        $.get( "/createpo/get_all_po_customer_names", function(data) {
            $( "#createpo-detail-customer" ).autocomplete({
                source: data
            });
        }, "json" );

        $('#da-createpo-insert-add').on( 'click', function (event) {
            event.preventDefault();

            // get input value
            var item_name = $('#createpo-insert-name').val();
            var item_count = $('#createpo-insert-item-count').val();
            var item_notes = $('#createpo-insert-notes').val();

            // prepare error message
            $("#da-createpo-insert-error").hide();

            // add error checking when input is blank
            if(item_name && item_count){
                var table_array = [];
                table_array[0] = 0;
                table_array[1] = item_name;
                table_array[2] = item_count;
                table_array[3] = item_notes;

                // clear all the text fields
                $('#createpo-insert-name').val('');
                $('#createpo-insert-item-count').val('');
                $('#createpo-insert-item-count-label').text('');
                $('#createpo-insert-notes').val('');

                get_item_id_by_item_name(poTable, table_array);
            }else{
                var message = "Nama dan jumlah barang wajib diisi.";
                $("#da-createpo-insert-error").html(message).show();
            }
        });

        $('#da-createpo-insert-clear').on( 'click', function (event) {
            event.preventDefault();

            // hide error message
            $("#da-createpo-insert-error").hide();

            // clear all the text fields
            $('#createpo-insert-name').val('');
            $('#createpo-insert-item-count').val('');
            $('#createpo-insert-notes').val('');
        });

        $('#da-createpo-submit').on('click', function(event) {
            event.preventDefault();

            // get all the value from preview table
            var tableValue = [];
            var walk = 0;

            // get input detail
            var po_supplier = $('#createpo-detail-supplier').val();
            var po_customer = $('#createpo-detail-customer').val();
            $("#da-createpo-detail-error").hide();
            $("#da-createpo-table-error").hide();

            if(po_supplier && po_customer){
                if(totalItem > 0){
                    $('table#da-createpo-datatable-numberpaging tr').each(function(outer_index) {
                        if(outer_index > 0){
                            tableValue[walk] = {};
                            $.each(this.cells, function(index, element){
                                var column_name = $(element).attr("name");
                                var column_value = $(element).text();
                                tableValue[walk][column_name] = column_value;
                            });
                            walk++;
                        }
                    });

                    // create JSON
                    var poItemValues = JSON.stringify(tableValue);
                    $('#da-createpo-submit-item-values').val(poItemValues);

                    // submit form
                    $('form#da-createpo-detail-form-val').submit();
                }else{
                    var message = "Tidak ada barang untuk PO.";
                    $("#da-createpo-table-error").html(message).show();
                }
            }else{
                var message = "Supplier dan customer wajib diisi.";
                $("#da-createpo-detail-error").html(message).show();
            }
        });

        /*
         Common Function
         */
        function get_unit_by_item_name(item_name, target_textplace){
            var item_name_encoded = encodeURIComponent(item_name);

            $.get( "/createpo/get_unit_by_item_name/" + item_name_encoded, function(data) {
                if(data != null && data.name != null){
                    $(target_textplace).text(data.name);
                }else{
                    $(target_textplace).text('');
                }
            }, "json" );
        }

        function get_item_id_by_item_name(poTable, table_array){
            var item_name_encoded = encodeURIComponent(table_array[1]);

            $.get( "/createpo/get_item_detail_by_item_name/" + item_name_encoded, function(data) {
                if(data != null && data.id != null){
                    $("#da-createpo-table-error").hide();

                    // update table
                    totalItem++;
                    table_array[0] = data.id;
                    poTable.row.add(table_array).draw();
                }else{
                    // error message
                    var message = "Barang tidak ditemukan dalam sistem.";
                    $("#da-createpo-insert-error").html(message).show();
                }
            }, "json" );
        }
	});
}) (jQuery);