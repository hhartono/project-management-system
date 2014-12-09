<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Createpo extends CI_Controller {

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
        $this->load->model('item_model');
        $this->load->model('unit_model');
        $this->load->model('supplier_model');
        $this->load->model('customer_model');
        $this->load->model('createpo_model');
    }

	public function index()
	{
        $this->load->helper('url');
        $base_url = base_url();

        $data['base_url'] = $base_url;
        $data['username'] = "Hans Hartono";
        $data['company_title'] = "Chief Technology Officer";
        $this->load->view('header');
        $this->load->view('createpo/navigation', $data);
        $this->load->view('createpo/main');
        $this->load->view('footer');
    }

    public function submit_item_values(){
        // get the input value
        if(!empty($this->input->post('po_item_values')) && !empty($this->input->post('supplier'))
            && !empty($this->input->post('customer'))){
            $po_item_values = $this->input->post('po_item_values');
            $po_item_values = json_decode($po_item_values, TRUE);

            if($po_item_values){
                // item values successfully decoded
                $database_input_array = array();

                // customer name
                $customer_detail = $this->customer_model->get_customer_by_name($this->input->post('customer_name'));
                if(empty($customer_detail)){
                    // TODO - show error message - no customer
                    return;
                }else{
                    $database_input_array['customer_id'] = $customer_detail['id'];
                }

                // search for supplier id
                $supplier_detail = $this->supplier_model->get_supplier_by_name($this->input->post('supplier'));
                if(empty($supplier_detail)){
                    // TODO - show error message - no supplier
                    return;
                }else{
                    $database_input_array['supplier_id'] = $supplier_detail['id'];
                }

                // input all po item values
                $database_input_array['po_item_values'] = $po_item_values;

                // input data to database
                $response = $this->createpo_model->set_po_detail($database_input_array);

                if($response){
                    // TODO - show success message
                }else{
                    // TODO - show error message
                }
            }else{
                // TODO - show error message - po item error
            }
        }else{
            // TODO - show error message
        }
   }

    public function get_all_po_items(){
        $po_items = $this->item_model->get_all_items();
        return $po_items;
    }

    public function get_all_po_item_names(){
        $po_items = $this->get_all_po_items();
        $po_name = array();
        foreach($po_items as $po_item){
            $po_name[] = $po_item['name'];
        }

        echo json_encode($po_name);
    }

    public function get_unit_by_item_name($item_name){
        $item_name = urldecode($item_name);
        $item_detail = $this->item_model->get_item_by_name($item_name);

        if(!empty($item_detail['unit_id'])){
            $unit_detail = $this->unit_model->get_unit_by_id($item_detail['unit_id']);
            echo json_encode($unit_detail);
        }
    }

    public function get_item_detail_by_item_name($item_name){
        $item_name = urldecode($item_name);
        $item_detail = $this->item_model->get_item_by_name($item_name);
        echo json_encode($item_detail);
    }

    public function get_all_po_suppliers(){
        $po_suppliers = $this->supplier_model->get_all_suppliers();
        return $po_suppliers;
    }

    public function get_all_po_supplier_names(){
        $po_suppliers = $this->get_all_po_suppliers();
        $supplier_name = array();
        foreach($po_suppliers as $po_supplier){
            $supplier_name[] = $po_supplier['name'];
        }

        echo json_encode($supplier_name);
    }

    public function get_all_po_customers(){
        $po_customers = $this->customer_model->get_all_customers();
        return $po_customers;
    }

    public function get_all_po_customer_names(){
        $po_customers = $this->get_all_po_customers();
        $customer_name = array();
        foreach($po_customers as $po_customer){
            $customer_name[] = $po_customer['name'];
        }

        echo json_encode($customer_name);
    }
}

/* End of file createpo.php */
/* Location: ./application/controllers/createpo.php */