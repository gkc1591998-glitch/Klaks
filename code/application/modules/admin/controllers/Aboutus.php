<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Aboutus extends CI_Controller {

	

	public $headerPage = 'admin_header';

	public $addPage  = 'aboutus-add';	   

	public $editPage = 'aboutus-edit';   

	public $listPage = 'aboutus';		  



	public $listPage_redirect = '/admin/Aboutus';		 

	public $addPage_redirect = '/admin/Aboutus/add/';	

	public $editPage_redirect = '/admin/Aboutus/edit/';  





	public function __construct() {

        parent::__construct();

  		$this->load->model('Aboutus_model','my_model');  

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

				if ($_FILES['image']['name'] != '') {

					$config['upload_path'] = './images/aboutus/'; /* NB! create this dir! */

					$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';

					$config['max_size']  = '0';

					$config['max_width']  = '0';

					$config['max_height']  = '0';

					$this->load->library('upload', $config);

					

					if(! $this->upload->do_upload('image')){

						$data['msg'] = $this->upload->display_errors();

					}else{

						$data = $this->upload->data();

						//echo '<pre>';print_r($data);

						$ImgData = $data['file_name'];						

					}

		

				}else{

					$data['msg'] = 'Please Upload Image...';

				}	

				

				$result = $this->my_model->add_record($ImgData);

				if($result){

						$this->session->set_flashdata('msg_succ', 'added Successfully...');

						redirect($this->listPage_redirect);

					}else{

						$data['msg'] = "please try again...";

					}

			

		}

		$this->load->view($this->headerPage);

		$this->load->view($this->addPage,$data);

	}









	public function edit($id){



		$data['record'] = $this->my_model->get_single_record($id);

		$data['msg'] ='';

		$old_image = $data['record']['image'];

		if($this->input->post('submit') != '')

		{

			//echo '<pre>'; print_r($_FILES);exit;

			if ($_FILES['image']['name'] != '') {

				$config['upload_path'] = './images/aboutus/'; /* NB! create this dir! */

				$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';

				$config['max_size']  = '0';

				$config['max_width']  = '0';

				$config['max_height']  = '0';

				$this->load->library('upload', $config);

				

				if(! $this->upload->do_upload('image')){

					$data['msg'] = $this->upload->display_errors();

				}else{

					$data = $this->upload->data();

					//echo '<pre>';print_r($data);exit;

					 $ImgData = $data['file_name'];

				}

			    }else{

					 $ImgData= $old_image;

				}

			    $result = $this->my_model->update_record($id,$ImgData);

				//echo '<pre>';print_r($result);exit;

			    if($result){

				

			    $this->session->set_flashdata('msg_succ', 'updated Successfully...');

						redirect($this->listPage_redirect);

				}else{

						

					$data['msg'] = "please try again...";

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

	

	

	public function status($id,$status){

		$data['msg'] ='';

		//echo $status;

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



}



?>