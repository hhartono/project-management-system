<?php
class Parts_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function get_parts_by_id($id){
        $query = $this->db->get_where('blum_lib_parts', array('id' => $id));
        return $query->row_array();
    }

    public function get_parts_by_group_name($group){
        $query = $this->db->get_where('blum_lib_parts', array('group_name' => $group));
        return $query->result_array();
    }

    public function get_group_name_by_id($id){
        $this->db->select('group_name');
        $this->db->from('blum_lib_parts');
    //    $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
	
	public function get_parts_by_group_code($group, $code){
		$this->db->select('blum_lib_parts.*');
        $this->db->from('blum_lib_parts');
        $this->db->where('group_name', $group);
        $this->db->where('code', $code);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_parts_info($group){
        $query = $this->db->get_where('blum_lib_parts', array('group' => $group));
        $result = $query->row_array();
        $return_value['id']             = !empty($result['id']) ? $result['id'] : '';
        $return_value['group_name']     = !empty($result['group_name']) ? $result['group_name'] : '';
        $return_value['part_img_path']  = !empty($result['part_img_path']) ? $result['part_img_path'] : '';
        $return_value['code']           = !empty($result['code']) ? $result['code'] : '';
        $return_value['description']    = !empty($result['description']) ? $result['description'] : '';
        $return_value['quantity']       = !empty($result['quantity']) ? $result['quantity'] : '';
        return $return_value;
    }

    public function get_all_parts(){
        $query = $this->db->get('blum_lib_parts');
        return $query->result_array();
    }

    public function update_parts(){
        if($this->input->post('id') !== false && $this->input->post('group') !== false && $this->input->post('code') !== false && $this->input->post('description') !== false && $this->input->post('quantity') !== false){
            $data = array(
                'group_name'            => $this->input->post('group'),
                'code'                  => $this->input->post('code'),
                'description'           => $this->input->post('description'),
                'quantity'              => $this->input->post('quantity'),
                'user_id'               => $this->input->post('user'),
                'last_update_timestamp' => date("Y-m-d H:i:s")
            );

            $this->db->where('id', $this->input->post('id'));
            return $this->db->update('blum_lib_parts', $data);
        } else{
            return false;
        }
    }

    public function set_parts(){
        if($this->input->post('group') !== false && $this->input->post('code') !== false 
            && $this->input->post('description') !== false && $this->input->post('quantity') !== false){
            
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'group_name'    => $this->input->post('group'),
                'code'          => $this->input->post('code'),
                'description'   => $this->input->post('description'),
                'quantity'      => $this->input->post('quantity'),
                'user_id'       => $this->input->post('user'),
                'creation_date' => date("Y-m-d H:i:s")
            );

            return $this->db->insert('blum_lib_parts', $data);
        } else{
            return false;
        }
    }

    public function delete_parts($id){
		$row_delete = array('id' => $id);
        $response = $this->db->delete('blum_lib_parts', array('id' => $id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
    }

    public function upload_image($file, $id_image){
        $this->db->where('id', $id_image);
        $this->db->update('blum_lib_parts', $file);
    }
}