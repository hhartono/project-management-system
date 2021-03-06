            <link rel="stylesheet" type="text/css" href="/assets/css/twd-base.css">
            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <div class="row-fixed">
                        <div class="span6 min-width-menu">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Pattern
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
                                    <!-- <div class="da-form-row" style="margin: 10px 220px 10px;">
                                        <a class="btn btn-success btn-create" href="" cls='btn' target="_blank">
                                        <i class='icon-print'></i>&nbsp; Export PDF </a>
                                    </div> -->
                                    <br>
                                <?php foreach ($pattern as $pattern) { ?>
                                <div class="span2.5">
                                    <div class="da-panel">
                                        <div class="da-panel-content" style=" width:200px; height:90px; background: <?php echo $pattern['hexadecimal']; ?>">
                                        <form action="/warna/delete_pattern/<?php echo $uri;?>" method="post">
                                                <input type="hidden" name="id" value="<?php echo $pattern['id']; ?>">
                                                <button><i class="icol-cross"></i></button>
                                            </form>
                                            
                                        </div>
                                        <div>
                                            <b>Kode</b> &nbsp;&nbsp; <?php echo $pattern['kode']; ?>
                                        </div>
                                        <div>
                                            <b>Nama</b> &nbsp; <?php echo $pattern['nama']; ?>
                                        </div>
                                        <div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="span2.5">
                                    <div class="da-panel">
                                        <div class="da-panel-content" style=" width:200px; height:90px">
                                                        <button id="da-warna-cari-dialog" class="btn btn-info" data-target="#da-warna-cari-form-div"><i class="icol-add"></button></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span6 min-width-menu">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Corak
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
                                    <!-- <div class="da-form-row" style="margin: 10px 220px 10px;">
                                        <a class="btn btn-success btn-create" href="" cls='btn' target="_blank">
                                        <i class='icon-print'></i>&nbsp; Export PDF </a>
                                    </div> -->
                                <br>
                                <?php foreach ($corak as $corak) { ?>
                                <div class="span2.5">
                                    <div class="da-panel">
                                        <div class="da-panel-content" style=" width:200px; height:90px; ?>">
                                           <!--  <form action="/warna/delete_corak/<?php echo $uri;?>" method="post">
                                               <input type="hidden" name="id" value="<?php echo $corak['id']; ?>">
                                               <button><i class="icol-cross"></i></button>
                                           </form> -->
                                            <img src="/uploads/corak/<?php echo $corak['gambar']; ?>"></td>                                           
                                        </div>
                                        <div>
                                            <b>Kode</b> &nbsp;&nbsp; <?php echo $corak['kode']; ?>
                                        </div>
                                        <div>
                                            <b>Nama</b> &nbsp; <?php echo $corak['nama']; ?>
                                        </div>
                                        <div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="span2.5">
                                    <div class="da-panel">
                                        <div class="da-panel-content" style=" width:200px; height:90px">
                                            <button id="da-corak-cari-dialog" class="btn btn-info" data-target="#da-corak-cari-form-div"><i class="icol-add"></button></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="da-warna-cari-form-div" class="form-container">
                        <div id="da-warna-cari-validate-error" class="da-message error" style="display:none;"></div>
                        <div class="da-form-inline">
                            <div class="da-form-row">
                                <table id="da-warna-datatable-numberpaging" class="da-table">
                                    <thead>
                                        <tr>
                                            <th>Kode Warna</th>
                                            <th>Nama Warna</th>
                                            <th>Preview</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($warna as $warna) {
                                        ?>
                                            <tr class="pilih" data-kode="<?php echo $warna['kode_warna']; ?>">
                                                <td><?php echo $warna['kode_warna']; ?></td>
                                                <td><?php echo $warna['nama_warna']; ?></td>
                                                <td>
                                                <form id="da-warna-cari-form-val" class="da-form" action="/warna/create_pattern_warna/<?php echo $uri; ?>" method="post">
                                                    <input type="hidden" name="id" value="<?php echo $warna['id'];?>">
                                                <input type="submit" style="width:150px; height:50px; background:<?php echo $warna['hexadecimal'];?>" value="Klik Disini"></td>
                                                </form>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="da-corak-cari-form-div" class="form-container">
                        <div id="da-corak-cari-validate-error" class="da-message error" style="display:none;"></div>
                        <div class="da-form-inline">
                            <div class="da-form-row">
                                <table id="da-corak-datatable-numberpaging" class="da-table">
                                    <thead>
                                        <tr>
                                            <th>Kode Warna</th>
                                            <th>Nama Warna</th>
                                            <th>Preview</th>
                                            <th>Pilih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($corakmaster as $corakmaster) {
                                        ?>
                                            <tr class="pilih" data-kode="<?php echo $corakmaster['kode_corak']; ?>">
                                                <td><?php echo $corakmaster['kode_corak']; ?></td>
                                                <td><?php echo $corakmaster['nama_corak']; ?></td>
                                                <td><img src="/uploads/corak/<?php echo $corakmaster['gambar_corak']; ?>" style="height: 200px; width: 200px;"></td>
                                                <td>
                                                <form id="da-corak-cari-form-val" class="da-form" action="/warna/create_pattern_corak/<?php echo $uri; ?>" method="post">
                                                    <input type="hidden" name="id" value="<?php echo $corakmaster['id'];?>">
                                                <input type="submit" value="Pilih"></td>
                                                </form>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-container" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="image-gallery-title"></h4>
                                </div>
                                <div class="modal-body">
                                    <img id="image-gallery-image" class="img-responsive" src="">
                                </div>
                                <div class="modal-footer">
                    
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-primary" id="show-previous-image">Previous</button>
                                    </div>
                    
                                    <div class="col-md-8 text-justify" id="image-gallery-caption">
                                        This text will be overwritten by jQuery
                                    </div>
                    
                                    <div class="col-md-2">
                                        <button type="button" id="show-next-image" class="btn btn-default">Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>