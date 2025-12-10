<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Guestlogin extends Common_Data_Controller {
	public $headerPage = '../../views/header';
	public $footerPage = '../../views/footer';
	public $listPage = 'guestlogin';
	public $searchPage        = 'search';
	public $listPage_redirect ='guestlogin';
	public $login_redirect    ='home';
	public $reDirect = 'checkout/payment/';
	
	public function __construct() 
	{
    parent::__construct();
		$this->load->model('Common_model','common_model');
		$this->load->model('Guestlogin_model','my_model');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(-1);
		ini_set('display_errors','on'); 
  }
	
	public function index()
	{
		if($this->input->post('submit')!='')
		{
			/*$exists = $this->my_model->get_exists_data($this->input->post('mobile'));
			if(empty($exists['mobile']))
			{*/
			   $this->my_model->add_registered();
			   $data = array(
							'fname'  => $this->input->post('fname'),
							'mobile' => $this->input->post('mobile'),
						 );
				$user_details = $this->my_model->getUser($data);
			    if($user_details)
				{
					    $newdata = array
						(
							'user_name'  => $user_details['fname'],
							'user_id'    => $user_details['id'],
						);
				   /*echo "<pre>";print_r($newdata);exit;*/
				   $this->session->set_userdata($newdata);
                   $this->session->set_flashdata('msg_succ', 'Welcome, '.$this->session->userdata('user_name').'');
				    if(($this->session->userdata('user_id')!='') &&($this->cart->total_items() > 0))
					{
						redirect($this->reDirect);
					} else {
						redirect($this->login_redirect);
					}
				}
				else
				{
					$this->session->set_flashdata( 'msg_fails', 'Invalid Email or Password.' );
					redirect($this->listPage_redirect);
				}
			/*} else
			{
				$this->session->set_flashdata( 'msg_succ', 'Mobile already exists, Try with another Mobile..');
				redirect("guestlogin");
			}*/
		}
		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
		$this->load->view($this->listPage,$data);
		$this->load->view($this->footerPage,$data);
	}
}
