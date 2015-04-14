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

        $.get( "/purchaseorder/get_all_po_item_names", function(data) {
            $( "#purchaseorder-createpo-insert-name" ).autocomplete({
                source: data,
                change: function() {
                    var item_name = $("#purchaseorder-createpo-insert-name").val();
                    get_unit_by_item_name(item_name, '#purchaseorder-createpo-insert-item-count-label');
                }
            });
        }, "json" );

        $.get( "/purchaseorder/get_all_po_supplier_names", function(data) {
            $( "#purchaseorder-createpo-detail-supplier" ).autocomplete({
                source: data
            });
        }, "json" );

        $.get( "/purchaseorder/get_all_po_project_names", function(data) {
            $( "#purchaseorder-createpo-detail-project" ).autocomplete({
                source: data
            });
        }, "json" );

        $('#da-purchaseorder-createpo-insert-add').on( 'click', function (event) {
            event.preventDefault();

            // get input value
            var item_name = $('#purchaseorder-createpo-insert-name').val();
            var item_count = $('#purchaseorder-createpo-insert-item-count').val();
            var item_notes = $('#purchaseorder-createpo-insert-notes').val();

            // prepare error message
            $("#da-purchaseorder-createpo-insert-error").hide();

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
            var item_name_encoded = encodeURIComponent(item_name);

            $.get( "/purchaseorder/get_unit_by_item_name/" + item_name_encoded, function(data) {
                if(data != null && data.name != null){
                    $(target_textplace).text(data.name);
                }else{
                    $(target_textplace).text('');
                }
            }, "json" );
        }

        function get_item_id_by_item_name(poTable, table_array){
            var item_name_encoded = encodeURIComponent(table_array[1]);

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