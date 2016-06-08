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
                                    <a class="btn btn-success btn-create" href="" cls='btn' target="_blank">
                                    <i class='icon-print'></i>&nbsp; Export PDF </a>

                                <?php foreach ($pattern as $pattern) { ?>
                                <div class="span2.5">
                                    <div class="da-panel">
                                        <div class="da-panel-content" style=" width:150px; height:80px; background: <?php echo $pattern['hexadecimal']; ?>">
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
                            </div>
                        </div>
                        <div class="span6 min-width-menu">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Preview Photo
                                    </span>
                                </div>
                                
                                <div id="gallery">
                                    <?php foreach ($gambar as $gambar) { ?>
                                        <div class="span2">
                                            <a href="/uploads/gambar/<?php echo $gambar['gambar'];?>" title="Satu">
                                                <img src="/uploads/gambar/<?php echo $gambar['gambar'];?>" alt="tutorial web design" >
                                            </a>                                            
                                        </div>
                                    <?php } ?>
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