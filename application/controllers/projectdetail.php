<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projectdetail extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('detail_model');
        $this->load->model('login_model');
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
            //$data['projectdetail'] = $this->detail_model->get_all_detail();

            $data['getproject'] = $this->detail_model->get_project();
            $data['getcompany'] = $this->detail_model->get_company();

            $this->load->view('header');
            $this->load->view('projectdetail/navigation', $data);
            $this->load->view('projectdetail/main', $data);
            $this->load->view('projectdetail/footer');
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
            $data['detail'] = $this->detail_model->get_all_projectdetail($idspj);
            $data['detail2'] = $this->detail_model->get_all_projectdetail2($idspj);
            $data['sumprice'] = $this->detail_model->get_all_sumpriceproject($idspj);
            $data['pro'] = $this->detail_model->getpro($idspj);
            $data['proj'] = $this->detail_model->getproj($idspj);
            $data['abse'] = $this->detail_model->getabs($idspj);
            $data['absensi'] = $this->detail_model->get_absensi($idspj);
            $data['company'] = $this->detail_model->get_company_id();
            $data['compro'] = $this->detail_model->get_company_project();
            $data['cetak'] = $this->detail_model->get_all_printdetail($idspj);
            $data['press'] = $this->detail_model->get_all_press($idspj);
            $data['pelapis'] = $this->detail_model->get_all_pelapis($idspj);

            $this->load->view('header');
            $this->load->view('projectdetail/navigation', $data);
            $this->load->view('projectdetail/detail', $data);
            $this->load->view('projectdetail/footer');
    }

    public function cetak($idproject, $idsubproject)
    {
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
            //$idpj = $idproject;
            $idspj = $idsubproject;
            $data['detail'] = $this->detail_model->get_all_projectdetail($idspj);
            $data['pro'] = $this->detail_model->getpro($idspj);
            $data['company'] = $this->detail_model->get_company_id();
            $data['compro'] = $this->detail_model->get_company_project();
        $this->load->view('projectdetail/print', $data);
        
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

        $data['getproject']=$this->detail_model->caridata();
        $data['getcompany'] = $this->detail_model->get_company();
        
        $this->load->view('header');
        $this->load->view('projectdetail/navigation', $data);
        $this->load->view('projectdetail/main',$data); 
        $this->load->view('projectdetail/footer');
    }

    public function caritanggal(){
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

            $data['detail'] = $this->detail_model->get_all_workerdetail();
            $data['pro'] = $this->detail_model->getpro2();
            $data['proj'] = $this->detail_model->getproj2();
            $data['absensi'] = $this->detail_model->caritanggal();

            //$tanggal1 = $this->input->post('tanggal1');
            //$tanggal2 = $this->input->post('tanggal2');
            $this->form_validation->set_rules('tanggal1','Tanggal Awal', 'required');
            $this->form_validation->set_rules('tanggal2','Tanggal Akhir', 'required');
            if($this->form_validation->run() == false){
                $this->load->view('header');
                $this->load->view('projectdetail/navigation', $data);
                $this->load->view('projectdetail/detailtukang', $data);
                $this->load->view('projectdetail/footer');
            }else{

            $this->load->view('header');
            $this->load->view('projectdetail/navigation', $data);
            $this->load->view('projectdetail/detailtukang', $data);
            $this->load->view('projectdetail/footer');
        }
    }

    public function checkDateFormat($tanggal1)
    {
        if(preg_match("/[0-9]{4}\/[0-12]{2}\/[0-31]{2}/", $tanggal1)){
            if(checkdate(substr($tanggal1, 6, 4), substr($tanggal1, 0, 2), substr($tanggal1, 3, 2))){
                return true;
            }
            else{
                //$this->form_validation->set_message('$tanggal1', 'Masukkan tanggal lahir yang benar.');
                return false;
            }
        }else{
            //$this->form_validation->set_message('valid_date', 'Masukkan tanggal lahir yang benar.');
            return false;
        }
    }

    public function cetaktukang($idproject, $idsubproject)
    {
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
            //$idpj = $idproject;
            $idspj = $idsubproject;
            $data['detail'] = $this->detail_model->get_all_projectdetail($idspj);
            $data['pro'] = $this->detail_model->getpro($idspj);
            $data['absensi'] = $this->detail_model->get_absensi($idspj);
        $this->load->view('projectdetail/printtukang', $data);
        
    }

    public function cetaktukangtanggal()
    {
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
            
            $data['detail'] = $this->detail_model->get_all_workerdetail();
            $data['pro'] = $this->detail_model->getproj3();
            $data['absensi'] = $this->detail_model->caritanggal();
        $this->load->view('projectdetail/printtukangtanggal', $data);
    }

    public function get_project_detail_usage($subproject_id, $stock_id){
        date_default_timezone_set('Asia/Jakarta');

        $subproject_id = urldecode($subproject_id);
        $stock_id = urldecode($stock_id);
        $project_detail_usage = $this->detail_model->get_all_usageproject($subproject_id, $stock_id);
        echo json_encode($project_detail_usage);
    }

    public function get_project_detail_usage2($subproject_id, $stock_id){
        date_default_timezone_set('Asia/Jakarta');

        $subproject_id = urldecode($subproject_id);
        $stock_id = urldecode($stock_id);
        $project_detail_usage = $this->detail_model->get_all_usageproject2($subproject_id, $stock_id);
        echo json_encode($project_detail_usage);
    }

    public function get_project_detail_press_usage($subproject_id, $stock_id){
        date_default_timezone_set('Asia/Jakarta');

        $subproject_id = urldecode($subproject_id);
        $stock_id = urldecode($stock_id);
        $project_detail_usage = $this->detail_model->get_all_usagepress($subproject_id, $stock_id);
        echo json_encode($project_detail_usage);
    }
}