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
    //tser
    }

    public function index()
    {
        $message = array();
        $this->show_table($message);
    }

    private function show_table($message)
    {
        $user_id = $this->input->cookie('uid', TRUE);
        if($user_id){
            // user info
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
           

        }else{
            redirect('login', 'refresh');
        }
    }

    public function detail($idproject, $idsubproject){
        $user_id = $this->input->cookie('uid', TRUE);
        if($user_id){
            // user info
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
            $data['pro'] = $this->detail_model->getpro($idspj);
            $data['proj'] = $this->detail_model->getproj($idspj);
            $data['abse'] = $this->detail_model->getabs($idspj);
            $data['absensi'] = $this->detail_model->get_absensi($idspj);

            $this->load->view('header');
            $this->load->view('projectdetail/navigation', $data);
            $this->load->view('projectdetail/detail', $data);
            $this->load->view('projectdetail/footer');
        }else{
            redirect('login', 'refresh');
        }
    }

    public function cetak($idproject, $idsubproject)
    {
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
            //$idpj = $idproject;
            $idspj = $idsubproject;
            $data['detail'] = $this->detail_model->get_all_projectdetail($idspj);
            $data['pro'] = $this->detail_model->getpro($idspj);
        $this->load->view('projectdetail/print', $data);
        
    }

    public function cari() {
        $user_id = $this->input->cookie('uid', TRUE);
        if($user_id){
            // user info
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
               
        }else{
            redirect('login', 'refresh');
        }
    }

    public function caritanggal($idproject, $idsubproject){
        $user_id = $this->input->cookie('uid', TRUE);
        if($user_id){
            // user info
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
            $data['detail'] = $this->detail_model->get_all_workerdetail($idspj);
            $data['pro'] = $this->detail_model->getpro($idspj);
            $data['proj'] = $this->detail_model->getproj($idspj);
            $data['abse'] = $this->detail_model->getabs($idspj);
            $data['absensi'] = $this->detail_model->get_absensi($idspj);

            $this->load->view('header');
            $this->load->view('projectdetail/navigation', $data);
            $this->load->view('projectdetail/detailtukang', $data);
            $this->load->view('projectdetail/footer');
        }else{
            redirect('login', 'refresh');
        }
    }
}