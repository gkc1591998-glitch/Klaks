<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subcategory extends CI_Controller {
	
	public $headerPage = 'admin_header';
	public $addPage    = 'subcategory-add';	   
	public $editPage   = 'subcategory-edit';   
	public $listPage   = 'subcategory';		  

	public $listPage_redirect = '/admin/Subcategory';		 
	public $addPage_redirect  = '/admin/Subcategory/add/';	
	public $editPage_redirect = '/admin/Subcategory/edit/';  


	public function __construct() 
	{
        parent::__construct();
  		$this->load->model('Subcategory_model','my_model');  
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(1);
		ini_set('display_errors','on'); 
    }

	public function index()
	{ 	
	
		$data['record'] = $this->my_model->get_all_records();
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
				'name' => mysqli_real_escape_string(
					$this->get_mysqli(),
					ucwords($this->input->post('name'))
				),
				'cat_id' => $this->input->post('cat_id')
			);

			$exit_details = $this->my_model->exit_details($exit_data);
			if($exit_details == 0)
			{
				$ImgData = '';
				if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
					$config['upload_path'] = './images/subcategory';
					$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
					$config['max_size']  = '0';
					$config['max_width']  = '0';
					$config['max_height']  = '0';
					$this->load->library('upload', $config);
					if(!$this->upload->do_upload('image')){
						$data['msg'] = $this->upload->display_errors();
					} else {
						$upload_data = $this->upload->data();
						$ImgData = $upload_data['file_name'];
					}
				}
				$result = $this->my_model->add_record($ImgData);
				if($result && empty($data['msg'])){
					$this->session->set_flashdata('msg_succ', 'Inserted Successfully...');
					redirect($this->listPage_redirect);
				}else if(empty($data['msg'])){
					$data['msg'] = "Not Inserted...";
				}
			}
			else
			{
				$data['msg'] = "Already Exists...";
			}
		}
		$this->load->view($this->headerPage);
		$data['categories']= $this->my_model->get_categories();
		$this->load->view($this->addPage,$data);
	}


	public function edit($id)
	{
		$data['record'] = $this->my_model->get_single_record($id);
		$data['msg'] ='';
		$old_image = $data['record']['image'];
		if($this->input->post('submit') != '')
		{
			$ImgData = $old_image;
			if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
				$config['upload_path'] = './images/subcategory';
				$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
				$config['max_size']  = '0';
				$config['max_width']  = '0';
				$config['max_height']  = '0';
				$this->load->library('upload', $config);
				if(!$this->upload->do_upload('image')){
					$data['msg'] = $this->upload->display_errors();
				} else {
					$upload_data = $this->upload->data();
					$ImgData = $upload_data['file_name'];
					// Delete old image only after successful upload
					if (!empty($old_image) && file_exists(FCPATH.'images/subcategory/'.$old_image)) {
						@unlink(FCPATH.'images/districts/'.$old_image);
					}
				}
			}
			$result = $this->my_model->update_record($id,$ImgData);
			if($result && empty($data['msg'])){
				$this->session->set_flashdata('msg_succ', 'Updated Successfully...');
				redirect($this->listPage_redirect);
			}else if(empty($data['msg'])){
				$data['msg'] = "Not Updated...";
			}
		}
		$this->load->view($this->headerPage);
		$data['categories']= $this->my_model->get_categories();
		$this->load->view($this->editPage,$data);
	}



	public function delete($id)
	{
		$data['msg'] ='';
		if($id)
		{
			$result = $this->my_model->delete_record($id);
			if($result)
			{
				$this->session->set_flashdata('msg_succ', 'Deleted Successfully...');
				redirect($this->listPage_redirect);
			} else
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


	public function status($id,$status)
	{
		$data['msg'] ='';
		$statu = ($status == 1 ? 'Deactive' : 'Active');
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

	public function get_mysqli() 
	{ 
       $db = (array)get_instance()->db;
       return mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
    }

}
?>
