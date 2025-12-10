<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Homelux_model extends CI_Model {

	public $table_products              = "tbl_products";
	public $table_products_details      = "tbl_product_details";
    // DEPRECATED: Old table removed during cleanup
    // public $table_product_more_info = "tbl_products_more_info"; 
    public $table_section = "tbl_sections";
    public $table_price = "tbl_prices";
    public $table_size = "tbl_sizes";
    public $table_color = "tbl_colors";
    public $table_coupon = "tbl_coupons";
    public $table_brands = "tbl_brands";
    public $table_name = "tbl_products";
    public $table_child_category = "tbl_category_child"; // Add missing table property for child category
    public $table_category = "tbl_category";
    public $table_subcategory = "tbl_subcategory";

	public function __construct() 
	{
			parent::__construct();
			error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
			error_reporting(1);
			ini_set('display_errors','on'); 
	}

	public function get_categories($name) {
		$this->db->select("*");
		$this->db->from($this->table_category);
		$this->db->where('name', $name);
		$this->db->where('status', 1);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_product($id)
		{
		$this->db->select("*");
		$this->db->from("tbl_products");
		$this->db->order_by('id','desc');
		$this->db->where('id',$id);
		$this->db->where('status', 1);
		
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query->row_array();
		if(count($result) > 0){
			if ($result) {
					// Note: attributes available through product variants data
					return $result;
			}
			return null;
		}
	}

	public function get_product_details($id){
		$this->db->select("*");
		$this->db->from("tbl_product_details");
		$this->db->order_by('id','desc');
		$this->db->where('lid',$id);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query->result_array();
		if(count($result) > 0){
			return $result;
		}
	} 
	public function get_category_products_count($id){
		$this->db->select("*");
		$this->db->from("tbl_products");
		$this->db->order_by('id','desc');
		$this->db->where('cat_id',$id);
		$this->db->where('status', 1);
		$this->db->where('show_in_lux', 1);
		
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query->num_rows();
		if(count($result) > 0){
			return $result;
		}
	}
		
	public function productsByType($category = null, $subcategory = null)
	{
    // If category is 'all' or null, return all products
    if (empty($category) || $category === 'all') {
        $this->db->select(
            "{$this->table_name}.*, ".
            "{$this->table_category}.name as category_name, ".
            "{$this->table_subcategory}.name as subcategory_name, ".
            "{$this->table_child_category}.child_category_name as child_category_name"
        , false);
        $this->db->from($this->table_name);
        $this->db->join($this->table_category, "{$this->table_category}.id = {$this->table_name}.cat_id", 'LEFT');
        $this->db->join($this->table_subcategory, "{$this->table_subcategory}.id = {$this->table_name}.subcat_id", 'LEFT');
        $this->db->join($this->table_child_category, "{$this->table_child_category}.id = {$this->table_name}.childcat_id", 'LEFT');
        $this->db->where("{$this->table_name}.status", 1);
        $this->db->where("{$this->table_name}.show_in_lux", 1);
        $this->db->group_by("{$this->table_name}.id");
        $this->db->order_by("{$this->table_name}.id", 'desc');
        $this->db->order_by('RAND()');
        $query = $this->db->get();
        $result = $query->result_array();
        // Note: attributes available through product variants data
        return $result;
    }
    
    // If subcategory is provided, filter by subcategory
    if (!empty($subcategory && $subcategory != 'all')) {
        // Get subcategory id by name
        $this->db->select('id');
        $this->db->from($this->table_subcategory);
        $this->db->where('name', $subcategory);
        $cat_query = $this->db->get();
        $cat_row = $cat_query->row_array();
        if (!$cat_row) {
            return [];
        }
        $subcat_id = $cat_row['id'];
        $this->db->select(
            "{$this->table_name}.*, ".
            "{$this->table_category}.name as category_name, ".
            "{$this->table_subcategory}.name as subcategory_name, ".
            "{$this->table_child_category}.child_category_name as child_category_name"
        , false);
        $this->db->from($this->table_name);
        $this->db->join($this->table_category, "{$this->table_category}.id = {$this->table_name}.cat_id", 'LEFT');
        $this->db->join($this->table_subcategory, "{$this->table_subcategory}.id = {$this->table_name}.subcat_id", 'LEFT');
        $this->db->join($this->table_child_category, "{$this->table_child_category}.id = {$this->table_name}.childcat_id", 'LEFT');
        $this->db->where("{$this->table_name}.subcat_id", $subcat_id);
        $this->db->where("{$this->table_name}.status", 1);
        $this->db->where("{$this->table_name}.show_in_lux", 1);
        $this->db->group_by("{$this->table_name}.id");
        $this->db->order_by("{$this->table_name}.id", 'desc');
        $this->db->order_by('RAND()');
        $query = $this->db->get();
        $result = $query->result_array();
        // Note: attributes available through product variants data
        return $result;
    }
    // If category is provided, filter by category
    else if (!empty($category)) {
        // Get category id by name
        $this->db->select('id');
        $this->db->from($this->table_category);
        $this->db->where('name', $category);
        $cat_query = $this->db->get();
        $cat_row = $cat_query->row_array();
        if (!$cat_row) {
            return [];
        }
        $cat_id = $cat_row['id'];
        $this->db->select(
            "{$this->table_name}.*, ".
            "{$this->table_category}.name as category_name, ".
            "{$this->table_subcategory}.name as subcategory_name, ".
            "{$this->table_child_category}.child_category_name as child_category_name"
        , false);
        $this->db->from($this->table_name);
        $this->db->join($this->table_category, "{$this->table_category}.id = {$this->table_name}.cat_id", 'LEFT');
        $this->db->join($this->table_subcategory, "{$this->table_subcategory}.id = {$this->table_name}.subcat_id", 'LEFT');
        $this->db->join($this->table_child_category, "{$this->table_child_category}.id = {$this->table_name}.childcat_id", 'LEFT');
        $this->db->where("{$this->table_name}.cat_id", $cat_id);
        $this->db->where("{$this->table_name}.status", 1);
        $this->db->where("{$this->table_name}.show_in_lux", 1);
        $this->db->group_by("{$this->table_name}.id");
        $this->db->order_by("{$this->table_name}.id", 'desc');
        $this->db->order_by('RAND()');
        $query = $this->db->get();
        $result = $query->result_array();
        foreach ($result as &$product) {
            $product['attributes'] = $this->get_product_attributes_full_joined($product['id']);
        }
        return $result;
    }
}
	public function get_product_attributes_full_joined($product_id)
    {
        // Updated to use new table structure: tbl_product_variants + tbl_variant_sizes
        $this->db->select(
            "v.id, v.product_id, " .
            "vs.size_id, vs.price_id, vs.sale_price, vs.stock, " .
            "v.color_id, v.sku_code, v.tags, v.ratings, " .
            "s.name as section_name, " .
            "p.name as price_name, " .
            "sz.name as size_name, " .
            "c.name as color_name, " .
            "vi.image",
            false
        );
        $this->db->from('tbl_product_variants v');
        $this->db->join('tbl_variant_sizes vs', 'vs.variant_id = v.id', 'LEFT');
        $this->db->join('tbl_variant_sections vsec', 'vsec.variant_id = v.id', 'LEFT');
        $this->db->join('tbl_sections s', 's.id = vsec.section_id', 'LEFT');
        $this->db->join('tbl_prices p', 'p.id = vs.price_id', 'LEFT');
        $this->db->join('tbl_sizes sz', 'sz.id = vs.size_id', 'LEFT');
        $this->db->join('tbl_colors c', 'c.id = v.color_id', 'LEFT');
        // $this->db->join('tbl_coupons cp', 'cp.id = vsec.coupon_id', 'LEFT'); // coupon_id column doesn't exist
        $this->db->join('tbl_products prod', 'prod.id = v.product_id', 'LEFT');
        // $this->db->join('tbl_brands b', 'b.id = prod.brand_id', 'LEFT'); // brand_id column doesn't exist
        $this->db->join('tbl_variant_images vi', 'vi.variant_id = v.id', 'LEFT');
        $this->db->where('v.product_id', $product_id);
        $this->db->where('vs.status', 1);
        $this->db->order_by('v.id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function productsByCategoryName($categoryName) {
        if (empty($categoryName) || $categoryName === 'all') {
            return $this->productsByType(null);
        }
        
        $this->db->select("*");
        $this->db->from($this->table_name);
        $this->db->join($this->table_category, "{$this->table_category}.id = {$this->table_name}.cat_id", 'LEFT');
        $this->db->where($this->table_category . '.name', $categoryName);
        $this->db->where($this->table_name . '.status', 1);
        $this->db->where($this->table_name . '.show_in_lux', 1);
        $this->db->order_by($this->table_name . '.id', 'desc');
        
        $query = $this->db->get();
        $result = $query->result_array();
        
        foreach ($result as &$product) {
            $product['attributes'] = $this->get_product_attributes_full_joined($product['id']);
        }
        
        return $result;
    }

    public function productsBySize($sizeName) {
        if (empty($sizeName)) {
            return $this->productsByType(null);
        }
        
        $this->db->select("{$this->table_name}.*");
        $this->db->from($this->table_name);
        $this->db->join('tbl_product_variants pv_size', "pv_size.product_id = {$this->table_name}.id", 'INNER');
        $this->db->join('tbl_variant_sizes vs_size', 'vs_size.variant_id = pv_size.id', 'INNER');
        $this->db->join($this->table_size, "{$this->table_size}.id = vs_size.size_id", 'INNER');
        $this->db->where($this->table_size . '.name', $sizeName);
        $this->db->where($this->table_name . '.status', 1);
        $this->db->where($this->table_name . '.show_in_lux', 1);
        $this->db->where('vs_size.status', 1);
        $this->db->group_by($this->table_name . '.id');
        $this->db->order_by($this->table_name . '.id', 'desc');
        
        $query = $this->db->get();
        $result = $query->result_array();
        
        foreach ($result as &$product) {
            $product['attributes'] = $this->get_product_attributes_full_joined($product['id']);
        }
        
        return $result;
    }

    public function productsByColor($colorName) {
        if (empty($colorName)) {
            return $this->productsByType(null);
        }
        
        $this->db->select("{$this->table_name}.*");
        $this->db->from($this->table_name);
        $this->db->join('tbl_product_variants pv_color', "pv_color.product_id = {$this->table_name}.id", 'INNER');
        $this->db->join($this->table_color, "{$this->table_color}.id = pv_color.color_id", 'INNER');
        $this->db->where($this->table_color . '.name', $colorName);
        $this->db->where($this->table_name . '.status', 1);
        $this->db->where($this->table_name . '.show_in_lux', 1);
        $this->db->group_by($this->table_name . '.id');
        $this->db->order_by($this->table_name . '.id', 'desc');
        
        $query = $this->db->get();
        $result = $query->result_array();
        
        foreach ($result as &$product) {
            $product['attributes'] = $this->get_product_attributes_full_joined($product['id']);
        }
        
        return $result;
    }

    public function filterProducts($filters = []) {
        try {
            error_log('MODEL FILTER START: ' . json_encode($filters));
            
            // If only sorting is requested, use simpler query
            if (!empty($filters['sort']) && empty($filters['size']) && empty($filters['color']) && empty($filters['category']) && empty($filters['fit']) && empty($filters['search']) && empty($filters['price_min']) && empty($filters['price_max'])) {
                return $this->filterProductsSimple($filters);
            }
            
            $this->db->select(
                "{$this->table_name}.*, ".
                "{$this->table_category}.name as category_name, ".
                "{$this->table_subcategory}.name as subcategory_name, ".
                "{$this->table_child_category}.child_category_name as child_category_name"
            , false);
            $this->db->from($this->table_name);
            $this->db->join($this->table_category, "{$this->table_category}.id = {$this->table_name}.cat_id", 'LEFT');
            $this->db->join($this->table_subcategory, "{$this->table_subcategory}.id = {$this->table_name}.subcat_id", 'LEFT');
            $this->db->join($this->table_child_category, "{$this->table_child_category}.id = {$this->table_name}.childcat_id", 'LEFT');
            
            // Track which joins we've already added to prevent duplicates
            $product_more_info_joined = false;
            $size_joined = false;
            $color_joined = false;
            $price_joined = false;
            
            // Join with variant tables for filtering instead of old table_product_more_info
            if (!empty($filters['size']) || !empty($filters['color']) || !empty($filters['fit']) || 
                (!empty($filters['price_min']) && is_numeric($filters['price_min'])) || 
                (!empty($filters['price_max']) && is_numeric($filters['price_max'])) ||
                (isset($filters['sort']) && in_array($filters['sort'], ['high-to-low', 'low-to-high']))) {
                
                $this->db->join('tbl_product_variants pv', "pv.product_id = {$this->table_name}.id", 'LEFT');
                $product_more_info_joined = true;
                
                if (!empty($filters['size'])) {
                    $this->db->join('tbl_variant_sizes vs_filter', 'vs_filter.variant_id = pv.id', 'LEFT');
                    $this->db->join($this->table_size, "{$this->table_size}.id = vs_filter.size_id", 'LEFT');
                    $size_joined = true;
                }
                if (!empty($filters['color'])) {
                    $this->db->join($this->table_color, "{$this->table_color}.id = pv.color_id", 'LEFT');
                    $color_joined = true;
                }
                // Join prices table if needed for price filtering or sorting
                if ((!empty($filters['price_min']) && is_numeric($filters['price_min'])) || 
                    (!empty($filters['price_max']) && is_numeric($filters['price_max'])) ||
                    (isset($filters['sort']) && in_array($filters['sort'], ['high-to-low', 'low-to-high']))) {
                    if (!$size_joined) {
                        $this->db->join('tbl_variant_sizes vs_price', 'vs_price.variant_id = pv.id', 'LEFT');
                    }
                    $this->db->join($this->table_price, "{$this->table_price}.id = " . ($size_joined ? 'vs_filter' : 'vs_price') . ".price_id", 'LEFT');
                    $price_joined = true;
                }
            }
            
            $this->db->where("{$this->table_name}.status", 1);
            $this->db->where("{$this->table_name}.show_in_lux", 1);
            
            // Category filter
            if (!empty($filters['category']) && strtolower($filters['category']) !== 'all') {
                $this->db->where("{$this->table_category}.name", $filters['category']);
            }
            
            // Add search filter support
            if (!empty($filters['search'])) {
                $this->db->like("{$this->table_name}.title", $filters['search']);
            }
            
            // Size filter
            if (!empty($filters['size'])) {
                $this->db->where("{$this->table_size}.name", $filters['size']);
            }
            
            // Color filter
            if (!empty($filters['color'])) {
                $this->db->where("{$this->table_color}.name", $filters['color']);
            }
            
            // Fit filter (assuming it's stored in main products table)
            if (!empty($filters['fit'])) {
                $this->db->like("{$this->table_name}.fit", $filters['fit']);
            }
            
            // Price range filter
            if ((!empty($filters['price_min']) && is_numeric($filters['price_min'])) || 
                (!empty($filters['price_max']) && is_numeric($filters['price_max']))) {
                
                if (!empty($filters['price_min']) && is_numeric($filters['price_min'])) {
                    $this->db->where("CAST({$this->table_price}.name AS UNSIGNED) >=", $filters['price_min']);
                }
                if (!empty($filters['price_max']) && is_numeric($filters['price_max'])) {
                    $this->db->where("CAST({$this->table_price}.name AS UNSIGNED) <=", $filters['price_max']);
                }
            }
            
            // Sorting
            if (!empty($filters['sort'])) {
                switch ($filters['sort']) {
                    case 'popular':
                        $this->db->order_by("{$this->table_name}.created_date_time", 'DESC');
                        break;
                    case 'new':
                        $this->db->order_by("{$this->table_name}.id", 'DESC');
                        break;
                    case 'high-to-low':
                        // Price join should already be done above
                        $this->db->order_by("CAST({$this->table_price}.name AS UNSIGNED)", 'DESC');
                        break;
                    case 'low-to-high':
                        // Price join should already be done above
                        $this->db->order_by("CAST({$this->table_price}.name AS UNSIGNED)", 'ASC');
                        break;
                }
            }
            
            $this->db->group_by("{$this->table_name}.id");
            $query = $this->db->get();
            $result = $query->result_array();
            
            // Debug: Log the actual query
            error_log('LAST QUERY: ' . $this->db->last_query());
            error_log('RESULT COUNT: ' . count($result));
            
            foreach ($result as &$product) {
                $product['attributes'] = $this->get_product_attributes_full_joined($product['id']);
            }
            return $result;
            
        } catch (Exception $e) {
            error_log('MODEL FILTER ERROR: ' . $e->getMessage());
            return [];
        }
    }

    // Simple filter method for sort-only requests
    public function filterProductsSimple($filters = []) {
        try {
            error_log('MODEL SIMPLE FILTER START: ' . json_encode($filters));
            
            // For price sorting, we need joins - updated to use new table structure
            if (!empty($filters['sort']) && in_array($filters['sort'], ['high-to-low', 'low-to-high'])) {
                $this->db->select("{$this->table_name}.*");
                $this->db->from($this->table_name);
                $this->db->join('tbl_product_variants pv_simple', "pv_simple.product_id = {$this->table_name}.id", 'LEFT');
                $this->db->join('tbl_variant_sizes vs_simple', 'vs_simple.variant_id = pv_simple.id', 'LEFT');
                $this->db->join($this->table_price, "{$this->table_price}.id = vs_simple.price_id", 'LEFT');
                $this->db->where("{$this->table_name}.status", 1);
                $this->db->where("{$this->table_name}.show_in_lux", 1);
                $this->db->where("vs_simple.status", 1);
                
                if ($filters['sort'] === 'high-to-low') {
                    $this->db->order_by("CAST({$this->table_price}.name AS UNSIGNED)", 'DESC');
                } else {
                    $this->db->order_by("CAST({$this->table_price}.name AS UNSIGNED)", 'ASC');
                }
                
                $this->db->group_by("{$this->table_name}.id");
            } else {
                // Simple sorts that don't need joins
                $this->db->select("*");
                $this->db->from($this->table_name);
                $this->db->where('status', 1);
                $this->db->where('show_in_lux', 1);
                
                if (!empty($filters['sort'])) {
                    switch ($filters['sort']) {
                        case 'popular':
                            $this->db->order_by('created_date_time', 'DESC');
                            break;
                        case 'new':
                            $this->db->order_by('id', 'DESC');
                            break;
                        default:
                            $this->db->order_by('id', 'DESC');
                            break;
                    }
                } else {
                    $this->db->order_by('id', 'DESC');
                }
            }
            
            $query = $this->db->get();
            $result = $query->result_array();
            
            error_log('SIMPLE LAST QUERY: ' . $this->db->last_query());
            error_log('SIMPLE RESULT COUNT: ' . count($result));
            
            foreach ($result as &$product) {
                $product['attributes'] = $this->get_product_attributes_full_joined($product['id']);
            }
            return $result;
            
        } catch (Exception $e) {
            error_log('MODEL SIMPLE FILTER ERROR: ' . $e->getMessage());
            return [];
        }
    }

    public function getAvailableColors() {
        $this->db->select('name');
        $this->db->from($this->table_color);
        $this->db->where('status', 1);
        $this->db->group_by('name');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAvailableSizes() {
        $this->db->select('name');
        $this->db->from($this->table_size);
        $this->db->where('status', 1);
        $this->db->group_by('name');
        $query = $this->db->get();
        return $query->result_array();
    }

}
