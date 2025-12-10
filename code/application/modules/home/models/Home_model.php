<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model
{
	public $table_sliders = "tbl_sliders";
	public $table_products = "tbl_products";
	public $table_products_details = "tbl_product_details";
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
	// DEPRECATED: Use tbl_variant_sections for section-based filtering instead
	// public $table_product_more_info = 'tbl_products_more_info';
	public $table_partners = 'tbl_partners';

	// Default slugs (can be overridden via config items)
	public $slug_men = 'men';
	public $slug_women = 'women';
	public $slug_accessories = 'accessories';

	public function __construct()
	{
		parent::__construct();
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors', 'off');

		// Allow overriding category slugs via config (application/config/config.php or a module config)
		if (isset($this->config)) {
			$this->slug_men = $this->config->item('home_slug_men') ?: $this->slug_men;
			$this->slug_women = $this->config->item('home_slug_women') ?: $this->slug_women;
			$this->slug_accessories = $this->config->item('home_slug_accessories') ?: $this->slug_accessories;
		}
	}

	public function get_sliders()
	{
		$this->db->select("*");
		$this->db->from($this->table_sliders);
		$this->db->order_by('id', 'desc');
		$this->db->where('status', 1);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_categories()
	{
		$this->db->select("*");
		$this->db->from($this->table_category);
		$this->db->order_by('id', 'desc');
		$this->db->where('status', 1);
		$this->db->where('top_rated', 1);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	public function get_cat()
	{
		$this->db->select("*");
		$this->db->from($this->table_category);
		$this->db->order_by('id', 'RANDOM');
		$this->db->where('status', 1);
		$this->db->limit(6);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	public function get_mens_categories()
	{
		$this->db->select("sc.*, sc.name as subcategory_name");
		$this->db->from("{$this->table_subcategory} sc");
		$this->db->join("{$this->table_category} c", "c.id = sc.cat_id", 'LEFT');
		// Use configurable slug (defaults to 'men')
		$this->db->where('c.slug', $this->slug_men);
		$this->db->where("sc.status", 1);
		$this->db->order_by("sc.id", "ASC");
		$query = $this->db->get();
		return $query->result_array();
	}

	/**
	 * Get women's category with subcategories
	 */
	public function get_womens_categories()
	{
		$this->db->select("sc.*, sc.name as subcategory_name");
		$this->db->from("{$this->table_subcategory} sc");
		$this->db->join("{$this->table_category} c", "c.id = sc.cat_id", 'LEFT');
	// Use configurable slug (defaults to 'women')
	$this->db->where('c.slug', $this->slug_women);
		$this->db->where("sc.status", 1);
		$this->db->order_by("sc.id", "ASC");
		$query = $this->db->get();
		return $query->result_array();
	}


	/**
	 * Get accessories category with subcategories
	 */
	public function get_accessories_categories()
	{
		$this->db->select("sc.*, sc.name as subcategory_name");
		$this->db->from("{$this->table_subcategory} sc");
		$this->db->join("{$this->table_category} c", "c.id = sc.cat_id", 'LEFT');
	// Use configurable slug (defaults to 'accessories')
	$this->db->where('c.slug', $this->slug_accessories);
		$this->db->where("sc.status", 1);
		$this->db->order_by("sc.id", "ASC");
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_all_partners()
	{
		$this->db->select("*");
		$this->db->from($this->table_partners);
		$this->db->order_by('id', 'desc');
		$this->db->where('status', '1');
		$query = $this->db->get();
		$result = $query->result_array();
		if (count($result) > 0) {
			return $result;
		}
	}

	/**
	 * Get products by subcategory name
	 */
	public function get_products_by_subcategory($subcategory_name, $limit = 4)
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
		// Match only by subcategory slug. Caller must pass a valid slug.
		$this->db->where("{$this->table_subcategory}.slug", $subcategory_name);
		$this->db->where("{$this->table_name}.status", 1);
		$this->db->group_by("{$this->table_name}.id");
		$this->db->order_by("{$this->table_name}.id", 'desc');
		$this->db->order_by('RAND()'); // Random order
		$this->db->limit($limit);
		$query = $this->db->get();
		$result = $query->result_array();
		// Batch-fetch grouped variant data for these products to avoid N+1 queries
		$productIds = array_map(function ($p) {
			return $p['id'];
		}, $result);
		$groupsMap = [];
		if (!empty($productIds)) {
			$groupsMap = $this->getGroupedVariantsForProductIds($productIds);
		}
		foreach ($result as &$product) {
			$pid = $product['id'];
			$product['variants_grouped_by_color'] = isset($groupsMap[$pid]) ? $groupsMap[$pid] : [];
		}
		return $result;
	}

	/**
	 * Get products by subcategory without attaching grouped variants (raw product rows + attributes).
	 * Useful when the caller will batch-attach variant data for many products.
	 */
	public function get_products_by_subcategory_raw($subcategory_name, $limit = 4)
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
		// Match only by subcategory slug. Caller must pass a valid slug.
		$this->db->where("{$this->table_subcategory}.slug", $subcategory_name);
		$this->db->where("{$this->table_name}.status", 1);
		$this->db->group_by("{$this->table_name}.id");
		$this->db->order_by("{$this->table_name}.id", 'desc');
		$this->db->order_by('RAND()');
		
		// Only apply limit if it's not null/false (allows unlimited results)
		if ($limit !== null && $limit !== false) {
			$this->db->limit($limit);
		}
		
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	/**
	 * Batch-fetch grouped variants for multiple products (single set of queries).
	 * Returns map: product_id => array of groups for that product.
	 * This minimizes DB round trips when preloading many products.
	 * @param array $productIds
	 * @return array
	 */
	public function getGroupedVariantsForProductIds(array $productIds)
	{
		if (empty($productIds)) return [];

		// 1) fetch variants for all requested products
		$this->db->select('v.id as variant_id, v.color_id, v.product_id, c.name as color_name');
		$this->db->from('tbl_product_variants v');
		$this->db->join('tbl_colors c', 'c.id = v.color_id', 'left');
		$this->db->where_in('v.product_id', $productIds);
		$variantRows = $this->db->get()->result_array();

		$variantsByProduct = [];
		$variantIds = [];
		foreach ($variantRows as $vr) {
			$pid = $vr['product_id'];
			$vid = $vr['variant_id'];
			$variantIds[] = $vid;
			if (!isset($variantsByProduct[$pid])) $variantsByProduct[$pid] = [];
			$variantsByProduct[$pid][$vid] = $vr;
		}

		$imagesByVariant = [];
		if (!empty($variantIds)) {
			// 2) fetch all images for these variants
			$this->db->select('variant_id, image');
			$this->db->from('tbl_variant_images');
			$this->db->where_in('variant_id', $variantIds);
			$imgs = $this->db->get()->result_array();
			foreach ($imgs as $ir) {
				$vid = $ir['variant_id'];
				if (!isset($imagesByVariant[$vid])) $imagesByVariant[$vid] = [];
				$imagesByVariant[$vid][] = $ir['image'];
			}

			// 3) fetch all sizes/prices for these variants
			$this->db->select('vs.variant_id, vs.size_id, s.name as size_name, p.name as price_name');
			$this->db->from('tbl_variant_sizes vs');
			$this->db->join('tbl_sizes s', 's.id = vs.size_id', 'left');
			$this->db->join('tbl_prices p', 'p.id = vs.price_id', 'left');
			$this->db->where_in('vs.variant_id', $variantIds);
			$sizeRows = $this->db->get()->result_array();
			$sizesByVariant = [];
			foreach ($sizeRows as $sr) {
				$vid = $sr['variant_id'];
				if (!isset($sizesByVariant[$vid])) $sizesByVariant[$vid] = [];
				$sizesByVariant[$vid][] = $sr;
			}
		}

		// assemble groups per product
		$groupsMap = [];
		foreach ($variantsByProduct as $pid => $variantList) {
			$groups = [];
			foreach ($variantList as $vid => $vr) {
				$colorId = $vr['color_id'] ?: 'unknown';
				if (!isset($groups[$colorId])) {
					$groups[$colorId] = [
						'color_id' => $colorId,
						'color_name' => isset($vr['color_name']) ? $vr['color_name'] : '',
						'variant_ids' => [],
						'images' => [],
						'sizes' => [],
						'sku_codes' => [],
						'tags' => [],
						'ratings' => []
					];
				}
				$groups[$colorId]['variant_ids'][] = $vid;

				// images
				if (!empty($imagesByVariant[$vid])) {
					foreach ($imagesByVariant[$vid] as $img) {
						if ($img !== '' && !in_array($img, $groups[$colorId]['images'])) {
							$groups[$colorId]['images'][] = $img;
						}
					}
				}

				// sizes
				if (!empty($sizesByVariant[$vid])) {
					foreach ($sizesByVariant[$vid] as $sr) {
						$found = false;
						foreach ($groups[$colorId]['sizes'] as &$existing) {
							if ($existing['size_id'] == $sr['size_id']) {
								$found = true;
								break;
							}
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
			}

			// convert to indexed and normalize
			$outGroups = [];
			foreach ($groups as $g) {
				$g['sku_codes'] = array_values(array_filter(array_unique($g['sku_codes'])));
				$g['tags'] = array_values(array_filter(array_unique($g['tags'])));
				$g['ratings'] = array_values(array_filter($g['ratings']));
				usort($g['sizes'], function ($a, $b) {
					return strcmp($a['size_name'], $b['size_name']);
				});
				$outGroups[] = $g;
			}
			$groupsMap[$pid] = $outGroups;
		}

		// ensure map has entries for requested productIds
		foreach ($productIds as $pid) {
			if (!isset($groupsMap[$pid])) $groupsMap[$pid] = [];
		}
		return $groupsMap;
	}

	/**
	 * Simple file cache getter
	 */
	protected function cacheGet($key)
	{
		$cacheDir = APPPATH . 'cache/';
		if (!is_dir($cacheDir)) {
			@mkdir($cacheDir, 0755, true);
		}
		$file = $cacheDir . 'home_groups_' . md5($key) . '.cache';
		if (!file_exists($file)) return false;
		$data = @file_get_contents($file);
		if ($data === false) return false;
		$payload = @json_decode($data, true);
		if (!is_array($payload) || !isset($payload['ts']) || !isset($payload['ttl']) || !isset($payload['v'])) return false;
		if ($payload['ttl'] > 0 && (time() - $payload['ts'] > $payload['ttl'])) {
			@unlink($file);
			return false;
		}
		return $payload['v'];
	}

	/**
	 * Simple file cache setter
	 */
	protected function cacheSet($key, $value, $ttl = 300)
	{
		$cacheDir = APPPATH . 'cache/';
		if (!is_dir($cacheDir)) {
			@mkdir($cacheDir, 0755, true);
		}
		$file = $cacheDir . 'home_groups_' . md5($key) . '.cache';
		$payload = ['ts' => time(), 'ttl' => (int)$ttl, 'v' => $value];
		@file_put_contents($file, json_encode($payload, JSON_UNESCAPED_UNICODE), LOCK_EX);
	}

	/**
	 * Cached wrapper for getGroupedVariantsForProductIds(). Cache key should be unique per subcategory.
	 * @param array $productIds
	 * @param string $cacheKey
	 * @param int $ttl
	 * @return array
	 */
	public function getGroupedVariantsForProductIdsCached(array $productIds, $cacheKey, $ttl = 300)
	{
		$key = 'groups_' . $cacheKey . '_' . md5(implode(',', $productIds));
		$cached = $this->cacheGet($key);
		if ($cached !== false) return $cached;
		$groups = $this->getGroupedVariantsForProductIds($productIds);
		$this->cacheSet($key, $groups, $ttl);
		return $groups;
	}

	/**
	 * Attach variants_grouped_by_color to each product row in $products array.
	 * Re-uses the grouping logic from getProductsGroupedByColorBySection for a list of products.
	 * @param array $products
	 * @return array
	 */
	public function attachVariantsGroupedByColor(array $products)
	{
		foreach ($products as &$product) {
			$pid = $product['id'];
			$groups = [];

			$variantRows = $this->db->select('v.id as variant_id, v.color_id, v.sku_code, v.tags, v.ratings, c.name as color_name')
				->from('tbl_product_variants v')
				->join('tbl_colors c', 'c.id = v.color_id', 'left')
				->where('v.product_id', $pid)
				->get()->result_array();

			foreach ($variantRows as $vr) {
				$colorId = $vr['color_id'] ?: 'unknown';
				if (!isset($groups[$colorId])) {
					$groups[$colorId] = [
						'color_id' => $colorId,
						'color_name' => isset($vr['color_name']) ? $vr['color_name'] : '',
						'variant_ids' => [],
						'images' => [],
						'sizes' => [],
						'sku_codes' => [],
						'tags' => [],
						'ratings' => []
					];
				}

				$groups[$colorId]['variant_ids'][] = $vr['variant_id'];
				if (!empty($vr['sku_code'])) $groups[$colorId]['sku_codes'][] = $vr['sku_code'];
				if (!empty($vr['tags'])) $groups[$colorId]['tags'][] = $vr['tags'];
				if (!empty($vr['ratings'])) $groups[$colorId]['ratings'][] = $vr['ratings'];

				// images for variant
				$this->db->select('image');
				$this->db->from('tbl_variant_images');
				$this->db->where('variant_id', $vr['variant_id']);
				$imgs = $this->db->get()->result_array();
				foreach ($imgs as $ir) {
					$img = trim($ir['image']);
					if ($img !== '' && !in_array($img, $groups[$colorId]['images'])) {
						$groups[$colorId]['images'][] = $img;
					}
				}

				// sizes/prices for variant
				$this->db->select('vs.size_id, s.name as size_name, p.name as price_name');
				$this->db->from('tbl_variant_sizes vs');
				$this->db->join('tbl_sizes s', 's.id = vs.size_id', 'left');
				$this->db->join('tbl_prices p', 'p.id = vs.price_id', 'left');
				$this->db->where('vs.variant_id', $vr['variant_id']);
				$sizeRows = $this->db->get()->result_array();
				foreach ($sizeRows as $sr) {
					$found = false;
					foreach ($groups[$colorId]['sizes'] as &$existing) {
						if ($existing['size_id'] == $sr['size_id']) {
							$found = true;
							break;
						}
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

			// normalize groups
			$outGroups = [];
			foreach ($groups as $g) {
				$g['sku_codes'] = array_values(array_filter(array_unique($g['sku_codes'])));
				$g['tags'] = array_values(array_filter(array_unique($g['tags'])));
				$g['ratings'] = array_values(array_filter($g['ratings']));
				usort($g['sizes'], function ($a, $b) {
					return strcmp($a['size_name'], $b['size_name']);
				});
				$outGroups[] = $g;
			}

			$product['variants_grouped_by_color'] = $outGroups;
		}
		return $products;
	}

	/**
	 * Attach grouped variants for a products array using cached grouped-variants lookup.
	 * This uses getGroupedVariantsForProductIdsCached internally and attaches the
	 * resulting groups to each product as 'variants_grouped_by_color'.
	 *
	 * @param array $products
	 * @param string $cacheKey unique cache key fragment (e.g. 'products_men')
	 * @param int $ttl seconds to cache
	 * @return array
	 */
	public function attachVariantsGroupedByColorCached(array $products, $cacheKey = 'default', $ttl = 300)
	{
		if (empty($products)) return $products;
		$productIds = array_map(function($p){ return isset($p['id']) ? $p['id'] : null; }, $products);
		$productIds = array_filter($productIds);
		if (empty($productIds)) return $products;
		$groupsMap = $this->getGroupedVariantsForProductIdsCached($productIds, $cacheKey, $ttl);

		// If cached map is present but all entries are empty arrays, attempt a fresh DB fetch
		$allEmpty = true;
		foreach ($productIds as $pidCheck) {
			if (!empty($groupsMap[$pidCheck])) { $allEmpty = false; break; }
		}
		if ($allEmpty) {
			// Re-fetch directly from DB to avoid stale cache
			$fresh = $this->getGroupedVariantsForProductIds($productIds);
			$hasAny = false;
			foreach ($productIds as $pidCheck) {
				if (!empty($fresh[$pidCheck])) { $hasAny = true; break; }
			}
			if ($hasAny) {
				// Save fresh result into cache using the same key as the cached wrapper
				$key = 'groups_' . $cacheKey . '_' . md5(implode(',', $productIds));
				$this->cacheSet($key, $fresh, $ttl);
				$groupsMap = $fresh;
			}
		}

		foreach ($products as &$p) {
			$pid = isset($p['id']) ? $p['id'] : null;
			$p['variants_grouped_by_color'] = $pid && isset($groupsMap[$pid]) ? $groupsMap[$pid] : [];
		}
		return $products;
	}


	public function getProductsGroupedByColorBySection($section_name = null, $limit = 4)
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
		$this->db->where("{$this->table_name}.status", 1);
		if ($section_name !== null) {
			$this->db->join('tbl_variant_sections vs', "vs.product_id = {$this->table_name}.id", 'INNER');
			$this->db->join($this->table_section, "{$this->table_section}.id = vs.section_id", 'LEFT');
			$this->db->where("{$this->table_section}.name", $section_name);
			$this->db->where("vs.status", 1);
		}
		$this->db->group_by("{$this->table_name}.id");
		$this->db->order_by("{$this->table_name}.id", 'desc');
		$this->db->limit((int)$limit);
		$q = $this->db->get();
		$products = $q->result_array();

		foreach ($products as &$product) {
			$pid = $product['id'];
			$groups = [];

			$variantRows = $this->db->select('v.id as variant_id, v.color_id, v.sku_code, v.tags, v.ratings, c.name as color_name')
				->from('tbl_product_variants v')
				->join('tbl_colors c', 'c.id = v.color_id', 'left')
				->where('v.product_id', $pid)
				->get()->result_array();

			foreach ($variantRows as $vr) {
				$colorId = $vr['color_id'] ?: 'unknown';
				if (!isset($groups[$colorId])) {
					$groups[$colorId] = [
						'color_id' => $colorId,
						'color_name' => isset($vr['color_name']) ? $vr['color_name'] : '',
						'variant_ids' => [],
						'images' => [],
						'sizes' => [],
						'sku_codes' => [],
						'tags' => [],
						'ratings' => []
					];
				}

				$groups[$colorId]['variant_ids'][] = $vr['variant_id'];
				if (!empty($vr['sku_code'])) $groups[$colorId]['sku_codes'][] = $vr['sku_code'];
				if (!empty($vr['tags'])) $groups[$colorId]['tags'][] = $vr['tags'];
				if (!empty($vr['ratings'])) $groups[$colorId]['ratings'][] = $vr['ratings'];

				$this->db->select('image');
				$this->db->from('tbl_variant_images');
				$this->db->where('variant_id', $vr['variant_id']);
				$imgs = $this->db->get()->result_array();
				foreach ($imgs as $ir) {
					$img = trim($ir['image']);
					if ($img !== '' && !in_array($img, $groups[$colorId]['images'])) {
						$groups[$colorId]['images'][] = $img;
					}
				}

				$this->db->select('vs.size_id, s.name as size_name, p.name as price_name');
				$this->db->from('tbl_variant_sizes vs');
				$this->db->join('tbl_sizes s', 's.id = vs.size_id', 'left');
				$this->db->join('tbl_prices p', 'p.id = vs.price_id', 'left');
				$this->db->where('vs.variant_id', $vr['variant_id']);
				$sizeRows = $this->db->get()->result_array();
				foreach ($sizeRows as $sr) {
					$found = false;
					foreach ($groups[$colorId]['sizes'] as &$existing) {
						if ($existing['size_id'] == $sr['size_id']) {
							$found = true;
							break;
						}
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

			// convert associative groups to indexed array and normalize
			$outGroups = [];
			foreach ($groups as $g) {
				$g['sku_codes'] = array_values(array_filter(array_unique($g['sku_codes'])));
				$g['tags'] = array_values(array_filter(array_unique($g['tags'])));
				$g['ratings'] = array_values(array_filter($g['ratings']));
				usort($g['sizes'], function ($a, $b) {
					return strcmp($a['size_name'], $b['size_name']);
				});
				$outGroups[] = $g;
			}
			$product['variants_grouped_by_color'] = $outGroups;
		}

		return $products;
	}
}
