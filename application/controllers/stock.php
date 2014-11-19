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
        $this->load->model('unit_model');
    }

	public function index()
	{
        $message = array();
        $this->show_table($message);
    }

    public function create_stock()
    {
        /*
        if($this->input->post('name')){
            // check if there is any duplicate
            $duplicate_check = $this->item_model->get_item_by_name($this->input->post('name'));

            if(empty($duplicate_check)){
                $response = $this->item_model->set_item();

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
        */
    }

    public function update_stock(){
        /*
        $response = $this->item_model->update_item();

        if($response){
            $message['success'] = "Barang berhasil diubah.";
            $this->show_table($message);
        }else{
            $message['error'] = "Barang gagal diubah.";
            $this->show_table($message);
        }
        */
    }

    public function delete_stock($item_id){
        /*
        $response = $this->item_model->delete_item($item_id);

        // display message according db status
        if($response){
            $message['success'] = "Barang berhasil dihapus.";
            $this->show_table($message);
        }else{
            $message['error'] = "Barang gagal dihapus.";
            $this->show_table($message);
        }
        */
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

    public function get_unit_by_item_name($item_name){
        $item_name = urldecode($item_name);
        $item_detail = $this->item_model->get_item_by_name($item_name);

        if(!empty($item_detail[0]['unit_id'])){
            $unit_detail = $this->unit_model->get_unit_by_id($item_detail[0]['unit_id']);
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
        $data['stocks'] = $this->stock_model->get_all_stocks();

        // show the view
        $this->load->view('header');
        $this->load->view('stock/navigation', $data);
        $this->load->view('stock/main', $data);
        $this->load->view('footer');
    }
}

/* End of file stock.php */
/* Location: ./application/controllers/stock.php */