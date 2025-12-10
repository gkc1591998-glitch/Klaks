<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Track_model extends CI_Model {

	public $table_about = "tbl_orders";
	
	public function __construct() {
    parent::__construct();
 		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(-1);
		ini_set('display_errors','on'); 
  }
	
	   public function get_all_records() 
	   {
			$this->db->select("*");
			$this->db->from($this->table_about);
			$this->db->where('status',1);
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		}

		public function get_all_categories() 
	   {
			$this->db->select("*");
			$this->db->from("tbl_category");
			$this->db->where('status',1);
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		}

		public function get_record($id) 
	   {
			$this->db->select("*");
			$this->db->from($this->table_about);
			$this->db->where('status',1);
			$this->db->where('id',$id);
			$query = $this->db->get();
			$result = $query->row_array();
			return $result;
		}
	
}
?>
