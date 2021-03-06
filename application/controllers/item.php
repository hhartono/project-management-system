<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller {

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
        $this->load->model('category_model');
        $this->load->model('item_model');
        $this->load->model('unit_model');
        $this->load->model('login_model');
        $this->load->helper('cookie');
        $this->load->helper('url');
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->_is_logged_in();
    }

    public function _is_logged_in(){
        if(!$this->tank_auth->is_logged_in()){
            redirect('/auth/login');
        }
    }

	public function index()
	{
        $message = array();
        $this->show_table($message);
    }

    public function create_item()
    {
        if($this->input->post('name')){

            // po detail id
            $database_input_array['name'] = $this->input->post('name');

            // item price
            $database_input_array['unit_id'] = $this->input->post('unit_id');

            $database_input_array['stock_unit_id'] = $this->input->post('stock_unit_id');

            // item count
            $database_input_array['category_id'] = $this->input->post('category_id');

            $database_input_array['notes'] = $this->input->post('notes');

            // generate item stock code
            $this->load->helper('stock_code_helper');
            $generated_stock_code = stock_code_generator($database_input_array['category_id'], $database_input_array['unit_id']);
            if(empty($generated_stock_code)){
                $message['error'] = "Stok gagal disimpan. Kode stok tidak dapat dibuat.";
                $this->show_table($message);
                return;
            }else{
                $database_input_array['item_code'] = $generated_stock_code;
            }
            // check if there is any duplicate
            $duplicate_check = $this->item_model->get_item_by_name($this->input->post('name'));

            if(empty($duplicate_check)){
                $response = $this->item_model->set_item($database_input_array);

                if($response){
                    $message['success'] = "Barang berhasil disimpan.";
                    $this->show_table($message);
                }else{
                    $message['error'] = "Barang gagal disimpan.";
                    $this->show_table($message);
                }
            }else{
                $message['error'] = "Barang gagal disimpan. Barang sudah ada dalam system.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "Barang gagal disimpan.";
            $this->show_table($message);
        }
    }

    public function update_item(){
        $response = $this->item_model->update_item();

        if($response){
            $message['success'] = "Barang berhasil diubah.";
            $this->show_table($message);
        }else{
            $message['error'] = "Barang gagal diubah.";
            $this->show_table($message);
        }
    }

    public function delete_item($item_id){
        $response = $this->item_model->delete_item($item_id);

        // display message according db status
        if($response){
            $message['success'] = "Barang berhasil dihapus.";
            $this->show_table($message);
        }else{
            $message['error'] = "Barang gagal dihapus.";
            $this->show_table($message);
        }
    }

    public function get_item_detail($item_id){
        $item_id = urldecode($item_id);
        $item_detail = $this->item_model->get_item_by_id($item_id);
        echo json_encode($item_detail);
    }

    public function get_all_item_categories(){
        $item_categories = $this->category_model->get_all_categories();
        echo json_encode($item_categories);
    }

    public function get_all_item_units(){
        $item_units = $this->unit_model->get_all_units();
        echo json_encode($item_units);
    }

    public function get_all_item_stock_units(){
        $item_units = $this->unit_model->get_all_units();
        echo json_encode($item_units);
    }

    private function show_table($message)
    {
            $user_id    = $this->tank_auth->get_user_id();
            $user_info = $this->login_model->get_user_info($user_id);
            $data['userid'] = $user_info['id'];
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            $data['item'] = $user_info['item'];

            // access level
            $create=substr($data['item'],0,1); 
            $edit=substr($data['item'],1,1); 
            $delete=substr($data['item'],2,1); 
            
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
            $data['items'] = $this->item_model->get_all_items();

            // show the view
            $this->load->view('header');
            // $this->load->view('item/navigation', $data);
            $this->load->view('navigation', $data);
            $this->load->view('item/main', $data);
            $this->load->view('item/footer');
    }
}

/* End of file item.php */
/* Location: ./application/controllers/item.php */