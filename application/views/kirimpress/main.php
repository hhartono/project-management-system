            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                <?php if (isset($access['create']) && $access['create']): ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <form id="da-kirimpress-add-form-val" class="da-form" action="/kirimpress/createpress" method="get">
                                <button id="da-purchase-create-dialog" class="btn btn-success btn-create">[+] Buat Kirim Barang</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Kirim Press
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
                                    <table id="da-purchaseorder-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Tanggal Kirim</th>
                                                <th>Kode Kirim Press</th>
                                                <th>Tanggal Terima Barang</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($kirimpress as $each_kirimpress): ?>
                                                <tr>
                                                    <td></td>
                                                    <td ><?php echo $each_kirimpress['creation_date']; ?></td>
                                                    <td class="code-row"><?php echo $each_kirimpress['kode_press']; ?></td>
                                                    <td class="closed-status-row">
                                                        <?php
                                                            if(empty($each_kirimpress['receive_date'])){
                                                                // po still open
                                                                $kirimpress_id = $each_kirimpress['id'];
                                                                $receive_url = "/kirimpress/receive/" . $kirimpress_id;
                                                        ?>
                                                        <?php if (isset($access['receive']) && $access['receive']): ?>
                                                            <form id="da-kirimpress-receive-form-val" class="da-form" action=<?php echo $receive_url; ?> method="post">
                                                                <button id="da-kirimpress-receive" class="btn btn-success">Terima Barang</button>
                                                            </form>
                                                        <?php endif; ?>
                                                        <?php
                                                            }else{
                                                                echo $each_kirimpress['receive_date'];
                                                        ?>
                                                        <?php
                                                            }
                                                        ?>
                                                    </td>
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