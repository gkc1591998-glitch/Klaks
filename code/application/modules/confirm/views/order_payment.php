<!-- <div class="edu-breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-inner">
            <div class="page-title">
                <h1 class="title">Complete Payment</h1>
            </div>
            <ul class="edu-breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
                <li class="separator"><i class="icon-angle-right"></i></li>
                <li class="breadcrumb-item"><a href="<?php echo site_url('checkout'); ?>">Checkout</a></li>
                <li class="separator"><i class="icon-angle-right"></i></li>
                <li class="breadcrumb-item active" aria-current="page">Payment</li>
            </ul>
        </div>
    </div>
</div> -->
<div class="main-container no-sidebar">
  <section class="account-page-area section-gap-equal">
      <div class="container position-relative">
          <div class="row g-12 justify-content-center">
              <div class="col-lg-6">
                  <div class="login-form-box">
                      <h3 class="title">Complete Your Payment</h3>
                      
                      <div class="payment-details">
                          <div class="order-info">
                              <h4>Order Details</h4>
                              <p><strong>Order ID:</strong> <?php echo $order_details['order_id']; ?></p>
                              <p><strong>Customer Name:</strong> <?php echo $order_details['fname'] . ' ' . $order_details['lname']; ?></p>
                              <p><strong>Email:</strong> <?php echo $order_details['email']; ?></p>
                              <p><strong>Mobile:</strong> <?php echo $order_details['mobile']; ?></p>
                          </div>
                          
                          <div class="payment-info">
                              <h4>Payment Details</h4>
                              <p><strong>Amount:</strong> ₹<?php echo number_format($order_details['amount'], 2); ?></p>
                              <p><strong>Description:</strong> Order Payment</p>
                          </div>
                          
                          <button id="rzp-button1" class="edu-btn btn-medium">Pay Now</button>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "<?php echo $razorpay_key_id; ?>",
    "amount": "<?php echo $amount; ?>",
    "currency": "<?php echo $currency; ?>",
    "name": "Your Store Name",
    "description": "Order Payment",
    "order_id": "<?php echo $razorpay_order_id; ?>",
    "handler": function (response){
        // Submit the form with payment details
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?php echo site_url('confirm/payment/verify_order'); ?>';
        
        var payment_id = document.createElement('input');
        payment_id.type = 'hidden';
        payment_id.name = 'razorpay_payment_id';
        payment_id.value = response.razorpay_payment_id;
        form.appendChild(payment_id);
        
        var order_id = document.createElement('input');
        order_id.type = 'hidden';
        order_id.name = 'razorpay_order_id';
        order_id.value = response.razorpay_order_id;
        form.appendChild(order_id);
        
        var signature = document.createElement('input');
        signature.type = 'hidden';
        signature.name = 'razorpay_signature';
        signature.value = response.razorpay_signature;
        form.appendChild(signature);
        
        document.body.appendChild(form);
        form.submit();
    },
    "prefill": {
        "name": "<?php echo $order_details['fname'] . ' ' . $order_details['lname']; ?>",
        "email": "<?php echo $order_details['email']; ?>",
        "contact": "<?php echo $order_details['mobile']; ?>"
    },
    "theme": {
        "color": "#1976d2"
    },
    "modal": {
        "ondismiss": function(){
            window.location.href = '<?php echo site_url('checkout'); ?>';
        }
    }
};

var rzp1 = new Razorpay(options);

document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>

<style>
.payment-details {
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-top: 20px;
}

.order-info, .payment-info {
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
    text-align: center;
}

.order-info h4, .payment-info h4 {
    color: #000;
    margin-bottom: 10px;
    text-align: center;
}

#rzp-button1 {
    width: 100%;
    margin-top: 20px;
}
</style>
