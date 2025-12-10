<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contactus extends CI_Controller {

	public $headerPage = 'admin_header';
	public $table_name = 'tbl_contact';	  //*****  Table name  *****//
	public $listPage = 'contactus';		
	public $viewPage='contact_view.php';
		 //*****  View page   *****//
	public $listPage_redirect = '/admin/Contactus';		  //*****  Redirect View  *****//

	public function __construct() {
        parent::__construct();
  		$this->load->model('Contactus_model','my_model');   //*****    Model Loading     *****//	
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off'); 
    }



	public function index(){ 		 
		$data['record'] = $this->my_model->get_all_records();	
		$this->load->view($this->headerPage);
		$this->load->view($this->listPage,$data);
	}

	/** View Function **/
	public function view($id){ 
		$data['record'] = $this->my_model->get_single_record($id);
		//print_r($data['record']);
		$this->load->view($this->headerPage);
	    $this->load->view($this->viewPage,$data);
	}

	/** Status Change Function **/
	public function contactStatus($id,$status){
		$data['msg'] ='';
		//echo $status;
		$statu = ($status == 1 ? 'Status Change' : 'Status Change');
		if($id){
			$result = $this->my_model->status_record($id,$status);
			if($result){
				$this->session->set_flashdata('msg_succ', $statu.' Successfully...');
				redirect($this->listPage_redirect);
			}else{
				$data['msg'] = " Status Not Updated...";
			}
		}
	}	
	
	public function Status($id,$status){
		$data['msg'] ='';
		//echo $status;
		$statu = ($status == 1 ? 'Status Change' : 'Status Change');
		if($id){
			$result = $this->my_model->status_record($id,$status);
			if($result){
				$this->session->set_flashdata('msg_succ', $statu.' Successfully...');
				redirect('master/dashboard');
			}else{
				$data['msg'] = " Status Not Updated...";
			}
		}
	}	
	

public function delete_selected(){
		$data['msg'] ='';
		if($this->input->post('selected_ids') != ''){
			$selected_ids = $this->input->post('selected_ids');
			for($i=0;$i<count($selected_ids);$i++){
				$result = $this->my_model->delete_record($selected_ids[$i]);
			}
			if($result){
				$this->session->set_flashdata('msg_succ', 'Deleted Successfully...');
				redirect($this->listPage_redirect);
			}else{
				$this->session->set_flashdata('msg_succ', 'Not Deleted...');
				redirect($this->listPage_redirect);
			}
		}
		else
		{
			$this->session->set_flashdata('msg_succ', 'Select any Check Box...');
			redirect($this->listPage_redirect);
		}
	}
	
	
	public function delete($id){ 
		if($id)
		{
			$result = $this->my_model->delete_record($id);
			if($result)
			{
				$this->session->set_flashdata('msg_succ', 'Deleted Successfully...');
				redirect($this->listPage_redirect);
			}else
			{
				$this->session->set_flashdata('msg_succ', 'Not Deleted...');
				redirect($this->listPage_redirect);
			}
		}
	}
	
	public function deletefile($path,$old_image)
	{
		$file = $path.$old_image;
		if(is_file($file))
		unlink($file); 
	}
}
?>