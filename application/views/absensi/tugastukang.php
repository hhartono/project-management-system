<div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                        <div class="row-fluid">
                            <!-- <div class="span12">
                                <?php echo form_open_multipart('/absensi/cari');?>
                                   Pencarian Berdasarkan Tanggal : <input id="absensi-create-join-date" type="text" value="yyyy-mm-dd" name="cari">
                                    <input type="submit" value="Filter" class="btn btn-success"/>
                                    </form>
                            </div> -->
                        </div>
                        <div class="row-fluid">
                            <div class="span12">
                                <!-- <a href="/absensi/upload" class="btn btn-success btn-create">[+] Upload Absensi</a> -->
                            </div>
                        </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Tugas Tukang
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
                                                <th>Grup</th>
                                                <th>Tanggal</th>
                                                <th>On Duty</th>
                                                <th>Off Duty</th>
                                                <th>Project</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($absensi as $each_absensi): ?>
                                                <tr><form method="post" action="/absensi/update_projectworkergrup/">
                                                    <input type="hidden" value="<?php echo $each_absensi['idgrup'];?>" name="id">
                                                    <input type="hidden" value="<?php echo $each_absensi['date'];?>" name="date">
                                                    <td class="prefix-row"><?php echo $each_absensi['grup']; ?></td>
                                                    <td class="name-row"><?php echo date("d-M-Y", strtotime($each_absensi['date'])); ?></td>
                                                    <td class="notes-row"><?php echo $each_absensi['jam_datang']; ?></td>
                                                    <td class="notes-row"><?php echo $each_absensi['jam_pulang']; ?></td>
                                                    <td>
                                                    <?php
                                                          if ($each_absensi['subproject'] !=null){
                                                            echo $each_absensi['subproject'];
                                                          }else{
                                                    ?>                                                    
                                                            <select id="demo2" name="subproject[]" multiple="multiple" style="width:300px">
                                                            <?php                                                                
                                                                    foreach ($getpro as $pro):                                                       
                                                            ?>
                                                                    <option value="<?php echo $pro['id'];?>">
                                                                        <?php echo $pro['project'];?> - <?php echo $pro['subproject'];?>
                                                                    </option>
                                                            <?php
                                                                endforeach;
                                                                 
                                                            ?>                                                           
                                                            </select><?php } ?>
                                                    </td>
                                                    <td class="da-icon-column">
                                                    <?php
                                                        if ($each_absensi['subproject'] ==null){
                                                    ?> 
                                                        <input type="submit" value="Submit" class="btn btn-success">
                                                    <?php } ?>
                                                    </td>
                                                  </form>  
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