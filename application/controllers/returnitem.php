<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Returnitem extends CI_Controller {

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
        $this->load->model('returnitem_model');
        $this->load->model('project_model');
        $this->load->model('subproject_model');
        $this->load->model('worker_model');
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

    /*public function submit_item_values(){
        var_dump($this->input->post());
    }
    */
        public function submit_item_values(){
            // get the input value
            if(!empty($this->input->post('returnitem_item_values')) && !empty($this->input->post('worker'))){
                $returnitem_item_values = $this->input->post('returnitem_item_values');
                $returnitem_item_values = json_decode($returnitem_item_values, TRUE);

                if($returnitem_item_values){
                    // item values successfully decoded
                    $database_input_array = array();

                    // generate purchase order code
                    //$this->load->helper('purchaseorder_code_helper');
                   // $generated_purchaseorder_code = purchaseorder_code_generator();
                    //if(empty($generated_purchaseorder_code)){
                      //  $message['error'] = "Purchase Order gagal dibuat. Kode purchase order tidak dapat dibuat.";
                        //$this->show_table($message);
                        //return;
                   // }else{
                    //    $database_input_array['po_reference_number'] = $generated_purchaseorder_code;
                   // }

                    // project name
                    
                    $worker_detail = $this->worker_model->get_worker_by_name($this->input->post('worker_id'));
                    if(empty($worker_detail)){
                        $message['error'] = "Returnitem gagal dibuat. Worker tidak ada dalam system.";
                        $this->show_table($message);
                        return;
                    }else{
                        $database_input_array['worker_id'] = $worker_detail['id'];
                    }

                    // input all po item values
                    $database_input_array['returnitem_item_values'] = $returnitem_item_values;

                    // input data to database
                    $response = $this->returnitem_model->set_returnitem_detail($database_input_array);

                    if($response){
                        $message['success'] = "Returnitem berhasil dibuat.";
                        $this->show_table($message);
                    }else{
                        $message['error'] = "Returnitem gagal dibuat.";
                        $this->show_table($message);
                    }
                }else{
                    $message['error'] = "Returnitem gagal dibuat. Item tidak dapat dideteksi.";
                    $this->show_table($message);
                }
            }else{
                $message['error'] = "Returnitem gagal dibuat.";
                $this->show_table($message);
            }
        }
    
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

    public function get_all_returnitem_project(){
        $returnitem_project = $this->returnitem_model->get_all_project();
        return $returnitem_project;
    }

    public function get_all_returnitem_project_names(){
        $returnitem_project = $this->get_all_returnitem_project();
        $project_name = array();
        foreach($returnitem_project as $returnitem_project){
            $project_name[] = $returnitem_project['name'];
        }

        echo json_encode($project_name);
    }

    public function get_all_returnitem_worker(){
        $returnitem_worker = $this->returnitem_model->get_all_worker();
        return $returnitem_worker;
    }

    public function get_all_returnitem_worker_names(){
        $returnitem_worker = $this->get_all_returnitem_worker();
        $worker_name = array();
        foreach($returnitem_worker as $returnitem_worker){
            $worker_name[] = $returnitem_worker['name'];
        }

        echo json_encode($worker_name);
    }

    public function get_sub_project()
    {
        $project_id = $this->input->POST('project_id');
        $subproject = $this->returnitem_model->get_sub_project($project_id);
        $data .="<option value=''>-- Pilih Sub Project --</option>";
        foreach ($subproject as $sub) {
            $data .="<option value='$sub[id]'>$sub[name]</option>\n";
        }

        echo $data;

    }

    private function show_table($message)
    {
        $user_id = $this->input->cookie('uid', TRUE);
        if($user_id){
            // user info
            $user_info = $this->login_model->get_user_info($user_id);
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            $data['useitem'] = $user_info['use_item'];

            // access level
            $create=substr($data['useitem'],0,1); 
            $edit=substr($data['useitem'],1,1); 
            $delete=substr($data['useitem'],2,1); 
            
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
            // $data['purchaseorders'] = $this->purchaseorder_model->get_all_purchaseorders();
            //$data['project'] = $this->returnitem_model->get_all_project();
            // show the view
            $this->load->view('header');
            $this->load->view('returnitem/navigation', $data);
            $this->load->view('returnitem/main', $data);
            $this->load->view('returnitem/footer');
        }else{
            redirect('/login', 'refresh');
        }
    }
}

/* End of file useitem.php */
/* Location: ./application/controllers/useitem.php */