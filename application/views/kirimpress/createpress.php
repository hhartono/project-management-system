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
                                <div id="da-kirimpress-createpress-insert-error" class="da-message error" style="display:none;"></div>
                                <div class="da-panel-content da-form-container">
                                    <form id="da-kirimpress-createpress-insert-form-val" class="da-form da-form-inline" method="post">
                                        <div class="da-form-row">
                                            <label class="da-form-label">Bahan Dasar</label>
                                            <div class="da-form-item large">
                                                <input id="kirimpress-createpress-insert-name" type="text" name="name" class="span12">
                                            </div>
                                        </div>
                                        <div class="da-form-row">
                                            <label class="da-form-label">Sisi 1</label>
                                            <div class="da-form-item large">
                                                <input id="kirimpress-createpress-insert-item-count" type="text" name="item_count" autocomplete="off" class="span12">
                                                <label for="kirimpress-createpress-insert-item-count" id="kirimpress-createpress-insert-item-count-label"></label>
                                            </div>
                                        </div>
                                        <div class="da-form-row">
                                            <label class="da-form-label">Sisi 2</label>
                                            <div class="da-form-item large">
                                                <input id="kirimpress-createpress-insert-notes" type="text" name="notes" autocomplete="off" class="span12">
                                            </div>
                                        </div>
                                        <div class="da-form-row" style="text-align:center;">
                                            <button id="da-kirimpress-createpress-insert-add" class="btn btn-success">Tambah Barang</button>
                                            <button id="da-kirimpress-createpress-insert-clear" class="btn btn-danger">Hapus Input</button>
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
                                            </tr>
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
                                    <form id="da-kirimpress-createpress-detail-form-val" class="da-form da-form-inline" action="/kirimpress/submit_item_values" method="post">
                                        <div class="da-form-row">
                                            <label class="da-form-label">Nama Supplier</label>
                                            <div class="da-form-item large">
                                                <input id="kirimpress-createpress-detail-supplier" type="text" name="supplier">
                                            </div>
                                        </div>
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
                                            <button id="da-kirimpress-createpress-submit" class="btn btn-success">Buat PO</button>
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