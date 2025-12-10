<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Forgotpassword extends Common_Data_Controller {
	// Variable Declaration Here
	public $headerPage      = '../../views/header';
	public $footerPage      = '../../views/footer';
	public $listPage        = 'forgotpassword';
	public $forgot_redirect = 'forgotpassword';

	public function __construct() 
	{
    parent::__construct();
		$this->load->model('Common_model','common_model'); 
		$this->load->model('Forgotpassword_model','my_model'); 
 		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(-1);
		ini_set('display_errors','on'); 
		$this->load->library('email');
  }
	
	
	
	/*public function index(){
		
		if($this->input->post('submit')!=''){
			
			
			if($this->my_model->email_check() != 0){ 

				$pwddigt  =  substr(rand(1,1000000),0,4); 
				$pwdchar  =   substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUXYVWZ"), 0, 4); 
				$password =   $pwdchar.$pwddigt;
				$changepass=$this->my_model->change_password($password,$this->input->post('email'));
				if($changepass){
				
					$this->load->library('email');
					$this->email->from('info@telugupickles.in', 'Telugupickles.in');
					$this->email->to($this->input->post('email')); 
					$this->email->subject('Your New Password');
					$this->email->message(" Your new password is :".$password."");	
					$this->email->send();
					
				$this->session->set_flashdata( 'msg_succ', 'Password sent to your Email');
				redirect($this->forgot_redirect);
				}
			}else{		
				$this->session->set_flashdata( 'msg_succ', 'Invalid Email Id...');
				redirect($this->forgot_redirect);
			}
		}
		
		$header['web_settings'] = $this->common_model->get_all_websettings();
		$header['menu']         = $this->common_model->get_all_menu();
		$this->load->view($this->headerPage,$header);
		$this->load->view($this->listPage);
		$footer['web_settings'] = $this->common_model->get_all_websettings();
		$this->load->view($this->footerPage,$footer);
	}*/
	
	public function reset_password()
	{
		if($this->input->post('submit')!='')
		{
			$exists = $this->my_model->get_exists_data($this->input->post('email'));
			if(!empty($exists['email']))
			{
				$code = md5(uniqid(rand(), true));
				$result = $this->my_model->update_verification_code($code);
				if($result)
				{
					$msg = "\n\n\n <a href='".site_url()."forgotpassword/configure_mypassword/".$exists['id']."/".$code."'>RESET PASSWORD</a>";
					$this->emailssend($msg);
					$this->session->set_flashdata( 'msg_succ', 'To Configure new password check your mail');
					redirect("forgotpassword/reset_password");
				}	
				else
				{
					$this->session->set_flashdata( 'msg_fail', 'Please Try Again');
					redirect("forgotpassword/reset_password");
				}
			}
			else
			{
				$this->session->set_flashdata( 'msg_fail', 'Email Not Found');
				redirect("forgotpassword/reset_password");
			}	
					
		}
		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
		$this->load->view($this->listPage, $data);
		$this->load->view($this->footerPage,$data);
	}
	
	
	function emailssend($msg)
	{
		$this->email->from('donthanareshgoud@gmail.com', 'KLAKS');
		$this->email->to($this->input->post('email'));
		$this->email->set_mailtype("html");
		$this->email->subject("FORGOT PASSWORD");
		$this->email->message($msg);
		return	$result=$this->email->send();
	}
	
	
	public function configure_mypassword($id,$code)
	{
		
		$emp_data       = $this->my_model->get_single_data($id); 
		$data['record'] = $this->my_model->get_single_data($id); 
		/*echo "<pre>";print_r($data['record']);exit;*/
		if($emp_data['v_code']==$code)
		{  
			if($this->input->post('submit')!='')
			{
				
				$changepass=$this->my_model->change_password_change($id);
				
					if($changepass)
					{
						$code = md5(uniqid(rand(), true));
						$this->my_model->update_verification_code_id($id,$code);
						$this->session->set_flashdata('msg_succ', 'Password Changed Successfully, Login with your new password...');
						redirect("login");
					}
					else
					{
						$this->session->set_flashdata('msg_succ', 'Sorry! Try Again');
						redirect("forgotpassword/configure_mypassword/".$id."/".$code);
					}
				
			}
			$data = $this->commonData; // get common data
		  $this->load->view($this->headerPage,$data);
			$this->load->view("newpassword",$data);
		  $this->load->view($this->footerPage,$data);
		}
		else
		{
			$data = $this->commonData; // get common data
			$this->load->view($this->headerPage,$data);
			$this->load->view($this->listPage,$data);
			$this->load->view($this->footerPage,$data);
		}
		
	}

}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */