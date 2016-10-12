            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                            <div class="span12">
                                
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Generator No. Dokumen
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
                                    <table id="da-gnd-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                            <form id="from_doc" action="/gnd/show_report" method="post">
                                                Jenis Dokumen :
                                                <select id="doc_type" name="doc_types">
                                                    <option selected disabled>--Pilih Jenis Dokumen--</option>
                                                    <option>Invoice</option>
                                                    <option>Quotation</option>
                                                    <option>PO</option>
                                                </select>
                                                <input type="submit" id="create_new_doc" name="cnd" value="Create Document">
                                                <input type="submit" id="show_report" name="report" value="Show Report">
                                            </form>
                                            </tr>
                                            <tr>
                                                <?php if(!empty($type)): ?>
                                                    <?php if($type == 'inv'): ?>
                                                        <th>No</th>
                                                        <th>Date Created</th>
                                                        <th>Client</th>
                                                        <th>Project</th>
                                                        <th>Invoice Number</th>
                                                        <th>Document Number</th>                                                        
                                                    <?php elseif($type == 'quo'): ?>
                                                        <th>No</th>
                                                        <th>Date Created</th>
                                                        <th>Client</th>
                                                        <th>Project</th>
                                                        <th>Document Number</th>
                                                    <?php elseif($type == 'po'): ?>
                                                        <th>No</th>
                                                        <th>Date Created</th>
                                                        <th>Supplier</th>
                                                        <th>Project</th>
                                                        <th>Document Number</th>
                                                    <?php endif ?>
                                                    <?php
                                                        $control_label_array = array();
                                                        // $control_label_array[] = "Lihat";

                                                        if(isset($access['edit']) && $access['edit']){
                                                            $control_label_array[] = "Ubah";
                                                        }

                                                        if(isset($access['delete']) && $access['delete']){
                                                            $control_label_array[] = "Hapus";
                                                        }
                                                    ?>
                                                    <th><?php echo implode('/', $control_label_array); ?></th>
                                                <?php endif ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <!--Pakai if u/ tahu $report kosong atau isi-->
                                        <?php 
                                            $num = 0; 
                                            if(!empty($report)): 
                                                foreach($report as $each_report): ?>
                                                    <tr class="result">                                                    
                                                        <?php $num += 1; ?>
                                                        <td class="report-no-row"><?php echo $num; ?></td>
                                                        <?php if($type == 'inv'): ?>
                                                            <?php
                                                                $date_array = array();
                                                                if(!empty($each_report['creation_date'])){
                                                                    $date_array[] = $each_report['creation_date'];
                                                                }
                                                            ?>
                                                            <td class="report-date-row"><?php echo implode(', ', $date_array); ?></td>

                                                            <?php
                                                                $client_array = array();
                                                                if(!empty($each_report['client'])){
                                                                    $client_array[] = $each_report['client'];
                                                                }
                                                            ?>
                                                            <td class="client-row"><?php echo implode(', ', $client_array); ?></td>

                                                            <?php
                                                                $project_array = array();
                                                                if(!empty($each_report['project'])){
                                                                    $project_array[] = $each_report['project'];
                                                                }
                                                            ?>
                                                            <td class="project-row"><?php echo implode(', ', $project_array); ?></td>

                                                            <?php
                                                                $inv_num_array = array();
                                                                if(!empty($each_report['inv_num'])){
                                                                    $inv_num_array[] = $each_report['inv_num'];
                                                                }
                                                            ?>
                                                            <td class="inv-num-row"><?php echo implode(', ', $inv_num_array); ?></td>

                                                            <?php
                                                                $doc_num_array = array();
                                                                if(!empty($each_report['doc_num'])){
                                                                    $doc_num_array[] = $each_report['doc_num'];
                                                                }
                                                            ?>
                                                            <td class="doc_num-row"><?php echo implode(', ', $doc_num_array); ?></td>
                                                        <?php elseif($type == 'quo'): ?>
                                                            <?php
                                                                $date_array = array();
                                                                if(!empty($each_report['creation_date'])){
                                                                    $date_array[] = $each_report['creation_date'];
                                                                }
                                                            ?>
                                                            <td class="report-date-row"><?php echo implode(', ', $date_array); ?></td>

                                                            <?php
                                                                $client_array = array();
                                                                if(!empty($each_report['client'])){
                                                                    $client_array[] = $each_report['client'];
                                                                }
                                                            ?>
                                                            <td class="client-row"><?php echo implode(', ', $client_array); ?></td>

                                                            <?php
                                                                $project_array = array();
                                                                if(!empty($each_report['project'])){
                                                                    $project_array[] = $each_report['project'];
                                                                }
                                                            ?>
                                                            <td class="project-row"><?php echo implode(', ', $project_array); ?></td>

                                                            <?php
                                                                $doc_num_array = array();
                                                                if(!empty($each_report['doc_num'])){
                                                                    $doc_num_array[] = $each_report['doc_num'];
                                                                }
                                                            ?>
                                                            <td class="doc_num-row"><?php echo implode(', ', $doc_num_array); ?></td>
                                                        <?php elseif($type == 'po'): ?>
                                                            <?php
                                                                $date_array = array();
                                                                if(!empty($each_report['creation_date'])){
                                                                    $date_array[] = $each_report['creation_date'];
                                                                }
                                                            ?>
                                                            <td class="report-date-row"><?php echo implode(', ', $date_array); ?></td>

                                                            <?php
                                                                $supplier_array = array();
                                                                if(!empty($each_report['supplier'])){
                                                                    $supplier_array[] = $each_report['supplier'];
                                                                }
                                                            ?>
                                                            <td class="client-row"><?php echo implode(', ', $supplier_array); ?></td>

                                                            <?php
                                                                $project_array = array();
                                                                if(!empty($each_report['project'])){
                                                                    $project_array[] = $each_report['project'];
                                                                }
                                                            ?>
                                                            <td class="project-row"><?php echo implode(', ', $project_array); ?></td>

                                                            <?php
                                                                $doc_num_array = array();
                                                                if(!empty($each_report['doc_num'])){
                                                                    $doc_num_array[] = $each_report['doc_num'];
                                                                }
                                                            ?>
                                                            <td class="doc_num-row"><?php echo implode(', ', $doc_num_array); ?></td>
                                                        <?php endif ?>

                                                        <td class="da-icon-column">
                                                            <?php if(isset($access['edit']) && $access['edit']): ?>
                                                                <a class="da-report-edit-dialog" href="#" data-value="<?php echo $each_report['id']; ?>"><i class="icol-pencil"></i></a>
                                                            <?php endif; ?>

                                                            <?php if(isset($access['delete']) && $access['delete']):
                                                                $item_id = $each_report['id'];
                                                                $delete_url = "/gnd/delete_item/" . $item_id;
                                                            ?>
                                                            <a href=<?php echo $delete_url; ?>><i class="icol-cross"></i></a>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php if($type = 'quo'): ?>

                                            <?php endif ?>
                                        <?php endif ?>
                                        </tbody-->
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Create Invoice Form -->
                    <div id="da-gnd-create-form-invoice-div" class="form-container modal">
                        <!--form id="da-gnd-create-form-invoice-val" class="da-form" action="/gnd/create_doc" method="post"-->                   
                        <form id="da-gnd-create-form-invoice-val" class="da-form" method="post">
                            <div id="da-gnd-create-invoice-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline modal-content">
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Klien</label>
                                    <div class="da-form-item large">
                                        <input type="text" id="klien" name="klien" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Project</label>
                                    <div class="da-form-item large">
                                        <input type="text" id="project" name="project" autofocus autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Invoice ke</label>
                                    <div class="da-form-item large">
                                        <select id="inv_num" name="inv_num">
                                            <?php 
                                                for ($i = 0; $i < 20; $i++) { 
                                                    echo '<option>'.($i+1).'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <div class="da-form-label large">
                                        <input type="submit" id="generate_inv" name="generate" value="Generate" autocomplete="off">
                                        <!--input type="button" name="generate" onclick="alert('HW')" value="Generate" autocomplete="off"-->
                                        <!--input type="button" name="generate" value="Generate" autocomplete="off"-->
                                    </div>
                                    <div class="da-form-item large">
                                        <input type="text" id="doc_num_inv" name="doc_num" autocomplete="off" readonly>
                                        <input type="button" id="btnCopy" value="Copy">
                                    </div>
                                </div>
                                <input type="hidden" value="<?php echo $userid; ?>" name="user">
                                <input type="hidden" id="doc" name="doc" value="inv">
                            </div>
                        </form>
                    </div>

                    <!-- Create Quotation Form -->
                    <div id="da-gnd-create-form-quotation-div" class="form-container">
                        <form id="da-gnd-create-form-quotation-val" class="da-form" method="post">
                            <div id="da-gnd-create-quotation-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Klien</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="klien" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Project</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="project" autofocus autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <div class="da-form-label large">
                                        <input type="submit" id="generate_quo" name="generate" value="Generate" autocomplete="off">
                                    </div>
                                    <div class="da-form-item large">
                                        <input type="text" id="doc_num_quo" name="doc_num" autocomplete="off" readonly>
                                        <input type="button" id="btnCopy" value="Copy">
                                    </div>
                                </div>
                                <input type="hidden" value="<?php echo $userid; ?>" name="user">
                                <input type="hidden" id="doc" name="doc" value="quo">
                            </div>
                        </form>
                    </div>

                    <!-- Create PO Form -->
                    <div id="da-gnd-create-form-po-div" class="form-container">
                        <form id="da-gnd-create-form-po-val" class="da-form" method="post">
                            <div id="da-gnd-create-po-validate-error" class="da-message error" style="display:none;"></div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Supplier</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="supplier" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Project</label>
                                    <div class="da-form-item large">
                                        <input type="text" name="project" autofocus autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <div class="da-form-label large">
                                        <input type="submit" id="generate_po" name="generate" value="Generate" autocomplete="off">
                                    </div>
                                    <div class="da-form-item large">
                                        <input type="text" id="doc_num_po" name="doc_num" autocomplete="off" readonly>
                                        <input type="button" id="btnCopy" value="Copy">
                                    </div>
                                </div>
                                <input type="hidden" value="<?php echo $userid; ?>" name="user">
                                <input type="hidden" id="doc_po" name="doc" value="po">
                            </div>
                        </form>
                    </div>
                </div>
            </div>