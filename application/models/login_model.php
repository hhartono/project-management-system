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
}