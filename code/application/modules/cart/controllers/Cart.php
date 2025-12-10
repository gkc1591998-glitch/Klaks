<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cart extends Common_Data_Controller {
	public $headerPage   = '../../views/header';
	public $footerPage   = '../../views/footer';
	public $listPage     = 'cart';
	public $searchPage   = 'search';
	public $cartPageajax = '../../views/cart-ajax';
	
	public function __construct() {
    parent::__construct();
		$this->load->model('Common_model','common_model');
		$this->load->model('Cart_model','cart_model');
		$this->load->model('products/Products_model','products_model');
		$this->load->model('home/Home_model','home_model');
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(-1);
		ini_set('display_errors','on');
  }
	
	  public function index(){
		/*$shipvat = $this->cart_model->getshippingvat();
		$newdata = array(
					'ship'  => $shipvat['shipping'],
					'vat'   => $shipvat['vat'],
				);
		$this->session->set_userdata($newdata);*/
		$data = $this->commonData; // get common data
		// Load dynamic cross-sell products using same logic as Products::product_view()
		$related = [];
		// attempt to get a context product from the cart (first item)
		$firstItem = null;
		foreach ($this->cart->contents() as $c) { $firstItem = $c; break; }
		if (!empty($firstItem) && isset($firstItem['id'])) {
			$prod = $this->products_model->get_product($firstItem['id']);
			$subcat_id = isset($prod['subcat_id']) ? $prod['subcat_id'] : null;
			if (!empty($subcat_id)) {
				$related = $this->products_model->get_products_by_subcategory_id($subcat_id);
			} else {
				// fallback: get random products
				$related = $this->products_model->productsByType(null);
			}
			// exclude the context product and limit to 4 random products
			$related = array_values(array_filter($related, function($p) use ($firstItem){ return isset($p['id']) && $p['id'] != $firstItem['id']; }));
			if (!empty($related)) { shuffle($related); $related = array_slice($related, 0, 4); }
		} else {
			// no context product, fallback to random products limited to 4
			$related = isset($this->products_model) ? $this->products_model->productsByType(null) : [];
			if (!empty($related)) { shuffle($related); $related = array_slice($related, 0, 4); }
		}
		// attach grouped variants for rendering
		if (!empty($related)) {
			$relatedIds = array_map(function($p){ return isset($p['id']) ? $p['id'] : 0; }, $related);
			$groupsMap = $this->home_model->getGroupedVariantsForProductIds($relatedIds);
			foreach ($related as &$p) {
				$pid = isset($p['id']) ? $p['id'] : null;
				$p['variants_grouped_by_color'] = $pid && isset($groupsMap[$pid]) ? $groupsMap[$pid] : [];
			}
			unset($p);
		}
		$data['cross_sell_products'] = $related;
		$this->load->view($this->headerPage,$data); 
		$this->load->view($this->listPage, $data);
		$this->load->view($this->footerPage,$data);
	}


	public function insertcart()
	{
		//  echo "<pre>";print_r($this->input->post());exit;
			// $id = $this->input->post('valu');
		  // $quantity = $this->input->post('quantity');
			// $size = $this->input->post('size');
			// $price = $this->input->post('price');
			// echo $id." ".$quantity." ".$size." ".$price; exit;
		  // $itemdetail = $this->cart_model->getitemdetail($id);
             
		     
		// Extract post data first
		$productInfoId = $this->input->post('productInfoId');
		$qty           = $this->input->post('qty');
		$price         = $this->input->post('price');
		$name          = $this->input->post('name');
		$image         = $this->input->post('image');
		$size          = $this->input->post('size');
		$color         = $this->input->post('color');
		$uniqueId      = $this->input->post('uniqueId');
		$productId     = $this->input->post('productId');

		// Add data to $data
		$data = array(
			'id'      => $productInfoId,
			'qty'     => $qty,
			'price'   => $price,
			'name'    => $name,
			'options' => array(
				'image'      => $image,
				'size'       => $size,
				'color'      => $color,
				'variant_id' => $uniqueId,
				'product_id' => $productId
			)
		);
		
		// Insert into cart
		$this->cart->insert($data); 
		
		// Check if this is an AJAX request that expects JSON response
		if ($this->input->is_ajax_request() && $this->input->post('format') === 'json') {
			// Return JSON response for modern cart systems
			$response = array(
				'status' => 'success',
				'message' => 'Product added to cart successfully',
				'cart_count' => $this->cart->total_items(),
				'cart_total' => $this->cart->total()
			);
			
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($response));
		} else {
			// Legacy HTML response for older systems
			// Detect mobile device and load appropriate cart view
			$this->load->library('user_agent');
			$isMobile = $this->agent->is_mobile();
			
			if ($isMobile) {
				$this->load->view('../../views/mobile-cart-ajax');
			} else {
				$this->load->view($this->cartPageajax);
			}
		}
	}
	

	public function updatecart()
	{
		// echo "<pre>";print_r($this->input->post());exit;
		$qty = $this->input->post('qty');
		$rowId = $this->input->post('rowId');
		$price = $this->input->post('price');
		$data = array(
			'rowid'   => $rowId,
			'qty'     => $qty,
			'price'    => $price,
		);
		$this->cart->update($data);
		// echo "<pre>";print_r($this->cart->contents());exit;
		$this->load->view("checkoutcart");
	}
	
	public function deletecart()
	{
		$id = $this->input->post('valu');
		$data = array(
               'rowid'   => $id,
                'qty'     => 0
            );
		$this->cart->update($data);
		//$this->load->view($this->cartPageajax);
		$this->load->view("checkoutcart");
	}
}
