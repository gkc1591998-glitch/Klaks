<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Homelux extends Common_Data_Controller {
	public $headerPage        = '../../views/header';
	public $footerPage        = '../../views/footer';
	public $listPage          = 'all_products';
	public $product_viewPage  = 'view-product';
	public $cartPageajax      = '../../views/cart-ajax';
	
	public function __construct() {
    parent::__construct();
		$this->load->model('homelux_model','my_model');
		$this->load->model('home/Home_model', 'home_model');
		$this->load->model('categories/Categories_model', 'categories_model');
		// Note: Error reporting now handled in parent constructor
  }

    /**
     * Common loader for homelux product lists; mirrors products module behavior
     * but ensures only products with show_in_lux == 1 are returned.
     */
    private function _load_products_data($params = []) {

        $category_slug = isset($params['category_slug']) ? trim(strtolower($params['category_slug'])) : null;

        // Load category lists from home_model for grouping
        $mens_categories = $this->home_model->get_mens_categories();
        $womens_categories = $this->home_model->get_womens_categories();
        $accessories_categories = $this->home_model->get_accessories_categories();

        $products = [];

        // Helper: load products for a single subcategory slug
        $load_subcategory = function($subSlug) {
            if (empty($subSlug)) return [];
            return $this->home_model->get_products_by_subcategory_raw($subSlug);
        };

        // If subcategory object or id passed explicitly, use it to fetch products by subcat_id
        $subcategory_obj = isset($params['subcategory']) ? $params['subcategory'] : null;
        $subcategory_id = isset($params['subcategory_id']) ? $params['subcategory_id'] : null;
        if ($subcategory_obj && is_array($subcategory_obj) && isset($subcategory_obj['id'])) {
            $subcategory_id = $subcategory_obj['id'];
        }

        if (!empty($subcategory_id)) {
            $products = $this->my_model->get_products_by_subcategory_id($subcategory_id);
        }

        if (empty($category_slug) && empty($subcategory_id)) {
            foreach ($mens_categories as $c) {
                if (empty($c['slug'])) continue;
                $list = $this->home_model->get_products_by_subcategory_raw($c['slug'], false);
                foreach ($list as $p) $products[] = $p;
            }
            foreach ($womens_categories as $c) {
                if (empty($c['slug'])) continue;
                $list = $this->home_model->get_products_by_subcategory_raw($c['slug'], false);
                foreach ($list as $p) $products[] = $p;
            }
            foreach ($accessories_categories as $c) {
                if (empty($c['slug'])) continue;
                $list = $this->home_model->get_products_by_subcategory_raw($c['slug'], false);
                foreach ($list as $p) $products[] = $p;
            }
        } else {
            if (in_array($category_slug, ['men','mens'])) {
                foreach ($mens_categories as $c) {
                    if (empty($c['slug'])) continue;
                    $list = $this->home_model->get_products_by_subcategory_raw($c['slug'], false);
                    foreach ($list as $p) $products[] = $p;
                }
            } elseif (in_array($category_slug, ['women','women','womens'])) {
                foreach ($womens_categories as $c) {
                    if (empty($c['slug'])) continue;
                    $list = $this->home_model->get_products_by_subcategory_raw($c['slug'], false);
                    foreach ($list as $p) $products[] = $p;
                }
            } elseif ($category_slug === 'accessories') {
                foreach ($accessories_categories as $c) {
                    if (empty($c['slug'])) continue;
                    $list = $this->home_model->get_products_by_subcategory_raw($c['slug'], false);
                    foreach ($list as $p) $products[] = $p;
                }
            } else {
                $found = false;
                foreach ([$mens_categories, $womens_categories, $accessories_categories] as $catList) {
                    foreach ($catList as $c) {
                        if (empty($c['slug'])) continue;
                        if ($c['slug'] === $category_slug || strpos($c['slug'], $category_slug) === 0 || strpos($category_slug, $c['slug']) === 0) {
                            $list = $this->home_model->get_products_by_subcategory_raw($c['slug'], false);
                            foreach ($list as $p) $products[] = $p;
                            $found = true;
                        }
                    }
                    if ($found) break;
                }
                if (!$found) {
                    $products = $this->my_model->productsByCategoryName($category_slug);
                }
            }
        }

        // Filter only products marked for lux
        $products = array_filter($products, function($p){ 
            return isset($p['show_in_lux']) && ((int)$p['show_in_lux'] === 1 || $p['show_in_lux'] === '1'); 
        });
        $products = array_values($products);

        // Attach grouped variants for all products in one batch
        $productIds = array_values(array_filter(array_map(function($p){ return isset($p['id']) ? $p['id'] : null; }, $products)));
        if (!empty($productIds)) {
            $groupsMap = $this->home_model->getGroupedVariantsForProductIds($productIds);
            foreach ($products as &$p) {
                $pid = isset($p['id']) ? $p['id'] : null;
                $p['variants_grouped_by_color'] = $pid && isset($groupsMap[$pid]) ? $groupsMap[$pid] : [];
            }
        }

        // Note: Attributes are available through variants_grouped_by_color data
        // No need to attach separate attributes as the variant groups contain all needed info

        return $products;
    }

	public function index($category = null) {

        // Check if passcode is already verified
		if($this->session->userdata('passcode_verified') !== true) {
			redirect('passcode','refresh');
			return;
		}

		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
		
    // Use loader to populate products with lux-only filter
    $params = [];
    if ($category) $params['category_slug'] = $category;
    $data['products']    = $this->_load_products_data($params);
        
    // Get filter options
    $data['available_colors'] = $this->my_model->getAvailableColors();
    $data['available_sizes'] = $this->my_model->getAvailableSizes();
		
		$this->load->view($this->listPage, $data);
		$this->load->view($this->footerPage,$data);
	}

	/**
	 * Handle trending page with top categories
	 */
	public function trending()
	{
		// Check if passcode is already verified
		if($this->session->userdata('passcode_verified') !== true) {
			redirect('passcode','refresh');
			return;
		}

		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
		
		// Load trending products (Most Trending section)
		$data['products'] = $this->my_model->productsByType('Most Trending');
		
		// Load top level categories for filter tabs
		$data['top_categories'] = [
			['name' => 'Men', 'slug' => 'men'],
			['name' => 'Women', 'slug' => 'women'], 
			['name' => 'Accessories', 'slug' => 'accessories']
		];
		
		// Load subcategories for each top category (for dynamic sidebar)
		$data['mens_categories'] = $this->home_model->get_mens_categories();
		$data['womens_categories'] = $this->home_model->get_womens_categories();
		$data['accessories_categories'] = $this->home_model->get_accessories_categories();
		
		// Load other filter data
		$data['available_colors'] = $this->my_model->getAvailableColors();
		$data['available_sizes'] = $this->my_model->getAvailableSizes();
		
		// Set flag to indicate this is trending page
		$data['is_trending_page'] = true;
		
		$this->load->view($this->listPage,$data);
		$this->load->view($this->footerPage,$data);
	}

	/**
	 * Handle newly launched page with top categories
	 */
	public function newly_launched()
	{
		// Check if passcode is already verified
		if($this->session->userdata('passcode_verified') !== true) {
			redirect('passcode','refresh');
			return;
		}

		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
		
		// Load newly launched products (New Drops section)
		$data['products'] = $this->my_model->productsByType('New Drops');
		
		// Load top level categories for filter tabs
		$data['top_categories'] = [
			['name' => 'Men', 'slug' => 'men'],
			['name' => 'Women', 'slug' => 'women'], 
			['name' => 'Accessories', 'slug' => 'accessories']
		];
		
		// Load subcategories for each top category (for dynamic sidebar)
		$data['mens_categories'] = $this->home_model->get_mens_categories();
		$data['womens_categories'] = $this->home_model->get_womens_categories();
		$data['accessories_categories'] = $this->home_model->get_accessories_categories();
		
		// Load other filter data
		$data['available_colors'] = $this->my_model->getAvailableColors();
		$data['available_sizes'] = $this->my_model->getAvailableSizes();
		
		// Set flag to indicate this is newly launched page
		$data['is_newly_launched_page'] = true;
		
		$this->load->view($this->listPage,$data);
		$this->load->view($this->footerPage,$data);
	}

	/**
	 * AJAX method to get subcategories for a given top category
	 */
	public function ajax_get_subcategories()
	{
		$category_slug = $this->input->post('category_slug');
		$subcategories = [];
		
		switch($category_slug) {
			case 'men':
				$subcategories = $this->home_model->get_mens_categories();
				break;
			case 'women':
				$subcategories = $this->home_model->get_womens_categories();
				break;
			case 'accessories':
				$subcategories = $this->home_model->get_accessories_categories();
				break;
		}
		
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode([
				'success' => true,
				'subcategories' => $subcategories
			]));
	}

	public function product_view($id=null)
	{
		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
		$data['product_view'] = $this->my_model->get_product($id);
		
		// Get product variants data instead of old attributes
		if (!empty($data['product_view']) && !empty($data['product_view']['id'])) {
			$groupsMap = $this->home_model->getGroupedVariantsForProductIds([$data['product_view']['id']]);
			$data['product_view']['variants_grouped_by_color'] = isset($groupsMap[$data['product_view']['id']]) ? $groupsMap[$data['product_view']['id']] : [];
		}
		
		// For backward compatibility with views that expect 'attributes'
		$data['attributes'] = isset($data['product_view']['variants_grouped_by_color']) ? $data['product_view']['variants_grouped_by_color'] : [];
		
		// echo "<pre>";print_r($data['product_view']);exit;
		// $data['products'] = $this->my_model->get_recent_ads($id,$data['product_view']['cat_id']);
		$this->load->view($this->product_viewPage, $data);
		$this->load->view($this->footerPage, $data);
	}


	public function deletecart()
	{
		$id = $this->input->post('valu');
		$data = array(
               'rowid'   => $id,
                'qty'     => 0
            );
		$this->cart->update($data);
		$this->load->view($this->cartPageajax);
		//$this->load->view("checkoutcart");
	}



	public function type($category) {

		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
    $params = [];
    if ($category) $params['category_slug'] = $category;
    $data['products']       = $this->_load_products_data($params);
		// echo "<pre>";print_r($data['products']);exit;
		$this->load->view($this->listPage,$data);
		$this->load->view($this->footerPage, $data);
	}

	public function filter_products() {
        $filters = $this->input->post();

        // Apply filters to the query
        $this->db->select('p.*')->from('tbl_products p');

        // Handle sorting
        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'popular':
                    $this->db->order_by('p.created_date_time', 'DESC');
                    break;
                case 'new':
                    $this->db->order_by('p.created_date_time', 'DESC');
                    break;
                case 'high-to-low':
                    $this->db->order_by('p.price_range', 'DESC');
                    break;
                case 'low-to-high':
                    $this->db->order_by('p.price_range', 'ASC');
                    break;
            }
        }

        // Handle search
        if (!empty($filters['search'])) {
            $this->db->like('p.title', $filters['search']);
        }

        // Handle category filter
        if (!empty($filters['category'])) {
            $this->db->where('p.category', $filters['category']);
        }

        // For attribute-based filters (size, color, fit), we need to join with attributes table
        $needsAttributeJoin = false;
        
        if (!empty($filters['size']) || !empty($filters['color']) || !empty($filters['fit'])) {
            $this->db->join('tbl_product_attributes pa', 'p.id = pa.product_id', 'inner');
            $needsAttributeJoin = true;
        }

        if (!empty($filters['size'])) {
            $this->db->where('pa.size_name', $filters['size']);
        }

        if (!empty($filters['color'])) {
            $this->db->where('pa.color_name', $filters['color']);
        }

        if (!empty($filters['fit'])) {
            $this->db->where('pa.fit_name', $filters['fit']);
        }

        // Group by product ID if we joined attributes to avoid duplicates
        if ($needsAttributeJoin) {
            $this->db->group_by('p.id');
        }

        $query = $this->db->get();
        $products = $query->result_array();

        // Get attributes for each product (same as in other methods)
        foreach ($products as &$product) {
            $product['attributes'] = $this->my_model->getProductAttributes($product['id']);
        }

        // Load the AJAX grid view with filtered products
        $this->load->view('products/ajax_products_grid', ['products' => $products]);
    }
	
    public function ajax_products($type = 'all') {
        try {
            // Get the type from POST data if available
            $type = $this->input->post('type') ? $this->input->post('type') : $type;
            
            error_log('AJAX PRODUCTS: Type = ' . $type); // Debug log
            
            // Validate input
            if (empty($type)) {
                $type = 'all';
            }
            
            // Handle special types first
            if ($type === 'trending') {
                // Load all trending products (Most Trending section)
                $data['products'] = $this->my_model->productsByType('Most Trending');
            } elseif ($type === 'newly_launched') {
                // Load all newly launched products (New Drops section)
                $data['products'] = $this->my_model->productsByType('New Drops');
            } else {
                // Use loader and ensure lux-only products
                $params = [];
                if ($type && $type !== 'all') $params['category_slug'] = $type;
                $data['products'] = $this->_load_products_data($params);
            }

            // Ensure products is an array
            if (!is_array($data['products'])) {
                $data['products'] = [];
            }

            error_log('AJAX PRODUCTS: Found ' . count($data['products']) . ' products'); // Debug log

            // Capture the view output
            $html = $this->load->view('products/ajax_products_grid', $data, true);
            
            // Return JSON response
            $response = [
                'success' => true,
                'html' => $html,
                'message' => 'Products loaded successfully',
                'count' => count($data['products'])
            ];
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
                
        } catch (Exception $e) {
            error_log('AJAX PRODUCTS ERROR: ' . $e->getMessage());
            $response = [
                'success' => false,
                'html' => '',
                'message' => 'Error: ' . $e->getMessage()
            ];
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }
    }

    public function ajax_filter_products() {
        // Build filters from POST then use loader to get base product set and
        // apply the same in-PHP filtering used by Products controller.
        $filters = [
            'sort' => $this->input->post('sort'),
            'category' => $this->input->post('category'),
            'size' => $this->input->post('size'),
            'color' => $this->input->post('color'),
            'fit' => $this->input->post('fit'),
            'search' => $this->input->post('search'),
            'price_min' => $this->input->post('price_min'),
            'price_max' => $this->input->post('price_max'),
        ];

        $params = [];
        if (!empty($filters['category'])) $params['category_slug'] = $filters['category'];

        $products = $this->_load_products_data($params);

        // Apply same PHP-level filtering as Products controller (simple reuse)
        // We'll call the Products controller logic by duplicating the minimal filter loop here
        $filtered = array_filter($products, function($p) use ($filters) {
            // color
            if (!empty($filters['color'])) {
                $found = false;
                $groups = isset($p['variants_grouped_by_color']) ? $p['variants_grouped_by_color'] : [];
                foreach ($groups as $g) {
                    $cname = isset($g['color_name']) ? $g['color_name'] : (isset($g['name']) ? $g['name'] : '');
                    if ($cname !== '' && strcasecmp(trim($cname), trim($filters['color'])) === 0) { $found = true; break; }
                }
                if (!$found) return false;
            }
            // size
            if (!empty($filters['size'])) {
                $found = false;
                $groups = isset($p['variants_grouped_by_color']) ? $p['variants_grouped_by_color'] : [];
                foreach ($groups as $g) {
                    if (!empty($g['sizes']) && is_array($g['sizes'])) {
                        foreach ($g['sizes'] as $s) {
                            $sname = isset($s['size_name']) ? $s['size_name'] : (isset($s['name']) ? $s['name'] : '');
                            if ($sname !== '' && strcasecmp(trim($sname), trim($filters['size'])) === 0) { $found = true; break 2; }
                        }
                    }
                    if (!empty($g['size_names']) && is_array($g['size_names'])) {
                        foreach ($g['size_names'] as $sname) {
                            if ($sname !== '' && strcasecmp(trim($sname), trim($filters['size'])) === 0) { $found = true; break 2; }
                        }
                    }
                }
                if (!$found) return false;
            }
            // price
            if ((!empty($filters['price_min']) && is_numeric($filters['price_min'])) || (!empty($filters['price_max']) && is_numeric($filters['price_max']))) {
                $min = is_numeric($filters['price_min']) ? (float)$filters['price_min'] : null;
                $max = is_numeric($filters['price_max']) ? (float)$filters['price_max'] : null;
                $matched = false;
                $groups = isset($p['variants_grouped_by_color']) ? $p['variants_grouped_by_color'] : [];
                foreach ($groups as $g) {
                    $sizes = [];
                    if (!empty($g['sizes']) && is_array($g['sizes'])) {
                        $sizes = $g['sizes'];
                    } elseif (!empty($g['price_names']) && is_array($g['price_names'])) {
                        foreach ($g['price_names'] as $pn) { $sizes[] = ['price_name' => $pn]; }
                    }
                    foreach ($sizes as $s) {
                        $priceRaw = isset($s['price_name']) ? $s['price_name'] : (isset($s['price']) ? $s['price'] : '');
                        $pnum = floatval(preg_replace('/[^0-9\.]/', '', (string)$priceRaw));
                        if (($min === null || $pnum >= $min) && ($max === null || $pnum <= $max)) { $matched = true; break 2; }
                    }
                }
                if (!$matched) return false;
            }
            // search
            if (!empty($filters['search'])) {
                $needle = $filters['search'];
                $found = false;
                if (!empty($p['title']) && stripos($p['title'], $needle) !== false) $found = true;
                if (!$found && !empty($p['tags']) && stripos($p['tags'], $needle) !== false) $found = true;
                if (!$found && !empty($p['variants_grouped_by_color'])) {
                    foreach ($p['variants_grouped_by_color'] as $g) {
                        if (!empty($g['tags']) && stripos(implode(' ', (array)$g['tags']), $needle) !== false) { $found = true; break; }
                    }
                }
                if (!$found) return false;
            }
            return true;
        });

        $filtered = array_values($filtered);

        // basic sorting 'new' or price sorts could be added here if needed

        $data['products'] = $filtered;
        $data['available_colors'] = $this->my_model->getAvailableColors();
        $data['available_sizes'] = $this->my_model->getAvailableSizes();

        $this->load->view('products/ajax_products_grid', $data);
    }

    // Simple test method to debug AJAX issues
    public function test_ajax() {
        echo json_encode([
            'success' => true,
            'message' => 'AJAX endpoint is working',
            'timestamp' => date('Y-m-d H:i:s'),
            'post_data' => $this->input->post()
        ]);
    }
}
