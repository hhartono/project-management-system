<?php
class Absensi extends CI_Controller{
  
  public function __construct()
  { 
    parent::__construct();
    $this->load->helper(array('form'));
    $this->load->model('absensi_model');
    $this->load->model('login_model');
    $this->load->model('project_model');
    $this->load->helper('cookie');
    $this->load->helper('url');
    $this->load->library('tank_auth');
    $this->lang->load('tank_auth');
    $this->_is_logged_in();
  }

  public function index()
  {
    $message = array();
    $this->show_table($message);
  }

  public function upload()
  {
    $user_id    = $this->tank_auth->get_user_id();
    $user_info = $this->login_model->get_user_info($user_id);
    $data['userid'] = $user_info['id'];
    $data['username'] = $user_info['name'];
    $data['company_title'] = $user_info['title']; 

    $this->load->view('header');
    $this->load->view('absensi/navigation', $data);
    $this->load->view('absensi/absensi', array('error' => ' ' ));
    $this->load->view('absensi/footer');    
  }

  public function do_upload()
  {   
    $user_id    = $this->tank_auth->get_user_id();
  
    $user_info = $this->login_model->get_user_info($user_id);
    $datau['userid'] = $user_info['id'];
    $datau['username'] = $user_info['name'];
    $datau['company_title'] = $user_info['title'];   
    
    $config = array(
      'upload_path' => "assets/absensi/",
      'allowed_types' => "csv",
      'file_name'     => "absensi",
      'overwrite' => TRUE,
      'max_size' => "1024", // Can be set to particular file size , here it is 2 MB(2048 Kb)
    );
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    if ( ! $this->upload->do_upload())
    {
      $error = array('error' => $this->upload->display_errors());
      $this->load->view('header');
      $this->load->view('absensi/navigation', $datau);
      $this->load->view('absensi/absensi', $error);
      $this->load->view('absensi/footer');
    }
    else
    {
      $txt_file = file_get_contents('assets/absensi/absensi.csv');
      $pesan = preg_replace("/((\r?\n)|(\r\n?))/", ']',$txt_file); 
      $rows = explode("]", $pesan);
      $filteredarray = array_values( array_filter($rows) );
      //print_r($filteredarray);
      //print_r($rows);
      array_shift($filteredarray);  
      
      foreach($filteredarray as $row => $data)
      {
        $row_data = preg_split('/,/', $data);
        $data1 = isset($row_data[1]) ? $row_data[1] : null;
        $data3 = isset($row_data[3]) ? $row_data[3] : null;
        $data4 = isset($row_data[5]) ? $row_data[5] : null;
        $data6 = isset($row_data[9]) ? $row_data[9] : null;
        $data7 = isset($row_data[10]) ? $row_data[10] : null;
        $data8 = isset($row_data[25]) ? $row_data[25] : null;
        $data9 = isset($row_data[16]) ? $row_data[16] : null;
        $data10 = isset($row_data[17]) ? $row_data[17] : null;
        
        $datas = array(
          'idabsensi' => $data1,
          'name' => $data3,
          'date' => date("Y-m-d", strtotime($data4)),
          'jam_datang' => $data6,
          'jam_pulang' => $data7,
          'count_time' => $data8,
          'lembur' => $data9,
          'jumlah_jam_kerja' => $data10,
          'jumlah_kehadiran' => $data8
        );
        $this->db->insert('absensi', $datas);
      }  
    }
      $data = array('upload_data' => $this->upload->data());
      $this->load->view('header');
      $this->load->view('absensi/navigation', $datau);
      $this->load->view('absensi/upload_success', $data);
      $this->load->view('absensi/footer');

  }

  public function show_table()
  {   
    $user_id    = $this->tank_auth->get_user_id();
    
    $user_info = $this->login_model->get_user_info($user_id);
    $data['userid'] = $user_info['id'];
    $data['username'] = $user_info['name'];
    $data['company_title'] = $user_info['title']; 

    //$data['message'] = $message;

    $data['absensi'] = $this->absensi_model->get_all_absensi();
    //$data['proabs'] = $this->absensi_model->get_project_absensi();
    $data['getpro']=$this->absensi_model->get_all_project();
    $data['upload'] = $this->absensi_model->get_absensi_upload(); 
    $this->load->view('header');
    $this->load->view('absensi/navigation', $data);
    $this->load->view('absensi/lihat', $data);
    $this->load->view('absensi/footer');
  }

