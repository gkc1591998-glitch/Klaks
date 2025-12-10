<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contactus extends Common_Data_Controller {
	public $headerPage = '../../views/header';
	public $footerPage = '../../views/footer';
	public $listPage   = 'contactus';
	public $searchPage = 'search';
	
	public function __construct() {
    parent::__construct();
		$this->load->model('Common_model','common_model');
		$this->load->model('Contactus_model','contact_model');
		$this->load->library('email');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(-1);
		ini_set('display_errors','on'); 
  }
	
	public function index(){
		
		if($this->input->post('submit')!='')
		{
			if($this->form_validation->run('contactus')==TRUE){
      /*echo "<pre>";print_r($_POST);exit;*/
			$result = $this->contact_model->add_contact();
			if($result)
			{
               $message = 'Name: ' . $this->input->post('name') . "\n\n" . 'Email: ' . $this->input->post('email') . "\n\n" . 'Mobile: ' . $this->input->post('mobile') . "\n\n" . 'Message: ' . $this->input->post('message');
				
				
				$this->email->from($this->input->post('email'), $this->input->post('name'));
				$this->email->to('info@klaks.com'); 
				$this->email->subject('Klaks Contact Us form');
				$this->email->message($message);	
				$this->email->send();

				$this->session->set_flashdata('msg_succ', 'Contacted Successfully, We will get back to you...');
				redirect(site_url()."contactus");
			}
			else
			{
				$this->session->set_flashdata('msg_succ', 'Failed Try Again');
				redirect(site_url()."contactus");
			}
		  }
		}	
		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
		$this->load->view($this->listPage,$data);
		$this->load->view($this->footerPage,$data);
	}
}
