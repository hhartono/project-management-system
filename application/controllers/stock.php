<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock extends CI_Controller {

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
        $this->load->model('stock_model');
        $this->load->model('item_model');
        $this->load->model('supplier_model');
        $this->load->model('project_model');
        $this->load->model('unit_model');
        $this->load->model('login_model');
        $this->load->helper('cookie');
        $this->load->helper('url');
    }

	public function index()
	{
        $message = array();
        $this->show_table($message);

        $this->load->helper('stock_code_helper');
        $generated_stock_code = stock_code_generator(2, 2);
    }

    public function create_stock()
    {
        // check all necessary input
        if(!empty($this->input->post('name')) && !empty($this->input->post('item_count'))
            && !empty($this->input->post('supplier'))){

            // search for item id
            $database_input_array = array();
            $item_detail = $this->item_model->get_item_by_name($this->input->post('name'));
            if(empty($item_detail)){
                $message['error'] = "Stok gagal disimpan. Nama barang tidak ada dalam system.";
                $this->show_table($message);
                return;
            }else{
                $database_input_array['item_id'] = $item_detail['id'];
                $database_input_array['category_id'] = $item_detail['category_id'];
            }

            // search for supplier id
            $supplier_detail = $this->supplier_model->get_supplier_by_name($this->input->post('supplier'));
            if(empty($supplier_detail)){
                $message['error'] = "Stok gagal disimpan. Supplier barang tidak ada dalam system.";
                $this->show_table($message);
                return;
            }else{
                $database_input_array['supplier_id'] = $supplier_detail['id'];
            }

            // search for project id
            $project_detail = $this->project_model->get_project_by_name($this->input->post('project'));
            if(empty($project_detail)){
                $message['error'] = "Stok gagal disimpan. Project tidak ada dalam system.";
                $this->show_table($message);
                return;
            }else{
                $database_input_array['project_id'] = $project_detail['id'];
            }

            // po detail id
            $database_input_array['po_detail_id'] = $this->input->post('po_detail_id');

            // item price
            $database_input_array['item_price'] = $this->input->post('item_price');

            // item count
            $database_input_array['item_count'] = $this->input->post('item_count');

            // generate item stock code
            $this->load->helper('stock_code_helper');
            $generated_stock_code = stock_code_generator($database_input_array['category_id'], $database_input_array['supplier_id']);
            if(empty($generated_stock_code)){
                $message['error'] = "Stok gagal disimpan. Kode stok tidak dapat dibuat.";
                $this->show_table($message);
                return;
            }else{
                $database_input_array['item_stock_code'] = $generated_stock_code;
            }

            // store stock information
            $response = $this->stock_model->set_stock($database_input_array);

            if($response){
                $message['success'] = "Stok berhasil disimpan.";
                $this->show_table($message);
            }else{
                $message['error'] = "Stok gagal disimpan.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "Stok gagal disimpan.";
            $this->show_table($message);
        }
    }

    public function update_stock(){
        // check all necessary input
        if(!empty($this->input->post('id')) && !empty($this->input->post('name'))
            && !empty($this->input->post('item_count')) && !empty($this->input->post('supplier'))){

            // search for item id
            $database_input_array = array();
            $item_detail = $this->item_model->get_item_by_name($this->input->post('name'));
            if(empty($item_detail)){
                $message['error'] = "Stok gagal diubah. Nama barang tidak ada dalam system.";
                $this->show_table($message);
                return;
            }else{
                $database_input_array['item_id'] = $item_detail['id'];
                $database_input_array['category_id'] = $item_detail['category_id'];
            }

            // search for supplier id
            $supplier_detail = $this->supplier_model->get_supplier_by_name($this->input->post('supplier'));
            if(empty($supplier_detail)){
                $message['error'] = "Stok gagal diubah. Supplier barang tidak ada dalam system.";
                $this->show_table($message);
                return;
            }else{
                $database_input_array['supplier_id'] = $supplier_detail['id'];
            }

            // search for project id
            $project_detail = $this->project_model->get_project_by_name($this->input->post('project'));
            if(empty($project_detail)){
                $message['error'] = "Stok gagal disimpan. Project tidak ada dalam system.";
                $this->show_table($message);
                return;
            }else{
                $database_input_array['project_id'] = $project_detail['id'];
            }

            // po detail id
            $database_input_array['po_detail_id'] = $this->input->post('po_detail_id');

            // item price
            $database_input_array['item_price'] = $this->input->post('item_price');

            // item count
            $database_input_array['item_count'] = $this->input->post('item_count');

            // database id
            $database_input_array['id'] = $this->input->post('id');

            // store stock information
            $response = $this->stock_model->update_stock($database_input_array);

            if($response){
                $message['success'] = "Stok berhasil diubah.";
                $this->show_table($message);
            }else{
                $message['error'] = "Stok gagal diubah.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "Stok gagal diubah.";
            $this->show_table($message);
        }
    }

    public function delete_stock($stock_id){
        $response = $this->stock_model->delete_stock($stock_id);

        // display message according db status
        if($response){
            $message['success'] = "Stok berhasil dihapus.";
            $this->show_table($message);
        }else{
            $message['error'] = "Stok gagal dihapus.";
            $this->show_table($message);
        }
    }

    public function get_all_stock_items(){
        $stock_items = $this->item_model->get_all_items();
        return $stock_items;
    }

    public function get_all_stock_item_names(){
        $stock_items = $this->get_all_stock_items();
        $stock_name = array();
        foreach($stock_items as $stock_item){
            $stock_name[] = $stock_item['name'];
        }

        echo json_encode($stock_name);
    }

    public function get_all_stock_suppliers(){
        $stock_suppliers = $this->supplier_model->get_all_suppliers();
        return $stock_suppliers;
    }

    public function get_all_stock_supplier_names(){
        $stock_suppliers = $this->get_all_stock_suppliers();
        $supplier_name = array();
        foreach($stock_suppliers as $stock_supplier){
            $supplier_name[] = $stock_supplier['name'];
        }

        echo json_encode($supplier_name);
    }

    public function get_all_stock_projects(){
        $stock_projects = $this->project_model->get_all_projects();
        return $stock_projects;
    }

    public function get_all_stock_project_names(){
        $stock_projects = $this->get_all_stock_projects();
        $project_name = array();
        foreach($stock_projects as $stock_project){
            $project_name[] = $stock_project['name'];
        }

        echo json_encode($project_name);
    }

    public function get_unit_by_item_name($item_name){
        $item_name = urldecode($item_name);
        $item_detail = $this->item_model->get_item_by_name($item_name);

        if(!empty($item_detail['unit_id'])){
            $unit_detail = $this->unit_model->get_unit_by_id($item_detail['unit_id']);
            echo json_encode($unit_detail);
        }
    }

    public function get_all_stock_units(){
        $item_units = $this->unit_model->get_all_units();
        echo json_encode($item_units);
    }

    public function get_stock_detail($stock_id){
        $stock_id = urldecode($stock_id);
        $stock_detail = $this->stock_model->get_stock_by_id($stock_id);
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
            $data['stock'] = $user_info['stock_item'];

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
            $data['stocks'] = $this->stock_model->get_all_stocks();

            // show the view
            $this->load->view('header');
            $this->load->view('stock/navigation', $data);
            $this->load->view('stock/main', $data);
            $this->load->view('stock/footer');
        }else{
            redirect('/login', 'refresh');
        }
    }
}

/* End of file stock.php */
/* Location: ./application/controllers/stock.php */