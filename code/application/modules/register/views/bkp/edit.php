  
  <div class="container">
    <div class="row">
      <div class="block block-breadcrumbs">
        <ul>
          <li class="home">
            <a href="#"><i class="fa fa-home"></i></a>
            <span></span>
          </li>
          <li>Edit</li>
        </ul>
      </div>
      <div class="main-page">
        <div class="page-content">
                <div class="row">
                
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
            
            <form role="form" name="edit_register" id="edit_register" enctype="multipart/form-data" method="post" >
              <div class="col-sm-6">
                <div class="box-border">
                   <div class="form-group ">
                  <label for="InputName"> First Name  </label>
                  <input type="text" name="fname"  id="fname" class="form-control" value="<?php echo stripslashes($record['fname']); ?>" >
                            <?php echo form_error('fname'); ?> 
                   </div>

                <div class="form-group ">
                  <label for="InputName"> Last Name  </label>
                  <input type="text" name="lname"  id="lname" class="form-control" value="<?php echo stripslashes($record['lname']); ?>" >
                            <?php echo form_error('lname'); ?> 
                </div>
                  
                  <div class="form-group">
                  <label for="InputEmail">Email </label>
                  <input type="text" name="email"  id="email" class="form-control" value="<?php echo stripslashes($record['email']); ?>" >
                            <?php echo form_error('email'); ?> 
                  </div>

                  <div class="form-group">
                  <label for="InputLastName">Password  </label>
                  <input type="password" name="password" id="password" class="form-control"  value="<?php echo stripslashes($record['password']); ?>" >
                           <?php echo form_error('password'); ?> 
                  </div>
                  
                  <div class="form-group">
                  <label for="InputEmail">Phone Number </label>
                  <input type="text" name="mobile" id="mobile" class="form-control" value="<?php echo stripslashes($record['mobile']); ?>" >
                            <?php echo form_error('mobile'); ?> 
                  </div>
                  
                  <div class="form-group ">
                  <label for="InputAddress">Address  </label>
                  <input type="text" name="address" id="address" class="form-control" value="<?php echo stripslashes($record['address']); ?>" >
                           <?php echo form_error('address'); ?> 
                  </div>

                  <div class="form-group ">
                  <label for="InputAddress">Zip  </label>
                  <input type="text" name="zip" id="zip" class="form-control" value="<?php echo stripslashes($record['zip']); ?>" >
                           <?php echo form_error('zip'); ?> 
                  </div>
                  
                  <p>
                    <button type="submit" name="submit" value="submit" class="button"><i class="fa fa-lock"></i>Update</button>
                  </p>
                </div>
              </div>
            </form>
                </div>
            </div>
      </div>
    </div>

  </div>
  