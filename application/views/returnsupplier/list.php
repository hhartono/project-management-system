            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                <?php if (isset($access['create']) && $access['create']): ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <form id="da-returnsuppliers-add-form-val" class="da-form" action="/returnsupplier/returnitem" method="get">
                                <button id="da-purchase-create-dialog" class="btn btn-success btn-create">[+] Buat Return Item</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Return Item
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
                                    <table id="da-returnsuppliers-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th>Kode Return Item</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Return</th>
                                                <th>Satuan</th>
                                                <th>Nama Supplier</th>
                                                    <?php
                                                        $control_label_array = array();
                                                        $control_label_array[] = "Lihat";
                                                    ?>
                                                    <th><?php echo implode('/', $control_label_array); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($returnsupplier as $each_returnsupplier): ?>
                                                <tr>
                                                    <td ><?php echo $each_returnsupplier['return_reference_number']; ?></td>
                                                    <td ><?php echo $each_returnsupplier['item']; ?></td>
                                                    <td ><?php echo $each_returnsupplier['kembali']; ?></td>
                                                    <td ><?php echo $each_returnsupplier['unit']; ?></td>
                                                    <td ><?php echo $each_returnsupplier['supplier']; ?></td>
                                                    <td >
                                                        <a href="<?php echo base_url(); ?>returnsupplier/detail/<?php echo $each_returnsupplier['id']; ?>"><i class="icol-eye"></i></a>
                                                    </td>
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