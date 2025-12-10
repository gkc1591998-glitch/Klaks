<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class City extends CI_Controller {
	
	public $headerPage = 'admin_header';
	public $listPage   = 'management_city';
	public $addPage    = 'management_city-add';
	public $editPage   = 'management_city-edit';
	public $viewPage   = 'management_city-view';
	public $listPage_redirect = 'admin/City';
	
	public function __construct() 
	{
        parent::__construct();
		$this->load->model('City_model','my_model'); 	
 		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off'); 
    }
	
	public function index()
	{	
		$data['record'] = $this->my_model->get_all_records(); 
		//echo '<pre>'; print_r($data['record']); exit;
		$this->load->view($this->headerPage);
		$this->load->view($this->listPage,$data);
	}
	
	public function view($id)
	{	
		$data['record'] = $this->my_model->get_single_record($id);
		$this->load->view($this->headerPage);
		$this->load->view($this->viewPage,$data);
	}

	public function add()
	{
		$data['state'] = $this->my_model->get_all_state();
		if($this->input->post('submit')!='')
		{
			$result = $this->my_model->add_record();
			if($result)
			{
				$this->session->set_flashdata('msg_succ', 'Updated Successfully.');
				redirect($this->listPage_redirect);
			}
			else
			{
				$this->session->set_flashdata('msg_fail', 'Update Failed Try Again');
				redirect($this->listPage_redirect);
			}	
		}
		$this->load->view($this->headerPage);
		$this->load->view($this->addPage,$data);		
	}	
	
	public function edit($id)
	{
		$data['state'] = $this->my_model->get_all_state();
		$data['record'] = $this->my_model->get_single_record($id); 
		
		if($this->input->post('submit')!='')
		{
			$result = $this->my_model->edit_record($id);
			if($result)
			{
				$this->session->set_flashdata('msg_succ', 'Updated Successfully.');
				redirect($this->listPage_redirect);
			}
			else
			{
				$this->session->set_flashdata('msg_fail', 'Update Failed Try Again');
				redirect($this->listPage_redirect);
			}	
		}
		$this->load->view($this->headerPage);
		$this->load->view($this->editPage,$data);		
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

	 public function city_status($id,$status)
		{
			
		$statu = ($status == 1 ? 'Deactive' : 'Active');
		if($id){
			$result = $this->my_model->city_status($id,$status);
			if($result)
			{
				$this->session->set_flashdata('msg_succ', $statu.' Successfully...');
				redirect(site_url()."admin/City");
			}
			else
			{
				$this->session->set_flashdata('msg_fail', 'Try again...');
				redirect(site_url()."admin/City");
			}
		}

	   }

}