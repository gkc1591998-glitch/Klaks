<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Albums extends CI_Controller {
	
	public $headerPage = 'admin_header';
	
	public function __construct() 
	{
        parent::__construct();
		$this->load->model('Albums_model','my_model'); 	
 		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off'); 
    }
	
	public function index()
	{	
		if($this->input->post('submit')!='')
		{
				
				$total = count($_FILES['images']['name']);
				// Loop through each file
				for($i=0; $i<$total; $i++) {
                  $gallery = explode(".",$_FILES["images"]["name"][$i]);
			      $gallery_image = "gallery".md5(uniqid(time())).".".end($gallery);

				  //Get the temp file path
				  $tmpFilePath = $_FILES['images']['tmp_name'][$i];

				  //Make sure we have a filepath
				  if ($tmpFilePath != ""){
				    //Setup our new file path
				    $newFilePath = "images/albums/".$gallery_image;
				    //Upload the file into the temp dir
				    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
			        $gallery = $this->my_model->add_banner($gallery_image);
				    }
                  }
                }
					if($gallery)
					{
						$this->session->set_flashdata('msg_succ', 'Added Successfully.');
						redirect(site_url()."admin/Albums");
					}
					else
					{
						$this->session->set_flashdata('msg_fail', 'Please Try Again...');
						redirect(site_url()."admin/Albums");
					}
		}
		else
        {
			$data['galleries'] = $this->my_model->get_ads();
			$this->load->view($this->headerPage);
			$this->load->view("albums",$data);
		}
	}


	public function delete_gallery($galleryid)
	{
		$gallery = $this->my_model->delete_gallery_image($galleryid);
		        if($gallery)
					{
						$this->session->set_flashdata('msg_succ', 'Deleted  Successfully.');
						redirect(site_url()."admin/Albums");
					}
					else
					{
						$this->session->set_flashdata('msg_fail', 'Please Try Again...');
						redirect(site_url()."admin/Albums");
					}
	}

}
	