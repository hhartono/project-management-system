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

    public function get_stock_by_name($name){
        /*
        $query = $this->db->get_where('item_master', array('name' => $name));
        return $query->result_array();
        */
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

    public function update_stock()
    {
        /*
        if($this->input->post('id') !== false && $this->input->post('name') !== false
            && $this->input->post('unit_id') !== false && $this->input->post('notes') !== false){
            $data = array(
                'name' => $this->input->post('name'),
                'unit_id' => $this->input->post('unit_id'),
                'notes' => $this->input->post('notes')
            );

            $this->db->where('id', $this->input->post('id'));
            return $this->db->update('item_master', $data);
        }else{
            return false;
        }
        */
    }

    public function set_stock()
    {
        /*
        if($this->input->post('name') !== false && $this->input->post('unit_id') !== false
            && $this->input->post('notes') !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'name' => $this->input->post('name'),
                'unit_id' => $this->input->post('unit_id'),
                'notes' => $this->input->post('notes'),
                'creation_date' => date("Y-m-d H:i:s")
            );

            return $this->db->insert('item_master', $data);
        }else{
            return false;
        }
        */
    }

    public function delete_stock($stock_id){
        /*
        $response = $this->db->delete('item_master', array('id' => $item_id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
        */
    }
}