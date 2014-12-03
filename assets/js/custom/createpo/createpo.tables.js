(function($) {
	$(document).ready(function(e) {
        var poTable = $("table#da-createpo-datatable-numberpaging").DataTable({
            bPaginate: false,
            bFilter: false
            //sPaginationType: "full_numbers"
        });

        $('#da-createpo-insert-add').on( 'click', function (event) {
            event.preventDefault();

            // TODO - add error checking when input is blank

            // get input value
            var item_name = $('#createpo-insert-name').val();
            var item_count = $('#createpo-insert-item-count').val();
            var item_notes = $('#createpo-insert-notes').val();
            var table_array = [];
            table_array[0] = item_name;
            table_array[1] = item_count;
            table_array[2] = item_notes;

            // clear all the text fields
            $('#createpo-insert-name').val('');
            $('#createpo-insert-item-count').val('');
            $('#createpo-insert-notes').val('');

            // update table
            poTable.row.add(table_array).draw();
        });

        $('#da-createpo-insert-clear').on( 'click', function (event) {
            event.preventDefault();

            // clear all the text fields
            $('#createpo-insert-name').val('');
            $('#createpo-insert-item-count').val('');
            $('#createpo-insert-notes').val('');
        });

	});
}) (jQuery);