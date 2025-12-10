<?php 
class area_model extends CI_Model {

	public $table_name = 'tbl_area';

	public function __construct() 
	{
        parent::__construct();
    }
	
    public function get_all_records() {
        $this->db->select("tbl_area.*,tbl_state.state_name as state,tbl_city.city_name as city");
		$this->db->from($this->table_name);
		$this->db->order_by('id','desc');
		$this->db->join('tbl_state','tbl_state.id = tbl_area.state_id');
		$this->db->join('tbl_city','tbl_city.id = tbl_area.city_id');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
    }
	
    public function get_states() 
	{
        $this->db->select("id,state_name");
		$this->db->from("tbl_state");
		$this->db->order_by('id','desc');
		$this->db->where("status",'1');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
    } 
	
	public function get_all_cities_ajax($id) 
	{
    $this->db->select("id,city_name");
		$this->db->from("tbl_city");
		$this->db->where("state_id",$id);
		$this->db->where("status",'1');
		$this->db->order_by('id','desc');
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
			$query = $this->db->get();
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
						'state_id' => mysql_real_escape_string(ucwords($this->input->post('state_id'))),
						'city_id' => mysql_real_escape_string(ucwords($this->input->post('city_id'))),
						'area_name' => mysql_real_escape_string(ucwords($this->input->post('area_name'))),
						'create_date_time' => date('Y-m-d H:i:s'),
						'status' => '0'
					);
		$result = $this->db->insert($this->table_name, $set_data); 
		return $result;
	}

	public function update_record($id){
		$set_data = array(
							'city_id' => mysql_real_escape_string(ucwords($this->input->post('city_id'))),
							'state_id' => mysql_real_escape_string(ucwords($this->input->post('state_id'))),
							'area_name' => mysql_real_escape_string(ucwords($this->input->post('area_name'))),
							
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
	
	public function area_status($id,$status)
	  {
		$sts = ($status == 1 ? 0 : 1);
		$set_data = array
		(
			'status' => $sts
		);
		$this->db->where('id',$id);
		

		$result = $this->db->update("tbl_area", $set_data); 
		return $result;
	 }

	
}
?>