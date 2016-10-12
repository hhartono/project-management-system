            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <!-- <div class="row-fluid">
                            <div class="span12" >
                                <button id="da-warna-create-dialog" class="btn btn-success btn-create">[+] Tambah Warna</button>
                            </div>
                        </div> -->
                    <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Pantone Master
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
                                                <th>Kode Pantone</th>
                                                <th>CMYK</th>
                                                <th>RGB</th>
                                                <th>Hex</th>
                                                <th>Warna</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($warnas as $each_warna): ?>
                                                <tr>
                                                    
                                                    <td class="customer-name-row"><?php echo $each_warna['Code']; ?></td>
                                                    <td class="company-name-row"><?php echo $each_warna['CMYK']; ?></td>
                                                    <td class="address-row"><?php echo $each_warna['RGB']; ?></td>
                                                    <td class="start-date-row"><?php echo $each_warna['Hex']; ?></td>
                                                    <td bgcolor="<?php echo $each_warna['Hex'];?>"></td>
                                            
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