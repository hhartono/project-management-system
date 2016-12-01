<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Planning extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('planning_model');
        $this->load->model('login_model');
        $this->load->model('item_model');
        $this->load->model('unit_model');
        $this->load->helper('cookie');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('fpdf');
        $this->load->library('form_validation');
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->_is_logged_in();
    //tser
    }

    public function index()
    {
        $message = array();
        $this->show_table($message);
    }

    public function _is_logged_in(){
        if(!$this->tank_auth->is_logged_in()){
            redirect('/auth/login');
        }
    }

    private function show_table($message)
    {
        $user_id    = $this->tank_auth->get_user_id();
        
            $user_info = $this->login_model->get_user_info($user_id);
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];

            // access level
            $data['access']['create'] = true;
            $data['access']['edit'] = true;
            $data['access']['delete'] = true;

            // message
            $data['message'] = $message;

            // get necessary data
            //$data['planning'] = $this->detail_model->get_all_detail();

            $data['getproject'] = $this->planning_model->get_project();
            $data['getcompany'] = $this->planning_model->get_company();

            $this->load->view('header');
            // $this->load->view('planning/navigation', $data);
            $this->load->view('navigation', $data);
            $this->load->view('planning/main', $data);
            $this->load->view('planning/footer');
    }

    public function detail($idproject, $idsubproject){
        $user_id    = $this->tank_auth->get_user_id();
        
            $user_info = $this->login_model->get_user_info($user_id);
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];

            // access level
            $data['access']['create'] = true;
            $data['access']['edit'] = true;
            $data['access']['delete'] = true;

            // message
            //$data['message'] = $message;

            // get necessary data
            $idpj = $idproject;
            $idspj = $idsubproject;
            $data['detail'] = $this->planning_model->get_all_planning($idspj);
            $data['stock'] = $this->planning_model->get_all_stock_planning($idspj);
            $data['subitem'] = $this->planning_model->get_all_subitem($idspj);
            $data['proj'] = $this->planning_model->getproj($idspj);
        
            $this->load->view('header');
            // $this->load->view('planning/navigation', $data);
            $this->load->view('navigation', $data);
            $this->load->view('planning/detail', $data);
            $this->load->view('planning/footer');
    }

    public function cariitem(){
        $user_id    = $this->tank_auth->get_user_id();
        
            $user_info = $this->login_model->get_user_info($user_id);
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];

            // access level
            $data['access']['create'] = true;
            $data['access']['edit'] = true;
            $data['access']['delete'] = true;

            // message
            //$data['message'] = $message;

            // get necessary data
            //$idpj = $idproject;
            //$idspj = $idsubproject;
            $data['detail'] = $this->planning_model->cariitem();
            $data['subitem'] = $this->planning_model->get_all_carisubitem();
            $data['finishing'] = $this->planning_model->get_all_finishing();
            $data['finishing_belakang'] = $this->planning_model->get_all_finishing();
            $data['proj'] = $this->planning_model->getprojitem();
            $data['sub'] = $this->planning_model->getsubitem();
        
            $this->load->view('header');
            // $this->load->view('planning/navigation', $data);
            $this->load->view('navigation', $data);
            $this->load->view('planning/detailitem', $data);
            $this->load->view('planning/footer');
    }

    public function cariitems($message){
            $user_id    = $this->tank_auth->get_user_id();
        
            $user_info = $this->login_model->get_user_info($user_id);
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];

            // access level
            $data['access']['create'] = true;
            $data['access']['edit'] = true;
            $data['access']['delete'] = true;

            // message
            $data['message'] = $message;

            // get necessary data
            //$idpj = $idproject;
            //$idspj = $idsubproject;
            $data['detail'] = $this->planning_model->cariitems();
            $data['subitem'] = $this->planning_model->get_all_carisubitem();
            $data['stock'] = $this->planning_model->get_all_stock();
            $data['proj'] = $this->planning_model->getprojitem();
            $data['sub'] = $this->planning_model->getsubitem();
        
            $this->load->view('header');
            // $this->load->view('planning/navigation', $data);
            $this->load->view('navigation', $data);
            $this->load->view('planning/detail', $data);
            $this->load->view('planning/footer');
    }

    public function submititem(){
        if(!empty($this->input->post('name'))){
            // check if there is any duplicate
            //$duplicate_check = $this->planning_model->get_subprojectitem_by_name($this->input->post('subproject_item'));
            
                $response = $this->planning_model->set_subprojectitem();

                if($response){
                    $message['success'] = "Subproject Item berhasil disimpan.";
                    $this->cariitems($message);
                }else{
                    $message['error'] = "Subproject Item gagal disimpan.";
                    $this->cariitems($message);
                }
            
        }else{
            $message['error'] = "Subproject Item tidak boleh kosong.";
            $this->cariitems($message);
        }
    }

    public function submit_planning(){
        // check all necessary input
        if(!empty($this->input->post('name')) && !empty($this->input->post('item_count'))){
            // search for customer id
            $database_input_array = array();
            $item_detail = $this->planning_model->get_item_by_name($this->input->post('name'));
            
            if(empty($item_detail)){
                $message['error'] = "Planning gagal disimpan. Item tidak ada dalam system.";
                $this->cariitem();
                return;
            }else{
                $database_input_array['item_id'] = $item_detail['id'];
            }
            $database_input_array['finishing_id'] = $this->input->post('finishing');
            $database_input_array['finishing_belakang_id'] = $this->input->post('finishing_belakang');        
            $database_input_array['quantity'] = $this->input->post('item_count');
            $database_input_array['subproject_item_id'] = $this->input->post('subitem');

            // check if there is any duplicate
            
                $response = $this->planning_model->submit_planning($database_input_array);

                if($response){
                    $message['success'] = "Planning berhasil disimpan.";
                    $this->cariitem();
                }else{
                    $message['error'] = "Planning gagal disimpan.";
                    $this->cariitem();
                }
            
        }else{
            $message['error'] = "Planning gagal disimpan.";
            $this->cariitem();
        }
    }

    public function get_unit_by_item_name($item_name){
        $item_name = base64_decode(urldecode($item_name));
        $item_detail = $this->item_model->get_item_by_name($item_name);

        if(!empty($item_detail['unit_id'])){
            $unit_detail = $this->unit_model->get_unit_by_id($item_detail['unit_id']);
            echo json_encode($unit_detail);
        }
    }

    public function cari() {
        $user_id    = $this->tank_auth->get_user_id();
            $user_info = $this->login_model->get_user_info($user_id);
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];

            // access level
            $data['access']['create'] = true;
            $data['access']['edit'] = true;
            $data['access']['delete'] = true;

            // message
            //$data['message'] = $message;

        $data['getproject'] = $this->planning_model->caridata();
        $data['getcompany'] = $this->planning_model->get_company();
        
        $this->load->view('header');
        // $this->load->view('planning/navigation', $data);
        $this->load->view('navigation', $data);
        $this->load->view('planning/main',$data); 
        $this->load->view('planning/footer');
    }
}