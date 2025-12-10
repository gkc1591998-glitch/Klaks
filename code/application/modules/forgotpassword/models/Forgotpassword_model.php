<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Forgotpassword_model extends CI_Model {
	// Variable Declaration Here
	public $content = 'tbl_content';
	public $table_name = 'tbl_register';
	
	// Autoloading a system library usin constructor method
	public function __construct() {
    parent::__construct();
 		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(1);
		ini_set('display_errors','on'); 
  }
  
	public function getUser($data) {
		$result = array();
		$this->db->select("*");
		$this->db->where('email', $data['email']);
		$this->db->where('password', $data['password']);
		$this->db->where('status', 1);
		$query = $this->db->get($this->table_name);
    if ($query->num_rows() > 0):
    	$result = $query->row_array();
		else:
			$result = FALSE;
    endif;
		return $result;
  }
	
	public function email_check(){
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->where('email',$this->input->post('email'));
		$result=$this->db->get();
		return $result->num_rows();	
	}
	
	public function activate_user(){
		
		$datac = array(
		    'online_status'=>1,
			'lastlog'=>date('Y-m-d H:i:s')
		);
		$this->db->where('id',$this->session->userdata('user_id'));
    $result = $this->db->update($this->table_name, $datac);
		return $result;
	}
	
	public function dectivate_user(){
		
		$datac = array(
		    'online_status'=>0
		);
		$this->db->where('id',$this->session->userdata('user_id'));
    $result = $this->db->update($this->table_name, $datac);
		return $result;
	}
	
	public function change_password($password,$email)
	{
		$datac = array(
		    'password'=>$password
		);
		$this->db->where('email',$email);
    $result = $this->db->update($this->table_name, $datac);
		return $result;
	}
	
		public function get_exists_data($email) 
	    {
			$this->db->select("email,id");
			$this->db->from($this->table_name);
			$this->db->where('email', $email);
			$query = $this->db->get();
			$result = $query->row_array();
			return $result;
		}
		
		public function update_verification_code($code)
		{
			$set_data = array(
 		       'v_code' => $code,
			 );
			$this->db->where('email',$this->input->post('email'));
			$result = $this->db->update($this->table_name,$set_data);
			return $result;
		}
		
		public function get_single_data($id) 
	    {
			$this->db->select("*");
			$this->db->from($this->table_name);
			$this->db->where('id', $id);
			$query = $this->db->get();
			$result = $query->row_array();
			return $result;
		}
		
		 public function change_password_change($id)
		 {
			$datac = array
			(
				'password' => $this->input->post('confirm_password')
			);
      /*echo "<pre>";print_r($datac);exit;*/
			$this->db->where('id',$id);
			$result = $this->db->update($this->table_name, $datac);
			return $result;
		 }
		 
		public function update_verification_code_id($id,$code)
		{
			$set_data = array(
 		       'v_code' => $code,
			 );
			$this->db->where('id',$id);
			$result = $this->db->update($this->table_name,$set_data);
			return $result;
		}
}
?>