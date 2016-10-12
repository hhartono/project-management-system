<?php
class Gnd_model extends CI_Model {
    
    public function __construct(){
        $this->load->database();
    }

    public function get_num_inv(){
        $gnd_db = $this->load->database("gnd", TRUE);
        $query = "SELECT doc_num FROM invoice ORDER BY id DESC LIMIT 1";
        $result = $gnd_db->query($query);
        return $result->row_array();
    }

    public function get_num_quo(){
        $gnd_db = $this->load->database("gnd", TRUE);
        $query = "SELECT doc_num FROM quotation ORDER BY id DESC LIMIT 1";
        $result = $gnd_db->query($query);
        return $result->row_array();
    }

    public function get_num_po(){
        $gnd_db = $this->load->database("gnd", TRUE);
        $query = "SELECT doc_num FROM po ORDER BY id DESC LIMIT 1";
        $result = $gnd_db->query($query);
        return $result->row_array();
    }

    public function set_doc_num($doc, $doc_num){
        $gnd_db = $this->load->database("gnd", TRUE);
        switch ($doc) {
            case 'inv':
                if($this->input->post('klien') !== false && $this->input->post('project') !== false && $this->input->post('inv_num')){
                    $data = array(
                        'client'        => $this->input->post('klien'),
                        'project'       => $this->input->post('project'),
                        'inv_num'       => $this->input->post('inv_num'),
                        'doc_num'       => $doc_num,
                        'user_id'       => $this->input->post('user'),
                        'creation_date' => date("Y-m-d H:i:s")
                        );
                    return $gnd_db->insert('invoice', $data);
                } else{
                    return false;
                }
                break;

            case 'quo':
                if($this->input->post('klien') !== false && $this->input->post('project')){
                    $data = array(
                        'client'        => $this->input->post('klien'),
                        'project'       => $this->input->post('project'),
                        'doc_num'       => $doc_num,
                        'user_id'       => $this->input->post('user'),
                        'creation_date' => date("Y-m-d H:i:s")
                        );
                    return $gnd_db->insert('quotation', $data);
                } else{
                    return false;
                }
                break;

            case 'po':
                if($this->input->post('supplier') !== false){
                    $data = array(
                        'supplier'      => $this->input->post('supplier'),
                        'project'       => $this->input->post('project'),
                        'doc_num'       => $doc_num,
                        'user_id'       => $this->input->post('user'),
                        'creation_date' => date("Y-m-d H:i:s")
                        );
                    return $gnd_db->insert('po', $data);
                } else{
                    return false;
                }
                break;
        }
    }

    public function get_parts_info($group){
        $query = $this->db->get_where('gnd', array('group' => $group));
        $result = $query->row_array();
        $return_value['id']             = !empty($result['id']) ? $result['id'] : '';
        $return_value['group_name']     = !empty($result['group_name']) ? $result['group_name'] : '';
        $return_value['part_img_path']  = !empty($result['part_img_path']) ? $result['part_img_path'] : '';
        $return_value['code']           = !empty($result['code']) ? $result['code'] : '';
        $return_value['description']    = !empty($result['description']) ? $result['description'] : '';
        $return_value['quantity']       = !empty($result['quantity']) ? $result['quantity'] : '';
        return $return_value;
    }

    //belum jadi
    public function get_all_parts(){
        $gnd_db = $this->load->database("gnd", TRUE);
        $query = $gnd_db->get('gnd');
        return $query->result_array();
    }

    public function get_all_inv(){
        $gnd_db = $this->load->database("gnd", TRUE);
        $q = "SELECT id, creation_date, client, project, inv_num, doc_num FROM invoice";
        // $gnd_db->select('id', 'creation_date', 'client', 'project', 'inv_num', 'doc_num');
        // $gnd_db->from('invoice');
        $query = $gnd_db->get('invoice');
        // $query = $gnd_db->get('invoice');
        return $query->result_array();
        // return $query;
    }

    public function get_all_quo(){
        $gnd_db = $this->load->database("gnd", TRUE);
        $q = "SELECT id, creation_date, client, project, doc_num FROM quotation";
        // $gnd_db->select('id', 'creation_date', 'client', 'project', 'inv_num', 'doc_num');
        $query = $gnd_db->get('quotation');
        return $query->result_array();
    }

    public function get_all_po(){
        $gnd_db = $this->load->database("gnd", TRUE);
        $q = "SELECT id, creation_date, supplier, project, doc_num FROM po";
        // $gnd_db->select('id', 'creation_date', 'client', 'project', 'inv_num', 'doc_num');
        $query = $gnd_db->get('po');
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