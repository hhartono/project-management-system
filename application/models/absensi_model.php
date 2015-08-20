<?php
class Absensi_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

	public function get_all_absensi()
	{
		/*$query = $this->db->query("select absensi.*,
							GROUP_CONCAT(DISTINCT subproject_master.name ORDER BY subproject_master.name DESC SEPARATOR ', ') as subproject
							FROM absensi 
							left join absensi_detail on absensi.id = absensi_detail.absensi_id
							left join subproject_master on absensi_detail.subproject_id = subproject_master.id
							GROUP BY absensi.date, absensi.name");*/
        $query = $this->db->query("select absensi . *, group_master.name as grup, group_master.id as idgrup,
                                        GROUP_CONCAT(DISTINCT subproject_master.name ORDER BY subproject_master.name DESC SEPARATOR ', ') as subproject
                                        FROM absensi left join worker_master ON worker_master.name = absensi.name
                                        left join group_master ON group_master.id = worker_master.group_id                      
                                        left join group_tugas_detail ON group_master.id = group_tugas_detail.group_id AND absensi.date = group_tugas_detail.date 
                                        left join subproject_master ON group_tugas_detail.subproject_id = subproject_master.id
                                        GROUP BY absensi.date , absensi.name");
    	
    	$result_array = $query->result_array();
    	return $result_array;
	}

	public function caridata()
    {
        $cari = $this->input->POST('cari');
        $query = $this->db->query("select absensi.*,
							GROUP_CONCAT(DISTINCT subproject_master.name ORDER BY subproject_master.name DESC SEPARATOR ', ') as subproject
							FROM absensi 
							left join absensi_detail on absensi.id = absensi_detail.absensi_id
							left join subproject_master on absensi_detail.subproject_id = subproject_master.id
                			WHERE date = '$cari'
                			GROUP BY absensi.date, absensi.name
            ");

            return $query->result_array();
        
    }

    public function get_all_project()
    {
        $this->db->select('project_master.name as project, subproject_master.name as subproject, subproject_master.id as id');
        $this->db->from('project_master, subproject_master');
        $this->db->where('project_master.id = subproject_master.project_id');
        $this->db->where('subproject_master.start_date != 0');
        $this->db->where('subproject_master.install_date = 0');
        $query = $this->db->get();
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

    public function get_project_absensi(){
        $this->db->select('project_master.name as project');
        $this->db->from('project_master, absensi_detail, absensi');
        $this->db->where('project_master.id = absensi_detail.project_id');
        $this->db->where('absensi.id = absensi_detail.absensi_id');
        //$this->db->where('absensi.id', $id);
        $query = $this->db->get();

        $row_array = $query->row_array();
        return $row_array;
    }

    public function get_all_absensidetail()
	{
		$this->db->select('*');
    	$this->db->from('absensi_detail');
    	$this->db->where('absensi_id', $this->input->post('id'));
    	$query = $this->db->get();

    	$result_array = $query->result_array();
    	return $result_array;
	}

    public function update_projectworker($database_input_array)
    {
        if($database_input_array['id'] !== false){
            date_default_timezone_set('Asia/Jakarta');
            
            $this->db->trans_start();
            

			if(!empty($this->input->post('subproject'))){
            foreach($_POST['subproject'] as $pro)
			{
				//echo $pro . "<br>";
				$id = $this->input->post('id');
				$query = $this->db->query("INSERT INTO absensi_detail(absensi_id, subproject_id) VALUES('$id', '$pro')");
            
        	}
        	

        	$jum = count($_POST['subproject']);
            $data = array(
                'count' => $jum
            );            
            
            $this->db->where('id', $database_input_array['id']);
            $this->db->update('absensi', $data);
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

    public function count_time()
    {
    	$query = $this->db->query("select absensi.*, SUM(absensi.count_time) as jam, date_format(date, '%M %Y') AS bulantahun						
							FROM absensi 
							GROUP BY date_format(date, '%M %Y'), name
							");
    	$result_array = $query->result_array();
    	return $result_array;
    }

    public function count_time_filter()
    {
    	//$name = $this->input->post('nama');
    	$bulan = $this->input->post('bulan');
    	$tahun = $this->input->post('tahun');
    	$query = $this->db->query("select absensi.*, SUM(absensi.count_time) as jam, date_format(date, '%M %Y') AS bulantahun						
							FROM absensi
							WHERE MONTH(date)='$bulan' AND YEAR(date) ='$tahun'
							GROUP BY name");
    	$result_array = $query->result_array();
    	return $result_array;
    }

    public function detail_worker()
    {
    	$nama = $this->input->post('name');
    	$bulantahun = $this->input->post('bulantahun');
    	$query = $this->db->query("select absensi.name as name, absensi.date as date, subproject_master.name as subproject, absensi.count as count, absensi.count_time as counttime, SUM(absensi.count_time / absensi.count) as waktu 
									from absensi, absensi_detail, subproject_master
									where absensi.id = absensi_detail.absensi_id AND subproject_master.id = absensi_detail.subproject_id 
									AND absensi.name = '$nama' AND date_format(absensi.date, '%M %Y') = '$bulantahun'
									GROUP BY subproject_master.name
									");
    	$result_array = $query->result_array();
    	return $result_array;
    }

    public function get_all_absensi_group()
    {
        $query = $this->db->query("select absensi . *, group_master.name as grup, group_master.id as idgrup,
                                        GROUP_CONCAT(DISTINCT subproject_master.name ORDER BY subproject_master.name DESC SEPARATOR ', ') as subproject
                                        FROM absensi left join worker_master ON worker_master.name = absensi.name
                                        left join group_master ON group_master.id = worker_master.group_id                      
                                        left join group_tugas_detail ON group_master.id = group_tugas_detail.group_id AND absensi.date = group_tugas_detail.date 
                                        left join subproject_master ON group_tugas_detail.subproject_id = subproject_master.id
                                        GROUP BY absensi.date , group_master.name");
        
        $result_array = $query->result_array();
        return $result_array;
    }

    public function update_projectworkergrup($database_input_array)
    {
        if($database_input_array['id'] !== false){
            date_default_timezone_set('Asia/Jakarta');
            
            $this->db->trans_start();
            

            if(!empty($this->input->post('subproject'))){
            foreach($_POST['subproject'] as $pro)
            {
                //echo $pro . "<br>";
                $id = $this->input->post('id');
                $date = $this->input->post('date');
                $query = $this->db->query("INSERT INTO group_tugas_detail(group_id, subproject_id, date) VALUES('$id', '$pro', '$date')");
            
            }
            

            $jum = count($_POST['subproject']);
            $data = array(
                'count' => $jum
            );            
            
            $this->db->where('id', $database_input_array['id']);
            $this->db->update('absensi', $data);
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

    public function insertabsensi()
    {
        for($i=0;$i<count($dataarray);$i++){
            $data = array(
                'name'=>$dataarray[$i]['nama'],
                'date'=>$dataarray[$i]['tanggal'],
                'on_duty'=>$dataarray[$i]['jam_masuk'],
                'off_duty'=>$dataarray[$i]['jam_pulang'],
                'count_time'=>$dataarray[$i]['count_time']
            );
            $this->db->insert('absensi', $data);
        }
    }
}
?>