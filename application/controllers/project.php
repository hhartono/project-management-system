<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {

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
        $this->load->model('project_model');
    }

	public function index()
	{
        $message = array();
        $this->show_table($message);
    }

    public function create_project(){
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

    public function update_project(){
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

    public function delete_project($project_id){
        $response = $this->project_model->delete_project($project_id);

        // display message according db status
        if($response){
            $message['success'] = "Project berhasil dihapus.";
            $this->show_table($message);
        }else{
            $message['error'] = "Project gagal dihapus.";
            $this->show_table($message);
        }
    }

    public function get_project_detail($project_id){
        $project_id = urldecode($project_id);
        $project_detail = $this->project_model->get_project_by_id($project_id);
        echo json_encode($project_detail);
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
        $data['projects'] = $this->project_model->get_all_projects();

        // show the view
        $this->load->view('header');
        $this->load->view('project/navigation', $data);
        $this->load->view('project/main', $data);
        $this->load->view('footer');
    }
}

/* End of file project.php */
/* Location: ./application/controllers/project.php */