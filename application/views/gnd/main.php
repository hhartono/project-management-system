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
                            <div class="da-panel ">
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
                                <form action="#" class="da-panel-content">
                                    <b>Jenis Dokumen : </b>
                                    <select id="doc_type" name="doc_types">
                                        <option selected disabled>--Pilih Jenis Dokumen--</option>
                                        <option>Invoice</option>
                                        <option>Quotation</option>
                                        <option>PO</option>
                                    </select> &nbsp;
                                    <select id="month">
                                        <option selected disabled>--Pilih Bulan--</option>
                                        <option>Januari</option>
                                        <option>Februari</option>
                                        <option>Maret</option>
                                        <option>April</option>
                                        <option>Mei</option>
                                        <option>Juni</option>
                                        <option>Juli</option>
                                        <option>Agustus</option>
                                        <option>September</option>
                                        <option>Oktober</option>
                                        <option>November</option>
                                        <option>Desember</option>
                                    </select> &nbsp;
                                    <input type="submit" id="create_new_doc" class="btn btn-primary" name="cnd" value="Create Document">
                                </form>
                                <div class="da-panel-content da-table-container">
                                    <table id="gnd-report" class="da-table">
                                        <thead>
                                            <th>No</th>
                                            <th>Date Created</th>
                                            <th>Client</th>
                                            <th>Supplier</th>
                                            <th>Project</th>
                                            <th>Invoice Number</th>
                                            <th>Document Number</th>
                                            <th>Ket</th>
                                        </thead>
                                    </table>

                                    <table id="gnd-report-2" class="da-table">
                                        <thead>
                                            <th>No</th>
                                            <th>Date Created</th>
                                            <th>Client</th>
                                            <th>Supplier</th>
                                            <th>Project</th>
                                            <th>Invoice Number</th>
                                            <th>Document Number</th>
                                            <th>Ket</th>
                                        </thead>
                                    </table>

                                    <table id="gnd-report-3" class="da-table">
                                        <thead>
                                            <th>No</th>
                                            <th>Date Created</th>
                                            <th>Client</th>
                                            <th>Supplier</th>
                                            <th>Project</th>
                                            <th>Invoice Number</th>
                                            <th>Document Number</th>
                                            <th>Ket</th>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Create Invoice Form -->
                    <div id="da-gnd-create-form-invoice-div" class="form-container modal">                   
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
                                        <input type="text" id="project" name="project" autocomplete="off">
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
                                    <input type="submit" id="search_inv" name="search_inv" class="btn btn-danger" value="Search" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <div class="da-form-label large">
                                        <input type="submit" id="generate_inv" name="generate" class="btn btn-primary" value="Generate" autocomplete="off">
                                    </div>
                                    <div class="da-form-item large">
                                        <input type="text" id="doc_num_inv" name="doc_num" autocomplete="off" readonly>
                                        <input type="button" id="btn_cp_inv" class="btn btn-default" value="Copy" data-clipboard-target="#doc_num_inv">
                                    </div>
                                </div>
                                <input type="hidden" id="user" value="<?php echo $userid; ?>" name="user">
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
                                        <input type="text" id="klienq" name="klien" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Project</label>
                                    <div class="da-form-item large">
                                        <input type="text" id="projectq" name="project" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <div class="da-form-label large">
                                        <input type="submit" id="generate_quo" name="generate" class="btn btn-primary" value="Generate" autocomplete="off">
                                    </div>
                                    <div class="da-form-item large">
                                        <input type="text" id="doc_num_quo" name="doc_num" autocomplete="off" readonly>
                                        <input type="button" id="btn_cp_quo" class="btn btn-default" value="Copy" data-clipboard-target="#doc_num_quo">
                                    </div>
                                </div>
                                <input type="hidden" id="user" value="<?php echo $userid; ?>" name="user">
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
                                        <input type="text" id="supplier" name="supplier" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Nama Project</label>
                                    <div class="da-form-item large">
                                        <input type="text" id="projectp" name="project" autocomplete="off">
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <div class="da-form-label large">
                                        <input type="submit" id="generate_po" name="generate" class="btn btn-primary" value="Generate" autocomplete="off">
                                    </div>
                                    <div class="da-form-item large">
                                        <input type="text" id="doc_num_po" name="doc_num" autocomplete="off" readonly>
                                        <input type="button" id="btn_cp_po" class="btn btn-default" value="Copy" data-clipboard-target="#doc_num_po">
                                    </div>
                                </div>
                                <input type="hidden" id="user" value="<?php echo $userid; ?>" name="user">
                            </div>
                        </form>
                    </div>
                </div>
            </div>