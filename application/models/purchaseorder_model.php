<?php
class Purchaseorder_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_purchaseorder_by_id($id){
        $this->db->select('transaction_po_main.*, supplier_master.name AS supplier, project_master.name AS project, subproject_master.name AS subproject');
        $this->db->from('transaction_po_main');
        $this->db->join('supplier_master', 'transaction_po_main.supplier_id = supplier_master.id');
        $this->db->join('project_master', 'transaction_po_main.project_id = project_master.id');
        $this->db->join('subproject_master', 'subproject_master.project_id = project_master.id');
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
        /*$this->db->select('transaction_po_main.*, project_master.name AS project, supplier_master.name AS supplier, subproject_master.name AS subproject');
        $this->db->from('transaction_po_main');
        $this->db->join('project_master', 'transaction_po_main.project_id = project_master.id','left');
        $this->db->join('subproject_master', 'transaction_po_main.subproject_id = subproject_master.id','left');
        $this->db->join('supplier_master', 'transaction_po_main.supplier_id = supplier_master.id','left');
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

                if(strtotime($result_array[$walk]['po_input_date']) <= 0){
                    $result_array[$walk]['sort_po_input_date'] = "";
                }else{
                    $result_array[$walk]['sort_po_input_date'] = strtotime($result_array[$walk]['po_input_date']);
                }

                $result_array[$walk]['print_label'] = false;
            }

            // check the print label status
            $this->db->select('transaction_po_main.id AS po_id, barcode_master.print_status AS print_status');
            $this->db->from('transaction_po_main');
            $this->db->join('barcode_master', 'transaction_po_main.id = barcode_master.po_id');
            $this->db->where('print_status', 0);
            $this->db->or_where('print_status', 1);
            $this->db->group_by('transaction_po_main.id');
            $label_status_query = $this->db->get();

            $label_status_result_array = $label_status_query->result_array();

            // assigning the printed status
            foreach($label_status_result_array as $each_label_print_status){
                for($walk = 0; $walk < $array_length; $walk++){
                    if($result_array[$walk]['id'] == $each_label_print_status['po_id']){
                        $result_array[$walk]['print_label'] = true;
                        break;
                    }
                }
            }

            return $result_array;
        }*/
        
        $this->db->select('transaction_po_main.*, stock_master.item_price AS item_price, stock_master.id AS stockid, project_master.name AS project, supplier_master.name AS supplier, subproject_master.name AS subproject');
        $this->db->from('transaction_po_main');
        $this->db->join('project_master', 'transaction_po_main.project_id = project_master.id','left');
        $this->db->join('subproject_master', 'transaction_po_main.subproject_id = subproject_master.id','left');
        $this->db->join('supplier_master', 'transaction_po_main.supplier_id = supplier_master.id','left');
        $this->db->join('transaction_po_detail', 'transaction_po_main.id = transaction_po_detail.po_id','left');
        $this->db->join('stock_master', 'stock_master.po_detail_id = transaction_po_detail.id','left');
        $this->db->group_by('transaction_po_detail.po_id');

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

                if(strtotime($result_array[$walk]['po_input_date']) <= 0){
                    $result_array[$walk]['sort_po_input_date'] = "";
                }else{
                    $result_array[$walk]['sort_po_input_date'] = strtotime($result_array[$walk]['po_input_date']);
                }

