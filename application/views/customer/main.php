            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <button id="da-customer-create-dialog" class="btn btn-success btn-create">[+] Tambah Customer</button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Customer
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
                                    <table id="da-customer-datatable-numberpaging" class="da-table"">
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
                                            <?php foreach($customers as $each_customer): ?>
                                                <tr>
                                                    <td class="name-row"><?php echo $each_customer['name']; ?></td>
                                                    <?php
                                                        // aggreagate the address detail
                                                        $address_array = array();
                                                        if(!empty($each_customer['address'])){
                                                            $address_array[] = $each_customer['address'];
                                                        }

                                                        if(!empty($each_customer['city'])){
                                                            $address_array[] = $each_customer['city'];
                                                        }
                                                    ?>
                                                    <td class="address-row"><?php echo implode(', ', $address_array); ?></td>
                                                    <?php
                                                        // aggreagate the phone number
                                                        $phone_number_array = array();
                                                        if(!empty($each_customer['phone_number_1'])){
                                                            $phone_number_array[] = $each_customer['phone_number_1'];
                                                        }

                                                        if(!empty($each_customer['phone_number_2'])){
                                                            $phone_number_array[] = $each_customer['phone_number_2'];
                                                        }

                                                        if(!empty($each_customer['phone_number_3'])){
                                                            $phone_number_array[] = $each_customer['phone_number_3'];
                                                        }
                                                    ?>
                                                    <td class="phone-row"><?php echo implode(', ', $phone_number_array); ?></td>
                                                    <td class="da-icon-column">
                                                        <a class="da-customer-view-dialog" href="#" data-value="<?php echo $each_customer['id']; ?>"><i class="icol-eye"></i></a>
                                                        <?php if(isset($access['edit']) && $access['edit']): ?>
                                                            <a class="da-customer-edit-dialog" href="#" data-value="<?php echo $each_customer['id']; ?>"><i class="icol-pencil"></i></a>
                                                        <?php endif; ?>
                                                        <?php if(isset($access['delete']) && $access['delete']):
                                                            $customer_id = $each_customer['id'];
                                                            $delete_url = "/customer/delete_customer/" . $customer_id;
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

                    <div id="da-customer-view-form-div" class="form-container">
                        <form id="da-customer-view-form-val" class="da-form" method="post">
                            <div id="da-customer-view-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama</label>
                                    <div class="da-form-item large">
                                        <input id="customer-view-name" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Alamat</label>
                                    <div class="da-form-item large">
                                        <input id="customer-view-address" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Kota</label>
                                    <div class="da-form-item large">
                                        <input id="customer-view-city" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Kode Pos</label>
                                    <div class="da-form-item large">
                                        <input id="customer-view-postal-code" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Provinsi</label>
                                    <div class="da-form-item large">
                                        <input id="customer-view-province" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 1</label>
                                    <div class="da-form-item large">
                                        <input id="customer-view-phone-1" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 2</label>
                                    <div class="da-form-item large">
                                        <input id="customer-view-phone-2" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 3</label>
                                    <div class="da-form-item large">
                                        <input id="customer-view-phone-3" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Fax</label>
                                    <div class="da-form-item large">
                                        <input id="customer-view-fax" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Email</label>
                                    <div class="da-form-item large">
                                        <input id="customer-view-email" type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="da-customer-create-form-div" class="form-container">
                        <form id="da-customer-create-form-val" class="da-form" action="/customer/create_customer" method="post">
                            <div id="da-customer-create-validate-error" class="da-message error" style="display:none;"></div>
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
                                <input type="hidden" value="<?php echo $userid; ?>" name="user">
                            </div>
                        </form>
                    </div>

                    <div id="da-customer-edit-form-div" class="form-container">
                        <form id="da-customer-edit-form-val" class="da-form" action="/customer/update_customer" method="post">
                            <div id="da-customer-edit-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama</label>
                                    <div class="da-form-item large">
                                        <input id="customer-edit-name" type="text" name="name">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Alamat</label>
                                    <div class="da-form-item large">
                                        <input id="customer-edit-address" type="text" name="address" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Kota</label>
                                    <div class="da-form-item large">
                                        <input id="customer-edit-city" type="text" name="city" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Kode Pos</label>
                                    <div class="da-form-item large">
                                        <input id="customer-edit-postal-code" type="text" name="postal_code" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Provinsi</label>
                                    <div class="da-form-item large">
                                        <input id="customer-edit-province" type="text" name="province" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 1</label>
                                    <div class="da-form-item large">
                                        <input id="customer-edit-phone-1" type="text" name="phone_number_1" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 2</label>
                                    <div class="da-form-item large">
                                        <input id="customer-edit-phone-2" type="text" name="phone_number_2" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 3</label>
                                    <div class="da-form-item large">
                                        <input id="customer-edit-phone-3" type="text" name="phone_number_3" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Fax</label>
                                    <div class="da-form-item large">
                                        <input id="customer-edit-fax" type="text" name="fax" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Email</label>
                                    <div class="da-form-item large">
                                        <input id="customer-edit-email" type="text" name="email" autocomplete="off">
                                    </div>
                                </div>
                                <input id="customer-edit-id" type="hidden" name="id">
                            </div>
                        </form>
                    </div>
                </div>
            </div>