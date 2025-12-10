<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {

	public $admindata = "tbl_admin_data";
	
	public function __construct() {
    parent::__construct();
 		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off'); 
    }
  
	  public function getadmindata() 
	  {
        $result = array();
        $this->db->select("*");
        $this->db->where('username', $this->input->post('user'));
        // $this->db->where('password', md5($this->input->post('password')));
				$this->db->where('password', $this->input->post('password'));
				$query = $this->db->get($this->admindata);
        if ($query->num_rows() > 0):
            $result = $query->row_array();
						echo $result;
				else:
					$result = FALSE;
						endif;
				return $result;
    }
}
?>