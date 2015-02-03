<?php
class Login_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function authenticate_user($user_name, $password)
    {
        $query = $this->db->get_where('user_master', array('username' => $user_name, 'password' => $password));
        return $query->row_array();
    }

    public function get_user_info($user_id){
        $query = $this->db->get_where('user_master', array('id' => $user_id));
        $result = $query->row_array();
        $return_value['name'] = !empty($result['name']) ? $result['name'] : 'Guest';
        $return_value['title'] = !empty($result['title']) ? $result['title'] : '';
        return $return_value;
    }
}