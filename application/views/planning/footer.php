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
    <script src="/assets/js/libs/chosen.jquery.min.js"></script>

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
    <script src="/assets/js/custom/worker/worker.modal.js"></script>
    <script src="/assets/js/custom/worker/worker.tables.js"></script>
    <script src="/assets/js/custom/planning/planning.tables.js"></script>
    <script src="/assets/js/custom/purchaseorder/purchaseorder.createpotables.js"></script>
    
    <script src="/assets/js/custom/absensi/absensi.tables.js"></script>

    <!-- JS Template -->
    <script src="/assets/js/core/dandelion.core.js"></script>

    <!-- JS Customizer -->
    <script src="/assets/js/core/dandelion.customizer.js"></script>

    <script>
    function getValSubproject(counter){
        var idproject = $('#idproject-'+counter).val();
        var idsubproject = $('#selectsub-'+counter).val();
        if(idsubproject==0){
            $('#view-'+counter).attr("href", "/planning/detail/"); 
        }else{
            $('#view-'+counter).attr("href", "/planning/detail/"+idproject+"/"+idsubproject);    
        }
        
    }
    $(document).ready(function(){
       
    })
        
    </script>
    <script>
            $(document).ready(function(){
                $('#finishing').chosen();
            });
    </script>
    <script>
            $(document).ready(function(){
                $('#finishing_belakang').chosen();
            });
    </script>
</body>
</html>