<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends CI_Controller {

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
        $this->load->model('supplier_model');
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

    public function create_supplier(){
        if($this->input->post('name')){
            // check if there is any duplicate
            $duplicate_check = $this->supplier_model->get_supplier_by_name($this->input->post('name'));

            if(empty($duplicate_check)){
                $response = $this->supplier_model->set_supplier();

                if($response){
                    $message['success'] = "Supplier berhasil disimpan.";
                    $this->show_table($message);
                }else{
                    $message['error'] = "Supplier gagal disimpan.";
                    $this->show_table($message);
                }
            }else{
                $message['error'] = "Supplier gagal disimpan. Supplier sudah ada dalam system.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "Supplier gagal disimpan.";
            $this->show_table($message);
        }
    }

    public function update_supplier(){
        $response = $this->supplier_model->update_supplier();

        if($response){
            $message['success'] = "Supplier berhasil diubah.";
            $this->show_table($message);
        }else{
            $message['error'] = "Supplier gagal diubah.";
            $this->show_table($message);
        }
    }

    public function delete_supplier($supplier_id){
        $response = $this->supplier_model->delete_supplier($supplier_id);

        // display message according db status
        if($response){
            $message['success'] = "Supplier berhasil dihapus.";
            $this->show_table($message);
        }else{
            $message['error'] = "Supplier gagal dihapus.";
            $this->show_table($message);
        }
    }

    public function get_supplier_detail($supplier_id){
        $supplier_id = urldecode($supplier_id);
        $supplier_detail = $this->supplier_model->get_supplier_by_id($supplier_id);
        echo json_encode($supplier_detail);
    }

    private function show_table($message)
    {
        $user_id    = $this->tank_auth->get_user_id();
            $user_info = $this->login_model->get_user_info($user_id);
            $data['userid'] = $user_info['id'];
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            $data['supplier'] = $user_info['supplier'];

            // access level
            $create=substr($data['supplier'],0,1); 
            $edit=substr($data['supplier'],1,1); 
            $delete=substr($data['supplier'],2,1); 
            
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
            $data['suppliers'] = $this->supplier_model->get_all_suppliers();

            // show the view
            $this->load->view('header');
            // $this->load->view('supplier/navigation', $data);
            $this->load->view('navigation', $data);
            $this->load->view('supplier/main', $data);
            $this->load->view('supplier/footer');
    }
}

/* End of file supplier.php */
/* Location: ./application/controllers/supplier.php */