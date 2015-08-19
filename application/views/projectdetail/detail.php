<!-- Main Content Wrapper -->
<div id="da-content-wrap" class="clearfix">
    <!-- Content Area -->
    <div id="da-content-area">
        <div class="row-fluid">
            <div class="span12" >
                <?php foreach($proj as $proj): ?>
                    <a class="btn btn-success btn-create" href="/projectdetail/cetak/<?php echo $proj['projectid']; ?>/<?php echo $proj['id'] ; ?>" cls='btn' target="_blank">
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
                            <tr><td><span class="da-panel-title">
                                <i class="icon-ok" style="color:LimeGreen"></i><b> Item Yang Dibayar</b></td>
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
                    <div class="da-panel-content da-table-container">
                    
                        <table id="da-projectdetail-datatable-numberpaging" class="da-table">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Quantity</th>
                                <th>Satuan</th>
                                <th>Kategori</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody><?php $total_sum=0; ?>
                        <?php foreach($detail as $details): ?>
                       <!--  <?php
                           if($category!=$details['category'])
                           {
                               $category=$details['category'];
                           }
                           else
                           {
                               $category='';
                           }
                       ?> -->
                        <?php 
                            $total=number_format($details['total'],2,',','.'); 
                        ?>
                        <?php if($details['company'] == $details['idcompany'] || $details['company'] == 0){ ?>
                            <tr>
                                <td class="division-row"><a class="da-projectdetail-view-dialog" href="#" data-namabarang="<?php echo $details['barang'];?>" data-value="<?php echo $details['id']; ?>" data-stock="<?php echo $details['stock']; ?>"><?php echo $details['barang']; ?></a></td>
                                <td class="division-row"><?php echo $details['quantity']; ?></td>
                                <td class="division-row"><?php echo $details['satuan']; ?></td>
                                <td class="division-row"><?php echo $details['category']; ?></td>
                                <td class="division-row"><?php echo $total; ?></td>
                            </tr>                    
                        <?php $total_sum+=$details['total'];?>
                        <?php } ?>
                        <!-- <?php $category=$details['category']; ?> -->
                        <?php endforeach?>
                        <?php $jumlah = number_format($total_sum,2,',','.') ;?>
                                <td style=background:#c6d2ff; colspan="4">Total Biaya</td><td style=background:#c6d2ff;><?php echo $jumlah ;?></td>
                        </tbody>
                        </table>
                    </div>
                    </br>
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
                                <i class="icon-remove" style="color:Red"></i><b> Item Yang Harus Dibayar</b></td>
                            </span></tr>
                        </table>
                    <?php endforeach?>
                    
                    </div>
                    <div class="da-panel-content da-table-container">
                        <table id="da-projectdetail-datatable-numberpaging" class="da-table">
                        <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Quantity</th>
                            <th>Satuan</th>
                            <th>Kategori</th>
                            <th>Total Harga</th>

                        </tr>

                        </thead>
                        <tbody><?php $total_sum=0; ?>
                        <?php foreach($detail2 as $details2): ?>
                        <?php
                            /*if($categorys!=$details['category'])
                            {
                                $categorys=$details['category'];
                            }
                            else
                            {
                                $categorys='';
                            }*/
                        ?>
                            <?php 
                                $total=number_format($details2['total'],2,',','.'); 
                            ?>
                            <?php if(!($details2['company'] == $details2['idcompany'] || $details2['company'] == 0)){ ?>
                            <tr>
                                <td class="division-row"><a class="da-projectdetail2-view-dialog" href="#" data-namabarang="<?php echo $details2['barang'];?>" data-value="<?php echo $details2['id']; ?>" data-stock="<?php echo $details2['stock']; ?>"><?php echo $details2['barang']; ?></a></td>
                                <td class="division-row"><?php echo $details2['quantity']; ?></td>
                                <td class="division-row"><?php echo $details2['satuan']; ?></td>
                                <td class="division-row"><?php echo $details2['category']; ?></td>
                                <td class="division-row"><?php echo $total; ?></td>
                            </tr>
                            
                            <?php //$categorys=$details['category']; ?>
                            <?php $total_sum+=$details2['total'];?>
                            <?php } ?>
                        <?php endforeach?>
                        <?php $jumlah2 = number_format($total_sum,2,',','.') ;?>
                                <td style=background:#c6d2ff; colspan="4">Total Biaya</td><td style=background:#c6d2ff;><?php echo $jumlah2 ;?></td>
                        </tbody>
                        </table>
                    </div>
                    </br>
                    <div class="da-panel-content da-table-container">
                        <div class="da-panel-header">
                        <?php $total_sum=0; ?>
                        <?php 
                            foreach($sumprice as $sumprice){
                                $total_sum+=$sumprice['total'];
                            }
                        ?>
                        <table>
                            <?php $jumlah3 = number_format($total_sum,2,',','.') ;?>
                            <tr><td><span class="da-panel-title">
                                <i class=""></i><h3><b> Total Biaya Keseluruhan</b></h3></td><td> :</td><td><font color='red'><h3><b><?php echo $jumlah3;?></b></h3></font></td></td>
                            </span></tr>
                        </table>
                    
                        </div>
                    </div>
                        
                    
                    </br>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span7">
            <?php echo form_open_multipart('/projectdetail/caritanggal/');?>
                    Tanggal Awal: <input id="absensi-create-join-date" type="text" name="tanggal1" style="width: 100px;">  &nbsp;&nbsp;&nbsp; Tanggal Akhir: <input id="date-cari" type="text" name="tanggal2" style="width: 100px;">
                    <input type="hidden" value="<?php echo $proj['id'] ; ?>" name="sub">
                    <input type="submit" value="Filter" class="btn btn-success"/>
               </form>
            </div>
            <div class="span5">
                            <a class="btn btn-success btn-create" href="/projectdetail/cetaktukang/<?php echo $proj['projectid']; ?>/<?php echo $proj['id'] ; ?>" cls='btn' target="_blank">
                                <i class='icon-print'></i>&nbsp; Cetak </a>                            
            </div>
        </div>     
        <div class="row-fluid">
            <div class="span12">
                <div class="da-panel">
                    <div class="da-panel-header">
                    <span class="da-panel-title">
                        <i class="icol-table"></i><b> Tukang</b>
                    </span></tr>
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
                    
                        <table id="da-projectdetail-datatable-numberpaging" class="da-table">
                        <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jam Kerja</th>
                        </tr>
                        <?php foreach($absensi as $absensi): ?>
                             <tr>
                                <td class="division-row"><?php echo $absensi['name']; ?></td>
                                <td class="division-row"><?php echo number_format((float)$absensi['waktu'], 1, ',', ''); ?> Jam</td>
                            </tr>
                        <?php endforeach?>
                        
                        </thead>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div id="da-projectdetail-view-form-div" class="form-container">
            <form id="da-projectdetail-view-form-val" class="da-form" method="post">
                <div id="da-projectdetail-view-validate-error" class="da-message error" style="display:none;"></div>
                <div class="da-form-inline">
                    <h3 id="judul" align="center"></h3>
                    <div class="da-form-row" style="padding:20px 90px;">
                            <table id="table" border="1" style="font-size:16px;">
                                <tr style=background:#A9A9A9;>
                                    <th>Tanggal Pakai/Return</th>
                                    <th>Quantity</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Tukang</th>
                                </tr>            
                            </table>
                    </div>
                </div>
            </form>
            <div id="output">
                        </div>
        </div>

        <div id="da-projectdetail2-view-form-div" class="form-container">
            <form id="da-projectdetail2-view-form-val" class="da-form" method="post">
                <div id="da-projectdetail2-view-validate-error" class="da-message error" style="display:none;"></div>
                <div class="da-form-inline">
                    <h3 id="judul2" align="center"></h3>
                    <div class="da-form-row" style="padding:20px 90px;">
                            <table id="table2" border="1" style="font-size:16px;">
                                <tr style=background:#A9A9A9;>
                                    <th>Tanggal Pakai/Return</th>
                                    <th>Quantity</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Tukang</th>
                                </tr>         
                            </table>
                    </div>
                </div>
            </form>
            <div id="output">
                        </div>
        </div>
    </div>
</div>