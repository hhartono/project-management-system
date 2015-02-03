            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header" style="text-align:center;">
                                    <h4>System akan mencetak</h4>
                                    <h2><u><?php echo $total_barcode_quantity; ?> label</u></h2>
                                    <h4>Lanjutkan print?</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4" style="float: right;">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Confirmation Barcode
                                    </span>
                                </div>
                                <div id="da-purchaseorder-barcode-print-confirmation-detail-error" class="da-message error" style="display:none;"></div>
                                <div class="da-panel-content da-form-container">
                                    <form id="da-purchaseorder-barcode-print-confirmation-detail-form-val" class="da-form da-form-inline" action="" method="post">
                                        <div class="da-form-row" style="text-align:center;">
                                            <button id="da-purchaseorder-barcode-print-confirmation-submit" class="btn btn-success" onclick='javascript:doClientPrint();'>Print Label</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>