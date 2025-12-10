<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model {

	public $admindata = "tbl_admin_data";
	
	
	public function __construct() {
        parent::__construct();
 		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off'); 
    }
		
	
}
?>