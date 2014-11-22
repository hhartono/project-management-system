<?php
class Category_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_category_by_id($id){
        /*
        $query = $this->db->get_where('unit_master', array('id' => $id));
        return $query->row_array();
        */
    }

    public function get_category_by_abbreviation($abbreviation){
        /*
        $query = $this->db->get_where('unit_master', array('abbreviation' => $abbreviation));
        return $query->result_array();
        */
    }

    public function get_all_categories()
    {
        $query = $this->db->get('category_master');
        return $query->result_array();
    }

    public function update_category()
    {
        /*
        if($this->input->post('id') !== false && $this->input->post('abbreviation') !== false
            && $this->input->post('name') !== false && $this->input->post('notes') !== false){
            $data = array(
                'abbreviation' => $this->input->post('abbreviation'),
                'name' => $this->input->post('name'),
                'notes' => $this->input->post('notes')
            );

            $this->db->where('id', $this->input->post('id'));
            return $this->db->update('unit_master', $data);
        }else{
            return false;
        }
        */
    }

    public function set_category()
    {
        /*
        if($this->input->post('abbreviation') !== false && $this->input->post('name') !== false
            && $this->input->post('notes') !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'abbreviation' => $this->input->post('abbreviation'),
                'name' => $this->input->post('name'),
                'notes' => $this->input->post('notes'),
                'creation_date' => date("Y-m-d H:i:s")
            );

            return $this->db->insert('unit_master', $data);
        }else{
            return false;
        }
        */
    }

    public function delete_category($category_id){
        /*
        $response = $this->db->delete('unit_master', array('id' => $unit_id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
        */
    }
}