(function($) {
    $(document).ready(function(e) {
        $('th:nth-child(1)').hide();
        $('th:nth-child(2)').hide();
        $('th:nth-child(3)').hide();
        $('th:nth-child(4)').hide();
        $('th:nth-child(5)').hide();
        $('th:nth-child(6)').hide();
        $('th:nth-child(7)').hide();
        $('th:nth-child(8)').hide();

        // $("#gnd-report").dialog({autoOpen:false});
        $("#gnd-report").hide();
        $("#gnd-report-2").hide();
        $("#gnd-report-3").hide();

        /*
            Modal Controller for Creating Invoice Form
        */
        $("#da-gnd-create-form-invoice-div").dialog({
            autoOpen: false,
            title: "Buat Invoice",
            modal: true,
            width: "640",
            buttons: [{
                text: "Keluar",
                click: function() {
                    $("#klien").val('');
                    $("#project").val('');
                    $("#inv_num").val('');
                    $("#doc_num_inv").val('');
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
                text: "Keluar",
                click: function() {
                    $("#klienq").val('');
                    $("#projectq").val('');
                    $("#doc_num_quo").val('');
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
                text: "Keluar",
                click: function() {
                    $("#supplier").val('');
                    $("#projectp").val('');
                    $("#doc_num_po").val('');
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

        $('#month').change(function(){
            var month_name = $('#month').val();
            var date = new Date();
            var ddl = $('#doc_type').val();
            switch (month_name){
                case 'Januari'  : var month = 1; break;
                case 'Februari' : var month = 2; break;
                case 'Maret'    : var month = 3; break;
                case 'April'    : var month = 4; break;
                case 'Mei'      : var month = 5; break;
                case 'Juni'     : var month = 6; break;
                case 'Juli'     : var month = 7; break;
                case 'Agustus'  : var month = 8; break;
                case 'September': var month = 9; break;
                case 'Oktober'  : var month = 10; break;
                case 'November' : var month = 11; break;
                case 'Desember' : var month = 12; break;
                default         : var month = date.getMonth(); break;
            }
            $.ajax({
                type:'post',
                url:'/gnd/show_report/'+ddl,
                data:month,
                dataType:'json',
                success:function(data){
                    show_report(ddl, month);
                }
            });
        })

        $('#doc_type').change(function(){
            var ddl = $('#doc_type').val();
            var date = new Date();
            var month = date.getMonth() + 1;
            show_report(ddl, month);
        });

        function show_report(ddl, month){
            switch (ddl){
                case "Invoice":
                    $('th:nth-child(1)').show();
                    $('th:nth-child(2)').show();
                    $('th:nth-child(3)').show();
                    $('th:nth-child(4)').hide();
                    $('th:nth-child(5)').show();
                    $('th:nth-child(6)').show();
                    $('th:nth-child(7)').show();
                    $('th:nth-child(8)').hide();

                    $('#gnd-report').show();
                    $('#gnd-report').dataTable().api().destroy();
                    $('#gnd-report').dataTable({
                        sPaginationType: "full_numbers",
                        ajax : {
                            type:'post',
                            url:'/gnd/show_report/'+ddl,
                            data:'',
                            dataType:'json',
                            dataSrc:function(data){
                                var return_data = new Array();
                                    for(var a = 0; a < data.length; a++){
                                        var m = data[a].creation_date;
                                        if(m.substr(5,2) == month)
                                        return_data.push({
                                          'id': data[a].id,
                                          'creation_date'  : data[a].creation_date,
                                          'client' : data[a].client,
                                          'project' : data[a].project,
                                          'inv_num' : data[a].inv_num,
                                          'doc_num' : data[a].doc_num
                                        })
                                    }
                                    return return_data;
                            }
                        },
                        columns : [
                            {"data" : "id"},
                            {"data" : "creation_date"},
                            {"data" : "client"},
                            {"data" : "project"},
                            {"data" : "inv_num"},
                            {"data" : "doc_num"},   
                        ]
                    });

                    $('#gnd-report-2').show();
                    $('#gnd-report-2').dataTable().api().destroy();
                    $('#gnd-report-2').dataTable({
                        sPaginationType: "full_numbers",
                        ajax : {
                            type:'post',
                            url:'/gnd/show_report/'+ddl,
                            dataSrc:function(data){
                                var return_data = new Array();
                                    for(var a = 0; a < data.length; a++){
                                        var m = data[a].creation_date;
                                        if(m.substr(5,2) == month-1)
                                        return_data.push({
                                          'id': data[a].id,
                                          'creation_date'  : data[a].creation_date,
                                          'client' : data[a].client,
                                          'project' : data[a].project,
                                          'inv_num' : data[a].inv_num,
                                          'doc_num' : data[a].doc_num
                                        })
                                    }
                                    return return_data;
                            }
                        },
                        columns : [
                            {"data" : "id"},
                            {"data" : "creation_date"},
                            {"data" : "client"},
                            {"data" : "project"},
                            {"data" : "inv_num"},
                            {"data" : "doc_num"},   
                        ]
                    });

                    $('#gnd-report-3').show();
                    $('#gnd-report-3').dataTable().api().destroy();
                    $('#gnd-report-3').dataTable({
                        sPaginationType: "full_numbers",
                        ajax : {
                            type:'post',
                            url:'/gnd/show_report/'+ddl,
                            dataSrc:function(data){
                                var return_data = new Array();
                                    for(var a = 0; a < data.length; a++){
                                        var m = data[a].creation_date;
                                        if(m.substr(5,2) == month-2)
                                        return_data.push({
                                          'id': data[a].id,
                                          'creation_date'  : data[a].creation_date,
                                          'client' : data[a].client,
                                          'project' : data[a].project,
                                          'inv_num' : data[a].inv_num,
                                          'doc_num' : data[a].doc_num
                                        })
                                    }
                                    return return_data;
                            }
                        },
                        columns : [
                            {"data" : "id"},
                            {"data" : "creation_date"},
                            {"data" : "client"},
                            {"data" : "project"},
                            {"data" : "inv_num"},
                            {"data" : "doc_num"},   
                        ]
                    });
                    break;
                case "Quotation":
                    $('th:nth-child(1)').show();
                    $('th:nth-child(2)').show();
                    $('th:nth-child(3)').show();
                    $('th:nth-child(4)').hide();
                    $('th:nth-child(5)').show();
                    $('th:nth-child(6)').hide();
                    $('th:nth-child(7)').show();
                    $('th:nth-child(8)').show();

                    $('#gnd-report').show();
                    $('#gnd-report').dataTable().api().destroy();
                    $('#gnd-report').dataTable( {
                        sPaginationType: "full_numbers",
                        ajax: {
                            type:'post',
                            url: '/gnd/show_report/'+ddl,
                            dataSrc:function(data){
                                var return_data = new Array();
                                    for(var a = 0; a < data.length; a++){
                                        var m = data[a].creation_date;
                                        if(m.substr(5,2) == month)
                                        return_data.push({
                                          'id': data[a].id,
                                          'creation_date'  : data[a].creation_date,
                                          'client' : data[a].client,
                                          'project' : data[a].project,
                                          'doc_num' : data[a].doc_num
                                        })
                                    }
                                    return return_data;
                            }
                        },
                        columns: [ 
                            {"data" : "id"},
                            {"data" : "creation_date"},
                            {"data" : "client"},
                            {"data" : "project"},
                            {"data" : "doc_num"},
                            {"data" : ""}
                        ],
                        columnDefs: [ {
                            "targets": -1,
                            "data": null,
                            "defaultContent": ""
                        } ]
                    });

                    $('#gnd-report-2').show();
                    $('#gnd-report-2').dataTable().api().destroy();
                    $('#gnd-report-2').dataTable( {
                        sPaginationType: "full_numbers",
                        ajax: {
                            type:'post',
                            url: '/gnd/show_report/'+ddl,
                            dataSrc:function(data){
                                var return_data = new Array();
                                    for(var a = 0; a < data.length; a++){
                                        var m = data[a].creation_date;
                                        if(m.substr(5,2) == month-1)
                                        return_data.push({
                                          'id': data[a].id,
                                          'creation_date'  : data[a].creation_date,
                                          'client' : data[a].client,
                                          'project' : data[a].project,
                                          'doc_num' : data[a].doc_num
                                        })
                                    }
                                    return return_data;
                            }
                        },
                        columns: [ 
                            {"data" : "id"},
                            {"data" : "creation_date"},
                            {"data" : "client"},
                            {"data" : "project"},
                            {"data" : "doc_num"},
                            {"data" : ""}
                        ],
                        columnDefs: [ {
                            "targets": -1,
                            "data": null,
                            "defaultContent": ""
                        } ]
                    });

                    $('#gnd-report-3').show();
                    $('#gnd-report-3').dataTable().api().destroy();
                    $('#gnd-report-3').dataTable( {
                        sPaginationType: "full_numbers",
                        ajax: {
                            type:'post',
                            url: '/gnd/show_report/'+ddl,
                            dataSrc:function(data){
                                var return_data = new Array();
                                    for(var a = 0; a < data.length; a++){
                                        var m = data[a].creation_date;
                                        if(m.substr(5,2) == month-2)
                                        return_data.push({
                                          'id': data[a].id,
                                          'creation_date'  : data[a].creation_date,
                                          'client' : data[a].client,
                                          'project' : data[a].project,
                                          'doc_num' : data[a].doc_num
                                        })
                                    }
                                    return return_data;
                            }
                        },
                        columns: [ 
                            {"data" : "id"},
                            {"data" : "creation_date"},
                            {"data" : "client"},
                            {"data" : "project"},
                            {"data" : "doc_num"},
                            {"data" : ""}
                        ],
                        columnDefs: [ {
                            "targets": -1,
                            "data": null,
                            "defaultContent": ""
                        } ]
                    });
                    break;
                case "PO":
                    $('th:nth-child(1)').show();
                    $('th:nth-child(2)').show();
                    $('th:nth-child(3)').hide();
                    $('th:nth-child(4)').show();
                    $('th:nth-child(5)').show();
                    $('th:nth-child(6)').hide();
                    $('th:nth-child(7)').show();
                    $('th:nth-child(8)').show();

                    $('#gnd-report').show();
                    $('#gnd-report').dataTable().api().destroy();
                    $('#gnd-report').dataTable( {
                        sPaginationType: "full_numbers",
                        ajax: {
                            type:'post',
                            url: '/gnd/show_report/'+ddl,
                            dataSrc:function(data){
                                var return_data = new Array();
                                    for(var a = 0; a < data.length; a++){
                                        var m = data[a].creation_date;
                                        if(m.substr(5,2) == month)
                                        return_data.push({
                                          'id': data[a].id,
                                          'creation_date'  : data[a].creation_date,
                                          'supplier' : data[a].supplier,
                                          'project' : data[a].project,
                                          'doc_num' : data[a].doc_num
                                        })
                                    }
                                    return return_data;
                            }
                        },
                        columns: [ 
                            {"data" : "id"},
                            {"data" : "creation_date"},
                            {"data" : "supplier"},
                            {"data" : "project"},
                            {"data" : "doc_num"},
                            {"data" : ""}
                        ],
                        "columnDefs": [ {
                            "targets": -1,
                            "data": null,
                            "defaultContent": ""
                        } ]
                    });

                    $('#gnd-report-2').show();
                    $('#gnd-report-2').dataTable().api().destroy();
                    $('#gnd-report-2').dataTable( {
                        sPaginationType: "full_numbers",
                        ajax: {
                            type:'post',
                            url: '/gnd/show_report/'+ddl,
                            dataSrc:function(data){
                                var return_data = new Array();
                                    for(var a = 0; a < data.length; a++){
                                        var m = data[a].creation_date;
                                        if(m.substr(5,2) == month-1)
                                        return_data.push({
                                          'id': data[a].id,
                                          'creation_date'  : data[a].creation_date,
                                          'supplier' : data[a].supplier,
                                          'project' : data[a].project,
                                          'doc_num' : data[a].doc_num
                                        })
                                    }
                                    return return_data;
                            }
                        },
                        columns: [ 
                            {"data" : "id"},
                            {"data" : "creation_date"},
                            {"data" : "supplier"},
                            {"data" : "project"},
                            {"data" : "doc_num"},
                            {"data" : ""}
                        ],
                        "columnDefs": [ {
                            "targets": -1,
                            "data": null,
                            "defaultContent": ""
                        } ]
                    });

                    $('#gnd-report-3').show();
                    $('#gnd-report-3').dataTable().api().destroy();
                    $('#gnd-report-3').dataTable( {
                        sPaginationType: "full_numbers",
                        ajax: {
                            type:'post',
                            url: '/gnd/show_report/'+ddl,
                            dataSrc:function(data){
                                var return_data = new Array();
                                    for(var a = 0; a < data.length; a++){
                                        var m = data[a].creation_date;
                                        if(m.substr(5,2) == month-2)
                                        return_data.push({
                                          'id': data[a].id,
                                          'creation_date'  : data[a].creation_date,
                                          'supplier' : data[a].supplier,
                                          'project' : data[a].project,
                                          'doc_num' : data[a].doc_num
                                        })
                                    }
                                    return return_data;
                            }
                        },
                        columns: [ 
                            {"data" : "id"},
                            {"data" : "creation_date"},
                            {"data" : "supplier"},
                            {"data" : "project"},
                            {"data" : "doc_num"},
                            {"data" : ""}
                        ],
                        "columnDefs": [ {
                            "targets": -1,
                            "data": null,
                            "defaultContent": ""
                        } ]
                    });
                    break;
                default: null; break;
            }
        }
        // });

        $('#create_new_doc').bind("click", (function(event){
            event.preventDefault();
            var ddl = $('#doc_type').val();
            switch (ddl){
                case "Invoice": 
                    $("#da-gnd-create-form-invoice-div").dialog("option", {modal: true}).dialog("open");
                    break;
                case "Quotation": 
                    $("#da-gnd-create-form-quotation-div").dialog("option", {modal: true}).dialog("open"); break;
                case "PO": 
                    $("#da-gnd-create-form-po-div").dialog("option", {modal: true}).dialog("open"); break;
            }
        }));

        //Set value for inv doc url
        $('#generate_inv').bind("click", (function(event){
            event.preventDefault();
            var klien    = $('#klien').val();
            var project  = $('#project').val();
            var inv_num  = $('#inv_num').val();
            var user     = $('#user').val();
            var postData = {'klien' : klien, 'project' : project, 'inv_num' : inv_num, 'user' : user};

            $.ajax({
                type:'post',
                url:'/gnd/create_doc/Invoice',
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
            var klien    = $('#klienq').val();
            var project  = $('#projectq').val();
            var user     = $('#user').val();
            var postData = {'klien' : klien, 'project' : project, 'user' : user};

            $.ajax({
                type:'post',
                url:'/gnd/create_doc/Quotation',
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
            var supplier = $('#supplier').val();
            var project  = $('#projectp').val();
            var user     = $('#user').val();
            var postData = {'supplier' : supplier, 'project' : project, 'user' : user};
            $.ajax({
                type:'post',
                url:'/gnd/create_doc/PO',
                data:postData,
                dataType:'json',
                success:function(data){         
                    $('#doc_num_po').val(data);
                }
            });
        }));

        //Button Copy Invoice
        $('#btn_cp_inv').bind("click",(function(event){
            event.preventDefault();
            var clipboard = new Clipboard('#btn_cp_inv');
        }));
        //Button Copy Quotation
        $('#btn_cp_quo').bind("click",(function(event){
            event.preventDefault();
            var clipboard = new Clipboard('#btn_cp_quo');
        }));
        //Button Copy PO
        $('#btn_cp_po').bind("click",(function(event){
            event.preventDefault();
            var clipboard = new Clipboard('#btn_cp_po');
        }));

        //Button Search Invoice Number
        $('#search_inv').bind("click", (function(event){
            event.preventDefault();
            var klien   = $('#klien').val();
            var project = $('#project').val();
            var postData= {'klien' : klien, 'project' : project};

            $.ajax({
                type:'post',
                url:'/gnd/check_inv_num',
                data:postData,
                dataType:'json',
                success:function(data){
                    $('#inv_num').val(data);
                    console.log(data);
                }
            });
        }));
    });
}) (jQuery);
