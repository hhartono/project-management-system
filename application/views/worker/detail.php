            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <button id="da-worker-create-dialog" class="btn btn-success btn-create">[+] Tambah Tukang</button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Tukang
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
                                    <table id="da-worker-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th>Kode Tukang</th>
                                                <th>Nama Tukang</th>
                                                <th>Divisi Tukang</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($workers as $each_worker): ?>
                                                <tr>
                                                    <td class="code-row"><?php echo $each_worker['kepala']; ?></td>
                                                    <td class="name-row"><?php echo $each_worker['name']; ?></td>
                                                    <td class="division-row"><?php echo $each_worker['division']; ?></td>
                                                </tr>
                                            <?php endforeach?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>