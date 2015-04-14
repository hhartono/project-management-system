(function($) {
    $(document).ready(function(e) {
        /*
            Modal Controller for Creating
         */
        $("#da-subproject-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah Subproject",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-subproject-create-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-subproject-create-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                project_name: {
                    required: true
                },
                name: {
                    required: true
                }
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Atribut yang diberi tanda wajib diisi.';
                    $("#da-subproject-create-validate-error").html(message).show();
                } else {
                    $("#da-subproject-create-validate-error").hide();
                }
            }
        });

        $("#da-subproject-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-subproject-create-form-div").dialog("option", {modal: true}).dialog("open");

            $.get( "/subproject/get_all_subproject_project_names", function(data) {
                $( "#subproject-create-project" ).autocomplete({
                    source: data
                });
            }, "json" );
        });

        /*
            Modal Controller for Editing
         */
        $("#da-subproject-edit-form-div").dialog({
            autoOpen: false,
            title: "Ubah Subproject",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-subproject-edit-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-subproject-edit-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                project_name: {
                    required: true
                },
                name: {
                    required: true
                }
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Atribut yang diberi tanda wajib diisi.';
                    $("#da-subproject-edit-validate-error").html(message).show();
                } else {
                    $("#da-subproject-edit-validate-error").hide();
                }
            }
        });

        $(".da-subproject-edit-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-subproject-edit-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            $.get( "/subproject/get_subproject_detail/" + id, function(data) {
                $("#subproject-edit-id").val(id);
                $("#subproject-edit-project").val(data.project_name);
                $("#subproject-edit-name").val(data.name);
                $("#subproject-edit-notes").val(data.notes);
            }, "json" );
        });

        /*
         Modal Controller for Viewing
         */
        $("#da-subproject-view-form-div").dialog({
            autoOpen: false,
            title: "Lihat Subproject",
            modal: true,
            width: "640",
            buttons: [{
                text: "Keluar",
                click: function() {
                    $("#da-subproject-view-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        });

        $(".da-subproject-view-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-subproject-view-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            $.get( "/subproject/get_subproject_detail/" + id, function(data) {
                $("#subproject-view-project").val(data.project_name);
                $("#subproject-view-subproject-code").val(data.subproject_code);
                $("#subproject-view-name").val(data.name);
                $("#subproject-view-start-date").val(data.formatted_start_date);
                $("#subproject-view-install-date").val(data.formatted_install_date);
                $("#subproject-view-notes").val(data.notes);
            }, "json" );
        });
    });
}) (jQuery);