<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
class Checkout extends Common_Data_Controller
{
  public $headerPage     = '../../views/header';
  public $footerPage     = '../../views/footer';
  public $listPage       = 'checkout';
  public $orderDetailsPage = 'order_details';
  public $orderDetails   = 'order_details';
  public $searchPage     = 'search';
  public $redirPagelogin = 'login';
  public $redirPage      = 'home';
  public $redirPayment2  = 'confirm/pay';

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Common_model', 'common_model');
    $this->load->model('Checkout_model', 'checkout_model');
    $this->load->model('Confirm/Confirm_model', 'confirm_model');
    $this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    error_reporting(-1);
    ini_set('display_errors', 'on');

    /*$shipvat = $this->checkout_model->getshippingvat();
			$newdata = array(
						'ship'  => $shipvat['shipping'],
						'vat'   => $shipvat['vat'],
					);
			$this->session->set_userdata($newdata);*/

    //    if($this->session->userdata('user_id')=='')
    // 	{
    // 		$this->session->set_flashdata( 'msg_fail_order', 'Please Login To Continue...' );
    // 		redirect($this->redirPagelogin);
    // 	}

    // if(($this->cart->total_items()==0)||($this->cart->total_items()==''))
    // {
    // 	$this->session->set_flashdata( 'msg_fail_order', 'Your Cart Was Empty...' );
    // 	redirect($this->redirPage);
    // }
  }


  public function index()
  {
    if ($this->session->userdata('user_id') == '') {
      $this->session->set_flashdata('msg_fail_order', 'Please Login To Continue...');
      redirect($this->redirPagelogin);
    }

    if (($this->cart->total_items() == 0) || ($this->cart->total_items() == '')) {
      $this->session->set_flashdata('msg_fail_order', 'Your Cart Was Empty...');
      redirect($this->redirPage);
    }

    if ($this->session->userdata('user_type') == "customer") {
      $data['record'] = $this->checkout_model->get_user_data();
    } else  if ($this->session->userdata('user_type') == "agent") {
      $data['record'] = $this->checkout_model->get_user_agent_data();
    } else {
      $data['record'] = '';
    }
    $data = $this->commonData; // get common data
    $this->load->view($this->headerPage, $data);
    $this->load->view($this->listPage, $data);
    $this->load->view($this->footerPage, $data);
  }

  public function order()
  {
    $order_details = null;
    $order_error = '';
    $result = null;
    if ($this->input->post('submit') != '') {
      if ($this->form_validation->run('billing_form') == TRUE) {
        $unique_id = rand(0, 1000000);
        $order_id  = "KA" . $unique_id;
        $shipping1  = '';
        $vat1 = '';
        $carttotal = $this->cart->total();
        $gtot = $carttotal;
        $result = $this->checkout_model->insert_cod_order($order_id, $vat1, $shipping1, $carttotal, $gtot);
        if (isset($result) && !empty($result)) {
          $payment_method = $this->input->post('payment_method');
          
          // Handle different payment methods
          if ($payment_method == 'razorpay') {
            // Store order details in session for payment processing
            $order_details = array(
              'order_table_id' => $result,
              'order_id' => $order_id,
              'amount' => $gtot,
              'fname' => $this->input->post('dfname'),
              'lname' => $this->input->post('dlname'),
              'email' => $this->input->post('demail'),
              'mobile' => $this->input->post('dmobile')
            );
            $this->session->set_userdata('order_for_payment', $order_details);
            
            // Simple redirect with explicit index.php
            redirect('index.php/confirm/payment/initiate_order/' . $result);
          } else {
            // COD Order - existing flow
            $totamount = $gtot;
            $this->session->unset_userdata('vat');
            $this->session->unset_userdata('coupan');
            $this->session->unset_userdata('ship');
            $this->cart->destroy();
            $order_details = array(
              'fname'    => $this->input->post('dfname'),
              'lname'    => $this->input->post('dlname'),
              'mobile'   => $this->input->post('dmobile'),
              'email'    => $this->input->post('demail'),
              'country'  => $this->input->post('dcountry'),
              'state'    => $this->input->post('dstate'),
              'city'     => $this->input->post('dcity'),
              'location' => $this->input->post('dlocation'),
              'zipcode'  => $this->input->post('dzipcode'),
              'amount'   => $totamount,
              'order_id' => $order_id,
              'order_table_id' => $result
            );
            $this->session->set_flashdata('msg_order', 'Dear, ' . $this->input->post('dfname') . ' Your Order was Placed Successfully. Your Order Id Is ' . $order_id . ' . Thank You. Visit Again !...');
            // Redirect to the checkout controller's order details page so the order is displayed
            redirect('checkout/orderdetails/' . $result);
          }
        } else {
          $order_error = 'Order was Failed, Try Again...';
        }
      } else {
        $order_error = validation_errors();
      }
    }
    $data = $this->commonData; // get common data
    $data['record']  = $this->checkout_model->get_user_data();
    if (!empty($order_error)) {
      // Validation failed: show errors back on the checkout page (not order details)
      $data['order_error'] = $order_error;
      // Preserve any submitted form values for redisplay if needed
      $data['form_values'] = $this->input->post();
      $this->load->view($this->headerPage, $data);
      $this->load->view($this->listPage, $data);
      $this->load->view($this->footerPage, $data);
    } else {
      $this->load->view($this->headerPage, $data);
      $this->load->view($this->listPage, $data);
      $this->load->view($this->footerPage, $data);
    }
  }

  public function orderdetails($order_id)
  {
    // echo "order_details_page-order_id".$order_id;exit;

    // if($this->session->userdata('user_type')=="customer"){
    // $data['record'] = $this->checkout_model->get_user_data();
    // } else  if($this->session->userdata('user_type')=="agent"){
    // $data['record']=$this->checkout_model->get_user_agent_data();	
    // } else {
    // $data['record'] ='';
    // }
    $data = $this->commonData; // get common data
    $data['record']  = $this->checkout_model->get_user_data();
    $data['order']   = $this->confirm_model->get_data($order_id);
    $data['order_details'] = $this->confirm_model->get_data_products($order_id);
    // echo "<pre>";print_r($data['order_details']);
    // echo "<pre>";print_r($data['order']);exit;
    // echo "<pre>";print_r($data['record']);
    // exit;
    $this->load->view($this->headerPage, $data);
    $this->load->view($this->orderDetails, $data);
    $this->load->view($this->footerPage, $data);
  }

  public function payment()
  {
    if ($this->input->post('submit') != '') {

      /*if ($this->form_validation->run('billing') == TRUE){
					echo "<pre>";print_r($_POST);exit;*/

      /* $x = ceil($this->session->userdata('ship'));
                                  $a = ceil(1500/$x);

                                 if ($this->cart->total_items() == 1 )
                                 {
                                   echo $shipping = $a;

                                 } else if($this->cart->total_items() ==2)
                                 {
                                     $b = $a + ceil(300/$x);echo $shipping = $b;

                                 } else  if($this->cart->total_items() == 3 )
                                 {
                                     $c = $a + ceil(800/$x);echo $shipping = $c;
                                 }else  if($this->cart->total_items() == 4 )
                                 {
                                    $d = $a + ceil(1300/$x);echo $shipping = $d;
                                 }else  if($this->cart->total_items() == 5 )
                                 {
                                      $e = $a + ceil(1800/$x);echo $shipping = $e;
                                 }else  if($this->cart->total_items() == 6 )
                                 {
                                     $f = $a + ceil(2300/$x);echo $shipping = $f;
                                 }else  if($this->cart->total_items() == 7 )
                                 {
                                      $g = $a + ceil(2600/$x);echo $shipping = $g;
                                 }else  if($this->cart->total_items() == 8 )
                                 {
                                      $h = $a + ceil(3000/$x);echo $shipping = $h;
                                 }else  if($this->cart->total_items() == 9 )
                                 {
                                     $i = $a + ceil(3300/$x);echo $shipping = $i;
                                 }else  if($this->cart->total_items() == 10 )
                                 {
                                     $j = $a + ceil(3500/$x);echo $shipping = $j;
                                 }else  if($this->cart->total_items() >= 10  && $this->cart->total_items() <= 13)
                                 {
                                     $k = $a + ceil(3500/$x);echo $shipping = $k;
                                 }else  if($this->cart->total_items() >= 13  && $this->cart->total_items() <= 20)
                                 {
                                     $l = $a + ceil(3300/$x);echo $shipping = $l;
                                 }else  if($this->cart->total_items() > 20 && $this->cart->total_items() <= 25)
                                 {
                                     $m = $a + ceil(3200/$x);echo $shipping = $m;
                                 }else  if($this->cart->total_items() > 25 )
                                 {
                                     $n = $a + ceil(3200/$x);echo $shipping = $n;
                                 }*/


      if ($this->cart->total_items() == 1) {
        echo $shipping = ceil(23);
      } else if ($this->cart->total_items() == 2) {
        echo $shipping = ceil(27.70);
      } else  if ($this->cart->total_items() == 3) {
        echo $shipping = ceil(35.40);
      } else  if ($this->cart->total_items() == 4) {
        echo $shipping = ceil(43);
      } else  if ($this->cart->total_items() == 5) {
        echo $shipping = ceil(50.80);
      } else  if ($this->cart->total_items() == 6) {
        echo $shipping = ceil(58.45);
      } else  if ($this->cart->total_items() == 7) {
        echo $shipping = ceil(63);
      } else  if ($this->cart->total_items() == 8) {
        echo $shipping = ceil(69.25);
      } else  if ($this->cart->total_items() == 9) {
        echo $shipping = ceil(73.85);
      } else  if ($this->cart->total_items() >= 10  && $this->cart->total_items() <= 13) {
        echo $shipping = ceil(7.70 * $this->cart->total_items());
      } else  if ($this->cart->total_items() >= 13  && $this->cart->total_items() <= 20) {
        echo $shipping = ceil(7.40 * $this->cart->total_items());
      } else  if ($this->cart->total_items() > 20 && $this->cart->total_items() <= 25) {
        echo $shipping = ceil(7.25 * $this->cart->total_items());
      } else  if ($this->cart->total_items() > 25) {
        echo $shipping = ceil(7.10 * $this->cart->total_items());
      }

      $unique_id = rand(0, 1000000);
      $order_id  = "TP" . $unique_id;
      $vat1       = (($this->session->userdata('vat') / 100) * $this->cart->total());
      $shipping1  = $shipping;
      $carttotal = $this->cart->total();
      $gtot = $carttotal + $shipping1;
      $result = $this->checkout_model->insert_cod_order($order_id, $vat1, $shipping1, $carttotal, $gtot);
      if ($result) {
        if ($this->session->userdata('user_type') == "agent") {
          $this->session->set_flashdata('msg_succ', 'Dear, ' . $this->input->post('dfname') . ' Your Order was Placed Successfully. Your Order Id Is ' . $order_id . ' . Thank You. Visit Again !...');
          redirect(site_url());
        } else {

          $totamount = $gtot;
          $this->session->unset_userdata('vat');
          $this->session->unset_userdata('coupan');
          $this->session->unset_userdata('ship');
          $this->cart->destroy();

          /*$order_details = array ( 
						'fname'    => $this->input->post('dfname'), 
						'lname'    => $this->input->post('dlname'), 
						'mobile'   => $this->input->post('dmobile') , 
						'email'    => $this->input->post('demail'),
						'country'  => $this->input->post('dcountry'),
						'state'    => $this->input->post('dstate'),
						'city'     => $this->input->post('dcity'),
						'location' => $this->input->post('dlocation'),
						'zipcode'  => $this->input->post('dzipcode'), 
						'amount'   => $totamount,
						'order_id' => $order_id,
						'order_table_id' => $result
						);
						$this->session->set_flashdata( 'msg_order', $order_details );*/
          redirect($this->redirPayment2 . "/" . $result);
        }
      } else {
        $this->session->set_flashdata('msg_fail', 'Order was Failed, Try Again...');
        redirect(site_url());
      }
      /*}*/
    }
    $data = $this->commonData; // get common data
    if ($this->session->userdata('user_type') == "customer") {
      $data['record'] = $this->checkout_model->get_user_data();
    } else  if ($this->session->userdata('user_type') == "agent") {
      $data['record'] = $this->checkout_model->get_user_agent_data();
    } else {
      $data['record'] = '';
    }

    $data['record']  = $this->checkout_model->get_user_data();
    $this->load->view($this->headerPage, $data);
    $this->load->view($this->listPage, $data);
    $this->load->view($this->footerPage, $data);
  }
}
