<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Division extends CI_Controller {

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
        $this->load->model('division_model');
        $this->load->model('login_model');
        $this->load->helper('cookie');
        $this->load->helper('url');
    }

	public function index()
	{
        $message = array();
        $this->show_table($message);
    }

    public function create_division()
    {
        if($this->input->post('division_code')){
            // check if there is any duplicate
            $duplicate_check = $this->division_model->get_division_by_code($this->input->post('division_code'));

            if(empty($duplicate_check)){
                $response = $this->division_model->set_division();

                if($response){
                    $message['success'] = "Divisi berhasil disimpan.";
                    $this->show_table($message);
                }else{
                    $message['error'] = "Divisi gagal disimpan.";
                    $this->show_table($message);
                }
            }else{
                $message['error'] = "Divisi gagal disimpan. Divisi sudah ada dalam system.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "Divisi gagal disimpan.";
            $this->show_table($message);
        }
    }

    public function update_division(){
        $response = $this->division_model->update_division();

        if($response){
            $message['success'] = "Divisi berhasil diubah.";
            $this->show_table($message);
        }else{
            $message['error'] = "Divisi gagal diubah.";
            $this->show_table($message);
        }
    }

    public function delete_division($division_id){
        $response = $this->division_model->delete_division($division_id);

        // display message according db status
        if($response){
            $message['success'] = "Divisi berhasil dihapus.";
            $this->show_table($message);
        }else{
            $message['error'] = "Divisi gagal dihapus.";
            $this->show_table($message);
        }
    }

    public function get_division_detail($division_id){
        $division_id = urldecode($division_id);
        $division_detail = $this->division_model->get_division_by_id($division_id);
        echo json_encode($division_detail);
    }

    private function show_table($message)
    {
        $user_id = $this->input->cookie('uid', TRUE);
        if($user_id){
            // user info
            $user_info = $this->login_model->get_user_info($user_id);
            $data['userid'] = $user_info['id'];
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            $data['division'] = $user_info['division_worker'];

            // access level
            $create=substr($data['division'],0,1); 
            $edit=substr($data['division'],1,1); 
            $delete=substr($data['division'],2,1); 
            
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

            // get necessary data
            $data['divisions'] = $this->division_model->get_all_divisions();

            // show the view
            $this->load->view('header');
            $this->load->view('division/navigation', $data);
            $this->load->view('division/main', $data);
            $this->load->view('division/footer');
        }else{
            redirect('/login', 'refresh');
        }
    }
}

/* End of file division.php */
/* Location: ./application/controllers/division.php */