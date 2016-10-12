<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Intivo extends CI_Controller{

    public function __construct(){
        parent::__construct();

        $this->load->model('blg_model');
        $this->load->model('customer_model');
        $this->load->model('login_model');
        $this->load->helper(array('form', 'cookie', 'url', 'date'));
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->_is_logged_in();
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

    public function create_item(){
        if($this->input->post('group')){
            // check if there is any duplicate
            $duplicate_check = $this->blg_model->get_item_by_group_name($this->input->post('group'));

            if(empty($duplicate_check)){
                $response = $this->blg_model->set_item();
            
                if($response){
                    $message['success'] = "Item set berhasil disimpan.";
                    $this->show_table($message);
                } else{
                    $message['error'] = "Item set gagal disimpan.";
                    $this->show_table($message);
                }
            } else{
                $message['error'] = "Item set gagal disimpan. Item set sudah ada di dalam system";
                $this->show_table($message);
            }
        } else{
            $message['error'] = "Item set gagal dsimpan.";
            $this->show_table($message);
        }
    }

    public function update_item(){
        $response = $this->blg_model->update_item();

        if($response){
            $message['success'] = "Item berhasil diubah.";
            $this->show_table($message);
        } else{
            $message['error'] = "Item gagal diubah.";
            $this->show_table($message);
        }
    }

    public function delete_item($id){
        $response = $this->blg_model->delete_item($id);

        // display message according to db status
        if($response){
            $message['success'] = "Item berhasil dihapus";
            $this->show_table($message);
        } else{
            $message['error'] = "Item gagal dihapus";
            $this->show_table($message);
        }
    }

    public function get_item_detail($id){
        $id = urldecode($id);
        $item_detail = $this->blg_model->get_item_by_id($id);
        echo json_encode($item_detail);
    }

    public function upload_image(){
        $config['upload_path']   = './assets/images/intivo/';
        $config['allowed_types'] = 'png|jpg';
        $config['file_ext']      = 'png|jpg';
        $config['max_size']      = '2048000';
        $config['max_width']     = '1024';
        $config['max_height']    = '768';
        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('image')){
            $message['error'] = array('error' => $this->upload->display_errors());
            $this->show_table($message);
        } else {
            $id_image = $this->input->post('id_image');
            $idt = $this->blg_model->get_item_by_id($id_image);
            //insert image 
            if(empty($idt['blg_img_path'])){
                $data = $this->upload->data();
                $file = array(
                    'blg_img_path' => $config['upload_path'].$data['file_name'],
                    'creation_date' => date("Y-m-d H:i:s")
                );
                $this->blg_model->upload_image($file, $id_image);
                $message['success'] = 'Gambar berhasil disimpan';
            } //edit image
            else if(!empty($idt['blg_img_path'])){
                $data = $this->upload->data();
                $file = array(
                    'blg_img_path' => $config['upload_path'].$data['file_name'],
                    'last_update_timestamp' => date("Y-m-d H:i:s")
                );
                $this->blg_model->upload_image($file, $id_image);
                $message['success'] = 'Gambar berhasil diubah';
            }
            $this->show_table($message);
        }
    }

    public function get_parts_count(){
        $code = $this->input->post('code');
        $sum = $this->blg_model->get_parts_count($code);
        echo '<option value="">Jumlah Parts</option>';
        foreach($sum as $row){ 
            echo '<option value ="' .$row['blg_parts_quantity']. '">' .$row['blg_parts_quantity']. '</option>';
        }
    }

    public function get_parts_last(){
        $code = $this->input->post('code');
        $sum = $this->input->post('sum');
        $sel_group = $this->blg_model->get_group_first($code, $sum);

        foreach($sel_group as $groups){
            $par[] = $groups['blg_group_name']; 
        }

        $par1 = !empty($par[0]) ? $par[0] : null; 
        $par2 = !empty($par[1]) ? $par[1] : null;
        $par3 = !empty($par[2]) ? $par[2] : null;
        $unq_par = $this->blg_model->get_unique_param($par1, $par2, $par3);
        echo '<option value="">Kode Barang (Unik)</option>';
        foreach($unq_par as $row){ 
            echo '<option value ="' .$row['code']. '">' .$row['code']. ' || ' .$row['group_name']. '</option>';
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

        if($addImg != 0){
            $data['access']['addImg'] = true;    
        }else{
            $data['access']['addImg'] = false;               
        }

        // message
        $data['message'] = $message;

        // get necessary data
        $form_input = $this->input->get('search');

        if($this->input->get() == false){
            $data['code_1'] = $this->blg_model->get_parts_dropdown();
            $data['group'] = $this->blg_model->get_all_items();

            // show the view
            $this->load->view('header');
            $this->load->view('intivo/navigation', $data);
            $this->load->view('intivo/main', $data);
            $this->load->view('intivo/footer');
        } else if($this->input->get() == true){
            $code = $this->input->get('code');
            $parts_sum = $this->input->get('parts_sum');
            $unq_code = $this->input->get('unq_code');

            //filling ddl1 in (group's code)
            $data['code_1'] = $this->blg_model->get_parts_dropdown();

            if($form_input == 'Search'){
                //jika DDL 1 tidak kosong dan DDL 2 tidak kosong
                if(!empty($code) && !empty($parts_sum) && !empty($unq_code)){
                    $data['group'] = $this->blg_model->final_search($code, $parts_sum, $unq_code);

                } else if (!empty($code) && !empty($parts_sum) && empty($unq_code)){
                    //message : kode unik kosong
                    $message['error'] = "Isi kode unik barang";
                    $data['message'] = $message;
                    $data['group'] = $this->blg_model->get_all_items();

                } else if (!empty($code) && empty($parts_sum) && !empty($unq_code)){
                    //message : jml parts masih kosong
                    $message['error'] = "Isi jumlah parts";
                    $data['message'] = $message;
                    $data['group'] = $this->blg_model->get_all_items();

                } else if (!empty($code) && empty($parts_sum) && empty($unq_code)){
                    //message : jumlah parts, kode unik masih kosong
                    $message['error'] = "Isi jumlah parts dan kode unik barang";
                    $data['message'] = $message;
                    $data['group'] = $this->blg_model->get_all_items();

                } else if (empty($code) && empty($parts_sum) && !empty($unq_code) ){
                    //message : kode barang, jumlah parts
                    $message['error'] = "Isi kode barang dan jumlah parts";
                    $data['message'] = $message;
                    $data['group'] = $this->blg_model->get_all_items();

                } else if (empty($code) && empty($parts_sum) && empty($unq_code)){
                    //message : kode Barang, jumlah parts dan kode unik masih kosong
                    $message['error'] = "Isi kode barang, jumlah parts dan kode unik barang";
                    $data['message'] = $message;
                    $data['group'] = $this->blg_model->get_all_items();
                }                    
            }
            // show the view
            $this->load->view('header');
            $this->load->view('intivo/navigation', $data);
            $this->load->view('intivo/main', $data);
            $this->load->view('intivo/footer');  
        }
    }
}

/* End of file intivo.php */
/* Location: ./application/controllers/intivo.php */
