<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warna extends CI_Controller {

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
        $this->load->model('warna_model');
        $this->load->model('login_model');
        $this->load->model('project_model');
        $this->load->model('subproject_model');
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

    public function create_warna(){
        // check all necessary input
        if(!empty($this->input->post('kode_warna')) && !empty($this->input->post('nama_warna')) && !empty($this->input->post('kode_pantone')) && !empty($this->input->post('hexadecimal'))){
            // search for customer id
            $database_input_array = array();

            $database_input_array['kode_warna'] = $this->input->post('kode_warna');

            $database_input_array['nama_warna'] = $this->input->post('nama_warna');

            $database_input_array['kode_pantone'] = $this->input->post('kode_pantone');

            $database_input_array['hexadecimal'] = $this->input->post('hexadecimal');

            // get the warna start date
            date_default_timezone_set('Asia/Jakarta');

            // check if there is any duplicate
            $duplicate_check = $this->warna_model->get_warna_by_name_kode($database_input_array['nama_warna'], $database_input_array['kode_warna']);

            if(empty($duplicate_check)){
                $response = $this->warna_model->set_warna($database_input_array);

                if($response){
                    $message['success'] = "warna berhasil disimpan.";
                    $this->show_table($message);
                }else{
                    $message['error'] = "warna gagal disimpan.";
                    $this->show_table($message);
                }
            }else{
                $message['error'] = "warna gagal disimpan. warna sudah ada dalam system.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "warna gagal disimpan.";
            $this->show_table($message);
        }
    }

    public function update_warna(){
        // check all necessary input
        if(!empty($this->input->post('id')) && !empty($this->input->post('kode_warna')) && !empty($this->input->post('nama_warna')) && !empty($this->input->post('kode_pantone')) && !empty($this->input->post('hexadecimal'))){

            $database_input_array = array();
            
            $database_input_array['kode_warna'] = $this->input->post('kode_warna');

            $database_input_array['nama_warna'] = $this->input->post('nama_warna');

            $database_input_array['kode_pantone'] = $this->input->post('kode_pantone');

            $database_input_array['hexadecimal'] = $this->input->post('hexdecimal');

            // get the warna start date
            date_default_timezone_set('Asia/Jakarta');
            
            // database id
            $database_input_array['id'] = $this->input->post('id');

            // store warna information
            $response = $this->warna_model->update_warna($database_input_array);

            if($response){
                $message['success'] = "warna berhasil diubah.";
                $this->show_table($message);
            }else{
                $message['error'] = "warna gagal diubah.";
                $this->show_table($message);
            }
        }else{
            $message['error'] = "warna gagal diubah.!";
            $this->show_table($message);
        }
    }

    public function delete_warna($warna_id){
        $response = $this->warna_model->delete_warna($warna_id);

        // display message according db status
        if($response){
            $message['success'] = "warna berhasil dihapus.";
            $this->show_table($message);
        }else{
            $message['error'] = "warna gagal dihapus.";
            $this->show_table($message);
        }
    }

    private function show_table($message)
    {
        $user_id = $this->tank_auth->get_user_id();
        
            $user_info = $this->login_model->get_user_info($user_id);
            $data['userid'] = $user_info['id'];
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            $data['project'] = $user_info['project'];

            // access level
            $create=substr($data['project'],0,1); 
            $edit=substr($data['project'],1,1); 
            $delete=substr($data['project'],2,1); 
            
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
            $data['warnas'] = $this->warna_model->get_all_warnas();

            // show the view
            $this->load->view('header');
            $this->load->view('warna/navigation', $data);
            $this->load->view('warna/main', $data);
            $this->load->view('warna/footer');
    }

    public function pattern_warna()
    {
        $message = array();
        $this->show_pattern($message);
    }

     private function show_pattern($message)
    {
        $user_id = $this->tank_auth->get_user_id();
        
            $user_info = $this->login_model->get_user_info($user_id);
            $data['userid'] = $user_info['id'];
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            $data['project'] = $user_info['project'];

            // access level
            $create=substr($data['project'],0,1); 
            $edit=substr($data['project'],1,1); 
            $delete=substr($data['project'],2,1); 
            
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
            $data['pattern'] = $this->warna_model->get_all_pattern_project();

            // show the view
            $this->load->view('header');
            $this->load->view('warna/navigation', $data);
            $this->load->view('warna/pattern', $data);
            $this->load->view('warna/footer');
    }

    public function get_warna_detail($warna_id){
        date_default_timezone_set('Asia/Jakarta');

        $warna_id = urldecode($warna_id);
        $warna_detail = $this->warna_model->get_warna_by_id($warna_id);
        echo json_encode($warna_detail);
    }

    public function view_warna($warna_id)
    {
        $user_id = $this->tank_auth->get_user_id();
        
            $user_info = $this->login_model->get_user_info($user_id);
            $data['userid'] = $user_info['id'];
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            $data['project'] = $user_info['project'];

            $data['warnas'] = $this->warna_model->get_warna_by_id($warna_id);

            // show the view
            $this->load->view('header');
            $this->load->view('warna/navigation', $data);
            $this->load->view('warna/view_warna', $data);
            $this->load->view('warna/footer');
    }

    public function get_all_projects_warna(){
        $warna_projects = $this->project_model->get_all_projects();
        return $warna_projects;
    }

    public function get_all_project_warna(){
        $warna_projects = $this->get_all_projects_warna();
        $project_name = array();
        foreach($warna_projects as $warna_project){
            $project_name[] = $warna_project['name'];
        }

        echo json_encode($project_name);
    }

    public function get_all_subprojects_warna(){
        $uri = $this->uri->segment(3);
        $warna_subprojects = $this->subproject_model->get_all_subprojects_warna($uri);
        return $warna_subprojects;
    }

    public function get_all_subproject_warna(){
        $warna_subprojects = $this->get_all_subprojects_warna();
        $subproject_name = array();
        foreach($warna_subprojects as $warna_subproject){
            $subproject_name[] = $warna_subproject['name'];
        }

        echo json_encode($subproject_name);
    }

    public function create_project_warna(){
        // check all necessary input
        if(!empty($this->input->post('project_name'))){
            // search for customer id
            $database_input_array = array();

            // get the warna start date
            date_default_timezone_set('Asia/Jakarta');

            $project_detail = $this->project_model->get_project_by_name($this->input->post('project_name'));
            if(empty($project_detail)){
                $message['error'] = "Project gagal disimpan. Nama project tidak ada dalam system.";
                $this->show_pattern($message);
                return;
            }else{
                $database_input_array['project_id'] = $project_detail['id'];
            }

            // check if there is any duplicate
            $duplicate_check = $this->warna_model->get_project_by_name($database_input_array['project_id']);

            if(empty($duplicate_check)){
                $response = $this->warna_model->set_project_warna($database_input_array);

                if($response){
                    $message['success'] = "Project berhasil disimpan.";
                    $this->show_pattern($message);
                }else{
                    $message['error'] = "Project gagal disimpan.";
                    $this->show_pattern($message);
                }
            }else{
                $message['error'] = "Project gagal disimpan. Project sudah ada dalam system.";
                $this->show_pattern($message);
            }
        }else{
            $message['error'] = "Project gagal disimpan.";
            $this->show_pattern($message);
        }
    }

    public function view_project_warna()
    {
        $message = array();
        $uri = $this->uri->segment(3);
        $this->show_subproject_warna($message, $uri);
    }

    public function show_subproject_warna($message, $uri)
    {
        $user_id = $this->tank_auth->get_user_id();
        
            $user_info = $this->login_model->get_user_info($user_id);
            $data['userid'] = $user_info['id'];
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            $data['project'] = $user_info['project'];
            $data['uri'] = $uri;

            // access level
            $create=substr($data['project'],0,1); 
            $edit=substr($data['project'],1,1); 
            $delete=substr($data['project'],2,1); 
            
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
            $data['subpattern'] = $this->warna_model->get_all_pattern_subproject($uri);
            $data['subgambar'] = $this->warna_model->get_all_gambar_subproject($uri);

            // show the view
            $this->load->view('header');
            $this->load->view('warna/navigation', $data);
            $this->load->view('warna/patternsubproject', $data);
            $this->load->view('warna/footer');
    }

    public function create_subproject_warna($uri){
        // check all necessary input
        if(!empty($this->input->post('subproject_name'))){
            // search for customer id
            $database_input_array = array();

            // get the warna start date
            date_default_timezone_set('Asia/Jakarta');

            $subproject_detail = $this->subproject_model->get_subproject_by_name($this->input->post('subproject_name'));
            if(empty($subproject_detail)){
                $message['error'] = "SubProject gagal disimpan. Nama subproject tidak ada dalam system.";
                $this->show_subproject_warna($message);
                return;
            }else{
                $database_input_array['subproject_id'] = $subproject_detail['id'];
            }

            $database_input_array['project_id'] = $this->input->post('projectid');

            // check if there is any duplicate
            $duplicate_check = $this->warna_model->get_subproject_by_name($database_input_array['subproject_id']);

            if(empty($duplicate_check)){
                $response = $this->warna_model->set_subproject_warna($database_input_array);

                if($response){
                    $message['success'] = "SubProject berhasil disimpan.";
                    $this->show_subproject_warna($message, $uri);
                }else{
                    $message['error'] = "SubProject gagal disimpan.";
                    $this->show_subproject_warna($message, $uri);
                }
            }else{
                $message['error'] = "SubProject gagal disimpan. SubProject sudah ada dalam system.";
                $this->show_subproject_warna($message, $uri);
            }
        }else{
            $message['error'] = "SubProject gagal disimpan.";
            $this->show_subproject_warna($message, $uri);
        }
    }

    public function upload_subproject_warna()
    {
        $config = array(
                'upload_path' => 'uploads/gambar/',
                'allowed_types' => 'gif|jpg|jpeg|png',
                'max_size' => '1024',
                'max_width' => '600',
                'max_height' => '600'
            );
        $this->load->library('upload', $config);
        
        $idsubproject = $this->input->post('id');
        $file = $this->input->post('file');
        // $filename = $this->upload->data('file');
        // $gambar = $filename['file_name'];
        if(!$this->upload->do_upload('file')){
            $output = json_encode(array('error' => $this->upload->display_errors(), 'file'=> $file));
        }else{
            $data_upload = $this->upload->data();

            $file_name = $data_upload['file_name'];
            $file_name_thumb = $data_upload['raw_name'].'_thumb' . $data_upload['file_ext'];

            
            $config_resize['image_library'] = 'gd2';    
            $config_resize['create_thumb'] = TRUE;
            $config_resize['maintain_ratio'] = TRUE;
            $config_resize['source_image'] = 'uploads/gambar/'. $file_name;
            $config_resize['width'] = 75;
            $config_resize['height'] = 50;
            
            $this->load->library('image_lib', $config_resize);
            
            $this->image_lib->resize();

            // $data["file_name_url"] = base_url() . $user_upload_path . $file_name;
            // $data["file_name_thumb_url"] = base_url() . $user_upload_path . $file_name_thumb;
    
            //$config['new_image'] = 'uploads/gambar/thumbs/'.$gambar;

            $this->warna_model->uploadSubprojectPhoto($idsubproject, $file_name);
            $output = json_encode(array('upload_data' => $this->upload->data()));
        }
        die($output);
    }

    public function get_subproject_warna_detail($subproject_id){
        date_default_timezone_set('Asia/Jakarta');

        $subproject_id = urldecode($subproject_id);
        $subproject_detail = $this->warna_model->get_subproject_warna_by_id($subproject_id);
        echo json_encode($subproject_detail);
    }

    public function view_patterngambar_warna()
    {
        $message = array();
        $uri = $this->uri->segment(3);
        $this->show_patterngambar_warna($message, $uri);
    }

    public function show_patterngambar_warna($message, $uri)
    {
        $user_id = $this->tank_auth->get_user_id();
        
            $user_info = $this->login_model->get_user_info($user_id);
            $data['userid'] = $user_info['id'];
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            $data['project'] = $user_info['project'];
            $data['uri'] = $uri;

            // access level
            $create=substr($data['project'],0,1); 
            $edit=substr($data['project'],1,1); 
            $delete=substr($data['project'],2,1); 
            
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
            $data['gambar'] = $this->warna_model->get_all_gambar_by_id($uri);
            $data['warna'] = $this->warna_model->get_all_warnas();
            $data['pattern'] = $this->warna_model->get_all_pattern_warna($uri);
            
            // show the view
            $this->load->view('header');
            $this->load->view('warna/navigation', $data);
            $this->load->view('warna/view_pattern_warna', $data);
            $this->load->view('warna/footer');
    }

    public function create_pattern_warna(){
        // check all necessary input
        if(!empty($this->input->post('id'))){
            // search for customer id
            
            $database_input_array = array();

            $database_input_array['uri'] = $this->uri->segment(3);

            $database_input_array['warna_id'] = $this->input->post('id');

            // get the warna start date
            date_default_timezone_set('Asia/Jakarta');

            // check if there is any duplicate
            $duplicate_check = $this->warna_model->get_pattern_by_id($database_input_array['warna_id'], $database_input_array['uri']);

            if(empty($duplicate_check)){
                $response = $this->warna_model->set_pattern_warna($database_input_array);

                if($response){
                    $message['success'] = "Pattern berhasil disimpan.";
                    $this->view_pattern($message);
                }else{
                    $message['error'] = "Pattern gagal disimpan.";
                    $this->view_pattern($message);
                }
            }else{
                $message['error'] = "Pattern gagal disimpan. Pattern sudah ada dalam system.";
                $this->view_pattern($message);
            }
        }else{
            $message['error'] = "Pattern gagal disimpan.";
            $this->view_pattern($message);
        }
    }

    public function cetak()
    {
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
            //$idpj = $idproject;
            $uri = $this->uri->segment(3);
            $data['pattern'] = $this->warna_model->get_all_pattern_warna($uri);
            $data['subproject'] = $this->warna_model->get_all_subproject($uri);

        $this->load->view('warna/eksport_pdf', $data);
        
    }

    public function delete_pattern(){
        $id = $this->input->post('id');
        $response = $this->warna_model->delete_pattern($id);

        // display message according db status
        if($response){
            $message['success'] = "warna berhasil dihapus.";
            $this->view_pattern($message);
        }else{
            $message['error'] = "warna gagal dihapus.";
            $this->view_pattern($message);
        }
    }

    public function view_pattern()
    {
        $message = array();
        $uri = $this->uri->segment(3);
        $this->show_patternadd($message, $uri);
    }

    public function show_patternadd($message, $uri)
    {
        $user_id = $this->tank_auth->get_user_id();
        
            $user_info = $this->login_model->get_user_info($user_id);
            $data['userid'] = $user_info['id'];
            $data['username'] = $user_info['name'];
            $data['company_title'] = $user_info['title'];
            $data['project'] = $user_info['project'];
            $data['uri'] = $uri;

            // access level
            $create=substr($data['project'],0,1); 
            $edit=substr($data['project'],1,1); 
            $delete=substr($data['project'],2,1); 
            
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
            $data['gambar'] = $this->warna_model->get_all_gambar_by_id($uri);
            $data['warna'] = $this->warna_model->get_all_warnas();
            $data['pattern'] = $this->warna_model->get_all_pattern_warna($uri);
            
            // show the view
            $this->load->view('header');
            $this->load->view('warna/navigation', $data);
            $this->load->view('warna/view_pattern', $data);
            $this->load->view('warna/footer');
    }

}

/* End of file warna.php */
/* Location: ./application/controllers/warna.php */