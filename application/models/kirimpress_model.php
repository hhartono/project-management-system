<?php
class Kirimpress_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_all_bahandasar()
    {
        $this->db->select('item_master.*, category_master.name AS category');
        $this->db->from('item_master');
        $this->db->join('stock_master', 'item_master.id = stock_master.item_id');
        $this->db->join('category_master', 'item_master.category_id = category_master.id');
        $where = "stock_master.item_count > '0' AND category_master.name = 'plywood'";
        $this->db->where($where, NULL, FALSE);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_all_sisi()
    {
        $this->db->select('item_master.*, category_master.name AS category');
        $this->db->from('item_master');
        $this->db->join('stock_master', 'item_master.id = stock_master.item_id');
        $this->db->join('category_master', 'item_master.category_id = category_master.id');
        $where = "stock_master.item_count > '0' AND category_master.name = 'HPL'";
        $this->db->where($where, NULL, FALSE);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function set_kirim_press($database_input_array)
    {
        if($this->input->post('name') !== false && $this->input->post('sisi1') !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'bahan_dasar' => $database_input_array['bahan_dasar'],
                'sisi1' => $database_input_array['sisi1'],
                'sisi2' => $database_input_array['sisi2'],
                'jumlah' => $database_input_array['jumlah']
            );

            return $this->db->insert('kirim_press_temp', $data);
        }else{
            return false;
        }
    }

    public function get_stock_by_name($name)
    {
        $query = $this->db->query("select stock_master.*
                                   from stock_master, item_master
                                   where stock_master.item_id = item_master.id AND item_master.name ='$name'");

        return $query->result_array(); 
    }

    public function get_item_press_id($id)
    {
        $this->db->select('kirim_press_detail.*');
        $this->db->from('kirim_press_detail');
        $this->db->where('kirim_press_main_id', $id);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function set_kirimpress_project($database_input_array){
        if($this->input->post('project') !== false && $this->input->post('subproject') !== false){

            date_default_timezone_set('Asia/Jakarta');

            // start database transaction
            $this->db->trans_begin();

            $temp = $this->get_all_press();
            foreach ($temp as $temp) {
                $data = array(
                    'bahan_dasar' => $temp['bahan_dasar'],
                    'sisi1' => $temp['sisi1'],
                    'sisi2' => $temp['sisi2'],
                    'jumlah' => $temp['jumlah']
                );
                $this->db->insert('kirim_press_detail', $data);
                
                $bhn_dsr = $this->get_stock_by_name($temp['bahan_dasar']);
                foreach ($bhn_dsr as $bhn) {
                    $data = array(
                        'item_count' => $bhn['item_count'] - $temp['jumlah']
                    );
                    $this->db->where('id', $bhn['id']);
                    $this->db->update('stock_master', $data);
                }

                $ss1 = $this->get_stock_by_name($temp['sisi1']);
                foreach ($ss1 as $s1) {
                    $data = array(
                        'item_count' => $s1['item_count'] - $temp['jumlah']
                    );
                    $this->db->where('id', $s1['id']);
                    $this->db->update('stock_master', $data);
                }

                $ss2 = $this->get_stock_by_name($temp['sisi2']);
                foreach ($ss2 as $s2) {
                    $data = array(
                        'item_count' => $s2['item_count'] - $temp['jumlah']
                    );
                    $this->db->where('id', $s2['id']);
                    $this->db->update('stock_master', $data);
                }

            }

            $data = array(
                'kode_press' => $database_input_array['kode_press'],
                'subproject_id' => $database_input_array['subproject_id'],
                'creation_date' => date("Y-m-d H:i:s"),
                'user_id' => $database_input_array['user']
            );
            $this->db->insert('kirim_press_main', $data);

            $data = array(
                'kirim_press_main_id' => $this->db->insert_id()
            );
            $this->db->where('kirim_press_main_id', null);
            $this->db->update('kirim_press_detail', $data);

            $this->db->truncate('kirim_press_temp');
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

    public function get_all_press()
    {
        $this->db->select('kirim_press_temp.*');
        $this->db->from('kirim_press_temp');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_all_itempress()
    {
        $this->db->select('stock_press_master.*');
        $this->db->from('stock_press_master');
        $where = "stock_press_master.jumlah > '0'";
        $this->db->where($where, NULL, FALSE);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_all_stockpress($id)
    {
        $this->db->select('stock_press_master.*');
        $this->db->from('stock_press_master');
        $this->db->where('stock_press_master.id', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_all_itempress_by_id($id)
    {
        $this->db->select('kirim_press_detail.*');
        $this->db->from('kirim_press_detail');
        $this->db->where('kirim_press_main_id', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_all_kirimpress()
    {
        $this->db->select('kirim_press_main.*');
        $this->db->from('kirim_press_main');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function delete_press_temp($press_id){
        $response = $this->db->delete('kirim_press_temp', array('id' => $press_id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
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

    public function get_kirimpress_by_kirimpress_code($kirimpress_code){
        $query = $this->db->get_where('kirim_press_main', array('kode_press' => $kirimpress_code));
        return $query->row_array();
    }

    public function get_all_item_press($id)
    {
        $this->db->select('kirim_press_detail.*');
        $this->db->from('kirim_press_detail');
        $this->db->where('kirim_press_main_id', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_cat_press()
    {
        $this->db->select('category_master.*');
        $this->db->from('category_master');
        $this->db->where('name', 'press');
        $query = $this->db->get();

        return $query->row_array(); 
    }

    public function get_stock_by_stock_code($stock_press_code){
        $query = $this->db->get_where('stock_press_master', array('stock_press_code' => $stock_press_code));
        return $query->row_array();
    }

    public function set_receive_press($database_input_array, $id)
    {
        date_default_timezone_set('Asia/Jakarta');

        // start database transaction
        $this->db->trans_begin();

        // remaining counter
        $remaining_counter = 0;

        $received_item_values = $database_input_array['received_item_values'];
        foreach($received_item_values as $each_received_item_value){
            if($each_received_item_value['quantity_received'] > 0){
                // PART 1 - update PO detail
                $data = array(
                    'jumlah_diterima' => ($each_received_item_value['quantity_received'] + $each_received_item_value['quantity_already_received'])
                );
                $this->db->where('id', $each_received_item_value['press_id']);
                $this->db->update('kirim_press_detail', $data);

                /*// PART 2 - insert item to stock
                $additional_database_input_array = $this->prepare_stock_detail($each_po_received_item_value['po_detail_id'], $database_input_array['supplier_id']);
                if(empty($additional_database_input_array)){
                    $this->db->trans_rollback();
                    return FALSE;
                }*/

                $count_database_input_array = $this->prepare_stock_count($each_received_item_value['bahan_dasar'], $each_received_item_value['sisi1'], $each_received_item_value['sisi2']);
                $checkitem = $this->get_stocks_press_by_id($each_received_item_value['bahan_dasar'], $each_received_item_value['sisi1'], $each_received_item_value['sisi2']);

                    if(!empty($checkitem)){
                        $data = array(
                            'jumlah' => $count_database_input_array['jumlah'] + $each_received_item_value['quantity_received']
                        );
                        $this->db->where('stock_press_master.bahan_dasar', $each_received_item_value['bahan_dasar']);
                        $this->db->where('stock_press_master.sisi1', $each_received_item_value['sisi1']);
                        $this->db->where('stock_press_master.sisi2', $each_received_item_value['sisi2']);
                        $this->db->update('stock_press_master', $data);
                    }else{
                        $data = array(
                            'stock_press_code' => $database_input_array['stock_press_code']++,
                            'bahan_dasar' => $each_received_item_value['bahan_dasar'],
                            'sisi1' => $each_received_item_value['sisi1'],
                            'sisi2' => $each_received_item_value['sisi2'],
                            'jumlah' => $each_received_item_value['quantity_received'],
                            'category_id' => $database_input_array['cat']
                        );
                        $this->db->insert('stock_press_master', $data);
                    }

                }
            }
            // update remaining counter
            $remaining_counter += $each_received_item_value['quantity_ordered'] - $each_received_item_value['quantity_received'] - $each_received_item_value['quantity_already_received'];

        // PART 3 - update the PO main if necessary
        if($remaining_counter <= 0){
            $data = array(
                'receive_date' => date("Y-m-d H:i:s")
            );
            $this->db->where('id', $id);
            $this->db->update('kirim_press_main', $data);
        }

        // return false if something went wrong
        if ($this->db->trans_status() === FALSE){
            //$this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function get_stocks_press_by_id($bahan_dasar, $sisi1, $sisi2){
        $this->db->select('stock_press_master.*');
        $this->db->from('stock_press_master');
        $this->db->where('stock_press_master.bahan_dasar', $bahan_dasar);
        $this->db->where('stock_press_master.sisi1', $sisi1);
        $this->db->where('stock_press_master.sisi2', $sisi2);
        $query = $this->db->get();

        return $query->result_array();
    }

    private function prepare_stock_count($bahan_dasar, $sisi1, $sisi2){
        $count_database_input_array = array();

        // get the item id
        $this->db->select('stock_press_master.*');
        $this->db->from('stock_press_master');
        $this->db->where('stock_press_master.bahan_dasar', $bahan_dasar);
        $this->db->where('stock_press_master.sisi1', $sisi1);
        $this->db->where('stock_press_master.sisi2', $sisi2);

        $query = $this->db->get();
        $item_detail = $query->row_array();

        if(!empty($item_detail)){
            $count_database_input_array['jumlah'] = $item_detail['jumlah'];
            
            return $count_database_input_array;
        }else{
            return FALSE;
        }
    }

    public function update_barcode_status_quantity($database_input_array, $id){
        // start database transaction
        $this->db->trans_begin();

        $barcode_print_values = $database_input_array['barcode_print_values'];
        foreach($barcode_print_values as $barcode_print_value){
            if($barcode_print_value['label_quantity'] > 0){
                $data = array(
                    'label_quantity' => $barcode_print_value['label_quantity']
                );

                $this->db->where('id', $barcode_print_value['stock_press_id']);
                $this->db->update('stock_press_master', $data);
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
    }

    public function get_barcode_detail_by_id($id){
        $this->db->select('*');
        $this->db->from('stock_press_master');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

}