                $result_array[$walk]['print_label'] = false;
            }

            // check the print label status
            $this->db->select('transaction_po_main.id AS po_id, barcode_master.print_status AS print_status');
            $this->db->from('transaction_po_main');
            $this->db->join('barcode_master', 'transaction_po_main.id = barcode_master.po_id');
            $this->db->where('print_status', 0);
            $this->db->or_where('print_status', 1);
            $this->db->group_by('transaction_po_main.id');
            $label_status_query = $this->db->get();

            $label_status_result_array = $label_status_query->result_array();

            // assigning the printed status
            foreach($label_status_result_array as $each_label_print_status){
                for($walk = 0; $walk < $array_length; $walk++){
                    if($result_array[$walk]['id'] == $each_label_print_status['po_id']){
                        $result_array[$walk]['print_label'] = true;
                        break;
                    }
                }
            }

            return $result_array;
        }
        
    }

    public function count_time_filter()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        $this->db->select('transaction_po_main.*, stock_master.item_price AS item_price, stock_master.id AS stockid, project_master.name AS project, supplier_master.name AS supplier, subproject_master.name AS subproject');
        $this->db->from('transaction_po_main');
        $this->db->join('project_master', 'transaction_po_main.project_id = project_master.id','left');
        $this->db->join('subproject_master', 'transaction_po_main.subproject_id = subproject_master.id','left');
        $this->db->join('supplier_master', 'transaction_po_main.supplier_id = supplier_master.id','left');
        $this->db->join('transaction_po_detail', 'transaction_po_main.id = transaction_po_detail.po_id','left');
        $this->db->join('stock_master', 'stock_master.po_detail_id = transaction_po_detail.id','left');
        $this->db->where('MONTH(po_input_date)', $bulan);
        $this->db->where('YEAR(po_input_date)', $tahun);
        $this->db->group_by('transaction_po_detail.po_id');

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

                if(strtotime($result_array[$walk]['po_input_date']) <= 0){
                    $result_array[$walk]['sort_po_input_date'] = "";
                }else{
                    $result_array[$walk]['sort_po_input_date'] = strtotime($result_array[$walk]['po_input_date']);
                }

                $result_array[$walk]['print_label'] = false;
            }

            // check the print label status
            $this->db->select('transaction_po_main.id AS po_id, barcode_master.print_status AS print_status');
            $this->db->from('transaction_po_main');
            $this->db->join('barcode_master', 'transaction_po_main.id = barcode_master.po_id');
            $this->db->where('print_status', 0);
            $this->db->or_where('print_status', 1);
            $this->db->group_by('transaction_po_main.id');
            $label_status_query = $this->db->get();

            $label_status_result_array = $label_status_query->result_array();

            // assigning the printed status
            foreach($label_status_result_array as $each_label_print_status){
                for($walk = 0; $walk < $array_length; $walk++){
                    if($result_array[$walk]['id'] == $each_label_print_status['po_id']){
                        $result_array[$walk]['print_label'] = true;
                        break;
                    }
                }
            }

            return $result_array;
        }
        $query = $this->db->query("select absensi.*, SUM(absensi.count_time) as jam, date_format(date, '%M %Y') AS bulantahun                       
                            FROM absensi
                            WHERE MONTH(date)='$bulan' AND YEAR(date) ='$tahun'
                            GROUP BY idabsensi");
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_all_purchaseorders_receive()
    {
        
        $this->db->select('transaction_po_main.*, stock_master.item_price AS item_price, stock_master.id AS stockid, project_master.name AS project, supplier_master.name AS supplier, subproject_master.name AS subproject');
        $this->db->from('transaction_po_main');
        $this->db->join('project_master', 'transaction_po_main.project_id = project_master.id','left');
        $this->db->join('subproject_master', 'transaction_po_main.subproject_id = subproject_master.id','left');
        $this->db->join('supplier_master', 'transaction_po_main.supplier_id = supplier_master.id','left');
        $this->db->join('transaction_po_detail', 'transaction_po_main.id = transaction_po_detail.po_id','left');
        $this->db->join('stock_master', 'stock_master.po_detail_id = transaction_po_detail.id','left');
        $this->db->where('transaction_po_main.po_close_date', null);
        $this->db->group_by('transaction_po_detail.po_id');

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

                if(strtotime($result_array[$walk]['po_input_date']) <= 0){
                    $result_array[$walk]['sort_po_input_date'] = "";
                }else{
                    $result_array[$walk]['sort_po_input_date'] = strtotime($result_array[$walk]['po_input_date']);
                }

                $result_array[$walk]['print_label'] = false;
            }

            // check the print label status
            $this->db->select('transaction_po_main.id AS po_id, barcode_master.print_status AS print_status');
            $this->db->from('transaction_po_main');
            $this->db->join('barcode_master', 'transaction_po_main.id = barcode_master.po_id');
            $this->db->where('print_status', 0);
            $this->db->or_where('print_status', 1);
            $this->db->group_by('transaction_po_main.id');
            $label_status_query = $this->db->get();

            $label_status_result_array = $label_status_query->result_array();

            // assigning the printed status
            foreach($label_status_result_array as $each_label_print_status){
                for($walk = 0; $walk < $array_length; $walk++){
                    if($result_array[$walk]['id'] == $each_label_print_status['po_id']){
                        $result_array[$walk]['print_label'] = true;
                        break;
                    }
                }
            }

            return $result_array;
        }
        
    }

    public function supplier_filter()
    {
        $supplier = $this->input->post('supplier');

        $this->db->select('transaction_po_main.*, stock_master.item_price AS item_price, stock_master.id AS stockid, project_master.name AS project, supplier_master.name AS supplier, subproject_master.name AS subproject');
        $this->db->from('transaction_po_main');
        $this->db->join('project_master', 'transaction_po_main.project_id = project_master.id','left');
        $this->db->join('subproject_master', 'transaction_po_main.subproject_id = subproject_master.id','left');
        $this->db->join('supplier_master', 'transaction_po_main.supplier_id = supplier_master.id','left');
        $this->db->join('transaction_po_detail', 'transaction_po_main.id = transaction_po_detail.po_id','left');
        $this->db->join('stock_master', 'stock_master.po_detail_id = transaction_po_detail.id','left');
        $this->db->where('transaction_po_main.po_close_date', null);
        $this->db->where('supplier_master.name', $supplier);
        $this->db->group_by('transaction_po_detail.po_id');

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

                if(strtotime($result_array[$walk]['po_input_date']) <= 0){
                    $result_array[$walk]['sort_po_input_date'] = "";
                }else{
                    $result_array[$walk]['sort_po_input_date'] = strtotime($result_array[$walk]['po_input_date']);
                }

                $result_array[$walk]['print_label'] = false;
            }

            // check the print label status
            $this->db->select('transaction_po_main.id AS po_id, barcode_master.print_status AS print_status');
            $this->db->from('transaction_po_main');
            $this->db->join('barcode_master', 'transaction_po_main.id = barcode_master.po_id');
            $this->db->where('print_status', 0);
            $this->db->or_where('print_status', 1);
            $this->db->group_by('transaction_po_main.id');
            $label_status_query = $this->db->get();

            $label_status_result_array = $label_status_query->result_array();

            // assigning the printed status
            foreach($label_status_result_array as $each_label_print_status){
                for($walk = 0; $walk < $array_length; $walk++){
                    if($result_array[$walk]['id'] == $each_label_print_status['po_id']){
                        $result_array[$walk]['print_label'] = true;
                        break;
                    }
                }
            }

            return $result_array;
        }
        
    }

    public function get_all_purchaseorders_label()
    {
        
        $this->db->select('transaction_po_main.*, stock_master.item_price AS item_price, stock_master.id AS stockid, project_master.name AS project, supplier_master.name AS supplier, subproject_master.name AS subproject');
        $this->db->from('transaction_po_main');
        $this->db->join('project_master', 'transaction_po_main.project_id = project_master.id','left');
        $this->db->join('subproject_master', 'transaction_po_main.subproject_id = subproject_master.id','left');
        $this->db->join('supplier_master', 'transaction_po_main.supplier_id = supplier_master.id','left');
        $this->db->join('transaction_po_detail', 'transaction_po_main.id = transaction_po_detail.po_id','left');
        $this->db->join('stock_master', 'stock_master.po_detail_id = transaction_po_detail.id','left');
        $this->db->join('barcode_master', 'transaction_po_main.id = barcode_master.po_id');
        $this->db->where('barcode_master.print_status', 0);
        $this->db->group_by('transaction_po_detail.po_id');

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

                if(strtotime($result_array[$walk]['po_input_date']) <= 0){
                    $result_array[$walk]['sort_po_input_date'] = "";
                }else{
                    $result_array[$walk]['sort_po_input_date'] = strtotime($result_array[$walk]['po_input_date']);
                }

                $result_array[$walk]['print_label'] = false;
            }

            // check the print label status
            $this->db->select('transaction_po_main.id AS po_id, barcode_master.print_status AS print_status');
            $this->db->from('transaction_po_main');
            $this->db->join('barcode_master', 'transaction_po_main.id = barcode_master.po_id');
            $this->db->where('print_status', 0);
            //$this->db->or_where('print_status', 1);
            $this->db->group_by('transaction_po_main.id');
            $label_status_query = $this->db->get();

            $label_status_result_array = $label_status_query->result_array();

            // assigning the printed status
            foreach($label_status_result_array as $each_label_print_status){
                for($walk = 0; $walk < $array_length; $walk++){
                    if($result_array[$walk]['id'] == $each_label_print_status['po_id']){
                        $result_array[$walk]['print_label'] = true;
                        break;
                    }
                }
            }

            return $result_array;
        }
        
    }

    public function get_barcode_detail_by_po_id($po_id){
        $this->db->select('*');
        $this->db->from('barcode_master');
        $where = "po_id='" . $po_id . "' AND (print_status='0' OR print_status='1')";
        $this->db->where($where, NULL, FALSE);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_purchaseorder_detail_by_po_id($po_id){
        $this->db->select('transaction_po_detail.*, item_master.name AS item_name, item_master.id as item_id, unit_master.name as unit_name');
        $this->db->from('transaction_po_detail');
        $this->db->join('item_master', 'transaction_po_detail.item_id = item_master.id');
        $this->db->join('unit_master', 'unit_master.id = item_master.stock_unit_id', 'left'); 
        $this->db->where('po_id', $po_id);
        $query = $this->db->get();

        $result_array = $query->result_array();
        return $result_array;
    }

     public function get_purchaseorder_detail_unit_by_po_id($po_id){
        $this->db->select('transaction_po_detail.*, item_master.name AS item_name, item_master.id as item_id, unit_master.name as unit_name');
        $this->db->from('transaction_po_detail');
        $this->db->join('item_master', 'transaction_po_detail.item_id = item_master.id');
        $this->db->join('unit_master', 'unit_master.id = item_master.unit_id', 'left'); 
        $this->db->where('po_id', $po_id);
        $query = $this->db->get();

        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_purchaseorder_detail_by_stock_id(){

        $po_id = $this->uri->segment(3);
        $query = $this->db->query("select transaction_po_detail.*, item_master.name AS item_name, stock_master.id as stockid, stock_master.item_price as item_price, SUM(stock_master.item_price * transaction_po_detail.quantity_received) as total
                                    from transaction_po_detail, item_master, stock_master
                                    where transaction_po_detail.item_id = item_master.id AND stock_master.item_id = item_master.id AND po_id = $po_id 
                                    Group By transaction_po_detail.id");
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_purchaseorder_detail($id){
        $this->db->select('transaction_po_detail.*, item_master.name AS item_name, unit_master.name AS unit_name');
        $this->db->from('transaction_po_detail');
        $this->db->join('item_master', 'transaction_po_detail.item_id = item_master.id');
        $this->db->join('unit_master', 'item_master.unit_id = unit_master.id');
        
        $this->db->where('po_id', $id);
        $query = $this->db->get();

        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_purchaseorder_details($id){
        $this->db->select('transaction_po_detail.*, item_master.name AS item_name, unit_master.name AS unit_name');
        $this->db->from('transaction_po_detail');
        $this->db->join('item_master', 'transaction_po_detail.item_id = item_master.id');
        $this->db->join('unit_master', 'item_master.unit_id = unit_master.id');
        
        $this->db->where('po_id', $id);
        $query = $this->db->get();

        $result_array = $query->row();
        return $result_array;
    }

    public function getpurchaseorder($id){
        $this->db->select('supplier_master.*, project_master.name AS project, subproject_master.name AS subproject, transaction_po_main.po_reference_number AS reference, transaction_po_main.po_input_date AS date, project_master.address as alamat');
        $this->db->from('transaction_po_main');
        $this->db->join('supplier_master', 'transaction_po_main.supplier_id = supplier_master.id');
        $this->db->join('project_master', 'transaction_po_main.project_id = project_master.id');
        $this->db->join('subproject_master', 'subproject_master.project_id = project_master.id');
        $this->db->where('transaction_po_main.id', $id);
            $query = $this->db->get();

        $row_array = $query->row_array();
        return $row_array;
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

    public function update_barcode_status_quantity($database_input_array, $po_id){
        // start database transaction
        $this->db->trans_begin();

        $barcode_print_values = $database_input_array['barcode_print_values'];
        foreach($barcode_print_values as $barcode_print_value){
            if($barcode_print_value['label_quantity'] > 0){
                $data = array(
                    'label_quantity' => $barcode_print_value['label_quantity'],
                    'print_status' => '1',
                );

                $this->db->where('po_detail_id', $barcode_print_value['po_detail_id']);
                $this->db->update('barcode_master', $data);
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

    public function receive_po_items($database_input_array, $po_id)
    {
        date_default_timezone_set('Asia/Jakarta');

        // start database transaction
        $this->db->trans_begin();

        // remaining counter
        $remaining_counter = 0;

        $po_received_item_values = $database_input_array['po_received_item_values'];
        foreach($po_received_item_values as $each_po_received_item_value){
            if($each_po_received_item_value['quantity_received'] > 0){
                // PART 1 - update PO detail
                $data = array(
                    'quantity_received' => ($each_po_received_item_value['quantity_received'] + $each_po_received_item_value['quantity_already_received']),
                    'convert' => $each_po_received_item_value['quantity_convert'],
                    'total_convert' => ($each_po_received_item_value['quantity_received'] + $each_po_received_item_value['quantity_already_received']) * $each_po_received_item_value['quantity_convert']
                );
                $this->db->where('id', $each_po_received_item_value['po_detail_id']);
                $this->db->update('transaction_po_detail', $data);

                // PART 2 - insert item to stock
                $additional_database_input_array = $this->prepare_stock_detail($each_po_received_item_value['po_detail_id'], $database_input_array['supplier_id']);
                if(empty($additional_database_input_array)){
                    $this->db->trans_rollback();
                    return FALSE;
                }

                $count_database_input_array = $this->prepare_stock_count($each_po_received_item_value['item_id']);
                $checkitem = $this->get_stocks_by_id($each_po_received_item_value['item_id']);

                if($each_po_received_item_value['quantity_convert'] > 0){
                    $totalconvert = $each_po_received_item_value['quantity_received'] * $each_po_received_item_value['quantity_convert'];               

                    if(!empty($checkitem)){
                        $data = array(
                            // 'item_id' => $additional_database_input_array['item_id'],
                            // 'supplier_id' => $database_input_array['supplier_id'],
                            // 'project_id' => $database_input_array['project_id'],
                            //'po_detail_id' => $each_po_received_item_value['po_detail_id'],
                            'item_count' => $count_database_input_array['item_count'] + $totalconvert
                            // 'stock_awal' => $each_po_received_item_value['quantity_received'],
                            // 'item_stock_code' => $additional_database_input_array['item_stock_code'],
                            // //'item_price' => $each_po_received_item_value['item_price'],
                            // 'received_date' => date("Y-m-d H:i:s")
                        );
                        $this->db->where('item_id', $each_po_received_item_value['item_id']);
                        $this->db->update('stock_master', $data);
                    }else{
                        $data = array(
                            'item_id' => $additional_database_input_array['item_id'],
                            'supplier_id' => $database_input_array['supplier_id'],
                            'project_id' => $database_input_array['project_id'],
                            'po_detail_id' => $each_po_received_item_value['po_detail_id'],
                            'item_count' => $totalconvert,
                            'stock_awal' => $totalconvert,
                            'item_stock_code' => $additional_database_input_array['item_stock_code'],
                            //'item_price' => $each_po_received_item_value['item_price'],
                            'received_date' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('stock_master', $data);
                    }
                }else{
                    if (!empty($checkitem)) {
                        $data = array(
                            // 'item_id' => $additional_database_input_array['item_id'],
                            // 'supplier_id' => $database_input_array['supplier_id'],
                            // 'project_id' => $database_input_array['project_id'],
                            //'po_detail_id' => $each_po_received_item_value['po_detail_id'],
                            'item_count' => $count_database_input_array['item_count'] + $each_po_received_item_value['quantity_received']
                            // 'stock_awal' => $each_po_received_item_value['quantity_received'],
                            // 'item_stock_code' => $additional_database_input_array['item_stock_code'],
                            // //'item_price' => $each_po_received_item_value['item_price'],
                            // 'received_date' => date("Y-m-d H:i:s")
                        );
                        $this->db->where('item_id', $each_po_received_item_value['item_id']);
                        $this->db->update('stock_master', $data);
                    }else{
                        $data = array(
                            'item_id' => $additional_database_input_array['item_id'],
                            'supplier_id' => $database_input_array['supplier_id'],
                            'project_id' => $database_input_array['project_id'],
                            'po_detail_id' => $each_po_received_item_value['po_detail_id'],
                            'item_count' => $each_po_received_item_value['quantity_received'],
                            'stock_awal' => $each_po_received_item_value['quantity_received'],
                            'item_stock_code' => $additional_database_input_array['item_stock_code'],
                            //'item_price' => $each_po_received_item_value['item_price'],
                            'received_date' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('stock_master', $data);
                    }

                }
                //input history item count
                $data = array(
                    'stock_id' => $count_database_input_array['stock_id'],
                    'item_count' => $count_database_input_array['item_count'],
                    'jumlah_perubahan' => $count_database_input_array['item_count'] + $each_po_received_item_value['quantity_received'],
                    'status' => '1',
                    'date' => date("Y-m-d H:i:s")
                );
                $this->db->insert('item_count_history', $data);
                
                // PART 4 - generate barcode data
                $data = array(
                    'po_id' => $po_id,
                    'po_detail_id' => $each_po_received_item_value['po_detail_id'],
                    'label_name' => $each_po_received_item_value['item_name'],
                    'label_quantity' => $each_po_received_item_value['quantity_received'] * $each_po_received_item_value['quantity_convert'],
                    'label_code' => $additional_database_input_array['item_stock_code'],
                    'item_quantity' => $each_po_received_item_value['quantity_received'] * $each_po_received_item_value['quantity_convert'],
                    'print_status' => '0',
                    'creation_date' => date("Y-m-d H:i:s")
                );
                $this->db->insert('barcode_master', $data);
            }
            // update remaining counter
            $remaining_counter += $each_po_received_item_value['quantity_ordered'] - $each_po_received_item_value['quantity_received'] - $each_po_received_item_value['quantity_already_received'];
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


    public function set_po_detail($database_input_array)
    {
        if($database_input_array['supplier_id'] !== false && $database_input_array['project_id'] !== false 
            && $database_input_array['subproject_id'] !== false
            && $database_input_array['po_item_values'] !== false
            && $database_input_array['user'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            // start database transaction
            $this->db->trans_start();

            // PART 1 - set PO main
            $data = array(
                'po_reference_number' => $database_input_array['po_reference_number'],
                'supplier_id' => $database_input_array['supplier_id'],
                'project_id' => $database_input_array['project_id'],
                'subproject_id' => $database_input_array['subproject_id'],
                'user_id_po_input' => $database_input_array['user'],
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

    private function prepare_stock_count($item_id){
        $count_database_input_array = array();

        // get the item id
        $this->db->select('stock_master.*, item_master.name');
        $this->db->from('stock_master');
        $this->db->join('item_master', 'stock_master.item_id = item_master.id');
        $this->db->where('stock_master.item_id', $item_id);

        $query = $this->db->get();
        $item_detail = $query->row_array();

        if(!empty($item_detail)){
            $count_database_input_array['item_count'] = $item_detail['item_count'];
            $count_database_input_array['stock_id'] = $item_detail['id'];

            return $count_database_input_array;
        }else{
            return FALSE;
        }
    }

    public function get_all_project()
    {
        $query = $this->db->get('project_master');
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

    public function update_itemprice($database_input_array)
    {
        if($database_input_array['id'] !== false && $database_input_array['item_price'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $this->db->trans_start();

            $id = $database_input_array['id'];
            $item_price = $database_input_array['item_price'];
            $price_before = $database_input_array['price_before'];
            $po_id = $this->uri->segment(3);
            $query = $this->db->query("select transaction_po_detail.*, item_master.name AS item_name, stock_master.id as stockid, stock_master.item_price as item_price
                                    from transaction_po_detail, item_master, stock_master
                                    where transaction_po_detail.item_id = item_master.id AND po_id = $po_id 
                                    Group By transaction_po_detail.id");

            $count = $query->num_rows();            
            for($i = 0; $i < $count; $i++){   
                $query = $this->db->query("UPDATE stock_master set item_price = $item_price[$i] where
                                            id = $id[$i]");
            
                $data = array(
                    'stock_id' => $id[$i],
                    'price_sebelum' => $price_before[$i],
                    'price_update' => $item_price[$i],
                    'date' => date("Y-m-d H:i:s")
                );
                $this->db->insert('item_price_history', $data);
            }

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

    public function get_po_by_id(){
        $id = $this->uri->segment(3);
        $this->db->select('transaction_po_main.*, supplier_master.name AS supplier, project_master.name AS project, subproject_master.name AS subproject');
        $this->db->from('transaction_po_main');
        $this->db->join('supplier_master', 'transaction_po_main.supplier_id = supplier_master.id');
        $this->db->join('project_master', 'transaction_po_main.project_id = project_master.id');
        $this->db->join('subproject_master', 'subproject_master.project_id = project_master.id');
        $this->db->where('transaction_po_main.id', $id);
        $query = $this->db->get();

        $row_array = $query->row();
        return $row_array;
    }

    public function get_total(){
        $po_id = $this->uri->segment(3);
        $query = $this->db->query("select transaction_po_detail.*, item_master.name AS item_name, stock_master.id as stockid, stock_master.item_price as item_price, SUM(stock_master.item_price * transaction_po_detail.quantity_received) as total
                                    from transaction_po_detail, item_master, stock_master
                                    where transaction_po_detail.item_id = item_master.id AND item_master.id = stock_master.item_id AND po_id = $po_id 
                                    ");
        $result_array = $query->row();
        return $result_array;
    }

    public function pembayaran()
    {
        $id = $this->uri->segment(3);
        $query = $this->db->query("
                SELECT sum(jumlah) as jumlah, company_master.name as name
                FROM pembayaran, company_master
                WHERE company_master.id = pembayaran.company_id AND po_id = '$id'
            ");
        $result_array = $query->row();
        return $result_array;
    }

    public function set_pembayaran($database_input_array)
    {
        if($database_input_array['jumlah'] !== false && $database_input_array['company_id'] !== false){
            date_default_timezone_set('Asia/Jakarta');

            $this->db->trans_start();
            $data = array(
                'po_id' => $this->input->post('po_id'),
                'company_id' => $database_input_array['company_id'],
                'jumlah' => $database_input_array['jumlah'],
                'date' => $database_input_array['start_date']
            );

            $this->db->insert('pembayaran', $data);

            if($this->input->post('harga') + $database_input_array['jumlah'] == $this->input->post('total')){
                $data = array(
                    'status_pembayaran' => '1'
                );
                $this->db->where('id', $this->input->post('po_id'));
                $this->db->update('transaction_po_main', $data);
            }

            $stockid = $this->input->post('stockid');
            foreach($stockid as $stock)
            {
                $data = array(
                    'company_id' => $database_input_array['company_id']
                );
                $this->db->where('id', $stock);
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

    public function getpembayaran()
    {
        $id = $this->uri->segment(3);
        $query = $this->db->query("
                SELECT pembayaran.*, company_master.name as name
                FROM pembayaran, company_master
                WHERE pembayaran.company_id = company_master.id AND po_id = '$id'
            ");
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_po_by_stock(){

        $po_id = $this->uri->segment(3);
        $query = $this->db->query("select transaction_po_detail.*, item_master.name AS item_name, stock_master.id as stockid, stock_master.item_price as item_price, SUM(stock_master.item_price * transaction_po_detail.quantity_received) as total
                                    from transaction_po_detail, item_master, stock_master
                                    where transaction_po_detail.item_id = item_master.id AND stock_master.item_id = item_master.id AND po_id = $po_id 
                                    Group By transaction_po_detail.id");
        if($query->num_rows() > 0){
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function get_stocks_by_id($id){
        $this->db->select('stock_master.*, item_master.name, unit_master.name AS unit, supplier_master.name AS supplier, project_master.name AS project');
        $this->db->from('stock_master');
        $this->db->join('item_master', 'stock_master.item_id = item_master.id');
        $this->db->join('unit_master', 'item_master.unit_id = unit_master.id');
        $this->db->join('supplier_master', 'stock_master.supplier_id = supplier_master.id');
        $this->db->join('project_master', 'stock_master.project_id = project_master.id');
        $this->db->where('stock_master.item_id', $id);
        $query = $this->db->get();

        return $query->result_array();
    }
}