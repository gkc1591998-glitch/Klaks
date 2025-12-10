<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
class Products extends Common_Data_Controller
{
  public $headerPage        = '../../views/header';
  public $footerPage        = '../../views/footer';
  public $listPage          = 'all_products';
  public $product_viewPage  = 'view-product';
  public $cartPageajax      = '../../views/cart-ajax';

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Products_model', 'my_model');
    $this->load->model('home/Home_model', 'home_model');
    $this->load->model('categories/Categories_model', 'categories_model');
    // Note: Error reporting now handled in parent constructor
  }

  public function index($category_slug = null)
  {
    $data = $this->commonData;
    
    $params = [];
    if ($category_slug) {
      $params['category_slug'] = $category_slug;
      $category = $this->categories_model->getCategoryBySlug($category_slug);
      $data['current_category'] = $category;
      $data['subcategories'] = $this->categories_model->getSubcategoriesByParentId($category['id']);
      $data['products'] = $this->_load_products_data($params);
    }
    
    // Use traditional view loading for now
    $this->load->view($this->headerPage, $data);
    $this->load->view($this->listPage, $data);
    $this->load->view($this->footerPage, $data);
  }

  /**
   * Handle trending page with top categories
   */
  public function trending()
  {
    $data = $this->commonData; // get common data
    $this->load->view($this->headerPage,$data);
    
    // Load all products for trending page
    $data['products'] = $this->my_model->productsByType('all'); // Show all products, user can filter
    
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
    $data = $this->commonData; // get common data
    $this->load->view($this->headerPage,$data);
    
    // Load all recent products for newly launched page
    $data['products'] = $this->my_model->productsByType('all'); // Show all products, user can filter
    
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

  /**
   * Common data loader for products listing, accepts params for filtering/processing
   */
  private function _load_products_data($params = []) {

    // Return a flat array of products filtered by category_slug (root or subcategory)
    $category_slug = isset($params['category_slug']) ? trim(strtolower($params['category_slug'])) : null;

    // Load category lists
    $mens_categories = $this->home_model->get_mens_categories();
    $womens_categories = $this->home_model->get_womens_categories();
    $accessories_categories = $this->home_model->get_accessories_categories();

    $products = [];

    // If caller passed a filters array, delegate filtering to the model and
    // return the filtered products list. This allows ajax_filter_products to
    // reuse the same loader path as index/type.
    if (!empty($params['filters']) && is_array($params['filters'])) {
      $products = $this->my_model->filterProducts($params['filters']);
      // Attach attributes for each product (same behavior as other loaders)
      foreach ($products as &$pr) {
        if (isset($pr['id'])) {
          $pr['attributes'] = $this->my_model->getProductAttributes($pr['id']);
        }
      }
      // Attach grouped variants for the filtered result set
      $productIds = array_values(array_filter(array_map(function($p){ return isset($p['id']) ? $p['id'] : null; }, $products)));
      if (!empty($productIds)) {
        $groupsMap = $this->home_model->getGroupedVariantsForProductIds($productIds);
        foreach ($products as &$p) {
          $pid = isset($p['id']) ? $p['id'] : null;
          $p['variants_grouped_by_color'] = $pid && isset($groupsMap[$pid]) ? $groupsMap[$pid] : [];
        }
      }
      return $products;
    }

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

    // If subcategory id provided, fetch products by subcat_id directly
    if (!empty($subcategory_id)) {
      $products = $this->my_model->get_products_by_subcategory_id($subcategory_id);
      
      // Attach grouped variants for the products and return immediately
      $productIds = array_values(array_filter(array_map(function($p){ return isset($p['id']) ? $p['id'] : null; }, $products)));
      if (!empty($productIds)) {
        $groupsMap = $this->home_model->getGroupedVariantsForProductIds($productIds);
        foreach ($products as &$p) {
          $pid = isset($p['id']) ? $p['id'] : null;
          $p['variants_grouped_by_color'] = $pid && isset($groupsMap[$pid]) ? $groupsMap[$pid] : [];
        }
      }
      return $products;
    }

        // If no slug provided and no subcategory id, return merged products across all types
    if (empty($category_slug) && empty($subcategory_id)) {
      $productIds = []; // Track IDs to prevent duplicates
      
      // Instead of using predefined category lists, get ALL active subcategories from database
      $this->db->select('slug');
      $this->db->from('tbl_subcategory');
      $this->db->where('status', 1);
      $all_subcategories_query = $this->db->get();
      $all_subcategories = $all_subcategories_query->result_array();
      
      foreach ($all_subcategories as $subcat) {
        if (empty($subcat['slug'])) continue;
        $list = $this->home_model->get_products_by_subcategory_raw($subcat['slug'], null); // No limit - show all
        foreach ($list as $p) {
          $pid = isset($p['id']) ? $p['id'] : null;
          if ($pid && !in_array($pid, $productIds)) {
            $products[] = $p;
            $productIds[] = $pid;
          }
        }
      }
    } else {
      // Handle root-level slugs
      if (in_array($category_slug, ['men','mens'])) {
        $productIds = []; // Track IDs to prevent duplicates
        foreach ($mens_categories as $c) {
          if (empty($c['slug'])) continue;
          $list = $this->home_model->get_products_by_subcategory_raw($c['slug'], null); // No limit - show all
          foreach ($list as $p) {
            $pid = isset($p['id']) ? $p['id'] : null;
            if ($pid && !in_array($pid, $productIds)) {
              $products[] = $p;
              $productIds[] = $pid;
            }
          }
        }
      } elseif (in_array($category_slug, ['women','women','womens'])) {
        $productIds = []; // Track IDs to prevent duplicates
        foreach ($womens_categories as $c) {
          if (empty($c['slug'])) continue;
          $list = $this->home_model->get_products_by_subcategory_raw($c['slug'], null); // No limit - show all
          foreach ($list as $p) {
            $pid = isset($p['id']) ? $p['id'] : null;
            if ($pid && !in_array($pid, $productIds)) {
              $products[] = $p;
              $productIds[] = $pid;
            }
          }
        }
      } elseif ($category_slug === 'accessories') {
        $productIds = []; // Track IDs to prevent duplicates
        foreach ($accessories_categories as $c) {
          if (empty($c['slug'])) continue;
          $list = $this->home_model->get_products_by_subcategory_raw($c['slug'], null); // No limit - show all
          foreach ($list as $p) {
            $pid = isset($p['id']) ? $p['id'] : null;
            if ($pid && !in_array($pid, $productIds)) {
              $products[] = $p;
              $productIds[] = $pid;
            }
          }
        }
      } else {
        // Treat slug as subcategory slug: try to find exact or prefix match in any category list
        $found = false;
        $productIds = []; // Track IDs to prevent duplicates
        foreach ([$mens_categories, $womens_categories, $accessories_categories] as $catList) {
          foreach ($catList as $c) {
            if (empty($c['slug'])) continue;
            // match exact or prefix
            if ($c['slug'] === $category_slug || strpos($c['slug'], $category_slug) === 0 || strpos($category_slug, $c['slug']) === 0) {
              $list = $this->home_model->get_products_by_subcategory_raw($c['slug'], null); // No limit - show all
              foreach ($list as $p) {
                $pid = isset($p['id']) ? $p['id'] : null;
                if ($pid && !in_array($pid, $productIds)) {
                  $products[] = $p;
                  $productIds[] = $pid;
                }
              }
              $found = true;
            }
          }
          if ($found) break;
        }
        // If still not found, fallback to attempt getting productsByCategoryName
        if (!$found) {
          $fallback_products = $this->my_model->productsByCategoryName($category_slug);
          // Apply duplicate prevention even for fallback
          foreach ($fallback_products as $p) {
            $pid = isset($p['id']) ? $p['id'] : null;
            if ($pid && !in_array($pid, $productIds)) {
              $products[] = $p;
              $productIds[] = $pid;
            }
          }
        }
      }
    }

    // Attach grouped variants for all products in one batch
    $productIds = array_values(array_filter(array_map(function($p){ return isset($p['id']) ? $p['id'] : null; }, $products)));
    if (!empty($productIds)) {
      $groupsMap = $this->home_model->getGroupedVariantsForProductIds($productIds);
      foreach ($products as &$p) {
        $pid = isset($p['id']) ? $p['id'] : null;
        $p['variants_grouped_by_color'] = $pid && isset($groupsMap[$pid]) ? $groupsMap[$pid] : [];
      }
    }
    // echo "<pre>";print_r($products);echo "</pre>";exit;
    return $products;
  }

  public function product_view($id = null, $variant_unique = null)
  {
    $data = $this->commonData; // get common data
    $this->load->view($this->headerPage, $data);
    $data['product_view'] = $this->my_model->get_product($id);
    // $data['attributes'] = $data['product_view']['attributes'];
    $data['variants'] = $this->my_model->getVariantsGroupedByColor($id);
    $data['variants_grouped_by_color'] = $this->my_model->getVariantsGroupedByColorDetailed($id);
    $data['selected_variant_unique'] = $variant_unique;
    // echo "<pre>";print_r($data);echo "</pre>";exit;
    // load reviews for this product
    $this->load->model('Products_model', 'products_model');
    $data['reviews'] = $this->my_model->get_reviews_by_product($id);
    // load related products (same subcategory) - attach grouped variants for rendering
    $related = [];
    $subcat_id = isset($data['product_view']['subcat_id']) ? $data['product_view']['subcat_id'] : null;
    if (!empty($subcat_id)) {
      $related = $this->my_model->get_products_by_subcategory_id($subcat_id);
    } else {
      // fallback: get random products
      $related = $this->my_model->productsByType(null);
    }
    // exclude current product and pick 4 random products
    $related = array_values(array_filter($related, function($p) use ($id) { return isset($p['id']) && $p['id'] != $id; }));
    if (!empty($related)) {
      shuffle($related);
      $related = array_slice($related, 0, 4);
    }
    $relatedIds = array_map(function($p){ return isset($p['id']) ? $p['id'] : 0; }, $related);
    if (!empty($relatedIds)) {
      $groupsMap = $this->home_model->getGroupedVariantsForProductIds($relatedIds);
      foreach ($related as &$p) {
        $pid = isset($p['id']) ? $p['id'] : null;
        $p['variants_grouped_by_color'] = $pid && isset($groupsMap[$pid]) ? $groupsMap[$pid] : [];
      }
      unset($p);
    }
    $data['related_products'] = $related;
    $this->load->view($this->product_viewPage, $data);
    $this->load->view($this->footerPage, $data);
  }

  /**
   * AJAX endpoint to submit a review for a product
   */
  public function submit_review()
  {
    if (!$this->input->is_ajax_request()) {
      show_404();
      return;
    }
    $post = $this->input->post();
    $product_id = isset($post['product_id']) ? (int)$post['product_id'] : 0;
    $variant_id = isset($post['variant_id']) ? $post['variant_id'] : null;
    $name = isset($post['name']) ? trim($post['name']) : '';
    $email = isset($post['email']) ? trim($post['email']) : '';
    $rating = isset($post['rating']) ? floatval($post['rating']) : 0;
    $comment = isset($post['comment']) ? trim($post['comment']) : '';

    if (empty($product_id) || empty($name) || empty($email) || empty($comment)) {
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(['success' => false, 'message' => 'Please fill all required fields.']));
      return;
    }

    $insertData = [
      'product_id' => $product_id,
      'variant_id' => $variant_id,
      'rating' => $rating,
      'name' => $name,
      'email' => $email,
      'comment' => $comment
    ];

    $this->load->model('Products_model', 'products_model');
    $insertId = $this->products_model->insert_review($insertData);
    if ($insertId) {
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(['success' => true, 'message' => 'Review submitted.', 'id' => $insertId]));
    } else {
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(['success' => false, 'message' => 'Failed to save review.']));
    }
  }
  /**
   * AJAX: return variants grouped by color as JSON
   */
  public function ajax_get_variants_by_color($product_id = null)
  {
    if ($this->input->is_ajax_request()) {
      $out = $this->my_model->getVariantsGroupedByColorDetailed($product_id);
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($out));
    } else {
      show_404();
    }
  }

  public function deletecart()
  {
    $id = $this->input->post('valu');
    $data = array(
      'rowid'   => $id,
      'qty'     => 0
    );
    $this->cart->update($data);
    
    // Capture the view output
    $output = $this->load->view($this->cartPageajax, array(), TRUE);
    
    // Send ONLY the cart HTML - bypass all CI output handling
    header('Content-Type: text/html; charset=utf-8');
    echo $output;
    die(); // Hard stop - nothing else should execute
  }

  public function get_cart_html()
  {
    // Capture the view output
    $output = $this->load->view($this->cartPageajax, array(), TRUE);
    
    // Send ONLY the cart HTML - bypass all CI output handling
    header('Content-Type: text/html; charset=utf-8');
    echo $output;
    die(); // Hard stop
  }

  public function type($category)
  {
    // Redirect trending to new trending page
    if ($category === 'trending') {
      redirect('products/trending');
      return;
    }
    
    // Redirect new to newly launched page
    if ($category === 'new') {
      redirect('products/newly_launched');
      return;
    }
    
    $data = $this->commonData; // get common data
    $this->load->view($this->headerPage, $data);
    $data['products']       = $this->my_model->productsByType($category, $subcategory = null);
    // echo "<pre>";print_r($data['products']);exit;
    $this->load->view($this->listPage, $data);
    $this->load->view($this->footerPage, $data);
  }

  public function filter_products()
  {
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

  public function ajax_products($type = 'all')
  {
    try {
      // Read simplified POST payload (preferred keys: name, subcatid, sub-cat-slug)
      $post = $this->input->post();

      // Normalize incoming values
      $name = isset($post['name']) ? trim($post['name']) : null;
      $subcatid = null;
      if (!empty($post['subcatid'])) {
        $subcatid = (int) $post['subcatid'];
      } elseif (!empty($post['subcat_id'])) {
        $subcatid = (int) $post['subcat_id'];
      }

      $sub_cat_slug = null;
      if (!empty($post['sub-cat-slug'])) {
        $sub_cat_slug = trim($post['sub-cat-slug']);
      } elseif (!empty($post['subcat_slug'])) {
        $sub_cat_slug = trim($post['subcat_slug']);
      } elseif (!empty($post['category_slug'])) {
        $sub_cat_slug = trim($post['category_slug']);
      }

      // Legacy: accept full subcategory JSON string
      $subcategory = null;
      if (!empty($post['subcategory'])) {
        $decoded = json_decode($post['subcategory'], true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
          $subcategory = $decoded;
          if (empty($subcatid) && isset($subcategory['id'])) $subcatid = (int)$subcategory['id'];
          if (empty($sub_cat_slug) && isset($subcategory['slug'])) $sub_cat_slug = $subcategory['slug'];
        }
      }

      // Build loader params expected by _load_products_data
      $loaderParams = [];
      // keep type for backward compatibility if passed
      $type = $this->input->post('type') ? $this->input->post('type') : $type;
      
      // Handle special types first
      if ($type === 'trending') {
        // Load all trending products (Most Trending section)
        $products = $this->my_model->productsByType('Most Trending');
      } elseif ($type === 'newly_launched') {
        // Load all newly launched products (New Drops section)
        $products = $this->my_model->productsByType('New Drops');
      } elseif ($name === 'ALL' && ($type === 'trending' || $type === 'newly_launched')) {
        // "ALL" clicked on trending or newly launched page
        if ($type === 'trending') {
          $products = $this->my_model->productsByType('Most Trending');
        } else {
          $products = $this->my_model->productsByType('New Drops');
        }
      } elseif ($name === 'ALL') {
        // For "ALL", don't set any category filters and set type to 'all'
        $loaderParams['type'] = 'all';
        $products = $this->_load_products_data($loaderParams);
      } else {
        // For specific categories/subcategories, don't use 'all' type
        if (!empty($name)) $loaderParams['name'] = $name;
        if (!empty($sub_cat_slug)) $loaderParams['category_slug'] = $sub_cat_slug;
        if (!empty($subcategory)) $loaderParams['subcategory'] = $subcategory;
        if (!empty($subcatid)) $loaderParams['subcategory_id'] = $subcatid;
        // Only set type if it was explicitly passed, otherwise let the loader use category logic
        if ($this->input->post('type')) {
          $loaderParams['type'] = $type;
        }
        
        // Use centralized loader (returns flat products array)
        $products = $this->_load_products_data($loaderParams);
      }

      // Prepare view data
      $viewData = ['products' => $products];
      $viewData['available_colors'] = $this->my_model->getAvailableColors();
      $viewData['available_sizes'] = $this->my_model->getAvailableSizes();

      // Render grid view and return JSON response
      $html = $this->load->view('products/ajax_products_grid', $viewData, true);

      $response = [
        'success' => true,
        'html' => $html,
        'message' => 'Products loaded successfully',
        'count' => is_array($products) ? count($products) : 0
      ];

      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
    } catch (Exception $e) {
      // error_log('AJAX PRODUCTS ERROR: ' . $e->getMessage());
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

  public function ajax_filter_products()
  {
    // Read raw filter inputs
    $rawFilters = [
      'sort' => $this->input->post('sort'),
      'category' => $this->input->post('category'),
      'size' => $this->input->post('size'),
      'color' => $this->input->post('color'),
      'fit' => $this->input->post('fit'),
      'search' => $this->input->post('search'),
      'price_min' => $this->input->post('price_min'),
      'price_max' => $this->input->post('price_max'),
      'tags' => $this->input->post('tags'),
    ];

    // Build params to load base product list for the current context (category/subcategory)
    $params = [];
    if (!empty($rawFilters['category'])) {
      // normalize category into a slug-like value and let _load_products_data try to resolve
      $params['category_slug'] = strtolower(str_replace(' ', '-', trim($rawFilters['category'])));
    }

    // Load base products using the existing index loader (this returns variants_grouped_by_color)
    $products = $this->_load_products_data($params);

    // Apply filters in PHP against the returned $products array (no model-side filter queries)
    $filtered = array_filter($products, function($p) use ($rawFilters) {
      // color filter: check variant groups for matching color name
      if (!empty($rawFilters['color'])) {
        $foundColor = false;
        $groups = isset($p['variants_grouped_by_color']) ? $p['variants_grouped_by_color'] : [];
        foreach ($groups as $g) {
          $cname = '';
          if (isset($g['color_name'])) $cname = $g['color_name'];
          elseif (isset($g['name'])) $cname = $g['name'];
          if ($cname !== '' && strcasecmp(trim($cname), trim($rawFilters['color'])) === 0) { $foundColor = true; break; }
        }
        if (!$foundColor) return false;
      }

      // size filter: check sizes within variant groups
      if (!empty($rawFilters['size'])) {
        $foundSize = false;
        $groups = isset($p['variants_grouped_by_color']) ? $p['variants_grouped_by_color'] : [];
        foreach ($groups as $g) {
          // prefer structured sizes
          if (!empty($g['sizes']) && is_array($g['sizes'])) {
            foreach ($g['sizes'] as $s) {
              $sname = isset($s['size_name']) ? $s['size_name'] : (isset($s['name']) ? $s['name'] : '');
              if ($sname !== '' && strcasecmp(trim($sname), trim($rawFilters['size'])) === 0) { $foundSize = true; break 2; }
            }
          }
          // fallback to CSV-style fields
          if (!empty($g['size_names']) && is_array($g['size_names'])) {
            foreach ($g['size_names'] as $sname) {
              if ($sname !== '' && strcasecmp(trim($sname), trim($rawFilters['size'])) === 0) { $foundSize = true; break 2; }
            }
          }
        }
        if (!$foundSize) return false;
      }

      // price range filter: check any price in variant sizes
      if ((!empty($rawFilters['price_min']) && is_numeric($rawFilters['price_min'])) || (!empty($rawFilters['price_max']) && is_numeric($rawFilters['price_max']))) {
        $min = is_numeric($rawFilters['price_min']) ? (float)$rawFilters['price_min'] : null;
        $max = is_numeric($rawFilters['price_max']) ? (float)$rawFilters['price_max'] : null;
        $matched = false;
        $groups = isset($p['variants_grouped_by_color']) ? $p['variants_grouped_by_color'] : [];
        foreach ($groups as $g) {
          $sizes = [];
          if (!empty($g['sizes']) && is_array($g['sizes'])) {
            $sizes = $g['sizes'];
          } elseif (!empty($g['price_names']) && is_array($g['price_names'])) {
            // fallback: use price_names array
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

      // search/tag filter: check title, name, or tags
      if (!empty($rawFilters['search']) || !empty($rawFilters['tags'])) {
        $needle = !empty($rawFilters['search']) ? $rawFilters['search'] : $rawFilters['tags'];
        $found = false;
        if (!empty($p['title']) && stripos($p['title'], $needle) !== false) $found = true;
        if (!$found && !empty($p['tags']) && stripos($p['tags'], $needle) !== false) $found = true;
        // also search in variant tags
        if (!$found && !empty($p['variants_grouped_by_color'])) {
          foreach ($p['variants_grouped_by_color'] as $g) {
            if (!empty($g['tags']) && stripos(implode(' ', (array)$g['tags']), $needle) !== false) { $found = true; break; }
          }
        }
        if (!$found) return false;
      }

      // fit filter (optional): check product fit field or attributes
      if (!empty($rawFilters['fit'])) {
        if (empty($p['fit']) || stripos($p['fit'], $rawFilters['fit']) === false) return false;
      }

      return true;
    });

    // Convert filtered to indexed array
    $filtered = array_values($filtered);

    // Sorting: support price-based sorting and simple 'new' / 'popular' fallbacks
    $sort = isset($rawFilters['sort']) ? $rawFilters['sort'] : null;
    if ($sort === 'high-to-low' || $sort === 'low-to-high') {
      // compute a representative price (lowest price) per product
      $prices = [];
      foreach ($filtered as $idx => $prod) {
        $minPrice = PHP_FLOAT_MAX;
        $groups = isset($prod['variants_grouped_by_color']) ? $prod['variants_grouped_by_color'] : [];
        foreach ($groups as $g) {
          if (!empty($g['sizes']) && is_array($g['sizes'])) {
            foreach ($g['sizes'] as $s) {
              $priceRaw = isset($s['price_name']) ? $s['price_name'] : (isset($s['price']) ? $s['price'] : '');
              $pnum = floatval(preg_replace('/[^0-9\.]/', '', (string)$priceRaw));
              if ($pnum > 0 && $pnum < $minPrice) $minPrice = $pnum;
            }
          } elseif (!empty($g['price_names']) && is_array($g['price_names'])) {
            foreach ($g['price_names'] as $pn) {
              $pnum = floatval(preg_replace('/[^0-9\.]/', '', (string)$pn));
              if ($pnum > 0 && $pnum < $minPrice) $minPrice = $pnum;
            }
          }
        }
        $prices[$idx] = ($minPrice === PHP_FLOAT_MAX) ? 0 : $minPrice;
      }
      if ($sort === 'high-to-low') {
        array_multisort($prices, SORT_DESC, $filtered);
      } else {
        array_multisort($prices, SORT_ASC, $filtered);
      }
    } elseif ($sort === 'new') {
      // sort by id desc if available or leave as is
      usort($filtered, function($a,$b){ $ia = isset($a['id'])?(int)$a['id']:0; $ib = isset($b['id'])?(int)$b['id']:0; return $ib - $ia; });
    }

    // Prepare view data
    $data['products'] = $filtered;
    $data['available_colors'] = $this->my_model->getAvailableColors();
    $data['available_sizes'] = $this->my_model->getAvailableSizes();

    // Render the grid fragment for AJAX injection
    $this->load->view('products/ajax_products_grid', $data);
  }

  // Simple test method to debug AJAX issues
  public function test_ajax()
  {
    echo json_encode([
      'success' => true,
      'message' => 'AJAX endpoint is working',
      'timestamp' => date('Y-m-d H:i:s'),
      'post_data' => $this->input->post()
    ]);
  }
}
