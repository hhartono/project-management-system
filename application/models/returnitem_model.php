<?php
class Returnitem_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }
    
    public function set_returnitem_detail($database_input_array)
    {
        if($database_input_array['worker_id'] !== false && $database_input_array['returnitem_item_values'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            // start database transaction
            $this->db->trans_start();

            // PART 1 - set PO main
            $data = array(
                'subproject_id' => $database_input_array['subproject_id'],
                'worker_id' => $database_input_array['worker_id'],
                'user_id' => $database_input_array['user']
            );
            $this->db->insert('transaction_return_main', $data);

            // PART 2 - set PO detail
            $database_input_array['return_id'] = $this->db->insert_id();
            foreach($database_input_array['returnitem_item_values'] as $each_usage_item){
                $data = array(
                    'return_id' => $database_input_array['return_id'],
                    'stock_id' => $each_usage_item['stock_id'],
                    'return_count' => $each_usage_item['item_usage'],
                    'creation_date' => date("Y-m-d H:i:s")
                );
                $this->db->insert('transaction_return_detail', $data);

                $data = array(
                    'item_count' => $each_usage_item['item_stock'] + $each_usage_item['item_usage']
                );
                $stock_id = $each_usage_item['stock_id'];
                $this->db->where('id', $stock_id);
                $this->db->update('stock_master', $data);
            }
            
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

    public function get_project_by_name($name){
        $query = $this->db->get_where('project_master', array('name' => $name));
        return $query->row_array();
    }

    public function get_all_project()
    {
        $query = $this->db->get('project_master');
        return $query->result_array();
    }

    public function get_worker_by_name($name){
        $query = $this->db->get_where('worker_master', array('name' => $name));
        return $query->row_array();
    }

    public function get_all_worker()
    {
        $query = $this->db->get('worker_master');
        return $query->result_array();
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
}