<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends CI_Controller {

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
        $this->load->model('supplier_model');
    }

	public function index()
	{
        $message = array();
        $this->show_table($message);
    }

    public function create_supplier(){
        /*
        if($this->input->post('abbreviation')){
            // check if there is any duplicate
            $duplicate_check = $this->unit_model->get_unit_by_abbreviation($this->input->post('abbreviation'));

            if(empty($duplicate_check)){
                $response = $this->unit_model->set_unit();

                if($response){
                    $message['success'] = "Satuan berhasil disimpan.";
                    $this->show_table($message);
                }else{
                    $message['error'] = "Satuan gagal disimpan.";
                    $this->show_table($message);
                }
            }else{
                $message['error'] = "Satuan gagal disimpan. Satuan sudah ada dalam system.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "Satuan gagal disimpan.";
            $this->show_table($message);
        }
        */
    }

    public function update_supplier(){
        /*
        $response = $this->unit_model->update_unit();

        if($response){
            $message['success'] = "Satuan berhasil diubah.";
            $this->show_table($message);
        }else{
            $message['error'] = "Satuan gagal diubah.";
            $this->show_table($message);
        }
        */
    }

    public function delete_supplier($supplier_id){
        /*
        $response = $this->unit_model->delete_unit($unit_id);

        // display message according db status
        if($response){
            $message['success'] = "Satuan berhasil dihapus.";
            $this->show_table($message);
        }else{
            $message['error'] = "Satuan gagal dihapus.";
            $this->show_table($message);
        }
        */
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
        $data['suppliers'] = $this->supplier_model->get_all_suppliers();

        // show the view
        $this->load->view('header');
        $this->load->view('supplier/navigation', $data);
        $this->load->view('supplier/main', $data);
        $this->load->view('footer');
    }
}

/* End of file supplier.php */
/* Location: ./application/controllers/supplier.php */