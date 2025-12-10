<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Register_model extends CI_Model {
	
	public function __construct() 
	{
    parent::__construct();
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off'); 
  }
		
		public function get_profie($id=null)
		{
			$this->db->select("*");
			$this->db->from("tbl_register");
			$this->db->where('id',$this->session->userdata('user_id'));
			$query = $this->db->get();
			$result = $query->row_array();
			//echo "<pre>";print_r($result);exit;
			return $result;
		}
		
		
		public function get_contactus_address($id)
		{
			$this->db->select("*");
			$this->db->from("tbl_common");
			$this->db->where('id',$id);
			$query = $this->db->get();
			$result = $query->row_array();
			return $result;
		}
		
		public function add_registered()
		{
			$set_data = array
			(
				'fname'    => mysqli_real_escape_string($this->get_mysqli(),ucwords($this->input->post('fname',TRUE))),
				'lname'    => mysqli_real_escape_string($this->get_mysqli(),ucwords($this->input->post('lname',TRUE))),
				'email'    => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('email',TRUE)),
				'mobile'   => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('mobile',TRUE)),
				'password' => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('password',TRUE)),
				'country'  => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('country',TRUE)),
				'state'  => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('state',TRUE)),
				'city'  => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('city',TRUE)),
				'location' => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('location',TRUE)),
				'zipcode' => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('zipcode',TRUE)),
				'create_date_time' => date('Y-m-d H:i:s'),
				'status' => '1'
			);
			/*echo "<pre>";print_r($set_data);exit;*/
			$result = $this->db->insert("tbl_register",$set_data);
			return $result; 
		}


		public function edit_registered()
		{
			$set_data = array
			(
				'fname'    => mysqli_real_escape_string($this->get_mysqli(),ucwords($this->input->post('fname',TRUE))),
				'lname'    => mysqli_real_escape_string($this->get_mysqli(),ucwords($this->input->post('lname',TRUE))),
				'email'    => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('email',TRUE)),
				'mobile'   => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('mobile',TRUE)),
				// 'password' => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('password',TRUE)),
				'country'  => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('country',TRUE)),
				'state'  => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('state',TRUE)),
				'city'  => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('city',TRUE)),
				'location'  => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('location',TRUE)),
				'zipcode'      => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('zipcode',TRUE)),
				'create_date_time' => date('Y-m-d H:i:s'),
				'status' => '1'
			);
			// echo "<pre>";print_r($set_data);exit;
			$this->db->where('id',$this->session->userdata('user_id'));
			$result = $this->db->update("tbl_register",$set_data);
			return $result; 
		}
		
		public function get_exists_data($email) 
	    {
			$this->db->select("email,id");
			$this->db->from("tbl_register");
			$this->db->where('email',$email);
			$query = $this->db->get();
			$result = $query->row_array();
			return $result;
		}
		
		/*public function update_verification_code($code)
		{
			$set_data = array(
 		       'v_code' => $code,
			 );
			$this->db->where('email',$this->input->post('email'));
			$result = $this->db->update("tbl_register",$set_data);
			return $result;
		}
		
		public function get_single_data($id) 
	    {
			$this->db->select("*");
			$this->db->from("tbl_register");
			$this->db->where('id', $id);
			$query = $this->db->get();
			$result = $query->row_array();
			return $result;
		}
		
		 public function update_password_id($id,$code)
		{
			$set_data = array
			(
 		       'password' => $code,
 		       'pstatus' => 1,
			 );
			$this->db->where('id',$id);
			$result = $this->db->update("tbl_register",$set_data);
			return $result;
		} */

    public function get_mysqli()
	{
    $db = (array)get_instance()->db;
    return mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
  }
		
}
