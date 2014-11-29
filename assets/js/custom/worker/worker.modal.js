(function($) {
    $(document).ready(function(e) {
        /*
         Modal Controller for Viewing
         */
        $("#da-worker-view-form-div").dialog({
            autoOpen: false,
            title: "Lihat Tukang",
            modal: true,
            width: "640",
            buttons: [{
                text: "Keluar",
                click: function() {
                    $("#da-worker-view-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        });

        $(".da-worker-view-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-worker-view-form-div").dialog("option", {modal: true}).dialog("open");

            //var id = $(this).data("value");
            //var viewCallbacks = $.Callbacks();
            //viewCallbacks.add(prepareViewDivision);
            //viewCallbacks.fire();
            //viewCallbacks.add(fillView);
            //viewCallbacks.fire(id);

            // fill division with all possible values
            var id = $(this).data("value");
            prepareViewDivision(id);
        });

        function prepareViewDivision(id) {
            $('#worker-view-division')
                .find('option')
                .remove()
                .end();

            $.get( "/worker/get_all_worker_divisions", function(data) {
                $('#worker-view-division')
                    .append($("<option></option>")
                        .attr("value", "")
                        .text("-- Silahkan Pilih --"));

                $.each(data, function(key, value){
                    $('#worker-view-division')
                        .append($("<option></option>")
                            .attr("value", value.id)
                            .text(value.name));
                });

                // fill the known value
                fillView(id);
            }, "json" );
        }

        function fillView(id) {
            $.get( "/worker/get_worker_detail/" + id, function(data) {
                $("#worker-view-id").val(id);
                $("#worker-view-worker-code").val(data.worker_code);
                $("#worker-view-division").val(data.division_id);
                $("#worker-view-name").val(data.name);
                $("#worker-view-address").val(data.address);
                $("#worker-view-phone-1").val(data.phone_number_1);
                $("#worker-view-phone-2").val(data.phone_number_2);
                $("#worker-view-join-date").val(data.formatted_join_date);
                $("#worker-view-salary").val(data.salary);
                $("#worker-view-notes").val(data.notes);
            }, "json" );
        }

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
                    $("#worker-edit-division").prop("disabled", false);
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
            $("#worker-edit-join-date").datepicker({showOtherMonths:true, dateFormat: 'dd-mm-yy'});

            //var id = $(this).data("value");
            //var editCallbacks = $.Callbacks();
            //editCallbacks.add(prepareEditDivision);
            //editCallbacks.fire();
            //editCallbacks.add(fillEdit);
            //editCallbacks.fire(id);

            // fill division with all possible values
            var id = $(this).data("value");
            prepareEditDivision(id);
        });

        function prepareEditDivision(id) {
            $('#worker-edit-division')
                .find('option')
                .remove()
                .end();

            $.get( "/worker/get_all_worker_divisions", function(data) {
                $('#worker-edit-division')
                    .append($("<option></option>")
                        .attr("value", "")
                        .text("-- Silahkan Pilih --"));

                $.each(data, function(key, value){
                    $('#worker-edit-division')
                        .append($("<option></option>")
                            .attr("value", value.id)
                            .text(value.name));
                });

                // fill the known value
                fillEdit(id);
            }, "json" );
        }

        function fillEdit(id){
            $.get( "/worker/get_worker_detail/" + id, function(data) {
                $("#worker-edit-id").val(id);
                $("#worker-edit-worker-code").val(data.worker_code);
                $("#worker-edit-division").val(data.division_id);
                $("#worker-edit-name").val(data.name);
                $("#worker-edit-address").val(data.address);
                $("#worker-edit-phone-1").val(data.phone_number_1);
                $("#worker-edit-phone-2").val(data.phone_number_2);
                $("#worker-edit-join-date").val(data.formatted_join_date);
                $("#worker-edit-salary").val(data.salary);
                $("#worker-edit-notes").val(data.notes);

            }, "json" );
        }
    });
}) (jQuery);