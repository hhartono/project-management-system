<div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i><b> Nama Pekerja : <?php echo $this->input->post('name'); ?></b>
                                    </span>
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i><b> Bulan/Tahun  &nbsp;: <?php echo $this->input->post('bulantahun'); ?></b>
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
                                
                                <div class="row-fluid">
                                <div class="span12">
                                  
                                <div class="da-panel-content da-table-container">
                                    <table id="da-absensi-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>                                          
                                                <th>Sub Project</th>
                                                <th>Jam Kerja</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($detail as $each_detail): ?>
                                                <tr>                                                   
                                                    
                                                    <td class="notes-row"><?php echo $each_detail['subproject']; ?></td>
                                                    <?php $total_sum=0; 
                                                    $total_sum+=$each_detail['waktu'];?>
                                                    <td class="notes-row"><?php echo $total_sum; ?> Jam</td>
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
                      </div>
                    </div>