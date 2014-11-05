            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <button id="da-supplier-create-dialog" class="btn btn-success btn-create">[+] Tambah Supplier</button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Satuan
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
                                    <table id="da-supplier-datatable-numberpaging" class="da-table"">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Alamat</th>
                                                <th>Telepon</th>
                                                <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                    <th>Ubah/Hapus</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($suppliers as $each_supplier): ?>
                                                <tr>
                                                    <td class="name-row"><?php echo $each_supplier['name']; ?></td>
                                                    <td class="address-row"><?php echo $each_supplier['address']; ?></td>
                                                    <td class="phone-row"><?php echo $each_supplier['phone_number_1']; ?></td>
                                                    <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                        <td class="da-icon-column">
                                                            <?php if(isset($access['edit']) && $access['edit']): ?>
                                                                <a class="da-supplier-edit-dialog" href="#" data-value="<?php echo $each_supplier['id']; ?>"><i class="icol-pencil"></i></a>
                                                            <?php endif; ?>
                                                            <?php if(isset($access['delete']) && $access['delete']):
                                                                $supplier_id = $each_supplier['id'];
                                                                $delete_url = "/supplier/delete_supplier/" . $supplier_id;
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

                    <div id="da-supplier-create-form-div" class="form-container">
                        <form id="da-supplier-create-form-val" class="da-form" action="/supplier/create_supplier" method="post">
                            <div id="da-supplier-create-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="name">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Alamat</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="address">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="phone">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="da-supplier-edit-form-div" class="form-container">
                        <form id="da-supplier-edit-form-val" class="da-form" action="/supplier/update_supplier" method="post">
                            <div id="da-supplier-edit-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-edit-name" type="text" name="name">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Alamat</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-edit-address" type="text" name="address">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-edit-phone" type="text" name="phone">
                                    </div>
                                </div>
                                <input id="supplier-edit-id" type="hidden" name="id">
                            </div>
                        </form>
                    </div>
                </div>
            </div>