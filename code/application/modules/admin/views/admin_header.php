<?PHP 
header("cache-Control: no-store, no-cache, must-revalidate");
header("cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
// if(($this->session->userdata('user')!="admin")||($this->session->userdata('developed_by')!='pradeep')||($this->session->userdata('user')=="")||($this->session->userdata('developed_by')==''))
// {
// 	redirect('/admin/');
// }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title><?php echo $_SERVER['SERVER_NAME']; ?></title>

		<meta name="description" content="Static &amp; Dynamic Tables" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/bootstrap.css" />
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/font-awesome.css" />

		<!-- page specific plugin styles -->
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/jquery-ui.custom.css" />
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/chosen.css" />
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/datepicker.css" />
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/bootstrap-timepicker.css" />
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/daterangepicker.css" />
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/bootstrap-datetimepicker.css" />
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/colorpicker.css" />
		<!-- text fonts -->
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/ace-fonts.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />

		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/multiselect.css" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/ace-part2.css" class="ace-main-stylesheet" />
		<![endif]-->

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/ace-ie.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="<?php echo site_url(); ?>assets/js/ace-extra.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="<?php echo site_url(); ?>assets/js/html5shiv.js"></script>
		<script src="<?php echo site_url(); ?>assets/js/respond.js"></script>
		<![endif]-->
	</head>

	<body class="no-skin">
		<!-- #section:basics/navbar.layout -->
		<div id="navbar" class="navbar navbar-default">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<!-- #section:basics/sidebar.mobile.toggle -->
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<!-- /section:basics/sidebar.mobile.toggle -->
				<div class="navbar-header pull-left">
					<!-- #section:basics/navbar.layout.brand -->
					<a href="#" class="navbar-brand">
						<small>
							<i class="fa fa-leaf"></i>
							<?php echo $_SERVER['SERVER_NAME']; ?>
						</small>
					</a>
                    <div class="clearfix"></div>
                    <ul class="company-social">
                  
								<li><a href="https://www.facebook.com" target="_blank">
									<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
								</a></li>

								<li><a href="https://www.youtube.com/user" target="_blank">
									<i class="ace-icon fa fa-youtube-square text-primary bigger-150"></i>
								</a></li>
                               <li>	<a href="https://twitter.com/" target="_blank">
									<i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
								</a>
                              </li>
                                <li><a href="https://www.linkedin.com/company/" target="_blank">
									<i class="ace-icon fa fa-linkedin-square light-blue bigger-150"></i>

								</a></li>
						<div class="clearfix"></div>
                    </ul>
					<!-- /section:basics/navbar.layout.brand -->

					<!-- #section:basics/navbar.toggle -->

					<!-- /section:basics/navbar.toggle -->
				</div>

				<!-- #section:basics/navbar.dropdown -->
				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<!-- #section:basics/navbar.user_menu -->
                        <li>
	                        <ul class="company-address">
		                        <li><b><i class="fa fa-globe" aria-hidden="true"></i>
							        Web Url  :</b> <a href="" target="_blank">KLAKS</a></li>
							    <li><b> <i class="fa fa-phone" aria-hidden="true"></i>
							        Support  :</b> 040 - 000000</li>
							    <li><b> <i class="fa fa-phone-square" aria-hidden="true"></i>
							         Sales  :</b> 0000000000</li>
						    </ul>
                        </li>


						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="<?php echo site_url(); ?>assets/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>Welcome,</small>
									Admin
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								
								<li>
									<a href="<?php ADMIN_URL;?>Changepassword">
										<i class="ace-icon fa fa-cog"></i>
										Change Password
									</a>
								</li>

								<!--<li>
									<a href="profile.html">
										<i class="ace-icon fa fa-user"></i>
										Profile
									</a>
								</li>

								<li class="divider"></li>
								-->

								<li>
									<a href="<?php ADMIN_URL;?>logout">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>

						<!-- /section:basics/navbar.user_menu -->
					</ul>
                    
                    
				</div>

				<!-- /section:basics/navbar.dropdown -->
			</div><!-- /.navbar-container -->
		</div>

		<!-- /section:basics/navbar.layout -->
		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<!-- #section:basics/sidebar -->
			<div id="sidebar" class="sidebar responsive">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

				<ul class="nav nav-list">
					
					<li <?php if($this->uri->segment(2) == 'Home'){?>class="active"<?php } ?>>
						<a href="<?php echo ADMIN_URL;?>Home">
									<i class="menu-icon fa fa-desktop"></i>
									<span class="menu-text">
										DASHBOARD
									</span>
								</a>
							<b class="arrow"></b>
					</li>

					        <?php /*<li <?php if($this->uri->segment(2) == 'Leads'){?>class="active"<?php } ?>>
								<a href="<?php echo ADMIN_URL;?>Leads">
									<i class="menu-icon fa fa-laptop"></i>
									<span class="menu-text"> Leads </span>
								</a>
								<b class="arrow"></b>
							</li>

							<li class="<?php if($this->uri->segment(2)=='Quotes') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Quotes">
									<i class="menu-icon fa fa-file-text-o"></i>
									<span class="menu-text"> Quotes </span>
								</a>
								<b class="arrow"></b>
							</li>

							<li class="<?php if($this->uri->segment(2)=='Itcampaign') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Itcampaign/email">
									<i class="menu-icon fa fa-bullhorn"></i>
									<span class="menu-text"> Campaign </span>
								</a>
								<b class="arrow"></b>
							</li>

							<li <?php if($this->uri->segment(2) == 'Itcampaign'){?>class="active"<?php } ?>>
								<a href="<?php echo ADMIN_URL;?>Itcampaign/email">
									<i class="menu-icon fa fa-smile-o"></i>
									<span class="menu-text"> Support </span>
								</a>
								<b class="arrow"></b>
							</li>
					
					        <li <?php if($this->uri->segment(2) == 'Users'){?>class="active"<?php } ?>>
								<a href="<?php echo ADMIN_URL;?>Users">
									<i class="menu-icon fa fa-smile-o"></i>
									<span class="menu-text"> Users </span>
								</a>
						        <b class="arrow"></b>
					        </li>
					
							<li <?php if($this->uri->segment(2) == 'agents'){?>class="active"<?php } ?>>
								<a href="<?php echo ADMIN_URL;?>agents">
									<i class="menu-icon fa fa-smile-o"></i>
									<span class="menu-text"> Agents </span>
								</a>
								<b class="arrow"></b>
							</li>  */?>
					
					
					<li class="<?php if($this->uri->segment(2)=='Category')       echo 'active';?>
					           	<?php if($this->uri->segment(2)=='Subcategory')    echo 'active';?>
											<?php if($this->uri->segment(2)=='Category_child') echo 'active';?>
											<?php /** if($this->uri->segment(2)=='Brands')         echo 'active';**/?>
											<?php if($this->uri->segment(2)=='Category_child') echo 'active';?>
											<?php if($this->uri->segment(2)=='Products')       echo 'active';?>
											<?php if($this->uri->segment(2)=='Discount')       echo 'active';?>
											<?php if($this->uri->segment(2)=='Shippingandvat') echo 'active';?>
											<?php if($this->uri->segment(2)=='Sizes')          echo 'active';?>
											<?php if($this->uri->segment(2)=='Colors')         echo 'active';?>
											<?php if($this->uri->segment(2)=='Prices')       echo 'active';?>
											<?php if($this->uri->segment(2)=='Coupons')     echo 'active';?>
											<?php if($this->uri->segment(2)=='Sections')       echo 'active';?>

					">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-sitemap"></i>
							<span class="menu-text">
								Categories
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="<?php if($this->uri->segment(2)=='Category') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Category">
									<i class="menu-icon fa fa-sitemap"></i>
									<span class="menu-text">Main Category</span>
								</a>
								<b class="arrow"></b>
							</li> 
							
							<li class="<?php if($this->uri->segment(2)=='Subcategory') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Subcategory">
									<i class="menu-icon fa fa-sitemap"></i>
									<span class="menu-text"> Sub Category</span>
								</a>
								<b class="arrow"></b>
							</li>
							
							<?php /**<li class="<?php if($this->uri->segment(2)=='Category_child') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Category_child">
									<i class="menu-icon fa fa-sitemap"></i>
									<span class="menu-text">Child Category</span>
								</a>
								<b class="arrow"></b>
							</li>
						
				
							<li class="<?php if($this->uri->segment(2)=='Mini_child') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Mini_child">
									<i class="menu-icon fa fa-cubes"></i>
									<span class="menu-text"> Menu Items List </span>
								</a>
								<b class="arrow"></b>
							</li>**/?>

							<li class="<?php if($this->uri->segment(2)=='Products') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Products">
									<i class="menu-icon fa fa-cubes"></i>
									<span class="menu-text">Products</span>
								</a>
								<b class="arrow"></b>
							</li>

							<li class="<?php if($this->uri->segment(2)=='Sizes') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Sizes">
									<i class="menu-icon fa fa-cubes"></i>
									<span class="menu-text"> Sizes </span>
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if($this->uri->segment(2)=='Colors') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Colors">
									<i class="menu-icon fa fa-cubes"></i>
									<span class="menu-text"> Colors </span>
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if($this->uri->segment(2)=='Prices') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Prices">
									<i class="menu-icon fa fa-cubes"></i>
									<span class="menu-text"> Prices </span>
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if($this->uri->segment(2)=='Coupons') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Coupons">
									<i class="menu-icon fa fa-cubes"></i>
									<span class="menu-text"> Coupons </span>
								</a>
								<b class="arrow"></b>
							</li>

							<li class="<?php if($this->uri->segment(2)=='Sections') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Sections">
									<i class="menu-icon fa fa-cubes"></i>
									<span class="menu-text"> Sections </span>
								</a>
								<b class="arrow"></b>
							</li>

							<?php /** <li class="<?php if($this->uri->segment(2)=='Discount') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Discount">
									<i class="menu-icon fa fa-cubes"></i>
									<span class="menu-text"> Discounts </span>
								</a>
								<b class="arrow"></b>
							</li>

							<li class="<?php if($this->uri->segment(2)=='Shippingandvat') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Shippingandvat">
									<i class="menu-icon fa fa-cubes"></i>
									<span class="menu-text"> Shipping </span>
								</a>
								<b class="arrow"></b>
							</li>**/?>
						</ul>
					</li>
				
					
					
					<li class="<?php if($this->uri->segment(2)=='Orders') echo 'active';?>">
						<a href="<?php echo ADMIN_URL;?>Orders">
							<i class="menu-icon fa fa-cube"></i>
							<span class="menu-text"> Orders </span>
						</a>
						<b class="arrow"></b>
					</li>

					<li class="<?php if($this->uri->segment(2)=='Payments') echo 'active';?>">
						<a href="<?php echo ADMIN_URL;?>Payments">
							<i class="menu-icon fa fa-money"></i>
							<span class="menu-text"> Payments </span>
						</a>
						<b class="arrow"></b>
					</li>
					
					<li class="<?php if($this->uri->segment(2)=='Logo')        echo 'active';?>
						       <?php if($this->uri->segment(2)=='Favicon')     echo 'active';?>
									 <?php if($this->uri->segment(2)=='Sliders')     echo 'active';?>
									 <?php if($this->uri->segment(2)=='Banners')     echo 'active';?>
							     <?php /*if($this->uri->segment(2)=='Aboutus')     echo 'active';?>
							   <?php if($this->uri->segment(2)=='Ads')         echo 'active';?>
							   <?php if($this->uri->segment(2)=='Partners')    echo 'active';?>
							   <?php if($this->uri->segment(2)=='Blog')        echo 'active';?>
							   <?php if($this->uri->segment(2)=='services') echo 'active';?>
							   <?php if($this->uri->segment(2)=='Testimonials')echo 'active';?>
							   <?php if($this->uri->segment(2)=='Customer')    echo 'active';?>
							   <?php if($this->uri->segment(2)=='Albums')      echo 'active';*/?>
								 <?php if($this->uri->segment(2)=='Bussiness_rules') echo 'active';?>
							   <?php if($this->uri->segment(2)=='Websettings') echo 'active';?>
					">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-bars"></i>
							<span class="menu-text">
								CMS
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
						    <li class="<?php if($this->uri->segment(2)=='Logo') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Logo">
									<i class="menu-icon fa fa-sitemap"></i>
									<span class="menu-text"> Logo </span>
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="<?php if($this->uri->segment(2)=='Favicon') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Favicon">
									<i class="menu-icon fa fa-sitemap"></i>
									<span class="menu-text"> Favicon </span>
								</a>
								<b class="arrow"></b>
							</li>
						
							<?php /*<li class="<?php if($this->uri->segment(2)=='Ads') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Ads">
									<i class="menu-icon fa fa-bars"></i>
									<span class="menu-text"> Ads </span>
								</a>
								<b class="arrow"></b>
							</li> 
							
							<li class="<?php if($this->uri->segment(2)=='Albums') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Albums">
									<i class="menu-icon fa fa-bars"></i>
									<span class="menu-text">Albums </span>
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="<?php if($this->uri->segment(2)=='Partners') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Partners">
									<i class="menu-icon fa fa-bars"></i>
									<span class="menu-text"> Partners </span>
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="<?php if($this->uri->segment(2)=='Testimonials') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Testimonials">
									<i class="menu-icon fa fa-bars"></i>
									<span class="menu-text"> Testimonials </span>
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="<?php if($this->uri->segment(2)=='services') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>services">
									<i class="menu-icon fa fa-bars"></i>
									<span class="menu-text">Our Services</span>
								</a>
								<b class="arrow"></b>
							</li> 
							
							<li class="<?php if($this->uri->segment(2)=='Policy') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Policy">
									<i class="menu-icon fa fa-bars"></i>
									<span class="menu-text">Policy Info</span>
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="<?php if($this->uri->segment(2)=='Aboutus') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Aboutus">
									<i class="menu-icon fa fa-bars"></i>
									<span class="menu-text"> About Company</span>
								</a>
								<b class="arrow"></b>
							</li>*/?>
							
							
							<!-- <li class="<?php if($this->uri->segment(2)=='Blog') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Blog">
									<i class="menu-icon fa fa-bars"></i>
									<span class="menu-text">Blog</span>
								</a>
								<b class="arrow"></b>
							</li> -->
							
							<li class="<?php if($this->uri->segment(2)=='Sliders') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Sliders">
									<i class="menu-icon fa fa-bars"></i>
									<span class="menu-text">Sliders </span>
								</a>
								<b class="arrow"></b>
							</li>

							<li class="<?php if($this->uri->segment(2)=='Banners') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Banners">
									<i class="menu-icon fa fa-bars"></i>
									<span class="menu-text"> Banners </span>
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="<?php if($this->uri->segment(2)=='Bussiness_rules') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Bussiness_rules">
									<i class="menu-icon fa fa-bars"></i>
									<span class="menu-text">Bussiness Rules </span>
								</a>
								<b class="arrow"></b>
							</li>
														
							<li class="<?php if($this->uri->segment(2)=='Websettings') echo 'active';?>">
								<a href="<?php echo ADMIN_URL;?>Websettings">
									<i class="menu-icon fa fa-sitemap"></i>
									<span class="menu-text"> Web Settings </span>
								</a>
								<b class="arrow"></b>
						    </li>
							
						</ul>
					</li>

					<li class="<?php if($this->uri->segment(2)=='Admins') echo 'active';?>">
						<a href="<?php echo ADMIN_URL;?>Admins">
							<i class="menu-icon fa fa-user"></i>
							<span class="menu-text">Passcode</span>
						</a>
						<b class="arrow"></b>
					</li>

					<li class="<?php if($this->uri->segment(2)=='Users') echo 'active';?>">
						<a href="<?php echo ADMIN_URL;?>Users">
								<i class="menu-icon fa fa-bars"></i>
								<span class="menu-text">Customers </span>
						</a>
						<b class="arrow"></b>
					</li>
						
					<li class="<?php if($this->uri->segment(2)=='Contactus') echo 'active';?>">
						<a href="<?php echo ADMIN_URL;?>Contactus">
							<i class="menu-icon fa fa-phone-square"></i>
							<span class="menu-text">Contacted</span>
						</a>
						<b class="arrow"></b>
					</li>
					

          <li class="">
						<a href="JavaScript:if(confirm('Confirm Database Backup ?')==true){window.location='<?php echo ADMIN_URL;?>backupdb';}">
							<i class="menu-icon fa fa-database"></i>
							<span class="menu-text"> Database Backup </span>
						</a>
						<b class="arrow"></b>
					</li>					
				</ul>
				
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>
