(function($) {
    $(document).ready(function(e) {
        /*
            Modal Controller for Creating
         */
        $("#da-category-create-form-div").dialog({
            autoOpen: false,
            title: "Tambah Kategori",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-category-create-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-category-create-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                prefix: {
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
                    $("#da-category-create-validate-error").html(message).show();
                } else {
                    $("#da-category-create-validate-error").hide();
                }
            }
        });

        $("#da-category-create-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-category-create-form-div").dialog("option", {modal: true}).dialog("open");
        });

        /*
            Modal Controller for Editing
         */
        $("#da-category-edit-form-div").dialog({
            autoOpen: false,
            title: "Ubah Kategori",
            modal: true,
            width: "640",
            buttons: [{
                text: "Simpan",
                click: function() {
                    $(this).find('form#da-category-edit-form-val').submit();
                }},
                {
                text: "Keluar",
                click: function() {
                    $("#da-category-edit-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        }).find('form').validate({
            rules: {
                prefix: {
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
                    $("#da-category-edit-validate-error").html(message).show();
                } else {
                    $("#da-category-edit-validate-error").hide();
                }
            }
        });

        $(".da-category-edit-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-category-edit-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            $.get( "/categoryrev/get_category_detail/" + id, function(data) {
                $("#category-edit-id").val(id);
                $("#category-edit-prefix").val(data.prefix);
                $("#category-edit-nama").val(data.nama);
                $("#category-edit-kat").val(data.kategori);
                $("#category-edit-satuan").val(data.satuan);
                $("#category-edit-harga").val(data.harga);
            }, "json" );
        });

        /*
            Modal Controller for Viewing
         */
        $("#da-category-view-form-div").dialog({
            autoOpen: false,
            title: "Cek History Harga",
            modal: true,
            width: "640",
            buttons: [{
                text: "Keluar",
                click: function() {
                    $("#da-category-view-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        });

        $(".da-category-view-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-category-view-form-div").dialog("option", {modal: true}).dialog("open");

            var kat_id = $(this).data('value');
            // $.get('/categoryrev/cek_history_harga/'+kat_id, function(data){
            //     // $("category-view-nama").val(data.nama);
            // }, "json");
            var t = [];
            $.ajax({
                type:'post',
                url:'/categoryrev/cek_history_harga/'+kat_id,
                dataType:'json',
                success:function(data){
                    var x;
                    for(x in data){
                        console.log(data[x]['harga']);
                        // var texts = "<tr><td>"+data[x]['harga']+"</td><td>"+data[x]['last_update_timestamp']+"</td></tr>";
                        t['harga'] = data[x]['harga'];
                        t['last_update_timestamp'] = data[x]['last_update_timestamp'];
                        // document.getElementById('coba').innerHTML = texts;
                        // console.log(data);
                    }
                }
            });

            var text = "<tr><td>"+t+"</td><td>b</td></tr>";
            console.log(t);
            // var text = 'ab';
            // var teks = '<thead><th>Harga</th><th>Tanggal</th></thead><tbody></tbody>';
            document.getElementById('coba').innerHTML = text;
            // $("#harga").dataTable().api().destroy();
            // $("#harga").dataTable({
            //     sPaginationType: "full_numbers",
            //     ajax : {
            //         type:'post',
            //         url:'/categoryrev/cek_history_harga/'+kat_id,
            //         data:'',
            //         dataType:'json',
            //         // dataSrc:function(data){
            //         //     var return_data = new Array();
            //         //         for(var a = 0; a < data.length; a++){
            //         //             // var m = data[a].creation_date;
            //         //             // if(m.substr(5,2) == month)
            //         //             return_data.push({
            //         //               'id': data[a].id,
            //         //               'kat_id' : data[a].kat_id,
            //         //               'nama_kat'  : data[a].nama_kat,
            //         //               'harga' : data[a].harga,
            //         //               'last_update_timestamp' : data[a].last_update_timestamp,
            //         //             })
            //         //         }
            //         //         return return_data;
            //         // },
            //         success:function(data){
            //             console.log(data);
            //         }
            //     }//,
            //     // columns : [
            //     //     {"data" : "id"},
            //     //     {"data" : "kat_id"},
            //     //     {"data" : "nama_kat"},
            //     //     {"data" : "harga"},
            //     //     {"data" : "last_update_timestamp"},
            //     // ]
            // });
        });
    });
}) (jQuery);