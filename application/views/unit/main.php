            <!-- Main Content Wrapper -->
            <div id="da-content-wrap" class="clearfix">
                <!-- Content Area -->
                <div id="da-content-area">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="da-panel">
                                <div class="da-panel-header">
                                    <span class="da-panel-title">
                                        <i class="icol-grid"></i> Satuan
                                    </span>
                                </div>
                                <div class="da-panel-content da-table-container">
                                    <table id="da-unit-datatable-numberpaging" class="da-table"">
                                        <thead>
                                            <tr>
                                                <th>Kode Satuan</th>
                                                <th>Nama Satuan</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($units as $each_unit): ?>
                                                <tr>
                                                    <td><?php echo !empty($each_unit['abbreviation']) ? $each_unit['abbreviation'] : "-"; ?></td>
                                                    <td><?php echo !empty($each_unit['name']) ? $each_unit['name'] : "-"; ?></td>
                                                    <td><?php echo !empty($each_unit['notes']) ? $each_unit['notes'] : "-"; ?></td>
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