<!-- Main Content Wrapper -->
<div id="da-content-wrap" class="clearfix">
    <!-- Content Area -->
    <div id="da-content-area">
        <div class="row-fluid">
            <div class="span12">
                <div class="da-panel">
                    <div class="da-panel-header">
                        <span class="da-panel-title">
                            <i class="icol-grid"></i> Terima Barang Press
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
                        <table id="da-kirimpress-receive-datatable-numberpaging" class="da-table">
                            <thead>
                                <tr>
                                    <th>Database ID</th>
                                    <th>Bahan Dasar</th>
                                    <th>Sisi 1</th>
                                    <th>Sisi 2</th>
                                    <th>Jumlah Dikirim</th>
                                    <th>Jumlah Sudah Diterima</th>
                                    <th>Jumlah Baru Diterima</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($press as $press): ?>
                                    <tr>
                                        <td class="database-id-row" name="press_id"><?php echo $press['id']; ?></td>
                                        <td class="database-id" name="bahan_dasar"><?php echo $press['bahan_dasar']; ?></td>
                                        <td class="database-id-row" name="sisi1"><?php echo $press['sisi1']; ?></td>
                                        <td class="name-row" name="sisi2"><?php echo $press['sisi2']; ?></td>
                                        <td class="quantity-order-row" name="quantity_ordered"><?php echo $press['jumlah']; ?></td>
                                        <td class="quantity-already-received-row" name="quantity_already_received"><?php echo $press['jumlah_diterima']; ?></td>
                                        <td class="quantity-received-row" name="quantity_received">
                                            <?php if($press['jumlah'] > $press['jumlah_diterima']){ ?>
                                                <input name="quantity_received_input" type="text" class="span6" value="<?php echo ($press['jumlah'] - $press['jumlah_diterima']); ?>">&nbsp; 
                                            <?php }else{
                                                echo "Sudah Diterima";
                                            } ?>
                                        </td>
                                    </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                        <div class="da-panel-content da-form-container">
                        <form id="da-kirimpress-receive-detail-form-val" class="da-form da-form-inline" action="<?php echo '/kirimpress/receive_submit/' . $receive_press; ?>" method="post">
                            <div class="da-form-row" style="text-align:center;">
                                <input id="da-kirimpress-receive-submit-item-values" type="hidden" name="received_item_values">
                                <input type="hidden" name="cat" value="<?php echo $catpress['id']; ?>">
                                <button id="da-kirimpress-receive-submit" class="btn btn-success">Terima Barang</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>