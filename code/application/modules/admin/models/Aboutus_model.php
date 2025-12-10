<?php 

class Aboutus_model extends CI_Model {

	public $table_name = 'tbl_about';

	public function __construct() 
	{
        parent::__construct();
    }

	

    public function get_all_records() 
    {
        $this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->order_by('id','name');
		$query = $this->db->get();
		//echo $this->db->last_query();
		$result = $query->result_array();
		//echo '<pre>';print_r($result);exit;
		return $result;
    }

	

    public function get_single_record($id='')
    {
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

	public function add_record($ImgData){

		$set_data = array(

						'name' => mysql_real_escape_string($this->input->post('name')),
						'content' => mysql_real_escape_string(stripcslashes(str_replace("\n","",$this->input->post('content')))),
						'image' =>$ImgData,
						'create_date_time'=>date('Y-m-d H:i:s'),
						'status' =>1

					);

		$result = $this->db->insert($this->table_name, $set_data); 

		return $result;

	}



	public function update_record($id,$ImgData){

		$set_data = array(

						'name' => mysql_real_escape_string($this->input->post('name')),
						'content' => mysql_real_escape_string(stripcslashes(str_replace("\n","",$this->input->post('content')))),
						'image' =>$ImgData,
						'create_date_time'=>date('Y-m-d H:i:s'),
						);

		$this->db->where('id',$id);
		$result = $this->db->update($this->table_name, $set_data);
         // echo '<pre>';print_r($result);exit;		
		return $result;
	}

	

	public function delete_record($id)

	{

		$this->db->where('id',$id);

		$result = $this->db->delete($this->table_name); 

		return $result;

	}
    
	public function status_record($id,$status){
		$sts = ($status == 1 ? 0 : 1);
		$set_data = array(
						'status' => $sts
					);
		$this->db->where('id',$id);
		$result = $this->db->update($this->table_name, $set_data); 
		return $result;
	}

}

?>