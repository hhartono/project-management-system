            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <button id="da-subproject-create-dialog" class="btn btn-success btn-create">[+] Tambah Subproject</button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Subproject
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
                                    <table id="da-subproject-datatable-numberpaging" class="da-table"">
                                        <thead>
                                            <tr>
                                                <th>Nama Project</th>
                                                <th>Kode Subproject</th>
                                                <th>Nama Subproject</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Pasang</th>
                                                <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                    <?php
                                                        $control_label_array = array();
                                                        $control_label_array[] = "Lihat";

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
                                            <?php foreach($subprojects as $each_subproject): ?>
                                                <tr>
                                                    <td class="project-name-row"><?php echo $each_subproject['project_name']; ?></td>
                                                    <td class="code-row"><?php echo $each_subproject['subproject_code']; ?></td>
                                                    <td class="name-row"><?php echo $each_subproject['name']; ?></td>
                                                    <td class="start-date-row">
                                                        <?php
                                                        if(empty($each_subproject['formatted_start_date'])){
                                                            $subproject_id = $each_subproject['id'];
                                                            $start_url = "/subproject/start_subproject/" . $subproject_id;
                                                            ?>
                                                            <form id="da-subproject-start-form-val" class="da-form" action=<?php echo $start_url; ?> method="post">
                                                                <button id="da-subproject-start" class="btn btn-success">Mulai</button>
                                                            </form>
                                                        <?php
                                                        }else{
                                                            echo $each_subproject['formatted_start_date'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="install-date-row">
                                                        <?php
                                                        if(empty($each_subproject['formatted_install_date'])){
                                                            $subproject_id = $each_subproject['id'];
                                                            $install_url = "/subproject/install_subproject/" . $subproject_id;
                                                            ?>
                                                            <?php if(empty($each_subproject['formatted_start_date'])){ ?>
                                                            <form id="da-subproject-install-form-val" class="da-form" method="post">
                                                                <button id="da-subproject-install" class="btn btn-success disabled">Pasang</button>
                                                            </form>
                                                            <?php } else { ?>
                                                            <form id="da-subproject-install-form-val" class="da-form" action=<?php echo $install_url; ?> method="post">
                                                                <button id="da-subproject-install" class="btn btn-success">Pasang</button>
                                                            </form>
                                                            <?php } ?>
                                                        <?php
                                                        }else{
                                                            echo $each_subproject['formatted_install_date'];
                                                        }
                                                        ?>
                                                    </td>

                                                    <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                        <td class="da-icon-column">
                                                            <a class="da-subproject-view-dialog" href="#" data-value="<?php echo $each_subproject['id']; ?>"><i class="icol-eye"></i></a>
                                                            <?php if(isset($access['edit']) && $access['edit']): ?>
                                                                <a class="da-subproject-edit-dialog" href="#" data-value="<?php echo $each_subproject['id']; ?>"><i class="icol-pencil"></i></a>
                                                            <?php endif; ?>
                                                            <?php if(isset($access['delete']) && $access['delete']):
                                                                $subproject_id = $each_subproject['id'];
                                                                $delete_url = "/subproject/delete_subproject/" . $subproject_id;
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

                    <div id="da-subproject-create-form-div" class="form-container">
                        <form id="da-subproject-create-form-val" class="da-form" action="/subproject/create_subproject" method="post">
                            <div id="da-subproject-create-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Project</label>
                                    <div class="da-form-item large">
                                        <input id="subproject-create-project" type="text" name="project_name">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Subproject</label>
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

                    <div id="da-subproject-edit-form-div" class="form-container">
                        <form id="da-subproject-edit-form-val" class="da-form" action="/subproject/update_subproject" method="post">
                            <div id="da-subproject-edit-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Project</label>
                                    <div class="da-form-item large">
                                        <input id="subproject-edit-project" type="text" name="project_name" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Subproject</label>
                                    <div class="da-form-item large">
                                        <input id="subproject-edit-name" type="text" name="name" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Keterangan</label>
                                    <div class="da-form-item large">
                                        <input id="subproject-edit-notes" type="text" name="notes">
                                    </div>
                                </div>
                                <input id="subproject-edit-id" type="hidden" name="id">
                            </div>
                        </form>
                    </div>

                    <div id="da-subproject-view-form-div" class="form-container">
                        <form id="da-subproject-view-form-val" class="da-form" method="post">
                            <div id="da-subproject-view-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Project</label>
                                    <div class="da-form-item large">
                                        <input id="subproject-view-project" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Code Subproject</label>
                                    <div class="da-form-item large">
                                        <input id="subproject-view-subproject-code" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Subproject</label>
                                    <div class="da-form-item large">
                                        <input id="subproject-view-name" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Tanggal Mulai</label>
                                    <div class="da-form-item large">
                                        <input id="subproject-view-start-date" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Tanggal Pasang</label>
                                    <div class="da-form-item large">
                                        <input id="subproject-view-install-date" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Keterangan</label>
                                    <div class="da-form-item large">
                                        <input id="subproject-view-notes" type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>