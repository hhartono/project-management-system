            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <div class="row-fluid">
                        <div class="span5">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Input Pesanan
                                    </span>
                                </div>
                                <div id="da-createpo-insert-error" class="da-message error" style="display:none;"></div>
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
                                                <label for="createpo-insert-item-count" id="createpo-insert-item-count-label"></label>
                                            </div>
                                        </div>
                                        <div class="da-form-row">
                                            <label class="da-form-label">Keterangan</label>
                                            <div class="da-form-item large">
                                                <input id="createpo-insert-notes" type="text" name="notes" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="da-form-row" style="text-align:center;">
                                            <button id="da-createpo-insert-add" class="btn btn-success">Tambah Barang</button>
                                            <button id="da-createpo-insert-clear" class="btn btn-danger">Hapus Input</button>
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
                                <div id="da-createpo-table-error" class="da-message error" style="display:none;"></div>
                                <div class="da-panel-content da-table-container">
                                    <table id="da-createpo-datatable-numberpaging" class="da-table"">
                                        <thead>
                                            <tr>
                                                <th>Database ID</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Barang</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <!--
                                <form id="da-createpo-submit-form-val" class="da-form da-form-inline" action="/createpo/submit_item_values" method="post">
                                    <div style="padding:20px; text-align:center;">
                                        <input id="da-createpo-submit-item-values" type="hidden" name="po_item_values">
                                        <button id="da-createpo-submit" class="btn-large btn btn-success">Buat PO</button>
                                    </div>
                                </form>
                                -->
                            </div>
                        </div>
                        <div class="span7">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Detail Pesanan
                                    </span>
                                </div>

                                <div id="da-createpo-detail-error" class="da-message error" style="display:none;"></div>
                                <div class="da-panel-content da-form-container">
                                    <form id="da-createpo-detail-form-val" class="da-form da-form-inline" action="/createpo/submit_item_values" method="post">
                                        <div class="da-form-row">
                                            <label class="da-form-label">Nama Supplier</label>
                                            <div class="da-form-item large">
                                                <input id="createpo-detail-supplier" type="text" name="supplier">
                                            </div>
                                        </div>
                                        <div class="da-form-row">
                                            <label class="da-form-label">Nama Customer</label>
                                            <div class="da-form-item large">
                                                <input id="createpo-detail-customer" type="text" name="customer">
                                            </div>
                                        </div>
                                        <div class="da-form-row" style="text-align:center;">
                                            <input id="da-createpo-submit-item-values" type="hidden" name="po_item_values">
                                            <button id="da-createpo-submit" class="btn btn-success">Buat PO</button>
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