<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Displaytugas extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('division_model');
        $this->load->model('displaytugas_model');
        $this->load->model('login_model');
        $this->load->helper('cookie');
        $this->load->helper('url');
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->_is_logged_in();
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

    public function show_table($message)
    {
        $user_id    = $this->tank_auth->get_user_id();
        
        $user_info = $this->login_model->get_user_info($user_id);
        $data['userid'] = $user_info['id'];
        $data['username'] = $user_info['name'];
        $data['company_title'] = $user_info['title'];
        $data['division'] = $user_info['division_worker'];

        // message
        $data['message'] = $message;

        // get necessary data
        $data['grup'] = $this->displaytugas_model->get_all_grup();
        $data['subproject'] = $this->displaytugas_model->get_all_subproject();
        //$data['timeline'] = $this->displaytugas_model->get_all_timeline();
        
        // show the view
        $this->load->view('header');
        // $this->load->view('displaytugas/navigation', $data);
        $this->load->view('navigation', $data);
        $this->load->view('displaytugas/create', $data);
        $this->load->view('displaytugas/footer');
    }

    public function timeline()
    {
        $user_id    = $this->tank_auth->get_user_id();
        
        $user_info = $this->login_model->get_user_info($user_id);
        $data['userid'] = $user_info['id'];
        $data['username'] = $user_info['name'];
        $data['company_title'] = $user_info['title'];
        $data['division'] = $user_info['division_worker'];

        $data['grup'] = $this->displaytugas_model->get_all_grup();

        // show the view
        //$this->load->view('header');
        //$this->load->view('displaytugas/navigation', $data);
        $this->load->view('displaytugas/main', $data);
        //$this->load->view('displaytugas/footer');
    }

    public function display()
    {
        $json = array();
        $grup = $this->displaytugas_model->get_all_grup();
        foreach ($grup as $each_grup) {
            
            $value = $this->displaytugas_model->get_all_tugas_by_grup($each_grup['name']);
            $waktu = 0;
            $data['waktu'] = 0;
            $nama = $each_grup['name'];
            $dat = array();
            
            foreach ($value as $value) {
                $next = $this->displaytugas_model->get_all_tugas_by_next($value['nexttimeline']); 
                
                foreach ($next as $val) {
                
                if($val['status'] == 1){
                    $data['desc'] = "Pembuatan ". $val['subproject'];
                    $data['label'] = "Pembuatan ". $val['subproject'];
                    $data['customClass'] = 'ganttRed';
                }elseif ($val['status'] == 2) {
                    $data['desc'] = "Finishing ". $val['subproject'];
                    $data['label'] = "Finishing ". $val['subproject'];
                    $data['customClass'] = 'ganttOrange';
                }else{
                    $data['desc'] = "Penyetelan ". $val['subproject'];
                    $data['label'] = "Penyetelan ". $val['subproject'];
                    $data['customClass'] = 'ganttBlue';               
                }

                $data['id'] = $val['id'];
                $data['waktu'] += $val['lama'];
                $waktu += $val['lama'];
                $time = $waktu - $val['lama'];
                $lama = $val['lama'];
                $from = strtotime('2015-10-26') * 1000;
                $hari = $time * 24 * 60 * 60 * 1000;
                $to = ($lama - 1) * 24 * 60 * 60 * 1000;
                $data['from'] = "/Date(".($from + $hari).")/";
                $data['to'] = "/Date(".($from + $hari + $to).")/";
                $data['next'] = $val['nexttimeline'];
                
                array_push($dat, $data);
                }
            }

            $response['name'] = $nama;
            //$response['desc'] = '';
            $response['values'] = $dat;
            array_push($json, $response);
        }   
        echo json_encode($json);     
    }

    public function time()
    {
        $id = $this->input->post('grup_id');
        $timeline = $this->displaytugas_model->get_all_timeline($id);
        $data .= "<option value=''> --- Pilih --- </option>";
        $waktu = 0;
        foreach ($timeline as $timeline) {
            if($timeline['status'] == 1){
                $status = 'Pembuatan';
            }elseif ($timeline['status'] == 2) {
                $status = 'Finishing';
            }elseif($timeline['status'] == 3){
                $status = 'Penyetelan';
            }

            $waktu += $timeline['lama_pekerjaan'];
            $wak = $waktu * 24 * 60 * 60;
            $time = $waktu - $timeline['lama_pekerjaan'];
            $lama = $timeline['lama_pekerjaan'];
            $from = strtotime('2015-10-26');
            $today = strtotime(date('Y-m-d'));
            $hari = $time * 24 * 60 * 60;
            $to = ($lama - 1) * 24 * 60 * 60;
            $mulai = $from + $wak;

            if($mulai >= $today){            
                $data .= "<option value='$timeline[id]'>$status. $timeline[subproject]</option>";
            }
        }
        echo $data;
        
    }

    public function timeid()
    {
        $id = $this->input->post('timeline');
        $time = $this->displaytugas_model->get_timeline_id($id);
        foreach ($time as $time) {
            $data .= "<option value='$time[next_timeline_id]'>$time[next_timeline_id]</option>";
        }
        echo $data;
        
    }

    public function create_timeline()
    {
        if(!empty($this->input->post('grup_id')) && !empty($this->input->post('subproject')) && !empty($this->input->post('status'))){
            
            $database_input_array = array();
            $grup_detail = $this->displaytugas_model->get_grup_by_name($this->input->post('grup'));
            $subproject_detail = $this->displaytugas_model->get_subproject_by_name($this->input->post('subproject'));
            
            if(empty($grup_detail)){
                $message['error'] = "Timeline gagal disimpan. Nama grup tidak ada dalam system.";
                $this->show_table($message);
                return;
            }else{
                $database_input_array['grup_id'] = $grup_detail['id'];
            }

            $database_input_array['subproject_id'] = $this->input->post('subproject');
            $database_input_array['timeline'] = $this->input->post('timeline');
            
            $database_input_array['status'] = $this->input->post('status');

            $database_input_array['waktu'] = $this->input->post('waktu');

            $database_input_array['timeid'] = $this->input->post('timeid');

            $response = $this->displaytugas_model->set_timeline($database_input_array);

                if($response){
                    $message['success'] = "Timeline berhasil disimpan.";
                    $this->show_table($message);
                }else{
                    $message['error'] = "Timeline gagal disimpans.";
                    $this->show_table($message);
                }
        }else{
            $message['error'] = "Timeline gagal disimpan.";
            $this->show_table($message);
        }
    }

}

