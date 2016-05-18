<?php
class Stock_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_stock_by_id($id){
        $this->db->select('stock_master.*, item_master.name, unit_master.name AS unit, supplier_master.name AS supplier, project_master.name AS project');
        $this->db->from('stock_master');
        $this->db->join('item_master', 'stock_master.item_id = item_master.id');
        $this->db->join('unit_master', 'item_master.unit_id = unit_master.id');
        $this->db->join('supplier_master', 'stock_master.supplier_id = supplier_master.id');
        $this->db->join('project_master', 'stock_master.project_id = project_master.id');
        $this->db->where('stock_master.id', $id);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function get_stocks_by_id($id){
        $this->db->select('stock_master.*, item_master.name, unit_master.name AS unit, supplier_master.name AS supplier, project_master.name AS project');
        $this->db->from('stock_master');
        $this->db->join('item_master', 'stock_master.item_id = item_master.id');
        $this->db->join('unit_master', 'item_master.unit_id = unit_master.id');
        $this->db->join('supplier_master', 'stock_master.supplier_id = supplier_master.id');
        $this->db->join('project_master', 'stock_master.project_id = project_master.id');
        $this->db->where('stock_master.item_id', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_stock_by_stock_code($stock_code){
        $query = $this->db->get_where('stock_master', array('item_stock_code' => $stock_code));
        return $query->row_array();
    }

    public function get_stock_item_detail_by_stock_code($stock_code){
        $this->db->select('stock_master.*, item_master.name AS item_name, unit_master.name AS item_unit');
        $this->db->from('stock_master');
        $this->db->join('item_master', 'stock_master.item_id = item_master.id');
        $this->db->join('unit_master', 'item_master.unit_id = unit_master.id');
        $this->db->where('stock_master.item_stock_code', $stock_code);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function get_stock_item_detail_by_item_code($item_code){
        $query = $this->db->query("select stock_master.id as id, item_master.name AS item_name, item_master.item_code AS item_code, unit_master.name AS item_unit, sum(stock_master.item_count) as jumlah, GROUP_CONCAT(DISTINCT stock_master.id ORDER BY stock_master.id ASC SEPARATOR ', ') as idstock, category_master.name as category
       from stock_master join item_master ON stock_master.item_id = item_master.id
       join unit_master ON item_master.stock_unit_id = unit_master.id
       join category_master ON category_master.id = item_master.category_id 
        where item_master.item_code = '$item_code' AND stock_master.item_count!=0
        UNION
        select stock_pelapis_master.id as id, item_master.name AS item_name, stock_pelapis_master.stock_kode_pelapis AS item_code, unit_master.name AS item_unit, sum(stock_pelapis_master.jumlah) as jumlah, GROUP_CONCAT(DISTINCT stock_pelapis_master.id ORDER BY stock_pelapis_master.id ASC SEPARATOR ', ') as idstock, category_master.name as category
       from stock_pelapis_master join item_master ON stock_pelapis_master.item_id = item_master.id
       join unit_master ON item_master.stock_unit_id = unit_master.id
       join category_master ON category_master.id = item_master.category_id 
        where stock_pelapis_master.stock_kode_pelapis = '$item_code' AND stock_pelapis_master.jumlah!=0
        UNION
        select stock_press_master.id as id, CONCAT(stock_press_master.bahan_dasar, stock_press_master.sisi1, stock_press_master.sisi2) as item_name, stock_press_master.stock_press_code as item_code, unit_master.name as item_unit, stock_press_master.jumlah as jumlah, stock_press_master.id as idstock, category_master.name as category
            from stock_press_master join unit_master ON unit_master.id = stock_press_master.unit_id join category_master ON category_master.id = stock_press_master.category_id
            where stock_press_master.stock_press_code = '$item_code' AND stock_press_master.jumlah !=0 ORDER by id DESC
        
        ");

        return $query->row_array();
    }

    public function get_stock_item_detail_by_item_code_return($item_code){
        $query = $this->db->query("select stock_master.id as id, item_master.name AS item_name, item_master.item_code AS item_code, unit_master.name AS item_unit, sum(stock_master.item_count) as jumlah, GROUP_CONCAT(DISTINCT stock_master.id ORDER BY stock_master.id ASC SEPARATOR ', ') as idstock
       from stock_master join item_master ON stock_master.item_id = item_master.id
       join unit_master ON item_master.unit_id = unit_master.id 
        where item_master.item_code = '$item_code'");

        return $query->row_array();
    }

    public function get_stock_item_by_stock_code($stock_code){
        $this->db->select('stock_master.*, item_master.name AS item_name, supplier_master.name as supplier, unit_master.name AS item_unit');
        $this->db->from('stock_master');
        $this->db->join('item_master', 'stock_master.item_id = item_master.id');
        $this->db->join('unit_master', 'item_master.unit_id = unit_master.id');
        $this->db->join('supplier_master', 'stock_master.supplier_id = supplier_master.id');
        $this->db->where('stock_master.item_stock_code', $stock_code);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function get_all_stocks()
    {
        $this->db->select('stock_master.*, item_master.name, item_master.id as itemid, item_master.item_code as item_code, unit_master.name AS unit');
        $this->db->from('stock_master');
        $this->db->join('item_master', 'stock_master.item_id = item_master.id');
        $this->db->join('unit_master', 'item_master.unit_id = unit_master.id');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function update_stock($database_input_array)
    {
        if($database_input_array['id'] && $database_input_array['item_id'] !== false
            && $database_input_array['supplier_id'] !== false && $database_input_array['project_id'] !== false
            && $database_input_array['po_detail_id'] !== false && $database_input_array['item_price'] !== false
            && $database_input_array['item_count'] !== false){

            $data = array(
                'item_id' => $database_input_array['item_id'],
                'supplier_id' => $database_input_array['supplier_id'],
                'project_id' => $database_input_array['project_id'],
                'po_detail_id' => $database_input_array['po_detail_id'],
                'item_price' => $database_input_array['item_price'],
                'item_count' => $database_input_array['item_count'],
                'stock_awal' => $database_input_array['item_count'],
                'min_stock' => $database_input_array['min_stock']
            );

            $this->db->where('id', $database_input_array['id']);
            return $this->db->update('stock_master', $data);
        }else{
            return false;
        }
    }

    public function set_stock($database_input_array)
    {
        if($database_input_array['item_id'] !== false && $database_input_array['supplier_id'] !== false
            && $database_input_array['project_id'] !== false && $database_input_array['po_detail_id'] !== false
            && $database_input_array['item_price'] !== false && $database_input_array['item_count'] !== false
            && $database_input_array['item_stock_code'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'item_id' => $database_input_array['item_id'],
                'supplier_id' => $database_input_array['supplier_id'],
                'project_id' => $database_input_array['project_id'],
                'po_detail_id' => $database_input_array['po_detail_id'],
                'item_price' => $database_input_array['item_price'],
                'item_count' => $database_input_array['item_count'],
                'stock_awal' => $database_input_array['item_count'],
                'min_stock' => $database_input_array['minstock'],
                'user_id' => $database_input_array['user'],
                'item_stock_code' => $database_input_array['item_stock_code'],
                'received_date' => date("Y-m-d H:i:s")
            );

            return $this->db->insert('stock_master', $data);
        }else{
            return false;
        }
    }

    public function update_item_count_stock($database_input_array)
    {
        if($database_input_array['item_id'] !== false
            && $database_input_array['item_count'] !== false){

            $counts = $this->get_stocks_by_id($database_input_array['item_id']);
            foreach ($counts as $coun) {
                $data = array(
                    'item_count' => $coun['item_count'] + $database_input_array['item_count'],
                    'stock_awal' => $coun['stock_awal'] + $database_input_array['item_count']
                );

                $this->db->where('item_id', $database_input_array['item_id']);
                return $this->db->update('stock_master', $data);
            }
        }else{
            return false;
        }
    }

    public function delete_stock($stock_id){
        $response = $this->db->delete('stock_master', array('id' => $stock_id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
    }

    public function update_view_limit($stock_id){
        if($stock_id !== false){

            $data = array(
                'view_limit' => '1'
            );

            $this->db->where('id', $stock_id);
            return $this->db->update('stock_master', $data);
        }else{
            return false;
        }
    }

    public function get_purchaseorder_detail_by_id($id){
        $this->db->select('stock_master.*, item_master.name AS item_name');
        $this->db->from('stock_master');
        $this->db->join('item_master', 'stock_master.item_id = item_master.id');
        //$this->db->join('stock_master', 'stock_master.item_id = item_master.id'); 
        $this->db->where('id', $id);
        $query = $this->db->get();

        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_barcode_detail_by_id($id){
        $this->db->select('stock_master.*, item_master.name AS item_name');
        $this->db->from('stock_master');
        $this->db->join('item_master', 'stock_master.item_id = item_master.id');
        $where = "stock_master.id='" . $id . "'";
        $this->db->where($where, NULL, FALSE);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function update_barcode_status_quantity($database_input_array, $id){
        // start database transaction
        $this->db->trans_begin();

        $barcode_print_values = $database_input_array['barcode_print_values'];
        foreach($barcode_print_values as $barcode_print_value){
            if($barcode_print_value['label_quantity'] > 0){
                $data = array(
                    'label_quantity' => $barcode_print_value['label_quantity'],
                    'print_status' => '1',
                );

                $this->db->where('id', $id);
                $this->db->update('stock_master', $data);
            }
        }

        // complete database transaction
        $this->db->trans_complete();

        // return false if something went wrong
        if ($this->db->trans_status() === FALSE){
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function get_stocks()
    {
        $query = $this->db->query("select * from item_master");

        return $query->result_array();
    }

    public function get_stocks_by_name($name)
    {
        $query = $this->db->query("select stock_master.*, item_master.name, unit_master.name AS unit
                            FROM stock_master, item_master, unit_master 
                            WHERE stock_master.item_id = item_master.id AND item_master.unit_id = unit_master.id AND item_master.name = '$name' limit 1
                            ");

        return $query->result_array();
    }

    public function get_stock_id($name, $id)
    {
        $query = $this->db->query("select stock_master.*, item_master.name, unit_master.name AS unit
                            FROM stock_master, item_master, unit_master 
                            WHERE stock_master.item_id = item_master.id AND item_master.unit_id = unit_master.id AND item_master.name = '$name' AND stock_master.id != '$id'");
        return $query->result_array();
    }

    public function get_stockscount_by_name($name)
    {
        $query = $this->db->query("select stock_master.id as id, stock_master.item_id as item_id, sum(stock_master.item_count) as item_count, item_master.name, unit_master.name AS unit
                            FROM stock_master, item_master, unit_master 
                            WHERE stock_master.item_id = item_master.id AND item_master.unit_id = unit_master.id AND item_master.name = '$name'
                            ");

        return $query->result_array();
    }

    public function update_stock_usage(){
        $this->db->trans_start();

        $itemname = $this->get_stocks();
        foreach ($itemname as $item) {
            
            //update stock_id transaction_usage_detail
            $stock = $this->get_stocks_by_name($item['name']);
            foreach ($stock as $stok) {
                $ids = $this->get_stock_id($item['name'], $stok['id']);
                foreach ($ids as $id) {
                
                    $data = array(
                        'stock_id' => $stok['id']
                    );

                    $this->db->where('stock_id', $id['id'] );
                    $this->db->update('transaction_usage_detail', $data);
                }
            }
        
            $count = $this->get_stockscount_by_name($item['name']);
            foreach ($count as $count) {

                //update item_count stock_master
                $data = array(
                    'item_count' => $count['item_count']
                );

                $this->db->where('id', $count['id']);
                $this->db->update('stock_master', $data);

                $stockcount = $this->get_stock_id($item['name'], $stok['id']);
                foreach ($stockcount as $stockcount) {
                
                    //delete stock id stock master    
                    $this->db->where('id', $stockcount['id']);
                    $this->db->delete('stock_master');
                }
            }
        }

        $this->db->trans_complete();

        // return false if something went wrong
        if ($this->db->trans_status() === FALSE){
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function get_all_limit_stocks()
    {
        $query = $this->db->query("select stock_master.*, item_master.item_code , item_master.name, item_master.id as itemid, unit_master.name AS unit
            FROM stock_master, item_master, unit_master
            where stock_master.item_id = item_master.id AND unit_master.id = item_master.unit_id AND stock_master.item_count <= stock_master.min_stock AND stock_master.view_limit = '0'");
        
        return $query->result_array();
    }

}