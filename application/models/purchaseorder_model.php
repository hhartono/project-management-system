<?php
class Purchaseorder_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_unit_by_id($id){
        /*
        $query = $this->db->get_where('unit_master', array('id' => $id));
        return $query->row_array();
        */
    }

    public function get_purchaseorder_by_purchaseorder_code($purchaseorder_code){
        $query = $this->db->get_where('transaction_po_main', array('po_reference_number' => $purchaseorder_code));
        return $query->row_array();
    }

    public function get_all_purchaseorders()
    {
        $this->db->select('transaction_po_main.*, customer_master.name AS customer, supplier_master.name AS supplier');
        $this->db->from('transaction_po_main');
        $this->db->join('customer_master', 'transaction_po_main.customer_id = customer_master.id');
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
                    $result_array[$walk]['formatted_po_input_date'] = date("d-m-Y", strtotime($result_array[$walk]['po_input_date']));
                }
            }

            return $result_array;
        }
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

    public function set_po_detail($database_input_array)
    {
        if($database_input_array['supplier_id'] !== false && $database_input_array['customer_id'] !== false
            && $database_input_array['po_item_values'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            // start database transaction
            $this->db->trans_start();

            // PART 1 - set PO main
            $data = array(
                'po_reference_number' => $database_input_array['po_reference_number'],
                'supplier_id' => $database_input_array['supplier_id'],
                'customer_id' => $database_input_array['customer_id'],
                'po_input_date' => date("Y-m-d H:i:s")
            );
            $this->db->insert('transaction_po_main', $data);

            // PART 2 - set PO detail
            $database_input_array['po_id'] = $this->db->insert_id();
            foreach($database_input_array['po_item_values'] as $each_po_item){
                $data = array(
                    'po_id' => $database_input_array['po_id'],
                    'item_id' => $each_po_item['item_id'],
                    'quantity' => $each_po_item['item_count'],
                    'notes' => $each_po_item['item_notes'],
                    'creation_date' => date("Y-m-d H:i:s")
                );
                $this->db->insert('transaction_po_detail', $data);
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
}