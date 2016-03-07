<?php
class Item_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_all_bahandasar()
    {
        $this->db->select('item_master.*, category_master.name AS category');
        $this->db->from('item_master');
        $this->db->join('category_master', 'item_master.category_id = category_master.id');
        $this->db->where('category_master.name', 'plywood')
        $query = $this->db->get();

        return $query->result_array();
    }

}