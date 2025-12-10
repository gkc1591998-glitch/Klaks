			<div class="main-content">
				<div class="main-content-inner">
					<!-- #section:basics/content.breadcrumbs -->
					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>

						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="<?php echo ADMIN_URL;?>Home">Home</a>
							</li>

							<li>
								<a href="<?php echo ADMIN_URL; ?>City">City</a>
							</li>
							<li class="active">Edit Page</li>
						</ul><!-- /.breadcrumb -->
					
						<!-- /section:basics/content.searchbox -->
					</div>
				
					<!-- /section:basics/content.breadcrumbs -->
					
					<div class="page-content">
							<div class="ace-settings-container" id="ace-settings-container">
							<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
								<i class="ace-icon fa fa-cog bigger-130"></i>
							</div>

							<div class="ace-settings-box clearfix" id="ace-settings-box">
								<div class="pull-left width-100">
									<!-- #section:settings.skins -->
									<div class="ace-settings-item">
										<div class="pull-left">
											<select id="skin-colorpicker" class="hide">
												<option data-skin="no-skin" value="#438EB9">#438EB9</option>
												<option data-skin="skin-1" value="#222A2D">#222A2D</option>
												<option data-skin="skin-2" value="#C6487E">#C6487E</option>
												<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
											</select>
										</div>
										<span>&nbsp; Choose Skin</span>
									</div>

									<!-- /section:settings.skins -->

									<!-- #section:settings.navbar -->
									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
										<label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
									</div>

									<!-- /section:settings.navbar -->

									<!-- #section:settings.sidebar -->
									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
										<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
									</div>

									<!-- /section:settings.sidebar -->

									<!-- #section:settings.breadcrumbs -->
									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
										<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
									</div>

									<!-- /section:settings.breadcrumbs -->

									<!-- #section:settings.rtl -->
									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
										<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
									</div>

									<!-- /section:settings.rtl -->

									<!-- #section:settings.container -->
									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
										<label class="lbl" for="ace-settings-add-container">
											Inside
											<b>.container</b>
										</label>
									</div>

									<!-- /section:settings.container -->
								</div><!-- /.pull-left -->

								<div class="pull-left width-50">
									<!-- #section:basics/sidebar.options -->
									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" />
										<label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" />
										<label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" />
										<label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
									</div>

									<!-- /section:basics/sidebar.options -->
								</div><!-- /.pull-left -->
							</div><!-- /.ace-settings-box -->
						</div><!-- /.ace-settings-container -->
						
							<h3 class="header smaller lighter blue">MAin Category Table Edit</h3>
							<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" name="myform" id="myform" method="post" enctype="multipart/form-data" role="form">
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">State Name : </label>

										<div class="col-sm-9">
											<select id="form-field-1"  name="state_name" class="col-xs-10 col-sm-5">
												<option value="">select</option>
												<?php foreach($state as $key => $value){?>
													<option value="<?php echo $value['id'];?>"<?php if($value['id'] == $record['state_id']){?> selected <?php } ?>><?php echo $value['state_name'];?></option>
												<?php } ?>
											</select>
										</div>
									</div>									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">City Name : </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1"  name="city_name" placeholder="City Name" value="<?php echo $record['city_name'];?>" class="col-xs-10 col-sm-5" />
										</div>
									</div>
									
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit" name="submit" value="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Submit
											</button>

											&nbsp; &nbsp; &nbsp;
											<a href="<?php echo ADMIN_URL; ?><?php echo $this->uri->segment(2)?>" class="btn" type="reset">
												<i class="ace-icon fa fa-undo bigger-110"></i>
												Cancel
											</a>
										</div>
									</div>
									
								</form>
							</div>
							
							</div>	
						
						

					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

				<?php echo  $this->load->view('footer_copywrite_div');?>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo site_url(); ?>assets/js/jquery.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='<?php echo site_url(); ?>assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo site_url(); ?>assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo site_url(); ?>assets/js/bootstrap.js"></script>
		
		<!-- page specific plugin scripts -->
		<script src="<?php echo site_url(); ?>assets/js/jquery-ui.custom.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/jquery.ui.touch-punch.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/markdown/markdown.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/markdown/bootstrap-markdown.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/jquery.hotkeys.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/bootstrap-wysiwyg.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/bootbox.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/chosen.jquery.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/fuelux/fuelux.spinner.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/date-time/bootstrap-timepicker.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/date-time/moment.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/date-time/daterangepicker.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/date-time/bootstrap-datetimepicker.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/bootstrap-colorpicker.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/jquery.knob.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/jquery.autosize.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/jquery.inputlimiter.1.3.1.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/jquery.maskedinput.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/bootstrap-tag.js"></script>
		
		<!-- inline scripts related to this page -->

		<!-- ace scripts -->
		<script src="<?php echo site_url(); ?>assets/js/ace/elements.scroller.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/elements.colorpicker.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/elements.fileinput.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/elements.typeahead.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/elements.wysiwyg.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/elements.spinner.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/elements.treeview.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/elements.wizard.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/elements.aside.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/ace.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/ace.ajax-content.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/ace.touch-drag.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/ace.sidebar.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/ace.sidebar-scroll-1.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/ace.submenu-hover.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/ace.widget-box.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/ace.settings.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/ace.settings-rtl.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/ace.settings-skin.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/ace.widget-on-reload.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/ace.searchbox-autocomplete.js"></script>

		<!-- inline scripts related to this page -->
		
	</body>
</html>
