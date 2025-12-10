<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Testimonials_model extends CI_Model {
	public $table_name = 'tbl_testimonials';
	public function __construct() 
	{
        parent::__construct();
    }
	
    public function get_all_records() {
        $this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->order_by('id','name');
		$this->db->where("status",1);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
    }
	
    public function get_single_record($id='') {
        $this->db->select("*");
		$this->db->from($this->table_name);
		if($id != '')
		{
			$this->db->where("id",$id);
			$this->db->where("status",1);
			$query = $this->db->get();
			$result = $query->row_array();
		}
		return $result;
    }
	
	public function add_record($Image)
	{
		$set_data = array(
					'name' =>mysqli_real_escape_string($this->get_mysqli(),stripcslashes(str_replace("\r\n","",$this->input->post('name')))),
					'designation' => mysqli_real_escape_string($this->get_mysqli(),stripslashes(str_replace("\r\n","",$this->input->post('designation')))),
					'content' => mysqli_real_escape_string($this->get_mysqli(),stripcslashes(str_replace("\r\n","",$this->input->post('content')))),
					'image' => $Image,
					'status' =>1,
					'create_date_time'=>date('Y-m-d H:i:s')
					);
		$result = $this->db->insert($this->table_name, $set_data); 
		return $result;
	}

	public function update_record($id,$Image)
	{
		$set_data = array(
					'name' =>mysqli_real_escape_string($this->get_mysqli(),stripcslashes(str_replace("\r\n","",$this->input->post('name')))),
					'designation' => mysqli_real_escape_string($this->get_mysqli(),stripslashes(str_replace("\r\n","",$this->input->post('designation')))),
					'content' => mysqli_real_escape_string($this->get_mysqli(),stripcslashes(str_replace("\r\n","",$this->input->post('content')))),
					'image' => $Image,
					'create_date_time'=>date('Y-m-d H:i:s')
						);
		$this->db->where('id',$id);
		$result = $this->db->update($this->table_name, $set_data);
		return $result;
	}
	
	public function delete_record($id)
	{
		$this->db->where('id',$id);
		$this->db->where("status",1);
		$result = $this->db->delete($this->table_name); 
		return $result;
	}
    
	public function status_record($id,$status)
	{
		$sts = ($status == 1 ? 0 : 1);
		$set_data = array(
						'status' => $sts
					);
		$this->db->where('id',$id);
		$result = $this->db->update($this->table_name, $set_data); 
		return $result;
	}

	public function get_mysqli()
	{
       $db = (array)get_instance()->db;
       return mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
    }
}
?>
