<div class="page-heading">

  <div class="page-title">

    <h2>Register</h2>

  </div>

</div>



<section id="content">

    

	<div class="container">

      <div class="row">

	  

	    

        <div class="col-md-12">

          

		  <header class="content-title">

          <br/><br/>

            <h1 class="title">Register Account</h1>

          </header>

		  

          <div class="xs-margin"></div>

		  

		<div class="col-md-12 col-sm-12 col-xs-12">

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

	    </div>

		

          <form role="form" name="register" id="register" enctype="multipart/form-data" method="post" >

		    

            <div class="row">

              <div class="col-md-6 col-sm-6 col-xs-12">

                <fieldset>

                  <h2 class="sub-title">YOUR PERSONAL DETAILS</h2>				  

                  <div class="input-group"><span class="input-group-addon"><span class="input-icon input-icon-user"></span><span class="input-text">First Name*</span></span>

                    <input class="form-control input-lg" name="fname"  id="fname" placeholder="Your First Name" type="text" value="<?php echo $this->input->post('fname');?>">

					<?php echo form_error('fname');?>

                  </div>

                 

                  <div class="input-group"><span class="input-group-addon"><span class="input-icon input-icon-email"></span><span class="input-text">Email*</span></span>

                    <input class="form-control input-lg" type="text" name="email"  id="email" value="<?php echo $this->input->post('email');?>" placeholder="Your Email Address">

					<?php echo form_error('email');?>

                  </div>

				  

				  <div class="input-group"><span class="input-group-addon"><span class="input-icon input-icon-email"></span><span class="input-text">Country*</span></span>

                    <input  class="form-control input-lg" placeholder="Your Country" type="text" name="country" id="country" value="<?php echo $this->input->post('country')?>">

					<?php echo form_error('country');?>

                  </div>

				  

				  <div class="input-group"><span class="input-group-addon"><span class="input-icon input-icon-email"></span><span class="input-text">City*</span></span>

                    <input  class="form-control input-lg" placeholder="Your City" type="text" name="city" value="<?php echo $this->input->post('city');?>">

					<?php echo form_error('city');?>

                  </div>

				  

				  

				  <div class="input-group"><span class="input-group-addon"><span class="input-icon input-icon-address"></span><span class="input-text">Zip code</span></span>

                    <input class="form-control input-lg" placeholder="Zip code" type="text" name="zipcode" id="zipcode" value="<?php $this->input->post('zipcode');?>">

					<?php echo form_error('zipcode');?>

                  </div>

				  

                </fieldset>

              </div>			  

			  

              <div class="col-md-6 col-sm-6 col-xs-12">

              <br/>

                <fieldset style="margin: 63px 0 0px 0">                  

                  <div class="input-group"><span class="input-group-addon"><span class="input-icon input-icon-user"></span><span class="input-text">Last Name*</span></span>

                    <input class="form-control input-lg" name="lname"  id="lname" placeholder="Your Last Name" type="text" value="<?php echo $this->input->post('lname');?>">

					<?php echo form_error('lname');?>

                  </div>

				  

				  <div class="input-group"><span class="input-group-addon"><span class="input-icon input-icon-phone"></span><span class="input-text">Mobile Number*</span></span>

					  <input class="form-control input-lg" placeholder="Your Mobile Number" type="text" name="mobile" id="mobile" value="<?php echo $this->input->post('mobile');?>">

					  <?php echo form_error('mobile');?>

                  </div>

				  

				  <div class="input-group"><span class="input-group-addon"><span class="input-icon input-icon-email"></span><span class="input-text">State*</span></span>

                    <input  class="form-control input-lg" placeholder="Your State" type="text" name="state" id="state" value="<?php echo $this->input->post('state');?>">

					<?php echo form_error('state');?>

                  </div>

				  

				  <div class="input-group"><span class="input-group-addon"><span class="input-icon input-icon-company"></span><span class="input-text">Location</span></span>

                    <input  class="form-control input-lg" placeholder="Location" type="text" name="location" id="location" value="<?php echo $this->input->post('location');?>">

					<?php echo form_error('location');?>

                  </div>

				  

				  <div class="input-group"><span class="input-group-addon"><span class="input-icon input-icon-password"></span><span class="input-text">Password*</span></span>

                    <input  class="form-control input-lg" placeholder="Your Password" type="password" name="password" id="password" value="<?php echo $this->input->post('password');?>">

					<?php echo form_error('password');?>

                  </div>

               <br>

                  <input value="CREATE MY ACCCOUNT" class="btn btn-custom-2 md-margin" type="submit" name="submit">

                </fieldset>

              </div>

            </div>

          </form>

        </div>

      </div>

    </div>

  </section>



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