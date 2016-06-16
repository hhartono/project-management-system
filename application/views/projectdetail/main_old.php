            <!-- Main Content Wrapper -->
           <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <?php if (isset($access['create']) && $access['create']): ?>
                        <div class="row-fluid">
                        </div>
                    <?php endif; ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Project Detail
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
                                    <?php $nama = '' ; ?>
                                    <table id="da-projectdetail-datatable-numberpaging" class="da-table"">
                                        <thead>
                                            <tr>
                                                <th>Project</th>
                                                <th>Sub Project</th>
                                                    <?php
                                                        $control_label_array = array();
                                                        $control_label_array[] = "Lihat";
                                                    ?>
                                                    <th><?php echo implode('/', $control_label_array); ?></th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($projectdetail as $each_projectdetail): ?>
                                            <?php
                                            if($nama!=$each_projectdetail['project'])
                                            {
                                                $nama=$each_projectdetail['project'];

                                            }
                                            else
                                            {
                                                $nama='';

                                            }
                                            ?>
                                            <tr>
                                                <td class="code-row"><?php echo $nama; ?></td>
                                                <td class="name-row"><?php echo $each_projectdetail['name'];//form_dropdown('subproject',$sub); ?>
                                                </td>
                                                <td class="da-icon-column">
                                                    <a title="project detail" href="<?php echo base_url(); ?>projectdetail/detail/<?php echo $each_projectdetail['id']; ?>">
                                                        <i class="icol-eye"></i>
                                                    </a>
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