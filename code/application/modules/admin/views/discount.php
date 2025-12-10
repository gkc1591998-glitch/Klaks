			<div class="main-content">
				<div class="main-content-inner">
					<!-- #section:Discounts/content.breadcrumbs -->
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
								<a href="<?php echo ADMIN_URL; ?>Discount">discount</a>
							</li>
							<li class="active">Main Page</li>
						</ul><!-- /.breadcrumb -->
					
						<!-- /section:Discounts/content.searchbox -->
					</div>

					<!-- /section:Discounts/content.breadcrumbs -->
					
					<div class="page-content">
						<!-- #section:settings.box -->
						
					<div class="row">
									<div class="col-xs-12">
										<h3 class="header smaller lighter blue">discount</h3>
										<form method="post" action="<?php echo ADMIN_URL;?>Discount/delete_selected">
										<div class="clearfix">
											<div class="pull-left tableTools-container"></div>
											<div class="pull-right">
											<a  href="<?php echo ADMIN_URL; ?>discount/add"  class="btn btn-primary">
												<i class="ace-icon fa glyphicon-plus align-top bigger-125"></i>
												ADD
											</a>											
											<button class="btn btn-danger" type="submit" onClick="return delete_selected_fields();" name="submit" value="submit">
												<i class="ace-icon fa  fa-trash-o align-top bigger-125"></i>
												DELETE
											</button>
											</div>
										</div>
										<script type="text/javascript">
                                        function delete_selected_fields(){ 
                                            var checked_num = $('input[name="selected_ids[]"]:checked').length;
                                            if (checked_num == 0) {
                                                alert('Minimum One Check Box Must be Selected... ');
                                                return false;
                                            }else if (checked_num > 0){ 
                                                if(confirm('Delete all selected?')==true){
                                                    return true;
                                                }else{
													return false;
												}
                                            }
                                        }
                                        </script>
										
										
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
										<div class="table-header">
											&nbsp;
										</div>

										<!-- div.table-responsive -->

										<!-- div.dataTables_borderWrap -->
										<div>
											<table id="dynamic-table" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th class="center">
															<label class="pos-rel">
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</th>
														<th>S.No</th>
														<th>Name</th>
														<th>Action</th>
													</tr>
												</thead>

												<tbody>
													<?php
														if(count($record) > 0){
															$i=1;
															foreach($record as $key => $row){ 
													?>
											
													<tr>
														<td class="center">
															<label class="pos-rel">
																<input type="checkbox" name="selected_ids[]" id="selected_ids[]" value="<?php echo $row['id'];?>" class="ace" />
																<span class="lbl"></span>
															</label>
														</td>
														<td><?php echo $i;?></td>
														<td><?php echo stripslashes($row['name']); ?></td>
												
														<td>
															<div class="hidden-sm hidden-xs action-buttons">
																
																<a class="green" href="<?php echo ADMIN_URL; ?>discount/edit/<?php echo $row['id'];?>">
																	<i class="ace-icon fa fa-pencil bigger-130"></i>
																</a>
                                                                 <a class="red" href="<?php echo ADMIN_URL; ?>discount/delete/<?php echo $row['id'];?>">
																	<i class="ace-icon fa fa-trash-o bigger-130"></i>
																</a>
															
															
															</div>

															<div class="hidden-md hidden-lg">
																<div class="inline pos-rel">
																	<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
																		<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
																	</button>

																	<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
																		

																		<li>
																			<a href="<?php echo ADMIN_URL; ?>discount/edit/<?php echo $row['id'];?>" class="tooltip-success" data-rel="tooltip" title="Edit">
																				<span class="green">
																					<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																				</span>
																			</a>
																		</li>

																	</ul>
																</div>
															</div>
														</td>
													</tr>
													
													<?php  $i++;} ?>
													<?php } ?>
													
												</tbody>
											</table>
										</div>
										 </form>   
									</div>
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
									<!-- #section:Discounts/sidebar.options -->
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

									<!-- /section:Discounts/sidebar.options -->
								</div><!-- /.pull-left -->
							</div><!-- /.ace-settings-box -->
						</div><!-- /.ace-settings-container -->
						
								</div>

					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?php echo  $this->load->view('footer_copywrite_div');?>
			
			

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- Discount scripts -->

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
		<script src="<?php echo site_url(); ?>assets/js/dataTables/jquery.dataTables.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
		
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
		
		<script type="text/javascript">
			jQuery(function($) {
				//initiate dataTables plugin
				var oTable1 = 
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.dataTable( {
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null,
					  { "bSortable": false }
					],
					"aaSorting": [],
			
					//,
					//"sScrollY": "200px",
					//"bPaginate": false,
			
					//"sScrollX": "100%",
					//"sScrollXInner": "120%",
					//"bScrollCollapse": true,
					//Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
					//you may want to wrap the table inside a "div.dataTables_borderWrap" element
			
					//"iDisplayLength": 50
			    } );
				//oTable1.fnAdjustColumnSizing();
			
			
				//TableTools settings
				TableTools.classes.container = "btn-group btn-overlap";
				TableTools.classes.print = {
					"body": "DTTT_Print",
					"info": "tableTools-alert gritter-item-wrapper gritter-info gritter-center white",
					"message": "tableTools-print-navbar"
				}
			
				//initiate TableTools extension
				var tableTools_obj = new $.fn.dataTable.TableTools( oTable1, {
					"sSwfPath": "<?php echo site_url(); ?>assets/js/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf", //in Ace demo <?php echo site_url(); ?>assets will be replaced by correct assets path
					
					"sRowSelector": "td:not(:last-child)",
					"sRowSelect": "multi",
					"fnRowSelected": function(row) {
						//check checkbox when row is selected
						try { $(row).find('input[type=checkbox]').get(0).checked = true }
						catch(e) {}
					},
					"fnRowDeselected": function(row) {
						//uncheck checkbox
						try { $(row).find('input[type=checkbox]').get(0).checked = false }
						catch(e) {}
					},
			
					"sSelectedClass": "success",
			        "aButtons": [
						{
							"sExtends": "copy",
							"sToolTip": "Copy to clipboard",
							"sButtonClass": "btn btn-white btn-primary btn-bold",
							"sButtonText": "<i class='fa fa-copy bigger-110 pink'></i>",
							"fnComplete": function() {
								this.fnInfo( '<h3 class="no-margin-top smaller">Table copied</h3>\
									<p>Copied '+(oTable1.fnSettings().fnRecordsTotal())+' row(s) to the clipboard.</p>',
									1500
								);
							}
						},
						
						{
							"sExtends": "csv",
							"sToolTip": "Export to CSV",
							"sButtonClass": "btn btn-white btn-primary  btn-bold",
							"sButtonText": "<i class='fa fa-file-excel-o bigger-110 green'></i>"
						},
						
						{
							"sExtends": "pdf",
							"sToolTip": "Export to PDF",
							"sButtonClass": "btn btn-white btn-primary  btn-bold",
							"sButtonText": "<i class='fa fa-file-pdf-o bigger-110 red'></i>"
						},
						
						{
							"sExtends": "print",
							"sToolTip": "Print view",
							"sButtonClass": "btn btn-white btn-primary  btn-bold",
							"sButtonText": "<i class='fa fa-print bigger-110 grey'></i>",
							
							"sMessage": "<div class='navbar navbar-default'><div class='navbar-header pull-left'><a class='navbar-brand' href='#'><small>Optional Navbar &amp; Text</small></a></div></div>",
							
							"sInfo": "<h3 class='no-margin-top'>Print view</h3>\
									  <p>Please use your browser's print function to\
									  print this table.\
									  <br />Press <b>escape</b> when finished.</p>",
						}
			        ]
			    } );
				//we put a container before our table and append TableTools element to it
			    $(tableTools_obj.fnContainer()).appendTo($('.tableTools-container'));
				
				//also add tooltips to table tools buttons
				//addding tooltips directly to "A" buttons results in buttons disappearing (weired! don't know why!)
				//so we add tooltips to the "DIV" child after it becomes inserted
				//flash objects inside table tools buttons are inserted with some delay (100ms) (for some reason)
				setTimeout(function() {
					$(tableTools_obj.fnContainer()).find('a.DTTT_button').each(function() {
						var div = $(this).find('> div');
						if(div.length > 0) div.tooltip({container: 'body'});
						else $(this).tooltip({container: 'body'});
					});
				}, 200);
				
				
				
				//ColVis extension
				var colvis = new $.fn.dataTable.ColVis( oTable1, {
					"buttonText": "<i class='fa fa-search'></i>",
					"aiExclude": [0, 6],
					"bShowAll": true,
					//"bRestore": true,
					"sAlign": "right",
					"fnLabel": function(i, title, th) {
						return $(th).text();//remove icons, etc
					}
					
				}); 
				
				//style it
				$(colvis.button()).addClass('btn-group').find('button').addClass('btn btn-white btn-info btn-bold')
				
				//and append it to our table tools btn-group, also add tooltip
				$(colvis.button())
				.prependTo('.tableTools-container .btn-group')
				.attr('title', 'Show/hide columns').tooltip({container: 'body'});
				
				//and make the list, buttons and checkboxed Ace-like
				$(colvis.dom.collection)
				.addClass('dropdown-menu dropdown-light dropdown-caret dropdown-caret-right')
				.find('li').wrapInner('<a href="javascript:void(0)" />') //'A' tag is required for better styling
				.find('input[type=checkbox]').addClass('ace').next().addClass('lbl padding-8');
			
			
				
				/////////////////////////////////
				//table checkboxes
				$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
				
				//select/deselect all rows according to table header checkbox
				$('#dynamic-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$(this).closest('table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) tableTools_obj.fnSelect(row);
						else tableTools_obj.fnDeselect(row);
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
					var row = $(this).closest('tr').get(0);
					if(!this.checked) tableTools_obj.fnSelect(row);
					else tableTools_obj.fnDeselect($(this).closest('tr').get(0));
				});
				
			
				
				
					$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
					e.stopImmediatePropagation();
					e.stopPropagation();
					e.preventDefault();
				});
				
				
				//And for the first simple table, which doesn't have TableTools or dataTables
				//select/deselect all rows according to table header checkbox
				var active_class = 'active';
				$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$(this).closest('table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
						else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#simple-table').on('click', 'td input[type=checkbox]' , function(){
					var $row = $(this).closest('tr');
					if(this.checked) $row.addClass(active_class);
					else $row.removeClass(active_class);
				});
			
				
			
				/********************************/
				//add tooltip for small view action buttons in dropdown menu
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				
				//tooltip placement on right or left
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			
			})
		</script>
		
		<!-- the following scripts are used in demo only for onpage help and you don't need them -->
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/ace.onpage-help.css" />
		<link rel="stylesheet" href="<?php echo site_url(); ?>docs/assets/js/themes/sunburst.css" />

		<script type="text/javascript"> ace.vars['base'] = '..'; </script>
		<script src="<?php echo site_url(); ?>assets/js/ace/elements.onpage-help.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/ace/ace.onpage-help.js"></script>
		<script src="<?php echo site_url(); ?>docs/assets/js/rainbow.js"></script>
		<script src="<?php echo site_url(); ?>docs/assets/js/language/generic.js"></script>
		<script src="<?php echo site_url(); ?>docs/assets/js/language/html.js"></script>
		<script src="<?php echo site_url(); ?>docs/assets/js/language/css.js"></script>
		<script src="<?php echo site_url(); ?>docs/assets/js/language/javascript.js"></script>
	</body>
</html>
