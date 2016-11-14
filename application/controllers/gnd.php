<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Gnd extends CI_Controller{
    private $num;

    public function __construct(){
        parent::__construct();

        $this->load->model('gnd_model');
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
        switch ($doc) {
            case 'Invoice':
                $doc_num_rtvd = $this->gnd_model->get_num_inv();
                $num_substr = substr(implode('',$doc_num_rtvd), -4);
                //check whether is it a new year
                $num = $this->reset_by_year($num_substr);
                //AI
                $this->num = $num + 1;
                return $this->num;
                break;
            case 'Quotation':
                $doc_num_rtvd = $this->gnd_model->get_num_quo();
                $num_substr = substr(implode('',$doc_num_rtvd), -4);
                //check whether is it a new year
                $num = $this->reset_by_year($num_substr);
                //AI
                $this->num = $num + 1;
                return $this->num;
                break;
            case 'PO':
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

    public function create_doc($doc){
        // $doc = $this->input->post('doc');

        // $rec_client = $this->input->post('klien');
        // $client = !empty($rec_client) ? $rec_client : null;
        // $rec_project = $this->input->post('project');
        // $project = !empty($rec_project) ? $rec_project : null;
        // $rec_supplier = $this->input->post('supplier');
        // $supplier = !empty($rec_supplier) ? $rec_supplier : null;
        // $rec_inv_num = $this->input->post('inv_num'); //echo json_encode($rec_inv_num.'a');
        // $inv_numb = !empty($rec_inv_num) ? $rec_inv_num : null; //echo json_encode($inv_numb.'b');
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
            case "Invoice" :
                $doc_num = "INV/".$date."/".$year_roman."/".$month_roman."/".$sn;
                echo json_encode($doc_num);
                $response = $this->gnd_model->set_doc_num($doc, $doc_num);
            break;
            case "Quotation" :
                $doc_num = "QUO/".$date."/".$year_roman."/".$month_roman."/".$sn;
                echo json_encode($doc_num);
                $response = $this->gnd_model->set_doc_num($doc, $doc_num);
            break;
            case "PO" :
                $doc_num = "PO/".$date."/".$year_roman."/".$month_roman."/".$sn;
                echo json_encode($doc_num);
                $response = $this->gnd_model->set_doc_num($doc, $doc_num);
            break;
        }
    }

    public function check_inv_num(){
        $klien = $this->input->post('klien');
        $project = $this->input->post('project');
        $result = $this->gnd_model->check_inv_num($klien, $project);
        $inv_num = !empty($result['inv_num']) ? $result['inv_num'] : null;

        if(!empty($inv_num)){ 
            $inv_num += 1;
        } else{ 
            $inv_num = 1;
        }
        echo json_encode($inv_num);
    }

    public function show_report($doc){
        $month = $this->input->post('month');
        switch ($doc) {
            case 'Invoice':
                $report = $this->gnd_model->get_inv_rpt($month);
                echo json_encode($report);
                break;
            case 'Quotation':
                $report = $this->gnd_model->get_quo_rpt($month);
                $arr[][] = array('');
                $nr = count($report);
                for($a = 0; $a < $nr; $a++) {
                    array_push($report[$a], $arr);
                }
                echo json_encode($report);
                break;
            case 'PO':
                $report = $this->gnd_model->get_po_rpt($month);
                $arr[][] = array('');
                $nr = count($report);
                for($a = 0; $a < $nr; $a++) {
                    array_push($report[$a], $arr);
                }
                echo json_encode($report);
                break;
        }
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

        // show the view
        $this->load->view('header');
        $this->load->view('gnd/navigation', $data);
        $this->load->view('gnd/main', $data);
        $this->load->view('gnd/footer');
    }
}

/* End of file gnd.php */
/* Location: ./application/controllers/gnd.php */
