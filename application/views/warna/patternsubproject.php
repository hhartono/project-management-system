            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                            <div class="span12" >
                                <button id="da-warna-subproject-create-dialog" class="btn btn-success btn-create">[+] Tambah Subproject</button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> SubProject Warna
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
                                    <table id="da-warna-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th>Nama SubProject</th>
                                                <th>Pattern</th>
                                                <th>Gambar</th>
                                                <th>Lihat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($subpattern as $each_pattern): ?>
                                                <tr>
                                                    <td class="customer-name-row"><?php echo $each_pattern['subproject']; ?></td>
                                                    <?php if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                        <td><?php if(isset($access['delete']) && $access['delete']):
                                                                $warna_id = $each_pattern['id'];
                                                                //$delete_url = "/warna/delete_subproject_warna/" . $warna_id;
                                                                $view_url = "/warna/view_pattern/". $warna_id;
                                                            ?>
                                                              <a href=<?php echo $view_url; ?>>Buat</i></a>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="da-icon-column">
                                                            
                                                            <?php if(isset($access['delete']) && $access['delete']):
                                                                $warna_id = $each_pattern['id'];
                                                                /*$delete_url = "/warna/delete_subproject_warna/" . $warna_id;
                                                                $view_url = "/warna/view_subproject_warna/". $warna_id;*/
                                                            ?><a class="da-warna-subproject-photo-dialog" href="#" data-value="<?php echo $each_pattern['id']; ?>">Upload</i></a>
                                                                <!-- <a href=<?php echo $view_url; ?>><i class="icol-eye"></i></a>
                                                                <a href=<?php echo $delete_url; ?>><i class="icol-cross"></i></a> -->
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php if(isset($access['delete']) && $access['delete']):
                                                                $warna_id = $each_pattern['id'];
                                                                //$delete_url = "/warna/delete_subproject_warna/" . $warna_id;
                                                                $view_url = "/warna/view_patterngambar_warna/". $warna_id;
                                                            ?>
                                                              <a href=<?php echo $view_url; ?>><i class="icol-eye"></i></a>
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

                    <div id="da-warna-subproject-create-form-div" class="form-container">
                        <form id="da-warna-subproject-create-form-val" class="da-form" action="/warna/create_subproject_warna/<?php echo $uri; ?>" method="post">
                            <div id="da-warna-subproject-create-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama SubProject</label>
                                    <div class="da-form-item large">
                                        
                                             <select class="form-control" name="cari">
                                        <?php 
                                            echo '<option>--- Pilih SubProject ---</option>';
                                            foreach ($subpro as $subpro)
                                            {            
                                                echo '<option value="'.$subpro['name'].'">'.$subpro['name'].'</option>';
                                            }
                                        ?>
                                            </select>
                                            
                                        
                                        <!-- <input id="pattern-create-subproject" type="text" name="subproject_name"> -->
                                        <input type="hidden" name="projectid" value="<?php echo $uri; ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="da-warna-subproject-photo-form-div" class="form-container">
                        <form id="da-warna-subproject-photo-form-val" class="dropzone" action="/warna/upload_subproject_warna" method="post">
                            <input type="hidden" name="id" id="subproject-warna-id" value="">
                        </form>
                    </div>

                </div>
            </div>