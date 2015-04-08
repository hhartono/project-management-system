            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Terima Barang Pesanan
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
                                    <table id="da-purchaseorder-receiveprice-datatable-numberpaging" class="da-table"">
                                        <thead>
                                            <tr>
                                                <th>Database ID</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Dipesan</th>
                                                <th>Jumlah Sudah Diterima</th>
                                                <th>Harga per Unit</th>
                                                <th>Keterangan</th>
                                                <?php if ((isset($access['delete']) && $access['delete'])): ?>
                                                    <?php
                                                        $control_label_array = array();
                                                        if(isset($access['delete']) && $access['delete']){
                                                            $control_label_array[] = "Hapus";
                                                        }
                                                    ?>
                                                    <th><?php echo implode('/', $control_label_array); ?></th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <div id="da-purchaseorder-receive-detail-error" class="da-message error" style="display:none;"></div>
                                            <?php //foreach($purchaseorder_details as $each_purchaseorder_detail): ?>
                                                <div class="da-panel-content da-form-container">
                                    <form id="da-purchaseorder-receive-detail-form-val" class="da-form da-form-inline" action="/purchaseorder/update_itemprice" method="post">
                                <input type="hidden" name="id" value="<?php echo $purchaseorder_details->stockid; ?>">
                                                <tr>
                                                    <td class="database-id-row" name="po_detail_id"><?php echo $purchaseorder_details->po_id; ?></td>
                                                    <td class="name-row" name="item_name"><?php echo $purchaseorder_details->item_name; ?></td>
                                                    <td class="quantity-order-row" name="quantity_ordered"><?php echo $purchaseorder_details->quantity; ?></td>
                                                    <td class="quantity-already-received-row" name="quantity_already_received"><?php echo $purchaseorder_details->quantity_received; ?></td>
                                                    <td class="price-row" name="item_price">
                                                        <input name="item_price" type="text" class="span6" value="<?php echo $purchaseorder_details->item_price; ?>">                                                        
                                                    </td>
                                                    <td class="notes-row"><?php echo $purchaseorder_details->notes; ?></td>
                                                    
                                                </tr>
                                                
                                            <?php //endforeach?>
<input type="button" value="Update" class="btn btn-success">
                                            </form>
                                </div>                                
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>