        </div>
    </div>

    <!-- Footer -->
    <div id="da-footer">
        <div class="da-container clearfix">
            <p>Copyright 2014. Hans Hartono. All Rights Reserved.
        </div>
    </div>

    <!-- JS Libs -->
    <script src="/assets/js/libs/jquery-1.8.3.min.js"></script>
    <script src="/assets/js/libs/jquery.placeholder.min.js"></script>
    <script src="/assets/js/libs/jquery.mousewheel.min.js"></script>

    <!-- JS Bootstrap -->
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>

    <!-- jQuery-UI JavaScript Files --> <!-- TODO - please double check -->
    <script src="/assets/jui/js/jquery-ui-1.9.2.min.js"></script>
    <script src="/assets/jui/jquery.ui.timepicker.min.js"></script>
    <script src="/assets/jui/jquery.ui.touch-punch.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/jui/css/jquery.ui.all.css" media="screen">

    <!-- Validation Plugin -->
    <script src="/assets/js/plugins/validate/jquery.validate.min.js"></script>

    <!-- JS Plugins --> <!-- TODO - please double check -->
    <script src="/assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <!-- <script src="/assets/js/libs/jquery.autocomplete.js"></script> -->

    <!-- JS Demo -->

    <!-- JS Table -->
    <script src="/assets/js/custom/warna/image.modal.js"></script>
    <script src="/assets/js/custom/warna/warna.modal.js"></script>
    <script src="/assets/js/custom/warna/warna.tables.js"></script>

    <!-- JS Template -->
    <script src="/assets/js/core/dandelion.core.js"></script>

    <!-- JS Customizer -->
    <script src="/assets/js/core/dandelion.customizer.js"></script>

    <script src="/assets/dropzone/dropzone.js"></script>

    <script type="text/javascript" src="/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.lightbox-0.5.js"></script>

    <script type="text/javascript">
    $(function() {
        $('#gallery a').lightBox();
    });
    </script>

    <script type="text/javascript">
  $(document).ready(function(){
    var counter = 0;
    var mouseX = 0;
    var mouseY = 0;
    
    $("#imgtag img").click(function(e) { // make sure the image is click
      var imgtag = $(this).parent(); // get the div to append the tagging list
      mouseX = (e.pageX - $(imgtag).offset().left) - 50; // x and y axis
      mouseY = (e.pageY - $(imgtag).offset().top) - 50;
      $('#tagit').remove(); // remove any tagit div first
      $(imgtag).append('<div id="tagit"><div class="box"></div><div class="name"><div class="text">Type any name or tag</div><input type="text" name="txtname" id="tagname" /><input type="button" name="btnsave" value="Save" id="btnsave" /><input type="button" name="btncancel" value="Cancel" id="btncancel" /></div></div>');
      $.get("/warna/get_all_warna_pattern", function(data) {
                $( "#tagname" ).autocomplete({
                    source: data
                });
            }, "json" );
      $('#tagit').css({top:mouseY, left:mouseX});
      
      $('#tagname').focus();
    });
    
    // Save button click - save tags
    $(document).on('click', '#tagit #btnsave', function(){
      name = $('#tagname').val();
        var img = $('#imgtag').find('img');
        var id = $(img).attr('id');
      $.ajax({
        type: "POST", 
        url: "/warna/savetagimg", 
        data: "pic_id=" + id + "&name=" + name + "&pic_x=" + mouseX + "&pic_y=" + mouseY + "&type=insert",
        cache: true, 
        success: function(data){
          viewtag(id);
          $('#tagit').fadeOut();
        }
      });
      
    });
    
    // Cancel the tag box.
    $(document).on('click', '#tagit #btncancel', function(){
      $('#tagit').fadeOut();
    });
    
    // mouseover the taglist 
    $('#taglist').on('mouseover', 'li', function(){
      id = $(this).attr("id");
      $('#view_' + id).css({opacity: 1.0});
    }).on('mouseout', 'li', function(){
        $('#view_' + id).css({opacity: 0.0});
    });
    
    // mouseover the tagboxes that is already there but opacity is 0.
    $('#tagbox').on('mouseover', '.tagview', function(){
        var pos = $(this).position();
        $(this).css({opacity: 1.0}); // div appears when opacity is set to 1.
    }).on('mouseout', '.tagview', function( ) {
        $(this).css({opacity: 0.0}); // hide the div by setting opacity to 0.
    });

    /*$.get("/warna/get_all_warna_customer_names", function(data) {
                $( "#warna-create-customer" ).autocomplete({
                    source: data
                });
            }, "json" );*/
    
    // Remove tags.
    $('#taglist').on('click', '.remove', function() {
      id = $(this).parent().attr("id");
      // Remove the tag
      $.ajax({
        type: "POST", 
        url: "/warna/savetagimg", 
        data: "tag_id=" + id + "&type=remove",
        success: function(data){
            var img = $('#imgtag').find('img');
            var id = $(img).attr('id');
            //get tags if present
            viewtag(id);
        }
      });
    });
    
    // load the tags for the image when page loads.
    var img = $('#imgtag').find('img');
    var id = $(img).attr('id');
    
    viewtag(id); // view all tags available on page load
    
    function viewtag(pic_id)
    {
      // get the tag list with action remove and tag boxes and place it on the image.
      $.post("/warna/savetagimg/" , "pic_id=" + pic_id, function(data) {
        $('#taglist ol').html(data.lists);
         $('#tagbox').html(data.boxes);
      }, "json");
    
    }
    
    
  });
</script>

    <!-- <script type="text/javascript">
        $(document).ready(function(){
            $('#addPhotoModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var modal = $(this)
                modal.find('.modal-body input#idsubproject').attr("value", id)
            });
    
            $('#addPhotoModal').on('hidden.bs.modal',function(){
                location.reload();
            });
        })
    </script> -->
</body>
</html>