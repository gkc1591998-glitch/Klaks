<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends Common_Data_Controller {
	public $headerPage        = '../../views/header';
	public $footerPage        = '../../views/footer';
	public $dashboardPage          = 'dashboard';
	public $profilePage          = 'profile';
	public $addressPage          = 'address';
	public $wishlistPage          = 'wishlist';
	public $ordersPage          = 'orders';
	public $product_viewPage  = 'view-product';
	public $cartPageajax      = '../../views/cart-ajax';
	
	public function __construct() {
    parent::__construct();
		$this->load->model('Dashboard_model','my_model');
		$this->load->model('Common_model','common_model');
		$this->load->model('Register/Register_model','register_model');
		$this->load->model('Wishlist_model','wishlist_model');
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(1);
		ini_set('display_errors','on'); 
  }
	 
	public function profile(){
		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
		$data['record']=$this->register_model->get_profie();
		$this->load->view($this->profilePage,$data);
		$this->load->view($this->footerPage,$data);
	}

	public function orders(){
		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
		$data['products']=$this->my_model->get_profile_orders();
		// echo "<pre>";print_r($data['products']);exit;
		$this->load->view($this->ordersPage,$data);
		$this->load->view($this->footerPage,$data);
	}

	public function index(){
		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
		$this->load->view($this->dashboardPage,$data);
		$this->load->view($this->footerPage,$data);
	}


	public function prouct_by_category($id)
	{
		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
		$data['products']    = $this->my_model->get_category_products($id);
		$this->load->view($this->listPage,$data);
		$this->load->view($this->footerPage,$data);
	}

	public function prouct_by_subcategory($cat_id,$id){
		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
		$data['products']= $this->my_model->get_subcategory_products($cat_id,$id);
		$this->load->view($this->listPage,$data);
		$this->load->view($this->footerPage,$data);
	}
 
	public function prouct_by_childcategory($cat_id,$subcat_id){
		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
		$data['products']=$this->my_model->get_childcategory_products($cat_id,$subcat_id);
		$this->load->view($this->listPage,$data);
		$this->load->view($this->footerPage,$data);
	}

	public function product_view($id)
	{
		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
		$data['product_view'] = $this->my_model->get_product($id);
		$data['products'] = $this->my_model->get_recent_ads($id,$data['product_view']['cat_id']);
		$this->load->view($this->product_viewPage,$data);
		$this->load->view($this->footerPage,$data);
	}

	public function productDetailsAjax($productId, $size)
	{
		$id = $productId;
		$product_details = $this->my_model->get_product($id);
		// echo $product_details; exit;
		if($product_details)
		{
			if($size == 'XS') {
				echo $product_details['sprice']; // Use S price for XS
			} else if($size == 'S') {
				echo $product_details['sprice'];
			} else if($size == 'M') {
				echo $product_details['mprice'];
			} else if($size == 'L') {
				echo $product_details['lprice'];
			} else if($size == 'XL') {
				echo $product_details['xlprice'];
			} else if($size == 'XXL' || $size == '2XL') {
				echo $product_details['xxlprice'];
			} else if($size == '3XL') {
				echo $product_details['xxlprice']; // Use XXL price for 3XL
			}
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
		$this->load->view($this->cartPageajax);
		//$this->load->view("checkoutcart");
	}

	/**
	 * Display user's wishlist
	 */
	public function wishlist() {
		// Check if user is logged in
		if(!$this->session->userdata('user_id')) {
			redirect('login');
		}
		
		$data = $this->commonData; // get common data
		$user_id = $this->session->userdata('user_id');
		$data['wishlist_items'] = $this->wishlist_model->get_user_wishlist($user_id);
		$data['wishlist_count'] = $this->wishlist_model->get_wishlist_count($user_id);

		// echo "<pre>";print_r($data['wishlist_items']);exit; // Debugging line, remove in production
		
		$this->load->view($this->headerPage, $data);
		$this->load->view($this->wishlistPage, $data);
		$this->load->view($this->footerPage, $data);
	}

	/**
	 * Add product to wishlist via AJAX
	 */
	public function add_to_wishlist() {
		// Check if user is logged in
		if(!$this->session->userdata('user_id')) {
			echo json_encode(['status' => 'error', 'message' => 'Please login to add items to wishlist']);
			return;
		}
		
		$product_id = $this->input->post('product_id');
		$product_more_info_id = $this->input->post('product_more_info_id'); // Get the specific variant
		$user_id = $this->session->userdata('user_id');
		
		if($product_id && $user_id) {
			$result = $this->wishlist_model->add_to_wishlist($user_id, $product_id, $product_more_info_id);
			
			if($result) {
				$wishlist_count = $this->wishlist_model->get_wishlist_count($user_id);
				echo json_encode([
					'status' => 'success', 
					'message' => 'Product added to wishlist',
					'wishlist_count' => $wishlist_count
				]);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Product already in wishlist']);
			}
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
		}
	}

	/**
	 * Remove product from wishlist via AJAX
	 */
	public function remove_from_wishlist() {
		// Check if user is logged in
		if(!$this->session->userdata('user_id')) {
			echo json_encode(['status' => 'error', 'message' => 'Please login first']);
			return;
		}
		
		$product_id = $this->input->post('product_id');
		$product_more_info_id = $this->input->post('product_more_info_id'); // Get the specific variant
		$user_id = $this->session->userdata('user_id');
		
		if($product_id && $user_id) {
			$result = $this->wishlist_model->remove_from_wishlist($user_id, $product_id, $product_more_info_id);
			
			if($result) {
				$wishlist_count = $this->wishlist_model->get_wishlist_count($user_id);
				echo json_encode([
					'status' => 'success', 
					'message' => 'Product removed from wishlist',
					'wishlist_count' => $wishlist_count
				]);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Failed to remove product']);
			}
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
		}
	}

	/**
	 * Check which products from a list are in user's wishlist
	 */
	public function check_wishlist_items() {
		// Check if user is logged in
		if(!$this->session->userdata('user_id')) {
			echo json_encode(['status' => 'error', 'message' => 'Please login first']);
			return;
		}
		
		$user_id = $this->session->userdata('user_id');
		$product_ids = $this->input->post('product_ids');
		
		if(empty($product_ids) || !is_array($product_ids)) {
			echo json_encode(['status' => 'error', 'message' => 'No product IDs provided']);
			return;
		}
		
		$wishlist_items = $this->wishlist_model->check_products_in_wishlist($user_id, $product_ids);
		
		echo json_encode([
			'status' => 'success', 
			'wishlist_items' => $wishlist_items
		]);
	}

	/**
	 * Check variant-specific wishlist status for products
	 */
	public function check_variant_wishlist_items() {
		// Check if user is logged in
		if(!$this->session->userdata('user_id')) {
			echo json_encode(['status' => 'error', 'message' => 'Please login first']);
			return;
		}
		
		$user_id = $this->session->userdata('user_id');
		
		// Get product_ids - handle both array and serialized formats
		// jQuery sends arrays as product_ids[] = val1, product_ids[] = val2, etc.
		$product_ids = $this->input->post('product_ids');
		
		// If null, try the array notation that jQuery uses
		if ($product_ids === NULL && isset($_POST['product_ids'])) {
			$product_ids = $_POST['product_ids'];
		}
		
		// Convert to array if needed
		if (!is_array($product_ids)) {
			if (!empty($product_ids)) {
				$product_ids = array($product_ids);
			} else {
				$product_ids = array();
			}
		}
		
		// Sanitize: convert all to integers and remove invalid values
		$product_ids = array_map('intval', array_filter($product_ids, function($id) {
			return !empty($id);
		}));
		
		if (empty($product_ids)) {
			http_response_code(400);
			echo json_encode(['status' => 'error', 'message' => 'No valid product IDs provided']);
			return;
		}
		
		// Get wishlist variants from model
		$wishlist_variants = $this->wishlist_model->check_variants_in_wishlist($user_id, $product_ids);
		
		// Return result
		http_response_code(200);
		header('Content-Type: application/json');
		echo json_encode([
			'status' => 'success', 
			'wishlist_variants' => $wishlist_variants
		]);
	}

	/**
	 * Get user's complete wishlist items (for fallback compatibility)
	 */
	public function get_user_wishlist_items() {
		// Check if user is logged in
		if(!$this->session->userdata('user_id')) {
			echo json_encode(['status' => 'error', 'message' => 'Please login first']);
			return;
		}
		
		$user_id = $this->session->userdata('user_id');
		
		// Get all wishlist items with variant details
		$this->db->select('w.*, w.product_more_info_id as variant_id');
		$this->db->from('tbl_wishlist w');
		$this->db->where('w.user_id', $user_id);
		$query = $this->db->get();
		$wishlist_items = $query->result_array();
		
		echo json_encode([
			'status' => 'success', 
			'wishlist_items' => $wishlist_items
		]);
	}

	/**
	 * Clear entire wishlist
	 */
	public function clear_wishlist() {
		// Check if user is logged in
		if(!$this->session->userdata('user_id')) {
			echo json_encode(['status' => 'error', 'message' => 'Please login first']);
			return;
		}
		
		$user_id = $this->session->userdata('user_id');
		$result = $this->wishlist_model->clear_wishlist($user_id);
		
		if($result) {
			echo json_encode(['status' => 'success', 'message' => 'Wishlist cleared successfully']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to clear wishlist']);
		}
	}
}
