<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Partners_model extends CI_Model {

	public $table_name = "tbl_partners";
	
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
		
		
		public function add_record($image)
		{
			$set_data = array(
			    'linkk' => mysql_real_escape_string($this->input->post('url_link')),
				'image' => $image,
				'alt_tag' => mysql_real_escape_string(ucfirst($this->input->post('alt_tag'))),
				'create_date_time'=>date('Y-m-d H:i:s'),
				'status' => '1'
			);
			$result = $this->db->insert($this->table_name,$set_data);
			return $result;
		}
		
		public function update_record($id,$image)
		{
			$record = $this->get_single_record($id);
			if($image !=''){
				$set_data = array(
				'linkk' => mysql_real_escape_string($this->input->post('url_link')),
				'image' => $image,
				'alt_tag' => mysql_real_escape_string(ucfirst($this->input->post('alt_tag'))),
				'create_date_time'=>date('Y-m-d H:i:s')
				);
			}
			if($image == ''){
				$set_data = array(
				'linkk' => mysql_real_escape_string($this->input->post('url_link')),
				'image' => $image,
				'alt_tag' => mysql_real_escape_string(ucfirst($this->input->post('alt_tag'))),
				'create_date_time'=>date('Y-m-d H:i:s')
				);				
			}
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