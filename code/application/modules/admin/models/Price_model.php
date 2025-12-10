<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Price_model extends CI_Model {
    private $table = 'tbl_prices';
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function get_all() {
        return $this->db->get($this->table)->result();
    }
    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}
