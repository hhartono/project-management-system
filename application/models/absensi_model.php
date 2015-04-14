<?php
class Absensi_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

	public function get_all_absensi()
	{
		$this->db->select('*');
    	$this->db->from('absensi');
    	$query = $this->db->get();

    	$result_array = $query->result_array();
    	return $result_array;
	}

	public function caridata()
    {
        $cari = $this->input->POST('cari');
        $query = $this->db->query("
                SELECT absensi.*, project_master.name as project
                FROM absensi
                left join project_master on project_master.id = absensi.project_id
                WHERE date = '$cari'
                ORDER BY id DESC
            ");

            return $query->result_array();
        
    }

    public function get_all_project()
    {
        $query = $this->db->get('project_master');
        return $query->result_array();
    }

    public function get_project_by_id($id){
        $this->db->select('*');
        $this->db->from('project_master');
        $this->db->where('id', $id);
        $query = $this->db->get();

        $row_array = $query->row_array();
        return $row_array;
    }

    public function update_projectworker($database_input_array)
    {
        if($database_input_array['id'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'project_id' => $database_input_array['project_id']
            );

            $this->db->where('id', $this->input->post('id'));
            return $this->db->update('absensi', $data);
        }else{
            return false;
        }
    }
}
?>