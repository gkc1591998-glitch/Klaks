<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payments_model extends CI_Model {
	
	public $table_name = 'tbl_payments';

	// Autoloading a system library usin constructor method
	public function __construct() {
        parent::__construct();
    }
	
 	/** In Function Get single records for edit view purpose from select table **/
   
	
	
	public function get_payments_records() 
	{
        $this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->order_by('id','desc'); 
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
    } 
	
	public function get_payments_detailed($x) {
        $this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->order_by('id','desc'); 
		$this->db->where('id',$x);
		$query = $this->db->get();
		//echo $this->db->last_query();
		$result = $query->row_array();
		return $result;
    } 
	
	public function get_user($y) {
        // For order payments, get from tbl_orders
        $this->db->select("user_id");
		$this->db->from("tbl_orders");
		$this->db->where('order_id', $y);
		$query = $this->db->get();
		$result = $query->row_array();
		
		// If not found and it's a student payment, return null
		if (!$result) {
		    return null;
		}
		return $result;
    }

   public function get_user_details($z) {
        // Get user details from tbl_register
        $this->db->select("*");
		$this->db->from("tbl_register");
		$this->db->where('id', $z);
		$query = $this->db->get();
		$result = $query->row_array();
		
		// If not found, try tbl_student_form for student payments
		if (!$result) {
		    $this->db->select("*");
		    $this->db->from("tbl_student_form");
		    $this->db->where('id', $z);
		    $query = $this->db->get();
		    $result = $query->row_array();
		}
		return $result;
    }	
	
	
	
	public function delete_record($id){
		$this->db->where('id',$id);
		$result = $this->db->delete($this->table_name); 
		return $result;
	}
	
}
