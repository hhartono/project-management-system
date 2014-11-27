(function($) {
    $(document).ready(function(e) {
        /*
            Modal Controller for Creating
         */
        $("#da-worker-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah Tukang",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-worker-create-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-worker-create-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                name: {
                    required: true
                },
                division_id: {
                    required: true
                }
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Atribut yang diberi tanda wajib diisi.';
                    $("#da-worker-create-validate-error").html(message).show();
                } else {
                    $("#da-worker-create-validate-error").hide();
                }
            }
        });

        $("#da-worker-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-worker-create-form-div").dialog("option", {modal: true}).dialog("open");
            $("#worker-create-join-date").datepicker({showOtherMonths:true, dateFormat: 'dd-mm-yy'});

            /* get the option for division */
            $('#worker-create-division')
                .find('option')
                .remove()
                .end();

            $.get( "/worker/get_all_worker_divisions", function(data) {
                $('#worker-create-division')
                    .append($("<option></option>")
                        .attr("value", "")
                        .text("-- Silahkan Pilih --"));

                $.each(data, function(key, value){
                    $('#worker-create-division')
                        .append($("<option></option>")
                            .attr("value", value.id)
                            .text(value.name));
                });
            }, "json" );
        });

        /*
            Modal Controller for Editing
         */
        $("#da-worker-edit-form-div").dialog({
            autoOpen: false,
            title: "Ubah Tukang",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-worker-edit-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-worker-edit-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                name: {
                    required: true
                },
                division_id: {
                    required: true
                }
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Atribut yang diberi tanda wajib diisi.';
                    $("#da-worker-edit-validate-error").html(message).show();
                } else {
                    $("#da-worker-edit-validate-error").hide();
                }
            }
        });

        $(".da-worker-edit-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-worker-edit-form-div").dialog("option", {modal: true}).dialog("open");
            $("#worker-create-join-date").datepicker({showOtherMonths:true, dateFormat: 'dd-mm-yy'});

            var id = $(this).data("value");
            $.get( "/worker/get_worker_detail/" + id, function(data) {
                $("#worker-edit-id").val(id);
                $("#worker-edit-name").val(data.name);
                $("#worker-edit-address").val(data.address);
            }, "json" );
        });
    });
}) (jQuery);