            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <!-- <input id="btntes" type="button" name="btntes" value="tes"> -->
                                <button id="da-category-create-dialog" class="btn btn-success btn-create">[+] Tambah Kategori</button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Kategori Barang Revised
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
                                    <table id="da-category-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th>Prefix Kategori</th>
                                                <th>Nama Kategori</th>
                                                <th>Kategori</th>
                                                <th>Satuan</th>
                                                <th>Harga</th>
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
                                            <?php foreach($categories as $each_category => $val): ?>
                                                <tr>
                                                    <td class="prefix-row"><?php echo $val['prefix']; ?></td>
                                                    <td class="name-row"><?php echo $val['nama']; ?></td>
                                                    <td class="cat-row"><?php echo $val['kategori']; ?></td>
                                                    <td class="satuan-row"><?php echo $val['satuan']; ?></td>
                                                    <td class="harga-row">
                                                        <?php echo 'Rp. '. $val['harga']; ?> 
                                                        <?php
                                                            for($j = 0; $j <= 7 - $space[$each_category]; $j++){
                                                                $white = '<i style="color:white;">o</i>';
                                                                echo $white;
                                                            }
                                                        ?>
                                                        <?php if(isset($access['edit']) && $access['edit']): ?>
                                                                <a class="da-category-edit-dialog" href="#" data-value="<?php echo $val['id']; ?>"><i class="icol-pencil"></i></a>
                                                        <?php endif; ?>
                                                    </td>
                                                    <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                        <td class="da-icon-column">
                                                            <a class="da-category-view-dialog" href="#" data-value="<?php echo $val['id']; ?>"><i class="icol-eye"></i></a>
                                                            <?php if(isset($access['delete']) && $access['delete']):
                                                                $category_id = $val['id'];
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
                        <form id="da-category-create-form-val" class="da-form" action="/categoryrev/create_category" method="post">
                            <div id="da-category-create-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Prefix Kategori</label>
                                    <div class="da-form-item large">
                                        <input id="category-create-prefix" type="text" name="prefix" autocomplete="off" maxlength="3">
                                        <label for="category-create-prefix">(3 karakter)</label>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Kategori</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="nama" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Kategori</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="kat" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Satuan</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="satuan" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Harga</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="harga" autocomplete="off">
                                    </div>
                                </div>
                                <input type="hidden" value="<?php echo $userid; ?>" name="user">
                            </div>
                        </form>
                    </div>

                    <div id="da-category-edit-form-div" class="form-container">
                        <form id="da-category-edit-form-val" class="da-form" action="/categoryrev/update_category" method="post">
                            <div id="da-category-edit-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Harga</label>
                                    <div class="da-form-item large">
                                        <input id="category-edit-harga" type="text" name="harga" autocomplete="off">
                                    </div>
                                </div>
                                <input id="category-edit-nama" type="hidden" name="nama">
                                <input id="category-edit-satuan" type="hidden" name="satuan">
                                <input id="category-edit-id" type="hidden" name="id">
                                <input type="hidden" value="<?php echo $userid; ?>" name="userid">
                            </div>
                        </form>
                    </div>

                    <div id="da-category-view-form-div" class="form-container">
                        <form id="da-category-view-form-val" class="da-form" action="/categoryrev/cek_history_harga" method="post">
                            <div id="da-category-view-validate-error" class="da-message error" style="display:none;"></div>
                            <div id="tharga" class="da-form-inline">
                                <table id='harga' class="da-table">
                                    <!-- Inserted with js -->
                                </table>
                                <input id="category-view-id" type="hidden" name="id">
                            </div>
                        </form>
                    </div>
                </div>
            </div>