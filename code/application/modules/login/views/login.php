<main class="site-main  main-container no-sidebar">
    <!-- <div class="container">
	
		<div class="akasha-heading style-01" style="padding-bottom: 0px;">
            <div class="heading-inner">
                <h3 class="title"style="margin-bottom:0px">
                    Login With OTP</h3>
            </div>
        </div>
	
        <div class="row">
            <div class="main-content col-md-12">
                <div class="page-main-content">
                    <div class="akasha">
                        <form class="track_order" style="padding-bottom: 10px;">
                           
                            <p class="form-row form-row-first"><label for="orderid">Phone Number</label>
                                <input class="input-text" type="text" name="orderid" id="orderid"
                                       value="" placeholder="Enter Your Phone Number">
                            </p>
                            
                            <div class="clear"></div>
                            <p class="form-row">
                                <button type="submit" class="button" name="track" value="Track">Request OTP</button>
                            </p>
							
							 <p style="padding-bottom: 0px;margin-bottom: 0px;font-size: 10px;text-align:center">A 6 digit OTP will be sent to your phone number</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
	
	<!-- <div class="container">
        <div class="row">
            <div class="main-content col-md-12">
                <div class="page-main-content">
                    <div class="akasha">
                        <form class="track_order" style="padding-bottom: 0px;">
                            
                            <p class="form-row">
                                <button style="background-color: #890000" type="submit" class="button" name="track" value="Track">or</button>
                            </p>
							
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
	
	<div class="container">	
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12" style="max-width: 770px; margin: auto; text-align: center">
                <?php if($this->session->flashdata('msg_succ') != ''){ ?>
                    <div class="alert alert-block alert-success col-sm-12">
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
                  <?php if($this->session->flashdata('msg_fails') != ''){ ?>
                    <div class="alert alert-block alert-danger">
                        <button type="button" class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                        </button>
                        <p>
                        <?php echo $this->session->flashdata('msg_fails')?$this->session->flashdata('msg_fails'):'';?>
                        </p>
                    </div>
                <?php } ?>
            </div>
            <div class="main-content col-md-12">
                <div class="page-main-content">
                    <div class="akasha">
                        <form class="track_order" role="form" name="login" id="login" enctype="multipart/form-data" method="post">
                            
                        <p style="max-width: 540px; margin: auto; text-align: center" class="form-row form-row-first"><label for="email">Email</label>
                                <input class="input-text" type="text" name="email" id="email"
                                value="<?php echo $this->input->post('email');?>" placeholder="Enter Your Email">
                            </p>
                            <div style="max-width: 540px; margin: auto; text-align: center"><?php echo form_error('email');?></div>
                            
                            <div class="clear"></div>

                            <p style="max-width: 540px; margin: auto; text-align: center" class="form-row form-row-first"><label for="password">Password</label>
                                <input class="input-text" type="password" name="password" id="password"
                                value="<?php echo $this->input->post('password');?>" placeholder="Enter Your Password">
                            </p>
                            <div style="max-width: 540px; margin: auto; text-align: center"><?php echo form_error('password');?></div>
                            
                            <div class="clear"></div>
                            <p class="form-row">
                                <button type="submit" class="button" name="submit" value="submit">Login</button>
                            </p>
							
							<p style="padding-bottom: 15px;font-size: 10px;text-align:center">
                                Don't have an account? &nbsp;&nbsp;<a href="<?php echo base_url(); ?>register"><span style="fornt-weight: bold; font-size: 14px">Register</span></a><br/>
                                Forget password. reset here&nbsp;&nbsp;<a href="<?php echo base_url(); ?>forgotpassword"><span style="fornt-weight: bold; font-size: 14px">Forget password</span></a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	
	
</main>