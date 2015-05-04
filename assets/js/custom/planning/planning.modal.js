(function($) {
    $(document).ready(function(e) {
        /*
            Modal Controller for Creating
         */
        $("#da-planning-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah Subproject Item",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-planning-create-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-planning-create-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                name: {
                    required: true
                }
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Atribut yang diberi tanda wajib diisi.';
                    $("#da-planning-create-validate-error").html(message).show();
                } else {
                    $("#da-planning-create-validate-error").hide();
                }
            }
        });

        $("#da-planning-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-planning-create-form-div").dialog("option", {modal: true}).dialog("open");
        });

        $.get( "/planning/get_all_planning_item_names", function(data) {
            $( "#planning-insert-name" ).autocomplete({
                source: data,
                change: function() {
                    var item_name = $("#planning-insert-name").val();
                    get_unit_by_item_name(item_name, '#planning-insert-item-count-label');
                }
            });
        }, "json" );

        function get_unit_by_item_name(item_name, target_textplace){
            var item_name_encoded = encodeURIComponent(item_name);

            $.get( "/planning/get_unit_by_item_name/" + item_name_encoded, function(data) {
                if(data != null && data.name != null){
                    $(target_textplace).text(data.name);
                }else{
                    $(target_textplace).text('');
                }
            }, "json" );
        }

    });
}) (jQuery);