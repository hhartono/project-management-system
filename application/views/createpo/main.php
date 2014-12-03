            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php //if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <button id="da-createpo-create-dialog" class="btn btn-success btn-create">[+] Tambah Barang</button>
                            </div>
                        </div>
                    <?php //endif; ?>
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Input Pesanan
                                    </span>
                                </div>
                                <div class="da-panel-content da-form-container">
                                    <form id="da-createpo-insert-form-val" class="da-form da-form-inline" method="post">
                                        <div class="da-form-row">
                                            <label class="da-form-label">Nama Barang</label>
                                            <div class="da-form-item large">
                                                <input id="createpo-insert-name" type="text" name="name">
                                            </div>
                                        </div>
                                        <div class="da-form-row">
                                            <label class="da-form-label">Jumlah Barang</label>
                                            <div class="da-form-item large">
                                                <input id="createpo-insert-item-count" type="text" name="item_count" autocomplete="off">
                                                <label for="createpo-insert-item-count">(satuan)</label>
                                            </div>
                                        </div>
                                        <div class="da-form-row">
                                            <label class="da-form-label">Keterangan</label>
                                            <div class="da-form-item large">
                                                <input id="createpo-insert-notes" type="text" name="notes" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="da-form-row" style="display: block; margin: auto;">
                                            <button id="da-createpo-insert-add" class="btn btn-success">Tambah Barang</button>
                                            <button id="da-createpo-insert-clear" class="btn btn-info">Hapus</button>
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
                        <div class="span6">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Pesanan
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
                                    <table id="da-createpo-datatable-numberpaging" class="da-table"">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Barang</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                    </table>
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