<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupons extends MX_Controller {
    public $headerPage = 'admin_header';
    private $view_path = 'coupons';
    private $redirect_base = 'admin/coupons';
    public function __construct() {
        parent::__construct();
        $this->load->model('Coupon_model');
        $this->load->helper(['url', 'form']);
    }

    public function index() {
        $data['coupons'] = $this->Coupon_model->get_all();
        $this->load->view($this->headerPage);
        $this->load->view($this->view_path, $data);
    }

    public function create() {
        if ($this->input->post()) {
            $data = [
                'name' => $this->input->post('name'),
                // 'discount' => $this->input->post('discount'),
                'created_date_time' => date('Y-m-d H:i:s'),
                'updated_date_time' => date('Y-m-d H:i:s'),
                'status' => 1
            ];
            $this->Coupon_model->insert($data);
            redirect($this->redirect_base);
        } else {
            $this->load->view($this->headerPage);
            $this->load->view($this->view_path);
        }
    }

    public function edit($id) {
        $data['coupon'] = $this->Coupon_model->get_by_id($id);
        $data['coupons'] = $this->Coupon_model->get_all();
        if ($this->input->post()) {
            $update = [
                'code' => $this->input->post('code'),
                'discount' => $this->input->post('discount'),
                'updated_date_time' => date('Y-m-d H:i:s'),
                'status' => $this->input->post('status')
            ];
            $this->Coupon_model->update($id, $update);
            redirect($this->redirect_base);
        } else {
            $this->load->view($this->headerPage);
            $this->load->view($this->view_path, $data);
        }
    }

    public function delete($id) {
        $this->Coupon_model->delete($id);
        redirect($this->redirect_base);
    }

    public function delete_selected() {
        $ids = $this->input->post('selected_ids');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $this->Coupon_model->delete($id);
            }
            $this->session->set_flashdata('msg_succ', 'Selected coupons deleted successfully.');
        } else {
            $this->session->set_flashdata('msg_succ', 'No coupons selected.');
        }
        redirect($this->redirect_base);
    }
}
