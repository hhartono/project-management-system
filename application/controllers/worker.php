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
        $this->load->model('login_model');
        $this->load->helper('cookie');
        $this->load->helper('url');
    }

	public function index()
	{
        $message = array();
        $this->show_table($message);
    }

    public function create_worker(){
        if($this->input->post('name') && $this->input->post('division_id')){
            // check if there is any duplicate
            $duplicate_check = $this->worker_model->get_worker_by_name_division($this->input->post('name'), $this->input->post('division_id'));

            if(empty($duplicate_check)){
                $database_input_array = array();

                // division id
                $database_input_array['division_id'] = $this->input->post('division_id');

                // generate worker id for each new worker
                $this->load->helper('worker_code_helper');
                $generated_worker_code = worker_code_generator($database_input_array['division_id']);
                if(empty($generated_worker_code)){
                    $message['error'] = "Tukang gagal disimpan. Kode tukang tidak dapat dibuat.";
                    $this->show_table($message);
                    return;
                }else{
                    $database_input_array['worker_code'] = $generated_worker_code;
                }

                // worker name
                $database_input_array['name'] = $this->input->post('name');

                // worker address
                $database_input_array['address'] = $this->input->post('address');

                // phone number 1
                $database_input_array['phone_number_1'] = $this->input->post('phone_number_1');

                // phone number 2
                $database_input_array['phone_number_2'] = $this->input->post('phone_number_2');

                // join date
                date_default_timezone_set('Asia/Jakarta');
                $join_date = strtotime($this->input->post('join_date'));
                if($join_date === false){
                    $message['error'] = "Tukang gagal disimpan. Tanggal masuk tidak valid.";
                    $this->show_table($message);
                    return;
                }else{
                    $join_date = date("Y-m-d H:i:s", $join_date);
                    if($join_date === false){
                        $message['error'] = "Tukang gagal disimpan. Tanggal masuk tidak valid.";
                        $this->show_table($message);
                        return;
                    }else{
                        $database_input_array['join_date'] = $join_date;
                    }
                }

                // salary
                $database_input_array['salary'] = $this->input->post('salary');

                // notes
                $database_input_array['notes'] = $this->input->post('notes');

                // store worker information
                $response = $this->worker_model->set_worker($database_input_array);

                if($response){
                    $message['success'] = "Tukang berhasil disimpan.";
                    $this->show_table($message);
                }else{
                    $message['error'] = "Tukang gagal disimpan.";
                    $this->show_table($message);
                }
            }else{
                $message['error'] = "Tukang gagal disimpan. Tukang sudah ada dalam system.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "Tukang gagal disimpan.";
            $this->show_table($message);
        }
    }

    public function update_worker(){
        $database_input_array = array();

        // division id
        $database_input_array['division_id'] = $this->input->post('division_id');

        // worker name
        $database_input_array['name'] = $this->input->post('name');

        // worker address
        $database_input_array['address'] = $this->input->post('address');

        // phone number 1
        $database_input_array['phone_number_1'] = $this->input->post('phone_number_1');

        // phone number 2
        $database_input_array['phone_number_2'] = $this->input->post('phone_number_2');

        // join date
        date_default_timezone_set('Asia/Jakarta');
        $join_date = strtotime($this->input->post('join_date'));
        if($join_date === false){
            $message['error'] = "Tukang gagal disimpan. Tanggal masuk tidak valid.";
            $this->show_table($message);
            return;
        }else{
            $join_date = date("Y-m-d H:i:s", $join_date);
            if($join_date === false){
                $message['error'] = "Tukang gagal disimpan. Tanggal masuk tidak valid.";
                $this->show_table($message);
                return;
            }else{
                $database_input_array['join_date'] = $join_date;
            }
        }

        // salary
        $database_input_array['salary'] = $this->input->post('salary');

        // notes
        $database_input_array['notes'] = $this->input->post('notes');

        // id
        $database_input_array['id'] = $this->input->post('id');

        // store worker information
        $response = $this->worker_model->update_worker($database_input_array);

        if($response){
            $message['success'] = "Tukang berhasil diubah.";
            $this->show_table($message);
        }else{
            $message['error'] = "Tukang gagal diubah.";
            $this->show_table($message);
        }
    }

    public function delete_worker($worker_id){
        $response = $this->worker_model->delete_worker($worker_id);

        // display message according db status
        if($response){
            $message['success'] = "Tukang berhasil dihapus.";
            $this->show_table($message);
        }else{
            $message['error'] = "Tukang gagal dihapus.";
            $this->show_table($message);
        }
    }

    public function get_worker_detail($worker_id){
        date_default_timezone_set('Asia/Jakarta');

        $worker_id = urldecode($worker_id);
        $worker_detail = $this->worker_model->get_worker_by_id($worker_id);
        $worker_detail['formatted_join_date'] = date("d-m-Y", strtotime($worker_detail['join_date']));
        echo json_encode($worker_detail);
    }

    public function get_all_worker_divisions(){
        $worker_divisions = $this->division_model->get_all_divisions();
        echo json_encode($worker_divisions);
    }

    private function show_table($message)
    {
        $user_id = $this->input->cookie('uid', TRUE);
        if($user_id){
            // user info
            $user_info = $this->login_model->get_user_info($user_id);
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            $data['worker'] = $user_info['worker'];

            // access level
            $create=substr($data['worker'],0,1); 
            $edit=substr($data['worker'],1,1); 
            $delete=substr($data['worker'],2,1); 
            
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
            $data['workers'] = $this->worker_model->get_all_workers();

            // show the view
            $this->load->view('header');
            $this->load->view('worker/navigation', $data);
            $this->load->view('worker/main', $data);
            $this->load->view('worker/footer');
        }else{
            redirect('/login', 'refresh');
        }
    }
}

/* End of file worker.php */
/* Location: ./application/controllers/worker.php */