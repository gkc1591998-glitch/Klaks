<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard_model extends CI_Model {

		public function __construct() 
		{
	    parent::__construct();
			error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
			error_reporting(0);
			ini_set('display_errors','off');
	  }
 
		public function get_discount_products($id)
		{
			$this->db->select("*");
			$this->db->from("tbl_products");
			$this->db->order_by('id','desc');
			// $this->db->where('discount', $id);
			$this->db->where('status', 1);
			$query = $this->db->get();
			$result = $query->result_array();
			$newarr=array();
		    if(!empty($result)){
			
			foreach($result as $key => $value){
				$newarr[$key]=array(
				'id'=>$value['id'],
				'image1'=>$value['image1'],
				'title'=>$value['title'],
				'cat_id'=>$value['cat_id'],
				'subcat_id'=>$value['subcat_id'],
				// 'childcat_id'=>$value['childcat_id'],
				// 'brand_id'=>$value['brand_id'],
				'price'=>$value['price'],
				// 'dprice'=>$value['dprice'],

				);
				$this->db->select("*");
				$this->db->from("tbl_product_details");
				$this->db->where('lid',$value['id']);
				$query1 = $this->db->get();
				$result1 = $query1->result_array();
				if(!empty($result1)){
					
					foreach($result1 as $keys => $values){
						
				$newarr[$key]['data'][]=$values;
						
					}
					
				}
			}
		}
		// echo'<pre>';print_r($newarr);exit;
		return $newarr;
		}



		public function get_category_products($id)
		{
			$this->db->select("*");
			$this->db->from("tbl_products");
			$this->db->order_by('id','desc');
			$this->db->where('cat_id',$id);
			$this->db->where('status', 1);
			
			$query = $this->db->get();
			$result = $query->result_array();
			$newarr=array();
		    if(!empty($result)){
			foreach($result as $key => $value){
				$newarr[$key]=array(

				'id'          => $value['id'],
				'image1'      => $value['image1'],
				'title'       => $value['title'],
				'cat_id'      => $value['cat_id'],
				'subcat_id'   => $value['subcat_id'],
				'childcat_id' => $value['childcat_id'],
				'price'       => $value['price'],
				'dprice'      => $value['dprice']
				);
				/*$this->db->select("*");
				$this->db->from("tbl_product_details");
				$this->db->where('lid',$value['id']);
				$query1 = $this->db->get();
				$result1 = $query1->result_array();
				if(!empty($result1)){
					foreach($result1 as $keys => $values){
				$newarr[$key]['data'][]=$values;
						
					}
				}*/
			}
		}
		return $newarr;
		}


		/*public function get_subcategory_products($cat_id,$id){
            $this->db->select("*");
			$this->db->from("tbl_products");
			$this->db->order_by('id','desc');
			$this->db->where('cat_id',$cat_id);
			$this->db->where('subcat_id',$id);
			$this->db->where('status', 1);
			$this->db->where('hstatus', 1);
			//$this->db->limit($perpage, $limit);
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			$result = $query->result_array();
			if(count($result) > 0){
				return $result;
			}
		} */


		 public function get_subcategory_products($cat_id,$id)
		{
			$this->db->select("*");
			$this->db->from("tbl_products");
			$this->db->order_by('id','desc');
			$this->db->where('cat_id',$cat_id);
			$this->db->where('subcat_id',$id);
			$this->db->where('status', 1);
			
			$query = $this->db->get();
			$result = $query->result_array();
			$newarr=array();
		    if(!empty($result)){
			
			foreach($result as $key => $value){
				$newarr[$key]=array(
				'id'=>$value['id'],
				'image1'=>$value['image1'],
				'title'=>$value['title'],
				'cat_id'=>$value['cat_id'],
				'subcat_id'=>$value['subcat_id'],
				'childcat_id'=>$value['childcat_id'],
				'brand_id'=>$value['brand_id'],
				'price'=>$value['price'],
				'dprice'=>$value['dprice'],

				);
				$this->db->select("*");
				$this->db->from("tbl_product_details");
				$this->db->where('lid',$value['id']);
				$query1 = $this->db->get();
				$result1 = $query1->result_array();
				if(!empty($result1)){
					
					foreach($result1 as $keys => $values){
						
				$newarr[$key]['data'][]=$values;
						
					}
					
				}
			}
		}
		//echo'<pre>';print_r($newarr);exit;
		return $newarr;
		}

		

		public function get_childcategory_products($cat_id,$subcat_id){
		
			$this->db->select("*");
			$this->db->from("tbl_products");
			$this->db->order_by('id','desc');
			$this->db->where('status', 1);
			
			$this->db->where('cat_id',$cat_id);
			$this->db->where('subcat_id',$subcat_id);
			$query = $this->db->get();
			$result = $query->result_array();
			$newarr=array();
		    if(!empty($result)){
			
			foreach($result as $key => $value){
				$newarr[$key]=array(
				'id'=>$value['id'],
				'image1'=>$value['image1'],
				'title'=>$value['title'],
				'cat_id'=>$value['cat_id'],
				'subcat_id'=>$value['subcat_id'],
				'childcat_id'=>$value['childcat_id'],
				'brand_id'=>$value['brand_id'],
				'price'=>$value['price'],
				'dprice'=>$value['dprice'],

				);
				$this->db->select("*");
				$this->db->from("tbl_product_details");
				$this->db->where('lid',$value['id']);
				$query1 = $this->db->get();
				$result1 = $query1->result_array();
				if(!empty($result1)){
					
					foreach($result1 as $keys => $values){
						
				$newarr[$key]['data'][]=$values;
						
					}
					
				}
			}
		}
		//echo'<pre>';print_r($newarr);exit;
		return $newarr;
		}


      public function get_product($id)
		 {
      $this->db->select("*");
			$this->db->from("tbl_products");
			$this->db->order_by('id','desc');
			$this->db->where('id',$id);
			$this->db->where('status', 1);
			
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			$result = $query->row_array();
			if(count($result) > 0){
				return $result;
			}
		}

		public function get_product_details($id){
            $this->db->select("*");
			$this->db->from("tbl_product_details");
			$this->db->order_by('id','desc');
			$this->db->where('lid',$id);
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			$result = $query->result_array();
			if(count($result) > 0){
				return $result;
			}
		}

		public function get_category_products_count($id){
            $this->db->select("*");
			$this->db->from("tbl_products");
			$this->db->order_by('id','desc');
			$this->db->where('cat_id',$id);
			$this->db->where('status', 1);
			
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			$result = $query->num_rows();
			if(count($result) > 0){
				return $result;
			}
		}

		public function get_profile_orders(){
			$this->db->select("*");
			$this->db->from("tbl_order_products");
			$this->db->order_by('id','desc');
			$this->db->where('user_id',$this->session->userdata('user_id'));
			// $this->db->where('status', 1);
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			$result = $query->result_array();
			$newarr=array();
		  if(!empty($result)){
				foreach($result as $key => $value){
					$newarr[$key]=array(
						'order_id'    => $value['order_table_id'],
						'image'       => $value['image'],
						'name'        => $value['name'],
						'price'       => $value['price'],
						'qty'         => $value['qty'],
						'sub_total'   => $value['subtotal']
					);
					$this->db->select("*");
					$this->db->from("tbl_orders");
					$this->db->where('tbl_orders.id',$value['order_table_id']);
					$query1 = $this->db->get();
					$result1 = $query1->result_array();
					if(!empty($result1)){
						foreach($result1 as $keys => $values){
							$newarr[$key]['delivery_address']= array(
								'first_name'    => $values['dfname'],
								'last_name'     => $values['dlname'],
								'email'        => $values['demail'],
								'mobile'       => $values['dmobile'],
								'location'     => $values['dlocation'],
								'city'   => $values['dcity'],
								'state'   => $values['dstate'],
								'country'   => $values['dcountry'],
								'zipcode'   => $values['dzipcode'],
								'order_created_on'   => $values['create_date_time']
							);
						}
					}
				}
			}
			return $newarr;
		}

		public function get_all_menu($id){
		$this->db->select("*");
		$this->db->from('tbl_category');
		//$this->db->where('id',$id);
		$query = $this->db->get();  
		$category_main = $query->result_array();
		foreach($category_main as $mkey => $mvalue){
			
			$result[$mkey] =  array(
									'categoryid'   => $mvalue['id'],
									'categoryname' => $mvalue['name']
								);

			$this->db->select("*");
			$this->db->from('tbl_subcategory');
			$this->db->where('cat_id',$mvalue['id']);
			$query = $this->db->get();  			
			$category_sub = $query->result_array();			
			foreach($category_sub as $skey => $svalue){
				
				$result[$mkey]['smenu'][$skey] =  array(
				                            'sub_cat_id'   => $svalue['id'],
											'sub_cat_name' => $svalue['name']
										);
			/*$this->db->select("*");
			$this->db->from('tbl_category_child');
			$this->db->where('sub_category_id',$svalue['id']);
			$query = $this->db->get();  			
			$category_child = $query->result_array();
			foreach($category_child as $ckey => $cvalue){
				$result[$mkey]['smenu'][$skey]['cmenu'][$ckey] =  array(
				                            'childcat_id'     => $cvalue['id'],
											'child_cat_name' => $cvalue['child_category_name']
										);
			}*/
			}				
		}
		return $result;
}

       public function get_recent_ads($id,$cat_id) 
	   {
			$this->db->select("*");
			$this->db->from("tbl_products");
			$this->db->order_by('id','RANDOM');
			$this->db->where('id !=',$id);
			$this->db->where('cat_id',$cat_id);
			$this->db->where('status',1);
			
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			$result = $query->result_array();
			if(count($result) > 0){
				return $result;
			}
		}		
}