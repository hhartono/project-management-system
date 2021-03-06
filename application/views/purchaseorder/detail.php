<!-- Main Content Wrapper -->
<div id="da-content-wrap" class="clearfix">
    <!-- Content Area -->
    <div id="da-content-area">
        <div class="row-fluid">
                            <div class="span12" >
                                <button id="da-cetak-create-dialog" class="btn btn-success btn-create"><i class='icon-print'></i>&nbsp; Cetak </a></button>
                            </div>
                    </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="da-panel">
                    <div class="da-panel-header">
                   
                        <table>
                                    <tr><td><span class="da-panel-title">
                                        <i class="icol-table"></i><b> Nama Supplier</b></td><td> :</td><td><?php echo $detail['name']; ?></td>
                                    </span></tr>
                                    <tr><td><span class="da-panel-title">
                                        <i class="icol-table"></i><b> Nama Project</b></td><td> :</td><td><?php echo $detail['project']; ?></td>
                                    </span></tr>
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
                    
                        <table id="da-projectdetail-datatable-numberpaging" class="da-table">
                        <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Jumlah Dipesan</th>
                            <th>Satuan</th>
                        </tr>

                        </thead>
                        <tbody>
                        <?php foreach($po as $po): ?>
                            <tr>
                                <td class="division-row"><?php echo $po['item_name']; ?></td>
                                <td class="division-row"><?php echo $po['quantity']; ?></td>
                                <td class="division-row"><?php echo $po['unit_name']; ?></td>
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

    <div id="da-cetak-create-form-div" class="form-container">
        <form id="da-cetak-create-form-val" class="da-form" action="/purchaseorder/cetak/<?php echo $pod->po_id;?>" method="post" target="blank">
            <div id="da-cetak-create-validate-error" class="da-message error" style="display:none;"></div>
            <div class="da-form-inline">
                <div class="da-form-row">
                    <label class="da-form-label">Attn</label>
                    <div class="da-form-item large">
                        <input id="cetak-attn-create" type="text" name="attn">
                    </div>
                </div>
                <div class="da-form-row">
                    <label class="da-form-label">Deliver Address</label>
                    <div class="da-form-item large">
                        <select id="cetak-deliver-create" name="deliver">
                            <option value="">Deliver Address</option>
                            <option value="project">Project</option>
                            <option value="inerre">Inerre</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>