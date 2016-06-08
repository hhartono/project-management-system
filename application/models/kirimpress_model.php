<?php
class Kirimpress_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_all_bahandasar()
    {
        $this->db->select('item_master.*, category_master.name AS category');
        $this->db->from('item_master');
        $this->db->join('category_master', 'item_master.category_id = category_master.id');
        $this->db->where('category_master.name', 'plywood');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_all_sisi()
    {
        $this->db->select('item_master.*, category_master.name AS category');
        $this->db->from('item_master');
        $this->db->join('category_master', 'item_master.category_id = category_master.id');
        $this->db->where('category_master.name', 'HPL');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function set_kirim_press($database_input_array)
    {
        if($this->input->post('name') !== false && $this->input->post('sisi1') !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'bahan_dasar' => $database_input_array['bahan_dasar'],
                'sisi1' => $database_input_array['sisi1'],
                'sisi2' => $database_input_array['sisi2']
            );

            return $this->db->insert('kirim_press_temp', $data);
        }else{
            return false;
        }
    }

    public function set_kirimpress_project($database_input_array){
        if($this->input->post('project') !== false && $this->input->post('subproject') !== false){

            date_default_timezone_set('Asia/Jakarta');

            // start database transaction
            $this->db->trans_begin();

            $temp = $this->get_all_press();
            foreach ($temp as $temp) {
                $data = array(
                    'bahan_dasar' => $temp['bahan_dasar'],
                    'sisi1' => $temp['sisi1'],
                    'sisi2' => $temp['sisi2']
                );
                $this->db->insert('kirim_press_detail', $data);
            }

            $data = array(
                'kode_press' => $database_input_array['kode_press'],
                'subproject_id' => $database_input_array['subproject_id'],
                'creation_date' => date("Y-m-d H:i:s"),
                'user_id' => $database_input_array['user']
            );
            $this->db->insert('kirim_press_main', $data);

            $data = array(
                'kirim_press_main_id' => $this->db->insert_id()
            );
            $this->db->where('kirim_press_main_id', null);
            $this->db->update('kirim_press_detail', $data);

            $this->db->truncate('kirim_press_temp');
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

    public function get_all_press()
    {
        $this->db->select('kirim_press_temp.*');
        $this->db->from('kirim_press_temp');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_all_kirimpress()
    {
        $this->db->select('kirim_press_main.*');
        $this->db->from('kirim_press_main');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function delete_press_temp($press_id){
        $response = $this->db->delete('kirim_press_temp', array('id' => $press_id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
    }

    public function get_sub_project($project_id)
    {     
        $this->db->where('project_id',$project_id);
        $result = $this->db->get('subproject_master');
        if($result->num_rows() > 0){
            return $result->result_array();
        }else{
            return array();
        }
    }

    public function get_kirimpress_by_kirimpress_code($kirimpress_code){
        $query = $this->db->get_where('kirim_press_main', array('kode_press' => $kirimpress_code));
        return $query->row_array();
    }

    public function set_receive_press($database_input_array)
    {
        if($this->input->post('id') !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'receive_date' => date("Y-m-d H:i:s")
            );
            $this->db->where('id', $database_input_array['id']);
            return $this->db->update('kirim_press_main', $data);
        }else{
            return false;
        }
    }

}