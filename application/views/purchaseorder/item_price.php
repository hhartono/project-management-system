            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <div class="row-fluid">
                        <div class="span5">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i>  <?php 
                                            if(isset($purchaseorder_main)){
                                                   if(($purchaseorder_main->status_pembayaran) == 0){
                                                        echo "Status Pembayaran : <font color='red'>Belum Dibayar</font> ";
                                                        echo"<button id='bayar' class='btn btn-success'>  Bayar</button>";
                                                    }else{
                                                        echo "<b><font >Status Pembayaran</font></b> : <font color='green'>Sudah Dibayar</font></h4>";
                                                    }
                                                
                                            }else{
                                                echo "Status Pembayaran : Belum Dibayar";
                                                echo"<button id='bayar' class='btn btn-success'> Bayar</button>";
                                            }
                                        ?>
                                    </span>
                                </div>            
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Update Item Price
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
                                    <table id="da-purchaseorder-receiveprice-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th>Database ID</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Dipesan</th>
                                                <th>Jumlah Sudah Diterima</th>
                                                <th>Harga per Unit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($purchaseorder_details as $purchaseorder_details): ?>
                                        <div id="da-purchaseorder-receive-detail-error" class="da-message error" style="display:none;"></div>
                                                <div class="da-panel-content da-form-container">
                                    <form id="da-purchaseorder-receive-detail-form-val" class="da-form da-form-inline" action="/purchaseorder/update_itemprice/<?php echo $purchaseorder_details['po_id'];?>" method="post">
                                                    <input type="hidden" name="id[]" value="<?php echo $purchaseorder_details['stockid']; ?>">
                                                <tr>
                                                    <td class="database-id-row" name="po_detail_id"><?php echo $purchaseorder_details['po_id']; ?></td>
                                                    <td class="name-row" name="item_name"><?php echo $purchaseorder_details['item_name']; ?></td>
                                                    <td class="quantity-order-row" name="quantity_ordered"><?php echo $purchaseorder_details['quantity']; ?></td>
                                                    <td class="quantity-already-received-row" name="quantity_already_received"><?php echo $purchaseorder_details['quantity_received']; ?></td>
                                                    <td>
                                                    <?php if(isset($purchaseorder_main)){
                                                    if(($purchaseorder_main->status_pembayaran) == 0){ ?>
                                                        <input name="item_price[]" type="text" class="span6" value="<?php echo $purchaseorder_details['item_price']; ?>">                                                        
                                                    <?php }else{
                                                        echo $purchaseorder_details['item_price'];
                                                        }
                                                    }
                                                    ?>
                                                    </td>                                                    
                                                </tr>                                          
                                </div>
                                <?php endforeach?>                                
                                        </tbody>
                                    </table>
                                   
                                </div>
                            </div>
                             <div class="row-fluid">
                            <div class="span12">
                            <?php if(isset($purchaseorder_main)){
                                if(($purchaseorder_main->status_pembayaran) == 0){ ?>
                                <input type="submit" value="Update" class="btn btn-success btn-create">
                                <?php }else{
                                    echo "";
                                }
                            }
                            ?>
                            </div>
                        </div>
                        </div>
                    </div>
                </div></form>

                <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel"><br>
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Pembayaran
                                    </span>
                                </div>                                
                                <div class="da-panel-content da-table-container">
                                    <table id="da-purchaseorder-receiveprice-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th>Tanggal Pembayaran</th>
                                                <th>Nama Company</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($getpembayaran as $gp): ?>
                                                <div class="da-panel-content da-form-container">
                                                <tr>
                                                    <td class="database-id-row"><?php echo $gp['date']; ?></td>
                                                    <td class="name-row"><?php echo $gp['name']; ?></td>
                                                    <td class="quantity-order-row"><?php echo $gp['jumlah']; ?></td>                                                    
                                                </tr>                                          
                                        </div>
                                        <?php endforeach?>
                                        <tr>
                                            <td colspan="3">
                                            <?php
                                                if(isset($purchaseorder_main)){
                                                    if(($purchaseorder_main->status_pembayaran) == 0){
                                                        echo "<b>Jumlah yang harus dibayar sebesar : "; echo $total->total - $pembayaran->jumlah;
                                                    }else{
                                                        echo "<b>Jumlah yang harus dibayar : <font color='green'>Sudah Dibayar</font>";
                                                    }
                                                }
                                            ?>
                                            </td>
                                        </tr>                                
                                        </tbody>
                                    </table>                                    
                                </div>
                            </div>
                        </div>
                    </div>                        
            </div>

            <div id="da-project-create-form-div" class="form-container">
                <form id="da-project-create-form-val" class="da-form" action="/purchaseorder/pembayaran/<?php echo $total->po_id; ?>" method="post">
                    <div id="da-project-create-validate-error" class="da-message error" style="display:none;"></div>
                    <div class="da-form-inline">
                        <div class="da-form-row">
                            <label class="da-form-label">Nama Company</label>
                            <div class="da-form-item large">
                            <?php if (empty($pembayaran->name)){ ?>
                                <input id="project-create-company" type="text" name="company_name">
                            <?php }else{ ?>
                                <input id="project-create-company" type="text" name="company_name" value="<?php echo $pembayaran->name;?>" disabled>
                            <?php } ?>
                            </div>
                        </div>
                        <div class="da-form-row">
                            <label class="da-form-label">Jumlah Bayar</label>
                            <div class="da-form-item large">
                                <input type="text" name="jumlah" value="<?php echo $total->total - $pembayaran->jumlah;?>">
                            </div>
                        </div>                        
                        <div class="da-form-row">
                            <label class="da-form-label">Tanggal Bayar</label>
                            <div class="da-form-item large">
                                <?php
                                    date_default_timezone_set('Asia/Jakarta');
                                    $tanggal= mktime(date("m"),date("d"),date("Y"));
                                    $tglsekarang = date("d-m-Y", $tanggal);                                    
                                ?>
                                <input id="project-create-start-date" type="text" name="date" value="<?php echo $tglsekarang;?>" autocomplete="off">
                            </div>
                        </div>
                        <?php foreach ($postock as $postock) { ?>
                        <input type="hidden" name="stockid[]" value="<?php echo $postock->stockid; ?>">
                        <?php } ?>
                        <input type="hidden" value="<?php echo $total->po_id; ?>" name="po_id">
                        <input type="hidden" name="harga" value="<?php echo $pembayaran->jumlah; ?>">
                        <input type="hidden" name="total" value="<?php echo $total->total;?>">
                    </div>
                </form>
            </div>