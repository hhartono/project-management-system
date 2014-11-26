<?php
class Stock_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_stock_by_id($id){
        $this->db->select('stock_master.*, item_master.name, unit_master.name AS unit, supplier_master.name AS supplier');
        $this->db->from('stock_master');
        $this->db->join('item_master', 'stock_master.item_id = item_master.id');
        $this->db->join('unit_master', 'item_master.unit_id = unit_master.id');
        $this->db->join('supplier_master', 'stock_master.supplier_id = supplier_master.id');
        $this->db->where('stock_master.id', $id);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function get_stock_by_stock_code($stock_code){
        $query = $this->db->get_where('stock_master', array('item_stock_code' => $stock_code));
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
            && $database_input_array['supplier_id'] !== false && $database_input_array['subproject_id'] !== false
            && $database_input_array['po_detail_id'] !== false && $database_input_array['item_price'] !== false
            && $database_input_array['item_count'] !== false){

            $data = array(
                'item_id' => $database_input_array['item_id'],
                'supplier_id' => $database_input_array['supplier_id'],
                'subproject_id' => $database_input_array['subproject_id'],
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
            && $database_input_array['subproject_id'] !== false && $database_input_array['po_detail_id'] !== false
            && $database_input_array['item_price'] !== false && $database_input_array['item_count'] !== false
            && $database_input_array['item_stock_code'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'item_id' => $database_input_array['item_id'],
                'supplier_id' => $database_input_array['supplier_id'],
                'subproject_id' => $database_input_array['subproject_id'],
                'po_detail_id' => $database_input_array['po_detail_id'],
                'item_price' => $database_input_array['item_price'],
                'item_count' => $database_input_array['item_count'],
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
}