<?php
class Categoryrev_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function get_category_by_id($id){
        $query = $this->db->get_where('category_rev', array('id' => $id));
        return $query->row_array();
    }

    public function get_category_by_prefix($prefix){
        $query = $this->db->get_where('category_rev', array('prefix' => $prefix));
        return $query->row_array();
    }

    public function get_all_categories(){
        $query = $this->db->get('category_rev');
        return $query->result_array();
    }

    public function get_harga_by_id($kat_id){
        $query = $this->db->get_where('harga_kat_history', array('kat_id' => $kat_id));
        return $query->result_array();
    }

    public function update_category(){
        if($this->input->post('id') !== false && $this->input->post('prefix') !== false && $this->input->post('nama') !== false && 
            $this->input->post('satuan') !== false && $this->input->post('harga') !== false){
            $data = array(
                'prefix'                => strtoupper($this->input->post('prefix')),
                'nama'                  => $this->input->post('nama'),
                'kategori'              => $this->input->post('kat'),
                'satuan'                => $this->input->post('satuan'),
                'harga'                 => $this->input->post('harga'),
                'last_update_timestamp' => date('Y-m-d H:i:s')
            );

            $this->db->where('id', $this->input->post('id'));
            return $this->db->update('category_rev', $data);
        }else{
            return false;
        }
    }

    // public function update_harga(){
    //     if($this->input->post('id') !== false && $this->input->post('harga') !== false){
    //         $data = array(
    //             'harga' => $this->input->post('harga'),
    //             'last_update_timestamp' => date('Y-m-d H:i:s')
    //         );

    //         $this->db->where('id', $this->input->post('id'));
    //         return $this->db->update('category_rev', $data);
    //     }else{
    //         return false;
    //     }
    // }

    public function update_harga(){ //update to category_rev, insert to harga_kat_history
        if($this->input->post('id') !== false && $this->input->post('nama') !== false && $this->input->post('harga') !== false){
            $data = array(
                'harga'                 => $this->input->post('harga'),
                'last_update_timestamp' => date('Y-m-d H:i:s')
            );

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('category_rev', $data);

            $data2 = array(
                'kat_id'                => $this->input->post('id'),
                'nama_kat'              => $this->input->post('nama'),
                'harga'                 => $this->input->post('harga'), //tambah userid(admin)
                'last_update_timestamp' => date('Y-m-d H:i:s')
            );

            $this->db->insert('harga_kat_history', $data2);
            return true;
        }else{
            return false;
        }
    }

    public function set_category(){
        if($this->input->post('prefix') !== false && $this->input->post('nama') !== false && $this->input->post('kat') !== false &&
            $this->input->post('satuan') !== false && $this->input->post('harga') !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'prefix'        => strtoupper($this->input->post('prefix')),
                'nama'          => $this->input->post('nama'),
                'kategori'      => $this->input->post('kat'),
                'satuan'        => $this->input->post('satuan'),
                'harga'         => $this->input->post('harga'),
                'user_id'       => $this->input->post('user'),
                'creation_date' => date("Y-m-d H:i:s")
            );

            return $this->db->insert('category_rev', $data);
        }else{
            return false;
        }
    }

    public function delete_category($category_id){
        $response = $this->db->delete('category_rev', array('id' => $category_id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
    }
}