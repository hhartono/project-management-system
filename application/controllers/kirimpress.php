<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include FCPATH . "/assets/barcodeprint/WebClientPrint.php";
use Neodynamic\SDK\Web\Utils;
use Neodynamic\SDK\Web\WebClientPrint;

class Kirimpress extends CI_Controller {

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
        $this->load->model('kirimpress_model');
        $this->load->model('unit_model');
        $this->load->model('supplier_model');
        $this->load->model('project_model');
        $this->load->model('subproject_model');
        $this->load->model('purchaseorder_model');
        $this->load->model('login_model');
        $this->load->helper('cookie');
        $this->load->helper('url');
        $this->load->library('fpdf');
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

    private function show_table($message)
    {
            $user_id    = $this->tank_auth->get_user_id();
            $user_info = $this->login_model->get_user_info($user_id);
            $data['userid'] = $user_info['id'];
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

            // $data['access']['create'] = true;
            // $data['access']['edit'] = true;
            // $data['access']['delete'] = true;
            // $data['access']['receive'] = true;
            // $data['access']['print'] = true;
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
            $data['kirimpress'] = $this->kirimpress_model->get_all_kirimpress();
            $data['catpress'] = $this->kirimpress_model->get_cat_press();

            // show the view
            $this->load->view('header');
            $this->load->view('kirimpress/navigation', $data);
            $this->load->view('kirimpress/main', $data);
            $this->load->view('kirimpress/footer');
    }

    public function createpress()
    {
        $message = array();
        $this->show_createpress($message);
    }

    public function show_createpress($message){
        $user_id = $this->tank_auth->get_user_id();
        $user_info = $this->login_model->get_user_info($user_id);
        $data['userid'] = $user_id;
        $data['username'] = $user_info['name'];
        $data['company_title'] = $user_info['title'];

        /*
        // access level
        $data['access']['create'] = true;
        $data['access']['edit'] = true;
        $data['access']['delete'] = true;
        */
        // message
        
        $data['message'] = $message;

        $data['press'] = $this->kirimpress_model->get_all_press();
        $data['project'] = $this->purchaseorder_model->get_all_project();
        
        // show the view
        $this->load->view('header');
        $this->load->view('kirimpress/navigation', $data);
        $this->load->view('kirimpress/createpress', $data);
        $this->load->view('kirimpress/footer');
    }

    public function item_press()
    {
        $message = array();
        $this->show_itempress($message);
    }

    public function show_itempress($message)
    {
        $user_id = $this->tank_auth->get_user_id();
        $user_info = $this->login_model->get_user_info($user_id);
        $data['userid'] = $user_id;
        $data['username'] = $user_info['name'];
        $data['company_title'] = $user_info['title'];

        
        // access level
        $data['access']['create'] = true;
        $data['access']['edit'] = true;
        $data['access']['delete'] = true;
        
        // message
        
        $data['message'] = $message;

        $data['press'] = $this->kirimpress_model->get_all_itempress();
        
        // show the view
        $this->load->view('header');
        $this->load->view('kirimpress/navigation', $data);
        $this->load->view('kirimpress/item_press', $data);
        $this->load->view('kirimpress/footer');
    }

    public function print_item_barcodes($id){
        $host_name = $database_password = getenv('HOST_NAME');

        if(empty($this->input->post())){
            $message = array();
            $this->show_print_barcode_table($message, $id);
        }else{
            $barcode_print_values = $this->input->post('barcode_print_item_values');
            $barcode_print_values = json_decode($barcode_print_values, TRUE);

            if($barcode_print_values){
                // item values successfully decoded
                $database_input_array = array();

                // set the receive item values
                $database_input_array['barcode_print_values'] = $barcode_print_values;

                // input data to database
                $response = $this->kirimpress_model->update_barcode_status_quantity($database_input_array, $id);

                if($response){
                    $message = array();
                    $total_barcode_quantity = 0;
                    $barcode_details = $this->kirimpress_model->get_barcode_detail_by_id($id);
                    foreach($barcode_details as $barcode_detail){
                        $total_barcode_quantity += $barcode_detail['label_quantity'];
                    }

                    $this->show_print_confirmation_screen($message, $id, $total_barcode_quantity);
                    echo WebClientPrint::createScript($host_name . '/printbarcode/press');
                }else{
                    $message['error'] = "Label gagal di print.";
                    $this->show_print_barcode_table($message, $id);
                }
            }else{
                $message['error'] = "Label gagal di prints.";
                $this->show_print_barcode_table($message, $id);
            }
        }
    }

