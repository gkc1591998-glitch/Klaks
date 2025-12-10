<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Guestlogin_model extends CI_Model {

	public function __construct() 
	{
        parent::__construct();
    }


    public function getUser($data) 
	{
		$result = array();
		$this->db->select("*");
		$this->db->where('fname', $data['fname']);
		$this->db->where('mobile', $data['mobile']);
		$this->db->where('status', 1);
		$query = $this->db->get("tbl_register");
		/*echo $this->db->last_query();exit;*/
    if ($query->num_rows() > 0):
      $result = $query->row_array();
		else:
			$result = FALSE;
    endif;
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

		public function get_exists_data($email) 
	    {
			$this->db->select("mobile,id");
			$this->db->from("tbl_register");
			$this->db->where('mobile',$email);
			$query = $this->db->get();
			$result = $query->row_array();
			return $result;
		}

     public function get_mysqli()
	{
       $db = (array)get_instance()->db;
       return mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
    }


}
