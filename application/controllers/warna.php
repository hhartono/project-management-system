<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warna extends CI_Controller {

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
        $this->load->model('warna_model');
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

    public function create_warna(){
        // check all necessary input
        if(!empty($this->input->post('kode_warna')) && !empty($this->input->post('nama_warna')) && !empty($this->input->post('kode_pantone')) && !empty($this->input->post('hexadecimal'))){
            // search for customer id
            $database_input_array = array();

            $database_input_array['kode_warna'] = $this->input->post('kode_warna');

            $database_input_array['nama_warna'] = $this->input->post('nama_warna');

            $database_input_array['kode_pantone'] = $this->input->post('kode_pantone');

            $database_input_array['hexadecimal'] = $this->input->post('hexadecimal');

            // get the warna start date
            date_default_timezone_set('Asia/Jakarta');

            // check if there is any duplicate
            $duplicate_check = $this->warna_model->get_warna_by_name_kode($database_input_array['nama_warna'], $database_input_array['kode_warna']);

            if(empty($duplicate_check)){
                $response = $this->warna_model->set_warna($database_input_array);

                if($response){
                    $message['success'] = "warna berhasil disimpan.";
                    $this->show_table($message);
                }else{
                    $message['error'] = "warna gagal disimpan.";
                    $this->show_table($message);
                }
            }else{
                $message['error'] = "warna gagal disimpan. warna sudah ada dalam system.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "warna gagal disimpan.";
            $this->show_table($message);
        }
    }

    public function update_warna(){
        // check all necessary input
        if(!empty($this->input->post('id')) && !empty($this->input->post('kode_warna')) && !empty($this->input->post('nama_warna')) && !empty($this->input->post('kode_pantone')) && !empty($this->input->post('hexadecimal'))){

            $database_input_array = array();
            
            $database_input_array['kode_warna'] = $this->input->post('kode_warna');

            $database_input_array['nama_warna'] = $this->input->post('nama_warna');

            $database_input_array['kode_pantone'] = $this->input->post('kode_pantone');

            $database_input_array['hexadecimal'] = $this->input->post('hexdecimal');

            // get the warna start date
            date_default_timezone_set('Asia/Jakarta');
            
            // database id
            $database_input_array['id'] = $this->input->post('id');

            // store warna information
            $response = $this->warna_model->update_warna($database_input_array);

            if($response){
                $message['success'] = "warna berhasil diubah.";
                $this->show_table($message);
            }else{
                $message['error'] = "warna gagal diubah.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "warna gagal diubah.!";
            $this->show_table($message);
        }
    }

    public function delete_warna($warna_id){
        $response = $this->warna_model->delete_warna($warna_id);

        // display message according db status
        if($response){
            $message['success'] = "warna berhasil dihapus.";
            $this->show_table($message);
        }else{
            $message['error'] = "warna gagal dihapus.";
            $this->show_table($message);
        }
    }

    private function show_table($message)
    {
        $user_id = $this->tank_auth->get_user_id();
        
            $user_info = $this->login_model->get_user_info($user_id);
            $data['userid'] = $user_info['id'];
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            $data['project'] = $user_info['project'];

            // access level
            $create=substr($data['project'],0,1); 
            $edit=substr($data['project'],1,1); 
            $delete=substr($data['project'],2,1); 
            
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
            $data['warnas'] = $this->warna_model->get_all_warnas();

            // show the view
            $this->load->view('header');
            $this->load->view('warna/navigation', $data);
            $this->load->view('warna/main', $data);
            $this->load->view('warna/footer');
    }
}

/* End of file warna.php */
/* Location: ./application/controllers/warna.php */