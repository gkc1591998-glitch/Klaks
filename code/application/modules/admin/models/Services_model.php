<?php 
class Services_model extends CI_Model {

	public $table_name = 'tbl_services';

	public function __construct() 
	{
        parent::__construct();
    }
	
    public function get_all_records() {
        $this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->order_by('id','ASC');
		$query = $this->db->get();
		//echo $this->db->last_query();
		$result = $query->result_array();
		return $result;
    }
	
    public function get_single_record($id='') {
        $this->db->select("*");
		$this->db->from($this->table_name);
		if($id != '')
		{
			$this->db->where("id",$id);
			$query = $this->db->get();
			//echo $this->db->last_query();
			$result = $query->row_array();
		}
		return $result;
    }

	public function exit_details($exit_data) {
        $this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->where($exit_data);
		$query = $this->db->get();
		$result = $query->num_rows();
		return $result;
    }
	
	public function add_record(){
		$set_data = array(
						'name' => mysql_real_escape_string(ucwords($this->input->post('name'))),
						'status' =>0
					);
		$result = $this->db->insert($this->table_name, $set_data); 
		return $result;
	}

	public function update_record($id){
		$set_data = array(
							'name' => mysql_real_escape_string(ucwords($this->input->post('name'))),
						);
		$this->db->where('id',$id);
		$result = $this->db->update($this->table_name, $set_data); 
		return $result;
	}
	
	public function delete_record($id)
	{
		$this->db->where('id',$id);
		$result = $this->db->delete($this->table_name); 
		return $result;
	}
	
	 public function service_status_record($id,$status)
	{
		$sts = ($status == 1 ? 0 : 1);
		$set_data = array
		(
			'status' => $sts
		);
		$this->db->where('id',$id);
		$result = $this->db->update("tbl_services", $set_data); 
		return $result;
	}
	
}
?>