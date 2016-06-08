            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                            <div class="span12" >
                                <button id="da-warna-create-dialog" class="btn btn-success btn-create">[+] Tambah Warna</button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Lihat Warna
                                    </span>
                                </div>
                                </br>
                                <?php foreach ($warnas as $warna) { ?>
                                <div class="da-panel-content da-table-container">
                                        <form action="" method="post">
                                            <div class="da-form-inline">
                                                <div class="span4">
                                                    <div class="da-form-item large">
                                                        <textarea style="width:350px; height: 180px; background-color:<?php echo $warna['hexadecimal']; ?>" readonly></textarea>
                                                    </div>
                                                </div>
                                                <div class="da-form-row">
                                                    <label class="da-form-label">Kode Warna</label>
                                                    <div class="da-form-item large">
                                                        <input type="text" name="kode_warna" value="<?php echo $warna['kode_warna'];?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="da-form-row">
                                                    <label class="da-form-label">Nama Warna</label>
                                                    <div class="da-form-item large">
                                                        <input type="text" name="nama_warna" value="<?php echo $warna['nama_warna'];?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="da-form-row">
                                                    <label class="da-form-label">Kode Pantone</label>
                                                    <div class="da-form-item large">
                                                        <input type="text" name="kode_pantone" value="<?php echo $warna['kode_pantone'];?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="da-form-row">
                                                    <label class="da-form-label">Hexadecimal</label>
                                                    <div class="da-form-item large">
                                                        <input type="text" name="hexadecimal" autocomplete="off" value="<?php echo $warna['hexadecimal'];?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>