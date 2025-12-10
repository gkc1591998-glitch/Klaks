<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller {
	public $headerPage = 'admin_header';
	public $table_name = 'tbl_register';	  
	public $listPage = 'users';		
	public $viewPage='contact_view.php';
		 
	public $listPage_redirect = '/admin/Users';		  
	public function __construct() {
        parent::__construct();
  		$this->load->model('Users_model','my_model');   
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
	
	
	public function view($id){ 
		$data['record'] = $this->my_model->get_single_record($id);
		//print_r($data['record']);
		$this->load->view($this->headerPage);
		$this->load->view($this->viewPage,$data);
	}
	
	public function contactStatus($id,$status){
		$data['msg'] ='';
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
	
	public function get_user_details() {
		if ($this->input->is_ajax_request()) {
			$user_id = $this->input->post('user_id');
			
			if ($user_id) {
				$user_data = $this->my_model->get_single_record($user_id);
				
				if ($user_data) {
					// Format the date
					$user_data['create_date_time'] = date('d-m-Y H:i:s', strtotime($user_data['create_date_time']));
					
					echo json_encode([
						'success' => true,
						'data' => $user_data
					]);
				} else {
					echo json_encode([
						'success' => false,
						'message' => 'User not found'
					]);
				}
			} else {
				echo json_encode([
					'success' => false,
					'message' => 'Invalid user ID'
				]);
			}
		} else {
			show_404();
		}
	}
	
	public function Status($id,$status){
		$data['msg'] ='';
		$statu = ($status == 1 ? 'User Deactivated' : 'User Activated');
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
	
	public function delete($id){ 
		$data['msg'] ='';
		if($id){
			$result = $this->my_model->delete_record($id);
			if($result){
				$this->session->set_flashdata('msg_succ', 'Deleted Successfully...');
				redirect($this->listPage_redirect);
			}else{
				$this->session->set_flashdata('msg_succ', 'Not Deleted...');
				redirect($this->listPage_redirect);
			}
		}
	}

	public function multi_delete(){
		$data['msg'] ='';
		if($this->input->post('selected_ids') != ''){
			$delete_ids = $this->input->post('selected_ids');
			for($i=0;$i<count($delete_ids);$i++){
				$result = $this->my_model->delete_record($delete_ids[$i]);
			}
			if($result){
				$this->session->set_flashdata('msg_succ', 'Deleted Successfully...');
				redirect($this->listPage_redirect);
			}else{
				$this->session->set_flashdata('msg_succ', 'Not Deleted...');
				redirect($this->listPage_redirect);
			}
		}else{
			$this->session->set_flashdata('msg_succ', 'Select any Check Box...');
			redirect($this->listPage_redirect);
		}
	}
	
}