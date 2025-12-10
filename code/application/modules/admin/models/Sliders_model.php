<?php 
class Sliders_model extends CI_Model {

	public $table_name = 'tbl_sliders';

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

    public function get_states() 
	{
        $this->db->select("id,name");
		$this->db->from("tbl_category");
		$this->db->order_by('id','ASC');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
    }


    public function get_districts() 
	{
        $this->db->select("id,name");
		$this->db->from("tbl_subcategory");
		$this->db->order_by('id','ASC');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
    }

    public function getAjaxDistrict($id) 
	{
		$this->db->select("id,name");
		$this->db->from("tbl_subcategory");
		$this->db->where('cat_id',$id);
		$this->db->order_by('id','ASC');
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
	
	public function add_record($ImgData)
	{
		$set_data = array(
			/*'cat_id'    => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('cat_id')),
		    'subcat_id' => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('subcat_id')),*/
			'name'      => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('name')),
			'content'   => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('content')),
			'image'     => $ImgData,
			'status'    => 1,
			'create_date_time' =>date('Y-m-d H:i:s')
					);
		/*echo "<pre>";print_r($set_data);exit;*/
		$result = $this->db->insert($this->table_name, $set_data); 
		return $result;
	}


	public function update_record($id,$ImgData)
	{
		$set_data = array(
			/*'cat_id'    => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('cat_id')),
		    'subcat_id' => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('subcat_id')),*/
			'name'      => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('name')),
			'content'   => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('content')),
			'image'     => $ImgData,
			'create_date_time' =>date('Y-m-d H:i:s')
					);
		/*echo "<pre>";print_r($set_data);exit;*/
		$this->db->where('id',$id);
		$result = $this->db->update($this->table_name, $set_data); 
		return $result;
	}

	public function delete_record($id)
	{
		$this->db->select("*")->from($this->table_name)->where("id", $id);
		$query=$this->db->get();
		if($query->num_rows() == 1)
		{
			$result=$query->result();
			$delete=@unlink(FCPATH . 'images/sliders/'.$result[0]->image);
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
	}

	public function slider_status_record($id,$status)
	{
		$sts = ($status == 1 ? 0 : 1);
		$set_data = array
		(
			'status' => $sts
		);
		$this->db->where('id',$id);
		$result = $this->db->update("tbl_sliders", $set_data); 
		return $result;
	}

	public function get_mysqli()
	{
       $db = (array)get_instance()->db;
       return mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
    }
}
?>
