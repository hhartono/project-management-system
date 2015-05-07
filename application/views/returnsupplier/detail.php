<!-- Main Content Wrapper -->
<div id="da-content-wrap" class="clearfix">
    <!-- Content Area -->
    <div id="da-content-area">
        <div class="row-fluid">
                            <div class="span12" >
                                     <a class="btn btn-success btn-create" href="/returnsupplier/cetak/<?php echo $pod->id;?>" target="_blank">
                                    <i class='icon-print'></i>&nbsp; Cetak </a>
                            </div>
                    </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="da-panel">
                    <div class="da-panel-header">
                   
                        <table>
                                    <tr><td><span class="da-panel-title">
                                        <i class="icol-table"></i><b> Nama Supplier</b></td><td> :</td><td><?php echo $detail['name']; ?></td>
                                    </span></td></tr>
                        </table>
                        
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
                            <th>Nama Barang</th>
                            <th>Jumlah Return</th>
                            <th>Satuan</th>
                        </tr>

                        </thead>
                        <tbody>
                        <?php foreach($po as $po): ?>
                            <tr>
                                <td class="division-row"><?php echo $po['item']; ?></td>
                                <td class="division-row"><?php echo $po['kembali']; ?></td>
                                <td class="division-row"><?php echo $po['unit']; ?></td>
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