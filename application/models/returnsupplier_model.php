<?php
class Returnsupplier_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    /*public function get_purchaseorder_by_id($id){
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
*/
    public function set_returnsupplier_detail($database_input_array)
    {
        if($database_input_array['returnsupplier_item_values'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            // start database transaction
            $this->db->trans_start();

            // PART 1 - set PO main
            $data = array(
                'return_reference_number' => $database_input_array['return_reference_number'],
                'supplier_id' => $database_input_array['supplier_id'],
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
                                    from item_master
                                     join stock_master ON item_master.id = stock_master.item_id 
                                     join transaction_return_supplier_detail ON stock_master.id = transaction_return_supplier_detail.stock_id 
                                     left join transaction_return_supplier_main ON transaction_return_supplier_detail.return_supplier_id = transaction_return_supplier_main.id 
                                     left join supplier_master ON transaction_return_supplier_main.supplier_id = supplier_master.id 
                                     left join unit_master ON item_master.unit_id = unit_master.id group by transaction_return_supplier_main.id");

        $result_array = $query->result_array();
        return $result_array;
    }

    public function getreturnsupplier($id)
    {
        $query = $this->db->query("select supplier_master.*
                                    from item_master, stock_master, transaction_return_supplier_main, transaction_return_supplier_detail, supplier_master
                                     where item_master.id = stock_master.item_id AND stock_master.id = transaction_return_supplier_detail.stock_id 
                                        AND transaction_return_supplier_detail.return_supplier_id = transaction_return_supplier_main.id 
                                        AND transaction_return_supplier_main.supplier_id = supplier_master.id AND transaction_return_supplier_main.id = '$id'");

        $result_array = $query->row_array();
        return $result_array;
    }

    public function get_returnsupplier_detail($id){
        $query = $this->db->query("select transaction_return_supplier_main.*, item_master.name as item, transaction_return_supplier_detail.return_count as kembali, supplier_master.name as supplier, unit_master.name as unit
                                    from item_master, stock_master, transaction_return_supplier_main, transaction_return_supplier_detail, supplier_master, unit_master
                                     where item_master.id = stock_master.item_id AND stock_master.id = transaction_return_supplier_detail.stock_id 
                                        AND transaction_return_supplier_detail.return_supplier_id = transaction_return_supplier_main.id 
                                        AND transaction_return_supplier_main.supplier_id = supplier_master.id AND unit_master.id = item_master.unit_id AND transaction_return_supplier_main.id = '$id'");

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