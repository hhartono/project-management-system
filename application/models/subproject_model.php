<?php
class Subproject_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_subproject_by_id($id){
        $this->db->select('subproject_master.*, project_master.name AS project_name');
        $this->db->from('subproject_master');
        $this->db->join('project_master', 'subproject_master.project_id = project_master.id');
        $this->db->where('subproject_master.id', $id);
        $query = $this->db->get();

        $row_array = $query->row_array();
        if($row_array === false){
            return false;
        }else{
            date_default_timezone_set('Asia/Jakarta');
            if(strtotime($row_array['start_date']) <= 0){
                $row_array['formatted_start_date'] = "";
            }else{
                $row_array['formatted_start_date'] = date("d-m-Y", strtotime($row_array['start_date']));
            }

            if(strtotime($row_array['install_date']) <= 0){
                $row_array['formatted_install_date'] = "";
            }else{
                $row_array['formatted_install_date'] = date("d-m-Y", strtotime($row_array['install_date']));
            }

            return $row_array;
        }
    }

    public function get_subproject_by_name($name){
        $query = $this->db->get_where('subproject_master', array('name' => $name));
        return $query->row_array();
    }
    public function get_subproject_by_subproject_project($name, $project_id){
        $this->db->select('subproject_master.*');
        $this->db->from('subproject_master');
        $this->db->where('name', $name);
        $this->db->where('project_id', $project_id);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function get_subproject_by_subproject_code($subproject_code){
        $query = $this->db->get_where('subproject_master', array('subproject_code' => $subproject_code));
        return $query->row_array();
    }

    public function get_all_subprojects()
    {
        $this->db->select('subproject_master.*, project_master.name AS project_name');
        $this->db->from('subproject_master');
        $this->db->join('project_master', 'subproject_master.project_id = project_master.id');
        $query = $this->db->get();

        $result_array = $query->result_array();
        if($result_array === false){
            return false;
        }else{
            date_default_timezone_set('Asia/Jakarta');
            $array_length = count($result_array);
            for($walk = 0; $walk < $array_length; $walk++){
                if(strtotime($result_array[$walk]['start_date']) <= 0){
                    $result_array[$walk]['formatted_start_date'] = "";
                }else{
                    $result_array[$walk]['formatted_start_date'] = date("d-m-Y", strtotime($result_array[$walk]['start_date']));
                }

                if(strtotime($result_array[$walk]['install_date']) <= 0){
                    $result_array[$walk]['formatted_install_date'] = "";
                }else{
                    $result_array[$walk]['formatted_install_date'] = date("d-m-Y", strtotime($result_array[$walk]['install_date']));
                }
            }

            return $result_array;
        }
    }

    public function update_subproject($database_input_array)
    {
        if($database_input_array['id'] !== false && $database_input_array['project_id'] !== false
            && $database_input_array['name'] !== false && $database_input_array['notes'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'project_id' => $database_input_array['project_id'],
                'name' => $database_input_array['name'],
                'notes' => $database_input_array['notes']
            );

            $this->db->where('id', $this->input->post('id'));
            return $this->db->update('subproject_master', $data);
        }else{
            return false;
        }
    }

    public function set_subproject($database_input_array)
    {
        if($database_input_array['project_id'] !== false && $database_input_array['subproject_code'] !== false
            && $database_input_array['name'] !== false && $database_input_array['notes'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'project_id' => $database_input_array['project_id'],
                'subproject_code' => $database_input_array['subproject_code'],
                'name' => $database_input_array['name'],
                'notes' => $database_input_array['notes'],
                'user_id' => $database_input_array['user'],
                'creation_date' => date("Y-m-d H:i:s")
            );

            return $this->db->insert('subproject_master', $data);
        }else{
            return false;
        }
    }

    public function delete_subproject($subproject_id){
        $response = $this->db->delete('subproject_master', array('id' => $subproject_id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
    }

    public function start_subproject($subproject_id){
        if($subproject_id){
            date_default_timezone_set('Asia/Jakarta');
            $data = array(
                'start_date' => date("Y-m-d H:i:s")
            );

            $this->db->where('id', $subproject_id);
            return $this->db->update('subproject_master', $data);
        }else{
            return false;
        }
    }

    public function install_subproject($subproject_id){
        if($subproject_id){
            date_default_timezone_set('Asia/Jakarta');
            $data = array(
                'install_date' => date("Y-m-d H:i:s")
            );

            $this->db->where('id', $subproject_id);
            return $this->db->update('subproject_master', $data);
        }else{
            return false;
        }
    }
}