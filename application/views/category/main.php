            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <button id="da-category-create-dialog" class="btn btn-success btn-create">[+] Tambah Kategori</button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Kategori Barang
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
                                    <table id="da-category-datatable-numberpaging" class="da-table"">
                                        <thead>
                                            <tr>
                                                <th>Prefix Kategori</th>
                                                <th>Nama Kategori</th>
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
                                            <?php foreach($categories as $each_category): ?>
                                                <tr>
                                                    <td class="prefix-row"><?php echo $each_category['prefix']; ?></td>
                                                    <td class="name-row"><?php echo $each_category['name']; ?></td>
                                                    <td class="notes-row"><?php echo $each_category['notes']; ?></td>
                                                    <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                        <td class="da-icon-column">
                                                            <?php if(isset($access['edit']) && $access['edit']): ?>
                                                                <a class="da-category-edit-dialog" href="#" data-value="<?php echo $each_category['id']; ?>"><i class="icol-pencil"></i></a>
                                                            <?php endif; ?>
                                                            <?php if(isset($access['delete']) && $access['delete']):
                                                                $category_id = $each_category['id'];
                                                                $delete_url = "/category/delete_category/" . $category_id;
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

                    <div id="da-category-create-form-div" class="form-container">
                        <form id="da-category-create-form-val" class="da-form" action="/category/create_category" method="post">
                            <div id="da-category-create-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Prefix Kategori</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="prefix">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Kategori</label>
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

                    <div id="da-category-edit-form-div" class="form-container">
                        <form id="da-category-edit-form-val" class="da-form" action="/category/update_category" method="post">
                            <div id="da-category-edit-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Prefix Kategori</label>
                                    <div class="da-form-item large">
                                        <input id="category-edit-prefix" type="text" name="prefix" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Kategori</label>
                                    <div class="da-form-item large">
                                        <input id="category-edit-name" type="text" name="name" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Keterangan</label>
                                    <div class="da-form-item large">
                                        <input id="category-edit-notes" type="text" name="notes">
                                    </div>
                                </div>
                                <input id="category-edit-id" type="hidden" name="id">
                            </div>
                        </form>
                    </div>
                </div>
            </div>