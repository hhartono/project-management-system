<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Parts extends CI_Controller{
	public $group;
    private $url;

	public function __construct(){
		parent::__construct();

		$this->load->model('login_model');
		$this->load->model('parts_model');
		$this->load->helper(array('cookie', 'url', 'date'));
		$this->load->library(array('tank_auth', 'user_agent'));
		$this->lang->load('tank_auth');
		$this->_is_logged_in();

        $this->url = base_url();
	}

	public function _is_logged_in(){
		if(!$this->tank_auth->is_logged_in()){
			redirect('/auth/login');
		}
	}

	public function index(){
		$message = array();
		$this->show_table($message);
	}

	public function create_parts(){
		$this->group = $this->input->post('group');
		if($this->input->post('group')){
			// check if there is any duplicate
			$duplicate_check = $this->parts_model->get_parts_by_group_code($this->input->post('group'), $this->input->post('code'));

			if(empty($duplicate_check)){
				$response = $this->parts_model->set_parts();
			
				if($response){
					$message['success'] = "Parts berhasil disimpan.";
					$this->show_table($message);
				} else{
					$message['error'] = "Parts gagal disimpan.";
					$this->show_table($message);
				}
			} else{
				$message['error'] = "Parts gagal disimpan. Parts sudah ada di dalam system";
				$this->show_table($message);
			}
		} else{
			$message['error'] = "Parts gagal disimpan.";
			$this->show_table($message);
		}
	}

	public function update_parts(){
		$this->group = $this->input->post('group');
		$response = $this->parts_model->update_parts();

		if($response){
			$message['success'] = "Parts berhasil diubah.";
			$this->show_table($message);
		} else{			
			$message['error'] = "Parts gagal diubah.";
			$this->show_table($message);
		}
	}

	public function delete_parts($id){
		$par = $this->parts_model->get_group_name_by_id($id);
		$this->group = implode($par,'');
		$response = $this->parts_model->delete_parts($id);

		// display message according to db status
		if($response){
			$message['success'] = "Parts berhasil dihapus";
			$this->show_table($message);
		} else{
			$message['error'] = "Parts gagal dihapus";
			$this->show_table($message);
		}
	}

	public function get_parts_detail($id){
        $id = urldecode($id);
        $parts_detail = $this->parts_model->get_parts_by_id($id);
        echo json_encode($parts_detail);
    }

    public function upload_image(){
    	$int_group = $this->input->post('group_image');
        $config['upload_path']   = './assets/images/intivo/intivo_parts/'. $int_group .'/';
        $config['allowed_types'] = 'png|jpg';
        $config['file_ext']      = 'png|jpg';
        $config['max_size']      = '2048000';
        $config['max_width']     = '1024';
        $config['max_height']    = '768';
        $this->load->library('upload', $config);
        $this->group = $int_group;

        $dir_exist = true; // flag for checking the directory exist or not
        if (!is_dir($config['upload_path'])){
	        mkdir($config['upload_path'], 0777, true);
	        $dir_exist = false; // dir not exist
    	}

        if(!$this->upload->do_upload('image')){
            $message['error'] = array('error' => $this->upload->display_errors());
            $this->show_table($message);
        } else {
            $id = $this->input->post('id_image');
            $id_image = $this->parts_model->get_parts_by_id($id);
            //insert image 
            if(empty($id_image['part_img_path'])){
                $data = $this->upload->data();
                $file = array(
                    'part_img_path' => $config['upload_path'].$data['file_name'],
                    'last_update_timestamp' => date("Y-m-d H:i:s")
                );
                $this->parts_model->upload_image($file, $id);
                $message['success'] = 'Gambar berhasil disimpan';
            } //edit image
            else if(!empty($id_image['blg_img_path'])){
                $data = $this->upload->data();
                $file = array(
                    'part_img_path' => $config['upload_path'].$data['file_name'],
                    'last_update_timestamp' => date("Y-m-d H:i:s")
                );
                $this->parts_model->upload_image($file, $id);
                $message['success'] = 'Gambar berhasil diubah';
            }
            $this->show_table($message);
        }
    }

	private function show_table($message){
		$user_id = $this->tank_auth->get_user_id();
        
        $user_info = $this->login_model->get_user_info($user_id);
        $data['userid'] = $user_info['id'];
        $data['username'] = $user_info['name'];
        $data['company_title'] = $user_info['title'];
        $data['customer'] = $user_info['customer'];
		
        // access level
        $create=substr($data['customer'],0,1);
        $addImg=substr($data['customer'],0,1);
        $edit  =substr($data['customer'],1,1);
        $delete=substr($data['customer'],2,1);
            
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

        if($addImg != 0){
            $data['access']['addImg'] = true;    
        }else{
            $data['access']['addImg'] = false;               
        }

        // message
        $data['message'] = $message;

        // get necessary data
    	if($this->agent->is_referral()){
    		$ref = $this->agent->referrer();
    		if($ref == $this->url.'intivo' || $ref == $this->url.'intivo/create_item' || $ref == $this->url.'intivo/update_item' || $ref == $this->url.'intivo/delete_item' || $ref == $this->url.'intivo/upload_image'){ //change referrer url if uploaded
				$group = $this->input->get('group');
        		$data['gn'] = $group;
        		$data['parts'] = $this->parts_model->get_parts_by_group_name($group);
    		} else{
    			$data['gn'] = $this->group;
    			$data['parts'] = $this->parts_model->get_parts_by_group_name($this->group);
    		}
		}

        // show the view
        $this->load->view('header');
        // $this->load->view('parts/navigation', $data);
        $this->load->view('navigation', $data);
        $this->load->view('parts/main', $data);
        $this->load->view('parts/footer');
    }
}

/* End of file parts.php */
/* Location: ./application/controllers/parts.php */
