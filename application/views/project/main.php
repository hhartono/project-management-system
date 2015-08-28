            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                            <div class="span12" >
                                <button id="da-project-create-dialog" class="btn btn-success btn-create">[+] Tambah Project</button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Project
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
                                    <table id="da-project-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th>Nama Project</th>
                                                <th>Nama Customer</th>
                                                <th>Nama Perusahaan</th>
                                                <th>Alamat Project</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Selesai</th>
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
                                            <?php foreach($projects as $each_project): ?>
                                                <tr>
                                                    <td class="name-row"><?php echo $each_project['name']; ?></td>
                                                    <td class="customer-name-row"><?php echo $each_project['customer_name']; ?></td>
                                                    <td class="company-name-row"><?php echo $each_project['company_name']; ?></td>
                                                    <td class="address-row"><?php echo $each_project['address']; ?></td>
                                                    <td class="start-date-row">
                                                        <?php if(empty($each_project['formatted_start_date'])){
                                                            echo "";
                                                        }else{
                                                            echo $each_project['formatted_start_date'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="finish-date-row">
                                                        <?php
                                                            if(empty($each_project['formatted_finish_date'])){
                                                                $project_id = $each_project['id'];
                                                                $finish_url = "/project/finish_project/" . $project_id;
                                                        ?>
                                                            <form id="da-project-finish-form-val" class="da-form" action=<?php echo $finish_url; ?> method="post">
                                                                <button id="da-project-finish" class="btn btn-success">Selesai</button>
                                                            </form>
                                                        <?php
                                                            }else{
                                                                echo $each_project['formatted_finish_date'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                        <td class="da-icon-column">
                                                            <a class="da-project-view-dialog" href="#" data-value="<?php echo $each_project['id']; ?>"><i class="icol-eye"></i></a>
                                                            <?php if(isset($access['edit']) && $access['edit']): ?>
                                                                <a class="da-project-edit-dialog" href="#" data-value="<?php echo $each_project['id']; ?>"><i class="icol-pencil"></i></a>
                                                            <?php endif; ?>
                                                            <?php if(isset($access['delete']) && $access['delete']):
                                                                $project_id = $each_project['id'];
                                                                $delete_url = "/project/delete_project/" . $project_id;
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

                    <div id="da-project-create-form-div" class="form-container">
                        <form id="da-project-create-form-val" class="da-form" action="/project/create_project" method="post">
                            <div id="da-project-create-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Inisial Project</label>
                                    <div class="da-form-item large">
                                        <input id="project-create-project-initial" type="text" name="project_initial" autocomplete="off" maxlength="5">
                                        <label for="project-create-project-initial">(max 5 karakter)</label>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Project</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Customer</label>
                                    <div class="da-form-item large">
                                        <input id="project-create-customer" type="text" name="customer_name">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Company</label>
                                    <div class="da-form-item large">
                                        <input id="project-create-company" type="text" name="company_name">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Tanggal Mulai</label>
                                    <div class="da-form-item large">
                                        <input id="project-create-start-date" type="text" name="start_date" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Alamat Project</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="address" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Keterangan</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="notes" autocomplete="off">
                                    </div>
                                </div>
                                <input type="hidden" value="<?php echo $userid; ?>" name="user">
                            </div>
                        </form>
                    </div>

                    <div id="da-project-edit-form-div" class="form-container">
                        <form id="da-project-edit-form-val" class="da-form" action="/project/update_project" method="post">
                            <div id="da-project-edit-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Inisial Project</label>
                                    <div class="da-form-item large">
                                        <input id="project-edit-project-initial" type="text" name="project_initial" maxlength="5" readonly>
                                        <label for="project-edit-project-initial">(max 5 karakter)</label>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Project</label>
                                    <div class="da-form-item large">
                                        <input id="project-edit-name" type="text" name="name" >
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Customer</label>
                                    <div class="da-form-item large">
                                        <input id="project-edit-customer" type="text" name="customer_name">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Tanggal Mulai</label>
                                    <div class="da-form-item large">
                                        <input id="project-edit-start-date" type="text" name="start_date" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Alamat Project</label>
                                    <div class="da-form-item large">
                                        <input id="project-edit-address" type="text" name="address" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Keterangan</label>
                                    <div class="da-form-item large">
                                        <input id="project-edit-notes" type="text" name="notes" autocomplete="off">
                                    </div>
                                </div>
                                <input id="project-edit-id" type="hidden" name="id">
                            </div>
                        </form>
                    </div>

                    <div id="da-project-view-form-div" class="form-container">
                        <form id="da-project-view-form-val" class="da-form" method="post">
                            <div id="da-project-view-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Inisial Project</label>
                                    <div class="da-form-item large">
                                        <input id="project-view-project-initial" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Project</label>
                                    <div class="da-form-item large">
                                        <input id="project-view-name" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Customer</label>
                                    <div class="da-form-item large">
                                        <input id="project-view-customer" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Tanggal Mulai</label>
                                    <div class="da-form-item large">
                                        <input id="project-view-start-date" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Tanggal Selesai</label>
                                    <div class="da-form-item large">
                                        <input id="project-view-finish-date" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Alamat Project</label>
                                    <div class="da-form-item large">
                                        <input id="project-view-address" type="text" readonly>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Keterangan</label>
                                    <div class="da-form-item large">
                                        <input id="project-view-notes" type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>