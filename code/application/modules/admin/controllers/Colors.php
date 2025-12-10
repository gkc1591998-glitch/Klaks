<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Colors extends MX_Controller {
    public $headerPage = 'admin_header';
    private $view_path = 'colors';
    private $redirect_base = 'admin/colors';
    public function __construct() {
        parent::__construct();
        $this->load->model('Color_model');
        $this->load->helper(['url', 'form']);
        error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(1);
		ini_set('display_errors','on');  
    }

    public function index() {
        $data['colors'] = $this->Color_model->get_all();
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
            $this->Color_model->insert($data);
            redirect($this->redirect_base);
        } else {
            $this->load->view($this->headerPage);
            $this->load->view($this->view_path);
        }
    }

    public function edit($id) {
        $data['color'] = $this->Color_model->get_by_id($id);
        $data['colors'] = $this->Color_model->get_all();
        if ($this->input->post()) {
            $update = [
                'name' => $this->input->post('name'),
                'updated_date_time' => date('Y-m-d H:i:s'),
                'status' => $this->input->post('status')
            ];
            $this->load->view($this->headerPage);
            $this->Color_model->update($id, $update);
            redirect($this->redirect_base);
        } else {
            $this->load->view($this->headerPage);
            $this->load->view($this->view_path, $data);
        }
    }

    public function delete($id) {
        $this->Color_model->delete($id);
        redirect($this->redirect_base);
    }

    public function delete_selected() {
        $ids = $this->input->post('selected_ids');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $this->Color_model->delete($id);
            }
            $this->session->set_flashdata('msg_succ', 'Selected colors deleted successfully.');
        } else {
            $this->session->set_flashdata('msg_succ', 'No colors selected.');
        }
        redirect($this->redirect_base);
    }
}
