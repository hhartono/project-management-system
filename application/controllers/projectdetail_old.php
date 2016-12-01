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
            $data['projectdetail'] = $this->detail_model->get_all_detail();
            $data['sub'] = $this->detail_model->get_all_sub();

            // show the view
            $this->load->view('header');
            // $this->load->view('projectdetail/navigation', $data);
            $this->load->view('navigation', $data);
            $this->load->view('projectdetail/main', $data);
            $this->load->view('projectdetail/footer');
        }else{
            redirect('login', 'refresh');
        }
    }

    public function detail($id){
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
         $data['detail'] = $this->detail_model->get_all_projectdetail($id);
        $this->load->view('header');
        // $this->load->view('projectdetail/navigation', $data);
        $this->load->view('navigation', $data);
        $this->load->view('projectdetail/detail', $data);
        $this->load->view('projectdetail/footer');
        }else{
            redirect('login', 'refresh');
        }
    }
}