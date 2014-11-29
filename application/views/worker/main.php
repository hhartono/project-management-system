            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <button id="da-worker-create-dialog" class="btn btn-success btn-create">[+] Tambah Tukang</button>
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
                                    <table id="da-worker-datatable-numberpaging" class="da-table"">
                                        <thead>
                                            <tr>
                                                <th>Kode Tukang</th>
                                                <th>Nama Tukang</th>
                                                <th>Divisi Tukang</th>
                                                <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
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
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($workers as $each_worker): ?>
                                                <tr>
                                                    <td class="code-row"><?php echo $each_worker['worker_code']; ?></td>
                                                    <td class="name-row"><?php echo $each_worker['name']; ?></td>
                                                    <td class="division-row"><?php echo $each_worker['division']; ?></td>
                                                    <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                        <td class="da-icon-column">
                                                            <a class="da-worker-view-dialog" href="#" data-value="<?php echo $each_worker['id']; ?>"><i class="icol-eye"></i></a>
                                                            <?php if(isset($access['edit']) && $access['edit']): ?>
                                                                <a class="da-worker-edit-dialog" href="#" data-value="<?php echo $each_worker['id']; ?>"><i class="icol-pencil"></i></a>
                                                            <?php endif; ?>
                                                            <?php if(isset($access['delete']) && $access['delete']):
                                                                $worker_id = $each_worker['id'];
                                                                $delete_url = "/worker/delete_worker/" . $worker_id;
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

                    <div id="da-worker-view-form-div" class="form-container">
                        <form id="da-worker-edit-form-val" class="da-form" method="post">
                            <div id="da-worker-view-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Kode Tukang</label>
                                    <div class="da-form-item large">
                                        <input id="worker-view-worker-code" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Tukang</label>
                                    <div class="da-form-item large">
                                        <input id="worker-view-name" type="text" name="name" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Divisi Tukang</label>
                                    <div class="da-form-item large">
                                        <select id="worker-view-division" name="division_id" disabled></select>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Alamat</label>
                                    <div class="da-form-item large">
                                        <input id="worker-view-address" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 1</label>
                                    <div class="da-form-item large">
                                        <input id="worker-view-phone-1" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 2</label>
                                    <div class="da-form-item large">
                                        <input id="worker-view-phone-2" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Tanggal Masuk</label>
                                    <div class="da-form-item large">
                                        <input id="worker-view-join-date" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Gaji</label>
                                    <div class="da-form-item large">
                                        <input id="worker-view-salary" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Keterangan</label>
                                    <div class="da-form-item large">
                                        <input id="worker-view-notes" type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="da-worker-create-form-div" class="form-container">
                        <form id="da-worker-create-form-val" class="da-form" action="/worker/create_worker" method="post">
                            <div id="da-worker-create-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Tukang</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="name">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Divisi Tukang</label>
                                    <div class="da-form-item large">
                                        <select id="worker-create-division" name="division_id"></select>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Alamat</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="address">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 1</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="phone_number_1">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 2</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="phone_number_2">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Tanggal Masuk</label>
                                    <div class="da-form-item large">
                                        <input id="worker-create-join-date" type="text" name="join_date">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Gaji</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="salary">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Keterangan</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="notes">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="da-worker-edit-form-div" class="form-container">
                        <form id="da-worker-edit-form-val" class="da-form" action="/worker/update_worker" method="post">
                            <div id="da-worker-edit-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Kode Tukang</label>
                                    <div class="da-form-item large">
                                        <input id="worker-edit-worker-code" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Tukang</label>
                                    <div class="da-form-item large">
                                        <input id="worker-edit-name" type="text" name="name" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Divisi Tukang</label>
                                    <div class="da-form-item large">
                                        <select id="worker-edit-division" name="division_id" disabled></select>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Alamat</label>
                                    <div class="da-form-item large">
                                        <input id="worker-edit-address" type="text" name="address">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 1</label>
                                    <div class="da-form-item large">
                                        <input id="worker-edit-phone-1" type="text" name="phone_number_1">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Telepon 2</label>
                                    <div class="da-form-item large">
                                        <input id="worker-edit-phone-2" type="text" name="phone_number_2">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Tanggal Masuk</label>
                                    <div class="da-form-item large">
                                        <input id="worker-edit-join-date" type="text" name="join_date">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Gaji</label>
                                    <div class="da-form-item large">
                                        <input id="worker-edit-salary" type="text" name="salary">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Keterangan</label>
                                    <div class="da-form-item large">
                                        <input id="worker-edit-notes" type="text" name="notes">
                                    </div>
                                </div>
                                <input id="worker-edit-id" type="hidden" name="id">
                            </div>
                        </form>
                    </div>
                </div>
            </div>