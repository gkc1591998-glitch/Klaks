<?php
class Logout extends CI_Controller{

	public $login_redirect = '/admin/index';

	public function __construct(){
		parent::__construct();
        $this->load->library('session');
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off'); 
	}

    public function index() 
	{

			$user_data = $this->session->all_userdata();
			foreach ($user_data as $key => $value) {
					$this->session->unset_userdata($key);
			}
			$this->session->unset_userdata('user');
			$this->session->unset_userdata('developed_by');
			$this->session->sess_destroy();
			redirect($this->login_redirect,'refresh');

   }
}