<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include FCPATH . "/assets/barcodeprint/WebClientPrint.php";
use Neodynamic\SDK\Web\Utils;
use Neodynamic\SDK\Web\WebClientPrint;

class Purchaseorder extends CI_Controller {

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
        $this->load->model('project_model');
        $this->load->model('subproject_model');
        $this->load->model('purchaseorder_model');
        $this->load->model('login_model');
        $this->load->helper('cookie');
        $this->load->helper('url');
        $this->load->library('fpdf');
    }

	public function index()
	{
        $message = array();
        $this->show_table($message);
    }

    public function createpo(){
        $user_id = $this->input->cookie('uid', TRUE);
        if($user_id){
            // user info
            $user_info = $this->login_model->get_user_info($user_id);
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];

            /*
            // access level
            $data['access']['create'] = true;
            $data['access']['edit'] = true;
            $data['access']['delete'] = true;

            // message
            $data['message'] = $message;

            // get necessary data
            $data['purchaseorders'] = $this->purchaseorder_model->get_all_purchaseorders();
            */
            $data['project'] = $this->purchaseorder_model->get_all_project();
            // show the view
            $this->load->view('header');
            $this->load->view('purchaseorder/navigation', $data);
            $this->load->view('purchaseorder/createpo', $data);
            $this->load->view('purchaseorder/footer');
        }else{
            redirect('/login', 'refresh');
        }
    }

    public function deletepo($po_id){
        $response = $this->purchaseorder_model->delete_po($po_id);

        // display message according db status
        if($response){
            $message['success'] = "Purchase Order berhasil dihapus.";
            $this->show_table($message);
        }else{
            $message['error'] = "Purchase Order gagal dihapus.";
            $this->show_table($message);
        }
    }

    public function print_item_barcodes($po_id){
        $host_name = $database_password = getenv('HOST_NAME');

        if(empty($this->input->post())){
            $message = array();
            $this->show_print_barcode_table($message, $po_id);
        }else{
            $barcode_print_values = $this->input->post('po_barcode_print_item_values');
            $barcode_print_values = json_decode($barcode_print_values, TRUE);

            if($barcode_print_values){
                // item values successfully decoded
                $database_input_array = array();

                // set the receive item values
                $database_input_array['barcode_print_values'] = $barcode_print_values;

                // input data to database
                $response = $this->purchaseorder_model->update_barcode_status_quantity($database_input_array, $po_id);

                if($response){
                    $message = array();
                    $total_barcode_quantity = 0;
                    $barcode_details = $this->purchaseorder_model->get_barcode_detail_by_po_id($po_id);
                    foreach($barcode_details as $barcode_detail){
                        $total_barcode_quantity += $barcode_detail['label_quantity'];
                    }

                    $this->show_print_confirmation_screen($message, $po_id, $total_barcode_quantity);
                    echo WebClientPrint::createScript($host_name . '/printbarcode');
                }else{
                    $message['error'] = "Label gagal di print.";
                    $this->show_print_barcode_table($message, $po_id);
                }
            }else{
                $message['error'] = "Label gagal di print.";
                $this->show_print_barcode_table($message, $po_id);
            }
        }
    }

    public function receive_po_items($po_id){
        if(empty($this->input->post())){
            $message = array();
            $this->show_detail_table($message, $po_id);
        }else{
            if(!empty($this->input->post('po_received_item_values')) && !empty($this->input->post('supplier'))
                && !empty($this->input->post('project'))) {
                $po_received_item_values = $this->input->post('po_received_item_values');
                $po_received_item_values = json_decode($po_received_item_values, TRUE);

                if($po_received_item_values){
                    // item values successfully decoded
                    $database_input_array = array();

                    // search for supplier id
                    $supplier_detail = $this->supplier_model->get_supplier_by_name($this->input->post('supplier'));
                    if(empty($supplier_detail)){
                        $message['error'] = "Barang gagal diterima. Supplier tidak ada dalam system.";
                        $this->show_table($message);
                        return;
                    }else{
                        $database_input_array['supplier_id'] = $supplier_detail['id'];
                    }

                    // project name
                    $project_detail = $this->project_model->get_project_by_name($this->input->post('project'));
                    if(empty($project_detail)){
                        $message['error'] = "Barang gagal diterima. Project tidak ada dalam system.";
                        $this->show_table($message);
                        return;
                    }else{
                        $database_input_array['project_id'] = $project_detail['id'];
                    }

                    // set the receive item values
                    $database_input_array['po_received_item_values'] = $po_received_item_values;

                    // input data to database
                    $response = $this->purchaseorder_model->receive_po_items($database_input_array, $po_id);

                    if($response){
                        $message['success'] = "Barang berhasil diterima.";
                        $this->show_table($message);
                    }else{
                        $message['error'] = "Barang gagal diterima.";
                        $this->show_detail_table($message, $po_id);
                    }
                }else{
                    $message['error'] = "Barang gagal diterima. Item tidak dapat dideteksi.";
                    $this->show_detail_table($message, $po_id);
                }
            }else{
                $message['error'] = "Barang gagal diterima. Silahkan coba kembali.";
                $this->show_detail_table($message, $po_id);
            }
        }
    }

    public function submit_item_values(){
        // get the input value
        if(!empty($this->input->post('po_item_values')) && !empty($this->input->post('supplier'))
            && !empty($this->input->post('project')) && !empty($this->input->post('subproject'))){
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
                $project_detail = $this->project_model->get_project_by_id($this->input->post('project'));
                if(empty($project_detail)){
                    $message['error'] = "Purchase Order gagal dibuat. Project tidak ada dalam system.";
                    $this->show_table($message);
                    return;
                }else{
                    $database_input_array['project_id'] = $project_detail['id'];
                }

                $subproject_detail = $this->subproject_model->get_subproject_by_id($this->input->post('subproject'));
                if(empty($subproject_detail)){
                    $message['error'] = "Purchase Order gagal dibuat. SubProject tidak ada dalam system.";
                    $this->show_table($message);
                    return;
                }else{
                    $database_input_array['subproject_id'] = $subproject_detail['id'];
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

    private function show_table($message)
    {
        $user_id = $this->input->cookie('uid', TRUE);
        if($user_id){
            // user info
            $user_info = $this->login_model->get_user_info($user_id);
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            $data['purchaseorder'] = $user_info['purchase_order'];
            $data['receiveorder'] = $user_info['receiveorder'];

            // access level
            $create=substr($data['purchaseorder'],0,1); 
            $edit=substr($data['purchaseorder'],1,1); 
            $delete=substr($data['purchaseorder'],2,1); 
            $receive=substr($data['receiveorder'],0,1); 
            $print=substr($data['receiveorder'],1,1); 

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

            if($receive != 0){
                $data['access']['receive'] = true;    
            }else{
                $data['access']['receive'] = false;               
            }

            if($print != 0){
                $data['access']['print'] = true;    
            }else{
                $data['access']['print'] = false;               
            }

            // message
            $data['message'] = $message;

            // get necessary data
            $data['purchaseorders'] = $this->purchaseorder_model->get_all_purchaseorders();

            // show the view
            $this->load->view('header');
            $this->load->view('purchaseorder/navigation', $data);
            $this->load->view('purchaseorder/main', $data);
            $this->load->view('purchaseorder/footer');
        }else{
            redirect('/login', 'refresh');
        }
    }

    private function show_detail_table($message, $po_id)
    {
        $user_id = $this->input->cookie('uid', TRUE);
        if($user_id){
            // user info
            $user_info = $this->login_model->get_user_info($user_id);
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            $data['purchaseorder'] = $user_info['purchase_order'];

            // access level
            /*
            $create=substr($data['purchaseorder'],0,1); 
            $edit=substr($data['purchaseorder'],1,1); 
            $delete=substr($data['purchaseorder'],2,1); 
            
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
            */
            // message
            $data['message'] = $message;

            // get necessary data
            $data['purchaseorder_details'] = $this->purchaseorder_model->get_purchaseorder_detail_by_po_id($po_id);
            $data['purchaseorder_main'] = $this->purchaseorder_model->get_purchaseorder_by_id($po_id);

            // show the view
            $this->load->view('header');
            $this->load->view('purchaseorder/navigation', $data);
            $this->load->view('purchaseorder/receive_po_items', $data);
            $this->load->view('purchaseorder/footer');
        }else{
            redirect('/login', 'refresh');
        }
    }

    private function show_print_barcode_table($message, $po_id)
    {
        $user_id = $this->input->cookie('uid', TRUE);
        if($user_id){
            // user info
            $user_info = $this->login_model->get_user_info($user_id);
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            $data['purchaseorder'] = $user_info['purchase_order'];

            // access level
            /*
            $create=substr($data['purchaseorder'],0,1); 
            $edit=substr($data['purchaseorder'],1,1); 
            $delete=substr($data['purchaseorder'],2,1); 
            
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
            */
            // message
            $data['message'] = $message;

            // get necessary data
            $data['barcode_details'] = $this->purchaseorder_model->get_barcode_detail_by_po_id($po_id);
            $data['po_id'] = $po_id;

            // show the view
            $this->load->view('header');
            $this->load->view('purchaseorder/navigation', $data);
            $this->load->view('purchaseorder/print_item_barcodes', $data);
            $this->load->view('purchaseorder/footer');
        }else{
            redirect('/login', 'refresh');
        }
    }

    private function show_print_confirmation_screen($message, $po_id, $total_barcode_quantity)
    {
        $user_id = $this->input->cookie('uid', TRUE);
        if($user_id){
            // user info
            $user_info = $this->login_model->get_user_info($user_id);
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            $data['purchaseorder'] = $user_info['purchase_order'];

            // access level
            $create=substr($data['purchaseorder'],0,1); 
            $edit=substr($data['purchaseorder'],1,1); 
            $delete=substr($data['purchaseorder'],2,1); 
            
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
            //$data['barcode_details'] = $this->purchaseorder_model->get_barcode_detail_by_po_id($po_id);
            $data['po_id'] = $po_id;
            $data['total_barcode_quantity'] = $total_barcode_quantity;

            // show the view
            $this->load->view('header');
            $this->load->view('purchaseorder/navigation', $data);
            $this->load->view('purchaseorder/print_item_barcodes_confirmation', $data);
            $this->load->view('purchaseorder/footer', $data);
        }else{
            redirect('/login', 'refresh');
        }
    }

    public function get_subproject()
    {
        $project_id = $this->input->POST('project_id');
        $subproject = $this->purchaseorder_model->get_sub_project($project_id);
        $data .="<option value=''>-- Pilih Sub Project --</option>";
        foreach ($subproject as $sub) {
            $data .="<option value='$sub[id]'>$sub[name]</option>";
        }

        echo $data;
    }

    public function detail($id){
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
            //$data['message'] = $message;

            // get necessary data
        $data['detail'] = $this->purchaseorder_model->getpurchaseorder($id);
        $data['po'] = $this->purchaseorder_model->get_purchaseorder_detail($id);
        $this->load->view('header');
        $this->load->view('purchaseorder/navigation', $data);
        $this->load->view('purchaseorder/detail', $data);
        $this->load->view('purchaseorder/footer');
        }else{
            redirect('login', 'refresh');
        }
    }

    public function cetak($id)
    {
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
            //$idpj = $idproject;
        $data['detail'] = $this->purchaseorder_model->getpurchaseorder($id);
        $data['po'] = $this->purchaseorder_model->get_purchaseorder_detail($id);
        $this->load->view('purchaseorder/print', $data);
        
    }

    public function update_price($po_id)
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
            //$data['message'] = $message;

            // get necessary data
            $data['purchaseorder_details'] = $this->purchaseorder_model->get_purchaseorder_detail_by_stock_id($po_id);
            $data['purchaseorder_main'] = $this->purchaseorder_model->get_purchaseorder_by_id($po_id);

            $this->load->view('header');
            $this->load->view('purchaseorder/navigation', $data);
            $this->load->view('purchaseorder/item_price', $data);
            $this->load->view('purchaseorder/footer');;
        }else{
            redirect('login', 'refresh');
        }
    }

    public function update_itemprice(){
        // check all necessary input
        if(!empty($this->input->post('id')) && !empty($this->input->post('item_price'))){

            // search for project id
            $database_input_array = array();
            
            $database_input_array['id'] = $this->input->post('id');
            $database_input_array['item_price'] = $this->input->post('item_price');

            // store project information
            $response = $this->purchaseorder_model->update_itemprice($database_input_array);

            if($response){
                $message['success'] = "Item Price berhasil diubah.";
                $this->show_table($message);
            }else{
                $message['error'] = "Item Price gagal diubah.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "Item Price gagal diubah.";
            $this->show_table($message);
        }
    }
}

/* End of file purchaseorder.php */
/* Location: ./application/controllers/purchaseorder.php */