<?php
class Project_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_project_by_id($id){
        $this->db->select('project_master.*, customer_master.name AS customer_name');
        $this->db->from('project_master');
        $this->db->join('customer_master', 'project_master.customer_id = customer_master.id');
        $this->db->where('project_master.id', $id);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function get_project_by_name_customer($name, $customer_id){
        $this->db->select('project_master.*');
        $this->db->from('project_master');
        $this->db->where('name', $name);
        $this->db->where('customer_id', $customer_id);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function get_all_projects()
    {
        $this->db->select('project_master.*, customer_master.name AS customer_name');
        $this->db->from('project_master');
        $this->db->join('customer_master', 'project_master.customer_id = customer_master.id');
        $query = $this->db->get();

        $result_array = $query->result_array();
        if($result_array === false){
            return false;
        }else{
            date_default_timezone_set('Asia/Jakarta');
            $array_length = count($result_array);
            for($walk = 0; $walk < $array_length; $walk++){
                if(strtotime($result_array[$walk]['start_date']) <= 0){
                    $result_array[$walk]['formatted_start_date'] = -1;
                }else{
                    $result_array[$walk]['formatted_start_date'] = date("d-m-Y", strtotime($result_array[$walk]['start_date']));
                }

                if(strtotime($result_array[$walk]['finish_date']) <= 0){
                    $result_array[$walk]['formatted_finish_date'] = -1;
                }else{
                    $result_array[$walk]['formatted_finish_date'] = date("d-m-Y", strtotime($result_array[$walk]['finish_date']));
                }
            }

            return $result_array;
        }
    }

    public function update_project($database_input_array)
    {
        if($database_input_array['id'] !== false && $database_input_array['customer_id'] !== false
            && $database_input_array['project_initial'] !== false && $database_input_array['name'] !== false
            && $database_input_array['address'] !== false && $database_input_array['notes'] !== false
            && $database_input_array['start_date'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'customer_id' => $database_input_array['customer_id'],
                'project_initial' => $database_input_array['project_initial'],
                'name' => $database_input_array['name'],
                'address' => $database_input_array['address'],
                'notes' => $database_input_array['notes'],
                'start_date' => $database_input_array['start_date'],
                'creation_date' => date("Y-m-d H:i:s")
            );

            $this->db->where('id', $this->input->post('id'));
            return $this->db->update('project_master', $data);
        }else{
            return false;
        }
    }

    public function set_project($database_input_array)
    {
        if($database_input_array['customer_id'] !== false && $database_input_array['project_initial'] !== false
            && $database_input_array['name'] !== false && $database_input_array['address'] !== false
            && $database_input_array['notes'] !== false && $database_input_array['start_date'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'customer_id' => $database_input_array['customer_id'],
                'project_initial' => $database_input_array['project_initial'],
                'name' => $database_input_array['name'],
                'address' => $database_input_array['address'],
                'notes' => $database_input_array['notes'],
                'start_date' => $database_input_array['start_date'],
                'creation_date' => date("Y-m-d H:i:s")
            );

            return $this->db->insert('project_master', $data);
        }else{
            return false;
        }
    }

    public function delete_project($project_id){
        $response = $this->db->delete('project_master', array('id' => $project_id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
    }

    public function finish_project($project_id){
        if($project_id){
            date_default_timezone_set('Asia/Jakarta');
            $data = array(
                'finish_date' => date("Y-m-d H:i:s")
            );

            $this->db->where('id', $project_id);
            return $this->db->update('project_master', $data);
        }else{
            return false;
        }
    }
}