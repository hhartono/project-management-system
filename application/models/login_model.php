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
        $return_value['project'] = !empty($result['project']) ? $result['project'] : '';
        $return_value['purchase_order'] = !empty($result['purchase_order']) ? $result['purchase_order'] : '';
        $return_value['use_item'] = !empty($result['use_item']) ? $result['use_item'] : '';
        $return_value['category_item'] = !empty($result['category_item']) ? $result['category_item'] : '';
        $return_value['item'] = !empty($result['item']) ? $result['item'] : '';
        $return_value['stock_item'] = !empty($result['stock_item']) ? $result['stock_item'] : '';
        $return_value['supplier'] = !empty($result['supplier']) ? $result['supplier'] : '';
        $return_value['unit_item'] = !empty($result['unit_item']) ? $result['unit_item'] : '';
        $return_value['subproject'] = !empty($result['subproject']) ? $result['subproject'] : '';
        $return_value['customer'] = !empty($result['customer']) ? $result['customer'] : '';
        $return_value['worker'] = !empty($result['worker']) ? $result['worker'] : '';
        $return_value['division_worker'] = !empty($result['division_worker']) ? $result['division_worker'] : '';
        return $return_value;
    }
}