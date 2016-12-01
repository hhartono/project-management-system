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

    public function create_project(){
        // check all necessary input
        if(!empty($this->input->post('customer_name')) && !empty($this->input->post('name')) && !empty($this->input->post('company_name'))){
            // search for customer id
            $database_input_array = array();
            $customer_detail = $this->customer_model->get_customer_by_name($this->input->post('customer_name'));
            $company_detail = $this->project_model->get_company_by_name($this->input->post('company_name'));
            if(empty($customer_detail)){
                $message['error'] = "Project gagal disimpan. Nama customer tidak ada dalam system.";
                $this->show_table($message);
                return;
            }else{
                $database_input_array['customer_id'] = $customer_detail['id'];
            }

            if(empty($company_detail)){
                $message['error'] = "Project gagal disimpan. Nama company tidak ada dalam system.";
                $this->show_table($message);
                return;
            }else{
                $database_input_array['company_id'] = $company_detail['id'];
            }

            // get the project name
            $database_input_array['name'] = $this->input->post('name');

            // get the project initial
            $database_input_array['project_initial'] = $this->input->post('project_initial');

            // get the project address
            $database_input_array['address'] = $this->input->post('address');

            $database_input_array['user'] = $this->input->post('user');

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
            $company_detail = $this->project_model->get_company_by_name($this->input->post('company_name'));
            if(empty($customer_detail)){
                $message['error'] = "Project gagal diubah. Nama customer tidak ada dalam system.";
                $this->show_table($message);
                return;
            }else{
                $database_input_array['customer_id'] = $customer_detail['id'];
            }
            if(empty($company_detail)){
                $message['error'] = "Project gagal diubah. Nama company tidak ada dalam system.";
                $this->show_table($message);
                return;
            }else{
                $database_input_array['company_id'] = $company_detail['id'];
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
                $message['error'] = "Project gagal diubah. Tanggal mulai tidak valid.";
                $this->show_table($message);
                return;
            }else{
                $start_date = date("Y-m-d H:i:s", $start_date);
                if($start_date === false){
                    $message['error'] = "Project gagal diubah. Tanggal mulai tidak valid.";
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
            $message['error'] = "Project gagal diubah.!";
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
        echo json_encode($project_detail);
    }

    public function get_all_project_customers(){
        $project_customers = $this->customer_model->get_all_customers();
        return $project_customers;
    }

    public function get_all_project_company(){
        $project_customers = $this->project_model->get_all_company();
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

    public function get_all_project_company_names(){
        $project_company = $this->get_all_project_company();
        $company_name = array();
        foreach($project_company as $project_company){
            $company_name[] = $project_company['name'];
        }

        echo json_encode($company_name);
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
            $data['projects'] = $this->project_model->get_all_projects();

            // show the view
            $this->load->view('header');
            // $this->load->view('project/navigation', $data);
            $this->load->view('navigation', $data);
            $this->load->view('project/main', $data);
            $this->load->view('project/footer');
    }
}

/* End of file project.php */
/* Location: ./application/controllers/project.php */