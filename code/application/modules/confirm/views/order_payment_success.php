<div class="edu-breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-inner">
            <div class="page-title">
                <h1 class="title">Payment Successful</h1>
            </div>
            <ul class="edu-breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
                <li class="separator"><i class="icon-angle-right"></i></li>
                <li class="breadcrumb-item active" aria-current="page">Payment Success</li>
            </ul>
        </div>
    </div>
</div>

<section class="account-page-area section-gap-equal">
    <div class="container position-relative">
        <div class="row g-12 justify-content-center">
            <div class="col-lg-8">
                <div class="login-form-box text-center">
                    <div class="success-icon">
                        <i class="fa fa-check-circle" style="font-size: 80px; color: #28a745; margin-bottom: 20px;"></i>
                    </div>
                    
                    <h2 style="color: #28a745; margin-bottom: 20px;">Payment Successful!</h2>
                    <p style="font-size: 18px; margin-bottom: 30px;">Thank you for your payment. Your order has been confirmed and will be processed shortly.</p>
                    
                    <div class="payment-details" style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: left;">
                        <h4>Payment Details</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Order ID:</strong> <?php echo $order_details['order_id']; ?></p>
                                <p><strong>Customer Name:</strong> <?php echo $order_details['fname'] . ' ' . $order_details['lname']; ?></p>
                                <p><strong>Amount Paid:</strong> ₹<?php echo number_format($payment['amount'], 2); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Payment ID:</strong> <?php echo $payment['razorpay_payment_id']; ?></p>
                                <p><strong>Razorpay Order ID:</strong> <?php echo $payment['razorpay_order_id']; ?></p>
                                <p><strong>Payment Date:</strong> <?php echo date('d-m-Y H:i:s', strtotime($payment['paid_at'])); ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="next-steps" style="background: #e3f2fd; padding: 20px; border-radius: 8px; margin: 20px 0;">
                        <h4 style="color: #1976d2;">What's Next?</h4>
                        <ul style="text-align: left; margin: 10px 0;">
                            <li>You will receive an order confirmation email shortly</li>
                            <li>Your order will be processed and shipped within 3-5 business days</li>
                            <li>You can track your order status in your account dashboard</li>
                            <li>Keep this payment receipt for your records</li>
                        </ul>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="<?php echo site_url(); ?>" class="edu-btn btn-medium">Continue Shopping</a>
                        <a href="<?php echo site_url('checkout/orderdetails/' . $order_details['order_table_id']); ?>" class="edu-btn btn-medium" style="margin-left: 10px;">View Order Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@media print {
    .action-buttons, .edu-breadcrumb-area {
        display: none;
    }
}
</style>
