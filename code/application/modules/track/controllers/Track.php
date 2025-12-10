<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Track extends Common_Data_Controller {

	public $headerPage = '../../../views/header';
	public $footerPage = '../../../views/footer';
	public $listPage = 'track';
	public $viewPage = 'track-detail';

	public function __construct()
	{
    parent::__construct();
	  $this->load->model('Common_model','common_model');
	  $this->load->model('Track_model','my_model');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(-1);
		ini_set('display_errors','on');
  }
	public function index()
	{
		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
		$data['cat'] = $this->my_model->get_all_categories();
		$data['datas'] = $this->my_model->get_all_records();
		//echo "<pre>";print_r($data['datas']);exit;
		$this->load->view($this->listPage,$data);
		$this->load->view($this->footerPage,$data);
	}

	public function view($id)
	{
		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);

		$data['cat'] = $this->my_model->get_all_categories();
		$data['datas']  = $this->my_model->get_all_records();
		$data['record'] = $this->my_model->get_record($id);
		//echo "<pre>";print_r($data['datas']);exit;
		$this->load->view($this->viewPage,$data);
		$this->load->view($this->footerPage,$data);
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
