<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Products_model extends CI_Model {

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
    public $table_reviews = "tbl_product_reviews"; // reviews table

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
        // row_array() may return null when no row found — guard against that
        if (!empty($result) && is_array($result)) {
            return $result;
        }
        return null;
	}

        /**
         * Reviews: insert a review and fetch reviews for a product
         */
        public function insert_review($data = [])
        {
            if (empty($data) || empty($data['product_id'])) return false;
            $insert = [
                'product_id' => $data['product_id'],
                'variant_id' => isset($data['variant_id']) ? $data['variant_id'] : null,
                'rating'     => isset($data['rating']) ? (float)$data['rating'] : 0,
                'name'       => isset($data['name']) ? $data['name'] : '',
                'email'      => isset($data['email']) ? $data['email'] : '',
                'comment'    => isset($data['comment']) ? $data['comment'] : '',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $ok = $this->db->insert($this->table_reviews, $insert);
            if ($ok) return $this->db->insert_id();
            return false;
        }

        public function get_reviews_by_product($product_id)
        {
            if (empty($product_id)) return [];
            $this->db->select('*');
            $this->db->from($this->table_reviews);
            $this->db->where('product_id', $product_id);
            $this->db->order_by('created_at', 'DESC');
            $q = $this->db->get();
            return $q->result_array();
        }

	public function get_product_details($id){
		$this->db->select("*");
		$this->db->from("tbl_product_details");
		$this->db->order_by('id','desc');
		$this->db->where('lid',$id);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
        $result = $query->result_array();
        // return result array (may be empty)
        return $result;
	} 
	public function get_category_products_count($id){
		$this->db->select("*");
		$this->db->from("tbl_products");
		$this->db->order_by('id','desc');
		$this->db->where('cat_id',$id);
		$this->db->where('status', 1);
		
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
        $result = $query->num_rows();
        // num_rows() returns an integer
        if ($result > 0) {
            return $result;
        }
        return 0;
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
        $this->db->group_by("{$this->table_name}.id");
        $this->db->order_by("{$this->table_name}.id", 'desc');
        $this->db->order_by('RAND()');
        $query = $this->db->get();
        $result = $query->result_array();
    // legacy attribute aggregation removed
        return $result;
    }
    
    // If subcategory is provided, filter by subcategory
    if (!empty($subcategory) && $subcategory != 'all') {
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
        $this->db->group_by("{$this->table_name}.id");
        $this->db->order_by("{$this->table_name}.id", 'desc');
        $this->db->order_by('RAND()');
        $query = $this->db->get();
        $result = $query->result_array();
    // legacy attribute aggregation removed
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
        $this->db->group_by("{$this->table_name}.id");
        $this->db->order_by("{$this->table_name}.id", 'desc');
        $this->db->order_by('RAND()');
        $query = $this->db->get();
        $result = $query->result_array();
    // legacy attribute aggregation removed
        return $result;
    }
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
        $this->db->order_by($this->table_name . '.id', 'desc');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    /**
     * Return products for a specific subcategory id
     */
    public function get_products_by_subcategory_id($subcat_id) {
        if (empty($subcat_id)) return [];
        $this->db->select(
            "{$this->table_name}.*, " .
            "{$this->table_category}.name as category_name, " .
            "{$this->table_subcategory}.name as subcategory_name, " .
            "{$this->table_child_category}.child_category_name as child_category_name"
        , false);
        $this->db->from($this->table_name);
        $this->db->join($this->table_category, "{$this->table_category}.id = {$this->table_name}.cat_id", 'LEFT');
        $this->db->join($this->table_subcategory, "{$this->table_subcategory}.id = {$this->table_name}.subcat_id", 'LEFT');
        $this->db->join($this->table_child_category, "{$this->table_child_category}.id = {$this->table_name}.childcat_id", 'LEFT');
        $this->db->where("{$this->table_name}.subcat_id", $subcat_id);
        $this->db->where("{$this->table_name}.status", 1);
        $this->db->group_by("{$this->table_name}.id");
        $this->db->order_by("{$this->table_name}.id", 'desc');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function productsBySize($sizeName) {
        if (empty($sizeName)) {
            return $this->productsByType(null);
        }
        
        $this->db->select("{$this->table_name}.*");
        $this->db->from($this->table_name);
        $this->db->join($this->table_product_more_info, "{$this->table_product_more_info}.product_id = {$this->table_name}.id", 'INNER');
        $this->db->join($this->table_size, "{$this->table_size}.id = {$this->table_product_more_info}.size_id", 'INNER');
        $this->db->where($this->table_size . '.name', $sizeName);
        $this->db->where($this->table_name . '.status', 1);
        $this->db->group_by($this->table_name . '.id');
        $this->db->order_by($this->table_name . '.id', 'desc');
        
        $query = $this->db->get();
        $result = $query->result_array();
        
    // legacy attribute aggregation removed
        
        return $result;
    }

    public function productsByColor($colorName) {
        if (empty($colorName)) {
            return $this->productsByType(null);
        }
        
        $this->db->select("{$this->table_name}.*");
        $this->db->from($this->table_name);
        $this->db->join($this->table_product_more_info, "{$this->table_product_more_info}.product_id = {$this->table_name}.id", 'INNER');
        $this->db->join($this->table_color, "{$this->table_color}.id = {$this->table_product_more_info}.color_id", 'INNER');
        $this->db->where($this->table_color . '.name', $colorName);
        $this->db->where($this->table_name . '.status', 1);
        $this->db->group_by($this->table_name . '.id');
        $this->db->order_by($this->table_name . '.id', 'desc');
        
        $query = $this->db->get();
        $result = $query->result_array();
        
    // legacy attribute aggregation removed
        
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
            
            // Join with product_more_info and related tables for filtering
            if (!empty($filters['size']) || !empty($filters['color']) || !empty($filters['fit']) || 
                (!empty($filters['price_min']) && is_numeric($filters['price_min'])) || 
                (!empty($filters['price_max']) && is_numeric($filters['price_max'])) ||
                (isset($filters['sort']) && in_array($filters['sort'], ['high-to-low', 'low-to-high']))) {
                
                $this->db->join($this->table_product_more_info, "{$this->table_product_more_info}.product_id = {$this->table_name}.id", 'LEFT');
                $product_more_info_joined = true;
                
                if (!empty($filters['size'])) {
                    $this->db->join($this->table_size, "{$this->table_size}.id = {$this->table_product_more_info}.size_id", 'LEFT');
                    $size_joined = true;
                }
                if (!empty($filters['color'])) {
                    $this->db->join($this->table_color, "{$this->table_color}.id = {$this->table_product_more_info}.color_id", 'LEFT');
                    $color_joined = true;
                }
                // Join prices table if needed for price filtering or sorting
                if ((!empty($filters['price_min']) && is_numeric($filters['price_min'])) || 
                    (!empty($filters['price_max']) && is_numeric($filters['price_max'])) ||
                    (isset($filters['sort']) && in_array($filters['sort'], ['high-to-low', 'low-to-high']))) {
                    $this->db->join($this->table_price, "{$this->table_price}.id = {$this->table_product_more_info}.price_id", 'LEFT');
                    $price_joined = true;
                }
            }
            
            $this->db->where("{$this->table_name}.status", 1);
            
            // Category filter
            if (!empty($filters['category']) && strtolower($filters['category']) !== 'all') {
                $this->db->where("{$this->table_category}.name", $filters['category']);
            }
            
            // Add search filter support: match across multiple product columns and variant SKU
            if (!empty($filters['search'])) {
                // Search term
                $term = trim($filters['search']);

                // Build list of candidate product columns to search. We'll only add clauses for columns that exist
                $candidateCols = ['title', 'slug', 'content', 'additional_info', 'keywords', 'tags'];

                $this->db->group_start();
                $firstAdded = false;
                foreach ($candidateCols as $col) {
                    if ($this->db->field_exists($col, $this->table_name)) {
                        if (!$firstAdded) {
                            $this->db->like("{$this->table_name}.{$col}", $term);
                            $firstAdded = true;
                        } else {
                            $this->db->or_like("{$this->table_name}.{$col}", $term);
                        }
                    }
                }

                // If none of the product-level columns were present/added, still try title/slug as a last resort
                if (!$firstAdded) {
                    $this->db->like("{$this->table_name}.title", $term);
                    $firstAdded = true;
                }

                // Also include products whose variants match the term across one or more columns (sku_code, tags)
                $variantCols = [];
                if ($this->db->field_exists('sku_code', 'tbl_product_variants')) $variantCols[] = 'sku_code';
                if ($this->db->field_exists('tags', 'tbl_product_variants')) $variantCols[] = 'tags';

                if (!empty($variantCols)) {
                    $like_quoted = $this->db->escape('%' . $term . '%');
                    $subParts = [];
                    foreach ($variantCols as $vc) {
                        $subParts[] = "$vc LIKE " . $like_quoted;
                    }
                    $sub = "{$this->table_name}.id IN (SELECT product_id FROM tbl_product_variants WHERE " . implode(' OR ', $subParts) . ")";
                    $this->db->or_where($sub);
                }

                $this->db->group_end();
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
            
            // legacy attribute aggregation removed
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
            
            // For price sorting, we need joins - so use a simplified version here without recursion
            if (!empty($filters['sort']) && in_array($filters['sort'], ['high-to-low', 'low-to-high'])) {
                $this->db->select("{$this->table_name}.*");
                $this->db->from($this->table_name);
                $this->db->join($this->table_product_more_info, "{$this->table_product_more_info}.product_id = {$this->table_name}.id", 'LEFT');
                $this->db->join($this->table_price, "{$this->table_price}.id = {$this->table_product_more_info}.price_id", 'LEFT');
                $this->db->where("{$this->table_name}.status", 1);
                
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
            
            // legacy attribute aggregation removed
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

    public function getVariantsGroupedByColor($product_id) {
        // Join all relevant tables and group by color
        $this->db->select(
            'v.id as variant_id, v.color_id, c.name as color_name, v.coupon_id, v.tags, v.ratings, v.sku_code, ' .
            'GROUP_CONCAT(DISTINCT vi.image) as images, ' .
            'GROUP_CONCAT(DISTINCT vs.size_id) as size_ids, ' .
            'GROUP_CONCAT(DISTINCT s.name) as size_names, ' .
            'GROUP_CONCAT(DISTINCT vs.price_id) as price_ids, ' .
            'GROUP_CONCAT(DISTINCT p.name) as price_names'
        , false);
        $this->db->from('tbl_product_variants v');
        $this->db->join('tbl_colors c', 'c.id = v.color_id', 'left');
        $this->db->join('tbl_variant_images vi', 'vi.variant_id = v.id', 'left');
        $this->db->join('tbl_variant_sizes vs', 'vs.variant_id = v.id', 'left');
        $this->db->join('tbl_sizes s', 's.id = vs.size_id', 'left');
        $this->db->join('tbl_prices p', 'p.id = vs.price_id', 'left');
        $this->db->join('tbl_coupons cp', 'cp.id = v.coupon_id', 'left');
        $this->db->where('v.product_id', $product_id);
        $this->db->group_by('v.color_id');
        $variants = $this->db->get()->result_array();
        // Format output for each color group
        foreach ($variants as &$variant) {
            // Split CSV fields, trim values and remove empty entries to avoid arrays with empty strings
            $variant['images'] = $variant['images'] ? array_values(array_filter(array_map('trim', explode(',', $variant['images'])))) : array();
            $variant['size_ids'] = $variant['size_ids'] ? array_values(array_filter(array_map('trim', explode(',', $variant['size_ids'])))) : array();
            $variant['size_names'] = $variant['size_names'] ? array_values(array_filter(array_map('trim', explode(',', $variant['size_names'])))) : array();
            $variant['price_ids'] = $variant['price_ids'] ? array_values(array_filter(array_map('trim', explode(',', $variant['price_ids'])))) : array();
            $variant['price_names'] = $variant['price_names'] ? array_values(array_filter(array_map('trim', explode(',', $variant['price_names'])))) : array();
            // sku_code is already included in $variant
        }
        return $variants;
    }

    /**
     * Return variants grouped by color with detailed images and size-price matrix.
     * Structure:
     * [
     *   {
     *     color_id, color_name,
     *     variant_ids: [],
     *     images: [],
     *     sizes: [ { size_id, size_name, price_name } ],
     *     sku_codes: [],
     *     tags: [],
     *     ratings: []
     *   }
     * ]
     */
    public function getVariantsGroupedByColorDetailed($product_id) {
        $this->db->select('v.id as variant_id, v.color_id, c.name as color_name, v.sku_code, v.tags, v.ratings');
        $this->db->from('tbl_product_variants v');
        $this->db->join('tbl_colors c', 'c.id = v.color_id', 'left');
        $this->db->where('v.product_id', $product_id);
        $rows = $this->db->get()->result_array();

        $groups = [];
        foreach ($rows as $row) {
            $colorId = $row['color_id'];
            if (!isset($groups[$colorId])) {
                $groups[$colorId] = [
                    'color_id' => $colorId,
                    'color_name' => $row['color_name'],
                    'variant_ids' => [],
                    'images' => [],
                    'sizes' => [],
                    'sku_codes' => [],
                    'tags' => [],
                    'ratings' => []
                ];
            }
            $groups[$colorId]['variant_ids'][] = $row['variant_id'];
            if (!empty($row['sku_code'])) $groups[$colorId]['sku_codes'][] = $row['sku_code'];
            if (!empty($row['tags'])) $groups[$colorId]['tags'][] = $row['tags'];
            if (!empty($row['ratings'])) $groups[$colorId]['ratings'][] = $row['ratings'];

            // collect images for this variant
            $this->db->select('image');
            $this->db->from('tbl_variant_images');
            $this->db->where('variant_id', $row['variant_id']);
            $imgs = $this->db->get()->result_array();
            foreach ($imgs as $imgRow) {
                $img = trim($imgRow['image']);
                if ($img !== '' && !in_array($img, $groups[$colorId]['images'])) {
                    $groups[$colorId]['images'][] = $img;
                }
            }

            // collect size-price matrix for this variant
            $this->db->select('vs.size_id, s.name as size_name, p.name as price_name');
            $this->db->from('tbl_variant_sizes vs');
            $this->db->join('tbl_sizes s', 's.id = vs.size_id', 'left');
            $this->db->join('tbl_prices p', 'p.id = vs.price_id', 'left');
            $this->db->where('vs.variant_id', $row['variant_id']);
            $sizeRows = $this->db->get()->result_array();
            foreach ($sizeRows as $sr) {
                // avoid duplicate size entries: key by size_id
                $found = false;
                foreach ($groups[$colorId]['sizes'] as &$existing) {
                    if ($existing['size_id'] == $sr['size_id']) { $found = true; break; }
                }
                if (!$found) {
                    $groups[$colorId]['sizes'][] = [
                        'size_id' => $sr['size_id'],
                        'size_name' => $sr['size_name'],
                        'price_name' => $sr['price_name']
                    ];
                }
            }
        }

        // Convert associative groups to indexed array and normalize tags/sku/ratings
        $out = [];
        foreach ($groups as $g) {
            $g['sku_codes'] = array_values(array_filter(array_unique($g['sku_codes'])));
            $g['tags'] = array_values(array_filter(array_unique($g['tags'])));
            $g['ratings'] = array_values(array_filter($g['ratings']));
            // sort sizes by size_name natural
            usort($g['sizes'], function($a,$b){ return strcmp($a['size_name'],$b['size_name']); });
            $out[] = $g;
        }

        return $out;
    }

}
