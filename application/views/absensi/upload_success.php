 <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Upload Absensi
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
                                <?php// echo $error;?>
                                <div class="row-fluid">
                                 	<div class="span12">
									<h3>File anda telah berhasil diupload </h3>
									<ul>
									<?php foreach ($upload_data as $item => $value):?>
										<li><?php echo $item;?>: <?php echo $value;?></li>
									<?php endforeach; ?>
									</ul>
									<p>
									<?php echo anchor('absensi/show_table', 'Lihat Absensi'); ?>
									</p>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>