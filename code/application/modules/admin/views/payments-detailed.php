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
								<a href="<?php echo ADMIN_URL;?>Payments">Payments </a>
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
														<div class="widget-box">
															<div class="widget-header">
																<h4 class="widget-title">Payment Details</h4>
															</div>
															<div class="widget-body">
																<div class="widget-main">
																	<div class="row-fluid">
																		<div class="span6">
																			<h5><strong>Transaction Information</strong></h5>
																			<table class="table table-bordered">
																				<tr>
																					<td><strong>Payment ID:</strong></td>
																					<td><?php echo $record['id']; ?></td>
																				</tr>
																				<tr>
																					<td><strong>Razorpay Payment ID:</strong></td>
																					<td><?php echo $record['razorpay_payment_id'] ? $record['razorpay_payment_id'] : 'N/A'; ?></td>
																				</tr>
																				<tr>
																					<td><strong>Razorpay Order ID:</strong></td>
																					<td><?php echo $record['razorpay_order_id'] ? $record['razorpay_order_id'] : 'N/A'; ?></td>
																				</tr>
																				<tr>
																					<td><strong>Amount:</strong></td>
																					<td>₹<?php echo number_format($record['amount'], 2); ?></td>
																				</tr>
																				<tr>
																					<td><strong>Currency:</strong></td>
																					<td><?php echo $record['currency']; ?></td>
																				</tr>
																				<tr>
																					<td><strong>Status:</strong></td>
																					<td>
																						<?php if($record['status'] == 'success'): ?>
																							<span class="badge badge-success">Success</span>
																						<?php elseif($record['status'] == 'failed'): ?>
																							<span class="badge badge-danger">Failed</span>
																						<?php else: ?>
																							<span class="badge badge-warning">Pending</span>
																						<?php endif; ?>
																					</td>
																				</tr>
																				<tr>
																					<td><strong>Created:</strong></td>
																					<td><?php echo date('d-m-Y H:i:s', strtotime($record['created_at'])); ?></td>
																				</tr>
																				<tr>
																					<td><strong>Paid At:</strong></td>
																					<td><?php echo $record['paid_at'] ? date('d-m-Y H:i:s', strtotime($record['paid_at'])) : 'N/A'; ?></td>
																				</tr>
																			</table>
																		</div>
																		<div class="span6">
																			<h5><strong>Order Information</strong></h5>
																			<table class="table table-bordered">
																				<?php if(!empty($record['order_id'])): ?>
																				<tr>
																					<td><strong>Order ID:</strong></td>
																					<td><?php echo $record['order_id']; ?></td>
																				</tr>
																				<tr>
																					<td><strong>Order Table ID:</strong></td>
																					<td><?php echo $record['order_table_id']; ?></td>
																				</tr>
																				<?php endif; ?>
																				
																				<?php if(!empty($record['student_id'])): ?>
																				<tr>
																					<td><strong>Student ID:</strong></td>
																					<td><?php echo $record['student_id']; ?></td>
																				</tr>
																				<?php endif; ?>
																				
																				<?php if(!empty($record['failure_reason'])): ?>
																				<tr>
																					<td><strong>Failure Reason:</strong></td>
																					<td><?php echo $record['failure_reason']; ?></td>
																				</tr>
																				<?php endif; ?>
																			</table>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
																	
																	</td>
																	
																</tr>
																
															</tbody>
														</table>
													</div>

										
												<div class="clearfix form-actions">
									 	    <div class="col-md-offset-3 col-md-9">
                                         
                                            <a href="<?php echo site_url(); ?>admin/Payments" class="btn btn-sm btn-primary">Back</a>
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
