<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Section_model extends CI_Model {
    private $table = 'tbl_sections';
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
    public function generate_unique_slug($name, $id = null)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $base_slug = $slug;
        $i = 1;
        while (true) {
            $this->db->where('slug', $slug);
            if ($id) {
                $this->db->where('id !=', $id);
            }
            $query = $this->db->get($this->table);
            if ($query->num_rows() == 0) {
                break;
            }
            $slug = $base_slug . '-' . $i;
            $i++;
        }
        return $slug;
    }
    public function insert($data) {
        $data['slug'] = $this->generate_unique_slug($data['name']);
        return $this->db->insert($this->table, $data);
    }
    public function update($id, $data) {
        $data['slug'] = $this->generate_unique_slug($data['name'], $id);
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}
