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
        $this->load->model('project_model');
        $this->load->model('subproject_model');
        $this->load->model('worker_model');
        $this->load->model('stock_model');
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

    /*public function submit_item_values(){
        var_dump($this->input->post());
    }
    */
    public function submit_item_values(){
        // get the input value
        if(!empty($this->input->post('useitem_item_values')) && !empty($this->input->post('subproject'))
            && !empty($this->input->post('project')) && !empty($this->input->post('worker'))){
            $useitem_item_values = $this->input->post('useitem_item_values');
            $useitem_item_values = json_decode($useitem_item_values, TRUE);

            if($useitem_item_values){
                // item values successfully decoded
                $database_input_array = array();

                // project name
                $project_detail = $this->project_model->get_project_by_id($this->input->post('project'));
                if(empty($project_detail)){
                    $message['error'] = "Useitem gagal dibuat. Project tidak ada dalam system.";
                    $this->show_table($message);
                    return;
                }else{
                    $database_input_array['project_id'] = $project_detail['id'];
                }

                // search for subproject id
                $subproject_detail = $this->subproject_model->get_subproject_by_id($this->input->post('subproject'));
                if(empty($subproject_detail)){
                    $message['error'] = "Useitem gagal dibuat. Sub Project tidak ada dalam system.";
                    $this->show_table($message);
                    return;
                }else{
                    $database_input_array['subproject_id'] = $subproject_detail['id'];
                }

                $worker_detail = $this->worker_model->get_worker_by_name($this->input->post('worker'));
                if(empty($worker_detail)){
                    $message['error'] = "Useitem gagal dibuat. Worker tidak ada dalam system.";
                    $this->show_table($message);
                    return;
                }else{
                    $database_input_array['worker_id'] = $worker_detail['id'];
                }

                $database_input_array['user'] = $this->input->post('user');

                // input all po item values
                $database_input_array['useitem_item_values'] = $useitem_item_values;

               /* foreach ($useitem_item_values as $useitem_item_values) {
                    $getstock = $this->useitem_model->get_stock($useitem_item_values['item_stock_code']);
                }
                $database_input_array['getstock'] = $getstock;*/

                // input data to database
                $response = $this->useitem_model->set_useitem_detail($database_input_array);

                // print_r($database_input_array);
                // print_r($database_input_array['useitem_item_values'][0]);
                if($response){
                    $message['success'] = "Useitem berhasil dibuat.";
                    $this->show_table($message);
                }else{
                    $message['error'] = "Useitem gagal dibuat.";
                    $this->show_table($message);
                }
            }else{
                $message['error'] = "Useitem gagal dibuat. Item tidak dapat dideteksi.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "Useitem gagal dibuat.";
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

    public function get_stock_detail_by_item_code($item_code){
        $item_code = urldecode($item_code);
        $stock_detail = $this->stock_model->get_stock_item_detail_by_item_code($item_code);
        echo json_encode($stock_detail);
    }

    public function get_all_useitem_project(){
        $useitem_project = $this->useitem_model->get_all_project();
        return $useitem_project;
    }

    public function get_all_useitem_project_names(){
        $useitem_project = $this->get_all_useitem_project();
        $project_name = array();
        foreach($useitem_project as $useitem_project){
            $project_name[] = $useitem_project['name'];
        }

        echo json_encode($project_name);
    }

    public function get_all_useitem_worker(){
        $useitem_worker = $this->useitem_model->get_all_worker();
        return $useitem_worker;
    }

    public function get_all_useitem_worker_names(){
        $useitem_worker = $this->get_all_useitem_worker();
        $worker_name = array();
        foreach($useitem_worker as $useitem_worker){
            $worker_name[] = $useitem_worker['name'];
        }

        echo json_encode($worker_name);
    }

    public function get_sub_project()
    {
        $project_id = $this->input->POST('project_id');
        $subproject = $this->useitem_model->get_sub_project($project_id);
        $data .="<option value=''>-- Pilih Sub Project --</option>";
        foreach ($subproject as $sub) {
            $data .="<option value='$sub[id]'>$sub[name]</option>\n";
        }

        echo $data;

    }

    private function show_table($message)
    {
        $user_id    = $this->tank_auth->get_user_id();
       
            $user_info = $this->login_model->get_user_info($user_id);
            $data['userid'] = $user_info['id'];
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
            $data['project'] = $this->useitem_model->get_all_project();
            // show the view
            $this->load->view('header');
            $this->load->view('useitem/navigation', $data);
            $this->load->view('useitem/main', $data);
            $this->load->view('useitem/footer');
    }
}

/* End of file useitem.php */
/* Location: ./application/controllers/useitem.php */