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

        return $query->result_array();
    }

    public function get_warna_by_name_kode($name, $kode){
        $this->db->select('warna_master.*');
        $this->db->from('warna_master');
        $this->db->where('nama_warna', $name);
        $this->db->where('kode_warna', $kode);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function get_project_by_name($name){
        $this->db->select('project_warna.*');
        $this->db->from('project_warna');
        $this->db->where('project_warna.project_id', $name);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function get_subproject_by_name($name){
        $this->db->select('subproject_warna.*');
        $this->db->from('subproject_warna');
        $this->db->where('subproject_warna.subproject_id', $name);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function get_subproject_by_uri($uri){
        $this->db->select('subproject_master.*');
        $this->db->from('subproject_master');
        $this->db->where('subproject_master.project_id', $uri);
        $query = $this->db->get();

        return $query->result_array();
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

    public function get_all_pattern_project()
    {
        $this->db->select('project_warna.*, project_master.name as project');
        $this->db->from('project_warna');
        $this->db->join('project_master', 'project_warna.project_id = project_master.id');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function set_project_warna($database_input_array)
    {
        if($database_input_array['project_id'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'project_id' => $database_input_array['project_id'],
            );

            return $this->db->insert('project_warna', $data);
        }else{
            return false;
        }
    }

    public function set_subproject_warna($database_input_array)
    {
        if($database_input_array['project_id'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'subproject_id' => $database_input_array['subproject_id'],
                'project_id' => $database_input_array['project_id']    
            );

            return $this->db->insert('subproject_warna', $data);
        }else{
            return false;
        }
    }

    public function get_all_pattern_subproject($uri)
    {
        $this->db->select('subproject_warna.*, subproject_master.name as subproject');
        $this->db->from('subproject_warna');
        $this->db->join('subproject_master', 'subproject_warna.subproject_id = subproject_master.id');
        //$this->db->join('gambar_warna', 'gambar_warna.subproject_warna_id = subproject_warna.id');
        $this->db->where('subproject_warna.project_id', $uri);
        //$this->db->where('gambar_warna.gambar', null);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function uploadSubprojectPhoto($id, $file)
    {
        $field = array(
                'gambar' => $file,
                'subproject_warna_id' => $id
            );
        $this->db->insert('gambar_warna', $field);
    }

    public function get_subproject_warna_by_id($id)
    {
        $this->db->select('subproject_warna.*');
        $this->db->from('subproject_warna');
        $this->db->where('subproject_warna.id', $id);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function get_all_gambar_subproject($uri)
    {
        $this->db->select('gambar_warna.*');
        $this->db->from('gambar_warna');
        $this->db->join('subproject_warna', 'subproject_warna.id = gambar_warna.subproject_warna_id');
        $this->db->join('project_warna', 'project_warna.id = subproject_warna.project_id');
        $this->db->where('project_warna.id', $uri);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_all_gambar_by_id($id)
    {
        $this->db->select('gambar_warna.*');
        $this->db->from('gambar_warna');
        $this->db->where('gambar_warna.subproject_warna_id', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_pattern_by_id($warna_id, $subproject_warna_id){
        $this->db->select('pattern_warna.*');
        $this->db->from('pattern_warna');
        $this->db->where('warna_id', $warna_id);
        $this->db->where('subproject_warna_id', $subproject_warna_id);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function set_pattern_warna($database_input_array)
    {
        if($database_input_array['warna_id'] !== false && $database_input_array['uri'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'warna_id' => $database_input_array['warna_id'],
                'subproject_warna_id' => $database_input_array['uri'],
            );

            return $this->db->insert('pattern_warna', $data);
        }else{
            return false;
        }
    }

    public function get_all_pattern_warna($uri)
    {
        $this->db->select('pattern_warna.*, warna_master.kode_warna as kode, warna_master.nama_warna as nama, warna_master.hexadecimal as hexadecimal');
        $this->db->from('pattern_warna');
        $this->db->join('warna_master', 'warna_master.id = pattern_warna.warna_id');
        $this->db->where('pattern_warna.subproject_warna_id', $uri);
        $query = $this->db->get();

        return $query->result_array();

    }

    public function get_pattern_warna()
    {
        //$uri = $this->uri->segment(3);
        $this->db->select('pattern_warna.*, warna_master.kode_warna as kode, warna_master.nama_warna as nama, warna_master.hexadecimal as hexadecimal');
        $this->db->from('pattern_warna');
        $this->db->join('warna_master', 'warna_master.id = pattern_warna.warna_id');
        //$this->db->where('pattern_warna.subproject_warna_id', $uri);
        $query = $this->db->get();

        return $query->result_array();

    }

    public function get_all_pattern_corak($uri)
    {
        $this->db->select('corak_warna.*, corak_master.kode_corak as kode, corak_master.nama_corak as nama, corak_master.gambar_corak as gambar');
        $this->db->from('corak_warna');
        $this->db->join('corak_master', 'corak_master.id = corak_warna.corak_id');
        $this->db->where('corak_warna.subproject_warna_id', $uri);
        $query = $this->db->get();

        return $query->result_array();

    }

    public function get_all_subproject($uri)
    {
        $this->db->select('subproject_master.*');
        $this->db->from('subproject_master');
        $this->db->join('subproject_warna', 'subproject_warna.subproject_id = subproject_master.id');
        $this->db->where('subproject_warna.subproject_id', $uri);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function delete_pattern($id){
        $response = $this->db->delete('pattern_warna', array('id' => $id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
    }

    public function get_all_corak()
    {
        $this->db->select('corak_master.*');
        $this->db->from('corak_master');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_corak_by_name_kode($name, $kode){
        $this->db->select('corak_master.*');
        $this->db->from('corak_master');
        $this->db->where('nama_corak', $name);
        $this->db->where('kode_corak', $kode);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function set_corak($database_input_array)
    {
        if($database_input_array['kode_corak'] !== false && $database_input_array['nama_corak'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'kode_corak' => $database_input_array['kode_corak'],
                'nama_corak' => $database_input_array['nama_corak']
            );

            return $this->db->insert('corak_master', $data);
        }else{
            return false;
        }
    }

    public function delete_corak($corak_id){
        $response = $this->db->delete('corak_master', array('id' => $corak_id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
    }

    public function uploadCorakPhoto($id, $file)
    {
        $field = array(
            'gambar_corak' => $file,
        );
        $this->db->where('id', $id);
        return $this->db->update('corak_master', $field);
    }

    public function get_corak_by_id($corak_id, $subproject_warna_id){
        $this->db->select('corak_warna.*');
        $this->db->from('corak_warna');
        $this->db->where('corak_id', $corak_id);
        $this->db->where('subproject_warna_id', $subproject_warna_id);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function set_corak_warna($database_input_array)
    {
        if($database_input_array['corak_id'] !== false && $database_input_array['uri'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'corak_id' => $database_input_array['corak_id'],
                'subproject_warna_id' => $database_input_array['uri'],
            );

            return $this->db->insert('corak_warna', $data);
        }else{
            return false;
        }
    }

    public function set_img_tag($database_input_array){
        if($database_input_array['id'] !== false && $database_input_array['name'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'gambar_id' => $database_input_array['id'],
                'name' => $database_input_array['name'],
                'pic_x' => $database_input_array['pic_x'],
                'pic_y' => $database_input_array['pic_y']
            );

            return $this->db->insert('image_tag', $data);
        }else{
            return false;
        }
    }

    public function taglist($id)
    {
        $this->db->select('image_tag.*');
        $this->db->from('image_tag');
        $this->db->where('image_tag.gambar_id', $id);
        $query = $this->db->get();

        return $query->result_array();
    }
}