    private function show_print_barcode_table($message, $id)
    {
        $user_id    = $this->tank_auth->get_user_id();
            $user_info = $this->login_model->get_user_info($user_id);
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            $data['stock'] = $user_info['purchase_order'];

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
            $data['barcode_details'] = $this->kirimpress_model->get_all_stockpress($id);
            $data['id'] = $id;

            // show the view
            $this->load->view('header');
            // $this->load->view('kirimpress/navigation', $data);
            $this->load->view('navigation', $data);
            $this->load->view('kirimpress/print_item_barcodes', $data);
            $this->load->view('kirimpress/footer');
    }

    private function show_print_confirmation_screen($message, $id, $total_barcode_quantity)
    {
       $user_id    = $this->tank_auth->get_user_id();
            $user_info = $this->login_model->get_user_info($user_id);
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            $data['stock'] = $user_info['purchase_order'];

            // access level
            $create=substr($data['stock'],0,1); 
            $edit=substr($data['stock'],1,1); 
            $delete=substr($data['stock'],2,1); 
            
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
            $data['id'] = $id;
            $data['total_barcode_quantity'] = $total_barcode_quantity;

            // show the view
            $this->load->view('header');
            // $this->load->view('kirimpress/navigation', $data);
            $this->load->view('navigation', $data);
            $this->load->view('kirimpress/print_item_barcodes_confirmation', $data);
            $this->load->view('kirimpress/footer', $data);
    }

    public function get_all_bahandasar(){
        $press_items = $this->kirimpress_model->get_all_bahandasar();
        return $press_items;
    }

    public function get_all_bahandasar_names(){
        $bd_items = $this->get_all_bahandasar();
        $bd_name = array();
        foreach($bd_items as $bd_item){
            $bd_name[] = $bd_item['name'];
        }

        echo json_encode($bd_name);
    }

    public function get_sisi1(){
        $sisi1 = $this->kirimpress_model->get_all_sisi();
        return $sisi1;
    }

    public function get_all_sisi1(){
        $sisi1 = $this->get_sisi1();
        $sisi_name = array();
        foreach($sisi1 as $sisi1){
            $sisi_name[] = $sisi1['name'];
        }

        echo json_encode($sisi_name);
    }

    public function get_sisi2(){
        $sisi2 = $this->kirimpress_model->get_all_sisi();
        return $sisi2;
    }

    public function get_all_sisi2(){
        $sisi2 = $this->get_sisi2();
        $sisi_name = array();
        foreach($sisi2 as $sisi2){
            $sisi_name[] = $sisi2['name'];
        }

        echo json_encode($sisi_name);
    }

    public function submit_press(){
        // get the input value
        if(!empty($this->input->post('name')) && !empty($this->input->post('sisi1')) && !empty($this->input->post('jumlah'))){
            
            $database_input_array['user'] = $this->input->post('user');

            // input all po item values
            $database_input_array['bahan_dasar'] = $this->input->post('name');

            $database_input_array['sisi1'] = $this->input->post('sisi1');

            $database_input_array['sisi2'] = $this->input->post('sisi2');

            $database_input_array['jumlah'] = $this->input->post('jumlah');

            // input data to database
            $response = $this->kirimpress_model->set_kirim_press($database_input_array);

            if($response){
                $message['success'] = "Kirim Press berhasil dibuat.";
                $this->show_createpress($message);
            }else{
                $message['error'] = "Kirim Press gagal dibuat.";
                $this->show_createpress($message);
            }
        }else{
            $message['error'] = "Kirim Press gagal dibuat. Bahan dasar dan sisi1 harus diisi .";
            $this->show_createpress($message);
        }
   }

   public function delete_press_temp($press_id){
        $response = $this->kirimpress_model->delete_press_temp($press_id);

        // display message according db status
        if($response){
            $message['success'] = "Kirim press berhasil dihapus.";
            $this->show_createpress($message);
        }else{
            $message['error'] = "Kirim press gagal dihapus.";
            $this->show_createpress($message);
        }
    }

