<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

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
        $this->load->model('login_model');
        $this->load->helper('cookie');
        $this->load->helper('url');
        //test
    }

	public function index()
	{
        $message = array();
        $this->show_table($message);
    }

    public function create_category(){
        if($this->input->post('prefix')){
            // check if there is any duplicate
            $duplicate_check = $this->category_model->get_category_by_prefix($this->input->post('prefix'));

            if(empty($duplicate_check)){
                $response = $this->category_model->set_category();

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
        $response = $this->category_model->update_category();

        if($response){
            $message['success'] = "Kategori berhasil diubah.";
            $this->show_table($message);
        }else{
            $message['error'] = "Kategori gagal diubah.";
            $this->show_table($message);
        }
    }

    public function delete_category($category_id){
        $response = $this->category_model->delete_category($category_id);

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
        $category_detail = $this->category_model->get_category_by_id($category_id);
        echo json_encode($category_detail);
    }

    private function show_table($message)
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
            $data['message'] = $message;

            // get necessary data
            $data['categories'] = $this->category_model->get_all_categories();

            // show the view
            $this->load->view('header');
            $this->load->view('category/navigation', $data);
            $this->load->view('category/main', $data);
            $this->load->view('category/footer');
        }else{
            redirect('/login', 'refresh');
        }
    }
}

/* End of file category.php */
/* Location: ./application/controllers/category.php */