<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Websettings_model extends CI_Model {

		public $table_name = "tbl_websettings";
		
		public function __construct() {
	        parent::__construct();
	 		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
			error_reporting(0);
			ini_set('display_errors','off'); 
	    }
  
	   public function get_all_records() 
	   {
			$this->db->select("*");
			$this->db->from($this->table_name);
			$this->db->where('id',1);
			$query = $this->db->get();
			$result = $query->row_array();
			return $result;
		}
		
	   public function get_single_record($id) 
	   {
			$this->db->select("*");
			$this->db->from($this->table_name);
			$this->db->where('id',$id);
			$query = $this->db->get();
			$result = $query->row_array();
			return $result;
		}	

		public function add_record()
		{
			$set_data = array(
			
		'host_name'=>mysqli_real_escape_string($this->get_mysqli(),$this->input->post('host_name')),
		'admin_email'=>mysqli_real_escape_string($this->get_mysqli(),$this->input->post('admin_email')),
		'admin_mobile'=>mysqli_real_escape_string($this->get_mysqli(),$this->input->post('admin_mobile')),
		'admin_address'=>mysqli_real_escape_string($this->get_mysqli(),$this->input->post('admin_address')),
		'status' => 1,
		'create_date_time' => date('Y-m-d H:i:s')
			
			);
			$result = $this->db->insert($this->table_name,$set_data);
			return $result;
		}		
		
		
		public function edit_record($id)
		{
			$set_data = array(
			
		'host_name'=>mysqli_real_escape_string($this->get_mysqli(),$this->input->post('host_name')),
		'admin_email'=>mysqli_real_escape_string($this->get_mysqli(),$this->input->post('admin_email')),
		'admin_mobile'=>mysqli_real_escape_string($this->get_mysqli(),$this->input->post('admin_mobile')),
		'admin_address'=>mysqli_real_escape_string($this->get_mysqli(),$this->input->post('admin_address')),
		'status' => 1,
		'create_date_time' => date('Y-m-d H:i:s')
			);
			/*echo "<pre>";print_r($set_data);exit;*/
			$this->db->where('id',$id);
			$result = $this->db->update($this->table_name,$set_data);
			return $result;
		}
		
		public function delete_record($id)
		{
		$this->db->where('id',$id);
		$result = $this->db->delete($this->table_name); 
		return $result;
		
		}

	    public function get_mysqli()
		{
	       $db = (array)get_instance()->db;
	       return mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
	    }
	
}
?>
