<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Scriptupdatecode extends CI_Controller
	{
		public function __construct()
    	{
        	parent::__construct();
        	$this->load->model('scriptupdatecode_model');
        }

        public function index()
        {
        	$this->scriptupdatecode_model->updateitemcode();
        }

	} 
?>