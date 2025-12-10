<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mail_model extends CI_Model {

	public $mail = "tbl_mail";
	
	public function __construct() {
        parent::__construct();
 		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off'); 
    }
  
	   public function get_all_records() 
	   {
			$this->db->select("*");
			$this->db->order_by('id','desc');
			$this->db->from($this->mail);
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		}
		
		 public function get_all_received() 
	    {
			$this->db->select("*");
			$this->db->order_by('id','desc');
			$this->db->where('hr_id',1);
			$this->db->where('status',2);
			$this->db->from("tbl_sent_mail");
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		 }
		 
		 public function get_inbox_mail($id) 
	    {
			$this->db->select("*");
			$this->db->order_by('id','desc');
			$this->db->where('hr_id',1);
			$this->db->where('status',2);
			$this->db->where('id',$id);
			$this->db->from("tbl_sent_mail");
			$query = $this->db->get();
			$result = $query->row_array();
			return $result;
		 }
		
		public function get_all_sent() 
	    {
			$this->db->select("*");
			$this->db->order_by('id','desc');
			$this->db->where('hr_id',1);
			$this->db->where('status',1);
			$this->db->from("tbl_sent_mail");
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		 }
		 
		 public function get_sent_mail($id) 
	    {
			$this->db->select("*");
			$this->db->order_by('id','desc');
			$this->db->where('hr_id',1);
			$this->db->where('status',1);
			$this->db->where('id',$id);
			$this->db->from("tbl_sent_mail");
			$query = $this->db->get();
			$result = $query->row_array();
			return $result;
		 }
		
		public function add_record($image)
		{
			$set_data = array
			(
			'hr_id' => 1,
			'message' => mysql_real_escape_string(ucfirst($this->input->post('message'))),
			'create_date_time' => date('Y-m-d H:i:s')
			);
			$result = $this->db->insert($this->mail,$set_data);
			return $result;
		}
		
		public function delete_record($id)
		{
		$this->db->where('hr_id',1);	
		$this->db->where('id',$id);
		$result = $this->db->delete("tbl_sent_mail"); 
		return $result;
		
		}
		
		
		  public function add_view_status($id) 
	     {
			$set_data = array
			(
			'vstatus' => 1,
			);
			$this->db->where('id',$id);
			$result = $this->db->update("tbl_sent_mail",$set_data);
			return $result;
		}
		
		 public function get_all_employees() 
	    {
			$this->db->select("id,fname,image,(select emp_idno from tbl_emp_five where tbl_emp_five.emp_id = tbl_emp_one.id)as empidno");
			$this->db->from("tbl_emp_one");
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		}
		
		public function send_email()
		{
		//echo	mysql_real_escape_string(trim($this->input->post('email')));exit;
			
			$setdata = array
			(
				'hr_id' =>  1,
				'empidno' =>  mysql_real_escape_string(trim($this->input->post('email'))),
				'subject' => mysql_real_escape_string(ucfirst($this->input->post('subject'))),
				'message' => mysql_real_escape_string(ucfirst($this->input->post('message'))),
				'status' => 1,
				'create_date_time' =>  date('Y-m-d H:i:s')
			);
			$result = $this->db->insert("tbl_sent_mail", $setdata); 
			if($result)
			{
			    $setdata2 = array
			    (
				'hr_id' =>  1,
				'empidno' =>  mysql_real_escape_string(trim($this->input->post('email'))),
				'subject' => mysql_real_escape_string(ucfirst($this->input->post('subject'))),
				'message' => mysql_real_escape_string(ucfirst($this->input->post('message'))),
				'status' => 2,
				'create_date_time' =>  date('Y-m-d H:i:s')
		    	);
			 
				$result2 = $this->db->insert("tbl_receive_mail", $setdata2); 
				return $result2;	
			}
			else
			{
				return 0; 
			}	
			
		}
		
		public function send_email_multiple()
		{	
			//echo '<pre>'; print_r($_POST); exit;
			$multiarr=array();
			$multiarr = explode(",",$this->input->post('messageall'));
			foreach($multiarr as $val)
			{
				 $setdata2 = array
			    (
				'hr_id' =>  1,
				'empidno' =>  trim($val),
				'subject' => mysql_real_escape_string(ucfirst($this->input->post('subject'))),
				'message' => mysql_real_escape_string(ucfirst($this->input->post('message'))),
				'status' => 1,
				'create_date_time' =>  date('Y-m-d H:i:s')
		    	);
			 
				$result = $this->db->insert("tbl_sent_mail", $setdata2); 
			}
			if($result)
			{
				foreach($multiarr as $val)
				{
					 $setdata3 = array
					(
					'hr_id' =>  1,
					'empidno' =>  trim($val),
					'subject' => mysql_real_escape_string(ucfirst($this->input->post('subject'))),
					'message' => mysql_real_escape_string(ucfirst($this->input->post('message'))),
					'status' => 2,
					'create_date_time' =>  date('Y-m-d H:i:s')
					);
				 
					$result2 = $this->db->insert("tbl_receive_mail", $setdata3); 
				}
			}
				return $result2;	
			
		}
		
		public function send_email_all()
		{
			$multiarr=array();
			$multiarr = explode(",",$this->input->post('all'));
			array_pop($multiarr);
			foreach($multiarr as $val)
			{
				 $setdata2 = array
			    (
				'hr_id' =>  1,
				'empidno' =>  trim($val),
				'subject' => mysql_real_escape_string(ucfirst($this->input->post('subject'))),
				'message' => mysql_real_escape_string(ucfirst($this->input->post('message'))),
				'status' => 1,
				'create_date_time' =>  date('Y-m-d H:i:s')
		    	);
			 
				$result = $this->db->insert("tbl_sent_mail", $setdata2); 
			}
			if($result)
			{
				foreach($multiarr as $val)
				{
					 $setdata3 = array
					(
					'hr_id' =>  1,
					'empidno' => trim($val),
					'subject' => mysql_real_escape_string(ucfirst($this->input->post('subject'))),
					'message' => mysql_real_escape_string(ucfirst($this->input->post('message'))),
					'status' => 2,
					'create_date_time' =>  date('Y-m-d H:i:s')
					);
				 
					$result2 = $this->db->insert("tbl_receive_mail", $setdata3); 
				}
			}
				return $result2;	
		}
	
}
?>