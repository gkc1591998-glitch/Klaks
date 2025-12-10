<?php class Products_model extends CI_Model
{
	public $table_name = 'tbl_products';
	public $table_category = 'tbl_category';
	public $table_subcategory = 'tbl_subcategory';
	public $table_child_category = 'tbl_category_child';
	public $table_brands = 'tbl_brands';
	public $table_discount = 'tbl_discount';
	public $table_section = 'tbl_sections';
	public $table_price = 'tbl_prices';
	public $table_size = 'tbl_sizes';
	public $table_color = 'tbl_colors';
	public $table_coupon = 'tbl_coupons';
	public $table_product_details = 'tbl_product_details';
	public $table_product_more_info = 'tbl_products_more_info';
	public function __construct()
	{
		parent::__construct();
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    error_reporting(-1);
    ini_set('display_errors', 'on');
	}
	public function get_all_records()
	{
		$this->db->select(
			"{$this->table_name}.*, " .
				"{$this->table_category}.name as category_name, " .
				"{$this->table_subcategory}.name as subcategory_name, " .
				"{$this->table_child_category}.child_category_name as child_category_name",
			false
		);
		$this->db->from($this->table_name);
		$this->db->join($this->table_category, "{$this->table_category}.id = {$this->table_name}.cat_id", 'LEFT');
		$this->db->join($this->table_subcategory, "{$this->table_subcategory}.id = {$this->table_name}.subcat_id", 'LEFT');
		$this->db->join($this->table_child_category, "{$this->table_child_category}.id = {$this->table_name}.childcat_id", 'LEFT');
		$this->db->group_by("{$this->table_name}.id");
		$this->db->order_by("{$this->table_name}.id", 'desc');
		$query = $this->db->get();
		$result = $query->result_array();
		// Attach full attribute rows for each product
		foreach ($result as &$product) {
			$product['attributes'] = $this->get_product_attributes_full_joined($product['id']);
		}
		return $result;
	}

	/**
	 * Get all product attribute rows for a product, joined with all info tables
	 * @param int $product_id
	 * @return array
	 */
	public function get_product_attributes_full_joined($product_id)
	{
		// TODO: This table doesn't exist anymore. The system now uses tbl_product_variants.
		// Return empty array to prevent errors while maintaining compatibility.
		return [];
		
		/* OLD CODE - commenting out since tbl_products_more_info doesn't exist
		$this->db->select(
			$this->table_product_more_info . ".*",
			false
		);
		$this->db->select(
			$this->table_section . ".name as section_name, " .
				$this->table_price . ".name as price_name, " .
				$this->table_size . ".name as size_name, " .
				$this->table_color . ".name as color_name, " .
				$this->table_coupon . ".name as coupon_code, " .
				$this->table_brands . ".name as brand_name",
			false
		);
		$this->db->from($this->table_product_more_info);
		$this->db->join($this->table_section, $this->table_section . '.id = ' . $this->table_product_more_info . '.section_id', 'LEFT');
		$this->db->join($this->table_price, $this->table_price . '.id = ' . $this->table_product_more_info . '.price_id', 'LEFT');
		$this->db->join($this->table_size, $this->table_size . '.id = ' . $this->table_product_more_info . '.size_id', 'LEFT');
		$this->db->join($this->table_color, $this->table_color . '.id = ' . $this->table_product_more_info . '.color_id', 'LEFT');
		$this->db->join($this->table_coupon, $this->table_coupon . '.id = ' . $this->table_product_more_info . '.coupon_id', 'LEFT');
		// If you want brand info, you need to join tbl_products for brand_id
		$this->db->join($this->table_name, $this->table_name . '.id = ' . $this->table_product_more_info . '.product_id', 'LEFT');
		$this->db->join($this->table_brands, $this->table_brands . '.id = ' . $this->table_product_more_info . '.brand_id', 'LEFT');
		$this->db->where($this->table_product_more_info . '.product_id', $product_id);
		$this->db->order_by($this->table_product_more_info . '.id', 'desc');
		$query = $this->db->get();
		return $query->result_array();
		*/
	}

	public function get_cat()
	{
		$this->db->select("id,name");
		$this->db->from($this->table_category);
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public function get_discounts()
	{
		$this->db->select("id,name");
		$this->db->from($this->table_discount);
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	public function get_brands()
	{
		$this->db->select("id,name");
		$this->db->from($this->table_brands);
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	public function get_all_cities_ajax($id)
	{
		$this->db->select("id,name");
		$this->db->from($this->table_subcategory);
		$this->db->where("cat_id", $id);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query->result_array();
		return $result;
	}
	public function get_all_areas_ajax($id)
	{
		$this->db->select("id,child_category_name");
		$this->db->from($this->table_child_category);
		$this->db->where("sub_category_id", $id);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query->result_array();
		//echo "<pre>";print_r($result);exit;
		return $result;
	}

	public function get_single_record($id = '')
	{
		$this->db->select("*");
		$this->db->from($this->table_name);
		if ($id != '') {
			$this->db->where("id", $id);
			$query = $this->db->get();
			//echo $this->db->last_query();
			$result = $query->row_array();
		}
		return $result;
	}


	public function get_last_record()
	{
		$this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->order_by('id', 'desc');
		$this->db->limit('1');
		$query = $this->db->get();
		$result = $query->row_array();
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

	public function generate_unique_slug($cat_id, $subcat_id, $product_name, $id = null)
	{
		// Get category name
		$this->db->select('name');
		$this->db->where('id', $cat_id);
		$cat_query = $this->db->get($this->table_category);
		$cat_row = $cat_query->row_array();
		$cat_name = isset($cat_row['name']) ? $cat_row['name'] : '';
		// Get subcategory name
		$this->db->select('name');
		$this->db->where('id', $subcat_id);
		$subcat_query = $this->db->get($this->table_subcategory);
		$subcat_row = $subcat_query->row_array();
		$subcat_name = isset($subcat_row['name']) ? $subcat_row['name'] : '';
		// Build base slug: category-subcategory-product
		$cat_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $cat_name)));
		$subcat_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $subcat_name)));
		$prod_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product_name)));
		$full_slug = $cat_slug . '-' . $subcat_slug . '-' . $prod_slug;
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

	public function add_record($attributes)
	{
		$cat_id = $this->input->post('cat_id');
		$subcat_id = $this->input->post('subcat_id');
		$childcat_id = $this->input->post('childcat_id');
		$title = ucwords($this->input->post('title'));
		$slug = $this->generate_unique_slug($cat_id, $subcat_id, $title);
		$set_data = array(
			'cat_id' => (int)$this->input->post('cat_id'),
			'subcat_id' => (int)$this->input->post('subcat_id'),
			'childcat_id' => (int)$this->input->post('childcat_id'),
			'title' => ucwords($this->input->post('title')),
			'available' => ucwords($this->input->post('available')),
			'content' => str_replace(array("\r\n", "\r", "\n"), '', $this->input->post('content')),
			'additional_info' => str_replace(array("\r\n", "\r", "\n"), '', $this->input->post('additional_info')),
			'status' => 1,
			'created_date_time' => date('Y-m-d H:i:s'),
			'updated_date_time' => date('Y-m-d H:i:s'),
			'slug' => $slug
		);
		//echo "<pre>";print_r($set_data);exit;
		$result = $this->db->insert($this->table_name, $set_data);
		$last_insert_id = $this->db->insert_id();
		
		// Save regular product attributes if provided (legacy system compatibility)
		if ($attributes && is_array($attributes)) {
			$this->save_product_attributes($last_insert_id, $attributes);
		}
		
		return $result;
	}

	public function update_record($id, $attributes)
	{
		$cat_id = $this->input->post('cat_id');
		$subcat_id = $this->input->post('subcat_id');
		$childcat_id = $this->input->post('childcat_id');
		$title = ucwords($this->input->post('title'));
		$slug = $this->generate_unique_slug($cat_id, $subcat_id, $title, $id);
		// echo "<pre>";print_r($attributes);exit;
		$set_data = array(
			'cat_id' => (int)$this->input->post('cat_id'),
			'subcat_id' => (int)$this->input->post('subcat_id'),
			'childcat_id' => (int)$this->input->post('childcat_id'),
			'title' => ucwords($this->input->post('title')),
			'available' => ucwords($this->input->post('available')),
			'content' => str_replace(array("\r\n", "\r", "\n"), '', $this->input->post('content')),
			'additional_info' => str_replace(array("\r\n", "\r", "\n"), '', $this->input->post('additional_info')),
			'updated_date_time' => date('Y-m-d H:i:s'),
			'slug' => $slug
		);
		$this->db->where('id', $id);
		$result = $this->db->update($this->table_name, $set_data);
		$this->delete_record_group_names($id);
		// Save product attributes if provided
		if ($attributes && is_array($attributes)) {
			$this->save_product_attributes($id, $attributes);
		}
		return $result;
	}

	public function delete_record_group_names($id)
	{
		$this->db->where('lid', $id);
		$result = $this->db->delete($this->table_product_details);
		return $result;
	}

	public function get_groups_data($id)
	{
		$this->db->select("*");
		$this->db->from($this->table_product_details);
		$this->db->order_by('id', 'desc');
		$this->db->where('lid', $id);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	public function get_item_data($id)
	{
		$this->db->select("*");
		$this->db->from($this->table_product_details);
		$this->db->order_by('id', 'desc');
		$this->db->where('lid', $id);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	// public function put_group_people($last_insert_id)
	// {
	// 	$size  = array();
	// 	$size = array_filter($this->input->post('size'));

	//         $quantity = array_filter($this->input->post('quantity'));
	// 	$avail = array_filter($this->input->post('prod'));
	// 		for($i=0;$i<(count($size));$i++)
	// 		{
	// 			$set_data = array
	// 			(					  
	// 			   'lid' => $last_insert_id,
	// 			  'size' => mysql_real_escape_string(trim($size[$i])),
	//                   'quantity' => mysql_real_escape_string(trim($quantity[$i])),

	// 			  'avail' => mysql_real_escape_string(trim($avail[$i])),
	// 			);
	// 			//echo "<pre>";print_r($set_data);exit;
	// 			$groups_result = $this->db->insert("tbl_product_details", $set_data);
	// 		}
	// 		return $groups_result;
	//   }

	public function delete_record($id)
	{
		// Delete product attributes first
		$this->delete_product_attributes($id);
		$query = $this->db->select("*")->from($this->table_name)->where('id', $id)->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			if ($result[0]->image1 != '0') {
				$delete1 = @unlink(FCPATH . 'images/products/' . $result[0]->image1);
			}

			if ($result[0]->image2 != '0') {
				$delete2 = @unlink(FCPATH . 'images/products/' . $result[0]->image2);
			}

			if ($result[0]->image3 != '0') {
				$delete3 = @unlink(FCPATH . 'images/products/' . $result[0]->image3);
			}
			if ($result[0]->image4 != '0') {
				$delete4 = @unlink(FCPATH . 'images/products/' . $result[0]->image4);
			}
			if ($result[0]->image5 != '0') {
				$delete5 = @unlink(FCPATH . 'images/products/' . $result[0]->image5);
			}

			$this->db->where('id', $id);
			$result = $this->db->delete($this->table_name);
			if ($result) {
				return 1;
			} else {
				return 0;
			}
		}
	}

	public function status_record($id, $status)
	{
		$sts = ($status == 1 ? 0 : 1);
		$set_data = array(
			'status' => $sts
		);
		$this->db->where('id', $id);
		$result = $this->db->update($this->table_name, $set_data);
		return $result;
	}

	public function lux_status_record($id, $status)
	{
		$sts = ($status == 1 ? 0 : 1);
		$set_data = array(
			'show_in_lux' => $sts
		);
		$this->db->where('id', $id);
		$result = $this->db->update($this->table_name, $set_data);
		return $result;
	}

	public function hstatus_record($id, $status)
	{
		$sts = ($status == 1 ? 0 : 1);
		$set_data = array(
			'hstatus' => $sts
		);
		$this->db->where('id', $id);
		$result = $this->db->update($this->table_name, $set_data);
		return $result;
	}

	public function updateSellingCategory($id, $status)
	{
		$set_data = array(
			'selling_category' => $status
		);
		$this->db->where('id', $id);
		$result = $this->db->update($this->table_name, $set_data);
		return $result;
	}

	public function get_mysqli()
	{
		$db = (array)get_instance()->db;
		return mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
	}

	/**
	 * Save multiple product attribute rows for a product into tbl_products_more_info
	 * @param int $product_id
	 * @param array $attributes Each item: ['section_id'=>, 'price_id'=>, 'size_id'=>, 'color_id'=>, 'coupon_id'=>, 'image'=>]
	 * @return bool
	 */
	public function save_product_attributes($product_id, $attributes = array())
	{
		// echo "<pre>";print_r($attributes);exit;
		// Remove old attributes for this product
		$this->db->where('product_id', $product_id);
		$this->db->delete($this->table_product_more_info);
		// Always treat $attributes as array of rows (from controller)
		if (!empty($attributes) && is_array($attributes)) {
			foreach ($attributes as $row) {
				$data = array(
					'product_id'  => $product_id,
					'section_id'  => isset($row['section_id']) ? $row['section_id'] : null,
					'price_id'    => isset($row['price_id']) ? $row['price_id'] : null,
					'size_id'     => isset($row['size_id']) ? $row['size_id'] : null,
					'color_id'    => isset($row['color_id']) ? $row['color_id'] : null,
					'coupon_id'   => isset($row['coupon_id']) ? $row['coupon_id'] : null,
					'image'       => isset($row['image']) ? $row['image'] : null,
					'unique_id'   => isset($row['unique_id']) ? $row['unique_id'] : uniqid(),
					'created_date_time'  => date('Y-m-d H:i:s'),
					'updated_date_time'  => date('Y-m-d H:i:s'),
				);
				$this->db->insert($this->table_product_more_info, $data);
			}
		}
		return true;
	}

	/**
	 * Delete all product attribute rows for a product - DEPRECATED
	 * The tbl_products_more_info table no longer exists
	 * @param int $product_id
	 * @return bool
	 */
	public function delete_product_attributes($product_id)
	{
		// DEPRECATED: tbl_products_more_info table no longer exists
		// Return true for backward compatibility
		return true;
	}

	public function get_product_attributes($product_id)
	{
		// DEPRECATED: tbl_products_more_info table no longer exists
		// Use the modern variant system instead via Home_model->getGroupedVariantsForProductIds()
		// Return empty array for backward compatibility
		return [];
	}

	/* Product Variants Methods */
	// public function get_product_variants($product_id) {
	// 	// Select main variant fields and color name
	// 	$this->db->select('v.*, c.name as color_name');
	// 	$this->db->select('GROUP_CONCAT(DISTINCT vi.image) as images', false);
	// 	$this->db->select('GROUP_CONCAT(DISTINCT s.section_id) as section_ids', false);
	// 	$this->db->select('GROUP_CONCAT(DISTINCT sec.name) as section_names', false);
	// 	$this->db->select('GROUP_CONCAT(DISTINCT vs.size_id) as size_ids', false);
	// 	$this->db->select('GROUP_CONCAT(DISTINCT CONCAT(vs.size_id, ":", vs.price_id, ":", vs.status)) as size_data', false);
		
	// 	// Main variant table
	// 	$this->db->from('tbl_product_variants v');
		
	// 	// Join with colors
	// 	$this->db->join('tbl_colors c', 'c.id = v.color_id', 'left');
		
	// 	// Join with variant images
	// 	$this->db->join('tbl_variant_images vi', 'vi.variant_id = v.id', 'left');
		
	// 	// Join with variant sections
	// 	$this->db->join('tbl_variant_sections s', 's.variant_id = v.id', 'left');
	// 	$this->db->join('tbl_sections sec', 'sec.id = s.section_id', 'left');
		
	// 	// Join with variant sizes
	// 	$this->db->join('tbl_variant_sizes vs', 'vs.variant_id = v.id', 'left');
		
	// 	// Filter by product
	// 	$this->db->where('v.product_id', $product_id);
		
	// 	// Group by variant id to combine related records
	// 	$this->db->group_by('v.id');
		
	// 	// Get results
	// 	$variants = $this->db->get()->result_array();
		
	// 	// Process the results to format the data
	// 	foreach($variants as &$variant) {
	// 		// Convert images string to array
	// 		$variant['images'] = $variant['images'] ? explode(',', $variant['images']) : array();
			
	// 		// Convert sections string to array
	// 		$variant['section_ids'] = $variant['section_ids'] ? explode(',', $variant['section_ids']) : array();
	// 		$variant['sections'] = array();
	// 		if($variant['section_names']) {
	// 			$section_names = explode(',', $variant['section_names']);
	// 			foreach($section_names as $i => $name) {
	// 				if(isset($variant['section_ids'][$i])) {
	// 					$variant['sections'][] = array(
	// 						'id' => $variant['section_ids'][$i],
	// 						'name' => $name
	// 					);
	// 				}
	// 			}
	// 		}
	// 		unset($variant['section_names']);
			
	// 		// Process size data into structured array
	// 		$variant['sizes'] = array();
	// 		if($variant['size_data']) {
	// 			$size_entries = explode(',', $variant['size_data']);
	// 			foreach($size_entries as $entry) {
	// 				list($size_id, $price_id, $status) = explode(':', $entry);
	// 				$variant['sizes'][$size_id] = array(
	// 					'size_id' => $size_id,
	// 					'price_id' => $price_id,
	// 					'status' => $status
	// 				);
	// 			}
	// 		}
	// 		unset($variant['size_data']);
	// 		unset($variant['size_ids']);
	// 	}
		
	// 	return $variants;
	// }

	// public function get_variant($variant_id) {
	// 	$this->db->where('id', $variant_id);
	// 	return $this->db->get('tbl_product_variants')->row_array();
	// }

	// public function add_variant($data) {
	// 	$this->db->insert('tbl_product_variants', $data);
	// 	return $this->db->insert_id();
	// }

	// public function update_variant($variant_id, $data) {
	// 	$this->db->where('id', $variant_id);
	// 	return $this->db->update('tbl_product_variants', $data);
	// }

	// public function delete_variant($variant_id) {
	// 	// Delete related records first
	// 	$this->db->where('variant_id', $variant_id);
	// 	$this->db->delete('tbl_variant_images');
		
	// 	$this->db->where('variant_id', $variant_id);
	// 	$this->db->delete('tbl_variant_sizes');
		
	// 	$this->db->where('variant_id', $variant_id);
	// 	$this->db->delete('tbl_variant_sections');
		
	// 	// Delete the variant
	// 	$this->db->where('id', $variant_id);
	// 	return $this->db->delete('tbl_product_variants');
	// }

	// public function get_variant_images($variant_id) {
	// 	$this->db->where('variant_id', $variant_id);
	// 	return $this->db->get('tbl_variant_images')->result_array();
	// }

	// public function add_variant_image($variant_id, $variant_image_data) {
	// 	$variant_image_data['variant_id'] = $variant_id;
	// 	return $this->db->insert('tbl_variant_images', $variant_image_data);
	// }

	// public function delete_variant_image($image_id) {
	// 	$this->db->where('id', $image_id);
	// 	$image = $this->db->get('tbl_variant_images')->row_array();
		
	// 	if($image && file_exists('./images/products/'.$image['image_name'])) {
	// 		unlink('./images/products/'.$image['image_name']);
	// 	}
		
	// 	$this->db->where('id', $image_id);
	// 	return $this->db->delete('tbl_variant_images');
	// }

	// public function get_variant_sizes($variant_id) {
	// 	$this->db->where('variant_id', $variant_id);
	// 	$result = $this->db->get('tbl_variant_sizes')->result_array();
	// 	$sizes = array();
	// 	foreach($result as $row) {
	// 		$sizes[$row['size_id']] = $row;
	// 	}
	// 	return $sizes;
	// }

	// public function save_variant_size($variant_id, $size_id, $data) {
	// 	$this->db->where('variant_id', $variant_id);
	// 	$this->db->where('size_id', $size_id);
	// 	$exists = $this->db->get('tbl_variant_sizes')->row();
		
	// 	if($exists) {
	// 		$this->db->where('variant_id', $variant_id);
	// 		$this->db->where('size_id', $size_id);
	// 		return $this->db->update('tbl_variant_sizes', $data);
	// 	} else {
	// 		return $this->db->insert('tbl_variant_sizes', $data);
	// 	}
	// }

	// public function get_variant_sections($variant_id) {
	// 	$this->db->select('section_id');
	// 	$this->db->where('variant_id', $variant_id);
	// 	$result = $this->db->get('tbl_variant_sections')->result_array();
	// 	return array_column($result, 'section_id');
	// }

	// public function save_variant_sections($variant_id, $sections) {
	// 	// Delete existing sections
	// 	$this->db->where('variant_id', $variant_id);
	// 	$this->db->delete('tbl_variant_sections');
		
	// 	// Add new sections
	// 	if($sections) {
	// 		$data = array();
	// 		foreach($sections as $section_id) {
	// 			$data[] = array(
	// 				'variant_id' => $variant_id,
	// 				'section_id' => $section_id
	// 			);
	// 		}
	// 		return $this->db->insert_batch('tbl_variant_sections', $data);
	// 	}
	// 	return true;
  
	// 	//echo $this->db->last_query();exit;
	// 	$result = $query->result_array();
	// 	return $result;
	// }

	public function get_product_video($product_id)
	{
		$this->db->select('product_video');
		$this->db->where('id', $product_id);
		$query = $this->db->get($this->table_name);
		$result = $query->row();
		return $result ? $result->product_video : null;
	}

	/**
	 * Check if a product should be treated as an accessory (One Size only)
	 * Accessories are detected by category names or specific keywords
	 * @param mixed $product_id_or_cat_id - Product ID or category ID for new products
	 * @param int $subcat_id - Subcategory ID (optional for existing products)
	 * @param string $title - Product title (optional for existing products)
	 * @return bool
	 */
	public function is_accessory_product($product_id_or_cat_id, $subcat_id = null, $title = null)
	{
		// If called with multiple parameters, it's for a new product
		if ($subcat_id !== null && $title !== null) {
			$cat_id = $product_id_or_cat_id;
			
			// Get category name
			$this->db->select('name');
			$this->db->where('id', $cat_id);
			$cat_query = $this->db->get($this->table_category);
			$category_name = '';
			if ($cat_query->num_rows() > 0) {
				$category_name = $cat_query->row()->name;
			}
			
			// Get subcategory name
			$this->db->select('name');
			$this->db->where('id', $subcat_id);
			$subcat_query = $this->db->get($this->table_subcategory);
			$subcategory_name = '';
			if ($subcat_query->num_rows() > 0) {
				$subcategory_name = $subcat_query->row()->name;
			}
			
			$product_title = $title;
		} else {
			// Called with product ID for existing product
			$product_id = $product_id_or_cat_id;
			
			// Get product with category information
			$this->db->select('p.*, c.name as category_name, sc.name as subcategory_name');
			$this->db->from($this->table_name . ' p');
			$this->db->join($this->table_category . ' c', 'c.id = p.cat_id', 'left');
			$this->db->join($this->table_subcategory . ' sc', 'sc.id = p.subcat_id', 'left');
			$this->db->where('p.id', $product_id);
			$query = $this->db->get();
			$product = $query->row_array();
			
			if (!$product) {
				return false;
			}
			
			$category_name = $product['category_name'] ?? '';
			$subcategory_name = $product['subcategory_name'] ?? '';
			$product_title = $product['title'] ?? '';
		}
		
		// Define accessory categories/keywords
		$accessory_keywords = [
			'accessories', 'accessory', 'watch', 'watches', 'belt', 'belts', 
			'bag', 'bags', 'wallet', 'wallets', 'sunglasses', 'glasses',
			'jewelry', 'jewellery', 'necklace', 'bracelet', 'ring', 'earring',
			'cap', 'caps', 'hat', 'hats', 'scarf', 'scarves'
		];
		
		// Check category and subcategory names
		$category_name = strtolower($category_name);
		$subcategory_name = strtolower($subcategory_name);
		$product_title = strtolower($product_title);
		
		foreach ($accessory_keywords as $keyword) {
			if (strpos($category_name, $keyword) !== false || 
				strpos($subcategory_name, $keyword) !== false ||
				strpos($product_title, $keyword) !== false) {
				return true;
			}
		}
		
		return false;
	}

	public function update_product_video($product_id, $video_name)
	{
		// echo $product_id, $video_name;exit;
		$this->db->where('id', $product_id);
		return $this->db->update($this->table_name, array('product_video' => $video_name));
	}
}
