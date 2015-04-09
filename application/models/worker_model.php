<?php
class Worker_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_worker_by_id($id){
        $query = $this->db->get_where('worker_master', array('id' => $id));
        return $query->row_array();
    }

    public function get_worker_by_worker_code($worker_code){
        $query = $this->db->get_where('worker_master', array('worker_code' => $worker_code));
        return $query->row_array();
    }

    public function get_worker_by_name($name){
        $query = $this->db->get_where('worker_master', array('name' => $name));
        return $query->row_array();
    }

    public function get_worker_by_name_division($name, $division_id){
        $this->db->select('worker_master.*');
        $this->db->from('worker_master');
        $this->db->where('name', $name);
        $this->db->where('division_id', $division_id);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function get_all_workers()
    {
        $this->db->select('worker_master.*, division_master.name AS division');
        $this->db->from('worker_master');
        $this->db->join('division_master', 'worker_master.division_id = division_master.id');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function update_worker($database_input_array)
    {
        if($database_input_array['id'] !== false && $database_input_array['division_id'] !== false
            && $database_input_array['name'] !== false && $database_input_array['address'] !== false
            && $database_input_array['phone_number_1'] !== false && $database_input_array['phone_number_2'] !== false
            && $database_input_array['join_date'] !== false && $database_input_array['salary'] !== false
            && $database_input_array['notes'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'division_id' => $database_input_array['division_id'],
                'name' => $database_input_array['name'],
                'address' => $database_input_array['address'],
                'phone_number_1' => $database_input_array['phone_number_1'],
                'phone_number_2' => $database_input_array['phone_number_2'],
                'join_date' => $database_input_array['join_date'],
                'salary' => $database_input_array['salary'],
                'notes' => $database_input_array['notes'],
            );

            $this->db->where('id', $this->input->post('id'));
            return $this->db->update('worker_master', $data);
        }else{
            return false;
        }
    }

    public function set_worker($database_input_array)
    {
        if($database_input_array['division_id'] !== false && $database_input_array['worker_code'] !== false
            && $database_input_array['name'] !== false && $database_input_array['address'] !== false
            && $database_input_array['phone_number_1'] !== false && $database_input_array['phone_number_2'] !== false
            && $database_input_array['join_date'] !== false && $database_input_array['salary'] !== false
            && $database_input_array['notes'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'division_id' => $database_input_array['division_id'],
                'worker_code' => $database_input_array['worker_code'],
                'name' => $database_input_array['name'],
                'address' => $database_input_array['address'],
                'phone_number_1' => $database_input_array['phone_number_1'],
                'phone_number_2' => $database_input_array['phone_number_2'],
                'join_date' => $database_input_array['join_date'],
                'salary' => $database_input_array['salary'],
                'notes' => $database_input_array['notes'],
                'user_id' => $database_input_array['user'],
                'creation_date' => date("Y-m-d H:i:s")
            );

            return $this->db->insert('worker_master', $data);
        }else{
            return false;
        }
    }

    public function delete_worker($worker_id){
        $response = $this->db->delete('worker_master', array('id' => $worker_id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
    }
}