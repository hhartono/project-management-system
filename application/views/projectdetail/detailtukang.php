<!-- Main Content Wrapper -->
<div id="da-content-wrap" class="clearfix">
    <!-- Content Area -->
    <div id="da-content-area">
        <div class="row-fluid">
                        <div class="span12" >
                            <?php foreach($proj as $proj): ?>
                                <a class="btn btn-success btn-create" href="/projectdetail/cetak/<?php echo $proj['projectid']; ?>/<?php echo $proj['id'] ; ?>" cls='btn' target="_blank" >
                                <i class='icon-print'></i>&nbsp; Cetak </a>
                            <?php endforeach?>
                        </div>
                    </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="da-panel">
                    <div class="da-panel-header">
                    <?php $pr='' ; ?>
                    <?php foreach($pro as $proj): ?>
                        <?php
                        if($pr!=$proj['project'])
                            {
                                $pr=$proj['project'];
                                $sp=$proj['name'];
                            }
                            else
                            {
                                $pr='';
                                $sp='';
                            }
                        ?>                 
                        <table>
                                    <tr><td><span class="da-panel-title">
                                        <i class="icol-table"></i><b> Nama Project</b></td><td> :</td><td><?php echo $pr; ?></td>
                                    </span></tr>
                                    <tr><td><span class="da-panel-title">
                                        <i class="icol-table"></i><b> Sub Project</b></td><td> :</td><td><?php echo $sp; ?></td>
                                    </span></tr>
                        </table>
                    <?php endforeach?>
                    
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
                    <?php
                        $category='' ;
                    ?>
                    <div class="da-panel-content da-table-container">
                    
                        <table id="da-projectdetail-datatable-numberpaging" class="da-table"">
                        <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Nama Barang</th>
                            <th>Quantity</th>
                            <th>Satuan</th>
                            <th>Tukang</th>
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>

                        </tr>

                        </thead>
                        <tbody><?php $total_sum=0; ?>
                        <?php foreach($detail as $details): ?>
                        <?php
                            if($category!=$details['category'])
                            {
                                $category=$details['category'];
                            }
                            else
                            {
                                $category='';
                            }
                        ?>
                            <?php 
                                $total=number_format($details['total'],2,',','.'); 
                                $harga=number_format($details['harga'],2,',','.');
                            ?>
                            <tr>
                                <td class="division-row"><?php echo $category; ?></td>
                                <td class="division-row"><?php echo $details['barang']; ?></td>
                                <td class="division-row"><?php echo $details['quantity']; ?></td>
                                <td class="division-row"><?php echo $details['satuan']; ?></td>
                                <td class="division-row"><?php echo $details['tukang']; ?></td>
                                <td class="division-row"><?php echo $harga; ?></td>
                                <td class="division-row"><?php echo $total; ?></td>
                            </tr>
                           <?php $category=$details['category']; ?>
                            <?php $total_sum+=$details['total'];?>
                        <?php endforeach?>
                        <?php $jumlah = number_format($total_sum,2,',','.') ;?>
                                <td style=background:#c6d2ff; colspan="6">Total Biaya</td><td style=background:#c6d2ff;><?php echo $jumlah ;?></td>
                        </tbody>
                        </table>
                        
                    </div>
                    _____________________________________________________________________________________________________________________________________________________________________________
                </div>
            </div>
        </div>
         <div class="row-fluid">
                        <div class="span12" >
                        <form method="post" action="/projectdetail/cetaktukangtanggal/" target="_blank">
                            <input type="hidden" value="<?php echo $proj['id'] ; ?>" name="sub">
                            <input type="hidden" value="<?php echo $this->input->post('tanggal1') ?>" name="tanggal1">
                            <input type="hidden" value="<?php echo $this->input->post('tanggal2') ?>" name="tanggal2">
                            <input type="submit" value="Cetak" class="btn btn-success btn-create" class="icon-print"/>
                        </form>                            
                        </div>
                    </div>
        <div class="row-fluid">
            <div class="span12">
            <?php if(form_error('tanggal1') == FALSE){ ?>
                                    <div class="control-group"><!-- default input text -->
                            <?php }else{ ?>
                                    <div class="control-group warning"><!-- warning -->
                            <?php } ?>
                <?php echo form_open_multipart('/projectdetail/caritanggal/');?>
                    Tanggal Awal: <input id="absensi-create-join-date" type="text" name="tanggal1"><?php echo form_error('tanggal1'); ?>
                      &nbsp;&nbsp;&nbsp; 
                      Tanggal Akhir:<input id="date-cari" type="text" name="tanggal2"><span class="help-inline"><?php echo form_error('tanggal2'); ?></span>
                    <input type="hidden" value="<?php echo $proj['id'] ; ?>" name="sub">
                    <input type="submit" value="Filter" class="btn btn-success"/>
               </form>
           </div>
          
        <div class="row-fluid">
            <div class="span12">
                <div class="da-panel">
                    <div class="da-panel-header">
                    <span class="da-panel-title">
                        <i class="icol-table"></i><b> Tukang</b>
                    </span>
                    <span class="da-panel-title">
                        <i class="icol-table"></i><b>  <?php
                        echo "Tanggal: &nbsp;"; echo $this->input->post('tanggal1'); echo "&nbsp;&nbsp;Sampai tanggal:&nbsp;&nbsp;"; echo $this->input->post('tanggal2');
                    ?></b>
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
                    
                        <table id="da-projectdetail-datatable-numberpaging" class="da-table">
                        <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jam Kerja</th>
                        </tr>
                        <?php 
                            if($this->input->post('tanggal1') > $this->input->post('tanggal2')){
                                echo "<tr><td colspan=2>"; echo "Tanggal Awal Tidak Boleh Lebih Besar Dari Tanggal Akhir"; echo "</td></tr>";
                            }else{
                                if(is_array($absensi)){
                                foreach($absensi as $absensi): ?>
                             <tr>
                             <tr>
                                <td class="division-row"><?php echo $absensi['name']; ?></td>
                                <td class="division-row"><?php echo number_format((float)$absensi['waktu'], 1, ',', ''); ?> Jam</td>
                            </tr>
                        <?php endforeach?>
                        <?php
                                }else{ 
                        ?>
                            <tr>
                             <tr><td colspan=2>Data Tidak Ditemukan</td></tr>
                            </tr>
                        <?php }
                        } ?>
                        </thead>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>