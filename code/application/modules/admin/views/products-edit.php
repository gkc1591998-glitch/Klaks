<div class="main-content">
				<div class="main-content-inner">
					<!-- #section:Productss/content.breadcrumbs -->
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
								<a href="<?php echo ADMIN_URL; ?>Products">Products</a>
							</li>
							<li class="active">Add Page</li>
						</ul><!-- /.breadcrumb -->
					
						<!-- /section:Productss/content.searchbox -->
					</div>
				
					<!-- /section:Productss/content.breadcrumbs -->
					
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
									<!-- #section:Productss/sidebar.options -->
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
									<!-- /section:Productss/sidebar.options -->
								</div><!-- /.pull-left -->
							</div><!-- /.ace-settings-box -->
						</div><!-- /.ace-settings-container -->
						    <h3 class="header smaller lighter blue">Products Listing </h3>
							<div class="row">
							<?php if($msg != ''){?>
									<div class="alert alert-block alert-success">
										<button type="button" class="close" data-dismiss="alert">
										<i class="icon-remove"></i>
										</button>
										<p>
											<i class="icon-ok"></i>
											<?php echo $msg?$msg:'';?>
										</p>
									</div>
								<?php } ?>
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
										
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" name="myform" id="myform" method="post" enctype="multipart/form-data" role="form">
						
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Category : </label>
								<div class="col-sm-9">
									<select id="cat_id" class="col-xs-10 col-sm-5" name="cat_id" onchange="getcity(this.value)">
										<option value="">Select Category</option>
										<?php foreach($maincat as $values){ ?>
											<option <?php if($record['cat_id']==$values['id']){ ?> selected <?php } ?> value="<?php echo $values['id']; ?>"><?php echo stripslashes(str_replace("\n","",$values['name'])); ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sub Category : </label>
								<div class="col-sm-9">
									<select id="subcat_id" class="col-xs-10 col-sm-5"  name="subcat_id" onchange="getarea(this.value)">
										<?php foreach($subcat as $values){ ?>
											<option <?php if($record['subcat_id']==$values['id']){ ?> selected <?php } ?> value="<?php echo $values['id']; ?>"><?php echo stripslashes(str_replace("\n","",$values['name'])); ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						
							<?php /*<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Child Category : </label>
								<div class="col-sm-9">
									<select id="childcat_id" class="col-xs-10 col-sm-5"  name="childcat_id" >
										<?php foreach($childcat as $values){ ?>
													<option <?php if($record['subcat_id']==$values['id']){ ?> selected <?php } ?> value="<?php echo $values['id']; ?>"><?php echo stripslashes(str_replace("\n","",$values['child_category_name'])); ?></option>
												<?php } ?>
									</select>
								</div>
							</div>*/?>
						
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Title: </label>
								<div class="col-sm-9">
									<input type="text" id="form-field-1" autocomplete="on" name="title" value="<?php echo stripslashes(str_replace("\n","",$record['title'])); ?>" class="col-xs-10 col-sm-5" />
								</div>
							</div>
									
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Availability: </label>
								<div class="col-sm-9">
									<select class="col-xs-10 col-sm-5" name="available">
										<option value="">Select Availability</option>
										<option <?php if($record['available']=="In Stock"){ ?> selected <?php } ?> value="In Stock">In Stock</option>
										<option <?php if($record['available']=="Out Stock"){ ?> selected <?php } ?> value="Out Stock">Out Stock</option>
									</select>
								</div>
							</div>

							<!-- <div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> XS size price: </label>
								<div class="col-sm-9">
									<input type="text" id="form-field-1" autocomplete="on" name="xsprice"  value="<?php echo stripslashes(str_replace("\n","",$record['xsprice'])); ?>" class="col-xs-10 col-sm-5"  placeholder="---Enter XS size price---"/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> S size price: </label>
								<div class="col-sm-9">
									<input type="text" id="form-field-1" autocomplete="on" name="sprice"  value="<?php echo stripslashes(str_replace("\n","",$record['sprice'])); ?>" class="col-xs-10 col-sm-5"  placeholder="---Enter S size price---"/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> M size price: </label>
								<div class="col-sm-9">
									<input type="text" id="form-field-1" autocomplete="on" name="mprice"  value="<?php echo stripslashes(str_replace("\n","",$record['mprice'])); ?>" class="col-xs-10 col-sm-5"  placeholder="---Enter M size price---"/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> L size price: </label>
								<div class="col-sm-9">
									<input type="text" id="form-field-1" autocomplete="on" name="lprice"  value="<?php echo stripslashes(str_replace("\n","",$record['lprice'])); ?>" class="col-xs-10 col-sm-5"  placeholder="---Enter L size price---"/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> XL size price: </label>
								<div class="col-sm-9">
									<input type="text" id="form-field-1" autocomplete="on" name="xlprice"  value="<?php echo stripslashes(str_replace("\n","",$record['xlprice'])); ?>" class="col-xs-10 col-sm-5"  placeholder="---Enter XL size price---"/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> XXL size price: </label>
								<div class="col-sm-9">
									<input type="text" id="form-field-1" autocomplete="on" name="xxlprice"  value="<?php echo stripslashes(str_replace("\n","",$record['xxlprice'])); ?>" class="col-xs-10 col-sm-5"  placeholder="---Enter XXL size price---"/>
								</div>
							</div>

						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Price Range: </label>
							<div class="col-sm-9">
								<input type="text" id="form-field-1" autocomplete="on" name="price_range"  value="<?php echo stripslashes(str_replace("\n","",$record['price_range'])); ?>" class="col-xs-10 col-sm-5"  placeholder="---Enter Price range---"/>
							</div>
						</div> -->
									
							<!-- <div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> price: </label>
								<div class="col-sm-9">
									<input type="text" id="form-field-1" autocomplete="on" name="price" value="<?php echo stripslashes(str_replace("\n","",$record['price'])); ?>" class="col-xs-10 col-sm-5" onkeypress="return isNumber(event)"/>
								</div>
							</div> -->
									
							<?php /*<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Discount price: </label>
								<div class="col-sm-9">
									<input type="text" id="form-field-1" autocomplete="on" name="dprice" value="<?php echo stripslashes(str_replace("\n","",$record['dprice'])); ?>" class="col-xs-10 col-sm-5" onkeypress="return isNumber(event)"/>
								</div>
							</div>*/?>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Product Description : </label>
								<div class="col-sm-9">
									<script src="//cdn.ckeditor.com/4.5.9/full/ckeditor.js"></script>
									<textarea name="content"><?php echo stripslashes(str_replace(array("\r\n", "\n", "\r", "\rn"), "", $record['content'])); ?></textarea>
									<script>
										CKEDITOR.replace( 'content' );
									</script>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Additional Information : </label>
								<div class="col-sm-9">
									<script src="//cdn.ckeditor.com/4.5.9/full/ckeditor.js"></script>
									<textarea name="additional_info"><?php echo stripslashes(str_replace(array("\r\n", "\n", "\r", "\rn"), "", $record['additional_info'])); ?></textarea>
									<script>
										CKEDITOR.replace( 'additional_info' );
									</script>
								</div>
							</div>
									
									<!-- <div class="clearfix"></div>
									<div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Image1: </label>
											<div class="col-sm-9">
											    <?php if(($record['image1']!="0")&&($record['image1']!="")){ ?>
												<img src="<?php echo site_url(); ?>images/products/<?php echo $record['image1']; ?>" height="100" width="100" >
											<?php } ?><br><br>
												<input type="file" name="image1"  id="id-input-file-2"  class="col-xs-10 col-sm-5" /> 
											</div>
										</div>
											
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Image2: </label>
											<div class="col-sm-9">
											   <?php if(($record['image2']!="0")&&($record['image2']!="")){ ?>
												<img src="<?php echo site_url(); ?>images/products/<?php echo $record['image2']; ?>" height="100" width="100" >
											<?php } ?> <br><br>
												<input type="file" name="image2"  id="id-input-file-2"  class="col-xs-10 col-sm-5" /> 
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Image3: </label>
											<div class="col-sm-9">
											   <?php if(($record['image3']!="0")&&($record['image3']!="")){ ?>
												<img src="<?php echo site_url(); ?>images/products/<?php echo $record['image3']; ?>" height="100" width="100" >
											<?php } ?><br><br>
												<input type="file" name="image3"  id="id-input-file-2"  class="col-xs-10 col-sm-5" /> 
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Image4: </label>
											<div class="col-sm-9">
											   <?php if(($record['image4']!="0")&&($record['image4']!="")){ ?>
												<img src="<?php echo site_url(); ?>images/products/<?php echo $record['image4']; ?>" height="100" width="100" >
											<?php } ?><br><br>
												<input type="file" name="image4"  id="id-input-file-2"  class="col-xs-10 col-sm-5" /> 
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Image5: </label>
											<div class="col-sm-9">
											   <?php if(($record['image5']!="0")&&($record['image5']!="")){ ?>
												<img src="<?php echo site_url(); ?>images/products/<?php echo $record['image5']; ?>" height="100" width="100" >
											<?php } ?><br><br>
												<input type="file" name="image5"  id="id-input-file-2"  class="col-xs-10 col-sm-5" /> 
											</div>
										</div> -->
									
									<div class="clearfix"></div><div>&nbsp;</div>
                                    <div>&nbsp;</div>

									<!-- Product Attributes Row (Dynamic) -->
								<!-- <div class="form-group">
									<div class="col-sm-12 text-center">
										<h2>Product Attributes</h2>
									</div>
									<div class="col-sm-12">
										<div class="col-xs-2"><b>Section</b></div>
										<div class="col-xs-2"><b>Price</b></div>
										<div class="col-xs-1"><b>Size</b></div>
										<div class="col-xs-2"><b>Color</b></div>
										<div class="col-xs-2"><b>Coupan</b></div>
										<div class="col-xs-2"><b>Image</b></div>
										<div class="col-xs-1"></div>
									</div>
								</div> -->
								<!-- <div class="form-group" id="product-attributes-row">
										<div class="col-sm-12" id="attributes-container">
											<?php 
												$attr = array();
												$showRemove = false; 
												$showAdd = true;
												include '_product_attributes_row_edit.php';

												$attributes = (isset($product_attributes) && is_array($product_attributes) && count($product_attributes) > 0) ? $product_attributes : array();
												foreach($attributes as $attr) {
														$showRemove = true; 
														$showAdd = false;
														include '_product_attributes_row_edit.php';
												}
											?>
										</div>
											<?php 
												$attributes = isset($product_attributes) && !empty($product_attributes) ? $product_attributes : array(array());
												foreach($attributes as $attr) {
													// Show images for each attribute row if available
													if (!empty($attr['image'])) {
														$imagePath = site_url() . 'images/products/' . $attr['image'];
														echo '<div class="attribute-image-preview col-xs-1" style="display:inline-block;margin-bottom:5px;">';
														echo '<img src="' . $imagePath . '" alt="Attribute Image" height="100" width="200" style="border:1px solid #ccc;padding:2px;max-width:100%;">';
														echo '</div>';
													}
												}
												?>
								</div> -->
									
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit" name="submit" value="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Submit
											</button>
											&nbsp; &nbsp; &nbsp;
											<a class="btn" href="<?php echo ADMIN_URL;?>Products">
												<i class="ace-icon fa fa-undo bigger-110"></i>
												Cancel
											</a>
										</div>
									</div>									
								</form>
							</div>					
					</div>
				</div>
			</div>
				<?php echo  $this->load->view('footer_copywrite_div');?>
			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->
		<!-- Products scripts -->
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
<script type="text/javascript">
//programmer defined functions
		function getcity(valu)
		{
			$.ajax({ 
			   type: "POST", url: '<?php echo ADMIN_URL;?>Products/getcities', data: "valu="+valu,
			   complete: function(data){  
				  var op = data.responseText.trim();
				   //alert(op);
				  $("#subcat_id").html(op);
			   }
		   });
		}
		function getarea(valu)
		{
			$.ajax({ 
			   type: "POST", url: '<?php echo ADMIN_URL;?>Products/getareas', data: "valu="+valu,
			   complete: function(data){  
				  var op = data.responseText.trim();
				  //alert(op);
				  $("#childcat_id").html(op);
			   }
		   });
		}
</script>

<script type="text/javascript">
     function makeid() {  
     	var text = "";
        var possible = "0123456789";
        for( var i=0; i < 4; i++ )
           text += possible.charAt(Math.floor(Math.random() * possible.length));
        return "AF-"+text;
    }
    function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    	 window.alert("Please Enter Only Numbers.");
        return false;
    }
    return true;
}
</script>
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
<script>
// Add/Remove attribute row logic (same as add page, but for edit)
$(document).on('click', '.btn-add-attribute', function() {
    var row = $(this).closest('.product-attribute-set');
    var html = row[0].outerHTML;
    var $clone = $(html);
    $clone.find('select').val('');
		$clone.find('.btn-remove-attribute').remove();
    $clone.find('.btn-add-attribute')
    .removeClass('btn-success btn-add-attribute')
    .addClass('btn-danger btn-remove-attribute')
    .html('<i class="fa fa-minus"></i>');
    $clone.find('.btn-remove-attribute').show();
    row.parent().append($clone);
});
$(document).on('click', '.btn-remove-attribute', function() {
    $(this).closest('.product-attribute-set').remove();
});
</script>
	</body>
</html>