    public function submit_kirim_press(){
        if(!empty($this->input->post('project')) && !empty($this->input->post('subproject'))){

            $project_detail = $this->project_model->get_project_by_id($this->input->post('project'));
            if(empty($project_detail)){
                $message['error'] = "Kirim press gagal dibuat. Project tidak ada dalam system.";
                $this->show_createpress($message);
                return;
            }else{
                $database_input_array['project_id'] = $project_detail['id'];
            }

            $subproject_detail = $this->subproject_model->get_subproject_by_id($this->input->post('subproject'));
            if(empty($subproject_detail)){
                $message['error'] = "Kirim Press gagal dibuat. SubProject tidak ada dalam system.";
                $this->show_createpress($message);
                return;
            }else{
                $database_input_array['subproject_id'] = $subproject_detail['id'];
            }

            $database_input_array['user'] = $this->input->post('user');

            $this->load->helper('press_code_helper');
            $generated_kirimpress_code = press_code_generator();
            if(empty($generated_kirimpress_code)){
                $message['error'] = "Kirim Press gagal dibuat. Kode Press tidak dapat dibuat.";
                $this->show_createpress($message);
                return;
            }else{
                $database_input_array['kode_press'] = $generated_kirimpress_code;
            }

            $response = $this->kirimpress_model->set_kirimpress_project($database_input_array);

            if($response){
                $message['success'] = "Kirim Press berhasil dibuat.";
                $this->show_createpress($message);
            }else{
                $message['error'] = "Kirim Press gagal dibuat.";
                $this->show_createpress($message);
            }

        }else{
            $message['error'] = "Kirim press gagal dibuat.";
            $this->show_createpress($message);
        }    

    }

    public function get_subproject()
    {
        $project_id = $this->input->POST('project_id');
        $subproject = $this->kirimpress_model->get_sub_project($project_id);
        $data .="<option value=''>-- Pilih Sub Project --</option>";
        foreach ($subproject as $sub) {
            $data .="<option value='$sub[id]'>$sub[name]</option>";
        }

        echo $data;
    }

    public function receive($id)
    {
        $message = array();
        $this->show_receive($message, $id);
    }

    public function show_receive($message, $id)
    {
        $user_id    = $this->tank_auth->get_user_id();
        $user_info = $this->login_model->get_user_info($user_id);
        $data['username'] = $user_info['name'];
        $data['company_title'] = $user_info['title'];
        //$data['purchaseorder'] = $user_info['purchase_order'];

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
        $data['press'] = $this->kirimpress_model->get_all_itempress_by_id($id);
        $data['catpress'] = $this->kirimpress_model->get_cat_press();
        $data['receive_press'] = $this->uri->segment(3);

        // show the view
        $this->load->view('header');
        // $this->load->view('kirimpress/navigation', $data);
        $this->load->view('navigation', $data);
        $this->load->view('kirimpress/receive_press_items', $data);
        $this->load->view('kirimpress/footer');
    }

    public function receive_submit($id)
    {
        if(!empty($this->input->post('received_item_values'))) {
                $received_item_values = $this->input->post('received_item_values');
                $received_item_values = json_decode($received_item_values, TRUE);

                if($received_item_values){
                    // item values successfully decoded
                    $database_input_array = array();

                    $database_input_array['cat'] = $this->input->post('cat');

                    // generate item stock code
                    $this->load->helper('stock_press_code_helper');
                    $generated_stock_code = stock_press_code_generator($database_input_array['cat']);
                    if(empty($generated_stock_code)){
                        $message['error'] = "Press gagal disimpan. Kode stok tidak dapat dibuat.";
                        $this->show_receive($message, $id);
                        return;
                    }else{
                        $database_input_array['stock_press_code'] = $generated_stock_code;
                    }

                    // set the receive item values
                    $database_input_array['received_item_values'] = $received_item_values;

                    // input data to database
                    $response = $this->kirimpress_model->set_receive_press($database_input_array, $id);

                    if($response){
                        $message['success'] = "Barang berhasil diterima.";
                        $this->show_table($message);
                    }else{
                        $message['error'] = "Barang gagal diterima.";
                        $this->show_receive($message, $id);
                    }
                }else{
                    $message['error'] = "Barang gagal diterima. Item tidak dapat dideteksi.";
                    $this->show_receive($message, $id);
                }
            }else{
                $message['error'] = "Barang gagal diterima. Silahkan coba kembali.";
                $this->show_receive($message, $id);
            }
    }
   
}

/* End of file kirimpress.php */
/* Location: ./application/controllers/kirimpress.php */