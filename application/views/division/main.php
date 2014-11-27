            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <button id="da-division-create-dialog" class="btn btn-success btn-create">[+] Tambah Divisi</button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Divisi Tukang
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
                                    <table id="da-division-datatable-numberpaging" class="da-table"">
                                        <thead>
                                            <tr>
                                                <th>Kode Divisi</th>
                                                <th>Nama Divisi</th>
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
                                            <?php foreach($divisions as $each_division): ?>
                                                <tr>
                                                    <td class="code-row"><?php echo $each_division['division_code']; ?></td>
                                                    <td class="name-row"><?php echo $each_division['name']; ?></td>
                                                    <td class="notes-row"><?php echo $each_division['notes']; ?></td>
                                                    <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                        <td class="da-icon-column">
                                                            <?php if(isset($access['edit']) && $access['edit']): ?>
                                                                <a class="da-division-edit-dialog" href="#" data-value="<?php echo $each_division['id']; ?>"><i class="icol-pencil"></i></a>
                                                            <?php endif; ?>
                                                            <?php if(isset($access['delete']) && $access['delete']):
                                                                $division_id = $each_division['id'];
                                                                $delete_url = "/division/delete_division/" . $division_id;
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

                    <div id="da-division-create-form-div" class="form-container">
                        <form id="da-division-create-form-val" class="da-form" action="/division/create_division" method="post">
                            <div id="da-division-create-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Kode Divisi</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="division_code">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Divisi</label>
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

                    <div id="da-division-edit-form-div" class="form-container">
                        <form id="da-division-edit-form-val" class="da-form" action="/division/update_division" method="post">
                            <div id="da-division-edit-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Kode Divisi</label>
                                    <div class="da-form-item large">
                                        <input id="division-edit-code" type="text" name="division_code" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Divisi</label>
                                    <div class="da-form-item large">
                                        <input id="division-edit-name" type="text" name="name" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Keterangan</label>
                                    <div class="da-form-item large">
                                        <input id="division-edit-notes" type="text" name="notes">
                                    </div>
                                </div>
                                <input id="division-edit-id" type="hidden" name="id">
                            </div>
                        </form>
                    </div>
                </div>
            </div>