<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admins_model extends CI_Model {
    private $table = 'tbl_admin_data';

    public function get_all_admins() {
        // Exclude the user with username 'admin'
        return $this->db
            ->where('username !=', 'admin')
            ->order_by('id', 'desc')
            ->get($this->table)
            ->result_array();
    }

    public function get_admin($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function insert_admin($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update_admin($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete_admin($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}
