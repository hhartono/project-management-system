<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        $this->load->helper('url');
        $this->load->model('login_model');
        $this->load->helper('cookie');
        $base_url = base_url();

        $user_id = $this->input->cookie('uid', TRUE);
        if($user_id){
            $user_info = $this->login_model->get_user_info($user_id);
            $data['base_url'] = $base_url;
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            $this->load->view('header');
            $this->load->view('home/navigation', $data);
            $this->load->view('home/main');
            $this->load->view('home/footer');
        }else{
            redirect('/login', 'refresh');
        }
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */