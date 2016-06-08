            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <div class="row-fluid">
                        <div class="span5">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Input Press
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
                                <div id="da-kirimpress-createpress-insert-error" class="da-message error" style="display:none;"></div>
                                <div class="da-panel-content da-form-container">
                                    <form action="/kirimpress/submit_press" class="da-form da-form-inline" method="post">
                                        <div class="da-form-row">
                                            <label class="da-form-label">Bahan Dasar</label>
                                            <div class="da-form-item large">
                                                <input id="kirimpress-createpress-insert-name" type="text" name="name" class="span12">
                                            </div>
                                        </div>
                                        <div class="da-form-row">
                                            <label class="da-form-label">Sisi 1</label>
                                            <div class="da-form-item large">
                                                <input id="kirimpress-createpress-insert-sisi1" type="text" name="sisi1" class="span12">
                                            </div>
                                        </div>
                                        <div class="da-form-row">
                                            <label class="da-form-label">Sisi 2</label>
                                            <div class="da-form-item large">
                                                <input id="kirimpress-createpress-insert-sisi2" type="text" name="sisi2" class="span12">
                                            </div>
                                        </div>
                                        <div class="da-form-row">
                                            <label class="da-form-label">Jumlah</label>
                                            <div class="da-form-item large">
                                                <input id="kirimpress-createpress-insert-jumlah" type="text" name="jumlah" class="span12">
                                            </div>
                                        </div>
                                        <div class="da-form-row" style="text-align:center;">
                                            <button id="da-kirimpress-createpress-insert-add" class="btn btn-success">Tambah Press Barang</button>
                                        </div>
                                    </form>
                                </div>
                                <!--
                                <div class="da-panel-toolbar">
                                    <div class="btn-toolbar">
                                        <div class="btn-group dropup">
                                            <a href="#" class="btn">
                                                <i class="icol-accept"></i>
                                                Tambah
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                -->
                            </div>
                        </div>
                        <div class="span7">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Preview Pesanan
                                    </span>
                                </div>
                                <div id="da-kirimpress-createpress-table-error" class="da-message error" style="display:none;"></div>
                                <div class="da-panel-content da-table-container">
                                    <table id="da-kirimpress-createpress-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th>Bahan Dasar</th>
                                                <th>Sisi 1</th>
                                                <th>Sisi 2</th>
                                                <th>Jumlah</th>
                                                <th>Hapus</th>
                                            </tr>
                                            <?php foreach ($press as $press) { ?>
                                            <tr>
                                                <td><?php echo $press['bahan_dasar']; ?></td>
                                                <td><?php echo $press['sisi1']; ?></td>
                                                <td><?php echo $press['sisi2']; ?></td>
                                                <td><?php echo $press['jumlah']; ?></td>
                                                <td>
                                                    <?php
                                                        $press_id = $press['id'];
                                                        $delete_url = "/kirimpress/delete_press_temp/" . $press_id;
                                                    ?>
                                                        <a href=<?php echo $delete_url; ?>><i class="icol-cross"></i></a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </thead>
                                    </table>
                                </div>
                                <!--
                                <form id="da-kirimpress-createpress-submit-form-val" class="da-form da-form-inline" action="/kirimpress/submit_item_values" method="post">
                                    <div style="padding:20px; text-align:center;">
                                        <input id="da-kirimpress-createpress-submit-item-values" type="hidden" name="po_item_values">
                                        <button id="da-kirimpress-createpress-submit" class="btn-large btn btn-success">Buat PO</button>
                                    </div>
                                </form>
                                -->
                            </div>
                        </div>
                        <div class="span7" style="float: right;">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Detail Pesanan
                                    </span>
                                </div>

                                <div id="da-kirimpress-createpress-detail-error" class="da-message error" style="display:none;"></div>
                                <div class="da-panel-content da-form-container">
                                    <form id="da-kirimpress-createpress-detail-form-val" class="da-form da-form-inline" action="/kirimpress/submit_kirim_press" method="post">
                                        
                                        <div class="da-form-row">
                                            <label class="da-form-label">Nama Project</label>
                                            <div class="da-form-item large">
                                                <select name="project" id="project_id">
                                                    <option value="">--- Pilih ---</option>
                                                    <?php
                                                    foreach ($project as $project) {
                                                        echo "<option value='$project[id]'>$project[name] </option> ";
                                                    }
                                                ?>   
                                                </select>    
                                            </div>
                                        </div>
                                        <div class="da-form-row">
                                            <label class="da-form-label">Nama Subproject</label>
                                            <div class="da-form-item large">
                                                <select name="subproject" id="subproject_id">
                                                    <option value="">--- Pilih Sub Project ---</option>   
                                                </select>    
                                            </div>
                                        </div>
                                        <input type="hidden" value="<?php echo $userid; ?>" name="user">
                                        <div class="da-form-row" style="text-align:center;">
                                            <input id="da-kirimpress-createpress-submit-item-values" type="hidden" name="po_item_values">
                                            <button id="da-kirimpress-createpress-submit" class="btn btn-success">Buat Press</button>
                                        </div>
                                    </form>
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