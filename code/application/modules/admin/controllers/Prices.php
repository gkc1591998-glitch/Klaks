<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prices extends MX_Controller {
    private $view_path = 'prices';
    private $redirect_base = 'admin/prices';
    public $headerPage = 'admin_header';
    public function __construct() {
        parent::__construct();
        $this->load->model('Price_model');
        $this->load->helper(['url', 'form']);
    }

    public function index() {
        $data['prices'] = $this->Price_model->get_all();
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
            $this->Price_model->insert($data);
            redirect($this->redirect_base);
        } else {
            $this->load->view($this->headerPage);
            $this->load->view($this->view_path);
        }
    }

    public function edit($id) {
        $data['price'] = $this->Price_model->get_by_id($id);
        $data['prices'] = $this->Price_model->get_all();
        if ($this->input->post()) {
            $update = [
                'name' => $this->input->post('name'),
                'updated_date_time' => date('Y-m-d H:i:s'),
                'status' => $this->input->post('status')
            ];
            $this->load->view($this->headerPage);
            $this->Price_model->update($id, $update);
            redirect($this->redirect_base);
        } else {
            $this->load->view($this->headerPage);
            $this->load->view($this->view_path, $data);
        }
    }

    public function delete($id) {
        $this->Price_model->delete($id);
        redirect($this->redirect_base);
    }

    public function delete_selected() {
        $ids = $this->input->post('selected_ids');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $this->Price_model->delete($id);
            }
            $this->session->set_flashdata('msg_succ', 'Selected prices deleted successfully.');
        } else {
            $this->session->set_flashdata('msg_succ', 'No prices selected.');
        }
        redirect($this->redirect_base);
    }
}
