<!-- Main Content Wrapper -->
<div id="da-content-wrap" class="clearfix">
    <!-- Content Area -->
    <div id="da-content-area">
        <div class="row-fluid">
            <div class="span12">
                <div class="da-panel">
                <?php foreach($stocks as $each_stock){ ?>
                    <div class="da-panel-header">
                        <span class="da-panel-title">
                            <i class="icol-grid"></i> <?php echo $each_stock['name']; ?>
                        </span>
                    </div>
                    <div class="da-panel-content da-table-container">
                    
                        <?php 
                            $allstocks = mysql_query("select stock_master.*, item_master.name, unit_master.name AS unit
                            FROM stock_master, item_master, unit_master 
                            WHERE stock_master.item_id = item_master.id AND item_master.unit_id = unit_master.id AND item_master.name = '$each_stock[name]'
                            ");
                        ?>
                        
                        <table id="da-stock-datatable-numberpaging" class="da-table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Barang</th>
                                    <th>Satuan Barang</th>
                                    <th>Harga Barang</th>
                                </tr>
                            </thead>
                            <?php while($allstock=mysql_fetch_array($allstocks)){?>
                            <tbody>
                                <tr>
                                    <td class="stock-code-row"><?php echo $allstock['id']; ?></td>
                                    <td class="stock-code-row"><?php echo $allstock['item_stock_code']; ?></td>
                                    <td class="name-row"><?php echo $allstock['name']; ?></td>
                                    <td class="count-row"><?php echo $allstock['item_count']; ?></td>
                                    <td class="unit-row"><?php echo $allstock['unit']; ?></td>
                                    <td class="price-row">
                                        <?php
                                            echo number_format($allstock['item_price'], 2, ',', '.');;
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                            <?php } ?>
                        </table>
                       
                    </div>
                    </br>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>