(function($) {
    $(document).ready(function(e) {

        /*
            Modal Controller for Creating Invoice Form
        */
        $("#da-gnd-create-form-invoice-div").dialog({
            autoOpen: false,
            title: "Buat Invoice",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-gnd-create-form-invoice-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-gnd-create-form-invoice-div").dialog("option", {modal: true}).dialog("close");
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
                    $("#da-gnd-create-invoice-validate-error").html(message).show();
                } else {
                    $("#da-gnd-create-invoice-validate-error").hide();
                }
            }
        });
        /*
            Modal Controller for Creating Quotation Form
         */
        $("#da-gnd-create-form-quotation-div").dialog({
            autoOpen: false,
            title: "Buat Quotation",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-gnd-create-form-quotation-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-gnd-create-form-quotation-div").dialog("option", {modal: true}).dialog("close");
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
                    $("#da-gnd-create-quotation-validate-error").html(message).show();
                } else {
                    $("#da-gnd-create-quotation-validate-error").hide();
                }
            }
        });

        /*
            Modal Controller for Creating PO Form
        */
        $("#da-gnd-create-form-po-div").dialog({
            autoOpen: false,
            title: "Buat PO",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-gnd-create-form-po-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-gnd-create-form-po-div").dialog("option", {modal: true}).dialog("close");
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
                    $("#da-gnd-create-po-validate-error").html(message).show();
                } else {
                    $("#da-gnd-create-po-validate-error").hide();
                }
            }
        });

        $('#doc_types').change(function(){
            var ddl = $('#doc_type').val();
            switch (ddl){
                case "Invoice": 
                    // $("#da-gnd-create-form-invoice-div").dialog("option", {modal: true}).dialog("open"); 
                    $.ajax({
                        type:'post',
                        url:'/gnd/show_report/',
                        // url:'/gnd/create_doc/',
                        data:"doc_t=Invoice",
                        dataType:'json',
                        success: function(data){
                            // $('#doc_num').val(data);
                            $('.result').val(data);
                            console.log(data);
                        } 
                    });
                    break;
            //     case "Quotation": 
            //         // $("#da-gnd-create-form-quotation-div").dialog("option", {modal: true}).dialog("open"); 
            //         $.ajax({
            //             type:'post',
            //             url:'/gnd/show_report/',
            //             success: function(e){
            //                 console.log(ddl);
            //             } 
            //         });
            //         break;
            //     case "PO": 
            //         // $("#da-gnd-create-form-po-div").dialog("option", {modal: true}).dialog("open"); 
            //         $.ajax({
            //             type:'post',
            //             url:'/gnd/show_report/',
            //             success: function(e){
            //                 console.log(ddl);
            //             } 
            //         });
            //         break;
            }
        });

        $('#create_new_doc').bind("click", (function(event){
            event.preventDefault();
            var ddl = $('#doc_type').val();
            switch (ddl){
                case "Invoice": 
                    $("#da-gnd-create-form-invoice-div").dialog("option", {modal: true}).dialog("open"); break;
                case "Quotation": 
                    $("#da-gnd-create-form-quotation-div").dialog("option", {modal: true}).dialog("open"); break;
                case "PO": 
                    $("#da-gnd-create-form-po-div").dialog("option", {modal: true}).dialog("open"); break;
            }
        }));

        //Set value for inv doc url
        $('#generate_inv').bind("click", (function(event){
            event.preventDefault();
            var doc      = $('#doc').val();
            var klien    = $('#klien').val();
            var project  = $('#project').val();
            var inv_num  = $('#inv_num').val();
            var postData = {'doc' : doc, 'klien' : klien, 'project' : project, 'inv_num' : inv_num};

            $.ajax({
                type:'post',
                url:'/gnd/create_doc',
                data:postData,
                dataType:'json',
                success:function(data){         
                    $('#doc_num_inv').val(data);
                }
            });
        }));

        //Set value for quo doc url
        $('#generate_quo').bind("click", (function(event){
            event.preventDefault();
            var doc      = $('#doc').val();
            var klien    = $('#klien').val();
            var project  = $('#project').val();
            var postData = {'doc' : doc, 'klien' : klien, 'project' : project};
            console.log(doc);
            $.ajax({
                type:'post',
                url:'/gnd/create_doc',
                data:postData,
                dataType:'json',
                success:function(data){         
                    $('#doc_num_quo').val(data);
                }
            });
        }));

        //Set value for po doc url
        $('#generate_po').bind("click", (function(event){
            event.preventDefault();
            var doc      = $('#doc').val();
            var supplier = $('#supplier').val();
            var project  = $('#project').val();
            var postData = {'doc' : doc, 'supplier' : supplier, 'project' : project};
            console.log(doc);
            $.ajax({
                type:'post',
                url:'/gnd/create_doc',
                data:postData,
                dataType:'json',
                success:function(data){         
                    $('#doc_num_po').val(data);
                }
            });
        }));
    });
}) (jQuery);
