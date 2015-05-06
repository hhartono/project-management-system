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
        $this->db->select('stock_master.*, item_master.name, unit_master.name AS unit');
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
                'item_count' => $database_input_array['item_count']
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
                'user_id' => $database_input_array['user'],
                'item_stock_code' => $database_input_array['item_stock_code'],
                'received_date' => date("Y-m-d H:i:s")
            );

            return $this->db->insert('stock_master', $data);
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
        $where = "stock_master.id='" . $id . "' AND (print_status='0' OR print_status='1')";
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
}