<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wishlist_model extends CI_Model {
    
    public $table_name = "tbl_wishlist";
    
    public function __construct() {
        parent::__construct();
        error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        error_reporting(0);
        ini_set('display_errors','off');
    }
    
    /**
     * Add product to wishlist with variant support
     */
    public function add_to_wishlist($user_id, $product_id, $product_more_info_id = null) {
        // Check if already exists (variant-specific if variant provided)
        if ($this->is_in_wishlist($user_id, $product_id, $product_more_info_id)) {
            return false; // Already in wishlist
        }
        
        $data = array(
            'user_id' => $user_id,
            'product_id' => $product_id,
            'product_more_info_id' => $product_more_info_id, // Store variant ID for variant-specific wishlist
            'created_at' => date('Y-m-d H:i:s')
        );
        
        return $this->db->insert($this->table_name, $data);
    }
    
    /**
     * Remove product from wishlist with variant support
     */
    public function remove_from_wishlist($user_id, $product_id, $product_more_info_id = null) {
        $this->db->where('user_id', $user_id);
        $this->db->where('product_id', $product_id);
        
        // If variant ID provided, remove only that specific variant
        if ($product_more_info_id !== null) {
            $this->db->where('product_more_info_id', $product_more_info_id);
        } else {
            // If no variant specified, remove all variants of this product
            // This is for backward compatibility
        }
        
        return $this->db->delete($this->table_name);
    }
    
    /**
     * Check if product is in user's wishlist with variant support
     */
    public function is_in_wishlist($user_id, $product_id, $product_more_info_id = null) {
        $this->db->where('user_id', $user_id);
        $this->db->where('product_id', $product_id);
        
        // If variant ID provided, check for that specific variant
        if ($product_more_info_id !== null) {
            $this->db->where('product_more_info_id', $product_more_info_id);
        }
        
        $query = $this->db->get($this->table_name);
        return $query->num_rows() > 0;
    }
    
    /**
     * Get user's wishlist with product details (refactored for correct schema)
     */
    public function get_user_wishlist($user_id) {
        // Get wishlist product IDs
        $this->db->select('w.product_id');
        $this->db->from($this->table_name . ' w');
        $this->db->where('w.user_id', $user_id);
        $this->db->group_by('w.product_id'); // Use GROUP BY instead of DISTINCT
        $this->db->order_by('w.created_at', 'DESC');
        $wishlist_query = $this->db->get();
        $wishlist_products = $wishlist_query->result_array();
        
        if (empty($wishlist_products)) {
            return array();
        }
        
        $product_ids = array_column($wishlist_products, 'product_id');
        
        // Get complete product data
        $this->db->select('p.*, cat.name as category_name, subcat.name as subcategory_name');
        $this->db->from('tbl_products p');
        $this->db->join('tbl_category cat', 'p.cat_id = cat.id', 'left');
        $this->db->join('tbl_subcategory subcat', 'p.subcat_id = subcat.id', 'left');
        $this->db->where_in('p.id', $product_ids);
        $this->db->where('p.status', 1);
        $products_query = $this->db->get();
        $products = $products_query->result_array();
        
        // Get variants grouped by color for each product (reusing existing logic)
        foreach ($products as &$product) {
            // Use the home model's existing method if available
            $CI =& get_instance();
            $CI->load->model('home/Home_model', 'home_model');
            
            try {
                // Try to use existing grouped variants method
                $grouped_variants = $CI->home_model->getGroupedVariantsForProductIds([$product['id']]);
                $product['variants_grouped_by_color'] = isset($grouped_variants[$product['id']]) ? $grouped_variants[$product['id']] : [];
                
                // Also get simple attributes for compatibility
                $product['attributes'] = $this->get_simple_product_attributes($product['id']);
            } catch (Exception $e) {
                error_log('Error getting variants for product ' . $product['id'] . ': ' . $e->getMessage());
                $product['variants_grouped_by_color'] = [];
                $product['attributes'] = [];
            }
        }
        
        return $products;
    }
    
    /**
     * Get simple product attributes for compatibility
     */
    private function get_simple_product_attributes($product_id) {
        try {
            $this->db->select('pv.id as variant_id, pv.sku_code, 
                               vs.sale_price, vs.stock,
                               s.name as size_name, 
                               c.name as color_name,
                               p.name as price_name');
            $this->db->from('tbl_product_variants pv');
            $this->db->join('tbl_variant_sizes vs', 'pv.id = vs.variant_id', 'left');
            $this->db->join('tbl_sizes s', 'vs.size_id = s.id', 'left');
            $this->db->join('tbl_colors c', 'pv.color_id = c.id', 'left');
            $this->db->join('tbl_prices p', 'vs.price_id = p.id', 'left');
            $this->db->where('pv.product_id', $product_id);
            $this->db->where('pv.status', 1);
            $this->db->limit(10); // Limit to avoid too many variants
            
            $query = $this->db->get();
            $attributes = $query->result_array();
            
            // Process attributes to use sale_price if available
            foreach ($attributes as &$attr) {
                if (!empty($attr['sale_price']) && $attr['sale_price'] > 0) {
                    $attr['price_name'] = $attr['sale_price'];
                } elseif (empty($attr['price_name'])) {
                    $attr['price_name'] = '0.00';
                }
            }
            
            return $attributes;
        } catch (Exception $e) {
            error_log('Error getting attributes for product ' . $product_id . ': ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get wishlist count for user
     */
    public function get_wishlist_count($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results($this->table_name);
    }
    
    /**
     * Clear user's entire wishlist
     */
    public function clear_wishlist($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->delete($this->table_name);
    }
    
    /**
     * Check which products from a list are in user's wishlist
     */
    public function check_products_in_wishlist($user_id, $product_ids) {
        $this->db->select('product_id');
        $this->db->where('user_id', $user_id);
        $this->db->where_in('product_id', $product_ids);
        $query = $this->db->get($this->table_name);
        
        $result = array();
        foreach ($query->result() as $row) {
            $result[] = $row->product_id;
        }
        
        return $result;
    }
    
    /**
     * Check variant-specific wishlist status for products
     * Returns array with product_id => [variant_ids_in_wishlist]
     */
    public function check_variants_in_wishlist($user_id, $product_ids) {
        $this->db->select('product_id, product_more_info_id');
        $this->db->where('user_id', $user_id);
        $this->db->where_in('product_id', $product_ids);
        $query = $this->db->get($this->table_name);
        
        $result = array();
        foreach ($query->result() as $row) {
            $product_id = $row->product_id;
            $variant_id = $row->product_more_info_id;
            
            if (!isset($result[$product_id])) {
                $result[$product_id] = array();
            }
            
            // Store variant ID if exists, otherwise mark as general product wishlist
            if ($variant_id !== null) {
                $result[$product_id][] = $variant_id;
            } else {
                // For backward compatibility - if no variant specified, 
                // consider the entire product as wishlisted
                $result[$product_id][] = 'all';
            }
        }
        
        return $result;
    }
    
    /**
     * Move wishlist item to cart
     */
    public function move_to_cart($user_id, $product_id, $product_more_info_id = null) {
        // This method can be used to move items from wishlist to cart
        // First we'd add to cart, then remove from wishlist
        return $this->remove_from_wishlist($user_id, $product_id, $product_more_info_id);
    }
}
