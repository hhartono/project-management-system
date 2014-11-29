<?php
class Division_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_division_by_id($id){
        $query = $this->db->get_where('division_master', array('id' => $id));
        return $query->row_array();
    }

    public function get_division_by_code($division_code){
        $query = $this->db->get_where('division_master', array('division_code' => $division_code));
        return $query->row_array();
    }

    public function get_all_divisions()
    {
        $query = $this->db->get('division_master');
        return $query->result_array();
    }

    public function update_division()
    {
        if($this->input->post('id') !== false && $this->input->post('division_code') !== false
            && $this->input->post('name') !== false && $this->input->post('notes') !== false){
            $data = array(
                'division_code' => strtoupper($this->input->post('division_code')),
                'name' => $this->input->post('name'),
                'notes' => $this->input->post('notes')
            );

            $this->db->where('id', $this->input->post('id'));
            return $this->db->update('division_master', $data);
        }else{
            return false;
        }
    }

    public function set_division()
    {
        if($this->input->post('division_code') !== false && $this->input->post('name') !== false
            && $this->input->post('notes') !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'division_code' => strtoupper($this->input->post('division_code')),
                'name' => $this->input->post('name'),
                'notes' => $this->input->post('notes'),
                'creation_date' => date("Y-m-d H:i:s")
            );

            return $this->db->insert('division_master', $data);
        }else{
            return false;
        }
    }

    public function delete_division($division_id){
        $response = $this->db->delete('division_master', array('id' => $division_id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
    }
}