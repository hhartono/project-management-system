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
        $this->load->model('customer_model');
    }

	public function index()
	{
        $message = array();
        $this->show_table($message);
    }

    public function create_project(){
        // check all necessary input
        if(!empty($this->input->post('customer_name')) && !empty($this->input->post('name'))){
            // search for customer id
            $database_input_array = array();
            $customer_detail = $this->customer_model->get_customer_by_name($this->input->post('customer_name'));
            if(empty($customer_detail)){
                $message['error'] = "Project gagal disimpan. Nama customer tidak ada dalam system.";
                $this->show_table($message);
                return;
            }else{
                $database_input_array['customer_id'] = $customer_detail['id'];
            }

            // get the project name
            $database_input_array['name'] = $this->input->post('name');

            // get the project initial
            $database_input_array['project_initial'] = $this->input->post('project_initial');

            // get the project address
            $database_input_array['address'] = $this->input->post('address');

            // get the project notes
            $database_input_array['notes'] = $this->input->post('notes');

            // get the project start date
            date_default_timezone_set('Asia/Jakarta');
            $start_date = strtotime($this->input->post('start_date'));
            if($start_date === false){
                $message['error'] = "Project gagal disimpan. Tanggal mulai tidak valid.";
                $this->show_table($message);
                return;
            }else{
                $start_date = date("Y-m-d H:i:s", $start_date);
                if($start_date === false){
                    $message['error'] = "Project gagal disimpan. Tanggal mulai tidak valid.";
                    $this->show_table($message);
                    return;
                }else{
                    $database_input_array['start_date'] = $start_date;
                }
            }

            // check if there is any duplicate
            $duplicate_check = $this->project_model->get_project_by_name_customer($database_input_array['name'], $database_input_array['customer_id']);

            if(empty($duplicate_check)){
                $response = $this->project_model->set_project($database_input_array);

                if($response){
                    $message['success'] = "Project berhasil disimpan.";
                    $this->show_table($message);
                }else{
                    $message['error'] = "Project gagal disimpan.";
                    $this->show_table($message);
                }
            }else{
                $message['error'] = "Project gagal disimpan. Project sudah ada dalam system.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "Project gagal disimpan.";
            $this->show_table($message);
        }
    }

    public function update_project(){
        // check all necessary input
        if(!empty($this->input->post('id')) && !empty($this->input->post('customer_name'))
            && !empty($this->input->post('name'))){

            // search for customer id
            $database_input_array = array();
            $customer_detail = $this->customer_model->get_customer_by_name($this->input->post('customer_name'));
            if(empty($customer_detail)){
                $message['error'] = "Project gagal disimpan. Nama customer tidak ada dalam system.";
                $this->show_table($message);
                return;
            }else{
                $database_input_array['customer_id'] = $customer_detail['id'];
            }

            // get the project name
            $database_input_array['name'] = $this->input->post('name');

            // get the project initial
            $database_input_array['project_initial'] = $this->input->post('project_initial');

            // get the project address
            $database_input_array['address'] = $this->input->post('address');

            // get the project notes
            $database_input_array['notes'] = $this->input->post('notes');

            // get the project start date
            date_default_timezone_set('Asia/Jakarta');
            $start_date = strtotime($this->input->post('start_date'));
            if($start_date === false){
                $message['error'] = "Project gagal disimpan. Tanggal mulai tidak valid.";
                $this->show_table($message);
                return;
            }else{
                $start_date = date("Y-m-d H:i:s", $start_date);
                if($start_date === false){
                    $message['error'] = "Project gagal disimpan. Tanggal mulai tidak valid.";
                    $this->show_table($message);
                    return;
                }else{
                    $database_input_array['start_date'] = $start_date;
                }
            }

            // database id
            $database_input_array['id'] = $this->input->post('id');

            // store project information
            $response = $this->project_model->update_project($database_input_array);

            if($response){
                $message['success'] = "Project berhasil diubah.";
                $this->show_table($message);
            }else{
                $message['error'] = "Project gagal diubah.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "Project gagal diubah.";
            $this->show_table($message);
        }
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

    public function finish_project($project_id){
        $response = $this->project_model->finish_project($project_id);

        // display message according db status
        if($response){
            $message['success'] = "Project berhasil diupdate.";
            $this->show_table($message);
        }else{
            $message['error'] = "Project gagal diupdate.";
            $this->show_table($message);
        }
    }

    public function get_project_detail($project_id){
        date_default_timezone_set('Asia/Jakarta');

        $project_id = urldecode($project_id);
        $project_detail = $this->project_model->get_project_by_id($project_id);
        $project_detail['formatted_start_date'] = date("d-m-Y", strtotime($project_detail['start_date']));
        echo json_encode($project_detail);
    }

    public function get_all_project_customers(){
        $project_customers = $this->customer_model->get_all_customers();
        return $project_customers;
    }

    public function get_all_project_customer_names(){
        $project_customers = $this->get_all_project_customers();
        $customer_name = array();
        foreach($project_customers as $project_customer){
            $customer_name[] = $project_customer['name'];
        }

        echo json_encode($customer_name);
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