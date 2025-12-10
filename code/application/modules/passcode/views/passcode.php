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
                        <form class="track_order" role="form" name="passcode" id="passcode" enctype="multipart/form-data" method="post">
                            
                        <p style="max-width: 540px; margin: auto; text-align: center" class="form-row form-row-first"><label for="passcode_input">Passcode</label>
                                <input class="input-text" type="text" name="passcode" id="passcode_input"
                                value="<?php echo $this->input->post('passcode');?>" placeholder="Enter Your Passcode">
                            </p>
                            <div style="max-width: 540px; margin: auto; text-align: center"><?php echo form_error('passcode');?></div>
                            
                            <div class="clear"></div>
                            <p class="form-row">
                                <button type="submit" class="button" name="submit" value="submit">Verify Passcode</button>
                            </p>
							
							<p style="padding-bottom: 15px;font-size: 10px;text-align:center">
                                Enter your passcode to access luxury products.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('passcode');
    const passcodeInput = document.getElementById('passcode_input');
    
    // Focus on passcode input when page loads
    passcodeInput.focus();
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        const passcode = passcodeInput.value.trim();
        
        if (passcode === '') {
            e.preventDefault();
            alert('Please enter a passcode');
            passcodeInput.focus();
            return false;
        }
    });
    
    // Handle Enter key press on input
    passcodeInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            form.submit();
        }
    });
});
</script>
