<?php 
class Subcategory_model extends CI_Model {

	public $table_name = 'tbl_subcategory';

	public function __construct() 
	{
        parent::__construct();
    }
	
    public function get_all_records() 
    {
        $this->db->select("tbl_subcategory.*,tbl_category.name as state");
		$this->db->from($this->table_name);
		$this->db->order_by('id','desc');
		$this->db->join('tbl_category','tbl_category.id = tbl_subcategory.cat_id');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
    }
	
    public function get_categories() 
	{
        $this->db->select("id,name");
		$this->db->from("tbl_category");
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
	
	public function generate_unique_slug($cat_id, $name, $id = null)
    {
        // Get category name
        $this->db->select('name');
        $this->db->where('id', $cat_id);
        $cat_query = $this->db->get('tbl_category');
        $cat_row = $cat_query->row_array();
        $cat_name = isset($cat_row['name']) ? $cat_row['name'] : '';
        // Build base slug: category-name-subcategory-name
        $base = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $cat_name)));
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $full_slug = $base . '-' . $slug;
        $unique_slug = $full_slug;
        $i = 1;
        while (true) {
            $this->db->where('slug', $unique_slug);
            if ($id) {
                $this->db->where('id !=', $id);
            }
            $query = $this->db->get($this->table_name);
            if ($query->num_rows() == 0) {
                break;
            }
            $unique_slug = $full_slug . '-' . $i;
            $i++;
        }
        return $unique_slug;
    }
	
	public function add_record($ImgData)
	{
		$cat_id = mysqli_real_escape_string($this->get_mysqli(), $this->input->post('cat_id'));
        $name = mysqli_real_escape_string($this->get_mysqli(), stripcslashes(str_replace("\r\n", "", $this->input->post('name'))));
        $slug = $this->generate_unique_slug($cat_id, $name);
		$set_data = array(
				'cat_id' => $cat_id,
				'name'   => $name,
				'image'  => $ImgData,
				'status' => 1,
				'create_date_time' => date('Y-m-d H:i:s'),
				'slug'   => $slug
					);
		/*echo "<pre>";print_r($set_data);exit;*/
		$result = $this->db->insert($this->table_name, $set_data); 
		return $result;
	}

	public function update_record($id,$ImgData)
	{
		$cat_id = mysqli_real_escape_string($this->get_mysqli(), $this->input->post('cat_id'));
        $name = mysqli_real_escape_string($this->get_mysqli(), stripcslashes(str_replace("\r\n", "", $this->input->post('name'))));
        $slug = $this->generate_unique_slug($cat_id, $name, $id);
		$set_data = array(
					'cat_id' => $cat_id,
					'name'   => $name,
					'image'  => $ImgData,
					'create_date_time' => date('Y-m-d H:i:s'),
					'slug'   => $slug
						);
		/*echo "<pre>";print_r($set_data);exit;*/
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

	public function get_mysqli()
	{
       $db = (array)get_instance()->db;
       return mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
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
}
?>
