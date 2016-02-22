            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <div class="row-fluid">
                        <div class="span12">
                            <?php echo form_open_multipart('/purchaseorder/caribulan');?>
                            Bulan
                                <select name="bulan">
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            Tahun
                                <select name="tahun">
                            <?php
                                $mulai= date('Y') - 5;
                                for($i = $mulai;$i<$mulai + 10;$i++){
                                    $sel = $i == date('Y') ? ' selected="selected"' : '';
                                    echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>';
                                }
                            ?>
                                </select>
                                <input type="submit" value="Filter" class="btn btn-success"/>
                                </form>
                        </div>
                    </div>
                <?php if (isset($access['create']) && $access['create']): ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <form id="da-purchaseorder-add-form-val" class="da-form" action="/purchaseorder/createpo" method="get">
                                <button id="da-purchase-create-dialog" class="btn btn-success btn-create">[+] Buat Purchase Order</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Purchase Order
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
                                                <th>Tanggal Purchase Order</th>
                                                <th>Tanggal Purchase Order</th>
                                                <th>Kode Purchase Order</th>
                                                <th>Nama Supplier</th>
                                                <th>Nama Project</th>
                                                <th>Nama Sub Project</th>
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
                                                    <td class="input-date-row"><?php echo $each_purchaseorder['formatted_po_input_date']; ?></td>
                                                    <td class="code-row"><?php echo $each_purchaseorder['po_reference_number']; ?></td>
                                                    <td class="supplier-row"><?php echo $each_purchaseorder['supplier']; ?></td>
                                                    <td class="customer-row"><?php echo $each_purchaseorder['project']; ?></td>
                                                    <td class="customer-row"><?php echo $each_purchaseorder['subproject']; ?></td>
                                                    
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

                    <!--
                    <div id="da-unit-create-form-div" class="form-container">
                        <form id="da-unit-create-form-val" class="da-form" action="/unit/create_unit" method="post">
                            <div id="da-unit-create-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Kode Satuan</label>
                                    <div class="da-form-item large">
                                        <input id="unit-create-abbreviation" type="text" name="abbreviation" autocomplete="off" maxlength="5">
                                        <label for="unit-create-abbreviation">(max 5 karakter)</label>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Satuan</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Keterangan</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="notes" autocomplete="off">
                                    </div>
                                </div>
                                <input type="hidden" value="<?php echo $userid; ?>" name="user">
                            </div>
                        </form>
                    </div>
                    -->

                    <!--
                    <div id="da-unit-edit-form-div" class="form-container">
                        <form id="da-unit-edit-form-val" class="da-form" action="/unit/update_unit" method="post">
                            <div id="da-unit-edit-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Kode Satuan</label>
                                    <div class="da-form-item large">
                                        <input id="unit-edit-abbreviation" type="text" name="abbreviation" maxlength="5" readonly>
                                        <label for="unit-edit-abbreviation">(max 5 karakter)</label>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Satuan</label>
                                    <div class="da-form-item large">
                                        <input id="unit-edit-name" type="text" name="name" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Keterangan</label>
                                    <div class="da-form-item large">
                                        <input id="unit-edit-notes" type="text" name="notes" autocomplete="off">
                                    </div>
                                </div>
                                <input id="unit-edit-id" type="hidden" name="id">
                            </div>
                        </form>
                    </div>
                    -->
                </div>
            </div>