<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

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
        $this->load->model('customer_model');
        $this->load->model('login_model');
        $this->load->helper('cookie');
        $this->load->helper('url');
    }

	public function index()
	{
        $message = array();
        $this->show_table($message);
    }

    public function create_customer(){
        if($this->input->post('name')){
            // check if there is any duplicate
            $duplicate_check = $this->customer_model->get_customer_by_name_address($this->input->post('name'), $this->input->post('address'));

            if(empty($duplicate_check)){
                $response = $this->customer_model->set_customer();

                if($response){
                    $message['success'] = "Customer berhasil disimpan.";
                    $this->show_table($message);
                }else{
                    $message['error'] = "Customer gagal disimpan.";
                    $this->show_table($message);
                }
            }else{
                $message['error'] = "Customer gagal disimpan. Customer sudah ada dalam system.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "Customer gagal disimpan.";
            $this->show_table($message);
        }
    }

    public function update_customer(){
        $response = $this->customer_model->update_customer();

        if($response){
            $message['success'] = "Customer berhasil diubah.";
            $this->show_table($message);
        }else{
            $message['error'] = "Customer gagal diubah.";
            $this->show_table($message);
        }
    }

    public function delete_customer($customer_id){
        $response = $this->customer_model->delete_customer($customer_id);

        // display message according db status
        if($response){
            $message['success'] = "Customer berhasil dihapus.";
            $this->show_table($message);
        }else{
            $message['error'] = "Customer gagal dihapus.";
            $this->show_table($message);
        }
    }

    public function get_customer_detail($customer_id){
        $customer_id = urldecode($customer_id);
        $customer_detail = $this->customer_model->get_customer_by_id($customer_id);
        echo json_encode($customer_detail);
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
            $data['customer'] = $user_info['customer'];

            // access level
            $create=substr($data['customer'],0,1); 
            $edit=substr($data['customer'],1,1); 
            $delete=substr($data['customer'],2,1); 
            
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
            $data['customers'] = $this->customer_model->get_all_customers();

            // show the view
            $this->load->view('header');
            $this->load->view('customer/navigation', $data);
            $this->load->view('customer/main', $data);
            $this->load->view('customer/footer');
        }else{
            redirect('/login', 'refresh');
        }
    }
}

/* End of file customer.php */
/* Location: ./application/controllers/customer.php */