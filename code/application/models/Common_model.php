<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Common_model extends CI_Model {	

		public $table_name          = "tbl_websettings";		

		public $table_products      = "tbl_products";

		public $table_banners      = "tbl_banners";

		public function __construct() 
		{
			parent::__construct();		
			error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);	
			error_reporting(0);		
			ini_set('display_errors','off');

		}	

		public function get_all_websettings() 	{		

			$this->db->select("*");		

			$this->db->from($this->table_name);			

			$query = $this->db->get();		

			$result = $query->row_array();		

			return $result;	

		}	

		public function get_all_banners() 

		{		

			$this->db->select("*");		

			$this->db->from($this->table_banners);		

			$this->db->where('status', 1);		

			$this->db->order_by('id','desc');		

			$query = $this->db->get();		

			$result = $query->result_array();		

			return $result;	

		}



		
	 public function get_search($key) 
	 {
	 	$this->db->select("*");

	 	$this->db->from($this->table_products);

	 	$this->db->order_by('id','desc');

	 	$this->db->or_where('title LIKE', $key.'%');
	 	$this->db->or_where('title LIKE', '%'.$key);
	 	$this->db->or_where('title LIKE', '%'.$key.'%');

	 	$this->db->where('status', 1);
	 	$query = $this->db->get();
        /*echo $this->db->last_query();exit;*/
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

	 				'price'=>$value['price'],					

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

	 	return $newarr;	

	 }		


			public function get_order_status($id) 

			  {		

				$this->db->select('status,dfname,order_id');

				$this->db->from('tbl_orders');		

				$this->db->where('order_id',$id);		

				$query = $this->db->get();		

				$result = $query->row_array();		

				if(count($result) > 0)

				{

					return $result;		

				}	

			}

			

			public function get_all_menu()

			{

			$this->db->select("*");

			$this->db->from('tbl_category');
			$this->db->where('status',1);
	        $this->db->limit(6);
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

	public function get_active_categories()
	{
		$this->db->select("*");
		$this->db->from('tbl_category');
		$this->db->where('status', 1);
		$query = $this->db->get();
		return $query->result_array();
	}


	public function get_active_subcategories()
	{
		$this->db->select("*");
		$this->db->from('tbl_subcategory');
		$this->db->where('status', 1);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_active_childcategories()
	{
		$this->db->select("*");
		$this->db->from('tbl_category_child');
		$this->db->where('status', 1);
		$query = $this->db->get();
		return $query->result_array();
	}
}?>