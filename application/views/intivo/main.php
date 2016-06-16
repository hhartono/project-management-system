            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <button id="da-item-create-dialog" class="btn btn-success btn-create">[+] Tambah Item</button>
                                <form id="search-form" action="/intivo" method="get">
                                    <span class="label label-info da-form-label"><font size="2">I n p u t &nbsp; P a r t s : </font></span>
                                    <select id="search_1" name="code">
                                        <option selected disabled>Kode Barang</option>
                                        <?php 
                                            foreach($code_1 as $param){
                                                echo '<option value="'.$param['code'].'">'.$param['code'].'</option>';
                                            }
                                        ?>
                                    </select> &nbsp;&nbsp;&nbsp;&nbsp;
                                    <select id="search_2" name="parts_sum">
                                        <option selected disabled>Jumlah Parts</option>
                                    </select> &nbsp;&nbsp;&nbsp;&nbsp;
                                    <select id="search_3" name="unq_code">
                                        <option selected disabled>Kode Barang (Unik)</option>
                                        <?php 
                                            foreach($spec as $param){
                                                echo '<option value="'.$param['code'].'">'.$param['code'].'</option>';
                                            }
                                        ?>
                                    </select> &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input id="search-btn-first" class="btn btn-danger" name="search" type="submit" value="Search">
                                </form> <br><br>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Intivo
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
                                    <table id="da-item-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th>Group</th>
                                                <th>Code</th>
                                                <th>Description</th>
                                                <th>Price</th>
                                                
                                                <?php if ((isset($access['addImg']) && $access['addImg']) || (isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                    <?php
                                                        $control_label_array = array();
                                                        if(isset($access['addImg']) && $access['addImg']){
                                                            $control_label_array[] = "Image";
                                                        }

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
                                            <?php foreach($group as $each_group): ?>
                                                <tr>
                                                    <?php
                                                        $img_array = array();
                                                        if(!empty($each_group['blg_img_path'])){
                                                            $img_array[] = $each_group['blg_img_path'];
                                                        }
                                                    ?>
                                                    <td class="group-name-row">
                                                        <h5><?php echo $each_group['blg_group_name']; ?> </h5><br>
                                                        <a href="/parts?group=<?php echo $each_group['blg_group_name']; ?>">
                                                            <img src='<?php echo implode(', ', $img_array); ?>' width="300" height="300"/>
                                                        </a>
                                                    </td>

                                                    <?php
                                                        $code_array = array();
                                                        if(!empty($each_group['blg_code'])){
                                                            $code_array[] = $each_group['blg_code'];
                                                        }
                                                    ?>
                                                    <td class="group-code-row"><?php echo implode(', ', $code_array); ?></td>

                                                    <?php
                                                        $description_array = array();
                                                        if(!empty($each_group['blg_description'])){
                                                            $description_array[] = $each_group['blg_description'];
                                                        }
                                                    ?>
                                                    <td class="description-row"><?php echo implode(', ', $description_array); ?></td>

                                                    <?php
                                                        $price_array = array();
                                                        if(!empty($each_group['blg_price'])){
                                                            $price_array[] = $each_group['blg_price'];
                                                        }
                                                    ?>
                                                    <td class="price-row"><?php echo "Rp ".implode(', ', $price_array); ?></td>
                                                
                                                    <td class="da-icon-column">
                                                        <?php if(isset($access['addImg']) && $access['addImg']): ?>
                                                            <a class="da-item-upload-dialog" id="da-upl-img" href="#" data-value="<?php echo $each_group['id']; ?>"><i class="icol-camera"></i></a>
                                                        <?php endif; ?>

                                                        <?php if(isset($access['edit']) && $access['edit']): ?>
                                                            <a class="da-item-edit-dialog" href="#" data-value="<?php echo $each_group['id']; ?>"><i class="icol-pencil"></i></a>
                                                        <?php endif; ?>

                                                        <?php if(isset($access['delete']) && $access['delete']):
                                                            $item_id = $each_group['id'];
                                                            $delete_url = "/intivo/delete_item/" . $item_id;
                                                        ?>
                                                        <a href=<?php echo $delete_url; ?>><i class="icol-cross"></i></a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="da-item-create-form-div" class="form-container">
                        <form id="da-item-create-form-val" class="da-form" action="/intivo/create_item" method="post">
                            <div id="da-item-create-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Group</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="group" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Code</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="code" autofocus autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Description</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="description" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Quantity</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="quantity" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Price</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="price" autocomplete="off">
                                    </div>
                                </div>
                                <input type="hidden" value="<?php echo $userid; ?>" name="user">
                            </div>
                        </form>
                    </div>

                    <div id="da-item-upload-form-div" class="form-container">
                        <form id="da-test-image" class="da-form" enctype="multipart/form-data" action="/intivo/upload_image" method="post">
                            <div id="da-item-upload-validate-error" class="da-message-error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Image</label>
                                    <div class="da-form-item large">
                                        <input type="file" id="image" name="image" autocomplete="off" />
                                        <input type="hidden" id="id_image" name="id_image" value="" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="da-item-edit-form-div" class="form-container">
                        <form id="da-item-edit-form-val" class="da-form" action="/intivo/update_item" method="post">
                            <div id="da-item-edit-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Group</label>
                                    <div class="da-form-item large">
                                        <input id="item-edit-group" type="text" name="group">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Code</label>
                                    <div class="da-form-item large">
                                        <input id="item-edit-code" type="text" name="code" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Description</label>
                                    <div class="da-form-item large">
                                        <input id="item-edit-description" type="text" name="description" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Parts Quantity</label>
                                    <div class="da-form-item large">
                                        <input id="item-edit-quantity" type="text" name="quantity" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Price</label>
                                    <div class="da-form-item large">
                                        <input id="item-edit-price" type="text" name="price" autocomplete="off">
                                    </div>
                                </div>
                                <input id="item-edit-id" type="hidden" name="id">
                            </div>
                        </form>
                    </div>
                </div>
            </div>