<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Categories extends Common_Data_Controller {
    public $headerPage = '../../views/header';
    public $footerPage = '../../views/footer';
    public $listPage = 'categories';
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Categories_model','categories_model');
    }
    
    public function index() {
        $data = $this->commonData;
        $data['categories'] = $this->categories_model->getAllCategories();
        
        $this->load->view($this->headerPage, $data);
        $this->load->view($this->listPage, $data);
        $this->load->view($this->footerPage, $data);
    }
}
