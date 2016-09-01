(function($) {
    $(document).ready(function(e) {
        /*
            Modal Controller for Creating
         */
        $("#da-warna-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah warna",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-warna-create-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-warna-create-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                warna_initial: {
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
                    $("#da-warna-create-validate-error").html(message).show();
                } else {
                    $("#da-warna-create-validate-error").hide();
                }
            }
        });

        $("#da-warna-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-warna-create-form-div").dialog("option", {modal: true}).dialog("open");
            $("#warna-create-start-date").datepicker({showOtherMonths:true, dateFormat: 'dd-mm-yy'});

            $.get( "/warna/get_all_warna_customer_names", function(data) {
                $( "#warna-create-customer" ).autocomplete({
                    source: data
                });
            }, "json" );
        });

        $("#da-warna-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-warna-create-form-div").dialog("option", {modal: true}).dialog("open");
            $("#warna-create-start-date").datepicker({showOtherMonths:true, dateFormat: 'dd-mm-yy'});

            $.get( "/warna/get_all_warna_company_names", function(data) {
                $( "#warna-create-company" ).autocomplete({
                    source: data
                });
            }, "json" );
        });

        /*
            Modal Controller for Editing
         */
        $("#da-warna-edit-form-div").dialog({
            autoOpen: false,
            title: "Ubah warna",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-warna-edit-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-warna-edit-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                kode_warna: {
                    required: true
                },
                nama_warna: {
                    required: true
                },
                kode_pantone: {
                    required: true
                },
                hexadecimal: {
                    required: true
                }
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Atribut yang diberi tanda wajib diisi.';
                    $("#da-warna-edit-validate-error").html(message).show();
                } else {
                    $("#da-warna-edit-validate-error").hide();
                }
            }
        });

        $(".da-warna-edit-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-warna-edit-form-div").dialog("option", {modal: true}).dialog("open");
            //$("#warna-edit-start-date").datepicker({showOtherMonths:true, dateFormat: 'dd-mm-yy'});

            $.get( "/warna/get_all_warna_customer_names", function(data) {
                $( "#warna-edit-customer" ).autocomplete({
                    source: data
                });
            }, "json" );

            var id = $(this).data("value");
            $.get( "/warna/get_warna_detail/" + id, function(data) {
                $("#warna-edit-id").val(id);
                $("#warna-edit-warna-initial").val(data.warna_initial);
                $("#warna-edit-name").val(data.name);
                $("#warna-edit-customer").val(data.customer_name);
                $("#warna-edit-start-date").val(data.formatted_start_date);
                $("#warna-edit-address").val(data.address);
                $("#warna-edit-notes").val(data.notes);
            }, "json" );
        });

        /*
         Modal Controller for Viewing
         */
        $("#da-warna-view-form-div").dialog({
            autoOpen: false,
            title: "Lihat Warna",
            modal: true,
            width: "640",
            buttons: [{
                text: "Keluar",
                click: function() {
                    $("#da-warna-view-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        });

        $(".da-warna-view-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-warna-view-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            $.get( "/warna/get_warna_detail/" + id, function(data) {
                $("#warna-view-warna-initial").val(data.warna_initial);
                $("#warna-view-name").val(data.name);
                $("#warna-view-customer").val(data.customer_name);
                $("#warna-view-start-date").val(data.formatted_start_date);
                $("#warna-view-finish-date").val(data.formatted_finish_date);
                $("#warna-view-address").val(data.address);
                $("#warna-view-notes").val(data.notes);
            }, "json" );
        });

        /*
            Modal Controller for Creating Project
         */
        $("#da-warna-project-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah Project",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-warna-project-create-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-warna-project-create-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                project_name: {
                    required: true
                }
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Atribut yang diberi tanda wajib diisi.';
                    $("#da-warna-project-create-validate-error").html(message).show();
                } else {
                    $("#da-warna-project-create-validate-error").hide();
                }
            }
        });

        $("#da-warna-project-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-warna-project-create-form-div").dialog("option", {modal: true}).dialog("open");
            
            $.get( "/warna/get_all_project_warna", function(data) {
                $( "#pattern-create-project" ).autocomplete({
                    source: data
                });
            }, "json" );
        });

        /*
            Modal Controller for Creating SubProject
         */
        $("#da-warna-subproject-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah SubProject",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-warna-subproject-create-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-warna-subproject-create-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                subproject_name: {
                    required: true
                }
            },
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = 'Atribut yang diberi tanda wajib diisi.';
                    $("#da-warna-subproject-create-validate-error").html(message).show();
                } else {
                    $("#da-warna-subproject-create-validate-error").hide();
                }
            }
        });

        $("#da-warna-subproject-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-warna-subproject-create-form-div").dialog("option", {modal: true}).dialog("open");
            
            $.get( "/warna/get_all_subproject_warna", function(data) {
                $( "#pattern-create-subproject" ).autocomplete({
                    source: data
                });
            }, "json" );
        });

        $("#da-warna-subproject-photo-form-div").dialog({
            autoOpen: false,
            modal: true,
            width: "640",
            buttons: [{
                text: "Keluar",
                click: function() {
                    $("#da-warna-subproject-photo-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        });

        $(".da-warna-subproject-photo-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-warna-subproject-photo-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            $.get( "/warna/get_subproject_warna_detail/" + id, function(data) {
                $("#subproject-warna-id").val(id);
            }, "json" );

        });

        $("#da-warna-cari-form-div").dialog({
            autoOpen: false,
            title: "Tambah Pattern",
            modal: true,
            width: "640",
            buttons: [{
                text: "Keluar",
                click: function() {
                    $("#da-warna-cari-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        });

        $("#da-warna-cari-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-warna-cari-form-div").dialog("option", {modal: true}).dialog("open");

            $("#da-warna-cari-dialog").getElementById("kode_warna").value = $(this).attr('data-kode');

            /*var id = $(this).data("value");
            $.get( "/warna/get_subproject_warna_detail/" + id, function(data) {
                $("#subproject-warna-id").val(id);
            }, "json" );*/

        });

        $("#da-corak-cari-form-div").dialog({
            autoOpen: false,
            title: "Tambah Corak",
            modal: true,
            width: "640",
            buttons: [{
                text: "Keluar",
                click: function() {
                    $("#da-corak-cari-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        });

        $("#da-corak-cari-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-corak-cari-form-div").dialog("option", {modal: true}).dialog("open");

            $("#da-corak-cari-dialog").getElementById("kode_corak").value = $(this).attr('data-kode');

            /*var id = $(this).data("value");
            $.get( "/warna/get_subproject_warna_detail/" + id, function(data) {
                $("#subproject-warna-id").val(id);
            }, "json" );*/

        });

        $(document).on('click', '.pilih', function (e) {
            document.getElementById("nim").value = $(this).attr('data-nim');
            $('#myModal').modal('hide');
        });

        $("#da-image-view-div").dialog({
            autoOpen: false,
            title: "Preview",
            modal: true,
            width: "640",
            buttons: [{
                text: "Keluar",
                click: function() {
                    $("#da-image-view-div").dialog("option", {modal: true}).dialog("close");
                }}]
        });

        $("#da-image-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-image-view-div").dialog("option", {modal: true}).dialog("open");
        });
    });
}) (jQuery);