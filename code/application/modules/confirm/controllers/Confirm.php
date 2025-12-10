<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Confirm extends Common_Data_Controller {
	
	public $headerPage = '../../views/header';
	public $footerPage = '../../views/footer';
	public $listPage   = 'confirm';
	public $payuPage   = 'payu';
	
	// Autoloading a system library using constructor method
	public function __construct() {
    parent::__construct();
		$this->load->model('Confirm_model','my_model');
		$this->load->model('Common_model','common_model');
 		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off');
  }

	/*public function cod($id)
	{
		$record   =  $this->my_model->get_data($id);
		$products =  $this->my_model->get_data_products($id);
		$coverted_currency = $record['total'];

		$temp = "<div class='col-sm-12 col-md-8 col-lg-12 no-padding-both'>
  <div style='height:7px; background-color:#e8dcdc'>&nbsp;</div>
  <div style='background-color:#adafac; margin:0px; padding:55px 20px 40px 20px; font-family:Helvetica, sans-serif; font-size:13px; color:#535353;'>
  <div style='width:100%; text-align:center; margin:auto;'>
  <div style='float:left; margin:0 0 0 20px;'><img src='".site_url()."images/logo.png'></div>
  </div>
    <div style='clear:both;'></div>
    <div style='border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Arial, Helvetica, sans-serif; font-size:13px;'><span style='font-weight:bold;'></span>
      <div class='row'> <div class='col-md-12' ><span style='text-align:center; font-size:20px; font-weight:bold;margin: 30px 0 0 30px; color:#535353;' >ORDER DETAILS</span></div> </div>
	 <div class='row'> <div class='col-md-3' >Order ID:<b> ".stripslashes($record['order_id'])." </b></div> <div class='col-md-3'  >Date Time: ".date('F j, Y, g:i a')."</div></div>

    
      <table style='width:80%; margin:20px 0 0 0; border: 1px solid black; border-collapse: collapse;'>
  <tr>
    <th style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;' >Quantity</th>
    <th style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;'>Item Name</th> 
 <th style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;'>Image</th> 	
    <th style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;' >Rate</th>
    <th style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;' >Total</th>    
  </tr>";
  
 foreach($products as $keys => $items):
  $prd .="<tr>
    <td style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;' >".$items['qty']."</td>
    <td style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' >".$items['name']."</td>
	 <td style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' ><img src='".site_url()."images/products/".$items['image']."' height='50' width='100'></td>
   <td style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;' >$".$items['price']."</td>    
    <td style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;' >$".$items['subtotal']."</td>    
  </tr>";
 endforeach;
  $last .= "<tr>
    <td  colspan='4' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' >Subtotal</td>
    <td colspan='1' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;' >$".$record['cart_total']."</td>
  </tr>
  
   <tr>
    <td  colspan='4' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' >Shipping</td>
    <td colspan='1' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;' >$".$record['shipping']."</td>
  </tr>

  <tr>
    <td  colspan='4' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' >Vat</td>
    <td colspan='1' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;' >$".$record['vat']."</td>
  </tr>

  <tr>
    <td  colspan='4' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' >Payable Amount</td>
    <td colspan='1' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;' >$".$record['total']."</td>
  </tr>
  <tr>
    <td  colspan='5' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' ><b>Shipping Address</b></td>
  </tr>
   <tr>
    <td  colspan='5' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' >".$record['dfname']."<br>".$record['demail']."<br>".$record['dmobile']."<br>".$record['dlocation']."<br>".$record['dcity']."<br>".$record['dstate']."<br>".$record['dcountry']."<br>".$record['dzipcode']."</td>
  </tr>
  
</table>
<p>Thank You.</p>
<p>For any query or assistance, feel free to <a target='_blank' href='".site_url()."contactus'>Contact Us.</a></p>

      </div>
  </div>
</div>";
						$config = Array(
						    'protocol' => 'smtp.gmail',
						    'mailtype' => 'html',
						    'smtp_host' => 'ssl://smtp.googlemail.com',
                'smtp_port' => 465,
						    'smtp_user' => 'info@klaks.com', 
						    'smtp_pass' => 'royalit@123', 
						    'charset' => 'iso-8859-1',
						    'priority' => '1',
						    'wordwrap' => TRUE
						);
						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");
						$this->email->from('info@klaks.com', 'klaks.com');
						$this->email->to($record['demail']);
						$this->email->bcc('info@klaks.com,vineethveerapaneni@yahoo.com'); 
						$this->email->subject("NEW ORDER");
						$this->email->message($temp.$prd.$last);
						$this->email->send();
			           $this->session->set_flashdata( 'msg_order', 'Thank You, Your Order Placed Successfully, Order id: <strong>'.$record['order_id'].'</strong> ' );
			            redirect(site_url());
	  } */
	
	public function pay($id)
	{
		$data = $this->commonData; // get common data
		$this->load->view($this->headerPage,$data);
    $data['record']   = $this->my_model->get_data($id);
		$data['detailed'] = $this->my_model->get_data_products($id);
		$data['coverted_currency'] = $data['record']['total'];
		$this->load->view($this->listPage,$data);
		$this->load->view($this->footerPage,$data);
	}
	
	public function payment_do()
	{
            /*echo "<pre>";print_r($_GET);exit;*/
            $item_no              = $_GET['item_number'];
			$item_transaction     = $_GET['tx'];
			$item_price           = $_GET['amt'];
			$item_currency        = $_GET['cc'];
			$status               = $_GET['st'];
			$payed_data['record'] = $this->my_model->get_data($item_no);
            $guid = $payed_data['record']['id'];
			/*echo "<pre>";print_r($payed_data['record']);exit;*/
			$currency='USD';
			if($status == "Completed" && $item_no== $guid)
	        {
	        	$this->my_model->pstatus_record($item_no);
				$record   = $this->my_model->get_data($item_no);
				$products =  $this->my_model->get_data_products($item_no);

                 $temp = "<div class='col-sm-12 col-md-8 col-lg-12 no-padding-both'>
  <div style='height:7px; background-color:#e8dcdc'>&nbsp;</div>
  <div style='background-color:#adafac; margin:0px; padding:55px 20px 40px 20px; font-family:Helvetica, sans-serif; font-size:13px; color:#535353;'>
  <div style='width:100%; text-align:center; margin:auto;'>
  <div style='float:left; margin:0 0 0 20px;'><img src='".site_url()."images/logo.png'></div>
  </div>
    <div style='clear:both;'></div>
    <div style='border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Arial, Helvetica, sans-serif; font-size:13px;'><span style='font-weight:bold;'></span>
      <div class='row'> <div class='col-md-12' ><span style='text-align:center; font-size:20px; font-weight:bold;margin: 30px 0 0 30px; color:#535353;' >ORDER DETAILS</span></div> </div>
	 <div class='row'> <div class='col-md-3' >Order ID:<b> ".stripslashes($record['order_id'])." </b></div> <div class='col-md-3'  >Date Time: ".date('F j, Y, g:i a')."</div></div>

    
      <table style='width:80%; margin:20px 0 0 0; border: 1px solid black; border-collapse: collapse;'>
  <tr>
    <th style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;' >Quantity</th>
    <th style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;'>Item Name</th> 
 <th style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;'>Image</th> 	
    <th style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;' >Rate</th>
    <th style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;' >Total</th>    
  </tr>";
  
 foreach($products as $keys => $items):
  $prd .="<tr>
    <td style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;' >".$items['qty']."</td>
    <td style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' >".$items['name']."</td>
	 <td style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' ><img src='".site_url()."images/products/".$items['image']."' height='50' width='100'></td>
   <td style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;' >$".$items['price']."</td>    
    <td style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;' >$".$items['subtotal']."</td>    
  </tr>";
 endforeach;
  $last .= "<tr>
    <td  colspan='4' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' >Subtotal</td>
    <td colspan='1' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;' >$".$record['cart_total']."</td>
  </tr>
  
   <tr>
    <td  colspan='4' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' >Shipping</td>
    <td colspan='1' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;' >$".$record['shipping']."</td>
  </tr>

  <tr>
    <td  colspan='4' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' >Vat</td>
    <td colspan='1' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;' >$".$record['vat']."</td>
  </tr>

  <tr>
    <td  colspan='4' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' >Payable Amount</td>
    <td colspan='1' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;' >$".$record['total']."</td>
  </tr>
  <tr>
    <td  colspan='5' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' ><b>Shipping Address</b></td>
  </tr>
   <tr>
    <td  colspan='5' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' >".$record['dfname']."<br>".$record['demail']."<br>".$record['dmobile']."<br>".$record['dlocation']."<br>".$record['dcity']."<br>".$record['dstate']."<br>".$record['dcountry']."<br>".$record['dzipcode']."</td>
  </tr>
  
</table>
<p>Thank You.</p>
<p>For any query or assistance, feel free to <a target='_blank' href='".site_url()."contactus'>Contact Us.</a></p>

      </div>
  </div>
</div>";
						
						$config = Array(
						    'protocol' => 'smtp.gmail',
						    'mailtype' => 'html',
						    'smtp_host' => 'ssl://smtp.googlemail.com',
                'smtp_port' => 465,
						    'smtp_user' => 'info@klaks.com', 
						    'smtp_pass' => 'royalit@123', 
						    'charset' => 'iso-8859-1',
						    'priority' => '1',
						    'wordwrap' => TRUE
						);
						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");		       
						$this->email->from('info@klaks.com', 'klaks.com');
						$this->email->to($record['demail']);
						$this->email->bcc('info@klaks.in, dontha.nareshgoud@gmail.com'); 
						$this->email->subject("NEW ORDER Payment");
						$this->email->message($temp.$prd.$last);
						$this->email->send();

                       /*$assigned_message = "Hi, ".$record['dfname'].". Your Order For ".$items['name']." Is Conformed . Your Order Id Is ".$record['order_id']." . Rest Assured it Will be Shipped Soon  . Thank You ...!";
						$this->sms($record['dmobile'],$assigned_message);*/
	
						$this->session->set_flashdata( 'msg_order', 'Thank You, Your Payment Completed and Order Placed Successfully, Order id: <strong>'.$record['order_id'].'</strong> ' );
						redirect(site_url());
		}
		else
		{
			$this->my_model->status_record($id);
			$this->session->set_flashdata( 'msg_fail_order', 'Payment Failed' );
			redirect(site_url());
		}
	}
		


		function get_currency($from_Currency, $to_Currency, $amount) 
		{
			$amount = urlencode($amount);
			$from_Currency = urlencode($from_Currency);
			$to_Currency = urlencode($to_Currency);

			$url = "http://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency";

			$ch = curl_init();
			$timeout = 0;
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

			curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$rawdata = curl_exec($ch);
			curl_close($ch);
			$data = explode('bld>', $rawdata);
			$data = explode($to_Currency, $data[1]);
			return round($data[0], 2);
		}
	
    
	public function cancelorder($id)
	{
		$record   =  $this->my_model->get_data($id);
		$products =  $this->my_model->get_data_products($id);
		$coverted_currency = $record['total'];

		$temp = "<div class='col-sm-12 col-md-8 col-lg-12 no-padding-both'>
                 <div style='height:7px; background-color:#e8dcdc'>&nbsp;</div>
                 <div style='background-color:#adafac; margin:0px; padding:55px 20px 40px 20px; font-family:Helvetica, sans-serif; font-size:13px; color:#535353;'>
                 <div style='width:100%; text-align:center; margin:auto;'>
                 <div style='float:left; margin:0 0 0 20px;'><img src='".site_url()."images/logo.png'></div>
                </div>

			    <div style='clear:both;'></div>
			    <div style='border-radius: 5px 5px 5px 5px; padding:20px; margin-top:45px; background-color:#FFFFFF; font-family:Arial, Helvetica, sans-serif; font-size:13px;'><span style='font-weight:bold;'></span>
			    <div class='row'> <div class='col-md-12' ><span style='text-align:center; font-size:20px; font-weight:bold;margin: 30px 0 0 30px; color:#535353;' >ORDER DETAILS</span></div> </div>
				<div class='row'> <div class='col-md-3' >Order ID:<b> ".stripslashes($record['order_id'])." </b></div> <div class='col-md-3'  >Date Time: ".date('F j, Y, g:i a')."</div></div>

    
			      <table style='width:80%; margin:20px 0 0 0; border: 1px solid black; border-collapse: collapse;'>
			  <tr>
			    <th style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;' >Quantity</th>
			    <th style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;'>Item Name</th> 
			 <th style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;'>Image</th> 	
			    <th style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;' >Rate</th>
			    <th style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;' >Total</th>    
			  </tr>";
  
 foreach($products as $keys => $items):
  $prd .="<tr>
    <td style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: center;' >".$items['qty']."</td>
    <td style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' >".$items['name']."</td>
	 <td style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' ><img src='".site_url()."images/products/".$items['image']."' height='50' width='100'></td>
   <td style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;' >$".$items['price']."</td>    
    <td style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;' >$".$items['subtotal']."</td>    
  </tr>";
 endforeach;

  $last .= "<tr>
    <td  colspan='4' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' >Subtotal</td>
    <td colspan='1' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;' >$".$record['cart_total']."</td>
  </tr>
  
   <tr>
    <td  colspan='4' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' >Shipping</td>
    <td colspan='1' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;' >".$record['shipping']."</td>
  </tr>

  <tr>
    <td  colspan='4' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' >Vat</td>
    <td colspan='1' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;' >".$record['vat']."</td>
  </tr>

  <tr>
    <td  colspan='4' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' >Payable Amount</td>
    <td colspan='1' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: right;' >$".$record['total']."</td>
  </tr>
  <tr>
    <td  colspan='5' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' ><b>Shipping Address</b></td>
  </tr>
   <tr>
   <td  colspan='5' style='border: 1px solid black; border-collapse: collapse; padding: 5px;  text-align: left;' >".$record['dfname']."<br>".$record['demail']."<br>".$record['dmobile']."<br>".$record['dlocation']."<br>".$record['dcity']."<br>".$record['dstate']."<br>".$record['dcountry']."<br>".$record['dzipcode']."</td>
  </tr>
  
</table>

<p>Thank You.</p>
<p>Want To Shop Now.Please Follow This Link <a target='_blank' href='".site_url()."home'>klaks.com</a></p>

      </div>
  </div>
</div>";
						$config = Array(
						    'protocol' => 'smtp.gmail',
						    'mailtype' => 'html',
						    'smtp_host' => 'ssl://smtp.googlemail.com',
                'smtp_port' => 465,
						    'smtp_user' => 'info@klaks.com', 
						    'smtp_pass' => 'royalit@123', 
						    'charset' => 'iso-8859-1',
						    'priority' => '1',
						    'wordwrap' => TRUE
						);
						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");		       
						$this->email->from('info@klaks.com', 'klaks.com');
						$this->email->to($record['demail']);
						$this->email->bcc('info@klaks.com, donthanareshgoud@gmail.com'); 
						$this->email->subject("Cancelled Order");
						$this->email->message($temp.$prd.$last);
						$this->email->send();
						$result = $this->my_model->cancel_order($id);
						if($result)
						{				
							$this->session->set_flashdata( 'msg_fail_order','Your Order was Cancelled');
							redirect(site_url());
						}
						else
						{
							$this->session->set_flashdata( 'msg_succ', "Not cancelled" );
							redirect(site_url());
						}	
		
	}

    /*function sms($num,$msg)
	{
		//echo $num;exit;
		$url ="http://sms.com/spanelv2/api.php?username=amerison&password=royal123&to=".urlencode($num)."&from=ameris&message=".urlencode($msg);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 4); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: close')); 
		$start = array_sum(explode(' ', microtime())); 
		$result = curl_exec($ch); 
		//echo $result;exit;
		return $result;
	}*/
}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
