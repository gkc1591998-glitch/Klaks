<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Returns extends Common_Data_Controller {
	
	public $headerPage = '../../../views/header';
	public $footerPage = '../../../views/footer';
	public $listPage   = 'returns';	

	public function __construct() 
	{
    parent::__construct();
		$this->load->model('Common_model','common_model'); 
		$this->load->model('Returns_model','my_model'); 
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(-1);
		ini_set('display_errors','on');
  }	

	public function index()
	{
		$data = $this->commonData; // get common data
		$data['datas'] = $this->my_model->get_all_records();
		$this->load->view($this->headerPage,$data);
		$this->load->view($this->listPage,$data);
		$this->load->view($this->footerPage,$data);
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
