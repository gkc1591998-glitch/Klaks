<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Shippingandvat extends CI_Controller {
	public $headerPage = 'admin_header';
	//public $addPage    = 'products-add';	   
	public $editPage   = 'shippingandvat-edit';   
	public $listPage   = 'shippingandvat';		  

	public $listPage_redirect = '/admin/Shippingandvat';		 
	//public $addPage_redirect  = '/admin/shippingandvat/add/';	
	public $editPage_redirect = '/admin/Shippingandvat/edit/';  

	
	// Autoloading a system library usin constructor method
	public function __construct() {
        parent::__construct();
  		$this->load->model('Shippingandvat_model','my_model'); // Loading the dashboard Model		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
 		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(-1);
		ini_set('display_errors','on'); 
   }

	/** Lists of Data Function **/
	public function index(){ 
		$data['record'] = $this->my_model->get_single_record(1);
		$this->load->view($this->headerPage);
		$this->load->view($this->listPage,$data);
	}
	
	/** Edit Function **/
	public function edit($id){ 
		$data['msg'] ='';
		$data['record'] = $this->my_model->get_single_record(1);
		//if ($this->form_validation->run('shippingandvat') == TRUE) {
		if($this->input->post('add') != ''){
				$result = $this->my_model->update_record($id);
				if($result){
					$this->session->set_flashdata('msg_succ', 'Updated Successfully...');
					redirect($this->listPage_redirect);
				}else{
					$data['msg'] = "Not Updated...";
				}
		}
		$this->load->view($this->headerPage);
		$this->load->view($this->editPage,$data);
	}
}
?>