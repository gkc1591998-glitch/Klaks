<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ads_model extends CI_Model {

	public function __construct() {
        parent::__construct();
 		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off'); 
    }
  
	   public function get_ads() 
	   {
			$this->db->select("*");
			$this->db->from("tbl_ads");
			$this->db->order_by('id','desc');
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
	   }
	   
	   public function get_single_banner($id) 
	   {
			$this->db->select("*");
			$this->db->from("tbl_ads");
			$this->db->where('id',$id);
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
	   }
		
		public function add_banner($image)
		{
			$set_data = array
			(
				'image' => $image,
				'status' => 1,
			);
			$result = $this->db->insert("tbl_ads",$set_data);
			return $result;
		}
		
		public function delete_banner_d($id){
			
			$dirPath = './images/ads/';
			$fileName = $this->get_single_banner($id);
			$this->db->where('id',$id);
			$result = $this->db->delete("tbl_ads"); 
			if($result)
			{
				$file = $dirPath.$fileName['image'];
				if(is_file($file))
				unlink($file);
			}
			return $result;
	}
	
	
	public function banner_status_record($id,$status)
	{
		$sts = ($status == 1 ? 0 : 1);
		$set_data = array
		(
			'status' => $sts
		);
		$this->db->where('id',$id);
		$result = $this->db->update("tbl_ads", $set_data); 
		return $result;
	}
	
	
	
}
?>