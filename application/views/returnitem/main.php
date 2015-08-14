            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <div class="row-fluid">
                        <div class="span5">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Input Pengembalian
                                    </span>
                                </div>
                                <div id="da-returnitem-insert-error" class="da-message error" style="display:none;"></div>
                                <div class="da-panel-content da-form-container">
                                    <form id="da-returnitem-insert-form-val" class="da-form da-form-inline" method="post">
                                        <div class="da-form-row">
                                            <label class="da-form-label">Kode Barang</label>
                                            <div class="da-form-item large">
                                                <input id="returnitem-insert-code" class="span12" type="text" name="item_stock_code">
                                            </div>
                                        </div>
                                        <div class="da-form-row" style="text-align:center;">
                                            <button id="da-returnitem-insert-add" class="btn btn-success">Tambah Barang</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="span7">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Preview Pengembalian Barang
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
                                <div id="da-returnitem-table-error" class="da-message error" style="display:none;"></div>
                                <div class="da-panel-content da-table-container">
                                    <table id="da-returnitem-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Stok</th>
                                                <th>Jumlah Return</th>
                                                <th>Satuan Barang</th>
                                                <th>Database ID</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="span7" style="float: right;">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Detail Pengembalian
                                    </span>
                                </div>

                                <div id="da-returnitem-detail-error" class="da-message error" style="display:none;"></div>
                                <div class="da-panel-content da-form-container">
                                    <form id="da-returnitem-detail-form-val" class="da-form da-form-inline" action="/returnitem/submit_item_values" method="post">
                                        <div class="da-form-row">
                                            <label class="da-form-label">Nama Project</label>
                                            <div class="da-form-item large">
                                                <select name="project" id="project_id">
                                                    <option value="">--- Pilih Project---</option>
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
                                        <div class="da-form-row">
                                            <label class="da-form-label">Nama Tukang</label>
                                            <div class="da-form-item large">
                                                <input id="returnitem-create-worker" type="text" name="worker">
                                            </div>
                                        </div>
                                        <input type="hidden" value="<?php echo $userid; ?>" name="user">
                                        <div class="da-form-row" style="text-align:center;">
                                            <input id="da-returnitem-submit-item-values" type="hidden" name="returnitem_item_values">
                                            <button id="da-returnitem-submit" class="btn btn-success">Kembalikan Barang</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>