<?php
class Payment extends Common_Data_Controller {
    
    private $razorpay_key_id;
    private $razorpay_key_secret;
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Payment_model', 'payment_model');
        $this->load->model('Common_model','common_model');
        $this->load->model('checkout/Checkout_model', 'checkout_model');
        $this->load->library('session');
        $this->load->config('razorpay');
        
        $this->razorpay_key_id = $this->config->item('razorpay_key_id');
        $this->razorpay_key_secret = $this->config->item('razorpay_key_secret');
        error_reporting(E_ALL);
		ini_set('display_errors','on');
    }
    
    public function test() {
        echo "Klaks Payment Gateway is working!";
        echo "<br>Razorpay Key ID: " . $this->razorpay_key_id;
        echo "<br>Base URL: " . base_url();
        echo "<br>Site URL: " . site_url();
    }

    private function create_razorpay_order($order_data) {
        $url = 'https://api.razorpay.com/v1/orders';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($order_data));
        curl_setopt($ch, CURLOPT_USERPWD, $this->razorpay_key_id . ':' . $this->razorpay_key_secret);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($response, true);
    }
    
    public function initiate_order($order_table_id) {
        // Debug: Log entry to this method
        log_message('debug', 'initiate_order called with order_table_id: ' . $order_table_id);
        
        // Get order details from session
        $order_details = $this->session->userdata('order_for_payment');
        
        log_message('debug', 'Order details from session: ' . print_r($order_details, true));
        
        if (!$order_details) {
            log_message('error', 'No order details found in session');
            $this->session->set_flashdata('msg_fail_order', 'Session expired. Please try again.');
            redirect('checkout');
            return;
        }
        
        // Amount in paise (Razorpay requires amount in smallest currency unit)
        $amount_in_paise = $order_details['amount'] * 100;

        // Create Razorpay order
        $order_data = array(
            'receipt' => 'klaks_order_' . $order_details['order_id'] . '_' . time(),
            'amount' => $amount_in_paise,
            'currency' => 'INR',
            'notes' => array(
                'order_id' => $order_details['order_id'],
                'order_table_id' => $order_table_id,
                'customer_name' => $order_details['fname'] . ' ' . $order_details['lname'],
                'customer_email' => $order_details['email'],
                'customer_mobile' => $order_details['mobile']
            )
        );
        
        $razorpay_order = $this->create_razorpay_order($order_data);
        
        if ($razorpay_order && isset($razorpay_order['id'])) {
            // Save payment record in database  
            $payment_data = array(
                'order_table_id' => $order_table_id,
                'razorpay_order_id' => $razorpay_order['id'],
                'amount' => $order_details['amount'],
                'currency' => 'INR',
                'status' => 'created',
                'created_at' => date('Y-m-d H:i:s')
            );
            
            $this->payment_model->save_order_payment($payment_data);
            $data = $this->commonData;
            
            // Prepare data for payment page
            $data['razorpay_order_id'] = $razorpay_order['id'];
            $data['amount'] = $amount_in_paise;
            $data['currency'] = 'INR';
            $data['order_details'] = $order_details;
            $data['razorpay_key_id'] = $this->razorpay_key_id;
            
            // Load payment page
            $this->load->view('../../views/header', $data);
            $this->load->view('order_payment', $data);
            $this->load->view('../../views/footer', $data);
        } else {
            log_message('error', 'Failed to create Razorpay order: ' . print_r($razorpay_order, true));
            $this->session->set_flashdata('msg_fail_order', 'Unable to create payment order. Please try again.');
            redirect('checkout');
        }
    }
    
    public function verify_order() {
        $razorpay_payment_id = $this->input->post('razorpay_payment_id');
        $razorpay_order_id = $this->input->post('razorpay_order_id');
        $razorpay_signature = $this->input->post('razorpay_signature');
        
        // Validate input data
        if (!$razorpay_payment_id || !$razorpay_order_id || !$razorpay_signature) {
            log_message('error', 'Missing payment verification data');
            $this->session->set_flashdata('msg_fail_order', 'Payment verification failed. Missing data.');
            redirect('checkout');
            return;
        }
        
        // Verify payment signature
        $generated_signature = hash_hmac('sha256', $razorpay_order_id . "|" . $razorpay_payment_id, $this->razorpay_key_secret);
        
        if ($generated_signature == $razorpay_signature) {
            // Payment signature is valid
            $payment = $this->payment_model->get_payment_by_order_id($razorpay_order_id);
            
            if ($payment) {
                $update_data = array(
                    'razorpay_payment_id' => $razorpay_payment_id,
                    'razorpay_signature' => $razorpay_signature,
                    'status' => 'success',
                    'paid_at' => date('Y-m-d H:i:s')
                );
                
                $this->payment_model->update_payment_status($payment['id'], $update_data);
                
                // Clear session data
                $this->session->unset_userdata('order_for_payment');
                
                // Clear shopping cart
                $this->cart->destroy();
                
                // Success message and redirect
                $this->session->set_flashdata('msg_succ', 'Payment successful! Your order has been confirmed.');
                redirect('confirm/payment/order_success/' . $payment['order_table_id']);
            } else {
                log_message('error', 'Payment record not found for order_id: ' . $razorpay_order_id);
                $this->session->set_flashdata('msg_fail_order', 'Payment record not found. Please contact support.');
                redirect('checkout');
            }
        } else {
            // Payment verification failed
            log_message('error', 'Payment signature verification failed for order_id: ' . $razorpay_order_id);
            
            $payment = $this->payment_model->get_payment_by_order_id($razorpay_order_id);
            if ($payment) {
                $update_data = array(
                    'status' => 'failed',
                    'failure_reason' => 'Signature verification failed'
                );
                $this->payment_model->update_payment_status($payment['id'], $update_data);
            }
            
            $this->session->set_flashdata('msg_fail_order', 'Payment verification failed. Please try again.');
            redirect('checkout');
        }
    }
    
    public function order_success($order_table_id) {
        // Get payment details
        $payment = $this->payment_model->get_payment_by_order_table_id($order_table_id);
        
        if (!$payment) {
            show_404();
            return;
        }
        
        $data = $this->commonData;
        $data['payment'] = $payment;
        $data['order_table_id'] = $order_table_id;
        
        // Load success page
        $this->load->view('../../views/header', $data);
        $this->load->view('order_payment_success', $data);
        $this->load->view('../../views/footer', $data);
    }

    // Generic failed method for payment failures
    public function failed() {
        $data = $this->commonData;
        $this->load->view('../../views/header', $data);
        $this->load->view('payment_failed', $data);
        $this->load->view('../../views/footer', $data);
    }
}
?>