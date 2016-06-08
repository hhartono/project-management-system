<?php
class Detail_model extends CI_Model {
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

    public function get_all_press($idsubproject)
    {
        $query = $this->db->query("select subproject_master.id as id, concat(stock_press_master.bahan_dasar, stock_press_master.sisi1, stock_press_master.sisi2) as barang, transaction_usage_press_detail.item_count as jumlah, unit_master.name as satuan, category_master.name as kategori
            from stock_press_master, transaction_usage_press_detail, transaction_usage_press_main, unit_master, category_master, subproject_master
            where stock_press_master.id = transaction_usage_press_detail.stock_press_id AND transaction_usage_press_main.id = transaction_usage_press_detail.usage_press_id AND stock_press_master.unit_id = unit_master.id AND stock_press_master.category_id = category_master.id AND  transaction_usage_press_main.subproject_id = subproject_master.id AND transaction_usage_press_main.subproject_id ='$idsubproject'");

        return $query->result_array();
    }

    public function get_all_usagepress($subproject_id, $stock_id)
    {
        $query = $this->db->query("select subproject_master.id as id, concat(stock_press_master.bahan_dasar, stock_press_master.sisi1, stock_press_master.sisi2) as barang, transaction_usage_press_detail.item_count as quantity, unit_master.name as satuan, category_master.name as kategori, transaction_usage_press_detail.creation_date as tanggal, worker_master.name as tukang
            from stock_press_master, transaction_usage_press_detail, transaction_usage_press_main, unit_master, category_master, subproject_master, worker_master
            where stock_press_master.id = transaction_usage_press_detail.stock_press_id AND transaction_usage_press_main.id = transaction_usage_press_detail.usage_press_id AND stock_press_master.unit_id = unit_master.id AND stock_press_master.category_id = category_master.id AND  transaction_usage_press_main.subproject_id = subproject_master.id AND transaction_usage_press_main.worker_id = worker_master.id AND  transaction_usage_press_main.subproject_id ='$idsubproject' AND stock_press_master.id = '$stock_id'");

        return $query->result_array();
    }

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
        /*$query = $this->db->query("Select pm.name as project, spm.*, cm.name as category, im.name as barang, tud.item_count as quantity, um.name as satuan, sm.item_price as harga, wm.name as tukang, tud.item_count*sm.item_price as total, com.id as company, pm.company_id as idcompany
				from project_master pm left join subproject_master spm on spm.project_id=pm.id
				 left join  transaction_usage_main tum on spm.id=tum.subproject_id
				left join transaction_usage_detail tud on tum.id=tud.usage_id
				left join worker_master wm on tum.worker_id=wm.id
				left join stock_master sm on tud.stock_id=sm.id
				left join item_master im on sm.item_id=im.id
				left join unit_master um on im.unit_id=um.id
				join category_master cm on im.category_id=cm.id
				left join company_master com on com.id = sm.company_id
                where spm.id='$idsubproject'
				order by cm.name ASC ");
        return $query->result_array();*/

        $query = $this->db->query("select category, barang, sum(quantity) as quantity, satuan, sum(total) as total, company, idcompany, id, stock, harga, tukang
from(Select pm.name as project, spm.*, cm.name as category, im.name as barang, sum(tud.item_count) as quantity, um.name as satuan, sum(tud.item_count*sm.item_price) as total, com.id as company, pm.company_id as idcompany, sm.id as stock, sm.item_price as harga, wm.name as tukang
                from project_master pm left join subproject_master spm on spm.project_id=pm.id
                 left join  transaction_usage_main tum on spm.id=tum.subproject_id
                left join transaction_usage_detail tud on tum.id=tud.usage_id
                left join worker_master wm on tum.worker_id=wm.id
                left join stock_master sm on tud.stock_id=sm.id
                left join item_master im on sm.item_id=im.id
                left join unit_master um on im.unit_id=um.id
                join category_master cm on im.category_id=cm.id
                left join company_master com on com.id = sm.company_id
                where spm.id='$idsubproject'
                group by sm.id
UNION
Select pm.name as project, spm.*, cm.name as category, im.name as barang, -sum(trd.return_count) as quantity, um.name as satuan, -sum(trd.return_count*sm.item_price) as total, com.id as company, pm.company_id as idcompany, sm.id as stock, sm.item_price as harga, wm.name as tukang
                from project_master pm left join subproject_master spm on spm.project_id=pm.id
                 left join  transaction_return_main trm on spm.id=trm.subproject_id
                left join transaction_return_detail trd on trm.id=trd.return_id
                left join worker_master wm on trm.worker_id=wm.id
                left join stock_master sm on trd.stock_id=sm.id
                left join item_master im on sm.item_id=im.id
                left join unit_master um on im.unit_id=um.id
                join category_master cm on im.category_id=cm.id
                left join company_master com on com.id = sm.company_id
                where spm.id='$idsubproject'
                group by sm.id) as detail group by detail.stock");
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

    public function get_all_projectdetail2($idsubproject)
    {
       $query = $this->db->query("select category, barang, sum(quantity) as quantity, satuan, sum(total) as total, company, idcompany, id, stock
from(Select pm.name as project, spm.*, cm.name as category, im.name as barang, sum(tud.item_count) as quantity, um.name as satuan, sum(tud.item_count*sm.item_price) as total, com.id as company, pm.company_id as idcompany, sm.id as stock
                from project_master pm left join subproject_master spm on spm.project_id=pm.id
                 left join  transaction_usage_main tum on spm.id=tum.subproject_id
                left join transaction_usage_detail tud on tum.id=tud.usage_id
                left join stock_master sm on tud.stock_id=sm.id
                left join item_master im on sm.item_id=im.id
                left join unit_master um on im.unit_id=um.id
                join category_master cm on im.category_id=cm.id
                left join company_master com on com.id = sm.company_id
                where spm.id='$idsubproject'
                group by sm.id
UNION
Select pm.name as project, spm.*, cm.name as category, im.name as barang, -sum(trd.return_count) as quantity, um.name as satuan, -sum(trd.return_count*sm.item_price) as total, com.id as company, pm.company_id as idcompany, sm.id as stock
                from project_master pm left join subproject_master spm on spm.project_id=pm.id
                 left join  transaction_return_main trm on spm.id=trm.subproject_id
                left join transaction_return_detail trd on trm.id=trd.return_id
                left join stock_master sm on trd.stock_id=sm.id
                left join item_master im on sm.item_id=im.id
                left join unit_master um on im.unit_id=um.id
                join category_master cm on im.category_id=cm.id
                left join company_master com on com.id = sm.company_id
                where spm.id='$idsubproject'
                group by sm.id) as detail group by detail.stock");
        return $query->result_array();
    }

    public function get_all_sumpriceproject($idsubproject)
    {
        $query = $this->db->query("select category, barang, sum(quantity) as quantity, satuan, sum(total) as total, company, idcompany, id, stock
from(Select pm.name as project, spm.*, cm.name as category, im.name as barang, sum(tud.item_count) as quantity, um.name as satuan, sum(tud.item_count*sm.item_price) as total, com.id as company, pm.company_id as idcompany, sm.id as stock
                from project_master pm left join subproject_master spm on spm.project_id=pm.id
                 left join  transaction_usage_main tum on spm.id=tum.subproject_id
                left join transaction_usage_detail tud on tum.id=tud.usage_id
                left join stock_master sm on tud.stock_id=sm.id
                left join item_master im on sm.item_id=im.id
                left join unit_master um on im.unit_id=um.id
                join category_master cm on im.category_id=cm.id
                left join company_master com on com.id = sm.company_id
                where spm.id='$idsubproject'
                group by sm.id
UNION
Select pm.name as project, spm.*, cm.name as category, im.name as barang, -sum(trd.return_count) as quantity, um.name as satuan, -sum(trd.return_count*sm.item_price) as total, com.id as company, pm.company_id as idcompany, sm.id as stock
                from project_master pm left join subproject_master spm on spm.project_id=pm.id
                 left join  transaction_return_main trm on spm.id=trm.subproject_id
                left join transaction_return_detail trd on trm.id=trd.return_id
                left join stock_master sm on trd.stock_id=sm.id
                left join item_master im on sm.item_id=im.id
                left join unit_master um on im.unit_id=um.id
                join category_master cm on im.category_id=cm.id
                left join company_master com on com.id = sm.company_id
                where spm.id='$idsubproject'
                group by sm.id) as detail group by detail.stock");
        return $query->result_array();
    }

    public function get_all_usageproject($idsubproject, $stock_id)
    {
        $query = $this->db->query("Select pm.name as project, spm.*, cm.name as category, im.name as barang, tud.item_count as quantity, um.name as satuan, sm.item_price as harga, tud.item_count*sm.item_price as total, tud.creation_date as tanggal, com.id as company, pm.company_id as idcompany, sm.id as stock, wm.name as tukang, im.name as item
                from project_master pm left join subproject_master spm on spm.project_id=pm.id
                 left join  transaction_usage_main tum on spm.id=tum.subproject_id
                left join transaction_usage_detail tud on tum.id=tud.usage_id
                left join worker_master wm on tum.worker_id=wm.id
                left join stock_master sm on tud.stock_id=sm.id
                left join item_master im on sm.item_id=im.id
                left join unit_master um on im.unit_id=um.id
                join category_master cm on im.category_id=cm.id
                left join company_master com on com.id = sm.company_id
                where spm.id='$idsubproject' AND sm.id = '$stock_id'
UNION
Select pm.name as project, spm.*, cm.name as category, im.name as barang, -trd.return_count as quantity, um.name as satuan, sm.item_price as harga, -trd.return_count*sm.item_price as total, trd.creation_date as tanggal, com.id as company, pm.company_id as idcompany, sm.id as stock, wm.name as tukang, im.name as item
                from project_master pm left join subproject_master spm on spm.project_id=pm.id
                 left join  transaction_return_main trm on spm.id=trm.subproject_id
                left join transaction_return_detail trd on trm.id=trd.return_id
                left join worker_master wm on trm.worker_id=wm.id
                left join stock_master sm on trd.stock_id=sm.id
                left join item_master im on sm.item_id=im.id
                left join unit_master um on im.unit_id=um.id
                join category_master cm on im.category_id=cm.id
                left join company_master com on com.id = sm.company_id
                where spm.id='$idsubproject' AND sm.id = '$stock_id'
                ");
        return $query->result_array();
    }

    public function get_all_usageproject2($idsubproject, $stock_id)
    {
        $query = $this->db->query("Select pm.name as project, spm.*, cm.name as category, im.name as barang, tud.item_count as quantity, um.name as satuan, sm.item_price as harga, tud.item_count*sm.item_price as total, tud.creation_date as tanggal, com.id as company, pm.company_id as idcompany, sm.id as stock, wm.name as tukang
                from project_master pm left join subproject_master spm on spm.project_id=pm.id
                 left join  transaction_usage_main tum on spm.id=tum.subproject_id
                left join transaction_usage_detail tud on tum.id=tud.usage_id
                left join worker_master wm on tum.worker_id=wm.id
                left join stock_master sm on tud.stock_id=sm.id
                left join item_master im on sm.item_id=im.id
                left join unit_master um on im.unit_id=um.id
                join category_master cm on im.category_id=cm.id
                left join company_master com on com.id = sm.company_id
                where spm.id='$idsubproject' AND sm.id = '$stock_id'
UNION
Select pm.name as project, spm.*, cm.name as category, im.name as barang, -trd.return_count as quantity, um.name as satuan, sm.item_price as harga, -trd.return_count*sm.item_price as total, trd.creation_date as tanggal, com.id as company, pm.company_id as idcompany, sm.id as stock, wm.name as tukang
                from project_master pm left join subproject_master spm on spm.project_id=pm.id
                 left join  transaction_return_main trm on spm.id=trm.subproject_id
                left join transaction_return_detail trd on trm.id=trd.return_id
                left join worker_master wm on trm.worker_id=wm.id
                left join stock_master sm on trd.stock_id=sm.id
                left join item_master im on sm.item_id=im.id
                left join unit_master um on im.unit_id=um.id
                join category_master cm on im.category_id=cm.id
                left join company_master com on com.id = sm.company_id
                where spm.id='$idsubproject' AND sm.id = '$stock_id'
                ");
        return $query->result_array();
    }

    public function get_company_id(){
        $this->db->select('*');
        $this->db->from('company_master');
        $query = $this->db->get();

        if($query->num_rows() > 0){
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function get_company_project(){
        $idproject = $this->uri->segment(3);
        $this->db->select('company_id');
        $this->db->from('project_master');
        $this->db->where('id', $idproject);
        $query = $this->db->get();

        return $query->row();
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

        return $query->result_array();
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

    public function getabs($idsubproject)
    {
        $this->db->select('subproject_master.name AS name, subproject_master.id AS id, project_master.name AS project, project_master.id AS projectid');
        $this->db->from('project_master');
        $this->db->join('subproject_master', 'project_master.id = subproject_master.project_id', 'left');
        $this->db->where('subproject_master.id', $idsubproject);
        $this->db->group_by('subproject_master.id');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function caritanggal()
    {
        $tanggal1 = $this->input->post('tanggal1');
        $tanggal2 = $this->input->post('tanggal2');
        $subproject = $this->input->post('sub');
        $query = $this->db->query("select absensi.name as name, absensi.date as date, subproject_master.name as subproject, absensi.count as count, 
                                        absensi.count_time as counttime, SUM(absensi.count_time / absensi.count) as waktu 
                                    from absensi, absensi_detail, subproject_master
                                    where absensi.id = absensi_detail.absensi_id AND subproject_master.id = absensi_detail.subproject_id 
                                        AND subproject_master.id = '$subproject' AND (date between '$tanggal1' AND '$tanggal2') 
                                    GROUP BY absensi.name ");
        return $query->result_array();
    }

    public function get_all_workerdetail()
    {
        $idsubproject = $this->input->post('sub');
       $query = $this->db->query("select category, barang, sum(quantity) as quantity, satuan, sum(total) as total, company, idcompany, id, stock, harga, tukang
from(Select pm.name as project, spm.*, cm.name as category, im.name as barang, sum(tud.item_count) as quantity, um.name as satuan, sum(tud.item_count*sm.item_price) as total, com.id as company, pm.company_id as idcompany, sm.id as stock, sm.item_price as harga, wm.name as tukang
                from project_master pm left join subproject_master spm on spm.project_id=pm.id
                 left join  transaction_usage_main tum on spm.id=tum.subproject_id
                left join transaction_usage_detail tud on tum.id=tud.usage_id
                left join worker_master wm on tum.worker_id=wm.id
                left join stock_master sm on tud.stock_id=sm.id
                left join item_master im on sm.item_id=im.id
                left join unit_master um on im.unit_id=um.id
                join category_master cm on im.category_id=cm.id
                left join company_master com on com.id = sm.company_id
                where spm.id='$idsubproject'
                group by sm.id
UNION
Select pm.name as project, spm.*, cm.name as category, im.name as barang, -sum(trd.return_count) as quantity, um.name as satuan, -sum(trd.return_count*sm.item_price) as total, com.id as company, pm.company_id as idcompany, sm.id as stock, sm.item_price as harga, wm.name as tukang
                from project_master pm left join subproject_master spm on spm.project_id=pm.id
                 left join  transaction_return_main trm on spm.id=trm.subproject_id
                left join transaction_return_detail trd on trm.id=trd.return_id
                left join worker_master wm on trm.worker_id=wm.id
                left join stock_master sm on trd.stock_id=sm.id
                left join item_master im on sm.item_id=im.id
                left join unit_master um on im.unit_id=um.id
                join category_master cm on im.category_id=cm.id
                left join company_master com on com.id = sm.company_id
                where spm.id='$idsubproject'
                group by sm.id) as detail group by detail.stock");
        return $query->result_array();

    }

    public function getpro2()
    {
        $subproject = $this->input->post('sub');
        $this->db->select('subproject_master.name AS name, subproject_master.id AS id, project_master.name AS project, project_master.id AS projectid');
        $this->db->from('project_master');
        $this->db->join('subproject_master', 'project_master.id = subproject_master.project_id', 'left');
        $this->db->where('subproject_master.id', $subproject);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getproj2()
    {
        $subproject = $this->input->post('sub');
        $this->db->select('subproject_master.name AS name, subproject_master.id AS id, project_master.name AS project, project_master.id AS projectid');
        $this->db->from('project_master');
        $this->db->join('subproject_master', 'project_master.id = subproject_master.project_id', 'left');
        $this->db->where('subproject_master.id', $subproject);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getproj3()
    {
        $subproject = $this->input->post('sub');
        $this->db->select('subproject_master.name AS name, subproject_master.id AS id, project_master.name AS project, project_master.id AS projectid');
        $this->db->from('project_master');
        $this->db->join('subproject_master', 'project_master.id = subproject_master.project_id', 'left');
        $this->db->where('subproject_master.id', $subproject);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_absensi2()
    {
        $subproject = $this->input->post('sub');
        $query = $this->db->query("select absensi.name as name, absensi.date as date, subproject_master.name as subproject, absensi.count as count, 
                                        absensi.count_time as counttime, SUM(absensi.count_time / absensi.count) as waktu 
                                    from absensi, absensi_detail, subproject_master
                                    where absensi.id = absensi_detail.absensi_id AND subproject_master.id = absensi_detail.subproject_id 
                                            AND subproject_master.id = '$subproject'
                                        GROUP BY absensi.name");
        return $query->result_array();   
    }

    public function get_all_printdetail($idsubproject)
    {
        $query = $this->db->query("Select pm.name as project, spm.*, cm.name as category, im.name as barang, tud.item_count as quantity, um.name as satuan, sm.item_price as harga, wm.name as tukang, tud.item_count*sm.item_price as total, com.id as company, pm.company_id as idcompany, pm.id as idproject
                from project_master pm left join subproject_master spm on spm.project_id=pm.id
                 left join  transaction_usage_main tum on spm.id=tum.subproject_id
                left join transaction_usage_detail tud on tum.id=tud.usage_id
                left join worker_master wm on tum.worker_id=wm.id
                left join stock_master sm on tud.stock_id=sm.id
                left join item_master im on sm.item_id=im.id
                left join unit_master um on im.unit_id=um.id
                join category_master cm on im.category_id=cm.id
                left join company_master com on com.id = sm.company_id
                where spm.id='$idsubproject'
                order by cm.name ASC ");
        return $query->row();
    }

}
?>