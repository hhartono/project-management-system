<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subproject extends CI_Controller {

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
        $this->load->model('subproject_model');
        $this->load->model('project_model');
    }

	public function index()
	{
        $message = array();
        $this->show_table($message);
    }

    public function create_subproject(){
        // check all necessary input
        if(!empty($this->input->post('project_name')) && !empty($this->input->post('name'))){
            // search for project id
            $database_input_array = array();
            $project_detail = $this->project_model->get_project_by_name($this->input->post('project_name'));
            if(empty($project_detail)){
                $message['error'] = "Subproject gagal disimpan. Nama project tidak ada dalam system.";
                $this->show_table($message);
                return;
            }else{
                $database_input_array['project_id'] = $project_detail['id'];
            }

            // generate subproject id for each new worker
            $this->load->helper('subproject_code_helper');
            $generated_subproject_code = subproject_code_generator($database_input_array['project_id']);
            if(empty($generated_subproject_code)){
                $message['error'] = "Subproject gagal disimpan. Kode subproject tidak dapat dibuat.";
                $this->show_table($message);
                return;
            }else{
                $database_input_array['subproject_code'] = $generated_subproject_code;
            }

            // get the subproject name
            $database_input_array['name'] = $this->input->post('name');

            // get the project notes
            $database_input_array['notes'] = $this->input->post('notes');

            // check if there is any duplicate
            $duplicate_check = $this->subproject_model->get_subproject_by_subproject_project($database_input_array['name'], $database_input_array['project_id']);

            if(empty($duplicate_check)){
                $response = $this->subproject_model->set_subproject($database_input_array);

                if($response){
                    $message['success'] = "Subproject berhasil disimpan.";
                    $this->show_table($message);
                }else{
                    $message['error'] = "Subproject gagal disimpan.";
                    $this->show_table($message);
                }
            }else{
                $message['error'] = "Subproject gagal disimpan. Subproject sudah ada dalam system.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "Subproject gagal disimpan.";
            $this->show_table($message);
        }
    }

    public function update_subproject(){
        // check all necessary input
        if(!empty($this->input->post('id')) && !empty($this->input->post('project_name'))
            && !empty($this->input->post('name'))){

            // search for project id
            $database_input_array = array();
            $project_detail = $this->project_model->get_project_by_name($this->input->post('project_name'));
            if(empty($project_detail)){
                $message['error'] = "Subproject gagal diubah. Nama project tidak ada dalam system.";
                $this->show_table($message);
                return;
            }else{
                $database_input_array['project_id'] = $project_detail['id'];
            }

            // get the subproject name
            $database_input_array['name'] = $this->input->post('name');

            // get the project notes
            $database_input_array['notes'] = $this->input->post('notes');

            // database id
            $database_input_array['id'] = $this->input->post('id');

            // store project information
            $response = $this->subproject_model->update_subproject($database_input_array);

            if($response){
                $message['success'] = "Subproject berhasil diubah.";
                $this->show_table($message);
            }else{
                $message['error'] = "Subproject gagal diubah.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "Subproject gagal diubah.";
            $this->show_table($message);
        }
    }

    public function delete_subproject($subproject_id){
        $response = $this->subproject_model->delete_subproject($subproject_id);

        // display message according db status
        if($response){
            $message['success'] = "Subproject berhasil dihapus.";
            $this->show_table($message);
        }else{
            $message['error'] = "Subproject gagal dihapus.";
            $this->show_table($message);
        }
    }

    public function start_subproject($subproject_id){
        $response = $this->subproject_model->start_subproject($subproject_id);

        // display message according db status
        if($response){
            $message['success'] = "Subproject berhasil diupdate.";
            $this->show_table($message);
        }else{
            $message['error'] = "Subproject gagal diupdate.";
            $this->show_table($message);
        }
    }

    public function install_subproject($subproject_id){
        $response = $this->subproject_model->install_subproject($subproject_id);

        // display message according db status
        if($response){
            $message['success'] = "Project berhasil diupdate.";
            $this->show_table($message);
        }else{
            $message['error'] = "Project gagal diupdate.";
            $this->show_table($message);
        }
    }

    public function get_subproject_detail($subproject_id){
        date_default_timezone_set('Asia/Jakarta');

        $subproject_id = urldecode($subproject_id);
        $subproject_detail = $this->subproject_model->get_subproject_by_id($subproject_id);
        //$subproject_detail['formatted_start_date'] = date("d-m-Y", strtotime($subproject_detail['start_date']));
        //$subproject_detail['formatted_install_date'] = date("d-m-Y", strtotime($subproject_detail['install_date']));
        echo json_encode($subproject_detail);
    }

    public function get_all_subproject_projects(){
        $subproject_projects = $this->project_model->get_all_projects();
        return $subproject_projects;
    }

    public function get_all_subproject_project_names(){
        $subproject_projects = $this->get_all_subproject_projects();
        $project_name = array();
        foreach($subproject_projects as $subproject_project){
            $project_name[] = $subproject_project['name'];
        }

        echo json_encode($project_name);
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
        $data['subprojects'] = $this->subproject_model->get_all_subprojects();

        // show the view
        $this->load->view('header');
        $this->load->view('subproject/navigation', $data);
        $this->load->view('subproject/main', $data);
        $this->load->view('subproject/footer');
    }
}

/* End of file subproject.php */
/* Location: ./application/controllers/subproject.php */