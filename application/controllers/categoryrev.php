<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categoryrev extends CI_Controller {

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
    public function __construct(){
        parent::__construct();
        $this->load->model('categoryrev_model');
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

	public function index()	{
        $message = array();
        $this->show_table($message);
    }

    public function create_category(){
        if($this->input->post('prefix')){
            // check if there is any duplicate
            $duplicate_check = $this->categoryrev_model->get_category_by_prefix($this->input->post('prefix'));
            
            if(empty($duplicate_check)){
                $response = $this->categoryrev_model->set_category();

                if($response){
                    $message['success'] = "Kategori berhasil disimpan.";
                    $this->show_table($message);
                }else{
                    $message['error'] = "Kategori gagal disimpan.";
                    $this->show_table($message);
                }
            }else{
                $message['error'] = "Kategori gagal disimpan. Kategori sudah ada dalam system.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "Kategori gagal disimpan.";
            $this->show_table($message);
        }
    }

    public function update_category(){
        // $response = $this->categoryrev_model->update_category();
        $response = $this->categoryrev_model->update_harga();

        if($response){
            $message['success'] = "Kategori berhasil diubah.";
            $this->show_table($message);
        }else{
            $message['error'] = "Kategori gagal diubah.";
            $this->show_table($message);
        }
    }

    public function delete_category($category_id){
        $response = $this->categoryrev_model->delete_category($category_id);

        // display message according db status
        if($response){
            $message['success'] = "Kategori berhasil dihapus.";
            $this->show_table($message);
        }else{
            $message['error'] = "Kategori gagal dihapus.";
            $this->show_table($message);
        }
    }

    public function get_category_detail($category_id){
        $category_id = urldecode($category_id);
        $category_detail = $this->categoryrev_model->get_category_by_id($category_id);
        echo json_encode($category_detail);
    }

    public function cek_history_harga($kat_id){
        // echo 'test';
        $kat_id = urldecode($kat_id);
        $harga = $this->categoryrev_model->get_harga_by_id($kat_id);
        // $data['num_rows'] = count($harga);
        // echo json_encode($data['num_rows']);
        echo json_encode($harga);
    }

    private function show_table($message){
        $user_id = $this->tank_auth->get_user_id();
        
        $user_info = $this->login_model->get_user_info($user_id);
        $data['userid'] = $user_info['id'];
        $data['username'] = $user_info['name'];
        $data['company_title'] = $user_info['title'];
        $data['category'] = $user_info['category_item'];

        // access level
        $create=substr($data['category'],0,1); 
        $edit  =substr($data['category'],1,1); 
        $delete=substr($data['category'],2,1); 
        
        if($create != 0){
            $data['access']['create'] = true;            
        } else{
            $data['access']['create'] = false;
        }
        
        if($edit != 0){
            $data['access']['edit'] = true;            
        } else{
            $data['access']['edit'] = false;
        }

        if($delete != 0){
            $data['access']['delete'] = true;    
        } else{
            $data['access']['delete'] = false;               
        }
        // message
        $data['message'] = $message;

        // get necessary data
        $data['categories'] = $this->categoryrev_model->get_all_categories();

        // show the view
        $this->load->view('header');
        $this->load->view('category_rev/navigation', $data);
        $this->load->view('category_rev/main', $data);
        $this->load->view('category_rev/footer');
    }
}

/* End of file category.php */
/* Location: ./application/controllers/category_rev.php */