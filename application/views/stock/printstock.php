<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=stocks.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table>
    <thead>
        <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Jumlah Barang</th>
            <th>Satuan Barang</th>
            <th>Harga Barang</th>
            <th>Minimal Stock</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($stocks as $each_stock): ?>
            <tr>
                <td class="stock-code-row"><?php echo $each_stock['item_code']; ?></td>
                <td class="name-row"><?php echo $each_stock['name']; ?></td>
                <td class="count-row"><?php echo $each_stock['item_count']; ?></td>
                <td class="unit-row"><?php echo $each_stock['unit']; ?></td>
                <td class="price-row">
                    <?php
                        echo number_format($each_stock['item_price'], 2, ',', '.');;
                    ?>
                </td>
                <td><?php echo $each_stock['min_stock']; ?></td>
            </tr>
        <?php endforeach?>
    </tbody>
</table>