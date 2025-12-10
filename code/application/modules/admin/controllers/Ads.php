<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ads extends CI_Controller {
	
	public $headerPage = 'admin_header';
	
	public function __construct() 
	{
        parent::__construct();
		$this->load->model('Ads_model','my_model'); 	
 		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off'); 
    }
	
	public function index()
	{	
		if($this->input->post('submit')!='')
		{
				  if ($_FILES['image']['name'] != '') 
				  {
						$config['upload_path'] = './images/ads/'; 
						$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
						$config['max_size']  = '0';
						$config['max_width']  = '0';
						$config['max_height']  = '0';
						$this->load->library('upload', $config);
						
						if(! $this->upload->do_upload('image')){
							$data['msg'] = $this->upload->display_errors();
							$this->session->set_flashdata('msg_fail', $data['msg']);
							redirect(site_url()."admin/Ads");
						}
						else
						{
							$data = $this->upload->data();
							
							$config_image = array();
							$config_image = array(
								  'image_library' => 'gd2',
								  'source_image' => './images/ads/'.$data['file_name'],
								 'new_image' => './images/ads/'.$data['file_name'],
									'width' => 337,
									'height' => 400,
									'maintain_ratio' => FALSE,
									'rotate_by_exif' => TRUE,
									'strip_exif' => TRUE,
									'master_dim'=>'auto',
								);					
								$this->load->library('image_lib', $config_image);
								$this->image_lib->initialize($config_image);
								$this->image_lib->resize();
								$this->image_lib->clear();
							
							
							
							$uploadedImages['image'] = $data['file_name'];
							$ImgData1 = array(
								'image' => $uploadedImages['image']
							);
						}
				}
				else
				{
					$ImgData1 = array(
							'image' => 0
						);
				}
				  
					$result = $this->my_model->add_banner($ImgData1['image']);
					if($result)
					{
						$this->session->set_flashdata('msg_succ', 'Added Successfully.');
						redirect(site_url()."admin/Ads");
					}
					else
					{
						$this->session->set_flashdata('msg_fail', 'Please Try Again...');
						redirect(site_url()."admin/Ads");
					}
		}
		else
        {
			$data['record'] = $this->my_model->get_ads();
			$this->load->view($this->headerPage);
			$this->load->view("ads",$data);
		}
	}
	
		public function del_banner($id)
		{ 
		if($id){
			$result = $this->my_model->delete_banner_d($id);
			if($result){
				$this->session->set_flashdata('msg_succ', 'Deleted Successfully...');
				redirect(site_url()."admin/Ads");
			}else{
				$this->session->set_flashdata('msg_fail', 'Not Deleted');
				redirect(site_url()."admin/Ads");
				}
			}
		}

		public function ads_delete_selected()
		{
			if($this->input->post('selected_ids') != '')
			{
				$delete_ids = $this->input->post('selected_ids');
				for($i=0;$i<count($delete_ids);$i++)
				{
					$result = $this->my_model->delete_banner_d($delete_ids[$i]);
				}
				if($result)
				{
					$this->session->set_flashdata('msg_succ', 'Deleted Successfully...');
					redirect(site_url()."admin/Ads");
				}else
				{
					$this->session->set_flashdata('msg_fail', 'Not Deleted...');
					redirect(site_url()."admin/Ads");
				}
			}
			else
			{
				$this->session->set_flashdata('msg_succ', 'Select any Check Box...');
				redirect(site_url()."admin/Ads");
			}
		}
		
		public function banner_status($id,$status)
		{
			
		$statu = ($status == 1 ? 'Deactive' : 'Active');
		if($id){
			$result = $this->my_model->banner_status_record($id,$status);
			if($result)
			{
				$this->session->set_flashdata('msg_succ', $statu.' Successfully...');
				redirect(site_url()."admin/Ads");
			}
			else
			{
				$this->session->set_flashdata('msg_fail', 'Try again...');
				redirect(site_url()."admin/Ads");
			}
		}

	   }
}
	