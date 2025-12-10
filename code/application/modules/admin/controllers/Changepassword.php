<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Changepassword extends CI_Controller {

	public $headerPage = 'admin_header';

	public $changepassword = 'changepassword';

	public function __construct()

	{

		parent::__construct();

		$this->load->model('Changepassword_model','my_model');

		$this->load->library('email');

		

	}

	

	public function index()

	{

		if($this->input->post('submit')!=''){

			//echo '<pre>'; print_r($_POST);exit;

			

		if($this->my_model->password_check() != 0)

		{ 

				

				$changepass=$this->my_model->change_password();

				if($changepass)

				{

						$message = " Your New Password is ".$this->input->post('confirm_password');

						$this->emailssendowner("NEW PASSWORD DETAILS",$message);

						

						$user_data = $this->session->all_userdata();

						foreach ($user_data as $key => $value) 

						{

						 if($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' ) {

								$this->session->unset_userdata($key);

						 }

						}

						

						$this->session->unset_userdata('user');

						$this->session->unset_userdata('developed_by');

						$this->session->sess_destroy();

						$this->session->set_flashdata('msg_succ', 'Password Sent to your Email Id...');

						redirect("Admin/index");

				}

				else

				{

					$this->session->set_flashdata('msg_succ', 'Sorry! Try Againn');
					$this->load->view($this->headerPage);
					redirect("admin/Changepassword");

				}	

		}

		else

		{

			$this->session->set_flashdata('msg_succ', 'Current password Incorrect');
			$this->load->view($this->headerPage);
			redirect("admin/Changepassword");

		}			

		}

		$this->load->view($this->headerPage);

		$this->load->view($this->changepassword);

	}

	

		function emailssendowner($sub,$msg)

		{

				$this->email->from("", "NEW PASSWORD");

				$this->email->to("");

				//$this->email->set_mailtype("html");

				$this->email->subject($sub);

				$this->email->message($msg);

		        return	$result=$this->email->send();

		}

}

