<div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                        <div class="row-fluid">
                            <div class="span12">
                                <?php echo form_open_multipart('/absensi/caribulan');?>
                                Bulan
                                    <select name="bulan">
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="12">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                Tahun
                                    <select name="tahun">
                                <?php
                                    $mulai= date('Y') - 5;
                                    for($i = $mulai;$i<$mulai + 10;$i++){
                                        $sel = $i == date('Y') ? ' selected="selected"' : '';
                                        echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>';
                                    }
                                ?>
                                    </select>
                                    <input type="submit" value="Filter" class="btn btn-success"/>
                                    </form>
                            </div>
                        </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Absensi
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
                                    <table id="da-absensi-datatable-numberpaging" class="da-table"">
                                        <thead>
                                            <tr>
                                                <th>Nama Pekerja</th>
                                                <th>Bulan/Tahun</th>
                                                <th>Total Jam Kerja</th>
                                                <th>Aksi</th>                                               
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($absensi as $each_absensi): ?>
                                                <tr><form method="post" action="/absensi/detail_worker/">
                                                    <input type="hidden" value="<?php echo $each_absensi['id'];?>" name="id">
                                                    <input type="hidden" value="<?php echo $each_absensi['name'];?>" name="name">
                                                    <input type="hidden" value="<?php echo $each_absensi['bulantahun'];?>" name="bulantahun">
                                                    <td class="prefix-row"><?php echo $each_absensi['name']; ?></td>
                                                    <td class="name-row"><?php echo $each_absensi['bulantahun']; ?></td>
                                                    <td class="notes-row"><?php echo $each_absensi['jam']; ?> Jam</td>
                                                    <td><input type="submit" value="Detail" class="btn btn-success"></td>                        
                                                  </form>
                                                </tr>
                                            <?php endforeach ?>
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