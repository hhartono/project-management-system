(function($){
	$(document).ready(function(e){
		$('#search_1').change(function(){
    		var value = $('#search_1').val();
    		$("#search_2").load('/intivo/get_parts_count', {'code':value});
		});

		$('#search_2').change(function(){
    		var code = $('#search_1').val();
    		var sum = $('#search_2').val();
    		$("#search_3").load('/intivo/get_parts_last', {'code':code, 'sum':sum});
    	});

        var element = document.getElementById('blum');
        element.classList.add("active");

        $('#nav-menu').empty();
        $('#nav-menu').html('<a href="#">Blum</a>');
        $('#nav-submenu').empty();
        $('#nav-submenu').html('<span>Intivo</span>');
        $('#nav-submenu').addClass('active');
	});
}) (jQuery)
