            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Print Barcode Label
                                    </span>
                                </div>
                                <?php if(isset($message['success'])): ?>
                                   <div class="da-message success"><?php echo $message['success']; ?></div>
                                <?php endif; ?>
                                <?php if(isset($message['info'])): ?>
                                    <div class="da-message info"><?php echo $message['info']; ?></div>
                                <?php endif; ?>
                                <?php if(isset($message['error'])): ?>
                                    <div class="da-message error"><?php echo $message['error']; ?></div>
                                <?php endif; ?>
                                <div class="da-panel-content da-table-container">
                                    <table id="da-stock-barcode-print-datatable-numberpaging" class="da-table"">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Barang Diterima</th>
                                                <th>Jumlah Label</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($barcode_details as $each_barcode_detail): ?>
                                                <tr>
                                                    <td class="name-row" name="label_name"><?php echo $each_barcode_detail['item_name']; ?></td>
                                                    <td class="quantiy-row" name="item_quantity"><?php echo $each_barcode_detail['item_count']; ?></td>
                                                    <td class="label-quantity-row" name="label_quantity">
                                                        <input name="label_quantity_input" type="text" class="span12" value="<?php echo ($each_barcode_detail['item_count']); ?>">
                                                    </td>
                                                </tr>
                                            <?php endforeach?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4" style="float: right;">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Detail Barcode
                                    </span>
                                </div>
                                <div id="da-stock-barcode-print-detail-error" class="da-message error" style="display:none;"></div>
                                <div class="da-panel-content da-form-container">
                                    <form id="da-stock-barcode-print-detail-form-val" class="da-form da-form-inline" action="<?php echo '/stock/print_item_barcodes/' . $id; ?>" method="post">
                                        <div class="da-form-row" style="text-align:center;">
                                            <input id="da-stock-barcode-print-submit-item-values" type="hidden" name="barcode_print_item_values">
                                            <button id="da-stock-barcode-print-submit" class="btn btn-success">Lanjutkan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>