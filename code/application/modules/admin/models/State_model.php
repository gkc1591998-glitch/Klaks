<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class State_model extends CI_Model {

	public $table_name = "tbl_state";
	
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
			
			$query = $this->db->get();
			
			$result = $query->result_array();
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
			
			'state_name' => mysqli_real_escape_string($this->get_mysqli(),ucwords($this->input->post('state_name'))),
			'status' => '0',
			'create_date_time' => date('Y-m-d H:i:s')
			
			);
			$result = $this->db->insert($this->table_name,$set_data);
			return $result;
		}		
		
		
		public function edit_record($id)
		{
			$set_data = array(
			'state_name' => mysqli_real_escape_string($this->get_mysqli(),ucwords($this->input->post('state_name'))),
			);
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

		public function delete_record1($id)
		{
		$result = $this->db->select('*')->from('tbl_city')->where('state_id',$id)->delete('tbl_city');
		return $result;
		
		}

		public function delete_record2($id)
		{
		$result = $this->db->select('*')->from('tbl_area')->where('state_id',$id)->delete('tbl_area');
		return $result;
		
		}


		public function state_status($id,$status)
	  {
		$sts = ($status == 1 ? 0 : 1);
		$set_data = array
		(
			'status' => $sts
		);
		$this->db->where('id',$id);

		$result = $this->db->update("tbl_state", $set_data); 
		return $result;
	 }

	 public function get_mysqli()
	{
       $db = (array)get_instance()->db;
       return mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
    }
	
}
?>