  public function show_table_project()
  {   
    $user_id    = $this->tank_auth->get_user_id();
  
    $user_info = $this->login_model->get_user_info($user_id);
    $data['userid'] = $user_info['id'];
    $data['username'] = $user_info['name'];
    $data['company_title'] = $user_info['title']; 

    //$data['message'] = $message;

    $this->load->view('header');
    $this->load->view('absensi/navigation', $data);
    $this->load->view('absensi/cari', $data);
    $this->load->view('absensi/footer');
    
  }

  public function cari() {
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

    $data['absensi']=$this->absensi_model->caridata();
    //$data['absensi'] = $this->absensi_model->get_all_absensi();
    $data['getpro']=$this->absensi_model->get_all_project();
    //$data['getproject']=$this->absensi_model->getproject1();
    
    //$data['getcompany'] = $this->detail_model->get_company();
      
    $this->load->view('header');
    $this->load->view('absensi/navigation', $data);
    $this->load->view('absensi/lihat',$data); 
    $this->load->view('absensi/footer');
  }

  public function update_projectworker(){
    // check all necessary input
    if(!empty($this->input->post('id')))
    {
      // search for customer id
      $database_input_array = array();
      
      $database_input_array['subproject_id'] = $this->input->post('subproject');
      
      // database id
      $database_input_array['id'] = $this->input->post('id');

      // store project information
      $response = $this->absensi_model->update_projectworker($database_input_array);

      if($response){
          $message['success'] = "Project Worker berhasil diubah.";
          $this->show_table($message);
      }else{
          $message['error'] = "Project Worker gagal diubah.";
          $this->show_table($message);
      }
    }else{
      $message['error'] = "Project Worker gagal diubah.";
      $this->show_table($message);
    }
  }

  public function projectdetail_worker() {
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

    $data['absensi'] = $this->absensi_model->count_time();
    $data['getpro']=$this->absensi_model->get_all_project();
      
    $this->load->view('header');
    $this->load->view('absensi/navigation', $data);
    $this->load->view('absensi/maindetail',$data); 
    $this->load->view('absensi/footer');
  }

  public function caribulan() {
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

    $data['absensi']=$this->absensi_model->count_time_filter();
    //$data['absensi'] = $this->absensi_model->get_all_absensi();
    $data['getpro']=$this->absensi_model->get_all_project();
    //$data['getproject']=$this->absensi_model->getproject1();
    
    //$data['getcompany'] = $this->detail_model->get_company();
      
    $this->load->view('header');
    $this->load->view('absensi/navigation', $data);
    $this->load->view('absensi/maindetail',$data); 
    $this->load->view('absensi/footer');
  }

  public function detail_worker(){
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
    $data['detail'] = $this->absensi_model->detail_worker();
    $this->load->view('header');
    $this->load->view('absensi/navigation', $data);
    $this->load->view('absensi/detail_worker', $data);
    $this->load->view('absensi/footer');
  }

  public function _is_logged_in(){
      if(!$this->tank_auth->is_logged_in()){
          redirect('/auth/login');
      }
  }

  public function tugastukang()
  {   
    $user_id    = $this->tank_auth->get_user_id();
    
    $user_info = $this->login_model->get_user_info($user_id);
    $data['userid'] = $user_info['id'];
    $data['username'] = $user_info['name'];
    $data['company_title'] = $user_info['title']; 

    //$data['message'] = $message;

    $data['absensi'] = $this->absensi_model->get_all_absensi_group();
    //$data['proabs'] = $this->absensi_model->get_project_absensi();
    $data['getpro']=$this->absensi_model->get_all_project(); 
    $this->load->view('header');
    $this->load->view('absensi/navigation', $data);
    $this->load->view('absensi/tugastukang', $data);
    $this->load->view('absensi/footer');
  }

  public function update_projectworkergrup(){
    // check all necessary input
    if(!empty($this->input->post('id')))
    {
      // search for customer id
      $database_input_array = array();
      
      $database_input_array['subproject_id'] = $this->input->post('subproject');
      
      // database id
      $database_input_array['id'] = $this->input->post('id');

      $database_input_array['date'] = $this->input->post('date');

      // store project information
      $response = $this->absensi_model->update_projectworkergrup($database_input_array);

      if($response){
          $message['success'] = "Project Worker berhasil diubah.";
          $this->tugastukang($message);
      }else{
          $message['error'] = "Project Worker gagal diubah.";
          $this->tugastukang($message);
      }
    }else{
        $message['error'] = "Project Worker gagal diubah.";
        $this->tugastukang($message);
    }
  }
}
?>