<div class="fullwidth-template">

	<div class="section-001">
		<?php if (!empty($sliders)) { ?>
			<div id="demo" class="carousel slide mt-5 " data-ride="carousel">
				<!-- Indicators -->
				<ul class="carousel-indicators">
					<?php foreach ($sliders as $i => $slider): ?>
						<li data-target="#demo" data-slide-to="<?php echo $i; ?>" <?php if ($i == 0) echo ' class="active"'; ?>></li>
					<?php endforeach; ?>
				</ul>

				<!-- The slideshow -->
				<div class="carousel-inner">
					<div class="linkonbanner">
						<?php foreach ($sliders as $i => $slider): ?>
							<div class="linkonbanner-item">
								<a href="#"><?php echo htmlspecialchars($slider['name']); ?></a>
							</div>
						<?php endforeach; ?>
					</div>
					<?php foreach ($sliders as $i => $slider): ?>
						<div class="carousel-item<?php if ($i == 0) echo ' active'; ?>">
							<?php if (!empty($slider['image'])): ?>
								<img src="<?php echo site_url(); ?>images/sliders/<?php echo htmlspecialchars($slider['image']); ?>" alt="<?php echo htmlspecialchars($slider['name']); ?>" width="100%" height="400">
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>

				<!-- Left and right controls -->
				<a class="carousel-control-prev" href="#demo" data-slide="prev">
					<span class="carousel-control-prev-icon"></span>
				</a>
				<a class="carousel-control-next" href="#demo" data-slide="next">
					<span class="carousel-control-next-icon"></span>
				</a>
			</div>
		<?php  } ?>
	</div>

	<div class="container">
		<div class="akasha-tabs style-01">
			<div class="tab-head">
				<ul class="tab-link equal-container " data-loop="1">
					<li class="active">
						<a class="" data-ajax="0" data-animate="" data-section="1547652725565-7e88bea3-ede2"
							data-id="330" href="#1547652725565-7e88bea3-ede2-5d80aefaa70e2">
							<span>MOST TRENDING</span>
						</a>
					</li>
				</ul>
			</div>
			<div class="tab-container">
				<div class="tab-panel active" id="1547652725565-7e88bea3-ede2-5d80aefaa70e2">
					<div class=" auto-clear equal-container better-height akasha-products">
						<ul class="row products columns-4">
							<?php
							// Do not fallback to most_trending — show blank if no products
							$products = isset($most_trending) ? $most_trending : array();
							include VIEWPATH . '_product_card_dynamic.php';
							?>
						</ul>
					</div>
					<div class="shop-all">
						<a target=" _blank" href="<?php echo site_url(); ?>categories">View All</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="section-001">
		<div class="container">
			<div class="akasha-heading style-01">
				<div class="heading-inner">
					<h3 class="title">
						SEASONAL FAVS</h3>

				</div>
			</div>
			<div class="akasha-blog style-02">
				<div class="blog-list-owl owl-slick equal-container better-height"
					data-slick="{&quot;arrows&quot;:false,&quot;slidesMargin&quot;:30,&quot;dots&quot;:true,&quot;infinite&quot;:false,&quot;speed&quot;:300,&quot;slidesToShow&quot;:3,&quot;rows&quot;:1}"
					data-responsive="[{&quot;breakpoint&quot;:480,&quot;settings&quot;:{&quot;slidesToShow&quot;:1,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:768,&quot;settings&quot;:{&quot;slidesToShow&quot;:1,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:992,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1500,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;30&quot;}}]">
					<article
						class="post-item post-grid rows-space-0 post-195 post type-post status-publish format-standard has-post-thumbnail hentry category-light category-table category-life-style tag-light tag-life-style">
						<div class="akasha-banner style-01 left-bottom">
							<div class="banner-inner">
								<figure class="banner-thumb">
									<img src="<?php echo site_url(); ?>assetsfe/klaks/3.jpg" class="attachment-full size-full" alt="img">
								</figure>
								<div class="banner-info ">
									<div class="banner-content">
										<div class="col-md-6">

											<ul class="tab-link equal-container " data-loop="1">
												<?php if (!empty($womens_categories) && is_array($womens_categories)):
													foreach ($womens_categories as $i => $c):
														$slug = !empty($c['slug']) ? $c['slug'] : (isset($c['subcategory_name']) ? $c['subcategory_name'] : 'wcat-' . $i);
														$label = !empty($c['subcategory_name']) ? $c['subcategory_name'] : (!empty($c['name']) ? $c['name'] : $slug);
												?>
														<li<?php if ($i == 0) echo ' class="active"'; ?>>
															<a class="<?php if ($i == 0) echo 'loaded'; ?>" data-ajax="0" data-animate="" data-section="<?php echo htmlspecialchars($slug); ?>" data-id="<?php echo isset($c['id']) ? intval($c['id']) : 0; ?>" href="#<?php echo htmlspecialchars($slug); ?>-tab">
																<span><?php echo htmlspecialchars($label); ?></span>
															</a>
															</li>
													<?php endforeach;
												endif; ?>
											</ul>
										</div>
										<div class="button-wrap">
										</div>
									</div>
								</div>
							</div>
						</div>
					</article>
					<article
						class="post-item post-grid rows-space-0 post-189 post type-post status-publish format-video has-post-thumbnail hentry category-table category-life-style tag-multi tag-life-style post_format-post-format-video">
						<div class="akasha-banner style-01 left-bottom">
							<div class="banner-inner">
								<figure class="banner-thumb">
									<img src="<?php echo site_url(); ?>assetsfe/klaks/3.jpg" class="attachment-full size-full" alt="img">
								</figure>
								<div class="banner-info ">
									<div class="banner-content">
										<div class="title-wrap">
											<h6 class="title">
												<a style="color:#ffffff" target=" _blank" href="#">T-SHIRTS</a>
											</h6>
										</div>
										<div class="button-wrap">
										</div>
									</div>
								</div>
							</div>
						</div>
					</article>
					<article
						class="post-item post-grid rows-space-0 post-186 post type-post status-publish format-standard has-post-thumbnail hentry category-light category-life-style tag-life-style">
						<div class="akasha-banner style-01 left-bottom">
							<div class="banner-inner">
								<figure class="banner-thumb">
									<img src="<?php echo site_url(); ?>assetsfe/klaks/3.jpg" class="attachment-full size-full" alt="img">
								</figure>
								<div class="banner-info ">
									<div class="banner-content">
										<div class="title-wrap">
											<h6 class="title">
												<a style="color:#ffffff" target=" _blank" href="#">JACKETS</a>
											</h6>
										</div>
										<div class="button-wrap">
										</div>
									</div>
								</div>
							</div>
						</div>
					</article>
					<article
						class="post-item post-grid rows-space-0 post-183 post type-post status-publish format-standard has-post-thumbnail hentry category-light category-fashion tag-light tag-multi">
						<div class="akasha-banner style-01 left-bottom">
							<div class="banner-inner">
								<figure class="banner-thumb">
									<img src="<?php echo site_url(); ?>assetsfe/klaks/3.jpg" class="attachment-full size-full" alt="img">
								</figure>
								<div class="banner-info ">
									<div class="banner-content">
										<div class="title-wrap">
											<h6 class="title">
												<a style="color:#ffffff" target=" _blank" href="#">CARGOS</a>
											</h6>
										</div>
										<div class="button-wrap">
										</div>
									</div>
								</div>
							</div>
						</div>
					</article>
				</div>
			</div>
		</div>
	</div>

	<div class="section-001">
		<div class="container ">
			<div class="akasha-tabs style-01 pt-5">
				<div class="tab-head">
					<div class="row">
						<div class="col-md-6 ">
							<div class="akasha-heading style-01">
								<div class="heading-inner">
									<h3 class="title">Men's Collection</h3>
								</div>
							</div>
						</div>
						<div class="col-md-6">

							<ul class="tab-link equal-container " data-loop="1">
								<?php if (!empty($mens_categories) && is_array($mens_categories)):
									foreach ($mens_categories as $i => $c):
										$slug = !empty($c['slug']) ? $c['slug'] : (isset($c['subcategory_name']) ? $c['subcategory_name'] : 'cat-' . $i);
										$label = !empty($c['subcategory_name']) ? $c['subcategory_name'] : (!empty($c['name']) ? $c['name'] : $slug);
								?>
										<li<?php if ($i == 0) echo ' class="active"'; ?>>
											<a class="<?php if ($i == 0) echo 'loaded'; ?>" data-ajax="0" data-animate="" data-section="<?php echo htmlspecialchars($slug); ?>" data-id="<?php echo isset($c['id']) ? intval($c['id']) : 0; ?>" href="#<?php echo htmlspecialchars($slug); ?>-tab">
												<span><?php echo htmlspecialchars($label); ?></span>
											</a>
											</li>
									<?php endforeach;
								endif; ?>
							</ul>
						</div>
					</div>
				</div>

				<div class="tab-container">
					<?php if (!empty($mens_categories) && is_array($mens_categories)):
						foreach ($mens_categories as $i => $c):
							$slug = !empty($c['slug']) ? $c['slug'] : (isset($c['subcategory_name']) ? $c['subcategory_name'] : 'cat-' . $i);
							$label = !empty($c['subcategory_name']) ? $c['subcategory_name'] : (!empty($c['name']) ? $c['name'] : $slug);
					?>
							<div class="tab-panel<?php if ($i == 0) echo ' active'; ?>" id="<?php echo htmlspecialchars($slug); ?>-tab">

								<div class=" auto-clear equal-container better-height akasha-products">
									<ul class="row products columns-4">
										<?php
										// Lookup products by slug only; show empty if not present
										$products = isset($mens_products[$slug]) ? $mens_products[$slug] : array();
										include VIEWPATH . '_product_card_dynamic.php';
										?>
									</ul>
								</div>

								<div class="shop-all">
									<a target=" _blank" href="<?php echo site_url('products/men'); ?>">View All</a>
								</div>

							</div>
					<?php endforeach;
					endif; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="section-001">
		<div class="container ">
			<div class="akasha-tabs style-01 pt-5">
				<div class="tab-head">
					<div class="row">
						<div class="col-md-6 ">
							<div class="akasha-heading style-01">
								<div class="heading-inner">
									<h3 class="title">Women's Collection</h3>
								</div>
							</div>
						</div>
						<div class="col-md-6">

							<ul class="tab-link equal-container " data-loop="1">
								<li class="active">
									<a class="loaded" data-ajax="0" data-animate="" data-section="w-shirts" data-id="330"
										href="#w-shirts-tab">
										<span>Tops</span>
									</a>
								</li>

								<li class="">
									<a class="" data-ajax="0" data-animate="" data-section="w-T-SHIRTS" data-id="330"
										href="#w-T-SHIRTS-tab">
										<span>T - SHIRTS</span>
									</a>
								</li>

								<li class="">
									<a class="" data-ajax="0" data-animate="" data-section="w-JEANS" data-id="330"
										href="#w-JEANS-tab">
										<span>Hoddies</span>
									</a>
								</li>

							</ul>

						</div>
					</div>

				</div>
				<div class="tab-container">

					<?php if (!empty($womens_categories) && is_array($womens_categories)):
						foreach ($womens_categories as $i => $c):
							$slug = !empty($c['slug']) ? $c['slug'] : (isset($c['subcategory_name']) ? $c['subcategory_name'] : 'wcat-' . $i);
							$label = !empty($c['subcategory_name']) ? $c['subcategory_name'] : (!empty($c['name']) ? $c['name'] : $slug);
					?>
							<div class="tab-panel<?php if ($i == 0) echo ' active'; ?>" id="<?php echo htmlspecialchars($slug); ?>-tab">
								<div class=" auto-clear equal-container better-height akasha-products">
									<ul class="row products columns-4">
										<?php
										$products = isset($womens_products[$slug]) ? $womens_products[$slug] : array();
										include VIEWPATH . '_product_card_dynamic.php';
										?>
									</ul>
								</div>

								<div class="shop-all">
									<a target=" _blank" href="<?php echo site_url('products/women'); ?>">View All</a>
								</div>
							</div>
					<?php endforeach;
					endif; ?>

				</div>
			</div>
		</div>
	</div>

	<div class="section-001">
		<div class="container ">
			<div class="akasha-tabs style-01 pt-5">
				<div class="tab-head">
					<div class="row">
						<div class="col-md-6 ">
							<div class="akasha-heading style-01">
								<div class="heading-inner">
									<h3 class="title">Accessories</h3>
								</div>
							</div>
						</div>
						<div class="col-md-6">

							<ul class="tab-link equal-container " data-loop="1">
								<?php if (!empty($accessories_categories) && is_array($accessories_categories)):
									foreach ($accessories_categories as $i => $c):
										$slug = !empty($c['slug']) ? $c['slug'] : (isset($c['subcategory_name']) ? $c['subcategory_name'] : 'acat-' . $i);
										$label = !empty($c['subcategory_name']) ? $c['subcategory_name'] : (!empty($c['name']) ? $c['name'] : $slug);
								?>
										<li<?php if ($i == 0) echo ' class="active"'; ?>>
											<a class="<?php if ($i == 0) echo 'loaded'; ?>" data-ajax="0" data-animate="" data-section="<?php echo htmlspecialchars($slug); ?>" data-id="<?php echo isset($c['id']) ? intval($c['id']) : 0; ?>" href="#<?php echo htmlspecialchars($slug); ?>-tab">
												<span><?php echo htmlspecialchars($label); ?></span>
											</a>
											</li>
									<?php endforeach;
								endif; ?>
							</ul>
						</div>
					</div>
				</div>

				<div class="tab-container">
					<?php if (!empty($accessories_categories) && is_array($accessories_categories)):
						foreach ($accessories_categories as $i => $c):
							$slug = !empty($c['slug']) ? $c['slug'] : (isset($c['subcategory_name']) ? $c['subcategory_name'] : 'acat-' . $i);
							$label = !empty($c['subcategory_name']) ? $c['subcategory_name'] : (!empty($c['name']) ? $c['name'] : $slug);
					?>
							<div class="tab-panel<?php if ($i == 0) echo ' active'; ?>" id="<?php echo htmlspecialchars($slug); ?>-tab">

								<div class=" auto-clear equal-container better-height akasha-products">
									<ul class="row products columns-4">
										<?php
										// Lookup products by slug only; show empty if not present
										$products = isset($accessories_products[$slug]) ? $accessories_products[$slug] : array();
										include VIEWPATH . '_product_card_dynamic.php';
										?>
									</ul>
								</div>

								<div class="shop-all">
									<a target=" _blank" href="<?php echo site_url('products/accessories'); ?>">View All</a>
								</div>

							</div>
					<?php endforeach;
					endif; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="section-001">
		<div class="container ">
			<div class="akasha-tabs style-01 pt-5">
				<div class="tab-head">
					<div class="row">
						<div class="col-md-6 ">
							<div class="akasha-heading style-01">
								<div class="heading-inner">
									<h3 class="title">Recently Viewed</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-container">
					<div class="tab-panel active" id="RECENTLY-tab">
						<div class=" auto-clear equal-container better-height akasha-products">
							<ul class="row products columns-4">
								<?php
								// Do not fallback to most_trending — show blank if no recently viewed
								$products = array();
								include VIEWPATH . '_product_card_dynamic.php';
								?>
							</ul>
						</div>
						<div class="shop-all">
							<a target=" _blank" href="<?php echo site_url(); ?>categories">View All</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>