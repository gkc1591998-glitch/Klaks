<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payments extends CI_Controller {
	public $headerPage       = 'admin_header';
	public $paymentsPage     = 'payments-page';
	public $paymentsdetailed = 'payments-detailed';
	
	public $listPage_redirect = '/admin/Payments';		
	public function __construct() {
	parent::__construct();
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(1);
		$this->load->model('Payments_model','my_model');
		ini_set('display_errors','on'); 
    }
	
	
	public function index()
	{ 		
		$data['record']= $this->my_model->get_payments_records();
		//echo'<pre>';print_r($data['record']);exit;
		$this->load->view($this->headerPage);
		$this->load->view($this->paymentsPage,$data);

	}
	
	public function payments_detailed($id)
	{ 		
		$data['record']= $this->my_model->get_payments_detailed($id);
		$orderid = $data['record']['order_id'];
		$data['record1']   = $this->my_model->get_user($orderid);
		$userid = $data['record1']['user_id'];
		$data['row']   = $this->my_model->get_user_details($userid);
		$this->load->view($this->headerPage);
		$this->load->view($this->paymentsdetailed,$data);
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
			redirect(site_url()."admin/Payments/orderdetailed/".$id);
			}
			else
			{
			$this->session->set_flashdata('msg_succ', 'Not Changed....');
			redirect(site_url()."admin/Payments/orderdetailed/".$id);	
			}
		}	
	}
}
?>