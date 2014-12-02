            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <button id="da-item-create-dialog" class="btn btn-success btn-create">[+] Tambah Barang</button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Jenis Barang
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
                                    <table id="da-item-datatable-numberpaging" class="da-table"">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Satuan Barang</th>
                                                <th>Kategori Barang</th>
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
                                            <?php foreach($items as $each_item): ?>
                                                <tr>
                                                    <td class="name-row"><?php echo $each_item['name']; ?></td>
                                                    <td class="unit-row"><?php echo $each_item['unit']; ?></td>
                                                    <td class="unit-row"><?php echo $each_item['category']; ?></td>
                                                    <td class="notes-row"><?php echo $each_item['notes']; ?></td>
                                                    <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                        <td class="da-icon-column">
                                                            <?php if(isset($access['edit']) && $access['edit']): ?>
                                                                <a class="da-item-edit-dialog" href="#" data-value="<?php echo $each_item['id']; ?>"><i class="icol-pencil"></i></a>
                                                            <?php endif; ?>
                                                            <?php if(isset($access['delete']) && $access['delete']):
                                                                $item_id = $each_item['id'];
                                                                $delete_url = "/item/delete_item/" . $item_id;
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

                    <div id="da-item-create-form-div" class="form-container">
                        <form id="da-item-create-form-val" class="da-form" action="/item/create_item" method="post">
                            <div id="da-item-create-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Barang</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Satuan Barang</label>
                                    <div class="da-form-item large">
                                        <select id="item-create-unit" name="unit_id"></select>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Kategori Barang</label>
                                    <div class="da-form-item large">
                                        <select id="item-create-category" name="category_id"></select>
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

                    <div id="da-item-edit-form-div" class="form-container">
                        <form id="da-item-edit-form-val" class="da-form" action="/item/update_item" method="post">
                            <div id="da-item-edit-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Barang</label>
                                    <div class="da-form-item large">
                                        <input id="item-edit-name" type="text" name="name" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Satuan Barang</label>
                                    <div class="da-form-item large">
                                        <select id="item-edit-unit" name="unit_id"></select>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Kategori Barang</label>
                                    <div class="da-form-item large">
                                        <select id="item-edit-category" name="category_id" disabled></select>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Keterangan</label>
                                    <div class="da-form-item large">
                                        <input id="item-edit-notes" type="text" name="notes" autocomplete="off">
                                    </div>
                                </div>
                                <input id="item-edit-id" type="hidden" name="id">
                            </div>
                        </form>
                    </div>
                </div>
            </div>