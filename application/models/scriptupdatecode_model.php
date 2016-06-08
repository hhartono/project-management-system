<?php
class Scriptupdatecode_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_item_code()
    {
    	$query = $this->db->query("select item_master.id as id, item_master.item_code as code, stock_master.item_stock_code as itemcode, item_master.name as item
										from item_master, stock_master 
										where item_master.id = stock_master.item_id 
										group by item_master.name DESC");
    	$result_array = $query->result_array();
        return $result_array;
    }

    public function updateitemcode()
    {
    	$code = $this->get_item_code();
    	foreach ($code as $codes) {
    		$data = array(
                'item_code' => $codes['itemcode']
            );
            $id = $codes['id'];
            $this->db->where('id', $id);
            $this->db->update('item_master', $data);
    	}
    }
}
?>