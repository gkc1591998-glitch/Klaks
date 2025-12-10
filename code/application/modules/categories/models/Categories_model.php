<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Categories_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->table_category = 'tbl_category';
        $this->table_subcategory = 'tbl_subcategory';
    }
    
    public function getAllCategories() {
        $this->db->select('*');
        $this->db->from($this->table_category);
        $this->db->where('status', 1);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getCategoryBySlug($slug) {
        $this->db->select('*');
        $this->db->from($this->table_category);
        $this->db->where('slug', $slug);
        $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function getSubcategoriesByParentId($parent_id) {
        $this->db->select('*');
        $this->db->from($this->table_subcategory);
        $this->db->where('cat_id', $parent_id);
        $this->db->where('status', 1);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
}
