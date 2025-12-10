<div class="edu-breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-inner">
            <div class="page-title">
                <h1 class="title">Payment Failed</h1>
            </div>
            <ul class="edu-breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
                <li class="separator"><i class="icon-angle-right"></i></li>
                <li class="breadcrumb-item active" aria-current="page">Payment Failed</li>
            </ul>
        </div>
    </div>
</div>

<section class="account-page-area section-gap-equal">
    <div class="container position-relative">
        <div class="row g-12 justify-content-center">
            <div class="col-lg-6">
                <div class="login-form-box text-center">
                    <div class="error-icon">
                        <i class="fa fa-times-circle" style="font-size: 80px; color: #dc3545; margin-bottom: 20px;"></i>
                    </div>
                    
                    <h2 style="color: #dc3545; margin-bottom: 20px;">Payment Failed!</h2>
                    <p style="font-size: 18px; margin-bottom: 30px;">Unfortunately, your payment could not be processed. Please try again.</p>
                    
                    <div class="error-reasons" style="background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: left;">
                        <h4 style="color: #856404;">Possible Reasons:</h4>
                        <ul style="margin: 10px 0; color: #856404;">
                            <li>Insufficient funds in your account</li>
                            <li>Network connectivity issues</li>
                            <li>Payment gateway timeout</li>
                            <li>Invalid card details</li>
                            <li>Payment cancelled by user</li>
                        </ul>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="<?php echo site_url('studentform'); ?>" class="edu-btn btn-medium">Try Again</a>
                        <a href="<?php echo site_url('contactus'); ?>" class="edu-btn btn-medium" style="margin-left: 10px; background-color: #6c757d;">Contact Support</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
