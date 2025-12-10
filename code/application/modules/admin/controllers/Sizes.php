<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sizes extends MX_Controller {
    private $view_path = 'sizes';
    private $redirect_base = 'admin/sizes';
    public $headerPage = 'admin_header';
    public function __construct() {
        parent::__construct();
        $this->load->model('Size_model');
        $this->load->helper(['url', 'form']);
    }

    public function index() {
        $data['sizes'] = $this->Size_model->get_all();
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
            $this->load->view($this->headerPage);
            $this->Size_model->insert($data);
            redirect($this->redirect_base);
        } else {
            $this->load->view($this->headerPage);
            $this->load->view($this->view_path);
        }
    }

    public function edit($id) {
        $data['size'] = $this->Size_model->get_by_id($id);
        $data['sizes'] = $this->Size_model->get_all();
        if ($this->input->post()) {
            $update = [
                'name' => $this->input->post('name'),
                'updated_date_time' => date('Y-m-d H:i:s'),
                'status' => $this->input->post('status')
            ];
            $this->load->view($this->headerPage);
            $this->Size_model->update($id, $update);
            redirect($this->redirect_base);
        } else {
            $this->load->view($this->headerPage);
            $this->load->view($this->view_path, $data);
        }
    }

    public function delete($id) {
        $this->Size_model->delete($id);
        $this->load->view($this->headerPage);
        redirect($this->redirect_base);
    }

    public function delete_selected() {
        $ids = $this->input->post('selected_ids');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $this->Size_model->delete($id);
            }
            $this->session->set_flashdata('msg_succ', 'Selected sizes deleted successfully.');
        } else {
            $this->session->set_flashdata('msg_succ', 'No sizes selected.');
        }
        $this->load->view($this->headerPage);
        redirect($this->redirect_base);
    }
}
