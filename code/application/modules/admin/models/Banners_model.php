<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Banners_model extends CI_Model {

	public function __construct() {
        parent::__construct();
 		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off'); 
    }
  
	   public function get_banners() 
	   {
			$this->db->select("*");
			$this->db->from("tbl_banners");
			$this->db->order_by('id','desc');
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
	   }
	   
	   public function get_single_banner($id) 
	   {
			$this->db->select("*");
			$this->db->from("tbl_banners");
			$this->db->where('id',$id);
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
	   }
		
		public function add_banner()
		{
			$set_data = array
			(
				//'image' => $image,
				'name' => $this->input->post('discount'),
				'status' => 1,
			);
			$result = $this->db->insert("tbl_banners",$set_data);
			return $result;
		}
		
		public function delete_banner_d($id){
			
			$dirPath = './images/banners/';
			$fileName = $this->get_single_banner($id);
			$this->db->where('id',$id);
			$result = $this->db->delete("tbl_banners"); 
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
		$result = $this->db->update("tbl_banners", $set_data); 
		return $result;
	}
	
	
	
}
?>