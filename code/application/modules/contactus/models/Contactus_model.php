<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contactus_model extends CI_Model {

	public $table_contact  = 'tbl_contact'; 
	public function __construct() 
	{
        parent::__construct();
    }

		public function add_contact()
		{
			$set_data = array
			(
				'name' => mysqli_real_escape_string($this->get_mysqli(),ucwords($this->input->post('name',TRUE))),
				'email' => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('email',TRUE)),
				'phone' => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('mobile',TRUE)),
				'msg' => mysqli_real_escape_string($this->get_mysqli(),ucfirst($this->input->post('msg',TRUE))),
				'create_date_time' => date('Y-m-d H:i:s')
			);
			$result = $this->db->insert($this->table_contact,$set_data);
			return $result;
		}

    public function get_mysqli()
	{
       $db = (array)get_instance()->db;
       return mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
    }

}