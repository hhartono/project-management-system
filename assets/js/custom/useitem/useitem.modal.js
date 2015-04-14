(function($) {
    $(document).ready(function(e) {
        /*
            Modal Controller for Creating
         */
        
        $.get( "/useitem/get_all_useitem_project_names", function(data) {
                $( "#useitem-create-project" ).autocomplete({
                    source: data

                });
        }, "json" );

        $.get( "/useitem/get_all_useitem_worker_names", function(data) {
                $( "#useitem-create-worker" ).autocomplete({
                    source: data

                });
        }, "json" );

        

    });
}) (jQuery);