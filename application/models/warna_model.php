<?php
class Warna_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_warna_by_id($id){
        $this->db->select('warna_master.*');
        $this->db->from('warna_master');
        $this->db->where('warna_master.id', $id);
        $query = $this->db->get();

        $row_array = $query->row_array();
    }

    public function get_warna_by_name_kode($name, $kode){
        $this->db->select('warna_master.*');
        $this->db->from('warna_master');
        $this->db->where('nama_warna', $name);
        $this->db->where('kode_warna', $kode);
        $query = $this->db->get();

        return $query->row_array();
    }


    public function get_warna_by_name($name){
        $query = $this->db->get_where('warna_master', array('name' => $name));
        return $query->row_array();
    }

    public function get_all_warnas()
    {
        $this->db->select('warna_master.*');
        $this->db->from('warna_master');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function update_warna($database_input_array)
    {
        if($database_input_array['id'] !== false && $database_input_array['kode_warna'] !== false 
            && $database_input_array['nama_warna'] !== false
            && $database_input_array['kode_pantone'] !== false && $database_input_array['hexadecimal'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'kode_warna' => $database_input_array['kode_warna'],
                'nama_warna' => $database_input_array['nama_warna'],
                'kode_pantone' => $database_input_array['kode_pantone'],
                'hexadecimal' => $database_input_array['hexadecimal']
            );

            $this->db->where('id', $this->input->post('id'));
            return $this->db->update('warna_master', $data);
        }else{
            return false;
        }
    }

    public function set_warna($database_input_array)
    {
        if($database_input_array['kode_warna'] !== false && $database_input_array['nama_warna'] !== false
            && $database_input_array['kode_pantone'] !== false
            && $database_input_array['hexadecimal'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'kode_warna' => $database_input_array['kode_warna'],
                'nama_warna' => $database_input_array['nama_warna'],
                'kode_pantone' => $database_input_array['kode_pantone'],
                'hexadecimal' => $database_input_array['hexadecimal']
            );

            return $this->db->insert('warna_master', $data);
        }else{
            return false;
        }
    }

    public function delete_warna($warna_id){
        $response = $this->db->delete('warna_master', array('id' => $warna_id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
    }
}