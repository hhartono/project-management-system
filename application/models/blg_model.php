<?php
class Blg_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function get_item_by_id($id){
        $query = $this->db->get_where('blum_lib_group', array('id' => $id));
        return $query->row_array();
    }

    public function get_item_by_group_name($group){
        $query = $this->db->get_where('blum_lib_group', array('blg_group_name' => $group));
        return $query->row_array();
    }
	
	public function get_item_by_code($code){
		$this->db->select('blum_lib_group.*');
        $this->db->from('blum_lib_group');
        $this->db->where('code', $code);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_item_info($id){
        $query = $this->db->get_where('blum_lib_group', array('id' => $id));
        $result = $query->row_array();
        $return_value['id']                 = !empty($result['id']) ? $result['id'] : '';
        $return_value['blg_group_name']     = !empty($result['blg_group_name']) ? $result['blg_group_name'] : '';
        $return_value['blg_code']           = !empty($result['blg_code']) ? $result['blg_code'] : '';
        $return_value['blg_description']    = !empty($result['blg_description']) ? $result['blg_description'] : '';
        $return_value['blg_parts_quantity'] = !empty($result['blg_quantity']) ? $result['blg_quantity'] : '';
        $return_value['blg_price']          = !empty($result['blg_price']) ? $result['blg_price'] : '';
        $return_value['blg_img_path']       = !empty($result['blg_img_path']) ? $result['blg_img_path'] : '';
        return $return_value;
    }

    //filling ddl1 in
    public function get_parts_dropdown(){
        $this->db->distinct();
        $this->db->select('code');
        $this->db->from('blum_lib_parts');
        $this->db->order_by('code', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_parts_count($code){
        $this->db->distinct();
        $this->db->select('blg_parts_quantity')->from('blum_lib_group');
        $this->db->join('blum_lib_parts', 'blg_group_name = group_name');
        $this->db->where('code', $code);
        $this->db->order_by('blg_parts_quantity', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    //get group(s) from code & parts_sum
    public function get_group_first($code, $parts_sum){
        $q = 'SELECT distinct(blg_group_name), id, blg_img_path, blg_code, blg_description, blg_price FROM blum_lib_group WHERE blg_group_name IN (SELECT group_name FROM blum_lib_parts WHERE code = ?) AND blg_parts_quantity = ? ORDER BY blg_group_name';
        $query = $this->db->query($q, array($code, $parts_sum));
        return $query->result_array();
    }

    //get unique parts from selected group_name -> get_group_first()
    public function get_unique_param($par1, $par2, $par3){ 
        $q = 'SELECT id, group_name, code, description, quantity FROM blum_lib_parts WHERE group_name IN (
              SELECT group_name FROM blum_lib_parts WHERE group_name = ? OR group_name = ? OR group_name = ?) 
              GROUP BY code HAVING COUNT(code) < 2 ORDER BY id, group_name, code'; 
        $query = $this->db->query($q, array($par1, $par2, $par3));
        return $query->result_array();
    }

    //last step of selection, acquiring specific group name
    public function final_search($code, $parts_sum, $unq_code){
        $params = array('code' => $code, 'code' => $unq_code, 'blg_parts_quantity' => $parts_sum);

        $this->db->select('g.id, blg_group_name, blg_img_path, blg_code, blg_description, blg_price')->from('blum_lib_group AS g');
        $this->db->join('blum_lib_parts p', 'blg_group_name = group_name');
        $this->db->where($params);
        $query = $this->db->get();
        return $query->result_array();
    }
        
    public function get_all_items(){
        $query = $this->db->get('blum_lib_group');
        return $query->result_array();
    }

    public function update_item(){
        if($this->input->post('id') !== false && $this->input->post('group') !== false && $this->input->post('code') !== false 
            && $this->input->post('description') !== false && $this->input->post('quantity') !== false && $this->input->post('price') !== false){
            $data = array(
                'blg_group_name'        => $this->input->post('group'),
                'blg_code'              => $this->input->post('code'),
                'blg_description'       => $this->input->post('description'),
                'blg_parts_quantity'    => $this->input->post('quantity'),
                'blg_price'             => $this->input->post('price'),
                'user_id'               => $this->input->post('user'),
                'last_update_timestamp' => date("Y-m-d H:i:s")
            );

            $this->db->where('id', $this->input->post('id'));
            return $this->db->update('blum_lib_group', $data);
        } else{
            return false;
        }
    }

    public function set_item(){
        if($this->input->post('group') !== false && $this->input->post('code') !== false 
            && $this->input->post('description') !== false && $this->input->post('quantity') !== false && $this->input->post('price') !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'blg_group_name'    => $this->input->post('group'),
                'blg_code'          => $this->input->post('code'),
                'blg_description'   => $this->input->post('description'),
                'blg_parts_quantity'=> $this->input->post('quantity'),
                'blg_price'         => $this->input->post('price'),
                'user_id'           => $this->input->post('user'),
                'creation_date'     => date("Y-m-d H:i:s")
            );
            return $this->db->insert('blum_lib_group', $data);
        } else{
            return false;
        }
    }

    public function upload_image($file, $id_image){
        $this->db->where('id', $id_image);
        $this->db->update('blum_lib_group', $file);
    }

    public function delete_item($id){
		$row_delete = array('id' => $id);
        $response = $this->db->delete('blum_lib_group', array('id' => $id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
    }
}