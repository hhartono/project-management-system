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
            $data['purchaseorders'] = $this->purchaseorder_model->get_all_purchaseorders();

            // show the view
            $this->load->view('header');
            $this->load->view('kirimpress/navigation', $data);
            $this->load->view('kirimpress/main', $data);
            $this->load->view('kirimpress/footer');
    }

    public function createpress(){
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

        // message
        $data['message'] = $message;

        // get necessary data
        $data['purchaseorders'] = $this->purchaseorder_model->get_all_purchaseorders();
        */
        $data['project'] = $this->purchaseorder_model->get_all_project();
        // show the view
        $this->load->view('header');
        $this->load->view('kirimpress/navigation', $data);
        $this->load->view('kirimpress/createpress', $data);
        $this->load->view('kirimpress/footer');
    }

    public function get_all_bahandasar(){
        $press_items = $this->kirimpress_model->get_all_bahandasar();
        return $press_items;
    }

   
}

/* End of file kirimpress.php */
/* Location: ./application/controllers/kirimpress.php */