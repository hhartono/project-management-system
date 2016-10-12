<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Gnd extends CI_Controller{

    private $num, $doc_num, $doc;

    public function __construct(){
        parent::__construct();

        $this->load->model('gnd_model');
        // $this->load->model('customer_model');
        $this->load->model('login_model');
        $this->load->helper(array('form', 'cookie', 'url', 'date'));
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->_is_logged_in();
    }

    public function _is_logged_in(){
        if(!$this->tank_auth->is_logged_in()){
            redirect('/auth/login');
        }
    }

    public function index(){
        $message = array();
        $this->show_table($message);
    }

    private function convert_to_roman($num){ 
        $n = intval($num); 
        $res = ''; 

        //array of roman numbers
        $roman_number_array = array(  
            'C'  => 100, 
            'XC' => 90, 
            'L'  => 50, 
            'XL' => 40, 
            'X'  => 10, 
            'IX' => 9, 
            'V'  => 5, 
            'IV' => 4, 
            'I'  => 1); 

        foreach ($roman_number_array as $roman => $number){ 
            //divide to get  matches
            $matches = intval($n / $number); 

            //assign the roman char * $matches
            $res .= str_repeat($roman, $matches); 

            //substract from the number
            $n = $n % $number; 
        } 

        // return the result
        return $res; 
    } 

    private function reset_by_year($num_substr){
        if(date("dmHis") == "0101000001"){
            $this->num = 1;
            return $this->num;
        } else{
            $this->num = intval($num_substr);
            return $this->num;
        }
    }

    private function get_num($doc){
        $this->doc = $doc;
        switch ($doc) {
            case 'inv':
                $doc_num_rtvd = $this->gnd_model->get_num_inv();
                $num_substr = substr(implode('',$doc_num_rtvd), -4);
                //check whether is it a new year
                $num = $this->reset_by_year($num_substr);
                //AI
                $this->num = $num + 1;
                return $this->num;
                break;
            case 'quo':
                $doc_num_rtvd = $this->gnd_model->get_num_quo();
                $num_substr = substr(implode('',$doc_num_rtvd), -4);
                //check whether is it a new year
                $num = $this->reset_by_year($num_substr);
                //AI
                $this->num = $num + 1;
                return $this->num;
                break;
            case 'po':
                $doc_num_rtvd = $this->gnd_model->get_num_po();
                $num_substr = substr(implode('',$doc_num_rtvd), -4);
                //check whether is it a new year
                $num = $this->reset_by_year($num_substr);
                //AI
                $this->num = $num + 1;
                return $this->num;
                break;
        }
    }

    public function create_doc(){
        $doc = $this->input->post('doc');

        $rec_client = $this->input->post('klien');
        $client = !empty($rec_client) ? $rec_client : null;
        $rec_project = $this->input->post('project');
        $project = !empty($rec_project) ? $rec_project : null;
        $rec_supplier = $this->input->post('supplier');
        $supplier = !empty($rec_supplier) ? $rec_supplier : null;
        $rec_inv_num = $this->input->post('inv_num');
        $inv_num = !empty($rec_inv_num) ? $rec_inv_num : null;
        $date = date("Ymd");
        $date_trim = trim(date("Y"),"20");
        $year_roman = $this->convert_to_roman($date_trim);
        $month_roman = $this->convert_to_roman(date("m"));

        // Take num from DB, match with reset_by_year
        intval($this->get_num($doc));
        if($this->num < 10 && $this->num > 0){
            $sn = "000".$this->num;
        } else if($this->num > 9 && $this->num < 100){
            $sn = "00".$this->num;
        } else if($this->num > 99 && $this->num < 1000){
            $sn = "0".$this->num;
        } else if($this->num > 999){
            $sn = $this->num;
        } else if($this->num == 0){
            $sn = "0001";
        }

        //create document number
        switch($doc){
            case "inv" :
                $doc_num = "INV/".$date."/".$year_roman."/".$month_roman."/".$sn;
                // $this->doc_num = $doc_num;
                // $data['doc_num'] = $doc_num;
                echo json_encode($doc_num);
                // echo json_encode($data['doc_num']);
                // echo json_encode($data);
                // $this->send_doc_num();
                // $response = $this->gnd_model->set_doc_num($doc, $doc_num);            
                // if($response){
                //     $message['success'] = "Dokumen berhasil disimpan.";
                //     // $this->show_table($message);
                // } else{
                //     $message['error'] = "Dokumen gagal disimpan.";
                //     // $this->show_table($message);
                // }
            break;
            case "quo" :
                $doc_num = "QUO/".$date."/".$year_roman."/".$month_roman."/".$sn;
                // $this->doc_num = $doc_num;
                // $this->send_doc_num();
                echo json_encode($doc_num);
                // $response = $this->gnd_model->set_doc_num($doc, $doc_num);            
                // if($response){
                //     $message['success'] = "Dokumen berhasil disimpan.";
                //     // $this->show_table($message);
                // } else{
                //     $message['error'] = "Dokumen gagal disimpan.";
                //     // $this->show_table($message);
                // }
            break;
            case "po" :
                $doc_num = "PO/".$date."/".$year_roman."/".$month_roman."/".$sn;
                echo json_encode($doc_num);
                // $response = $this->gnd_model->set_doc_num($doc, $doc_num);            
                // if($response){
                //     $message['success'] = "Dokumen berhasil disimpan.";
                //     // $this->show_table($message);
                // } else{
                //     $message['error'] = "Dokumen gagal disimpan.";
                //     // $this->show_table($message);
                // }
            break;
        }
    }

    public function test(){
        $a = $this->input->post('str');
        // $a = $str;
        echo json_encode($a);
    }

    public function send_doc_num(){
        $dn = $this->doc_num;
        echo json_encode($dn);
        // print_r($dn);
        // echo "<script>console.log('".json_encode($dn)."');</script>";
        // echo ("<script>console.log('a');</script>");
    }

    // public function show_report(){
    //     $doc = $this->input->post('doc_types');
    //     switch ($doc) {
    //         case 'Invoice':
    //             $data['report'] = $this->gnd_model->get_all_inv();
    //             $message['success'] = "Menampilkan Invoice";  
    //             $this->show_table($message);
    //             break;
    //         case 'Quotation':
    //             $data['report'] = $this->gnd_model->get_all_quo();
    //             $message['success'] = "Menampilkan Quotation";
    //             $this->show_table($message);
    //             break;
    //         case 'PO':
    //             $data['report'] = $this->gnd_model->get_all_po();
    //             $message['success'] = "Menampilkan PO";
    //             $this->show_table($message);
    //             break;
    //     }
    //     // return $data['report'];
    // }

    public function show_report(){
        $this->doc = $this->input->post('doc_t');
        // $data['report'] = $this->gnd_model->get_all_inv();
        // echo json_encode($data['report']);
        $message = array();
        $this->show_table($message);
    }

    // public function create_item(){
    //     if($this->input->post('group')){
    //         // check if there is any duplicate
    //         $duplicate_check = $this->blg_model->get_item_by_group_name($this->input->post('group'));

    //         if(empty($duplicate_check)){
    //             $response = $this->blg_model->set_item();
            
    //             if($response){
    //                 $message['success'] = "Item set berhasil disimpan.";
    //                 $this->show_table($message);
    //             } else{
    //                 $message['error'] = "Item set gagal diisimpan.";
    //                 $this->show_table($message);
    //             }
    //         } else{
    //             $message['error'] = "Item set gagal disimpan. Item set sudah ada di dalam system";
    //             $this->show_table($message);
    //         }
    //     } else{
    //         $message['error'] = "Item set gagal dsimpan.";
    //         $this->show_table($message);
    //     }
    // }

    // public function update_item(){
    //     $response = $this->blg_model->update_item();

    //     if($response){
    //         $message['success'] = "Item berhasil diubah.";
    //         $this->show_table($message);
    //     } else{
    //         $message['error'] = "Item gagal diubah.";
    //         $this->show_table($message);
    //     }
    // }

    // public function delete_item($id){
    //     $response = $this->blg_model->delete_item($id);

    //     // display message according to db status
    //     if($response){
    //         $message['success'] = "Item berhasil dihapus";
    //         $this->show_table($message);
    //     } else{
    //         $message['error'] = "Item gagal dihapus";
    //         $this->show_table($message);
    //     }
    // }

    public function get_item_detail($id){
        $id = urldecode($id);
        $item_detail = $this->gnd_model->get_item_by_id($id);
        echo json_encode($item_detail);
    }

    

    private function show_table($message){
        $user_id = $this->tank_auth->get_user_id();
        
        $user_info = $this->login_model->get_user_info($user_id);
        $data['userid'] = $user_info['id'];
        $data['username'] = $user_info['name'];
        $data['company_title'] = $user_info['title'];
        $data['customer'] = $user_info['customer'];
        
        // access level
        $create=substr($data['customer'],0,1);
        $edit  =substr($data['customer'],1,1);
        $delete=substr($data['customer'],2,1);
            
        if($create != 0){
            $data['access']['create'] = true;            
        }else{
            $data['access']['create'] = false;
        }
            
        if($edit != 0){
            $data['access']['edit'] = true;            
        }else{
            $data['access']['edit'] = false;
        }

        if($delete != 0){
            $data['access']['delete'] = true;    
        }else{
            $data['access']['delete'] = false;               
        }

        // message
        $data['message'] = $message;

        //op
        switch ($this->doc) {
            case 'Invoice':
                $data['report'] = $this->gnd_model->get_all_inv();
                $data['type'] = 'inv';
                $message['success'] = "Menampilkan Invoice";
                break;
            case 'Quotation':
                $data['report'] = $this->gnd_model->get_all_quo();
                $data['type'] = 'quo';
                $message['success'] = "Menampilkan Quotation";
                break;
            case 'PO':
                $data['report'] = $this->gnd_model->get_all_po();
                $data['type'] = 'po';
                $message['success'] = "Menampilkan PO";
                break;
        }

        //show table by ddl
        // $this->show_report();

        // show the view
        $this->load->view('header');
        $this->load->view('gnd/navigation', $data);
        $this->load->view('gnd/main', $data);
        $this->load->view('gnd/footer');
    }
}

/* End of file intivo.php */
/* Location: ./application/controllers/intivo.php */
