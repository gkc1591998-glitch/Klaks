<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
class Search_model extends CI_Model
{

	public $table_products = "tbl_products";
	public $table_products_details = "tbl_product_details";
	// DEPRECATED: Use tbl_variant_sections for section-based filtering instead
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
	}
	public function perform_search($search_data)
	{
		$termsRaw = !empty($search_data['query']) ? trim($search_data['query']) : '';
		if ($termsRaw === '') return [];

		// Prefer DB-powered filtering via Products_model
		$this->load->model('products/Products_model', 'products_model');
		$filters = ['search' => $termsRaw];
		$products = $this->products_model->filterProducts($filters);

		// Attach grouped variants via home_model for rendering
		$this->load->model('home/Home_model','home_model');
		$productIds = array_values(array_filter(array_map(function($p){ return isset($p['id']) ? $p['id'] : null; }, $products)));
		if (!empty($productIds)) {
			$groupsMap = $this->home_model->getGroupedVariantsForProductIds($productIds);
			foreach ($products as &$p) {
				$pid = isset($p['id']) ? $p['id'] : null;
				$p['variants_grouped_by_color'] = $pid && isset($groupsMap[$pid]) ? $groupsMap[$pid] : [];
			}
			unset($p);
		}

		return array_values($products);
	}
}
