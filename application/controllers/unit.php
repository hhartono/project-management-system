<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit extends CI_Controller {

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
        $this->load->model('unit_model');
        $this->load->model('login_model');
        $this->load->helper('cookie');
        $this->load->helper('url');
    }

	public function index()
	{
        $message = array();
        $this->show_table($message);
    }

    public function create_unit(){
        if($this->input->post('abbreviation')){
            // check if there is any duplicate
            $duplicate_check = $this->unit_model->get_unit_by_abbreviation($this->input->post('abbreviation'));

            if(empty($duplicate_check)){
                $response = $this->unit_model->set_unit();

                if($response){
                    $message['success'] = "Satuan berhasil disimpan.";
                    $this->show_table($message);
                }else{
                    $message['error'] = "Satuan gagal disimpan.";
                    $this->show_table($message);
                }
            }else{
                $message['error'] = "Satuan gagal disimpan. Satuan sudah ada dalam system.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "Satuan gagal disimpan.";
            $this->show_table($message);
        }
    }

    public function update_unit(){
        $response = $this->unit_model->update_unit();

        if($response){
            $message['success'] = "Satuan berhasil diubah.";
            $this->show_table($message);
        }else{
            $message['error'] = "Satuan gagal diubah.";
            $this->show_table($message);
        }
    }

    public function delete_unit($unit_id){
        $response = $this->unit_model->delete_unit($unit_id);

        // display message according db status
        if($response){
            $message['success'] = "Satuan berhasil dihapus.";
            $this->show_table($message);
        }else{
            $message['error'] = "Satuan gagal dihapus.";
            $this->show_table($message);
        }
    }

    public function get_unit_detail($unit_id){
        $unit_id = urldecode($unit_id);
        $unit_detail = $this->unit_model->get_unit_by_id($unit_id);
        echo json_encode($unit_detail);
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
            $data['units'] = $this->unit_model->get_all_units();

            // show the view
            $this->load->view('header');
            $this->load->view('unit/navigation', $data);
            $this->load->view('unit/main', $data);
            $this->load->view('unit/footer');
        }else{
            redirect('/login', 'refresh');
        }
    }
}

/* End of file unit.php */
/* Location: ./application/controllers/unit.php */