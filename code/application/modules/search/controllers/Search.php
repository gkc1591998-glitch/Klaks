<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class Search extends Common_Data_Controller {
	public $headerPage = '../../views/header';
	public $footerPage = '../../views/footer';
	public $listPage = 'search';

	public function __construct() {
    parent::__construct();
			$this->load->model('Search_model','search_model');
			$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
			error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
			error_reporting(0);
			ini_set('display_errors','off'); 
    }
	
	public function index(){
		$data = $this->commonData; // get common data
		// Accept search query from POST (form) or GET (query param 'q') for convenience
		$query = '';
		if ($this->input->post('search_query') !== null) {
			$query = trim($this->input->post('search_query'));
		} elseif ($this->input->get('q') !== null) {
			$query = trim($this->input->get('q'));
		}

		if ($query !== '') {
			$searchData = ['query' => $query];
			$results = $this->search_model->perform_search($searchData);
			$data['query'] = $query;
			$data['products'] = $results;
			// expose helpful debug info to the view for troubleshooting
			$data['debug_last_query'] = isset($this->db) ? $this->db->last_query() : '';
			$data['debug_result_count'] = is_array($results) ? count($results) : 0;
			if (!empty($results)) {
				// set immediate message for the view (flashdata is for next request)
				$data['msg_success'] = 'Search completed successfully.';
			} else {
				$data['msg_fails'] = 'No results found.';
			}
		} else {
			// ensure products key exists for the view
			$data['products'] = [];
		}

		$this->load->view($this->headerPage, $data);
		$this->load->view($this->listPage, $data);
		$this->load->view($this->footerPage, $data);
	}
}