(function($) {
	$(document).ready(function(e) {
        $("table#da-kirimpress-receive-datatable-numberpaging").DataTable({
            //sPaginationType: "full_numbers",
            bSort: false,
            bPaginate: false,
            bFilter: false
        });

        $('#da-kirimpress-receive-submit').on('click', function(event) {
            event.preventDefault();

            // get all the value from preview table
            var tableValue = [];
            var walk = 0;
            var overflowStatus = false;

            $("#da-kirimpress-receive-detail-error").hide();

                $('table#da-kirimpress-receive-datatable-numberpaging tr').each(function(outer_index) {
                    if(outer_index > 0){
                        var walk_status = false;
                        var quantity_received_status = false;
                        var quantity_ordered = 0;
                        var quantity_already_received = 0;
                        var quantity_received = 0;
                        var tempObject = {};
                        $.each(this.cells, function(index, element){
                            if($(element).attr("name")){
                                var column_name = $(element).attr("name");
                                var column_value = $(element).text();
                                if($(element).children('input').length > 0 && column_name == 'quantity_received'){
                                    column_value = $(element).children("input").val();
                                    quantity_received_status = true;
                                }

                                tempObject[column_name] = column_value;
                                walk_status = true;

                                // prepare value to check overflow
                                if(column_name == 'quantity_ordered'){
                                    quantity_ordered = parseInt(column_value);
                                }

                                if(column_name == 'quantity_already_received'){
                                    quantity_already_received = parseInt(column_value);
                                }

                                if(column_name == 'quantity_received'){
                                    quantity_received = parseInt(column_value);
                                }

                            }
                        });

                        // check if the row successfully parsed
                        if(walk_status == true && quantity_received_status == true){
                            tableValue[walk] = tempObject;
                            walk++;
                        }

                        // determine overflow status
                        if(quantity_ordered < (quantity_already_received + quantity_received)){
                            overflowStatus = true;
                        }
                    }
                });

                // check if any value is successfully parsed
                if(walk > 0){
                    if(overflowStatus == false){
                        // create JSON
                        var receiveItemValues = JSON.stringify(tableValue);
                        $('#da-kirimpress-receive-submit-item-values').val(receiveItemValues);

                        // submit form
                        $('form#da-kirimpress-receive-detail-form-val').submit();
                    }else{
                        var message = "Barang diterima lebih besar dari yang dipesan.";
                        $("#da-kirimpress-receive-detail-error").html(message).show();
                    }
                }else{
                    var message = "Tidak ada barang yang diterima.";
                    $("#da-kirimpress-receive-detail-error").html(message).show();
                }
        });
	});
}) (jQuery);