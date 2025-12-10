<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category_child_model extends CI_Model {

	public $table_name = "tbl_category_child";
	public $sub_table_name = "tbl_subcategory";
	public $main_table_name = "tbl_category";
	
	public function __construct() {
        parent::__construct();
 		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off'); 
    }
  
	   public function get_all_records() 
	   {
			$this->db->select("*,(SELECT name from ".$this->main_table_name." where ".$this->main_table_name.".id = ".$this->table_name.".category_id) as category_name
			,(SELECT name from ".$this->sub_table_name." where ".$this->sub_table_name.".id = ".$this->table_name.".sub_category_id) as sub_category_name
			");
			$this->db->from($this->table_name);
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		}
		
	   public function get_single_record($id) 
	   {
			$this->db->select("*");
			$this->db->from($this->table_name);
			$this->db->where('id',$id);
			$query = $this->db->get();
			$result = $query->row_array();
			return $result;
		}	
		
	   public function getsubcat($id) 
	   {
			$this->db->select("*");
			$this->db->from($this->sub_table_name);
			$this->db->where('cat_id',$id);
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		}		
		
	   public function get_all_category() 
	   {
			$this->db->select("*");
			$this->db->from($this->main_table_name);
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		}	

       public function get_all_subcategory() 
	   {
			$this->db->select("*");
			$this->db->from($this->sub_table_name);
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		}			

    public function generate_unique_slug($category_id, $sub_category_id, $child_name, $id = null)
    {
        // Get category name
        $this->db->select('name');
        $this->db->where('id', $category_id);
        $cat_query = $this->db->get($this->main_table_name);
        $cat_row = $cat_query->row_array();
        $cat_name = isset($cat_row['name']) ? $cat_row['name'] : '';
        // Get subcategory name
        $this->db->select('name');
        $this->db->where('id', $sub_category_id);
        $subcat_query = $this->db->get($this->sub_table_name);
        $subcat_row = $subcat_query->row_array();
        $subcat_name = isset($subcat_row['name']) ? $subcat_row['name'] : '';
        // Build base slug: category-subcategory-child
        $cat_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $cat_name)));
        $subcat_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $subcat_name)));
        $child_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $child_name)));
        $full_slug = $cat_slug . '-' . $subcat_slug . '-' . $child_slug;
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

		public function add_record()
		{
			$category_id = $this->input->post('category_name');
			$sub_category_id = $this->input->post('sub_category_name');
			$child_category_name = $this->input->post('child_category_name');
			$slug = $this->generate_unique_slug($category_id, $sub_category_id, $child_category_name);
			$set_data = array(
			'category_id' => $category_id,
			'sub_category_id' => $sub_category_id,
			'child_category_name' => $child_category_name,
			'status' => '1',
			'create_date_time' => date('Y-m-d H:i:s'),
			'slug' => $slug
			);
			$result = $this->db->insert($this->table_name,$set_data);
			return $result;
		}		
		
		
		public function edit_record($id)
		{
			$category_id = $this->input->post('category_name');
			$sub_category_id = $this->input->post('sub_category_name');
			$child_category_name = $this->input->post('child_category_name');
			$slug = $this->generate_unique_slug($category_id, $sub_category_id, $child_category_name, $id);
			$set_data = array(
			
			'category_id' => $category_id,
			'sub_category_id' => $sub_category_id,
			'child_category_name' => $child_category_name,
			'status' => '1',
			'slug' => $slug
			);
			$this->db->where('id',$id);
			$result = $this->db->update($this->table_name,$set_data);
			return $result;
		}
		
		public function delete_record($id)
		{
			
		$this->db->where('id',$id);
		$result = $this->db->delete($this->table_name); 
		return $result;
		
		}
	
}
?>