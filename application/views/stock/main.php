            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <button id="da-stock-create-dialog" class="btn btn-success btn-create">[+] Tambah Stok</button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Stok Barang
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
                                    <table id="da-stock-datatable-numberpaging" class="da-table"">
                                        <thead>
                                            <tr>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Barang</th>
                                                <th>Satuan Barang</th>
                                                <th>Harga Barang</th>
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
                                            <?php foreach($stocks as $each_stock): ?>
                                                <tr>
                                                    <td class="stock-code-row"><?php echo $each_stock['item_stock_code']; ?></td>
                                                    <td class="name-row"><?php echo $each_stock['name']; ?></td>
                                                    <td class="count-row"><?php echo $each_stock['item_count']; ?></td>
                                                    <td class="unit-row"><?php echo $each_stock['unit']; ?></td>
                                                    <td class="price-row"><?php echo $each_stock['item_price']; ?></td>
                                                    <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                        <td class="da-icon-column">
                                                            <a class="da-stock-view-dialog" href="#" data-value="<?php echo $each_stock['id']; ?>"><i class="icol-eye"></i></a>
                                                            <?php if(isset($access['edit']) && $access['edit']): ?>
                                                                <a class="da-stock-edit-dialog" href="#" data-value="<?php echo $each_stock['id']; ?>"><i class="icol-pencil"></i></a>
                                                            <?php endif; ?>
                                                            <?php if(isset($access['delete']) && $access['delete']):
                                                                $stock_id = $each_stock['id'];
                                                                $delete_url = "/stock/delete_stock/" . $stock_id;
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

                    <div id="da-stock-view-form-div" class="form-container">
                        <form id="da-stock-view-form-val" class="da-form" method="post">
                            <div id="da-stock-view-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Barang</label>
                                    <div class="da-form-item large">
                                        <input id="stock-view-name" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Satuan Barang</label>
                                    <div class="da-form-item large">
                                        <input id="stock-view-unit" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Supplier Barang</label>
                                    <div class="da-form-item large">
                                        <input id="stock-view-supplier" type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="da-stock-create-form-div" class="form-container">
                        <form id="da-stock-create-form-val" class="da-form" action="/stock/create_stock" method="post">
                            <div id="da-stock-create-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Barang</label>
                                    <div class="da-form-item large">
                                        <input id="stock-create-name" type="text" name="name">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Jumlah Stok</label>
                                    <div class="da-form-item large">
                                        <input id="stock-create-item-count" type="text" name="item_count">
                                        <label for="stock-create-item-count" id="stock-create-item-count-label"></label>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Supplier Barang</label>
                                    <div class="da-form-item large">
                                        <input id="stock-create-supplier" type="text" name="supplier">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Subproject</label>
                                    <div class="da-form-item large">
                                        <input id="stock-create-subproject" type="text" name="subproject">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">PO Detail ID</label>
                                    <div class="da-form-item large">
                                        <input id="stock-create-po-detail-id" type="text" name="po_detail_id">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Harga Barang</label>
                                    <div class="da-form-item large">
                                        <input id="stock-create-item-price" type="text" name="item-price">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="da-stock-edit-form-div" class="form-container">
                        <form id="da-stock-edit-form-val" class="da-form" action="/stock/update_stock" method="post">
                            <div id="da-stock-edit-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Barang</label>
                                    <div class="da-form-item large">
                                        <input id="stock-edit-name" type="text" name="name">
                                    </div>
                                </div>
                                <input id="stock-edit-id" type="hidden" name="id">
                            </div>
                        </form>
                    </div>
                </div>
            </div>