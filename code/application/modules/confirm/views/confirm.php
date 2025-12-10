
<div class="page-heading">
  <div class="page-title">
    <h2>Payments</h2>
  </div>
</div>

<section id="content">
    
	<div class="container">
      <div class="row">
	  
	    
        <div class="col-md-12">
          
		  <header class="content-title">
          <br/><br/>
            
          </header>
		  
          <div class="xs-margin"></div>
		  
            <div class="row">
              <div class="col-md-6" style="margin-left:300px;">
                <fieldset>
                 	<h1 class="title">Payment Details</h1>
                   <div class="input-group"><span class="input-group-addon"><span class="input-icon input-icon-user"></span><span class="input-text">Order Id*</span></span>
                    <input class="form-control input-lg" type="text" value="<?php echo stripslashes($record['order_id']); ?>" readonly>
                  </div>
				  
				   <div class="input-group"><span class="input-group-addon"><span class="input-icon input-icon-user"></span><span class="input-text">Total Price*</span></span>
                    <input class="form-control input-lg" type="text" value="$<?php echo stripslashes($record['total']); ?>" readonly>
                  </div>
				  
				  <div class="input-group"><span class="input-group-addon"><span class="input-icon input-icon-user"></span><span class="input-text">First Name*</span></span>
                    <input class="form-control input-lg" type="text" value="<?php echo stripslashes($record['dfname']); ?>" readonly>
                 </div>
				  
                 <div class="input-group"><span class="input-group-addon"><span class="input-icon input-icon-user"></span><span class="input-text">Last Name*</span></span>
                    <input class="form-control input-lg" type="text" value="<?php echo stripslashes($record['dlname']); ?>" readonly>
                 </div>
				 
				 <div class="input-group"><span class="input-group-addon"><span class="input-icon input-icon-user"></span><span class="input-text">Address</span></span>
                    <textarea class="form-control input-lg"readonly><?php echo
					stripslashes($record['dlocation']).','.stripslashes($record['dcity']).','.stripslashes($record['dstate']).','.stripslashes($record['dcountry']); ?></textarea>
                 </div>
				 
				 <div class="input-group"><span class="input-group-addon"><span class="input-icon input-icon-user"></span><span class="input-text">Mobile Number*</span></span>
                    <input class="form-control input-lg" type="text" value="<?php echo stripslashes($record['dmobile']); ?>" readonly>
                  </div>
				 <br>
				 
				    <?php  
						$paypal_url='https://www.paypal.com/cgi-bin/webscr'; 
						$paypal_id ='vineethveerapaneni10@yahoo.com';
						
				    ?>
				 
				       <form   method="post" action="<?php echo $paypal_url;?>">
					   <input  type="hidden" name="business"    value="<?php echo $paypal_id; ?>">
						<input type="hidden" name="cmd"         value="_xclick">
						<input type="hidden" name="item_name"   value="">
						<input type="hidden" name="item_number" value="<?php echo stripslashes($record['id']); ?>">
						<input type="hidden" name="credits" value="510">
						<input type="hidden" name="userid" value="<?php echo $this->session->userdata('user_id');?>">
					    <input type="hidden" name="amount" value="<?php echo stripslashes($record['total']);?>">
						<input type="hidden" name="cpp_header_image" value="https://telugupickles.in/images/logo.png">
						<input type="hidden" name="no_shipping" value="1">
						<input type="hidden" name="currency_code" value="USD">
						<input type="hidden" name="handling" value="0">
						<input type="hidden" name="rm" value="2" />
						<input type="hidden" name="cancel_return" value="<?php echo site_url();?>confirm/cancelorder/<?php echo stripslashes($record['id']); ?>">
						<input type="hidden" name="return" value="<?php echo site_url();?>confirm/payment_do">
                        <div class="col-md-2">
                            <button  type="submit" name="submit" value="submit" class="btn btn-custom-2 md-margin" type="submit">Pay Online</button>
				        </div>
						<?php /*<div class="col-md-2" style="margin-left:130px;">
						  <a href="<?php echo site_url();?>confirm/cod/<?php echo $record['id'];?>"><button class="btn btn-custom-2 md-margin" type="button">Cash on Delivery</button></a>
						</div>*/?>
						<div class="col-md-2" style="float:right;">
						  <a href="<?php echo site_url();?>confirm/cancelorder/<?php echo $record['id'];?>"><button class="btn btn-custom-2 md-margin" type="button">Cancel</button></a>
						</div>
						</form>
                </fieldset>
              </div>
            </div>
        </div>
      </div>
    </div>
  </section><br /><br /><br />
