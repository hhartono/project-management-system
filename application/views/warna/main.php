            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                            <div class="span12" >
                                <button id="da-warna-create-dialog" class="btn btn-success btn-create">[+] Tambah Warna</button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Warna
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
                                    <table id="da-warna-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th>Warna</th>
                                                <th>Kode Warna</th>
                                                <th>Nama Warna</th>
                                                <th>Kode Pantone</th>
                                                <th>Hexadecimal</th>
                                                <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                    <?php
                                                        $control_label_array = array();

                                                        if(isset($access['delete']) && $access['delete']){
                                                            $control_label_array[] = "Hapus";
                                                        }
                                                    ?>
                                                    <th><?php echo implode('/', $control_label_array); ?></th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($warnas as $each_warna): ?>
                                                <tr>
                                                    <td bgcolor="<?php echo $each_warna['hexadecimal'];?>"></td>
                                                    <td class="customer-name-row"><?php echo $each_warna['kode_warna']; ?></td>
                                                    <td class="company-name-row"><?php echo $each_warna['nama_warna']; ?></td>
                                                    <td class="address-row"><?php echo $each_warna['kode_pantone']; ?></td>
                                                    <td class="start-date-row"><?php echo $each_warna['hexadecimal']; ?></td>
                                                    <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                        <td class="da-icon-column">
                                                            
                                                            <?php if(isset($access['delete']) && $access['delete']):
                                                                $warna_id = $each_warna['id'];
                                                                $delete_url = "/warna/delete_warna/" . $warna_id;
                                                                $view_url = "/warna/view_warna/". $warna_id;
                                                            ?>
                                                                <a href=<?php echo $view_url; ?>><i class="icol-eye"></i></a>
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

                    <div id="da-warna-create-form-div" class="form-container">
                        <form id="da-warna-create-form-val" class="da-form" action="/warna/create_warna" method="post">
                            <div id="da-warna-create-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Kode Warna</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="kode_warna" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Warna</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="nama_warna">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Kode Pantone</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="kode_pantone">
                                    </div>
                                </div>
                                <!-- <div class="da-form-row">
                                    <label class="da-form-label">Hexadecimal</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="hexadecimal" autocomplete="off">
                                    </div>
                                </div> -->
                            </div>
                        </form>
                    </div>

                    <div id="da-warna-edit-form-div" class="form-container">
                        <form id="da-warna-edit-form-val" class="da-form" action="/warna/update_warna" method="post">
                            <div id="da-warna-edit-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Kode Warna</label>
                                    <div class="da-form-item large">
                                        <input id="warna-edit-kode-warna" type="text" name="kode_warna" >
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Warna</label>
                                    <div class="da-form-item large">
                                        <input id="warna-edit-nama-warna" type="text" name="nama_warna">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Kode Pantone</label>
                                    <div class="da-form-item large">
                                        <input id="warna-edit-kode-pantone" type="text" name="kode_pantone">
                                    </div>
                                </div>
                                <!-- <div class="da-form-row">
                                    <label class="da-form-label">Hexadecimal</label>
                                    <div class="da-form-item large">
                                        <input id="warna-edit-hexadecimal" type="text" name="hexadecimal">
                                    </div>
                                </div> -->
                                <input id="warna-edit-id" type="hidden" name="id">
                            </div>
                        </form>
                    </div>
                </div>
            </div>