<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

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
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->model('login_model');
    }

	public function index()
    {
        // check cookie to find out already login or not
        $user_id = $this->input->cookie('uid', TRUE);

        if($user_id){
            // has login -> show the home screen
            redirect('/home', 'refresh');
        }else{
            // has not login -> show the login screen
            $this->load->view('login/main');
        }
    }

    public function authenticate()
    {
        // check the input
        $user_name = $this->input->post('username');
        $password = $this->input->post('password');
        $remember = $this->input->post('remember');

        if($user_name && $password){
            // valid input, authenticate user
            $user = $this->login_model->authenticate_user($user_name, $password);

            if($user && $user['id']){
                // set cookie if authenticated
                $cookie = array(
                    'name'   => 'uid',
                    'value'  => $user['id'],
                    'expire' => '86500'
                );
                $this->input->set_cookie($cookie);

                // authentication successful, show the home screen
                redirect('/home', 'refresh');
            }else{
                // cannot authenticate user, display login screen
                $this->load->view('login/main');
            }
        }else{
            // not valid input, display login screen
            $this->load->view('login/main');
        }
    }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */