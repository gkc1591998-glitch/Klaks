<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bussiness_rules extends CI_Controller 
 {
	public $headerPage = 'admin_header';
	public $addPage    = 'bussiness_rules-add';
	public $editPage   = 'bussiness_rules-edit';
	public $listPage   = 'bussiness_rules';

	public $listPage_redirect = '/admin/Bussiness_rules';
	public $addPage_redirect  = '/admin/Bussiness_rules/add/';
	public $editPage_redirect = '/admin/Bussiness_rules/edit/';


	public function __construct() {
        parent::__construct();
  		$this->load->model('Bussiness_rules_model','my_model');
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off');
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
				'name' => mysqli_real_escape_string(ucwords($this->get_mysqli(),$this->input->post('name')))
			);

			$exit_details = $this->my_model->exit_details($exit_data);
			if($exit_details == 0)
			{
				/*if ($_FILES['image']['name'] != '') {
					$config['upload_path'] = './images/bussiness_rules'; 
					$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
					$config['max_size']  = '0';
					$config['max_width']  = '0';
					$config['max_height']  = '0';
					$this->load->library('upload', $config);
					if(! $this->upload->do_upload('image')){
						$data['msg'] = $this->upload->display_errors();
					}else{
						$data = $this->upload->data();
						$ImgData = $data['file_name'];
						$result = $this->my_model->add_record($ImgData);*/
						$result = $this->my_model->add_record();
						if($result){
							$this->session->set_flashdata('msg_succ', 'Inserted Successfully...');
							redirect($this->listPage_redirect);
						}else{
							$data['msg'] = "Not Inserted...";
						}
					/*}
				}else{
					$data['msg'] = 'Please Upload Image...';
				}*/
			}
			else
			{
					$data['msg'] = "Already Exists...";
			}
		}
		$this->load->view($this->headerPage);
		$this->load->view($this->addPage,$data);
	}

	public function edit($id)
	{
		$data['record'] = $this->my_model->get_single_record($id);
		$data['msg'] ='';
		$old_image = $data['record']['image'];
		if($this->input->post('submit') != '')
		{
			/*if ($_FILES['image']['name'] != '') {
				$config['upload_path'] = './images/bussiness_rules';
				$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
				$config['max_size']  = '0';
				$config['max_width']  = '0';
				$config['max_height']  = '0';
				$this->load->library('upload', $config);
				if(! $this->upload->do_upload('image')){
					$data['msg'] = $this->upload->display_errors();
				} else {
					$data = $this->upload->data();
					$ImgData = $data['file_name'];
					$result = $this->my_model->update_record($id,$ImgData);*/
					$result = $this->my_model->update_record($id);
					if($result){
						/*$file = $config['upload_path'].$old_image;
						if(is_file($file))
						unlink($file);*/
						$this->session->set_flashdata('msg_succ', 'Updated Successfully...');
						redirect($this->listPage_redirect);
					}else{
						$data['msg'] = "Not Updated...";
					}
				/*}
	
			}else{
				$ImgData = $old_image;
				$result = $this->my_model->update_record($id,$ImgData);
				if($result){
					$this->session->set_flashdata('msg_succ', 'Updated Successfully...');
					redirect($this->listPage_redirect);
				} else {
					$data['msg'] = "Not Updated...";
				}
			}*/
		}
		$this->load->view($this->headerPage);
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

     public function slider_status($id,$status)
	 {
		$statu = ($status == 1 ? 'Deactive' : 'Active');
		if($id)
		{
			$result = $this->my_model->slider_status_record($id,$status);
			if($result)
			{
				$this->session->set_flashdata('msg_succ', $statu.' Successfully...');
				redirect(site_url()."admin/Bussiness_rules");
			}
			else
			{
				$this->session->set_flashdata('msg_fail', 'Try again...');
				redirect(site_url()."admin/Bussiness_rules");
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
