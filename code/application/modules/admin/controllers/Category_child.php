<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Category_child extends CI_Controller {
	
	public $headerPage = 'admin_header';
	public $listPage   = 'category_child';
	public $addPage    = 'category_child-add';
	public $editPage   = 'category_child-edit';
	public $viewPage   = 'category_child-view';
	public $listPage_redirect = 'admin/Category_child';
	
	public function __construct() 
	{
        parent::__construct();
		$this->load->model('Category_child_model','my_model'); 	
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
		$data['category'] = $this->my_model->get_all_category();
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
		$data['category'] = $this->my_model->get_all_category();
		$data['subcategory'] = $this->my_model->get_all_subcategory();
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
	
	public function delete($id)
	{ 
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

	public function getsubcat(){
		$cat_id = $this->input->post('category_name');
		$getData = $this->my_model->getsubcat($cat_id);  
		$selBox = '<option value="" >-- Select Sub Category --</option>';
		foreach($getData as $rows){
			$selBox .= '<option value="'. $rows['id'].'" >'.$rows['name'].'</option>';
		}
		echo $selBox;
	}	

}
