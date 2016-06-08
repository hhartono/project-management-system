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
                                <div id="da-returnsupplier-insert-error" class="da-message error" style="display:none;"></div>
                                <div class="da-panel-content da-form-container">
                                    <form id="da-returnsupplier-insert-form-val" class="da-form da-form-inline" method="post">
                                        <div class="da-form-row">
                                            <label class="da-form-label">Kode Barang</label>
                                            <div class="da-form-item large">
                                                <input id="returnsupplier-insert-code" class="span12" type="text" name="item_stock_code">
                                            </div>
                                        </div>
                                        <div class="da-form-row" style="text-align:center;">
                                            <button id="da-returnsupplier-insert-add" class="btn btn-success">Tambah Barang</button>
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
                                <div id="da-returnsupplier-table-error" class="da-message error" style="display:none;"></div>
                                <div class="da-panel-content da-table-container">
                                    <table id="da-returnsupplier-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Stok</th>
                                                <th>Jumlah Return</th>
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

                                <div id="da-returnsupplier-detail-error" class="da-message error" style="display:none;"></div>
                                <div class="da-panel-content da-form-container">
                                    <form id="da-returnsupplier-detail-form-val" class="da-form da-form-inline" action="/returnsupplier/submit_item_values" method="post">
                                        <input type="hidden" value="<?php echo $userid; ?>" name="user">
                                        <div class="da-form-row">
                                            <label class="da-form-label">Nama Supplier</label>
                                            <div class="da-form-item large">
                                                <input id="returnsupplier-create-supplier" type="text" name="supplier">
                                            </div>
                                        </div>
                                        <div class="da-form-row" style="text-align:center;">
                                            <input id="da-returnsupplier-submit-item-values" type="hidden" name="returnsupplier_item_values">
                                            <button id="da-returnsupplier-submit" class="btn btn-success">Kembalikan Barang</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>