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
    }

	public function index()
	{
        $message = array();
        $this->show_table($message);
    }

    public function create_item()
    {
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
        $data['items'] = $this->item_model->get_all_items();

        // show the view
        $this->load->view('header');
        $this->load->view('item/navigation', $data);
        $this->load->view('item/main', $data);
        $this->load->view('footer');
    }
}

/* End of file item.php */
/* Location: ./application/controllers/item.php */