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
                $("#category-edit-nama").val(data.nama);
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
                    $("#harga th").remove();
                    $("#harga tr").remove();
                    $("#da-category-view-form-div").dialog("option", {modal: true}).dialog("close");
                }}]
        });

        $(".da-category-view-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-category-view-form-div").dialog("option", {modal: true}).dialog("open");

            var kat_id = $(this).data('value');
            var x;
            $.ajax({
                type:'post',
                url:'/categoryrev/cek_history_harga/'+kat_id,
                dataType:'json',
                success:function(data){
                    var t = [];
                    for(x in data){
                        t.push({"harga":data[x]['harga'], "date":data[x]['creation_date']});
                    }

                    table = document.getElementById('harga');

                    thHarga = document.createElement('th');
                    thHarga.appendChild(document.createTextNode('Harga'));
                    thDate = document.createElement('th');
                    thDate.appendChild(document.createTextNode('Tanggal'));

                    table.appendChild(thHarga);
                    table.appendChild(thDate);

                    for (var i = 0; i < t.length; i++) {
                        row = document.createElement('tr');
                        for (var j = 0; j < 1; j++) {
                            col = document.createElement('td');
                            col.appendChild(document.createTextNode(t[i]['harga']));
                            row.appendChild(col);
                        }
                        for (var k = 0; k < 1; k++) {
                            col = document.createElement('td');
                            col.appendChild(document.createTextNode(t[i]['date']));
                            row.appendChild(col);
                        }
                        table.appendChild(row);
                    }
                }
            });
        });
    });
}) (jQuery);