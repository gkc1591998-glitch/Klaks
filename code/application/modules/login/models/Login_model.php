<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_model extends CI_Model {
	
	
	public function __construct() 
	{
        parent::__construct();
		
    } 
		
	public function getUser($data) 
	{
        $result = array();
        $this->db->select("*");
        $this->db->where('email', $data['email']);
        $this->db->where('password', $data['password']);
		$this->db->where('status', 1);
		$query = $this->db->get("tbl_register");
		/*echo $this->db->last_query();exit;*/
        if ($query->num_rows() > 0):
            $result = $query->row_array();
		else:
			$result = FALSE;
        endif;
		return $result;
    }
		
}