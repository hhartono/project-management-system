<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Useitem extends CI_Controller {

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
        $this->load->model('useitem_model');
        $this->load->model('stock_model');
        $this->load->model('login_model');
        $this->load->helper('cookie');
        $this->load->helper('url');
    }

	public function index()
	{
        $message = array();
        $this->show_table($message);
    }

    public function submit_item_values(){
        var_dump($this->input->post());
    }

        /*
        public function submit_item_values(){
            // get the input value
            if(!empty($this->input->post('po_item_values')) && !empty($this->input->post('supplier'))
                && !empty($this->input->post('project'))){
                $po_item_values = $this->input->post('po_item_values');
                $po_item_values = json_decode($po_item_values, TRUE);

                if($po_item_values){
                    // item values successfully decoded
                    $database_input_array = array();

                    // generate purchase order code
                    $this->load->helper('purchaseorder_code_helper');
                    $generated_purchaseorder_code = purchaseorder_code_generator();
                    if(empty($generated_purchaseorder_code)){
                        $message['error'] = "Purchase Order gagal dibuat. Kode purchase order tidak dapat dibuat.";
                        $this->show_table($message);
                        return;
                    }else{
                        $database_input_array['po_reference_number'] = $generated_purchaseorder_code;
                    }

                    // project name
                    $project_detail = $this->project_model->get_project_by_name($this->input->post('project'));
                    if(empty($project_detail)){
                        $message['error'] = "Purchase Order gagal dibuat. Project tidak ada dalam system.";
                        $this->show_table($message);
                        return;
                    }else{
                        $database_input_array['project_id'] = $project_detail['id'];
                    }

                    // search for supplier id
                    $supplier_detail = $this->supplier_model->get_supplier_by_name($this->input->post('supplier'));
                    if(empty($supplier_detail)){
                        $message['error'] = "Purchase Order gagal dibuat. Supplier tidak ada dalam system.";
                        $this->show_table($message);
                        return;
                    }else{
                        $database_input_array['supplier_id'] = $supplier_detail['id'];
                    }

                    // input all po item values
                    $database_input_array['po_item_values'] = $po_item_values;

                    // input data to database
                    $response = $this->purchaseorder_model->set_po_detail($database_input_array);

                    if($response){
                        $message['success'] = "Purchase Order berhasil dibuat.";
                        $this->show_table($message);
                    }else{
                        $message['error'] = "Purchase Order gagal dibuat.";
                        $this->show_table($message);
                    }
                }else{
                    $message['error'] = "Purchase Order gagal dibuat. Item tidak dapat dideteksi.";
                    $this->show_table($message);
                }
            }else{
                $message['error'] = "Purchase Order gagal dibuat.";
                $this->show_table($message);
            }
        }
        */

    /*
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

    public function get_all_po_projects(){
        $po_projects = $this->project_model->get_all_projects();
        return $po_projects;
    }

    public function get_all_po_project_names(){
        $po_projects = $this->get_all_po_projects();
        $project_name = array();
        foreach($po_projects as $po_project){
            $project_name[] = $po_project['name'];
        }

        echo json_encode($project_name);
    }
    */

    /*
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
    */

    public function get_stock_detail_by_item_stock_code($stock_code){
        $stock_code = urldecode($stock_code);
        $stock_detail = $this->stock_model->get_stock_item_detail_by_stock_code($stock_code);
        echo json_encode($stock_detail);
    }

    private function show_table($message)
    {
        $user_id = $this->input->cookie('uid', TRUE);
        if($user_id){
            // user info
            $user_info = $this->login_model->get_user_info($user_id);
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];

            // access level
            $data['access']['create'] = true;
            $data['access']['edit'] = true;
            $data['access']['delete'] = true;

            // message
            $data['message'] = $message;

            // get necessary data
            // $data['purchaseorders'] = $this->purchaseorder_model->get_all_purchaseorders();

            // show the view
            $this->load->view('header');
            $this->load->view('useitem/navigation', $data);
            $this->load->view('useitem/main', $data);
            $this->load->view('useitem/footer');
        }else{
            redirect('/login', 'refresh');
        }
    }
}

/* End of file useitem.php */
/* Location: ./application/controllers/useitem.php */