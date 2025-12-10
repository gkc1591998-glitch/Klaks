<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Filter Helper Library
 * Common filter-related functionality across modules
 */
class Filter_helper {
    
    protected $CI;
    
    public function __construct() {
        $this->CI =& get_instance();
    }
    
    /**
     * Get available colors from database with consistent formatting
     */
    public function get_available_colors($module_specific = null) {
        $this->CI->load->model('Common_model');
        
        $colors = $this->CI->Common_model->get_active_colors();
        
        // Apply module-specific filtering if needed
        if ($module_specific === 'homelux') {
            // Filter for luxury products only
            $colors = array_filter($colors, function($color) {
                return !empty($color['show_in_lux']);
            });
        }
        
        return $colors;
    }
    
    /**
     * Get available sizes from database
     */
    public function get_available_sizes($module_specific = null) {
        $this->CI->load->model('Common_model');
        
        $sizes = $this->CI->Common_model->get_active_sizes();
        
        return $sizes;
    }
    
    /**
     * Get categories for filter display
     */
    public function get_filter_categories($parent_category = null) {
        $this->CI->load->model('categories/Categories_model', 'categories_model');
        
        if ($parent_category) {
            return $this->CI->categories_model->getSubcategoriesByParentSlug($parent_category);
        }
        
        return $this->CI->categories_model->getAllActiveCategories();
    }
    
    /**
     * Process filter parameters from POST/GET
     */
    public function process_filter_params() {
        $filters = [];
        
        // Get filter values from request
        $filters['category'] = $this->CI->input->get_post('category');
        $filters['subcategory'] = $this->CI->input->get_post('subcategory');
        $filters['size'] = $this->CI->input->get_post('size');
        $filters['color'] = $this->CI->input->get_post('color');
        $filters['price_min'] = $this->CI->input->get_post('price_min');
        $filters['price_max'] = $this->CI->input->get_post('price_max');
        $filters['sort'] = $this->CI->input->get_post('sort', TRUE) ?: 'newest';
        
        // Process price range
        $price_range = $this->CI->input->get_post('price');
        if ($price_range) {
            $this->_parse_price_range($price_range, $filters);
        }
        
        // Remove empty filters
        $filters = array_filter($filters, function($value) {
            return !empty($value);
        });
        
        return $filters;
    }
    
    /**
     * Parse price range string like "500-1000" into min/max
     */
    private function _parse_price_range($price_range, &$filters) {
        if ($price_range === '5000+') {
            $filters['price_min'] = 5000;
        } else if (strpos($price_range, '-') !== false) {
            list($min, $max) = explode('-', $price_range);
            $filters['price_min'] = (int)$min;
            $filters['price_max'] = (int)$max;
        }
    }
    
    /**
     * Build WHERE conditions for database queries based on filters
     */
    public function build_filter_conditions($filters, $table_alias = 'p') {
        $conditions = [];
        $bind_params = [];
        
        if (!empty($filters['category'])) {
            $conditions[] = "c.slug = ?";
            $bind_params[] = $filters['category'];
        }
        
        if (!empty($filters['subcategory'])) {
            $conditions[] = "sc.slug = ?";
            $bind_params[] = $filters['subcategory'];
        }
        
        if (!empty($filters['size'])) {
            $conditions[] = "pv.size_name = ?";
            $bind_params[] = $filters['size'];
        }
        
        if (!empty($filters['color'])) {
            $conditions[] = "col.name = ?";
            $bind_params[] = $filters['color'];
        }
        
        if (!empty($filters['price_min'])) {
            $conditions[] = "{$table_alias}.sale_price >= ?";
            $bind_params[] = $filters['price_min'];
        }
        
        if (!empty($filters['price_max'])) {
            $conditions[] = "{$table_alias}.sale_price <= ?";
            $bind_params[] = $filters['price_max'];
        }
        
        return [
            'conditions' => $conditions,
            'params' => $bind_params
        ];
    }
    
    /**
     * Get ORDER BY clause based on sort parameter
     */
    public function get_sort_order($sort_by, $table_alias = 'p') {
        switch ($sort_by) {
            case 'price_low':
                return "{$table_alias}.sale_price ASC";
            case 'price_high':
                return "{$table_alias}.sale_price DESC";
            case 'popular':
                return "{$table_alias}.view_count DESC, {$table_alias}.id DESC";
            case 'name':
                return "{$table_alias}.name ASC";
            case 'newest':
            default:
                return "{$table_alias}.id DESC";
        }
    }
    
    /**
     * Format filter data for view rendering
     */
    public function prepare_filter_data($module = 'products') {
        $data = [];
        
        $data['available_colors'] = $this->get_available_colors(
            $module === 'homelux' ? 'homelux' : null
        );
        $data['available_sizes'] = $this->get_available_sizes();
        $data['filter_categories'] = $this->get_filter_categories();
        
        return $data;
    }
}