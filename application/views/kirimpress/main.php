            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                <?php if (isset($access['create']) && $access['create']): ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <form id="da-purchaseorder-add-form-val" class="da-form" action="/kirimpress/createpress" method="get">
                                <button id="da-purchase-create-dialog" class="btn btn-success btn-create">[+] Buat Kirim Barang</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Kirim Press
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
                                                <th>Tanggal Kirim</th>
                                                <th>Kode Kirim Press</th>
                                                <th>Tanggal Terima Barang</th>
                                                <?php if ((isset($access['delete']) && $access['delete'])): ?>
                                                    <?php
                                                        $control_label_array = array();
                                                        $control_label_array[] = "Lihat";

                                                        if(isset($access['delete']) && $access['delete']){
                                                            $control_label_array[] = "Hapus";
                                                        }
                                                    ?>
                                                    <th><?php echo implode('/', $control_label_array); ?></th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($purchaseorders as $each_purchaseorder): ?>
                                                <tr>
                                                    <td class="input-date-sort-row"><?php echo $each_purchaseorder['sort_po_input_date']; ?></td>
                                                    <td class="code-row"><?php echo $each_purchaseorder['po_reference_number']; ?></td>
                                                    <td class="closed-status-row">
                                                        <?php
                                                            if(empty($each_purchaseorder['po_close_date'])){
                                                                // po still open
                                                                //$purchaseorder_id = $each_purchaseorder['id'];
                                                                $receive_url = "/purchaseorder/receive/";
                                                        ?>
                                                        <?php if (isset($access['receive']) && $access['receive']): ?>
                                                            <form id="da-purchaseorder-receive-form-val" class="da-form" action=<?php echo $receive_url; ?> method="post">
                                                                <button id="da-purchaseorder-receive" class="btn btn-success">Terima Barang</button>
                                                            </form>
                                                        <?php endif; ?>
                                                        <?php
                                                            }else{
                                                                echo $each_purchaseorder['po_close_date'];
                                                        ?>
                                                        <?php
                                                            }
                                                        ?>
                                                    </td>
                                                    <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                        <td class="da-icon-column">
                                                            <a class="da-purchaseorder-view-dialog" href="<?php echo base_url(); ?>purchaseorder/detail/<?php echo $each_purchaseorder['id']; ?>"><i class="icol-eye"></i></a>
                                                            <?php if(isset($access['delete']) && $access['delete']):
                                                                $po_id = $each_purchaseorder['id'];
                                                                $delete_url = "/purchaseorder/deletepo/" . $po_id;
                                                                ?>
                                                                <a href=<?php echo $delete_url; ?><i class="icol-cross"></i></a>
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

                </div>
            </div>