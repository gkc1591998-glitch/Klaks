<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class City_model extends CI_Model {

	public $table_name = "tbl_city";
	public $state_table_name = "tbl_state";
	
	public function __construct() {
        parent::__construct();
 		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off'); 
    }
  
	   public function get_all_records() 
	   {
			$this->db->select("*,(SELECT state_name from ".$this->state_table_name." where ".$this->state_table_name.".id = ".$this->table_name.".state_id) as state_name");
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
		
	   public function get_all_state() 
	   {
			$this->db->select("*");
			$this->db->from($this->state_table_name);
			$this->db->where("status",'1');
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		}		

		public function add_record()
		{
			$set_data = array(
			'state_id' => mysql_real_escape_string(ucwords($this->input->post('state_name'))),
			'city_name' => mysql_real_escape_string(ucwords($this->input->post('city_name'))),
			'status' => '0',
			'create_date_time' => date('Y-m-d H:i:s')
			);
			$result = $this->db->insert($this->table_name,$set_data);
			return $result;
		}		
		
		
		public function edit_record($id)
		{
			$set_data = array(
			'state_id' => mysql_real_escape_string(ucwords($this->input->post('state_name'))),
			'city_name' => mysql_real_escape_string(ucwords($this->input->post('city_name'))),
			
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

		public function city_status($id,$status)
	  {
		$sts = ($status == 1 ? 0 : 1);
		$set_data = array
		(
			'status' => $sts
		);
		$this->db->where('id',$id);
		
		$result = $this->db->update("tbl_city", $set_data); 
		return $result;
	 }

}
?>