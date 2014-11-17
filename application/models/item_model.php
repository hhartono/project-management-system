<?php
class Item_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_item_by_id($id){
        $query = $this->db->get_where('item_master', array('id' => $id));
        return $query->row_array();
    }

    public function get_item_by_name($name){
        $query = $this->db->get_where('item_master', array('name' => $name));
        return $query->result_array();
    }

    public function get_all_items()
    {
        $this->db->select('item_master.*, unit_master.name AS unit');
        $this->db->from('item_master');
        $this->db->join('unit_master', 'item_master.unit_id = unit_master.id');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function update_item()
    {
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
    }

    public function set_item()
    {
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
    }

    public function delete_item($item_id){
        $response = $this->db->delete('item_master', array('id' => $item_id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
    }
}