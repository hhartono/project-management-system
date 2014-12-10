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
                                    <table id="da-purchaseorder-receive-datatable-numberpaging" class="da-table"">
                                        <thead>
                                            <tr>
                                                <th>Database ID</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Dipesan</th>
                                                <th>Jumlah Sudah Diterima</th>
                                                <th>Jumlah Baru Diterima</th>
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
                                            <?php foreach($purchaseorder_details as $each_purchaseorder_detail): ?>
                                                <tr>
                                                    <td class="database-id-row" name="po_detail_id"><?php echo $each_purchaseorder_detail['id']; ?></td>
                                                    <td class="name-row" name="item_name"><?php echo $each_purchaseorder_detail['item_name']; ?></td>
                                                    <td class="quantity-order-row" name="quantity_ordered"><?php echo $each_purchaseorder_detail['quantity']; ?></td>
                                                    <td class="quantity-already-received-row" name="quantity_already_received"><?php echo $each_purchaseorder_detail['quantity_received']; ?></td>
                                                    <td class="quantity-received-row" name="quantity_received">
                                                        <?php if($each_purchaseorder_detail['quantity'] > $each_purchaseorder_detail['quantity_received']){ ?>
                                                            <input name="quantity_received_input" type="text" class="span3" value="<?php echo ($each_purchaseorder_detail['quantity'] - $each_purchaseorder_detail['quantity_received']); ?>">
                                                        <?php }else{
                                                            echo "Sudah Diterima";
                                                        } ?>
                                                    </td>
                                                    <td class="notes-row"><?php echo $each_purchaseorder_detail['notes']; ?></td>
                                                    <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                        <td class="da-icon-column">
                                                            <?php if(isset($access['delete']) && $access['delete']):
                                                                $po_detail_id = $each_purchaseorder_detail['id'];
                                                                $delete_url = "/purchaseorder/deletepo_detail/" . $po_detail_id;
                                                                ?>
                                                                <a href=<?php echo $delete_url; ?>><i class="icol-cross"></i></a>
                                                            <?php endif; ?>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span7" style="float: right;">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                        <span class="da-panel-title">
                                            <i class="icol-grid"></i> Detail Pesanan
                                        </span>
                                </div>

                                <div id="da-purchaseorder-receive-detail-error" class="da-message error" style="display:none;"></div>
                                <div class="da-panel-content da-form-container">
                                    <form id="da-purchaseorder-receive-detail-form-val" class="da-form da-form-inline" action="<?php echo '/purchaseorder/receive_po_items/' . $purchaseorder_main['id']; ?>" method="post">
                                        <div class="da-form-row">
                                            <label class="da-form-label">Nama Supplier</label>
                                            <div class="da-form-item large">
                                                <input id="purchaseorder-receive-detail-supplier" type="text" name="supplier" value="<?php echo $purchaseorder_main['supplier']; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="da-form-row">
                                            <label class="da-form-label">Nama Project</label>
                                            <div class="da-form-item large">
                                                <input id="purchaseorder-receive-detail-project" type="text" name="project" value="<?php echo $purchaseorder_main['project']; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="da-form-row" style="text-align:center;">
                                            <input id="da-purchaseorder-receive-submit-item-values" type="hidden" name="po_received_item_values">
                                            <button id="da-purchaseorder-receive-submit" class="btn btn-success">Terima Barang</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>