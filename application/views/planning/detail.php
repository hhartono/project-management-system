<!-- Main Content Wrapper -->
<div id="da-content-wrap" class="clearfix">
    <!-- Content Area -->
    <div id="da-content-area">
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
                    <input type="submit" value="Filter" class="btn btn-success"/>
               </form>
            </div>
            <div class="span5">
                <form method="post" action="/planning/submititem/">
                &nbsp; Tambah Subproject Item: <input type="text" name="subproject_item">
                <input type="hidden" value="<?php echo $proj->id ; ?>" name="sub">
                <input type="hidden" value="<?php echo $this->input->post('subitem') ; ?>" name="subitem">
                <input type="submit" value="Submit" class="btn btn-success btn-create">
                </form>                           
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
                    
                        <table id="da-planning-datatable-numberpaging" class="da-table">
                        <thead>
                        <tr>
                            <th>Sub Project Item</th>
                            <th>Kategori</th>
                            <th>Nama Barang</th>
                            <th>Quantity</th>
                            <th>Satuan</th>
                            <th>Finishing</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($detail as $details): ?>
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
                                <td class="division-row"><?php echo $details['finishing']; ?></td>
                            </tr>
                            <?php $subproject=$details['subproject']; ?>
                        <?php endforeach?>
                       </tbody>
                        </table>
                        
                    </div>
                    </br>
                </div>
            </div>
        </div>
        
    </div>
</div>