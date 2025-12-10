<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admins extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('admin/Admins_model', 'admins_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    public function index($edit_id = null) {
        $data['admins'] = $this->admins_model->get_all_admins();
        if ($edit_id) {
            $admin = $this->admins_model->get_admin($edit_id);
            if ($admin) {
                $data['edit_admin'] = $admin;
            }
        }
        $this->load->view('admin/admins_view', $data);
    }

    public function create() {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[tbl_admin_data.username]');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['admins'] = $this->admins_model->get_all_admins();
            $this->load->view('admin/admins_view', $data);
        } else {
            $admin_data = array(
                'name' => $this->input->post('name'),
                'status' => $this->input->post('status'),
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role' => 'p_admin',
                'created_date_time' => date('Y-m-d H:i:s')
            );
            $this->admins_model->insert_admin($admin_data);
            redirect('admin/admins');
        }
    }

    public function edit($id) {
        $admin = $this->admins_model->get_admin($id);
        if (!$admin) {
            redirect('admin/admins');
        }
        $data['edit_admin'] = $admin;
        $data['admins'] = $this->admins_model->get_all_admins();
        $this->load->view('admin/admins_view', $data);
    }

    public function edit_submit($id) {
        $admin = $this->admins_model->get_admin($id);
        if (!$admin) {
            redirect('admin/admins');
        }
        $this->form_validation->set_rules('name', 'Name', 'required');
        // $this->form_validation->set_rules('status', 'Status', 'required');
        // $this->form_validation->set_rules('username', 'Username', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $data['edit_admin'] = $admin;
            $data['admins'] = $this->admins_model->get_all_admins();
            $this->load->view('admin/admins_view', $data);
        } else {
            $update_data = array(
                'name' => $this->input->post('name'),
                'username' => $this->input->post('username'),
                'status' => $this->input->post('status'),
                'role' => 'p_admin',
                'updated_date_time' => date('Y-m-d H:i:s'),
            );
            $password = $this->input->post('password');
            if (!empty($password)) {
                $update_data['password'] = password_hash($password, PASSWORD_DEFAULT);
            }
            $result = $this->admins_model->update_admin($id, $update_data);
            redirect('admin/admins');
        }
    }

    public function delete($id) {
        $this->admins_model->delete_admin($id);
        redirect('admin/admins');
    }
}
