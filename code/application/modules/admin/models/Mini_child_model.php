<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mini_child_model extends CI_Model {

	public $table_name       = "tbl_mini_child";
	public $child_table_name = "tbl_category_child";
	public $sub_table_name   = "tbl_subcategory";
	public $main_table_name  = "tbl_category";
	
	public function __construct() {
        parent::__construct();
 		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off'); 
    }
  
	   public function get_all_records() 
	   {
			$this->db->select("*,(SELECT name from ".$this->main_table_name." where ".$this->main_table_name.".id = ".$this->table_name.".category_id) as category_name
			,(SELECT name from ".$this->sub_table_name." where ".$this->sub_table_name.".id = ".$this->table_name.".sub_category_id) as sub_category_name
			");
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
		
	   public function getsubcat($id) 
	   {
			$this->db->select("*");
			$this->db->from($this->child_table_name);
			$this->db->where('sub_cat_id',$id);
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		}

		public function getchildcat($id) 
	   {
			$this->db->select("*");
			$this->db->from($this->sub_table_name);
			$this->db->where('cat_id',$id);
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		}		
		
	   public function get_all_category() 
	   {
			$this->db->select("*");
			$this->db->from($this->main_table_name);
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		}	

       public function get_all_subcategory() 
	   {
			$this->db->select("*");
			$this->db->from($this->sub_table_name);
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		}			

		public function add_record()
		{
			$set_data = array(
			'category_id' => mysql_real_escape_string(ucwords($this->input->post('category_name'))),
			'sub_category_id' => mysql_real_escape_string(ucwords($this->input->post('sub_category_name'))),
			'child_category_name' => mysql_real_escape_string(ucwords($this->input->post('child_category_name'))),
			'status' => '1',
			'create_date_time' => date('Y-m-d H:i:s')
			
			);
			$result = $this->db->insert($this->table_name,$set_data);
			return $result;
		}		
		
		
		public function edit_record($id)
		{
			$set_data = array(
			
			'category_id' => mysql_real_escape_string(ucwords($this->input->post('category_name'))),
			'sub_category_id' => mysql_real_escape_string(ucwords($this->input->post('sub_category_name'))),
			'child_category_name' => mysql_real_escape_string(ucwords($this->input->post('child_category_name'))),
			'status' => '1',
			
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
	
}
?>