(function($) {
    $(document).ready(function(e) {
        /*
            Modal Controller for Creating
         */
        $("#da-project-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah Project",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-project-create-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-project-create-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                project_initial: {
                    required: true
                },
                name: {
                    required: true
                },
                customer_name: {
                    required: true
                },
                start_date: {
                    required: true
                }
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Atribut yang diberi tanda wajib diisi.';
                    $("#da-project-create-validate-error").html(message).show();
                } else {
                    $("#da-project-create-validate-error").hide();
                }
            }
        });

        $("#da-project-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-project-create-form-div").dialog("option", {modal: true}).dialog("open");
            $("#project-create-start-date").datepicker({showOtherMonths:true, dateFormat: 'dd-mm-yy'});

            $.get( "/project/get_all_project_customer_names", function(data) {
                $( "#project-create-customer" ).autocomplete({
                    source: data
                });
            }, "json" );
        });

        /*
            Modal Controller for Editing
         */
        $("#da-project-edit-form-div").dialog({
            autoOpen: false,
            title: "Ubah Project",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-project-edit-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-project-edit-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                project_initial: {
                    required: true
                },
                name: {
                    required: true
                },
                customer_name: {
                    required: true
                },
                start_date: {
                    required: true
                }
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Atribut yang diberi tanda wajib diisi.';
                    $("#da-project-edit-validate-error").html(message).show();
                } else {
                    $("#da-project-edit-validate-error").hide();
                }
            }
        });

        $(".da-project-edit-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-project-edit-form-div").dialog("option", {modal: true}).dialog("open");
            //$("#project-edit-start-date").datepicker({showOtherMonths:true, dateFormat: 'dd-mm-yy'});

            $.get( "/project/get_all_project_customer_names", function(data) {
                $( "#project-edit-customer" ).autocomplete({
                    source: data
                });
            }, "json" );

            var id = $(this).data("value");
            $.get( "/project/get_project_detail/" + id, function(data) {
                $("#project-edit-id").val(id);
                $("#project-edit-project-initial").val(data.project_initial);
                $("#project-edit-name").val(data.name);
                $("#project-edit-customer").val(data.customer_name);
                $("#project-edit-start-date").val(data.formatted_start_date);
                $("#project-edit-address").val(data.address);
                $("#project-edit-notes").val(data.notes);
            }, "json" );
        });

        /*
         Modal Controller for Viewing
         */
        $("#da-project-view-form-div").dialog({
            autoOpen: false,
            title: "Lihat Project",
            modal: true,
            width: "640",
            buttons: [{
                text: "Keluar",
                click: function() {
                    $("#da-project-view-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        });

        $(".da-project-view-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-project-view-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            $.get( "/project/get_project_detail/" + id, function(data) {
                $("#project-view-project-initial").val(data.project_initial);
                $("#project-view-name").val(data.name);
                $("#project-view-customer").val(data.customer_name);
                $("#project-view-start-date").val(data.formatted_start_date);
                $("#project-view-finish-date").val(data.formatted_finish_date);
                $("#project-view-address").val(data.address);
                $("#project-view-notes").val(data.notes);
            }, "json" );
        });
    });
}) (jQuery);