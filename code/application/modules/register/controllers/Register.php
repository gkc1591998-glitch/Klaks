<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Register extends Common_Data_Controller {
	public $headerPage = '../../views/header';
	public $footerPage = '../../views/footer';
	public $listPage   = 'register';
	public $editPage   = 'edit';
	public $searchPage = 'search';
	
	public function __construct() {
    parent::__construct();
		$this->load->model('Common_model','common_model');
		$this->load->model('Register_model','register_model');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(-1);
		ini_set('display_errors','on');
  }
	
	public function index(){
		
		if($this->input->post('submit')!='')
		{   
			// echo "hi";exit;
      if ($this->form_validation->run('register') == TRUE) {
				// echo "<pre>";print_r($_POST);exit;
				$exists = $this->register_model->get_exists_data($this->input->post('email'));
				if(empty($exists['email']) && empty($exists['mobile']))
				{
					$result = $this->register_model->add_registered();
					if($result)
					{
						
						$this->session->set_flashdata( 'msg_succ', 'Registered Successfully...!Please Login To Continue.');
						redirect(site_url()."login");
					}
					else
					{
						$this->session->set_flashdata('msg_fail_order', 'Failed Try Again');
						redirect(site_url()."register");
					}
					
				}
				else
				{
					$this->session->set_flashdata( 'msg_fail_order', 'Email already exists, Try with another email..');
					redirect("register");
				}	
		  }		
		}

		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
		$this->load->view($this->listPage,$data);
		$this->load->view($this->footerPage,$data);
	}
	
	public function edit()
	{	
		$data['record']=$this->register_model->get_profie();
		if($this->input->post('submit')!='')
		{
			// echo "<pre>";print_r($_POST);exit;
			// if ($this->form_validation->run('edit_register') == TRUE) {

				$result = $this->register_model->edit_registered();
				if($result)
				{
					$this->session->set_flashdata( 'msg_succ', 'Profile updated Successfully...!');
					redirect(site_url()."dashboard/profile");
				}
				else
				{
					$this->session->set_flashdata('msg_fail_order', 'Failed to update. Please Try Again');
					redirect(site_url()."dashboard/profile");
			}
										
		  // }		
					
		}

		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
		$this->load->view($this->editPage,$data);
		$this->load->view($this->footerPage,$data);
	}
	
	
	public function verify_email($id,$code)
	{
		
		$emp_data = $this->register_model->get_single_data($id); 
		$data['record'] = $this->register_model->get_single_data($id); 
		if($emp_data['v_code']==$code)
		{  
			$code = rand(10,10000);
			$pass = $this->register_model->update_password_id($id,$code);
		
			if($pass)
			{
				$msg = "\n\n\n Your login details is \n\n\n Username: ".$emp_data['email']." \n\n\n Password : ".$code." ";
				$this->emailssend($msg,$emp_data['email']);
				$this->session->set_flashdata('msg_succ', 'Password Sent to your Email, Login with your email and password...');
				redirect("register");
			}
			else
			{
				$this->session->set_flashdata( 'msg_fail_order', 'Please try again...');
				redirect("register");
			}
		}
		else
		{
			$this->session->set_flashdata( 'msg_fail_order', 'Please Try again, your verification link might be expired...');
			redirect("register");
		}
	}
	
	function emailssend($msg,$email)
	{
		$this->load->library('email'); 
		$this->email->from('info@klaks.in', 'klaks');
		$this->email->to($email);
		$this->email->set_mailtype("html");
		$this->email->subject("klaks");
		$this->email->message($msg);
		$result=$this->email->send();
		return $result;
	}
}
