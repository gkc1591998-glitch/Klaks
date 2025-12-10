				<div class="main-content">
					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="<?php echo ADMIN_URL;?>Home">Home</a>
							</li>
                           
							<li>
								<a href="<?php echo ADMIN_URL;?>Orders">Orders </a>
							</li>
							<li class="active">List View</li>
						</ul><!-- .breadcrumb -->
						<div class="nav-search" id="nav-search">
<!--							<form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="icon-search nav-search-icon"></i>
								</span>
							</form>
-->						</div><!-- #nav-search -->
					</div>
			<div class="page-content">
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->

							<div class="space-6"></div>
								<div>
							<div class="row-fluid">
								<div class="span10 offset1">
									<div class="widget-box transparent invoice-box">
										<div class="widget-header widget-header-large">
											<h3 class="grey lighter pull-left position-relative">
												<i class="icon-leaf green"></i>
												Order ID: <b class="red"><?php echo stripslashes($record['order_id']);?></b>
											</h3>

											<div class="widget-toolbar no-border invoice-info">
												<span class="invoice-info-label">Time:</span>
												<span class="red"><?php echo date('h:i A',strtotime($record['create_date_time']));?></span>

												<br />
												<span class="invoice-info-label">Date:</span>
												<span class="blue"><?php echo date('d-M-Y',strtotime($record['create_date_time']));?></span>
											</div>
											
										</div>

										<div class="widget-body">
											
											<div class="widget-main padding-24">
											<?php if($this->session->flashdata('msg_succ') != ''){?>
										<div class="alert alert-block alert-success">
											<button type="button" class="close" data-dismiss="alert">
											<i class="icon-remove"></i>
											</button>
											<p>
												<i class="icon-ok"></i>
												<?php echo $this->session->flashdata('msg_succ')?$this->session->flashdata('msg_succ'):'';?>
											</p>
										</div>
										<?php } ?>
												<div class="row-fluid">
												
													<div class="space"></div>

													<div class="row-fluid">
														<table class="table table-striped table-bordered">
															<thead>
																<tr>
																	<th class="center">S.No.</th>
																	<th>Item Name</th>
																	<th class="hidden-phone">Image</th>
																	<th >Price</th>
																	<th class="center">Quantity</th>
																	<th>Sub Total</th>
																</tr>
															</thead>

															<tbody>
															<?php  $i=1; foreach($products as $key => $value){ ?>
																<tr>
																	<td class="center"><?php echo $i;?></td>
																	<td><a href="<?php echo site_url();?>products/product_view/<?php echo stripslashes(str_replace("\n","",$value['item_id']));?>"><?php echo stripslashes(str_replace("\n","",$value['name']));?></a></td>
																	
																	<td><a href="<?php echo site_url();?>all_products/product_view/<?php echo stripslashes(str_replace("\n","",$value['item_id']));?>"><?php echo $value['image'] == '' ? '<img src=" '.site_url().'/images/no-image.jpg" width="100" height="100" />' : '<img src="'.site_url().'images/products/'.$value['image'].'" height="100" width="100" />' ?> </a></td>
																	<td>Rs.&nbsp;<?php   echo stripslashes(str_replace("\n","",$value['price']));?></td>
																	<td class="center"><?php echo stripslashes(str_replace("\n","",$value['qty']));?>&nbsp;</td>
																	<td>Rs.&nbsp;<?php    echo stripslashes(str_replace("\n","",$value['subtotal']));?></td>
																</tr>
															<?php $i++; } ?>
																
																<tr>
																	<td colspan="5">Cart Total :</td>
																	
																	<td>Rs.&nbsp;<?php echo  $record['cart_total'];?></td>
																</tr>
																<!-- <tr>
																	<td colspan="5">Shipping Charges  :</td>

																	<td>Rs.&nbsp;<?php if($record['shipping']!=""){ echo  $record['shipping'];} else {echo "----";}?></td>
																</tr>
																<tr>
																	<td colspan="5">Vat  :</td>
																	<td>Rs.&nbsp;<?php if($record['vat']!=""){ echo  $record['vat'];} else {echo "----";}?></td>
																</tr>
																 -->
																<tr>
																	<td colspan="5">Total Amount:</td>
																	<td><b>Rs.&nbsp;<?php echo  $record['total'];?></b></td>
																</tr>

																<tr>
																	<td colspan="5">Payment Type:</td>
																	<td><b><?php if($record['pay_status']==1){echo "PAYPAL";} else if($record['pay_status']==0){echo "CASH ON DELIVERY";}?></b></td>
																</tr>


																	<tr>
																	<td colspan="6"><b>Shipping Address:</b></br>
																	Name: <?php echo stripslashes(str_replace("\n","",$record['dfname']));?>&nbsp;<?php echo stripslashes(str_replace("\n","",$record['dlname']));?></br>
																	Mobile: <?php echo stripslashes(str_replace("\n","",$record['dmobile']));?> </br>
																	Email: <?php echo stripslashes(str_replace("\n","",$record['demail']));?></br>
																	Address : <?php echo stripslashes(str_replace("\n","",$record['dlocation']));?>&nbsp;,
																	<?php echo stripslashes(str_replace("\n","",$record['dcity']));?>&nbsp;,
																	<?php echo stripslashes(str_replace("\n","",$record['dstate']));?>&nbsp;,
																	<?php echo stripslashes(str_replace("\n","",$record['dcountry']));?>&nbsp;</br>
																	Zip Code : <?php echo stripslashes(str_replace("\n","",$record['dzipcode']));?></br>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>

													<div class="hr hr8 hr-double hr-dotted"></div>
													<div class="widget-body">
									
											
													
													<div id="fuelux-wizard-container">
												<div>
													<!-- #section:plugins/fuelux.wizard.steps -->
													<ul class="steps">
														<li data-step="1"  <?php if($record['status']==1){ ?> class="active" <?php } ?> ><a href="<?php echo site_url();?>admin/Orders/changestatus/1/<?php echo $record['id'];?>">
															<span class="step">1</span>
															<span class="title">CONFIRMED</span></a>
														</li>

														<li data-step="2" <?php if($record['status']==2){ ?> class="active" <?php } ?>  ><a href="<?php echo site_url();?>admin/Orders/changestatus/2/<?php echo $record['id'];?>">
															<span class="step">2</span>
															<span class="title">PROCESSING</span></a>
														</li>

														<li data-step="3" <?php if($record['status']==3){ ?> class="active" <?php } ?> ><a href="<?php echo site_url();?>admin/Orders/changestatus/3/<?php echo $record['id'];?>">
															<span class="step">3</span>
															<span class="title">SHIPPING</span></a>
														</li>

														<li data-step="4" <?php if($record['status']==4){ ?> class="active" <?php } ?> ><a href="<?php echo site_url();?>admin/Orders/changestatus/4/<?php echo $record['id'];?>">
															<span class="step">4</span>
															<span class="title">DELIVERED</span></a>
														</li>
													</ul>

													<!-- /section:plugins/fuelux.wizard.steps -->
												</div>
													</div>
													<div class="space-6"></div>

													
												</div>
												<div class="clearfix form-actions">
									 	    <div class="col-md-offset-3 col-md-9">
                                         
                                            <a href="<?php echo site_url(); ?>admin/Orders" class="btn btn-sm btn-primary">Back</a>
										</div>
									</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
							<!--PAGE CONTENT ENDS-->
						</div><!--/.span-->
					</div><!--/.row-fluid-->
				</div><!--/.page-content-->
	</div><!-- /.main-content -->
				<div class="ace-settings-container" id="ace-settings-container">
					<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
						<i class="icon-cog bigger-150"></i>
					</div>
					<div class="ace-settings-box" id="ace-settings-box">
						<div>
							<div class="pull-left">
								<select id="skin-colorpicker" class="hide">
									<option data-skin="default" value="#438EB9">#438EB9</option>
									<option data-skin="skin-1" value="#222A2D">#222A2D</option>
									<option data-skin="skin-2" value="#C6487E">#C6487E</option>
									<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
								</select>
							</div>
							<span>&nbsp; Choose Skin</span>
						</div>
						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
							<label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
						</div>
						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
							<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
						</div>
						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
							<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
						</div>
						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
							<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
						</div>
						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
							<label class="lbl" for="ace-settings-add-container">
								Inside
								<b>.container</b>
							</label>
						</div>
					</div>
				</div><!-- /#ace-settings-container -->
			</div><!-- /.main-container-inner -->
			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->
		<!-- basic scripts -->
		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo site_url();?>/assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>
		<!-- <![endif]-->
		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='<?php echo site_url();?>/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='<?php echo site_url();?>/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo site_url();?>/assets/js/bootstrap.min.js"></script>
		<script src="<?php echo site_url();?>/assets/js/typeahead-bs2.min.js"></script>
		<!-- page specific plugin scripts -->
		<script src="<?php echo site_url();?>/assets/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo site_url();?>/assets/js/jquery.dataTables.bootstrap.js"></script>
		<!-- ace scripts -->
		<script src="<?php echo site_url();?>/assets/js/ace-elements.min.js"></script>
		<script src="<?php echo site_url();?>/assets/js/ace.min.js"></script>
		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				var oTable1 = $('#sample-table-2').dataTable( {
				"aoColumns": [
			      { "bSortable": false },
			      null, null,null, null,null, null,
				  { "bSortable": false }
				] } );
				
				
				$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});
			
			
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			})
		</script>
	</body>
</html>
