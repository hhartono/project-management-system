(function($) {
    $(document).ready(function(e) {
        /*
         Modal Controller for Viewing
         */
        $("#da-projectdetail-view-form-div").dialog({
            autoOpen: false,
            title: "Lihat Project Detail",
            modal: true,
            width: "640",
            buttons: [{
                text: "Keluar",
                click: function() {
                    location.reload();
                    $("#da-projectdetail-view-form-div").dialog("option", {modal: true}).dialog("close");

                }}]
        });

        $(".da-projectdetail-view-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-projectdetail-view-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            var stock_id = $(this).data("stock");
            var namabarang = $(this).data("namabarang");
            $("#judul").html(namabarang);
            $.getJSON("/projectdetail/get_project_detail_usage/"+ id + "/" + stock_id, function(data) {
                var table = $("#table");
                $.each(data, function(index, element) {
                    if(element.quantity < 0){
                        table.append('<tr style=background:#FF69B4;> <td>'+ element.tanggal +'</td> <td>'+ element.quantity+'</td> <td>'+element.satuan+'</td> <td>'+ element.harga +' </td> <td>'+ element.tukang +' </td></tr>');
                    }else{
                        table.append('<tr> <td>'+ element.tanggal +'</td> <td>'+ element.quantity+'</td> <td>'+element.satuan+'</td> <td>'+ element.harga +' </td> <td>'+ element.tukang +' </td></tr>');
                    
                    }
                    /*$("#projectdetail-view-category").append(element.category);
                    $("#projectdetail-view-item").append(element.barang);
                    $("#projectdetail-view-quantity").append(element.quantity);
                    $("#projectdetail-view-satuan").append(element.satuan);*/
                });
                
            });
        });

        
        $("#da-projectdetail2-view-form-div").dialog({
            autoOpen: false,
            title: "Lihat Project Detail",
            modal: true,
            width: "640",
            buttons: [{
                text: "Keluar",
                click: function() {
                    location.reload();
                    $("#da-projectdetail2-view-form-div").dialog("option", {modal: true}).dialog("close");

                }}]
        });

        $(".da-projectdetail2-view-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-projectdetail2-view-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            var stock_id = $(this).data("stock");
            var namabarang = $(this).data("namabarang");
            $("#judul2").html(namabarang);
            $.getJSON("/projectdetail/get_project_detail_usage2/"+ id + "/" + stock_id, function(data) {
                var table2 = $("#table2");
                $.each(data, function(index, element) {
                    if(element.quantity < 0){
                        table2.append('<tr style=background:#FF69B4;> <td>'+ element.tanggal +'</td> <td>'+ element.quantity+'</td> <td>'+element.satuan+'</td> <td>'+ element.harga +' </td> <td>'+ element.tukang +' </td></tr>');
                    }else{
                        table2.append('<tr> <td>'+ element.tanggal +'</td> <td>'+ element.quantity+'</td> <td>'+element.satuan+'</td> <td>'+ element.harga +' </td> <td>'+ element.tukang +' </td></tr>');
                    
                    }
                    /*$("#projectdetail-view-category").append(element.category);
                    $("#projectdetail-view-item").append(element.barang);
                    $("#projectdetail-view-quantity").append(element.quantity);
                    $("#projectdetail-view-satuan").append(element.satuan);*/
                });
                
            });
        });

        $("#da-press-view-form-div").dialog({
            autoOpen: false,
            title: "Lihat Project Detail Press",
            modal: true,
            width: "640",
            buttons: [{
                text: "Keluar",
                click: function() {
                    location.reload();
                    $("#da-press-view-form-div").dialog("option", {modal: true}).dialog("close");

                }}]
        });

        $(".da-press-view-dialog").bind("click", function(event) {
            event.preventDefault();
            $("#da-press-view-form-div").dialog("option", {modal: true}).dialog("open");

            var id = $(this).data("value");
            var stock_id = $(this).data("stock");
            var namabarang = $(this).data("namabarang");
            $("#judul3").html(namabarang);
            $.getJSON("/projectdetail/get_project_detail_press_usage/"+ id + "/" + stock_id, function(data) {
                var table3 = $("#table3");
                $.each(data, function(index, element) {
                    if(element.quantity < 0){
                        table3.append('<tr style=background:#FF69B4;> <td>'+ element.tanggal +'</td> <td>'+ element.quantity+'</td> <td>'+element.satuan+'</td> <td>'+ element.tukang +' </td></tr>');
                    }else{
                        table3.append('<tr> <td>'+ element.tanggal +'</td> <td>'+ element.quantity+'</td> <td>'+element.satuan+'</td> <td>'+ element.tukang +' </td></tr>');
                    
                    }
                    /*$("#projectdetail-view-category").append(element.category);
                    $("#projectdetail-view-item").append(element.barang);
                    $("#projectdetail-view-quantity").append(element.quantity);
                    $("#projectdetail-view-satuan").append(element.satuan);*/
                });
                
            });
        });
    });
}) (jQuery);