(function($) {
    $(document).ready(function(e) {
        /*
            Modal Controller for Creating
         */

        $.get( "/planning/get_all_planning_item_names", function(data) {
            $( "#planning-insert-name" ).autocomplete({
                source: data,
                change: function() {
                    var item_name = $("#planning-insert-name").val();
                    get_unit_by_item_name(item_name, '#purchaseorder-createpo-insert-item-count-label');
                }
            });
        }, "json" );

    });
}) (jQuery);