(function($) {
    $(document).ready(function(e) {
        //home's controller send the id of list clicked        
        // $('ul#menu li').click(function(e){
        //     var id = this.id;
        //     // var element = document.getElementById(id);
        //     // element.classList.add("active");
        //     $.ajax({
        //         type:'post',
        //         url:'/'+id+'/get_li_id'+id,
        //         dataType:'json',
        //         success:function(data){
        //             console.log(data);
        //         }
        //     });
        //     // console.log(this.id);
        // });

        var element = document.getElementById('home');
        element.classList.add("active");

        $('#nav-home').addClass('active');
        $('#nav-menu').remove();
        $('#nav-submenu').remove();
    });
}) (jQuery);