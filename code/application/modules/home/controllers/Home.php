<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends Common_Data_Controller {
	public $headerPage   = '../../views/header';
	public $footerPage   = '../../views/footer';
	public $listPage     = 'home';
	public $searchPage   = 'search';
	public $cartPageajax = '../../views/cart-ajax';
	public $orderPage    = 'track_order';

	// types of products
	public $newDrops = 'New Drops';
	public $mostTrending  = 'Most Trending';
	public $seasonalFavs = 'Seasonal Favourites';
	public $shirts   = 'Shirts';
	public $tshirts  = 'T-Shirts';
	public $jeans    = 'Jeans';
	public $trending = 'Trending';
	public $shorts   = 'Shorts';
	public $trousers = 'Trousers';
	public $recentstalked   = 'Recently Stalked';
	public $pants    = 'Pants';
	public $skirts   = 'Skirts';
	public $jackets  = 'Jackets';
	public $sweatshirts = 'Sweat Shirts';
	public $shoes    = 'Shoes';
	public $bags     = 'Bags';
	public $accessories = 'Accessories';

	
	public function __construct() {
    parent::__construct();
    $this->load->model('Common_model','common_model');
		$this->load->model('Home_model','my_model');
		$this->load->model('products/Products_model','products_model');
    }
	
	public function index(){

		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
    $data['sliders']        = $this->my_model->get_sliders();

		// Load most trending grouped by color
		$data['most_trending'] = $this->my_model->getProductsGroupedByColorBySection($this->mostTrending);

		// Load dynamic categories
		$data['mens_categories'] = $this->my_model->get_mens_categories();
		$data['womens_categories'] = $this->my_model->get_womens_categories();
		$data['accessories_categories'] = $this->my_model->get_accessories_categories();

		// Load products for each subcategory (raw) so we can batch-attach grouped variants
		$data['mens_products'] = array();
		$allProductIds = [];
		foreach ($data['mens_categories'] as $category) {
			// Require slug; skip category if slug is missing
			if (empty($category['slug'])) continue;
			$subSlug = $category['slug'];
			$list = $this->my_model->get_products_by_subcategory_raw($subSlug);
			$data['mens_products'][$subSlug] = $list;
			foreach ($list as $p) $allProductIds[] = $p['id'];
		}

		// echo "<pre>";print_r($data['mens_categories']);exit;

		$data['womens_products'] = array();
		foreach ($data['womens_categories'] as $category) {
			// Require slug; skip category if slug is missing
			if (empty($category['slug'])) continue;
			$subSlug = $category['slug'];
			$list = $this->my_model->get_products_by_subcategory_raw($subSlug);
			$data['womens_products'][$subSlug] = $list;
			foreach ($list as $p) $allProductIds[] = $p['id'];
		}

		$data['accessories_products'] = array();
		foreach ($data['accessories_categories'] as $category) {
			// Require slug; skip category if slug is missing
			if (empty($category['slug'])) continue;
			$subSlug = $category['slug'];
			$list = $this->my_model->get_products_by_subcategory_raw($subSlug);
			$data['accessories_products'][$subSlug] = $list;
			foreach ($list as $p) $allProductIds[] = $p['id'];
		}

		// Attach grouped variants per subcategory with a simple cache
		foreach ($data['mens_products'] as $sub => &$plist) {
			// $sub is now the subcategory slug
			$pids = array_map(function($p){ return $p['id']; }, $plist);
			if (!empty($pids)) {
				$groupsMap = $this->my_model->getGroupedVariantsForProductIdsCached($pids, 'mens_' . $sub, 300);
			} else {
				$groupsMap = [];
			}
			foreach ($plist as &$p) {
				$p['variants_grouped_by_color'] = isset($groupsMap[$p['id']]) ? $groupsMap[$p['id']] : [];
			}
		}
		foreach ($data['womens_products'] as $sub => &$plist) {
			// $sub is now the subcategory slug
			$pids = array_map(function($p){ return $p['id']; }, $plist);
			if (!empty($pids)) {
				$groupsMap = $this->my_model->getGroupedVariantsForProductIdsCached($pids, 'womens_' . $sub, 300);
			} else {
				$groupsMap = [];
			}
			foreach ($plist as &$p) {
				$p['variants_grouped_by_color'] = isset($groupsMap[$p['id']]) ? $groupsMap[$p['id']] : [];
			}
		}
		foreach ($data['accessories_products'] as $sub => &$plist) {
			// $sub is now the subcategory slug
			$pids = array_map(function($p){ return $p['id']; }, $plist);
			if (!empty($pids)) {
				$groupsMap = $this->my_model->getGroupedVariantsForProductIdsCached($pids, 'accessories_' . $sub, 300);
			} else {
				$groupsMap = [];
			}
			foreach ($plist as &$p) {
				$p['variants_grouped_by_color'] = isset($groupsMap[$p['id']]) ? $groupsMap[$p['id']] : [];
			}
		}
		
		// echo "<pre>";print_r($data['mens_products']);exit;
		$this->load->view($this->listPage,$data);
		$this->load->view($this->footerPage, $data);
	}
	

	public function searchproperty()
	{	
		if($this->input->post('submit')!='')
		{
			$text = substr($this->input->post('keyword'), 0,7);
			$data = $this->commonData; // get common data
			$this->load->view($this->headerPage,$data);
			$data['products']      = $this->common_model->get_search($text);
			$this->load->view($this->searchPage,$data);
			$this->load->view($this->footerPage, $data);
		}
	}

	public function trackorder()
	{	
		if($this->input->post('submit')!='')
		{
			$orderid      =	$this->input->post('orderid');
			$data = $this->commonData; // get common data
			$this->load->view($this->headerPage,$data);
			$data['orderstatus']  = $this->common_model->get_order_status($orderid);
			/*echo "<pre>";print_r($data['orderstatus']);exit;*/
			$this->load->view($this->orderPage,$data);
			$this->load->view($this->footerPage, $data);

		}
	} 
}
