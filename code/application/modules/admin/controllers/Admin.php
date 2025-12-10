<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public $index_page = "login";
	public $listPage_redirect = '/admin/Home';
	public $login_redirect = '/admin/index';
	
	public function __construct() 
	{
    parent::__construct();
		echo $this->input->post('user');
		echo $this->input->post('password');
		$this->load->library('session');
      if ($this->session->userdata('username')!="") { 
        redirect($this->listPage_redirect, 'refresh'); 
      }
  		$this->load->model('Admin_model','my_model'); 
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(1);
		ini_set('display_errors','on'); 
    }
	
	public function index()
	{	
		if($this->input->post('submit')!='')
		{
				$admin_details = $this->my_model->getadmindata();
				
					if($admin_details)
					{				
							$newdata = array
									(
										'user'  => $admin_details['username'],
										'developed_by' => ""
									);
							$this->session->set_userdata($newdata);
							$this->session->set_flashdata( 'msg_succ', 'HI, Admin, You was signed in Successfully.' );
							redirect($this->listPage_redirect);
					}
					else 
					{
							$this->session->set_flashdata( 'msg_fail', 'Oops...Invalid Credentials Dear, Try again.' );
							redirect($this->login_redirect);
					}				
	 	}
		$this->load->view($this->index_page);
	}
	
	public function backupdb()
	{
		$this->load->dbutil();

        $prefs = array(     
                'format'      => 'zip',             
                'filename'    => 'my_db_backup.sql'
              );


        $backup =& $this->dbutil->backup($prefs); 

        $db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
        $save = 'pathtobkfolder/'.$db_name;

        $this->load->helper('file');
        write_file($save, $backup); 


        $this->load->helper('download');
        force_download($db_name, $backup); 
      }
}
