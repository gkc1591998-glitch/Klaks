<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller {
	public $headerPage = 'admin_header';
	public $ordersPage = 'orders-page';
	public $ordersdetailed = 'order-detailed';
	
	public $listPage_redirect = '/admin/Orders';		
	public function __construct() {
	parent::__construct();
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	$this->load->model('Orders_model','my_model');
		error_reporting(0);
		ini_set('display_errors','off'); 
    }
	
	
	public function index()
	{ 		
		$data['record']= $this->my_model->get_orders_records();
		//echo'<pre>';print_r($data['record']);exit;
		$this->load->view($this->headerPage);
		$this->load->view($this->ordersPage,$data);

	}
	
	public function orderdetailed($id)
	{ 		
		$this->my_model->changeviewstatus($id);
		$data['record']= $this->my_model->get_orders_detailed($id);
		$data['products']= $this->my_model->get_orders_products($id);
		$this->load->view($this->headerPage);
		$this->load->view($this->ordersdetailed,$data);
	}
	
	public function delete($id)
	{ 
		$data['msg'] ='';
		if($id){
			$result = $this->my_model->delete_record($id);
			if($result){
				$this->session->set_flashdata('msg_succ', 'Deleted Successfully...');
				redirect($this->listPage_redirect);
			}else{
				$data['msg'] = "Not Deleted...";
			}
		}
	}
	
	public function multi_delete(){
		$data['msg'] ='';
		if($this->input->post('delete_ids') != ''){
			$delete_ids = $this->input->post('delete_ids');
			// echo "<pre>";print_r($delete_ids);exit;
			for($i=0;$i<count($delete_ids);$i++){
				$result = $this->my_model->delete_record($delete_ids[$i]);
			}
			if($result){
				$this->session->set_flashdata('msg_succ', 'Deleted Successfully...');
				redirect($this->listPage_redirect);
			}else{
				$this->session->set_flashdata('msg_succ', 'Not Deleted...');
				redirect($this->listPage_redirect);
			}
		}else{
			$this->session->set_flashdata('msg_succ', 'Select any Check Box...');
			redirect($this->listPage_redirect);
		}
	}
	
	public function changestatus($change,$id){
		
		
		if($id!='')
		{
			$result = $this->my_model->change($id,$change);
			
			if($result)
			{
			$this->session->set_flashdata('msg_succ', 'Changed Sucessfully...');
			redirect(site_url()."admin/orders/orderdetailed/".$id);
			}
			else
			{
			$this->session->set_flashdata('msg_succ', 'Not Changed....');
			redirect(site_url()."admin/orders/orderdetailed/".$id);	
			}	
		}	
	}
}
?>