            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <button id="da-parts-create-dialog" class="btn btn-success btn-create" data-value="<?php echo $gn ?>">[+] Tambah Parts</button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> <a href="/intivo">Intivo </a> / Parts
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
                                    <table id="da-parts-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th>Group</th>
                                                <th>Parts Image</th>
                                                <th>Code</th>
                                                <th>Description</th>
                                                <th>Quantity</th>
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
                                            <?php foreach($parts as $each_parts): ?>
                                                <tr>
                                                    <td class="group-name-row">
                                                        <?php echo $each_parts['group_name']; ?>
                                                    </td>

                                                    <?php
                                                        $img_array = array();
                                                        if(!empty($each_parts['part_img_path'])){
                                                            $img_array[] = $each_parts['part_img_path'];
                                                        }
                                                    ?>
                                                    <td class="group-code-row">
                                                        <img src='<?php echo implode(', ', $img_array); ?>' width="250" height="250"/>
                                                    </td>

                                                    <?php
                                                        $code_array = array();
                                                        if(!empty($each_parts['code'])){
                                                            $code_array[] = $each_parts['code'];
                                                        }
                                                    ?>
                                                    <td class="group-code-row"><?php echo implode(', ', $code_array); ?></td>

                                                    <?php
                                                        $description_array = array();
                                                        if(!empty($each_parts['description'])){
                                                            $description_array[] = $each_parts['description'];
                                                        }
                                                    ?>
                                                    <td class="description-row"><?php echo implode(', ', $description_array); ?></td>
                                                
                                                    <?php
                                                        $quantity_array = array();
                                                        if(!empty($each_parts['quantity'])){
                                                            $quantity_array[] = $each_parts['quantity'];
                                                        }
                                                    ?>
                                                    <td class="quantity-row"><?php echo implode(', ', $quantity_array); ?></td>

                                                    <td class="da-icon-column">
                                                        <?php if(isset($access['addImg']) && $access['addImg']): ?>
                                                            <a class="da-parts-upload-dialog" id="da-upl-img" href="#" data-value="<?php echo $each_parts['id']; ?>" data-group="<?php echo $each_parts['group_name']; ?>"><i class="icol-camera"></i></a>
                                                        <?php endif; ?>

                                                        <?php if(isset($access['edit']) && $access['edit']): ?>
                                                            <a class="da-parts-edit-dialog" href="#" data-value="<?php echo $each_parts['id']; ?>"><i class="icol-pencil"></i></a>
                                                        <?php endif; ?>

                                                        <?php if(isset($access['delete']) && $access['delete']):
                                                            $item_id = $each_parts['id'];
                                                            $delete_url = "/parts/delete_parts/" . $item_id;
                                                        ?>
                                                        <a href=<?php echo $delete_url; ?>><i class="icol-cross"></i></a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="da-parts-create-form-div" class="form-container">
                        <form id="da-parts-create-form-val" class="da-form" action="/parts/create_parts" method="post">
                            <div id="da-parts-create-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Group</label>
                                    <div class="da-form-item large">
                                        <input id="parts-create-group" type="text" name="group" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Code</label>
                                    <div class="da-form-item large">
                                        <input id="parts-create-code" type="text" name="code" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Description</label>
                                    <div class="da-form-item large">
                                        <input id="parts-create-description" type="text" name="description" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Quantity</label>
                                    <div class="da-form-item large">
                                        <input id="parts-create-quantity" type="text" name="quantity" autocomplete="off">
                                    </div>
                                </div>
                                <input type="hidden" value="<?php echo $userid; ?>" name="user">
                                <input id="parts-create-id" type="hidden" name="id-create">
                            </div>
                        </form>
                    </div>

                    <div id="da-parts-upload-form-div" class="form-container">
                        <form id="da-test-image" class="da-form" enctype="multipart/form-data" action="/parts/upload_image" method="post">
                            <div id="da-parts-upload-validate-error" class="da-message-error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Image</label>
                                    <div class="da-form-item large">
                                        <input type="file" id="image" name="image" autocomplete="off" />
                                        <input type="hidden" id="id_image" name="id_image" value="" autocomplete="off" />
                                        <input type="hidden" id="group_image" name="group_image" value="" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="da-parts-edit-form-div" class="form-container">
                        <form id="da-parts-edit-form-val" class="da-form" action="/parts/update_parts" method="post">
                            <div id="da-parts-edit-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Group</label>
                                    <div class="da-form-item large">
                                        <input id="parts-edit-group" type="text" name="group">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Code</label>
                                    <div class="da-form-item large">
                                        <input id="parts-edit-code" type="text" name="code" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Description</label>
                                    <div class="da-form-item large">
                                        <input id="parts-edit-description" type="text" name="description" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Quantity</label>
                                    <div class="da-form-item large">
                                        <input id="parts-edit-quantity" type="text" name="quantity" autocomplete="off">
                                    </div>
                                </div>
                                <input id="parts-edit-id" type="hidden" name="id">
                            </div>
                        </form>
                    </div>
                </div>
            </div>