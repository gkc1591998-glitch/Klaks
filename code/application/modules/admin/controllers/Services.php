<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Services extends CI_Controller {
	
	public $headerPage = 'admin_header';
	public $addPage    = 'services-add';	   
	public $editPage   = 'services-edit';   
	public $listPage   = 'services';		  

	public $listPage_redirect = '/admin/Services';		 
	public $addPage_redirect  = '/admin/Services/add/';	
	public $editPage_redirect = '/admin/Services/edit/';  


	public function __construct() {
        parent::__construct();
  		$this->load->model('Services_model','my_model');  
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off'); 
    }



	public function index(){ 	
	
		$data['record'] = $this->my_model->get_all_records();	
		//echo'<pre>';print_r($data['record']);exit;
		$this->load->view($this->headerPage);
		$this->load->view($this->listPage,$data);

	}

	



	public function add()
	{ 

		$data['msg'] ='';
		if($this->input->post('submit') != '')
		{
			$exit_data = array
			(
				'name' => mysql_real_escape_string(ucwords($this->input->post('name'))),
			);				
			$exit_details = $this->my_model->exit_details($exit_data);
			if($exit_details == 0)
			{
				$result = $this->my_model->add_record();
				if($result)
				{
					$this->session->set_flashdata('msg_succ', 'Inserted Successfully...');
					redirect($this->listPage_redirect);
				}else
				{
					$data['msg'] = "Not Inserted...";
				}
			}
			else
			{
					$data['msg'] = "Already Exists...";
			}
		}
		$this->load->view($this->headerPage);
		$this->load->view($this->addPage,$data);
	}




	public function edit($id){

		$data['record'] = $this->my_model->get_single_record($id);
		$data['msg'] ='';
		if($this->input->post('submit') != '')
		{
			$result = $this->my_model->update_record($id);
			if($result)
			{
				$this->session->set_flashdata('msg_succ', 'Updated Successfully...');
				redirect($this->listPage_redirect);
			}else
			{
				$data['msg'] = "Not Updated...";
			}
		}
		$this->load->view($this->headerPage);
		$this->load->view($this->editPage,$data);

	}


	public function delete($id){ 
		$data['msg'] ='';
		if($id)
		{
			$result = $this->my_model->delete_record($id);
			if($result)
			{
				$this->session->set_flashdata('msg_succ', 'Deleted Successfully...');
				redirect($this->listPage_redirect);
			}else
			{
				$data['msg'] = "Not Deleted...";
			}
		}

	}



	public function delete_selected()
	{

		$data['msg'] ='';
		if($this->input->post('selected_ids') != '')
		{
			$delete_ids = $this->input->post('selected_ids');
			for($i=0;$i<count($delete_ids);$i++)
			{
				$result = $this->my_model->delete_record($delete_ids[$i]);
			}
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
		else
		{
			$this->session->set_flashdata('msg_succ', 'Select any Check Box...');
			redirect($this->listPage_redirect);
		}
	}

	 public function service_status($id,$status)
		{
			
		$statu = ($status == 1 ? 'Deactive' : 'Active');
		if($id){
			$result = $this->my_model->service_status_record($id,$status);
			if($result)
			{
				$this->session->set_flashdata('msg_succ', $statu.' Successfully...');
				redirect(site_url()."admin/services");
			}
			else
			{
				$this->session->set_flashdata('msg_fail', 'Try again...');
				redirect(site_url()."admin/services");
			}
		}

	   }
}

?>