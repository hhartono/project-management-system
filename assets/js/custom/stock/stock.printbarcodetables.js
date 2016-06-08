(function($) {
	$(document).ready(function(e) {
        $("table#da-stock-barcode-print-datatable-numberpaging").DataTable({
            //sPaginationType: "full_numbers",
            bSort: false,
            bPaginate: false,
            bFilter: false
        });

        $('#da-stock-barcode-print-confirmation-submit').on('click', function(event) {
            event.preventDefault();
        });

        $('#da-stock-barcode-print-submit').on('click', function(event) {
            event.preventDefault();

            // get all the value from preview table
            var tableValue = [];
            var walk = 0;
            var overflowStatus = false;

            // get input detail
            $("#da-stock-barcode-print-detail-error").hide();
            $('table#da-stock-barcode-print-datatable-numberpaging tr').each(function(outer_index) {
                if(outer_index > 0){
                    var walk_status = false;
                    var label_quantity_status = false;
                    var item_quantity = 0;
                    var label_quantity = 0;
                    var tempObject = {};
                    $.each(this.cells, function(index, element){
                        if($(element).attr("name")){
                            var column_name = $(element).attr("name");
                            var column_value = $(element).text();
                            if($(element).children('input').length > 0 && column_name == 'item_quantity'){
                                column_value = $(element).children("input").val();
                            }

                            if($(element).children('input').length > 0 && column_name == 'label_quantity'){
                                column_value = $(element).children("input").val();
                                label_quantity_status = true;
                            }
                            tempObject[column_name] = column_value;
                            walk_status = true;

                            // prepare value to check overflow
                            if(column_name == 'item_quantity'){
                                item_quantity = parseInt(column_value);
                            }

                            if(column_name == 'label_quantity'){
                                label_quantity = parseInt(column_value);
                            }
                        }
                    });

                    // check if the row successfully parsed
                    if(walk_status == true && label_quantity_status == true){
                        tableValue[walk] = tempObject;
                        walk++;
                    }

                    // determine overflow status
                    if(item_quantity < label_quantity){
                        overflowStatus = true;
                    }
                }
            });

            // check if any value is successfully parsed
            if(walk > 0){
                if(overflowStatus == false){
                    // create JSON
                    var barcodePrintValues = JSON.stringify(tableValue);
                    $('#da-stock-barcode-print-submit-item-values').val(barcodePrintValues);

                    // submit form
                    $('form#da-stock-barcode-print-detail-form-val').submit();
                }else{
                    var message = "Jumlah label lebih besar dari barang diterima.";
                    $("#da-stock-barcode-print-detail-error").html(message).show();
                }
            }else{
                var message = "Tidak ada label untuk di print.";
                $("#da-stock-barcode-print-detail-error").html(message).show();
            }
        });
	});
}) (jQuery);