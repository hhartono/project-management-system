<?php
class Category_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_category_by_id($id){
        $query = $this->db->get_where('category_master', array('id' => $id));
        return $query->row_array();
    }

    public function get_category_by_prefix($prefix){
        $query = $this->db->get_where('category_master', array('prefix' => $prefix));
        return $query->result_array();
    }

    public function get_all_categories()
    {
        $query = $this->db->get('category_master');
        return $query->result_array();
    }

    public function update_category()
    {
        if($this->input->post('id') !== false && $this->input->post('prefix') !== false
            && $this->input->post('name') !== false){
            $data = array(
                'prefix' => $this->input->post('prefix'),
                'name' => $this->input->post('name')
            );

            $this->db->where('id', $this->input->post('id'));
            return $this->db->update('category_master', $data);
        }else{
            return false;
        }
    }

    public function set_category()
    {
        if($this->input->post('prefix') !== false && $this->input->post('name') !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'prefix' => $this->input->post('prefix'),
                'name' => $this->input->post('name'),
                'creation_date' => date("Y-m-d H:i:s")
            );

            return $this->db->insert('category_master', $data);
        }else{
            return false;
        }
    }

    public function delete_category($category_id){
        $response = $this->db->delete('category_master', array('id' => $category_id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
    }
}