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
    <script src="/assets/js/custom/purchaseorder/purchaseorder.modal.js"></script>
    <script src="/assets/js/custom/purchaseorder/purchaseorder.tables.js"></script>
    <script src="/assets/js/custom/purchaseorder/purchaseorder.createpotables.js"></script>
    <script src="/assets/js/custom/kirimpress/kirimpress.receiveitemstables.js"></script>
    <script src="/assets/js/custom/kirimpress/kirimpress.printbarcodetables.js"></script>
    <script src="/assets/js/custom/kirimpress/kirimpress.createpress.js"></script>
    <script src="/assets/js/custom/purchaseorder/purchaseorder.printbarcodetables.js"></script>
    
    <!-- JS Barcode -->
    
<script>
    $(document).ready(function(){
        $("#project_id").change(function(){
            var project_id = $("#project_id").val();
                $.ajax({
                    type: "POST",
                    url : "<?php echo base_url(); ?>kirimpress/get_subproject",
                    data: "project_id=" + project_id, 
                        success: function(data){
                            $('#subproject_id').html(data);
                        }
                });
        });

    });
</script>
    <!-- JS Template -->
    <script src="/assets/js/core/dandelion.core.js"></script>

    <!-- JS Customizer -->
    <script src="/assets/js/core/dandelion.customizer.js"></script>
</body>
</html>