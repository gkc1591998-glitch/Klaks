<?php
// Merchant key here as provided by Payu
$MERCHANT_KEY = "6buBguKJ";

// Merchant Salt as provided by Payu
$SALT = "YcnZSHhlt7";

// End point - change to https://secure.payu.in for LIVE mode
$PAYU_BASE_URL = "https://secure.payu.in";

$action = '';

$posted = array();
if(!empty($_POST)) {
    //print_r($_POST);
  foreach($_POST as $key => $value) {    
    $posted[$key] = $value; 
  
  }
}

$formError = 0;

if(empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
          || empty($posted['surl'])
          || empty($posted['furl'])
      || empty($posted['service_provider'])
  ) {
    $formError = 1;
  } else {
    //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
  $hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';  
  foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;


    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}
?>
<html>
  <head>
  <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>
  </head>
  <body onload="submitPayuForm()">
   <div class="container">
   <div class="row">
    <h2>PayU Form</h2>
    <br/>
    <?php if($formError) { ?>
      <span style="color:red">Please fill all mandatory fields.</span>
      <br/>
      <br/>
    <?php } ?>
    <form action="<?php echo $action; ?>" method="post" name="payuForm">
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
      <input type="hidden" name="order_id" value="<?php echo $record["order_id"];?>" />
      <input type="hidden" name="amount" value="<?php echo $coverted_currency;?>"/>
      <input type="hidden" name="firstname" id="firstname" value="<?php echo $record["dfname"];?>" />
      <input type="hidden" name="email" id="email" value="<?php echo $record["demail"];?>" />
      <input type="hidden" name="phone" value="<?php echo $record['dmobile'];?>" />
      <input type="hidden" name="productinfo" value="<?php echo $record['id'];?>"/>
      <input type="hidden" name="surl" value="<?php echo site_url();?>confirm/pay_success_payu" size="64" />
      <input type="hidden" name="furl" value="<?php echo site_url();?>confirm/cancelorder/<?php echo $record['id'];?>" size="64" />
      <input type="hidden" name="service_provider" value="payu_paisa" size="64" />
      <div class="row">

               <div class="pull-left"><a href="<?php echo site_url();?>confirm/cancelorder/<?php echo $record['id'];?>" class="btn btn-primary"  >Cancel Order</a> </div> 
               <?php if(!$hash) { ?>
                  <div class="pull-right" ><input type="submit" name="submit" value="submit" class="btn btn-danger" ></div>
                <?php } ?>
            </div>

    </form>
    </div>
    </div>
  </body>
</html>
