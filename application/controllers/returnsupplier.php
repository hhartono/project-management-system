<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Returnsupplier extends CI_Controller {

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
        $this->load->model('returnsupplier_model');
        $this->load->model('project_model');
        $this->load->model('subproject_model');
        $this->load->model('supplier_model');
        $this->load->model('stock_model');
        $this->load->model('login_model');
        $this->load->helper('cookie');
        $this->load->helper('url');
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->load->library('fpdf');
        $this->_is_logged_in();
    }

	public function index()
	{
        $message = array();
        $this->show_table_list($message);
    }

    public function returnitem()
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
        if(!empty($this->input->post('returnsupplier_item_values'))){
            $returnsupplier_item_values = $this->input->post('returnsupplier_item_values');
            $returnsupplier_item_values = json_decode($returnsupplier_item_values, TRUE);

            if($returnsupplier_item_values){
                // item values successfully decoded
                $database_input_array = array();

                // generate return item code
                $this->load->helper('returnsupplier_code_helper');
                $generated_returnsupplier_code = returnsupplier_code_generator();
                if(empty($generated_returnsupplier_code)){
                    $message['error'] = "Return item gagal dibuat. Kode return item tidak dapat dibuat.";
                    $this->show_table($message);
                    return;
                }else{
                    $database_input_array['return_reference_number'] = $generated_returnsupplier_code;
                }

                $supplier_detail = $this->supplier_model->get_supplier_by_name($this->input->post('supplier'));
                if(empty($supplier_detail)){
                    $message['error'] = "Return item gagal dibuat. Supplier tidak ada dalam system.";
                    $this->show_table($message);
                    return;
                }else{
                    $database_input_array['supplier_id'] = $supplier_detail['id'];
                }
            
                $database_input_array['user'] = $this->input->post('user');

                // input all po item values
                $database_input_array['returnsupplier_item_values'] = $returnsupplier_item_values;

                // input data to database
                $response = $this->returnsupplier_model->set_returnsupplier_detail($database_input_array);

                if($response){
                    $message['success'] = "Returnsupplier berhasil dibuat.";
                    $this->show_table($message);
                }else{
                    $message['error'] = "Returnsupplier gagal dibuat.";
                    $this->show_table($message);
                }
            }else{
                $message['error'] = "Returnsupplier gagal dibuat. Item tidak dapat dideteksi.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "Returnsupplier gagal dibuat.";
            $this->show_table($message);
        }
    }

    public function get_stock_detail_by_item_stock_code($stock_code){
        $stock_code = urldecode($stock_code);
        $stock_detail = $this->stock_model->get_stock_item_by_stock_code($stock_code);
        echo json_encode($stock_detail);
    }

    public function get_all_returnsupplier_project(){
        $returnsupplier_project = $this->returnsupplier_model->get_all_project();
        return $returnsupplier_project;
    }

    public function get_all_returnsupplier_project_names(){
        $returnsupplier_project = $this->get_all_returnsupplier_project();
        $project_name = array();
        foreach($returnsupplier_project as $returnsupplier_project){
            $project_name[] = $returnsupplier_project['name'];
        }

        echo json_encode($project_name);
    }

    public function get_all_returnsupplier_supplier(){
        $returnsupplier_supplier = $this->returnsupplier_model->get_all_supplier();
        return $returnsupplier_supplier;
    }

    public function get_all_returnsupplier_supplier_names(){
        $returnsupplier_supplier = $this->get_all_returnsupplier_supplier();
        $supplier_name = array();
        foreach($returnsupplier_supplier as $returnsupplier_supplier){
            $supplier_name[] = $returnsupplier_supplier['name'];
        }

        echo json_encode($supplier_name);
    }

    public function get_sub_project()
    {
        $project_id = $this->input->POST('project_id');
        $subproject = $this->returnsupplier_model->get_sub_project($project_id);
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
            //$data['returnsupplier'] = $user_info['returnsupplier'];

            // access level
           /* $create=substr($data['returnsupplier'],0,1); 
            $edit=substr($data['returnsupplier'],1,1); 
            $delete=substr($data['returnsupplier'],2,1); 
            
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
            // $data['purchaseorders'] = $this->purchaseorder_model->get_all_purchaseorders();
            //$data['project'] = $this->returnsupplier_model->get_all_project();
            // show the view
            $this->load->view('header');
            // $this->load->view('returnsupplier/navigation', $data);
            $this->load->view('navigation', $data);
            $this->load->view('returnsupplier/main', $data);
            $this->load->view('returnsupplier/footer');
    }

    private function show_table_list($message)
    {
            $user_id    = $this->tank_auth->get_user_id();
            $user_info = $this->login_model->get_user_info($user_id);
            $data['userid'] = $user_info['id'];
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            /*$data['purchaseorder'] = $user_info['purchase_order'];
            $data['receiveorder'] = $user_info['receiveorder'];

            // access level
            $create=substr($data['purchaseorder'],0,1); 
            $edit=substr($data['purchaseorder'],1,1); 
            $delete=substr($data['purchaseorder'],2,1); 
            $receive=substr($data['receiveorder'],0,1); 
            $print=substr($data['receiveorder'],1,1); 
*/
            $data['access']['create'] = true;
            $data['access']['edit'] = true;
            $data['access']['delete'] = true;
            $data['access']['receive'] = true;
            $data['access']['print'] = true;
            /*if($create != 0){
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
            }*/

            // message
            $data['message'] = $message;

            // get necessary data
            $data['returnsupplier'] = $this->returnsupplier_model->get_all_return_supplier();

            // show the view
            $this->load->view('header');
            // $this->load->view('returnsupplier/navigation', $data);
            $this->load->view('navigation', $data);
            $this->load->view('returnsupplier/list', $data);
            $this->load->view('returnsupplier/footer');
    }

    public function detail($id){
        $user_id    = $this->tank_auth->get_user_id();
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
        $data['detail'] = $this->returnsupplier_model->getreturnsupplier($id);
        $data['po'] = $this->returnsupplier_model->get_returnsupplier_detail($id);
        $data['pod'] = $this->returnsupplier_model->get_returnsupplier_details($id);
        
        $this->load->view('header');
        // $this->load->view('returnsupplier/navigation', $data);
        $this->load->view('navigation', $data);
        $this->load->view('returnsupplier/detail', $data);
        $this->load->view('returnsupplier/footer');
    }

    public function cetak($id)
    {
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
            //$idpj = $idproject;
        $data['detail'] = $this->returnsupplier_model->getreturnsupplier($id);
        $data['po'] = $this->returnsupplier_model->get_returnsupplier_detail($id);
        //$data['pod'] = $this->purchaseorder_model->get_purchaseorder_details($id);
        $this->load->view('returnsupplier/print', $data);
        
    }
}

/* End of file returnsupplier.php */
/* Location: ./application/controllers/returnsupplier.php */