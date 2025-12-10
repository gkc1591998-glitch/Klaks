<?php 
class Bussiness_rules_model extends CI_Model {

	public $table_name = 'tbl_bussiness_rules';

	public function __construct() 
	{
        parent::__construct();
    }
	
    public function get_all_records() 
	{
        $this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->order_by('id','asc');
		$query = $this->db->get();
		$result = $query->result_array();
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
			$result = $query->row_array();
		}
		return $result;
    }

	public function exit_details($exit_data) 
	{
        $this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->where($exit_data);
		$query = $this->db->get();
		$result = $query->num_rows();
		return $result;
    }
	
	public function add_record()
	{
		$set_data = array(
			/*'cat_id'    => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('cat_id')),
		    'subcat_id' => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('subcat_id')),
			'image'     => $ImgData,
			*/
			'name'      => mysqli_real_escape_string($this->get_mysqli(),ucwords($this->input->post('name'))),
			'content'   => mysqli_real_escape_string(
				$this->get_mysqli(),
				preg_replace('/\r\n|\r|\n/', '', $this->input->post('content'))
			),
			'status'    => 1,
			'create_date_time' =>date('Y-m-d H:i:s')
					);
		/*echo "<pre>";print_r($set_data);exit;*/
		$result = $this->db->insert($this->table_name, $set_data); 
		return $result;
	}


	public function update_record($id)
	{
		$set_data = array(
			/*'cat_id'    => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('cat_id')),
		    'subcat_id' => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('subcat_id')),
			'image'     => $ImgData,
			*/
			'name'      => mysqli_real_escape_string($this->get_mysqli(),ucwords($this->input->post('name'))),
			'content'   => mysqli_real_escape_string(
				$this->get_mysqli(),
				preg_replace('/\r\n|\r|\n/', '', $this->input->post('content'))
			),
			'create_date_time' =>date('Y-m-d H:i:s')
					);
		/*echo "<pre>";print_r($set_data);exit;*/
		$this->db->where('id',$id);
		$result = $this->db->update($this->table_name, $set_data); 
		return $result;
	}

	/*public function delete_record($id)
	{
		$this->db->select("*")->from($this->table_name)->where("id", $id)->where('status',1);
		$query=$this->db->get();
		if($query->num_rows() == 1)
		{
			$result=$query->result();
			$delete=@unlink(FCPATH . 'images/bussiness_rules/'.$result[0]->image);
			if($delete)
			{
				$this->db->where('id',$id);
		        $result = $this->db->delete($this->table_name); 
		        if($result){
					return 1;
				}else {
					return 0;
				}
			}
			else
			{
				return 0;
			}
		}
	}*/

	public function delete_record($id)
	{
		$this->db->where('id',$id);
		$result = $this->db->delete($this->table_name); 
		return $result;
	}

	public function slider_status_record($id,$status)
	{
		$sts = ($status == 1 ? 0 : 1);
		$set_data = array
		(
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
