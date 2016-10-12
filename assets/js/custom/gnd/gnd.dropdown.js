(function($){
	$(document).ready(function(e){
		$('#doc_type').change(function(){
    		var value = $('#doc_type').val();
    		// $("#search_2").load('/intivo/get_parts_count', {'code':value});
            load('/gnd/get_parts_count', {'code':value});
		});
	});
}) (jQuery)
