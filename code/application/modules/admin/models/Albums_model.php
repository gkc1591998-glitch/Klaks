<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Albums_model extends CI_Model 
{

	public function __construct() 
	{
        parent::__construct();
 		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off'); 
    }
  
	   public function get_ads() 
	   {
			$this->db->select("*");
			$this->db->from("tbl_albums");
			$this->db->order_by('id','desc');
			$query = $this->db->get();
			$result = $query->result();
			return $result;
	   }
	   
	  
		public function add_banner($image)
		{
			$set_data = array
			(
				'image' => $image,
				'create_date_time'=>date('Y-m-d H:i:s'),
				'status' => 1,
			);
			$result = $this->db->insert("tbl_albums",$set_data);
			return $result;
		}
		
	public function delete_gallery_image($id)
	{		
		$this->db->select("*")->from("tbl_albums")->where(array("id" => $id));
		$query=$this->db->get();
		/** echo $this->db->last_query();exit;**/
		if($query->num_rows() == 1)
		{
			$result=$query->result();
			/*echo '<pre>';print_r($result);exit;*/
			$delete=@unlink(FCPATH . 'images/albums/' . $result[0]->image);
			if($delete)
			{
				$delete_gallery_query = $this->db->delete("tbl_albums",array("id" => $id));
				
			}

			if($delete_gallery_query)
			{
              return 1;
			} else
			{
				return 0;
			}
		}
    }
}
