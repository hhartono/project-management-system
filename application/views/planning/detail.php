<!-- Main Content Wrapper -->
<div id="da-content-wrap" class="clearfix">
    <!-- Content Area -->
    <div id="da-content-area">
        <div class="row-fluid">
            <div class="span12">
                <h3 align="center"><?php echo $proj->project; ?> - <?php echo $proj->name;?></h3>
            </div>
        </div>
        </br>
        <div class="row-fluid">
            <div class="span7">
            <?php echo form_open_multipart('/planning/cariitem/');?>
                Subproject Item: <select name="subitem">
                    <option value="">--- Pilih Subproject Item---</option>
                    <?php
                        foreach ($subitem as $subitem) {
                            echo "<option value='$subitem[id]'> $subitem[name] </option> ";
                        }
                    ?></select>   
                    <input type="hidden" value="<?php echo $proj->id ; ?>" name="sub">
                    <input type="submit" value="Submit" class="btn btn-success"/>
               </form>
            </div>
            <div class="span5">
                <button id="da-planning-create-dialog" class="btn btn-success btn-create">[+] Tambah Subproject Item</button>          
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="da-panel">
                <div class="da-panel-header">
                    <span class="da-panel-title">
                        <i class="icol-grid"></i> Planning
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
                    <?php
                        $subproject='' ;
                    ?>
                    <div class="da-panel-content da-table-container">
                    
                        <table id="da-plannings-datatable-numberpaging" class="da-table">
                        <thead>
                        <tr>
                            <th>Sub Project Item</th>
                            <th>Kategori</th>
                            <th>Nama Barang</th>
                            <th>Quantity</th>
                            <th>Satuan</th>
                            <th>Finishing Depan</th>
                            <th>Finishing Belakang</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if(!empty($detail))
                        {
                            foreach($detail as $details): ?>
                        <?php
                            if($subproject!=$details['subproject'])
                            {
                                $subproject=$details['subproject'];
                            }
                            else
                            {
                                $subproject='';
                            }
                        ?>
                            <tr>
                                <td class="division-row"><?php echo $subproject; ?></td>
                                <td class="division-row"><?php echo $details['category']; ?></td>
                                <td class="division-row"><?php echo $details['item']; ?></td>
                                <td class="division-row"><?php echo $details['quantity']; ?></td>
                                <td class="division-row"><?php echo $details['unit']; ?></td>
                                <?php if(empty($details['finishing'])){ ?>
                                <td class="division-row"><?php echo "Tidak Ada"; ?></td>
                                <?php    
                                    }else{
                                ?>    
                                <td class="division-row"><?php echo $details['finishing']; ?></td>
                                <?php } ?>
                                <?php if(empty($details['finishing_belakang'])){ ?>
                                <td class="division-row"><?php echo "Tidak Ada"; ?></td>
                                <?php    
                                    }else{
                                ?>    
                                <td class="division-row"><?php echo $details['finishing_belakang']; ?></td>
                                <?php } ?>
                            </tr>
                            <?php $subproject =$details ['subproject']; ?>
                           
                            <?php endforeach?>
                        <?php
                            }else{
                        ?>
                            <tr><td colspan="7">Data Tidak Ada, Silahkan Isi Subproject Item Terlebih Dahulu!</td></tr>
                       <?php } ?>
                       </tbody>
                        </table>
                        
                    </div>
                    </br>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="da-panel">
                <div class="da-panel-header">
                    <span class="da-panel-title">
                        <i class="icol-grid"></i> Cek Stock Barang
                    </span>
                </div>
                    <?php
                        $category='' ;
                    ?>
                    <div class="da-panel-content da-table-container">
                    
                        <table id="da-planning-datatable-numberpaging" class="da-table">
                        <thead>
                        <tr>                            
                            <th>Kategori</th>
                            <th>Nama Barang</th>
                            <th>Quantity</th>
                            <th>Satuan</th>
                            <th>Stock Tersedia</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                            foreach($stock as $stocks): ?>
                            <tr>
                                <td class="division-row"><?php echo $stocks['category']; ?></td>
                                <td class="division-row"><?php echo $stocks['item']; ?></td>
                                <td class="division-row"><?php echo $stocks['quantity']; ?></td>
                                <td class="division-row"><?php echo $stocks['unit']; ?></td>
                                <?php if(empty($stocks['stock'])){ ?>
                                <td class="division-row"><?php echo "Stock Kosong"; ?></td>
                                <?php    
                                    }else{
                                ?>    
                                <td class="division-row"><?php echo $stocks['stock']; ?></td>
                                <?php } ?>
                                <?php if(($stocks['stock'] >= $stocks['quantity'])){ ?>
                                <td class="division-row"><?php echo "Item Tersedia"; ?></td>
                                <?php    
                                    }else{
                                        $kurang = $stocks['quantity'] - $stocks['stock'];
                                ?>    
                                <td class="division-row">Item Kurang :&nbsp; <font style="color:red;"><?php echo $kurang ; ?></font>&nbsp; Unit</td>
                                <?php } ?>
                            </tr>                           
                            <?php endforeach?>
                       </tbody>
                        </table>
                        
                    </div>
                    </br>
                </div>
            </div>
        </div>

        <div id="da-planning-create-form-div" class="form-container">
            <form id="da-planning-create-form-val" class="da-form" action="/planning/submititem" method="post">
                <div id="da-planning-create-validate-error" class="da-message error" style="display:none;"></div>
                <div class="da-form-inline">
                    <div class="da-form-row">
                        <label class="da-form-label">Subproject Item</label>
                    <div class="da-form-item large">
                        <input type="text" name="name" autocomplete="off">
                    </div>
                    <input type="hidden" value="<?php echo $proj->id ; ?>" name="sub">
                    <input type="hidden" value="<?php echo $this->input->post('subitem') ; ?>" name="subitem">
                    </div>
                </div>
            </form>
        </div>        
    </div>
</div>