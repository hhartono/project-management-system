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
                                        <i class="icol-grid"></i> Supplier
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
                                                <?php
                                                    $control_label_array = array();
                                                    $control_label_array[] = "Lihat";

                                                    if(isset($access['edit']) && $access['edit']){
                                                        $control_label_array[] = "Ubah";
                                                    }

                                                    if(isset($access['delete']) && $access['delete']){
                                                        $control_label_array[] = "Hapus";
                                                    }
                                                ?>
                                                <th><?php echo implode('/', $control_label_array); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($suppliers as $each_supplier): ?>
                                                <tr>
                                                    <td class="name-row"><?php echo $each_supplier['name']; ?></td>
                                                    <?php
                                                        // aggreagate the address detail
                                                        $address_array = array();
                                                        if(!empty($each_supplier['address'])){
                                                            $address_array[] = $each_supplier['address'];
                                                        }

                                                        if(!empty($each_supplier['city'])){
                                                            $address_array[] = $each_supplier['city'];
                                                        }
                                                    ?>
                                                    <td class="address-row"><?php echo implode(', ', $address_array); ?></td>
                                                    <?php
                                                        // aggreagate the phone number
                                                        $phone_number_array = array();
                                                        if(!empty($each_supplier['phone_number_1'])){
                                                            $phone_number_array[] = $each_supplier['phone_number_1'];
                                                        }

                                                        if(!empty($each_supplier['phone_number_2'])){
                                                            $phone_number_array[] = $each_supplier['phone_number_2'];
                                                        }

                                                        if(!empty($each_supplier['phone_number_3'])){
                                                            $phone_number_array[] = $each_supplier['phone_number_3'];
                                                        }
                                                    ?>
                                                    <td class="phone-row"><?php echo implode(', ', $phone_number_array); ?></td>
                                                    <td class="da-icon-column">
                                                        <a class="da-supplier-view-dialog" href="#" data-value="<?php echo $each_supplier['id']; ?>"><i class="icol-eye"></i></a>
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
                                                </tr>
                                            <?php endforeach?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="da-supplier-view-form-div" class="form-container">
                        <form id="da-supplier-view-form-val" class="da-form" method="post">
                            <div id="da-supplier-view-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-view-name" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Alamat</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-view-address" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Kota</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-view-city" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Kode Pos</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-view-postal-code" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Provinsi</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-view-province" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 1</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-view-phone-1" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 2</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-view-phone-2" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 3</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-view-phone-3" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Fax</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-view-fax" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Email</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-view-email" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Website</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-view-website" type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="da-supplier-create-form-div" class="form-container">
                        <form id="da-supplier-create-form-val" class="da-form" action="/supplier/create_supplier" method="post">
                            <div id="da-supplier-create-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Alamat</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="address" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Kota</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="city" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Kode Pos</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="postal_code" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Provinsi</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="province" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 1</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="phone_number_1" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 2</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="phone_number_2" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 3</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="phone_number_3" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Fax</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="fax" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Email</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="email" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Website</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="website" autocomplete="off">
                                    </div>
                                </div>
                                <input type="hidden" value="<?php echo $userid; ?>" name="user">
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
                                        <input id="supplier-edit-address" type="text" name="address" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Kota</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-edit-city" type="text" name="city" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Kode Pos</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-edit-postal-code" type="text" name="postal_code" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Provinsi</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-edit-province" type="text" name="province" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 1</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-edit-phone-1" type="text" name="phone_number_1" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 2</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-edit-phone-2" type="text" name="phone_number_2" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 3</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-edit-phone-3" type="text" name="phone_number_3" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Fax</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-edit-fax" type="text" name="fax" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Email</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-edit-email" type="text" name="email" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Website</label>
                                    <div class="da-form-item large">
                                        <input id="supplier-edit-website" type="text" name="website" autocomplete="off">
                                    </div>
                                </div>
                                <input id="supplier-edit-id" type="hidden" name="id">
                            </div>
                        </form>
                    </div>
                </div>
            </div>