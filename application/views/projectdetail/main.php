            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Project Detail
                                    </span>
                                </div>
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <?php print 'Cari Berdasarkan Perusahaan : ';?>
                                            <form action="<?php echo base_url();?>projectdetail/cari" method=POST>
                                            <select class="form-control" name="cari">
                                        <?php 
                                            echo '<option>--- Pilih Perusahaan ---</option>';
                                            foreach($getcompany as $row)
                                            {            
                                                echo '<option value="'.$row->name.'">'.$row->name.'</option>';
                                            }
                                        ?>
                                            </select>
                                            <input type="submit" class="btn btn-success" value="Filter">
                                            </form>
                                    </span>
                                </div>

                                <?php if(isset($message['success'])): ?>
                                   <div class="da-message success">
                                    <?php echo $message['success']; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if(isset($message['info'])): ?>
                                    <div class="da-message info"><?php echo $message['info']; ?></div>
                                <?php endif; ?>
                                <?php if(isset($message['error'])): ?>
                                    <div class="da-message error"><?php echo $message['error']; ?></div>
                                <?php endif; ?>

                                <div class="da-panel-content da-table-container">

                                    <table id="da-projectdetail-datatable-numberpaging" class="da-table">
                                        <thead>
                                            <tr>
                                                <th>Project</th>
                                                <th>Sub Project</th>
                                                <?php 
                                                if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])): ?>
                                                    <?php
                                                        $control_label_array = array();
                                                        $control_label_array[] = "Lihat";
                                                    ?>
                                                    <th><?php echo implode('/', $control_label_array); ?></th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                            $counter = 1;
                                            if(is_array($getproject)){
                                            foreach($getproject as $each):
                                        ?>
                                            <form action="<?php echo base_url();?>projectdetail/detail/" method="POST">
                                            <tr>
                                                <?php
                                                foreach ($each as $key => $value):
                                                    if($key==0):
                                                        ?>
                                                        <td class="code-row">
                                                            <?php echo $value; 

                                                            $val = $value;
                                                            ?>
                                                        </td>
                                                <?php
                                                    endif;

                                                    if($key == 1):
                                                ?>
                                                        <td class="name-row">
                                                            <select id="selectsub-<?php echo $counter;?>" name="sub" onChange="getValSubproject(<?php echo $counter;?>)">
                                                                <option>--- Sub Project ---</option>
                                                            <?php 
                                                            if($value!=''){
                                                                foreach ($value as $sub):
                                                           
                                                            ?>
                                                                    <option value="<?php echo $sub->idsubproject;?>">
                                                                        <?php echo $sub->subprojectname;?>
                                                                    </option>
                                                            <?php
                                                                endforeach;
                                                            }else{
                                                            ?>
                                                                <option DISABLED value="0">NO SUBPROJECT(S)</option>
                                                            <?php
                                                            }
                                                            ?>
                                                            </select>
                                                        </td>
                                                <?php
                                                    endif;
                                                    
                                                    if($key == 2):
                                                        if ((isset($access['edit']) && $access['edit']) || (isset($access['delete']) && $access['delete'])):
                                                     ?>
                                                        <td class="da-icon-column">
                                                            <input type="hidden" name="idproject" id="idproject-<?php echo $counter;?>" value="<?php echo $key;?>">
                                                            <a id="view-<?php echo $counter;?>" title="project detail" href="">
                                                                <i class="icol-eye"></i>
                                                            </a>
                                                        </td>
                                                        <?php endif;
                                                    endif;
                                                endforeach;
                                        ?>
                                            </tr>
                                            </form>
                                        <?php 

                                            $counter++;

                                            endforeach;
                                        }
                                        ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>