<?php
class Createpo_model extends CI_Model {
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

    public function get_unit_by_abbreviation($abbreviation){
        /*
        $query = $this->db->get_where('unit_master', array('abbreviation' => $abbreviation));
        return $query->row_array();
        */
    }

    public function get_all_units()
    {
        /*
        $query = $this->db->get('unit_master');
        return $query->result_array();
        */
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

    public function delete_unit($unit_id){
        /*s
        $response = $this->db->delete('unit_master', array('id' => $unit_id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
        */
    }
}