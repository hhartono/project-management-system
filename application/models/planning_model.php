<?php
class Planning_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_all_detail()
    {
        $this->db->select('subproject_master.name AS name, subproject_master.id AS id, project_master.name AS project');
        $this->db->from('project_master');
        $this->db->join('subproject_master', 'project_master.id = subproject_master.project_id', 'left');
        $this->db->order_by('project_master.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getalldetail(){
        $this->db->select('project_master.name AS project, project_master.id AS idproject, company_master.name AS company');
        $this->db->from('project_master, company_master');
        $this->db->where('company_master.id = project_master.company_id ');
        $this->db->like('company_master.name', $q);
        $this->db->order_by('project_master.id', 'DESC');
        $query = $this->db->get();
        return $query;
    }

    /*
       
    */
    public function get_project(){
        $query = $this->db->query("
                SELECT pm.id AS idproject, pm.name AS projectname
                FROM project_master pm
                ORDER BY pm.id DESC
            ");
        if($query->num_rows()>0){
            foreach($query->result_array() as $row){
                $dataquery[] = array( $row['projectname'], $this->get_sub_project($row['idproject']), $row['idproject']);
            }
            return $dataquery;
        }
    }

    /*

    */
    public function get_sub_project($id){
        $query = $this->db->query("
                SELECT spm.id AS idsubproject, spm.name AS subprojectname
                FROM subproject_master spm
                WHERE spm.project_id = '$id'
            ");
        if($query->num_rows()>0){
            foreach($query->result() as $row){
                $dataquery[] = $row;
            }
            return $dataquery;
        }
    }

    public function get_all_projectdetail($idsubproject)
    {
     /*   $query = $this->db->query("select project_master.name AS project, subproject_master.name AS subproject, category_master.name AS category, item_master.name AS barang, 	transaction_usage_detail.item_count AS quantity, unit_master.name AS satuan, stock_master.item_price AS harga, worker_master.name AS tukang
        from project_master, subproject_master, category_master, item_master, transaction_usage_detail, transaction_usage_main, unit_master, stock_master, worker_master
        where subproject_master.project_id = project_master.id AND subproject_master.id=transaction_usage_main.subproject_id AND transaction_usage_main.id=transaction_usage_detail.usage_id AND transaction_usage_main.worker_id=worker_master.id AND transaction_usage_detail.stock_id=stock_master.id AND stock_master.item_id = item_master.id AND item_master.unit_id = unit_master.id AND item_master.category_id=category_master.id AND subproject_master.id='.$id.'");

        return $query;
    */
        $query = $this->db->query("Select pm.name as project, spm.*, cm.name as category, im.name as barang, tud.item_count as quantity, um.name as satuan, sm.item_price as harga, wm.name as tukang, tud.item_count*sm.item_price as total
				from project_master pm left join subproject_master spm on spm.project_id=pm.id
				 left join  transaction_usage_main tum on spm.id=tum.subproject_id
				left join transaction_usage_detail tud on tum.id=tud.usage_id
				left join worker_master wm on tum.worker_id=wm.id
				left join stock_master sm on tud.stock_id=sm.id
				left join item_master im on sm.item_id=im.id
				left join unit_master um on im.unit_id=um.id
				join category_master cm on im.category_id=cm.id
				where spm.id='$idsubproject'
				order by cm.name ASC ");
        return $query->result_array();

     /*   $this->db->select('pm.name as project, spm.*, cm.name as category, im.name as barang, tud.item_count as quantity, um.name as satuan, sm.item_price as harga, wm.name as tukang');
        $this->db->from('project_master pm');
        $this->db->join('subproject_master spm', 'spm.project_id=pm.id', 'left');
        $this->db->join('transaction_usage_main tum', 'spm.id=tum.subproject_id', 'left');
        $this->db->join('transaction_usage_detail tud', 'tum.id=tud.usage_id', 'left');
        $this->db->join('worker_master wm ', 'tum.worker_id=wm.id', 'left');
        $this->db->join('stock_master sm', 'tud.stock_id=sm.id', 'left');
        $this->db->join('item_master im', 'sm.item_id=im.id', 'left');
        $this->db->join('unit_master um', 'im.unit_id=um.id', 'left');
        $this->db->join('category_master cm', 'im.category_id=cm.id', 'left');
        $this->db->where('spm.id',$id);
        $query = $this->db->get();
        $row_array = $query->result_array();
        return $row_array;
     */
    }

    public function getpro($idsubproject)
    {
        $this->db->select('subproject_master.name AS name, subproject_master.id AS id, project_master.name AS project, project_master.id AS projectid');
        $this->db->from('project_master');
        $this->db->join('subproject_master', 'project_master.id = subproject_master.project_id', 'left');
        $this->db->where('subproject_master.id', $idsubproject);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getproj($idsubproject)
    {
        $this->db->select('subproject_master.name AS name, subproject_master.id AS id, project_master.name AS project, project_master.id AS projectid');
        $this->db->from('project_master');
        $this->db->join('subproject_master', 'project_master.id = subproject_master.project_id', 'left');
        $this->db->where('subproject_master.id', $idsubproject);
        $query = $this->db->get();

        return $query->row();
    }

    public function caridata()
    {
        $c = $this->input->POST ('cari');
        $query = $this->db->query("
                SELECT pm.id AS idproject, pm.name AS projectname, cm.name AS company
                FROM project_master pm, company_master cm
                WHERE pm.company_id = cm.id AND cm.name like '%".$c."%'
                ORDER BY pm.id DESC
            ");

        if($query->num_rows()>0){
            foreach($query->result_array() as $row){
                $dataquery[] = array( $row['projectname'], $this->get_sub_project($row['idproject']), $row['idproject']);
            }
            return $dataquery;
        }
        
    }

    public function get_company()
    {
        $query = $this->db->query("select name from company_master");

        return $query->result();

    }

    public function get_category()
    {
        $query = $this->db->query("select * from category_master");

        return $query->result();

    }

    public function get_absensi($idsubproject)
    {
        $query = $this->db->query("select absensi.name as name, absensi.date as date, subproject_master.name as subproject, absensi.count as count, 
                                        absensi.count_time as counttime, SUM(absensi.count_time / absensi.count) as waktu 
                                    from absensi, absensi_detail, subproject_master
                                    where absensi.id = absensi_detail.absensi_id AND subproject_master.id = absensi_detail.subproject_id 
                                            AND subproject_master.id = '$idsubproject'
                                        GROUP BY absensi.name");
        return $query->result_array();   
    }

    public function get_all_planning($idsubproject)
    {
        $query = $this->db->query("select subproject_item_master.name as subproject, unit_master.name as unit, category_master.name as category, item_master.name as item, item_master.id as itemid, planning_master.quantity as quantity, 
                                        (select item_master.name from item_master, finishing_master, planning_master where finishing_master.planning_id = planning_master.id AND finishing_master.item_id = item_master.id AND planning_master.item_id = itemid LIMIT 1) as finishing 
                                    from item_master, planning_master, unit_master, subproject_item_master, subproject_master, category_master
                                    where item_master.id = planning_master.item_id AND category_master.id = item_master.category_id AND unit_master.id = planning_master.unit_id AND planning_master.subproject_item_id = subproject_item_master.id AND subproject_master.id = subproject_item_master.subproject_id AND subproject_master.id ='$idsubproject' ");

        return $query->result_array();
    }

    public function get_all_subitem($idsubproject) 
    {
        $result = $this->db->query ("select subproject_item_master.*
                                        from subproject_item_master, subproject_master 
                                        where subproject_item_master.subproject_id = subproject_master.id AND subproject_master.id='$idsubproject'");
        return $result->result_array();
    }

    public function cariitem()
    {
        $subitem = $this->input->post('subitem');
        $sub = $this->input->post('sub');
        $query = $this->db->query("select subproject_item_master.name as subproject, unit_master.name as unit, category_master.name as category, item_master.name as item, item_master.id as itemid, planning_master.quantity as quantity, 
                                        (select item_master.name from item_master, finishing_master, planning_master where finishing_master.planning_id = planning_master.id AND finishing_master.item_id = item_master.id AND planning_master.item_id = itemid LIMIT 1) as finishing 
                                    from item_master, planning_master, unit_master, subproject_item_master, subproject_master, category_master
                                    where item_master.id = planning_master.item_id AND category_master.id = item_master.category_id AND unit_master.id = planning_master.unit_id AND planning_master.subproject_item_id = subproject_item_master.id AND subproject_master.id = subproject_item_master.subproject_id AND subproject_master.id = '$sub' AND subproject_item_master.id ='$subitem'");

        return $query->result_array();
    }

    public function get_all_carisubitem() 
    {
        $sub = $this->input->post('sub');
        $result = $this->db->query ("select subproject_item_master.*
                                        from subproject_item_master, subproject_master 
                                        where subproject_item_master.subproject_id = subproject_master.id AND subproject_master.id='$sub'");
        return $result->result_array();
    }

    public function getprojitem()
    {
        $sub = $this->input->post('sub');
        $this->db->select('subproject_master.name AS name, subproject_master.id AS id, project_master.name AS project, project_master.id AS projectid');
        $this->db->from('project_master');
        $this->db->join('subproject_master', 'project_master.id = subproject_master.project_id', 'left');
        $this->db->where('subproject_master.id', $sub);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_subprojectitem_by_name($name){
        $query = $this->db->get_where('subproject_item_master', array('name' => $name));
        return $query->row_array();
    }

    public function set_subprojectitem()
    {
        if($this->input->post('subproject_item') !== false)
        {
            $data = array(
                'name' => $this->input->post('subproject_item'),
                'subproject_id' => $this->input->post('sub')
            );

            return $this->db->insert('subproject_item_master', $data);
        }else{
            return false;
        }
    }

    /*public function get_all_planningnew($idsubproject)
    {
        $query = $this->db->query("select category_master.name as category, 
    item_master.name as item, 
    item_master.id as itemid,
planning_master.quantity as quantity, 
(select item_master.name 
    from item_master, finishing_master, planning_master 
    where finishing_master.planning_id = planning_master.id 
    AND finishing_master.item_id = item_master.id 
    AND planning_master.item_id = itemid LIMIT 1) as finishing 
from item_master, planning_master, unit_master, subproject_item_master, subproject_master, category_master
where item_master.id = planning_master.item_id 
AND category_master.id = item_master.category_id 
AND unit_master.id = planning_master.unit_id 
AND planning_master.subproject_item_id = subproject_item_master.id 
AND subproject_master.id = subproject_item_master.subproject_id
");

        return $query->result_array();
    }*/

}
?>