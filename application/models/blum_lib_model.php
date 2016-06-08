<?php
class Blum_lib_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_item_by_id($id){
        $query = $this->db->get_where('blum_lib_parts', array('id' => $id));
        return $query->row_array();
    }

    public function get_item_by_code($code){
        $query = $this->db->get_where('blum_lib_parts', array('code' => $code));
        return $query->row_array();
    }
	
	public function get_item_by_group_code($group, $code){
		$this->db->select('blum_lib_parts.*');
        $this->db->from('blum_lib_parts');
        $this->db->where('group', $group);
        $this->db->where('code', $code);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_item_info($id){
        $query = $this->db->get_where('blum_lib_parts', array('id' => $id));
        $result = $query->row_array();
        $return_value['id']         = !empty($result['id']) ? $result['id'] : '';
        $return_value['group']      = !empty($result['group']) ? $result['group'] : '';
        $return_value['code']       = !empty($result['code']) ? $result['code'] : '';
        $return_value['description']= !empty($result['description']) ? $result['description'] : '';
        $return_value['quantity']   = !empty($result['quantity']) ? $result['quantity'] : '';
        return $return_value;
    }

    public function get_all_items()
    {
        $query = $this->db->get('blum_lib_parts');
        return $query->result_array();
    }

    public function update_item()
    {
        if($this->input->post('id') !== false && $this->input->post('group') !== false
            && $this->input->post('code') !== false && $this->input->post('description') !== false){
            $data = array(
                'group'                 => $this->input->post('group'),
                'code'                  => $this->input->post('code'),
                'description'           => $this->input->post('description'),
                'quantity'              => $this->input->post('quantity'),
                'last_update_timestamp' => date("Y-m-d H:i:s")
            );

            $this->db->where('id', $this->input->post('id'));
            return $this->db->update('blum_lib_parts', $data);
        }else{
            return false;
        }
    }

    public function set_item()
    {
        if($this->input->post('group') !== false && $this->input->post('code') !== false
            && $this->input->post('description') !== false && $this->input->post('quantity') !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'group'         => $this->input->post('group'),
                'code'          => $this->input->post('code'),
                'description'   => $this->input->post('description'),
                'quantity'      => $this->input->post('quantity'),
                'creation_date' => date("Y-m-d H:i:s")
            );

            return $this->db->insert('blum_lib_parts', $data);
        }else{
            return false;
        }
    }

    public function delete_item($id){
		$row_delete = array('id' => $id);
        $response = $this->db->delete('blum_lib_parts', array('id' => $id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
    }
}