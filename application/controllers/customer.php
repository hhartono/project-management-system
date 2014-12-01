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
        $data['customers'] = $this->customer_model->get_all_customers();

        // show the view
        $this->load->view('header');
        $this->load->view('customer/navigation', $data);
        $this->load->view('customer/main', $data);
        $this->load->view('footer');
    }
}

/* End of file customer.php */
/* Location: ./application/controllers/customer.php */