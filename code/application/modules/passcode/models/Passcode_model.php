<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Passcode_model extends CI_Model {
	public function __construct() 
	{
		parent::__construct();
	}

	public function getPasscode($data) 
	{
		$result = array();
		$this->db->select("*");
		$this->db->where('name', $data['name']);
		// $this->db->where('status', 1);
		$query = $this->db->get("tbl_admin_data");
		/*echo $this->db->last_query();exit;*/
    if ($query->num_rows() > 0):
      $result = $query->row_array();
		else:
			$result = FALSE;
    endif;
		return $result;
  }
}