            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Stok Barang Press
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
                                    <table id="da-purchaseorder-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th>Kode Barang</th>
                                                <th>Bahan Dasar</th>
                                                <th>Sisi 1</th>
                                                <th>Sisi 2</th>
                                                <th>Jumlah</th>
                                                <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                    <?php
                                                        $control_label_array = array();
                                                        if(isset($access['edit']) && $access['edit']){
                                                            $control_label_array[] = "Cetak";
                                                        }

                                                        if(isset($access['delete']) && $access['delete']){
                                                            $control_label_array[] = "Hapus";
                                                        }
                                                    ?>
                                                    <th><?php echo implode('/', $control_label_array); ?></th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($press as $each_press): ?>
                                                <tr>
                                                    <td class="stock-code-row"><?php echo $each_press['stock_press_code']; ?></td>
                                                    <td class="name-row"><?php echo $each_press['bahan_dasar']; ?></td>
                                                    <td class="count-row"><?php echo $each_press['sisi1']; ?></td>
                                                    <td class="unit-row"><?php echo $each_press['sisi2']; ?></td>
                                                    <td class="price-row"><?php echo $each_press['jumlah'];?>
                                                    </td>
                                                    <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                        <td class="da-icon-column">
                                                            <?php if(isset($access['delete']) && $access['delete']):
                                                                $stock_id = $each_press['id'];
                                                                $delete_url = "/stock/delete_stock/" . $stock_id;
                                                                ?>
                                                                <a href=<?php echo $delete_url; ?>><i class="icol-cross"></i></a>
                                                            <?php endif; ?>
                                                            <a class="da-stock" href="<?php echo base_url(); ?>kirimpress/print_item_barcodes/<?php echo $each_press['id']; ?>"><i class="icon-print"></i></a>
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
                </div>
            </div>