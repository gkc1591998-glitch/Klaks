<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class Passcode extends Common_Data_Controller {
	public $headerPage = '../../views/header';
	public $footerPage = '../../views/footer';
	public $listPage = 'passcode';
	public $listPage_redirect ='homelux';
	public $login_redirect    ='passcode';
	
	public function __construct() {
    parent::__construct();
			$this->load->model('Passcode_model','passcode_model');
			$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
			error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
			error_reporting(0);
			ini_set('display_errors','off'); 
    }
	
	public function index(){
		
		if($this->input->post('submit')!='')
		{
			$this->form_validation->set_rules('passcode', 'Passcode', 'trim|required');
			if ($this->form_validation->run() == TRUE) {
				$data = array(
					'name' => $this->input->post('passcode')
				);
				/*echo "<pre>";print_r($data);exit;*/
				$passcode_details = $this->passcode_model->getPasscode($data);
				// echo "<pre>";print_r($passcode_details);exit;
				if($passcode_details)
				{
					$newdata = array
					(
						'passcode'  => $passcode_details['name'],
						'passcode_verified' => true,
						'show_lux_products' => true,
					);
					// echo "<pre>";print_r($newdata);exit;
					$this->session->set_userdata($newdata);
					$this->session->set_flashdata( 'msg_succ', 'Passcode verified successfully.' );
					redirect($this->listPage_redirect);
				} else {
					$this->session->set_flashdata( 'msg_fails', 'Invalid Passcode.' );
					redirect($this->login_redirect);
				}
			}
	}	
	$data = $this->commonData; // get common data
	$this->load->view($this->headerPage,$data);
	$this->load->view($this->listPage, $data);
	$this->load->view($this->footerPage,$data);
	}
	
	public function logout()
	{	
		$this->session->unset_userdata('user_name');
		$this->session->unset_userdata('user_id');
		$this->session->sess_destroy();
		redirect($this->login_redirect,'refresh');
	}
	
}