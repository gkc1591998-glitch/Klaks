<?php
class Payment_model extends CI_Model {
    private $payment_table = 'tbl_payments';
    
    public function __construct() {
        parent::__construct();
    }
    
    // Generic payment save method - works for both student and order payments
    public function save_payment($data) {
        return $this->db->insert($this->payment_table, $data);
    }
    
    // Save specifically for order payments
    public function save_order_payment($data) {
        return $this->db->insert($this->payment_table, $data);
    }
    
    // Get payment by Razorpay order ID (works for both types)
    public function get_payment_by_order_id($razorpay_order_id) {
        return $this->db->where('razorpay_order_id', $razorpay_order_id)->get($this->payment_table)->row_array();
    }
    
    // Get payment by order table ID (for ecommerce orders)
    public function get_payment_by_order_table_id($order_table_id) {
        $this->db->where('order_table_id', $order_table_id);
        $this->db->where('status', 'success');
        return $this->db->get($this->payment_table)->row_array();
    }
    
    // Update payment status
    public function update_payment_status($payment_id, $data) {
        $this->db->where('id', $payment_id);
        return $this->db->update($this->payment_table, $data);
    }
    
    // Get all payments for admin view - shows both student and order payments
    public function get_all_payments() {
        $this->db->select('p.*, s.first_name as student_first_name, s.last_name as student_last_name, s.email as student_email, s.phone as student_phone');
        $this->db->from($this->payment_table . ' p');
        $this->db->join('tbl_student_form s', 'p.student_id = s.id', 'left');
        $this->db->order_by('p.created_at', 'DESC');
        return $this->db->get()->result_array();
    }
    
    // Get all order payments specifically (for Klaks ecommerce)
    public function get_all_order_payments() {
        $this->db->where('order_table_id IS NOT NULL');
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get($this->payment_table)->result_array();
    }
    
    // Get payment by student ID (keep for backward compatibility with any existing student payment system)
    public function get_payment_by_student_id($student_id) {
        $this->db->where('student_id', $student_id);
        $this->db->where('status', 'success');
        return $this->db->get($this->payment_table)->row_array();
    }
}
?>
