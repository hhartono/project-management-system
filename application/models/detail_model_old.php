<?php
class Detail_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_all_detail()
    {
        $this->db->select('subproject_master.name AS name, subproject_master.id AS id, project_master.name AS project, project_master.id AS id_project ');
        $this->db->from('project_master');
        $this->db->join('subproject_master', 'project_master.id = subproject_master.project_id', 'left');
        $this->db->order_by('project_master.id','DESC');
        $query = $this->db->get();

        return $query->result_array();

    }

    public function get_all_sub()
    {
        $this->db->select('subproject_master.name AS name');
        $this->db->from('project_master');
        $this->db->join('subproject_master', 'project_master.id = subproject_master.project_id', 'left');
        $this->db->order_by('project_master.id','DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
             return $query->result_array();
        }
            else
        {
            return false;
        }

    }

    public function get_all_projectdetail($id)
    {
     /*   $query = $this->db->query("select project_master.name AS project, subproject_master.name AS subproject, category_master.name AS category, item_master.name AS barang, 	transaction_usage_detail.item_count AS quantity, unit_master.name AS satuan, stock_master.item_price AS harga, worker_master.name AS tukang
        from project_master, subproject_master, category_master, item_master, transaction_usage_detail, transaction_usage_main, unit_master, stock_master, worker_master
        where subproject_master.project_id = project_master.id AND subproject_master.id=transaction_usage_main.subproject_id AND transaction_usage_main.id=transaction_usage_detail.usage_id AND transaction_usage_main.worker_id=worker_master.id AND transaction_usage_detail.stock_id=stock_master.id AND stock_master.item_id = item_master.id AND item_master.unit_id = unit_master.id AND item_master.category_id=category_master.id AND subproject_master.id='.$id.'");

        return $query;
    */
        $query = $this->db->query("Select pm.name as project, spm.*, cm.name as category, im.name as barang, tud.item_count as quantity, um.name as satuan, sm.item_price as harga, wm.name as tukang
				from project_master pm left join subproject_master spm on spm.project_id=pm.id
				 left join  transaction_usage_main tum on spm.id=tum.subproject_id
				left join transaction_usage_detail tud on tum.id=tud.usage_id
				left join worker_master wm on tum.worker_id=wm.id
				left join stock_master sm on tud.stock_id=sm.id
				left join item_master im on sm.item_id=im.id
				left join unit_master um on im.unit_id=um.id
				left join category_master cm on im.category_id=cm.id
				where spm.id='$id'");
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
}
?>