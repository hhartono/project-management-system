<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends CI_Controller {

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
	public function index()
	{
        $this->load->helper('url');
        $base_url = base_url();

        $data['base_url'] = $base_url;
        $data['username'] = "Hans Hartono";
        $data['company_title'] = "Chief Technology Officer";
		$this->load->view('dashboard/main', $data);
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */