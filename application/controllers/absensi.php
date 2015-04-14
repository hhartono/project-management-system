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
  }

  public function index()
  {
        $message = array();
        $this->show_table($message);
  }

  public function upload()
  {
    $user_id = $this->input->cookie('uid', TRUE);
    if($user_id){
      // user info
      $user_info = $this->login_model->get_user_info($user_id);
      $data['userid'] = $user_info['id'];
      $data['username'] = $user_info['name'];
      $data['company_title'] = $user_info['title']; 

    $this->load->view('header');
    $this->load->view('absensi/navigation', $data);
    $this->load->view('absensi/absensi', array('error' => ' ' ));
    $this->load->view('absensi/footer');
    }else{
            redirect('/login', 'refresh');
        }
  }

  public function do_upload()
  {   
  $user_id = $this->input->cookie('uid', TRUE);
  if($user_id){
      // user info
      $user_info = $this->login_model->get_user_info($user_id);
      $datau['userid'] = $user_info['id'];
      $datau['username'] = $user_info['name'];
      $datau['company_title'] = $user_info['title'];   
    
    $config = array(
      'upload_path' => "assets/absensi/",
      'allowed_types' => "txt",
      'file_name'     => "absensi",
      'overwrite' => TRUE,
      'max_size' => "1024", // Can be set to particular file size , here it is 2 MB(2048 Kb)
    );
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    if ( ! $this->upload->do_upload())
    {
      $error = array('error' => $this->upload->display_errors());
      $this->load->view('absensi/absensi', $error);
    }
    else
    {
      $txt_file = file_get_contents('assets/absensi/absensi.txt');
      $pesan = preg_replace("/((\r?\n)|(\r\n?))/", ',',$txt_file); 
      $rows = explode(",", $pesan);
      $filteredarray = array_values( array_filter($rows) );
   //print_r($filteredarray);
   //print_r($rows);
      array_shift($filteredarray);  
      
      foreach($filteredarray as $row => $data)
      {
        $row_data = preg_split('/[\s]+/', $data);
        $data3 = isset($row_data[3]) ? $row_data[3] : null;
        $data4 = isset($row_data[4]) ? $row_data[4] : null;
        $data6 = isset($row_data[6]) ? $row_data[6] : null;
        $data7 = isset($row_data[7]) ? $row_data[7] : null;

        $datas = array(
                      'name' => $data3,
                      'date' => date("Y-m-d", strtotime($data4)),
                      'on_duty' => $data6,
                      'off_duty' => $data7
                      );
        $this->db->insert('absensi', $datas);
      }  
      
      $data = array('upload_data' => $this->upload->data());
      $this->load->view('header');
      $this->load->view('absensi/navigation', $datau);
      $this->load->view('absensi/upload_success', $data);
      $this->load->view('absensi/footer');
    }
    }else{
            redirect('/login', 'refresh');
        }
  }

  public function show_table($message)
  {   
    $user_id = $this->input->cookie('uid', TRUE);
    if($user_id){
      // user info
      $user_info = $this->login_model->get_user_info($user_id);
      $data['userid'] = $user_info['id'];
      $data['username'] = $user_info['name'];
      $data['company_title'] = $user_info['title']; 

      $data['message'] = $message;

    $data['absensi'] = $this->absensi_model->get_all_absensi();
    $data['getpro']=$this->absensi_model->get_all_project(); 
    $this->load->view('header');
    $this->load->view('absensi/navigation', $data);
    $this->load->view('absensi/lihat', $data);
    $this->load->view('absensi/footer');

    }else{
            redirect('/login', 'refresh');
        }
    
  }

  public function show_table_project()
  {   
    $user_id = $this->input->cookie('uid', TRUE);
    if($user_id){
      // user info
      $user_info = $this->login_model->get_user_info($user_id);
      $data['userid'] = $user_info['id'];
      $data['username'] = $user_info['name'];
      $data['company_title'] = $user_info['title']; 

      //$data['message'] = $message;

    $this->load->view('header');
    $this->load->view('absensi/navigation', $data);
    $this->load->view('absensi/cari', $data);
    $this->load->view('absensi/footer');

    }else{
            redirect('/login', 'refresh');
        }
    
  }

  public function cari() {
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
            }else{
            redirect('login', 'refresh');
            }
    }

    public function update_projectworker(){
        // check all necessary input
        if(!empty($this->input->post('id')))
        {

            // search for customer id
            $database_input_array = array();
            
            $database_input_array['project_id'] = implode(", ", $this->input->post('project'));
            
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
}
?>