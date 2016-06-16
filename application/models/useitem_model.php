<?php
class Useitem_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_purchaseorder_by_id($id){
        $this->db->select('transaction_po_main.*, supplier_master.name AS supplier, project_master.name AS project');
        $this->db->from('transaction_po_main');
        $this->db->join('supplier_master', 'transaction_po_main.supplier_id = supplier_master.id');
        $this->db->join('project_master', 'transaction_po_main.project_id = project_master.id');
        $this->db->where('transaction_po_main.id', $id);
        $query = $this->db->get();

        $row_array = $query->row_array();
        return $row_array;
    }

    public function get_purchaseorder_by_purchaseorder_code($purchaseorder_code){
        $query = $this->db->get_where('transaction_po_main', array('po_reference_number' => $purchaseorder_code));
        return $query->row_array();
    }

    public function get_all_purchaseorders()
    {
        $this->db->select('transaction_po_main.*, project_master.name AS project, supplier_master.name AS supplier');
        $this->db->from('transaction_po_main');
        $this->db->join('project_master', 'transaction_po_main.project_id = project_master.id');
        $this->db->join('supplier_master', 'transaction_po_main.supplier_id = supplier_master.id');
        $query = $this->db->get();

        $result_array = $query->result_array();
        if($result_array === false){
            return false;
        }else{
            date_default_timezone_set('Asia/Jakarta');
            $array_length = count($result_array);
            for($walk = 0; $walk < $array_length; $walk++){
                if(strtotime($result_array[$walk]['po_input_date']) <= 0){
                    $result_array[$walk]['formatted_po_input_date'] = "";
                }else{
                    $result_array[$walk]['formatted_po_input_date'] = date("d-m-Y H:i", strtotime($result_array[$walk]['po_input_date']));
                }

                if(strtotime($result_array[$walk]['po_close_date']) <= 0){
                    $result_array[$walk]['formatted_po_close_date'] = "";
                }else{
                    $result_array[$walk]['formatted_po_close_date'] = date("d-m-Y", strtotime($result_array[$walk]['po_close_date']));
                }
            }

            return $result_array;
        }
    }

    public function get_purchaseorder_detail_by_po_id($po_id){
        $this->db->select('transaction_po_detail.*, item_master.name AS item_name');
        $this->db->from('transaction_po_detail');
        $this->db->join('item_master', 'transaction_po_detail.item_id = item_master.id');
        $this->db->where('po_id', $po_id);
        $query = $this->db->get();

        $result_array = $query->result_array();
        return $result_array;
    }

    public function update_unit()
    {
        /*
        if($this->input->post('id') !== false && $this->input->post('abbreviation') !== false
            && $this->input->post('name') !== false && $this->input->post('notes') !== false){
            $data = array(
                'abbreviation' => $this->input->post('abbreviation'),
                'name' => $this->input->post('name'),
                'notes' => $this->input->post('notes')
            );

            $this->db->where('id', $this->input->post('id'));
            return $this->db->update('unit_master', $data);
        }else{
            return false;
        }
        */
    }

    public function get_stock($item_code)
    {
        $query = $this->db->query("select stock_master.*, item_master.name AS item_name, item_master.item_code AS item_code
                                    from stock_master join item_master ON stock_master.item_id = item_master.id
                                    join unit_master ON item_master.unit_id = unit_master.id 
                                    where item_master.item_code = '$item_code' AND stock_master.item_count!=0");

        return $query->result_array();
    }

    public function get_stock_press($item_code)
    {
        $query = $this->db->query("select stock_press_master.*
                                    from stock_press_master 
                                    where stock_press_master.stock_press_code = '$item_code' AND stock_press_master.jumlah!=0");

        return $query->result_array();
    }

    public function get_stock_pelapis($item_code)
    {
        $query = $this->db->query("select stock_pelapis_master.*
                                    from stock_pelapis_master 
                                    where stock_pelapis_master.stock_kode_pelapis = '$item_code' AND stock_pelapis_master.jumlah!=0");

        return $query->result_array();
    }

    public function set_useitem_detail($database_input_array)
    {
        if($database_input_array['subproject_id'] !== false //&& $database_input_array['project_id'] !== false
            && $database_input_array['worker_id'] !== false && $database_input_array['useitem_item_values'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            // start database transaction
           $this->db->trans_start();

            foreach($database_input_array['useitem_item_values'] as $each_usage_item){
                if($each_usage_item['category'] == 'Press'){
                    $data = array(
                        'subproject_id' => $database_input_array['subproject_id'],
                        'worker_id' => $database_input_array['worker_id'],
                        'user_id' => $database_input_array['user'],
                        'creation_date' => date("Y-m-d H:i:s"),
                        'last_update_timestamp' => date("Y-m-d H:i:s")
                        );
                    $this->db->insert('transaction_usage_press_main', $data);

                    $database_input_array['usage_press_id'] = $this->db->insert_id();

                    $getstock = $this->get_stock_press($each_usage_item['item_stock_code']);

                    foreach ($getstock as $getstock) {
                        $data = array(
                            'jumlah' => $getstock['jumlah'] - $each_usage_item['item_usage']
                        );
                        $stock_press_id = $getstock['id'];
                        $this->db->where('id', $stock_press_id);
                        $this->db->update('stock_press_master', $data);

                        $data = array(
                            'usage_press_id' => $database_input_array['usage_press_id'],
                            'stock_press_id' => $stock_press_id,
                            'item_count' => $each_usage_item['item_usage'],
                            'user_id' => $database_input_array['user'],
                            'creation_date' => date("Y-m-d H:i:s"),
                            'last_update_timestamp' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('transaction_usage_press_detail', $data);        
                    }
                }elseif($each_usage_item['category'] == 'Veneer') {
                    $data = array(
                        'subproject_id' => $database_input_array['subproject_id'],
                        'worker_id' => $database_input_array['worker_id'],
                        'user_id' => $database_input_array['user'],
                        'creation_date' => date("Y-m-d H:i:s"),
                        'last_update_timestamp' => date("Y-m-d H:i:s")
                        );
                    $this->db->insert('transaction_usage_pelapis_main', $data);

                    $database_input_array['usage_pelapis_id'] = $this->db->insert_id();

                    $getstock = $this->get_stock_pelapis($each_usage_item['item_stock_code']);

                    foreach ($getstock as $getstock) {
                        $data = array(
                            'jumlah' => $getstock['jumlah'] - $each_usage_item['item_usage']
                        );
                        $stock_pelapis_id = $getstock['id'];
                        $this->db->where('id', $stock_pelapis_id);
                        $this->db->update('stock_pelapis_master', $data);

                        $data = array(
                            'usage_pelapis_id' => $database_input_array['usage_pelapis_id'],
                            'stock_pelapis_id' => $stock_pelapis_id,
                            'item_count' => $each_usage_item['item_usage'],
                            'user_id' => $database_input_array['user'],
                            'creation_date' => date("Y-m-d H:i:s"),
                            'last_update_timestamp' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('transaction_usage_pelapis_detail', $data);        
                    }
                }else{

                    /*$data = array(
                        'usage_id' => $database_input_array['usage_id'],
                        'stock_id' => $each_usage_item['stock_id'],
                        'item_count' => $each_usage_item['item_usage'],
                        'creation_date' => date("Y-m-d H:i:s"),
                        'item_code' => $each_usage_item['item_stock_code']
                    );
                    $this->db->insert('transaction_usage_detail', $data);*/

                    $data = array(
                        //'project_id' => $database_input_array['project_id'],
                        'subproject_id' => $database_input_array['subproject_id'],
                        'worker_id' => $database_input_array['worker_id'],
                        'user_id' => $database_input_array['user'],
                        'creation_date' => date("Y-m-d H:i:s"),
                        'last_update_timestamp' => date("Y-m-d H:i:s")
                        );
                    $this->db->insert('transaction_usage_main', $data);

                    $database_input_array['usage_id'] = $this->db->insert_id();

                    $getstock = $this->get_stock($each_usage_item['item_stock_code']);

                    foreach ($getstock as $getstock) {
                        if($each_usage_item['item_usage'] > $getstock['item_count'] ){
                            $current = $getstock['item_count'] - $getstock['item_count'];
                            $currentitemusage = $each_usage_item['item_usage'] - $getstock['item_count'];
                            $stock = $getstock['item_count'];
                            //$each_usage_item['item_usage'] = $each_usage_item['item_usage'] - $getstock['item_count'];                    
                        }else if($each_usage_item['item_usage'] < $getstock['item_count'] ){
                            $current = $getstock['item_count'] - $each_usage_item['item_usage'];
                            $currentitemusage = $each_usage_item['item_usage'] - $each_usage_item['item_usage'];
                            $stock = $each_usage_item['item_usage'];
                            //$each_usage_item['item_usage'] = 0;
                        }else{
                            $current = $getstock['item_count'] - $each_usage_item['item_usage'];
                            $currentitemusage = $getstock['item_count'] - $each_usage_item['item_usage'];
                            $stock = $each_usage_item['item_usage'];
                            //$each_usage_item['item_usage'] = 0;
                        }
                        $data = array(
                            // 'item_count' => $getstock['item_count'] - $each_usage_item['item_usage']
                            'item_count' => $current
                        );
                        $stock_id = $getstock['id'];
                        $this->db->where('id', $stock_id);
                        $this->db->update('stock_master', $data);

                        $data = array(
                            'usage_id' => $database_input_array['usage_id'],
                            'stock_id' => $stock_id,
                            'item_count' => $stock,
                            'user_id' => $database_input_array['user'],
                            'creation_date' => date("Y-m-d H:i:s"),
                            //'item_code' => $each_usage_item['item_stock_code'],
                            'last_update_timestamp' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('transaction_usage_detail', $data);

                        $data = array(
                            'stock_id' => $stock_id,
                            'item_count' => $each_usage_item['item_stock'],
                            'jumlah_perubahan' => $current,
                            'status' => '2',
                            'date' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('item_count_history', $data);

                        // update the required item count
                        $each_usage_item['item_usage'] = $currentitemusage;

                        // break the loop if all the item has been fulfilled
                        if($each_usage_item['item_usage'] <= 0){
                            break;
                        }
                    }

                    if ($each_usage_item['item_usage'] > 0){
                        // TODO - display error message - item not enough
                        $this->db->trans_rollback(); 
                        return FALSE;
                    }
                }
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