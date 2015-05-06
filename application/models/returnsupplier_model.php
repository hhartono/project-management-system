<?php
class Returnsupplier_model extends CI_Model {
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

    public function receive_po_items($database_input_array, $po_id)
    {
        date_default_timezone_set('Asia/Jakarta');

        // start database transaction
        $this->db->trans_begin();

        // remaining counter
        $remaining_counter = 0;

        $po_received_item_values = $database_input_array['po_received_item_values'];
        foreach($po_received_item_values as $each_po_received_item_value){
            // PART 1 - update PO detail
            $data = array(
                'quantity_received' => ($each_po_received_item_value['quantity_received'] + $each_po_received_item_value['quantity_already_received'])
            );
            $this->db->where('id', $each_po_received_item_value['po_detail_id']);
            $this->db->update('transaction_po_detail', $data);

            // PART 2 - insert item to stock
            $additional_database_input_array = $this->prepare_stock_detail($each_po_received_item_value['po_detail_id'], $database_input_array['supplier_id']);
            if(empty($additional_database_input_array)){
                $this->db->trans_rollback();
                return FALSE;
            }

            $data = array(
                'item_id' => $additional_database_input_array['item_id'],
                'supplier_id' => $database_input_array['supplier_id'],
                'project_id' => $database_input_array['project_id'],
                'po_detail_id' => $each_po_received_item_value['po_detail_id'],
                'item_count' => $each_po_received_item_value['quantity_received'],
                'item_stock_code' => $additional_database_input_array['item_stock_code'],
                'item_price' => $each_po_received_item_value['item_price'],
                'received_date' => date("Y-m-d H:i:s")
            );
            $this->db->insert('stock_master', $data);

            // update remaining counter
            $remaining_counter += $each_po_received_item_value['quantity_ordered'] - $each_po_received_item_value['quantity_received'] - $each_po_received_item_value['quantity_already_received'];

            // TODO - generate stock barcode
        }

        // PART 3 - update the PO main if necessary
        if($remaining_counter <= 0){
            $data = array(
                'po_close_date' => date("Y-m-d H:i:s")
            );
            $this->db->where('id', $po_id);
            $this->db->update('transaction_po_main', $data);
        }

        // return false if something went wrong
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return TRUE;
        }
    }


    public function set_returnsupplier_detail($database_input_array)
    {
        if($database_input_array['returnsupplier_item_values'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            // start database transaction
            $this->db->trans_start();

            // PART 1 - set PO main
            $data = array(
                'return_reference_number' => $database_input_array['return_reference_number'],
                //'supplier_id' => $database_input_array['supplier_id'],
                'user_id' => $database_input_array['user']
            );
            $this->db->insert('transaction_return_supplier_main', $data);

            // PART 2 - set PO detail
            $database_input_array['return_id'] = $this->db->insert_id();
            foreach($database_input_array['returnsupplier_item_values'] as $each_usage_item){
                $data = array(
                    'return_supplier_id' => $database_input_array['return_id'],
                    'stock_id' => $each_usage_item['stock_id'],
                    'return_count' => $each_usage_item['item_usage'],
                    'creation_date' => date("Y-m-d H:i:s")
                );
                $this->db->insert('transaction_return_supplier_detail', $data);

                $data = array(
                    'item_count' => $each_usage_item['item_stock'] - $each_usage_item['item_usage']
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

    public function delete_po($po_id){
        // start database transaction
        $this->db->trans_start();

        $main_response = $this->db->delete('transaction_po_main', array('id' => $po_id));
        $main_affected_row = $this->db->affected_rows();

        $detail_response = $this->db->delete('transaction_po_detail', array('po_id' => $po_id));
        $detail_affected_row = $this->db->affected_rows();

        // complete database transaction
        $this->db->trans_complete();

        $delete_status = false;
        if($main_response === true && $detail_response === true && $main_affected_row > 0 && $detail_affected_row > 0 && $this->db->trans_status() !== FALSE){
            $delete_status = true;
        }

        return $delete_status;
    }

    private function prepare_stock_detail($po_detail_id, $supplier_id){
        $additional_database_input_array = array();

        // get the item id
        $this->db->select('transaction_po_detail.*, item_master.category_id AS category_id, item_master.id AS item_id');
        $this->db->from('transaction_po_detail');
        $this->db->join('item_master', 'transaction_po_detail.item_id = item_master.id');
        $this->db->where('transaction_po_detail.id', $po_detail_id);
        $query = $this->db->get();
        $item_detail = $query->row_array();

        if(!empty($item_detail)){
            $additional_database_input_array['item_id'] = $item_detail['item_id'];

            // generate item stock code
            $this->load->helper('stock_code_helper');
            $generated_stock_code = stock_code_generator($item_detail['category_id'], $supplier_id);

            if(!empty($generated_stock_code)){
                $additional_database_input_array['item_stock_code'] = $generated_stock_code;

                return $additional_database_input_array;
            }else{
                return FALSE;
            }
        }else{
            return FALSE;
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

    public function get_supplier_by_name($name){
        $query = $this->db->get_where('supplier_master', array('name' => $name));
        return $query->row_array();
    }

    public function get_all_supplier()
    {
        $query = $this->db->get('supplier_master');
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

    public function get_all_return_supplier()
    {
        $query = $this->db->query("select transaction_return_supplier_main.*, item_master.name as item, transaction_return_supplier_detail.return_count as kembali, supplier_master.name as supplier, unit_master.name as unit
                                    from item_master, stock_master, transaction_return_supplier_main, transaction_return_supplier_detail, supplier_master, unit_master
                                     where item_master.id = stock_master.item_id AND stock_master.id = transaction_return_supplier_detail.stock_id 
                                        AND transaction_return_supplier_detail.return_supplier_id = transaction_return_supplier_main.id 
                                        AND stock_master.supplier_id = supplier_master.id AND item_master.unit_id = unit_master.id group by transaction_return_supplier_main.id");

        $result_array = $query->result_array();
        return $result_array;
    }

    public function getreturnsupplier($id)
    {
        $query = $this->db->query("select supplier_master.*
                                    from item_master, stock_master, transaction_return_supplier_main, transaction_return_supplier_detail, supplier_master
                                     where item_master.id = stock_master.item_id AND stock_master.id = transaction_return_supplier_detail.stock_id 
                                        AND transaction_return_supplier_detail.return_supplier_id = transaction_return_supplier_main.id 
                                        AND stock_master.supplier_id = supplier_master.id AND transaction_return_supplier_main.id = '$id'");

        $result_array = $query->row_array();
        return $result_array;
    }

    public function get_returnsupplier_detail($id){
        $query = $this->db->query("select transaction_return_supplier_main.*, item_master.name as item, transaction_return_supplier_detail.return_count as kembali, supplier_master.name as supplier, unit_master.name as unit
                                    from item_master, stock_master, transaction_return_supplier_main, transaction_return_supplier_detail, supplier_master, unit_master
                                     where item_master.id = stock_master.item_id AND stock_master.id = transaction_return_supplier_detail.stock_id 
                                        AND transaction_return_supplier_detail.return_supplier_id = transaction_return_supplier_main.id 
                                        AND stock_master.supplier_id = supplier_master.id AND unit_master.id = item_master.unit_id AND transaction_return_supplier_main.id = '$id'");

        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_returnsupplier_details($id){
        $query = $this->db->query("select transaction_return_supplier_main.*, item_master.name as item, transaction_return_supplier_detail.return_count as kembali, supplier_master.name as supplier, unit_master.name as unit
                                    from item_master, stock_master, transaction_return_supplier_main, transaction_return_supplier_detail, supplier_master, unit_master
                                     where item_master.id = stock_master.item_id AND stock_master.id = transaction_return_supplier_detail.stock_id 
                                        AND transaction_return_supplier_detail.return_supplier_id = transaction_return_supplier_main.id 
                                        AND stock_master.supplier_id = supplier_master.id AND unit_master.id = item_master.unit_id AND transaction_return_supplier_main.id = '$id'");

        $result_array = $query->row();
        return $result_array;
    }

    public function get_returnsupplier_by_returnsupplier_code($returnsupplier_code){
        $query = $this->db->get_where('transaction_return_supplier_main', array('return_reference_number' => $returnsupplier_code));
        return $query->row_array();
    }
}