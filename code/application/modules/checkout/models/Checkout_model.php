<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Checkout_model extends CI_Model {
	public function __construct() 
	{
        parent::__construct();
    }
		public function get_user_data()
		{
			$this->db->select("*");
			$this->db->from("tbl_register");
			$this->db->where('id',$this->session->userdata('user_id'));
			$query = $this->db->get();
			$result = $query->row_array();
			return $result;
		}
		public function get_user_agent_data()
		{
			$this->db->select("*");
			$this->db->from("tbl_agent_register");
			$this->db->where('id',$this->session->userdata('user_id'));
			$query = $this->db->get();
			$result = $query->row_array();
			return $result;
		}
		public function insert_cod_order($order_id,$vat1,$shipping1,$carttotal,$gtot)
		{
			$set_data = array(
            'user_id'   => $this->session->userdata('user_id'),
            'order_id'  => mysqli_real_escape_string($this->get_mysqli(), (string)$order_id),
            'vat'       => mysqli_real_escape_string($this->get_mysqli(), (string)$vat1),
            'shipping'  => mysqli_real_escape_string($this->get_mysqli(), (string)$shipping1),
            'cart_total'=> mysqli_real_escape_string($this->get_mysqli(), (string)$carttotal),
            'total'     => mysqli_real_escape_string($this->get_mysqli(), (string)$gtot),
            'dfname'    => mysqli_real_escape_string($this->get_mysqli(), (string)$this->input->post('dfname')),
            'dlname'    => mysqli_real_escape_string($this->get_mysqli(), (string)$this->input->post('dlname')),
            'dmobile'   => mysqli_real_escape_string($this->get_mysqli(), (string)$this->input->post('dmobile')),
            'demail'    => mysqli_real_escape_string($this->get_mysqli(), (string)$this->input->post('demail')),
            'dcountry'  => mysqli_real_escape_string($this->get_mysqli(), (string)$this->input->post('dcountry')),
            'dstate'    => mysqli_real_escape_string($this->get_mysqli(), (string)$this->input->post('dstate')),
            'dcity'     => mysqli_real_escape_string($this->get_mysqli(), (string)$this->input->post('dcity')),
            'dlocation' => mysqli_real_escape_string($this->get_mysqli(), (string)$this->input->post('dlocation')),
            'dzipcode'  => mysqli_real_escape_string($this->get_mysqli(), (string)$this->input->post('dzipcode')),
            'sfname'    => mysqli_real_escape_string($this->get_mysqli(), (string)$this->input->post('sfname')),
            'slname'    => mysqli_real_escape_string($this->get_mysqli(), (string)$this->input->post('slname')),
            'smobile'   => mysqli_real_escape_string($this->get_mysqli(), (string)$this->input->post('smobile')),
            'semail'    => mysqli_real_escape_string($this->get_mysqli(), (string)$this->input->post('semail')),
            'scountry'  => mysqli_real_escape_string($this->get_mysqli(), (string)$this->input->post('scountry')),
            'sstate'    => mysqli_real_escape_string($this->get_mysqli(), (string)$this->input->post('sstate')),
            'scity'     => mysqli_real_escape_string($this->get_mysqli(), (string)$this->input->post('scity')),
            'slocation' => mysqli_real_escape_string($this->get_mysqli(), (string)$this->input->post('slocation')),
            'szipcode'  => mysqli_real_escape_string($this->get_mysqli(), (string)$this->input->post('szipcode')),
            'create_date_time' => date('Y-m-d H:i:s'),
            'status' => 1,
            'pay_status' => 0
        );
	  // echo "<pre>";print_r($set_data);exit;
		$result = $this->db->insert("tbl_orders", $set_data); 
		// echo "<pre>";print_r($result);exit;
		$last_id = $this->db->insert_id();
		if($result)
		{
			$this->insert_order_products($last_id);
		}	
		return $last_id;
}

		
		public function insert_order_products($last_id)
	  {
				foreach ($this->cart->contents() as $items)
				{
					if ($this->cart->has_options($items['rowid']) == TRUE){
						foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value){
							if($option_name=='image')
							{
								$imagename = $option_value;
							} 
						}
					}
					if ($this->cart->has_options($items['rowid']) == TRUE){
					foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value){
						if($option_name=='size')
						{
							$size = $option_value;
						} 
					}
					}
					//  if ($this->cart->has_options($items['rowid']) == TRUE){
					//  foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value){
					//   if($option_name=='colour')
					//   {
					// 	   $colour = $option_value;
					//   } 
					//  }
					//  }
					//  if ($this->cart->has_options($items['rowid']) == TRUE){
					//  foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value){
					//   if($option_name=='skucode')
					//   {
					// 	   $skucode = $option_value;
					//   } 
					//  }
					//  }
					$set_data= array(
							'order_table_id'=> $last_id,
							'user_id'       => $this->session->userdata('user_id'),
							'item_id'       => $items['id'],
							'image'         => $imagename,
							'name'          => $items['name'],
							'price'         => $items['price'],
							'qty'           => $items['qty'],
							'size'          => $size,
							// 'colour'        => $colour,
							// 'skucode'       => $skucode,
							'subtotal'      => $items['subtotal']
					);
					// echo "<pre>";print_r($set_data);exit;
					$result =  $this->db->insert("tbl_order_products", $set_data); 
				}
			return $result;
	  }
	 public function get_data($id) 
   {
		$this->db->select("*");
		$this->db->from("tbl_orders");
		$this->db->where('id', $id);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	public function get_data_products($id) 
   {
		$this->db->select("*");
		$this->db->from("tbl_order_products");
		$this->db->where('order_table_id', $id);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	  public function getshippingvat() 
	   {
			$this->db->select("*");
			$this->db->from("tbl_shippingandvat");
			$query = $this->db->get();
			$result = $query->row_array();
			return $result;
		}

	 public function get_mysqli()
	{
       $db = (array)get_instance()->db;
       return mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
    }
}
