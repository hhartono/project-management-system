<!-- Main Content Wrapper -->
<div id="da-content-wrap" class="clearfix">
    <!-- Content Area -->
    <div id="da-content-area">
        
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
                    <div class="row-fluid">
                        <div class="span12" >
                            <?php foreach($pro as $pro): ?>
                                <a class="btn btn-success btn-create" href="/projectdetail/cetak/<?php echo $pro['projectid']; ?>/<?php echo $pro['id'] ; ?>" cls='btn' >
                                <i class='icon-print'></i>Cetak </a>
                            <?php endforeach?>
                        </div>
                    </div>
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
                </div>
            </div>
        </div>
    </div>
</div>