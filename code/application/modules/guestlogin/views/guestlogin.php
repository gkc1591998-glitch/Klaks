<div class="page-heading">
  <div class="page-title">
    <h2>Guest Login</h2>
  </div>
</div>

<div class="main-container col1-layout wow bounceInUp animated animated animated" style="visibility: visible;">     
              
         <div class="main">
            <div class="account-login container">
                    <?php if($this->session->flashdata('msg_succ') != ''){ ?>
                      <div class="alert alert-block alert-success">
                        <button type="button" class="close" data-dismiss="alert">
                          <i class="ace-icon fa fa-times"></i>
                        </button>
                        <p>
                        <?php echo $this->session->flashdata('msg_succ')?$this->session->flashdata('msg_succ'):'';?>
                        </p>
                      </div>
                    <?php } ?>
                    

				  <?php if($this->session->flashdata('msg_fail_order') != ''){ ?>
					<div class="alert alert-block alert-danger">
					  <button type="button" class="close" data-dismiss="alert">
						<i class="ace-icon fa fa-times"></i>
					  </button>
					  <p>
						<?php echo $this->session->flashdata('msg_fail_order')?$this->session->flashdata('msg_fail_order'):'';?>
					  </p>
					</div>
				  <?php } ?>
	
	
	
	
	
    
        <fieldset class="col2-set">
            <div class="col-1 new-users"> 
                <strong>New Customers</strong>    
                <div class="content">
                    <p>By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.</p>
                    <div class="buttons-set">
                    <a href="<?php echo site_url();?>register"><button type="button" title="Create an Account" class="button create-account"><span><span> Create an Account</span></span></button></a> 
                    </div>
                </div>
            </div>
            <div class="col-2 registered-users">
             <strong>Guest Login</strong>
              <form role="form" method="post">
                <div class="content">
                    <?php /*<p>If you have an account with us, please log in.</p>*/?>
                    <ul class="form-list">
                        <li>
                            <label for="email">Name<em class="required">*</em></label>
                            <div class="input-box">
                                <input type="text" value="<?php echo $this->input->post('fname');?>" id="mobile" name="fname" class="input-text " title="Enter Your Name" type="text" required>
                            </div>
                        </li>

                        <li>
                            <label for="email">Mobile Number<em class="required">*</em></label>
                            <div class="input-box">
                                <input type="text" value="<?php echo $this->input->post('mobile');?>" id="mobile" name="mobile" class="input-text" title="Enter Mobile Number" type="text" required>
                            </div>
                        </li>
                    </ul>
                    <div class="buttons-set">
					        	<button type="submit" name="submit" value="submit" class="button login" title="Sunbmit"><span>Submit</span></button>
                    </div>
                </div>
                 </form>
            </div> 
        </fieldset> 
</div>
         </div>
          </div>



<div class="our-features-box wow bounceInUp animated animated category">
    <div class="container">
      <ul>
        <li>
          <div class="feature-box free-shipping">
            <div class="icon-truck"></div>
            <div class="content" style="font-size: 14px;">100 % Quality ,Service & Convenience.</div>
          </div>
        </li>
        <li>
          <div class="feature-box need-help">
            <div class="icon-support"></div>
            <div class="content">Need Help Call us :  +91 9872469999</div>
          </div>
        </li>
        <li>
          <div class="feature-box money-back">
            <div class="icon-money"></div>
            <div class="content">Large Variety of Categories</div>
          </div>
        </li>
        <li class="last">
          <div class="feature-box return-policy">
            <div class="icon-return"></div>
            <div class="content">Best Prices & Offers</div>
          </div>
        </li>
      </ul>
    </div>
  </div>
