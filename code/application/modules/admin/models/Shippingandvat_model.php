<?php 
class Shippingandvat_model extends CI_Model {
	
	public $table_name = 'tbl_shippingandvat';

	// Autoloading a system library usin constructor method
	public function __construct() {
        parent::__construct();
    }
	
 	/** In Function Get single records for edit view purpose from select table **/
    public function get_single_record($id='') {
        $this->db->select("*");
		$this->db->from($this->table_name);
		if($id != ''){
			$this->db->where("id",$id);
			$query = $this->db->get();
			$result = $query->row_array();
		}
		return $result;
    }
 
  	/** In Function Update records for select table **/
	public function update_record($id)
	{
		$set_data = array(
						'shipping' => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('shipping')),
						'vat' => mysqli_real_escape_string($this->get_mysqli(),$this->input->post('vat')),
					);
		$this->db->where('id',$id);
		$result = $this->db->update($this->table_name, $set_data); 
		return $result;
	}

	public function get_mysqli()
	{
		$db = (array)get_instance()->db;
		return mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
	}
 
}
?>