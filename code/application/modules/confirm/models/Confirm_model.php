<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Confirm_model extends CI_Model {
	// Variable Declaration Here
	//public $content = 'tbl_content';
	// Autoloading a system library usin constructor method
	public function __construct() 
	{
        parent::__construct();
 		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off'); 
    }
	   public function get_data($id)
	   {
			$this->db->select("*");
			$this->db->from("tbl_orders");
			$this->db->where('id', $id);
			$query = $this->db->get();
			$result = $query->row_array();
			return $result;
		}

		public function get_data_products($id)
	    {
			$this->db->select("*");
			$this->db->from("tbl_order_products");
			$this->db->where('order_table_id', $id);
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		}

		public function status_record($id)
		{
			$sts = 1;
			$set_data = array(
							'status' => $sts
						);
			$this->db->where('id',$id);
			$result = $this->db->update("tbl_orders", $set_data);
			return $result;
	    }

	   public function pstatus_record($id)
		{
			$sts = 1;
			$set_data = array(
							'pay_status' => $sts
						);
			$this->db->where('id',$id);
			$result = $this->db->update("tbl_orders", $set_data);
			return $result;
	   }
	
		public function cancel_order($id)
		{
			$this->cancel_products_order($id);
			$this->db->where('id',$id);
			$result = $this->db->delete("tbl_orders"); 
			return $result;
		}
	
		public function cancel_products_order($id)
		{
			$this->db->where('order_table_id',$id);
			$result = $this->db->delete("tbl_order_products"); 
			return $result;
		}	

	public function payment_details($data)
	{
		$result = $this->db->insert("payment_details",$data);
		//echo "<pre>";print_r($result);exit;
	    if(!empty($result))
	    {
	    	 return $result;
	    }
	}
}
