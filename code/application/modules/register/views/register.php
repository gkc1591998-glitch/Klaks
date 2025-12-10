<main class="site-main  main-container no-sidebar">
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
            </div>
            <div class="main-content col-md-12">
                <div class="page-main-content">
                    <div class="akasha">
                        <form class="track_order" role="form" name="register" id="register" enctype="multipart/form-data" method="post" >

                            <p style="max-width: 540px; margin: auto; text-align: center" class="form-row form-row-first"><label for="mobile">Mobile number</label>
                                <input class="input-text" type="text" name="mobile" id="mobile"
                                value="<?php echo $this->input->post('mobile');?>" placeholder="Enter Your Mobile">
                            </p>
                            <div style="max-width: 540px; margin: auto; text-align: center"><?php echo form_error('mobile');?></div>
                            
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
                                <button type="submit" class="button" name="submit" value="submit">Register</button>
                            </p>
							
							<p style="padding-bottom: 15px;font-size: 10px;text-align:center">
                                Already have an account? &nbsp;&nbsp;<a href="<?php echo base_url(); ?>login"><span style="fornt-weight: bold; font-size: 14px">Login</span></a><br/>
                                Forget password. reset here&nbsp;&nbsp;<a href="<?php echo base_url(); ?>forgotpassword"><span style="fornt-weight: bold; font-size: 14px">Forget password</span></a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>