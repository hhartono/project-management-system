<?php
class Unit_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_all_units()
    {
        $query = $this->db->get('unit_master');
        return $query->result_array();
    }
}