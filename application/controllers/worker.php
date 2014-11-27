<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Worker extends CI_Controller {

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
        $this->load->model('worker_model');
        $this->load->model('division_model');
    }

	public function index()
	{
        $message = array();
        $this->show_table($message);
    }

    public function create_worker(){
        /*
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
        */
    }

    public function update_worker(){
        /*
        $response = $this->unit_model->update_unit();

        if($response){
            $message['success'] = "Satuan berhasil diubah.";
            $this->show_table($message);
        }else{
            $message['error'] = "Satuan gagal diubah.";
            $this->show_table($message);
        }
        */
    }

    public function delete_worker($worker_id){
        /*
        $response = $this->unit_model->delete_unit($unit_id);

        // display message according db status
        if($response){
            $message['success'] = "Satuan berhasil dihapus.";
            $this->show_table($message);
        }else{
            $message['error'] = "Satuan gagal dihapus.";
            $this->show_table($message);
        }
        */
    }

    public function get_worker_detail($worker_id){
        $worker_id = urldecode($worker_id);
        $worker_detail = $this->worker_model->get_worker_by_id($worker_id);
        echo json_encode($worker_detail);
    }

    public function get_all_worker_divisions(){
        $worker_divisions = $this->division_model->get_all_divisions();
        echo json_encode($worker_divisions);
    }

    private function show_table($message)
    {
        // user info
        $data['username'] = "Hans Hartono";
        $data['company_title'] = "Chief Technology Officer";

        // access level
        $data['access']['create'] = true;
        $data['access']['edit'] = true;
        $data['access']['delete'] = true;

        // message
        $data['message'] = $message;

        // get necessary data
        $data['workers'] = $this->worker_model->get_all_workers();

        // show the view
        $this->load->view('header');
        $this->load->view('worker/navigation', $data);
        $this->load->view('worker/main', $data);
        $this->load->view('footer');
    }
}

/* End of file worker.php */
/* Location: ./application/controllers/worker.php */