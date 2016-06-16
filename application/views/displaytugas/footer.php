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

    <!-- JS Template -->
    <script src="/assets/js/core/dandelion.core.js"></script>

    <!-- JS Customizer -->
    <script src="/assets/js/core/dandelion.customizer.js"></script>

    <script type="text/javascript"> 
        $(document).ready(function(){
            $("#grup_id").change(function(){
                var grup_id = $("#grup_id").val();
                   $.ajax({
                       type: "POST",
                       url : "<?php echo base_url(); ?>displaytugas/time",
                       data: "grup_id=" + grup_id,
                       success: function(data){
                            $('#timeline').html(data);
                        }
                    });
            });
        });
    </script>

    <script type="text/javascript"> 
        $(document).ready(function(){
            $("#timeline").change(function(){
                var timeline = $("#timeline").val();
                   $.ajax({
                       type: "POST",
                       url : "<?php echo base_url(); ?>displaytugas/timeid",
                       data: "timeline=" + timeline,
                       success: function(data){
                            $('#timeid').html(data);
                        }
                    });
              });
        });
    </script>
</body>
</html>