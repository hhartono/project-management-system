<?php
class Printbarcode_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_barcode_detail_by_po_id($po_id){
        // start database transaction
        $this->db->trans_begin();

        $this->db->select('barcode_master.*, item_master.name as item, item_master.item_code as item_code');
        $this->db->from('barcode_master, item_master, transaction_po_detail');
        $this->db->where('barcode_master.po_id = transaction_po_detail.po_id');
        $this->db->where('transaction_po_detail.item_id = item_master.id');
        $this->db->where('barcode_master.po_id', $po_id);
        $this->db->where('print_status', '1');
        $query = $this->db->get();
        $result_array = $query->result_array();

        // update print status to 2
        foreach($result_array as $each_result){
            $data = array(
                'print_status' => '2',
            );

            $this->db->where('id', $each_result['id']);
            $this->db->update('barcode_master', $data);
        }


        // complete database transaction
        $this->db->trans_complete();

        // return false if something went wrong
        if ($this->db->trans_status() === FALSE){
            return FALSE;
        }else{
            return $result_array;
        }
    }

    public function get_barcode_stock_by_id($id){
        // start database transaction
        $this->db->trans_begin();

        $this->db->select('stock_master.*, item_master.name as item, item_master.item_code as item_code');
        $this->db->from('stock_master, item_master');
        $this->db->where('stock_master.item_id = item_master.id');
        $this->db->where('stock_master.id', $id);
        $this->db->where('stock_master.print_status', '1');
        $query = $this->db->get();
        $result_array = $query->result_array();

        // update print status to 2
        foreach($result_array as $each_result){
            $data = array(
                'print_status' => '2',
            );

            $this->db->where('id', $each_result['id']);
            $this->db->update('stock_master', $data);
        }


        // complete database transaction
        $this->db->trans_complete();

        // return false if something went wrong
        if ($this->db->trans_status() === FALSE){
            return FALSE;
        }else{
            return $result_array;
        }
    }

    public function get_barcode_stock_press_by_id($id){
        // start database transaction
        $this->db->trans_begin();

        $this->db->select('stock_press_master.*');
        $this->db->from('stock_press_master');
        $this->db->where('stock_press_master.id', $id);
        $query = $this->db->get();
        $result_array = $query->result_array();

        // complete database transaction
        $this->db->trans_complete();

        // return false if something went wrong
        if ($this->db->trans_status() === FALSE){
            return FALSE;
        }else{
            return $result_array;
        }
    }
}