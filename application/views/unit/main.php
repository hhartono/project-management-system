            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <button id="da-unit-create-dialog" class="btn btn-success btn-create">[+] Tambah Satuan</button>
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
                                    <table id="da-unit-datatable-numberpaging" class="da-table"">
                                        <thead>
                                            <tr>
                                                <th>Kode Satuan</th>
                                                <th>Nama Satuan</th>
                                                <th>Keterangan</th>
                                                <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                    <?php
                                                        $control_label_array = array();
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
                                            <?php foreach($units as $each_unit): ?>
                                                <tr>
                                                    <td class="abbreviation-row"><?php echo $each_unit['abbreviation']; ?></td>
                                                    <td class="name-row"><?php echo $each_unit['name']; ?></td>
                                                    <td class="notes-row"><?php echo $each_unit['notes']; ?></td>
                                                    <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                        <td class="da-icon-column">
                                                            <?php if(isset($access['edit']) && $access['edit']): ?>
                                                                <a class="da-unit-edit-dialog" href="#" data-value="<?php echo $each_unit['id']; ?>"><i class="icol-pencil"></i></a>
                                                            <?php endif; ?>
                                                            <?php if(isset($access['delete']) && $access['delete']):
                                                                $unit_id = $each_unit['id'];
                                                                $delete_url = "/unit/delete_unit/" . $unit_id;
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

                    <div id="da-unit-create-form-div" class="form-container">
                        <form id="da-unit-create-form-val" class="da-form" action="/unit/create_unit" method="post">
                            <div id="da-unit-create-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Kode Satuan</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="abbreviation">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Satuan</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="name">
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

                    <div id="da-unit-edit-form-div" class="form-container">
                        <form id="da-unit-edit-form-val" class="da-form" action="/unit/update_unit" method="post">
                            <div id="da-unit-edit-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Kode Satuan</label>
                                    <div class="da-form-item large">
                                        <input id="unit-edit-abbreviation" type="text" name="abbreviation">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Satuan</label>
                                    <div class="da-form-item large">
                                        <input id="unit-edit-name" type="text" name="name">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Keterangan</label>
                                    <div class="da-form-item large">
                                        <input id="unit-edit-notes" type="text" name="notes">
                                    </div>
                                </div>
                                <input id="unit-edit-id" type="hidden" name="id">
                            </div>
                        </form>
                    </div>
                </div>
            </div>