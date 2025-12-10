<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Common_Data_Controller extends MX_Controller {
    public $commonData = [];
    
    // Standard page components - moved from individual controllers
    public $headerPage = '../../views/header';
    public $footerPage = '../../views/footer';
    public $cartPageajax = '../../views/cart-ajax';

    public function __construct() {
      parent::__construct();
      $this->_setup_error_reporting();
      $this->load->model('Common_model','common_model');
      $this->_load_common_data();
    }

    /**
     * Standardized error reporting setup
     */
    protected function _setup_error_reporting() {
        error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        error_reporting(-1);
        ini_set('display_errors','on');
    }

    /**
     * Load common data used across all modules
     */
    protected function _load_common_data() {
        $this->commonData['web_settings'] = $this->common_model->get_all_websettings();
        $this->commonData['menu'] = $this->common_model->get_all_menu();
        $this->commonData['banners'] = $this->common_model->get_all_banners();
        $this->commonData['categories'] = $this->common_model->get_active_categories();
        $this->commonData['subcategories'] = $this->common_model->get_active_subcategories();
        $this->commonData['childcategories'] = $this->common_model->get_active_childcategories();
    }

    /**
     * Standard view loading pattern used across all modules
     * @param string $contentView The main content view to load
     * @param array $data Data to pass to views
     */
    protected function _load_standard_views($contentView, $data = []) {
        if (empty($data)) {
            $data = $this->commonData;
        }
        
        $this->load->view($this->headerPage, $data);
        $this->load->view($contentView, $data);
        $this->load->view($this->footerPage, $data);
    }

    /**
     * Load cart ajax view - common across modules
     */
    protected function _load_cart_ajax() {
        $this->load->view($this->cartPageajax);
    }

    /**
     * Standard AJAX subcategories method - reusable across modules
     */
    public function ajax_get_subcategories() {
        $parent_id = $this->input->post('parent_id');
        
        if (!$parent_id) {
            echo json_encode(['status' => 'error', 'message' => 'Parent ID required']);
            return;
        }

        $this->load->model('categories/Categories_model', 'categories_model');
        $subcategories = $this->categories_model->getSubcategoriesByParentId($parent_id);
        
        if (!empty($subcategories)) {
            echo json_encode(['status' => 'success', 'data' => $subcategories]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No subcategories found']);
        }
    }
}