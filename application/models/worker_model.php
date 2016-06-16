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

    public function get_all_workers_by_kepala()
    {
        $this->db->select('worker_master.*, division_master.name AS division, group_master.name as kepala');
        $this->db->from('worker_master');
        $this->db->join('division_master', 'worker_master.division_id = division_master.id');
        $this->db->join('group_master', 'worker_master.group_id = group_master.id');
        
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_all_workerkepala($worker)
    {
        $this->db->select('worker_master.*, division_master.name AS division, group_master.name as kepala');
        $this->db->from('worker_master');
        $this->db->join('division_master', 'worker_master.division_id = division_master.id');
        $this->db->join('group_master', 'worker_master.group_id = group_master.id');
        $this->db->where('group_master.name', $worker);
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

            $this->db->trans_start();
            date_default_timezone_set('Asia/Jakarta');

            if($database_input_array['ketua-edit'] == 1){
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
            $this->db->update('worker_master', $data);
            }else{
                    $data = array(
                        'division_id' => $database_input_array['division_id'],
                        'leader_group' => $database_input_array['ketua-edit'],
                        //'group_id' => $database_input_array['group_id'],
                        'name' => $database_input_array['name'],
                        'address' => $database_input_array['address'],
                        'phone_number_1' => $database_input_array['phone_number_1'],
                        'phone_number_2' => $database_input_array['phone_number_2'],
                        'join_date' => $database_input_array['join_date'],
                        'salary' => $database_input_array['salary'],
                        'notes' => $database_input_array['notes'],
                    );
                    $this->db->where('id', $this->input->post('id'));
                    $this->db->update('worker_master', $data);

                    $data = array(
                        'leader_group' => '0'
                    );
                    $this->db->where('group_id', $database_input_array['group_id']);
                    $this->db->update('worker_master', $data);

                    $data = array(
                        'leader_group' => '1'
                    );
                    $this->db->where('id', $this->input->post('id'));
                    $this->db->update('worker_master', $data);

                    $data = array(
                        'name' => $database_input_array['name'],
                        'worker_id' => $this->input->post('id')
                    );
                    $this->db->where('id', $database_input_array['group_id']);
                    $this->db->update('group_master', $data);
            }
            $this->db->trans_complete();

            // return false if something went wrong
            if ($this->db->trans_status() === FALSE){
                return FALSE;
            }else{
                return TRUE;
            }
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
            $this->db->trans_start();
            date_default_timezone_set('Asia/Jakarta');

            if($database_input_array['ketua'] == 1){
            $data = array(
                'division_id' => $database_input_array['division_id'],
                'worker_code' => $database_input_array['worker_code'],
                'leader_group' => $database_input_array['ketua'],
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

            $this->db->insert('worker_master', $data);
            
            $database_input_array['group'] = $this->db->insert_id();
            $data = array(
                'name' => $database_input_array['name'],
                //'leader_group' => $database_input_array['ketua'],
                'worker_id' => $database_input_array['group']
            );
            $this->db->insert('group_master', $data);

            $database_input_array['groupid'] = $this->db->insert_id();
            $data = array(
                'group_id' => $database_input_array['groupid']
            );
            $this->db->where('id', $database_input_array['group']);
            $this->db->update('worker_master', $data);

            }else{
                $data = array(
                'division_id' => $database_input_array['division_id'],
                'worker_code' => $database_input_array['worker_code'],
                'group_id' => $database_input_array['group_id'],
                'leader_group' => '0',
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

            $this->db->insert('worker_master', $data);
            }

            // complete database transaction
            $this->db->trans_complete();

            // return false if something went wrong
            if ($this->db->trans_status() === FALSE){
                return FALSE;
            }else{
                return TRUE;
            }
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

    public function get_all_group()
    {
        $query = $this->db->get('group_master');
        return $query->result_array();
    }
}