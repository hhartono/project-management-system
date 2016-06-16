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
                                        <i class="icol-grid"></i> Timeline
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
                                
                                <div id="da-item-create-form-div" class="form-container">
                                    <form action="/displaytugas/create_timeline" method="post">
                                        <div id="da-item-create-validate-error" class="da-message error" style="display:none;"></div>
                                        <div class="da-form-inline">
                                            <div class="da-form-row">
                                                <label class="da-form-label">Nama Grup</label>
                                                <div class="da-form-item large">
                                                    <select name="grup_id" id="grup_id">
                                                        <option value="">--- Pilih Grup ---</option>
                                                        <?php
                                                            foreach ($grup as $grup) {
                                                                echo "<option value='$grup[id]'>$grup[name] </option> ";
                                                            }
                                                        ?>   
                                                    </select>    
                                                </div>
                                            </div>                                            
                                            <div class="da-form-row">
                                                <label class="da-form-label">Subproject</label>
                                                <div class="da-form-item large">
                                                    <select name="subproject">
                                                        <option value="">--- Pilih Subproject ---</option>
                                                        <?php
                                                            foreach ($subproject as $subproject) {
                                                                echo "<option value='$subproject[id]'>$subproject[name] </option> ";
                                                            }
                                                        ?>   
                                                    </select>    
                                                </div>
                                            </div>
                                            <div class="da-form-row">
                                                <label class="da-form-label">Simpan Setelah Project</label>
                                                <div class="da-form-item large">
                                                    <select name="timeline" id="timeline">
                                                        <option value="">--- Pilih Project ---</option>
                                                    </select>    
                                                </div>
                                            </div>
                                            <div class="da-form-row">
                                                <div class="da-form-item large">
                                                    <select name="timeid" id="timeid" style="display:none;">
                                                    </select>    
                                                </div>
                                            </div>
                                            <div class="da-form-row">
                                                <label class="da-form-label">Status</label>
                                                <div class="da-form-item large">
                                                    <select name="status">
                                                        <option value="">--- Pilih Status ---</option>
                                                        <option value="1"> Pembuatan </option>
                                                        <option value="2"> Finishing </option>
                                                        <option value="3"> Penyetelan </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="da-form-row">
                                                <label class="da-form-label"> Lama Pekerjaan </label>
                                                <div class="da-form-item large">
                                                    <input type="text" name="waktu" autocomplete="off">
                                                </div>
                                            </div>
                                            
                                            <input type="submit" value="Simpan">
                                        </div>
                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>

        