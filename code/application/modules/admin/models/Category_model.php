<?php 
class Category_model extends CI_Model {
	public $table_name = 'tbl_category';
	public function __construct() 
	{
        parent::__construct();
    }
	
    public function get_all_records() 
    {
			$this->db->select("*");
			$this->db->from($this->table_name);
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
	
	public function generate_unique_slug($name, $id = null)
    {
        // Convert name to slug
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $base_slug = $slug;
        $i = 1;
        while (true) {
            $this->db->where('slug', $slug);
            if ($id) {
                $this->db->where('id !=', $id);
            }
            $query = $this->db->get($this->table_name);
            if ($query->num_rows() == 0) {
                break;
            }
            $slug = $base_slug . '-' . $i;
            $i++;
        }
        return $slug;
    }
	
	public function add_record($ImgData)
	{
        $name = mysqli_real_escape_string($this->get_mysqli(), stripcslashes(str_replace("\r\n", "", $this->input->post('name'))));
        $slug = $this->generate_unique_slug($name);
		$set_data = array(
			'name'   => $name,
			'image'  => $ImgData,
			'status' => 1,
			'create_date_time' => date('Y-m-d H:i:s'),
			'slug'   => $slug
		);
		/*echo  "<pre>";print_r($set_data);exit;*/
		$result = $this->db->insert($this->table_name, $set_data); 
		return $result;
	}

	public function update_record($id, $ImgData)
	{
        $name = mysqli_real_escape_string($this->get_mysqli(), stripcslashes(str_replace("\r\n", "", $this->input->post('name'))));
        $slug = $this->generate_unique_slug($name, $id);
		$set_data = array(
			'name'   => $name,
			'image'     => $ImgData,
			'create_date_time' => date('Y-m-d H:i:s'),
			'slug'   => $slug
		);
		$this->db->where('id', $id);
		$result = $this->db->update($this->table_name, $set_data); 
		return $result;
	}
	
	public function delete_record($id)
	{
		$this->db->where('id',$id);
		$result = $this->db->delete($this->table_name); 
		return $result;
	}
	
	public function delete1_record($id)
	{
		$this->db->select("*")->from($this->table_name)->where("id", $id);
		$query=$this->db->get();
		if($query->num_rows() == 1)
		{
			$result=$query->result();
			$delete=@unlink(FCPATH . 'images/category/' . $result[0]->image);
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

	public function top_category_status_record($id,$status)
	{
		$sts = ($status == 1 ? 0 : 1);
		$set_data = array(
						'top_rated' => $sts
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
