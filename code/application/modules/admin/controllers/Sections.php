<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sections extends MX_Controller {
    public $headerPage = 'admin_header';
    private $view_path = 'sections';
    private $redirect_base = 'admin/sections';
    public function __construct() {
        parent::__construct();
        $this->load->model('Section_model');
        $this->load->helper(['url', 'form']);
    }

    public function index() {
        $data['sections'] = $this->Section_model->get_all();
        $this->load->view($this->headerPage);
        $this->load->view($this->view_path, $data);
    }

    public function create() {
        if ($this->input->post()) {
            $data = [
                'name' => $this->input->post('name'),
                'created_date_time' => date('Y-m-d H:i:s'),
                'updated_date_time' => date('Y-m-d H:i:s'),
                'status' => 1
            ];
            $this->Section_model->insert($data);
            redirect($this->redirect_base);
        } else {
            $this->load->view($this->headerPage);
            $this->load->view($this->view_path);
        }
    }

    public function edit($id) {
        $data['section'] = $this->Section_model->get_by_id($id);
        $data['sections'] = $this->Section_model->get_all();
        if ($this->input->post()) {
            $update = [
                'name' => $this->input->post('name'),
                'updated_date_time' => date('Y-m-d H:i:s'),
                'status' => $this->input->post('status')
            ];
            $this->Section_model->update($id, $update);
            redirect($this->redirect_base);
        } else {
            $this->load->view($this->headerPage);
            $this->load->view($this->view_path, $data);
        }
    }

    public function delete($id) {
        $this->Section_model->delete($id);
        redirect($this->redirect_base);
    }

    public function delete_selected() {
        $ids = $this->input->post('selected_ids');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $this->Section_model->delete($id);
            }
            $this->session->set_flashdata('msg_succ', 'Selected sections deleted successfully.');
        } else {
            $this->session->set_flashdata('msg_succ', 'No sections selected.');
        }
        redirect($this->redirect_base);
    }
}
