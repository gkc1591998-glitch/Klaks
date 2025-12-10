<?php
// Load color helper for better color management
if (!function_exists('get_best_color_match')) {
    $this->load->helper('color');
}
?>
<div class="single-thumb-vertical main-container shop-page no-sidebar">
        <div class="container">
            <div class="row">
                <div class="main-content col-md-12">
                    <div class="akasha-notices-wrapper"></div>
                    <div id="product-27"
                        class="post-27 product type-product status-publish has-post-thumbnail product_cat-table product_cat-new-arrivals product_cat-lamp product_tag-table product_tag-sock first instock shipping-taxable purchasable product-type-variable has-default-attributes">
                        <div class="main-contain-summary">
                            <div class="contain-left has-gallery">
                                <div class="single-left">
                                   
                                    <div class="share-button">
                                        <a href="#" >
                                            <i class="fa fa-share-alt" style="font-size: 18px;"></i>
                                        </a>
                                    </div>
                                    <div class="akasha-product-gallery akasha-product-gallery--with-images akasha-product-gallery--columns-4 images">
                                        <a href="#" class="akasha-product-gallery__trigger"></a>
                                        <div class="flex-viewport">
                                            <figure class="akasha-product-gallery__wrapper">
                                                <?php if (!empty($attributes)): ?>
                                                    <?php foreach ($attributes as $idx => $attr): ?>
                                                        <div class="akasha-product-gallery__image">
                                                            <img alt="<?php echo htmlspecialchars($attr['image']); ?>" src="<?php echo site_url('images/products/' . $attr['image']); ?>">
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                                <?php /*if (!empty($product['video'])): ?>
                                                    <div class="akasha-product-gallery__image">
                                                        <div class="video-container">
                                                            <video id="video" class="product-video" controls>
                                                                <source src="<?php echo site_url('images/products/' . $product['video']); ?>" type="video/mp4">
                                                                Your browser does not support HTML video.
                                                            </video>
                                                            <div class="video-overlay" id="overlay">
                                                                <div class="play-icon"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; */?>
                                            </figure>
                                        </div>
                                        <!-- <ol style="display: none;"  class="flex-control-nav flex-control-thumbs">
                                             <?php if (!empty($attributes)): ?>
                                                <?php foreach ($attributes as $idx => $attr): ?>
                                                    <li><img alt="<?php echo htmlspecialchars($attr['image']); ?>" src="<?php echo site_url('images/products/' . $attr['image']); ?>">
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </ol> -->
                                        <!-- <div class="flex-viewport">
                                            <figure class="akasha-product-gallery__wrapper">
                                                <div class="akasha-product-gallery__image">
                                                    <img alt="img" src="<?php echo site_url(); ?>assetsfe/klaks/1.jpg">
                                                </div>
                                                <div class="akasha-product-gallery__image">
                                                    <img src="<?php echo site_url(); ?>assetsfe/klaks/2.jpg">
                                                </div>
                                                <div class="akasha-product-gallery__image">
                                                    <img src="<?php echo site_url(); ?>assetsfe/klaks/1.jpg">
                                                </div>
                                                <div class="akasha-product-gallery__image">
                                                    <img src="<?php echo site_url(); ?>assetsfe/klaks/2.jpg">
                                                </div>
                                                <div class="akasha-product-gallery__image">
                                                    <div class="video-container">
                                                        <video id="video" class="product-video" controls>
                                                            <source src="<?php echo site_url() ?>assetsfe/demo-video.mp4" type="video/mp4">
                                                            Your browser does not support HTML video.
                                                        </video>
                                                        <div class="video-overlay" id="overlay">
                                                            <div class="play-icon"></div>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </figure>
                                        </div>
                                        <ol style="display: none;"  class="flex-control-nav flex-control-thumbs">
                                            <li><img src="<?php echo site_url() ?>assetsfe/klaks/1.jpg">
                                            </li>
                                            <li><img src="<?php echo site_url() ?>assetsfe/klaks/2.jpg">
                                            </li>
                                            <li><img src="<?php echo site_url() ?>assetsfe/klaks/1.jpg">
                                            </li>
                                            <li><img src="<?php echo site_url() ?>assetsfe/klaks/2.jpg">
                                            </li>
                                            <li><img src="<?php echo site_url() ?>assetsfe/video-thumb.png">
                                            </li>
                                        </ol> -->
                                    </div>
                                </div>
                                <div class="summary entry-summary">
                                    <h1 class="product_title entry-title" id="active-product-title"><?php echo (stripslashes(str_replace('\n','',$product_view['title']))); ?></h1>
                                        <span class="price">
                                            <span class="akasha-Price-amount amount">
												<?php
													if (!empty($attributes)) {
														$first = true;
														foreach ($attributes as $attr) {
															$color = htmlspecialchars($attr['color_name']);
															$price = isset($attr['price_name']) ? htmlspecialchars($attr['price_name']) : '';
															$variant_id = isset($attr['id']) ? htmlspecialchars($attr['id']) : '';
															if ($price !== '') {
																$display = $first ? 'block' : 'none';
																$activeClass = $first ? ' active-price' : '';
																echo '<p class="price-value ' . $color . $activeClass . '" data-variant-id="' . $variant_id . '" style="padding-left: 10px; display: ' . $display . ';">₹ ' . $price . ' <span class="d-none">' . $variant_id . '</span></p>';
																$first = false;
															}
														}
													}
												?>
                                            </span>
                                        </span>       
                                        
                                        <div class="d-flex d-flex justify-content-between">
                                            <div>
                                                <h6 >Colors</h6>
                                                <div class="color-option pb-2">
                                                    <div class="circles">
                                                        <?php if (!empty($attributes)): ?>
                                                            <?php foreach ($attributes as $attr):?>
                                                                <?php 
                                                                // Use enhanced color matching from helper
                                                                $colorMatch = get_best_color_match($attr['color_name']);
                                                                $cssColor = $colorMatch['css_color'];
                                                                $displayName = $colorMatch['display_name'];
                                                                ?>
                                                                <span 
                                                                    class="circle <?php echo htmlspecialchars(strtolower($attr['color_name'])); ?> active"
                                                                    style="background: <?php echo htmlspecialchars($cssColor); ?>;"
                                                                    title="<?php echo htmlspecialchars($displayName); ?>"
                                                                    data-variant-id="<?php echo htmlspecialchars($attr['id']); ?>">
                                                                </span>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                       <div class="field-error color-error" style="color:#c00;display:none;margin-top:6px;font-size:13px;"></div>
                                                </div>
                                            </div>
                                            <div >
                                                <h6 class="mb-2">User Rating</h6>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <span class="text-warning fs-4">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fa fa-star-half-alt"></i>
                                                    </span>
                                                    <span class="ms-2 fs-5">4.5 out of 5</span>
                                                </div>
                                            </div>
                                        </div>

                                    <div class="dreamingsb-wrap dreamingsb-bundled">
                                        <div class="dreamingsb-products" data-discount="10" data-discount-amount="0"
                                            data-fixed-price="no" data-variables="no" data-optional="no" data-min="1"
                                            data-max="">
                                            <div class="accordion-container">
                                                <div class="accordion-section">
                                                    <div class="accordion-header">
                                                        <h3>OFFERS</h3>
                                                        <span class="accordion-icon">+</span>
                                                    </div>
                                                    <div class="accordion-content">
                    
                                                        <div class="dreamingsb-product" data-id="30" data-price="60" data-qty="1">

                                                            <div class="dreamingsb-title">
                                                                <div class="dreamingsb-title-inner"> <a href="#">Flat 10% off on
                                                                        first app purchase</a></div>
                                                            </div>
                                                            <div class="dreamingsb-price">
                                                                <div class="dreamingsb-price-ori">
                                                                    <span class="akasha-Price-amount amount"><span
                                                                            class="akasha-Price-currencySymbol">&#x2617; </span>
                                                                        CODE : APP10</span>
                                                                </div>
                                                                <div class="dreamingsb-price-new"></div>
                                                            </div>
                                                        </div>
                                                        <div class="dreamingsb-product" data-id="35" data-price="134" data-qty="1">
            
                                                            <div class="dreamingsb-title">
                                                                <div class="dreamingsb-title-inner"> <a href="#">Flat 10% off on
                                                                        minimum purchase of ₹1999</a></div>
                                                            </div>
                                                            <div class="dreamingsb-price">
                                                                <div class="dreamingsb-price-ori">
                                                                    <span class="akasha-Price-amount amount"><span
                                                                            class="akasha-Price-currencySymbol">&#x2617; </span>
                                                                        CODE : FLAT10</span>
                                                                </div>
                                                                <div class="dreamingsb-price-new"></div>
                                                            </div>
                                                        </div>
                                                        <div class="dreamingsb-product" data-id="29" data-price="129" data-qty="1">
            
                                                            <div class="dreamingsb-title">
                                                                <div class="dreamingsb-title-inner"> <a href="#">Flat 15% off on
                                                                        minimum purchase of ₹2999</a></div>
                                                            </div>
                                                            <div class="dreamingsb-price">
                                                                <div class="dreamingsb-price-ori">
                                                                    <span class="akasha-Price-amount amount"><span
                                                                            class="akasha-Price-currencySymbol">&#x2617; </span>
                                                                        CODE : FLAT15</span>
                                                                </div>
                                                                <div class="dreamingsb-price-new"></div>
                                                            </div>
                                                        </div>
                                                        <div class="dreamingsb-product" data-id="29" data-price="129" data-qty="1">
            
                                                            <div class="dreamingsb-title">
                                                                <div class="dreamingsb-title-inner"> <a href="#">Flat 20% off on
                                                                        minimum purchase of ₹4599</a></div>
                                                            </div>
                                                            <div class="dreamingsb-price">
                                                                <div class="dreamingsb-price-ori">
                                                                    <span class="akasha-Price-amount amount"><span
                                                                            class="akasha-Price-currencySymbol">&#x2617; </span>
                                                                        CODE : FLAT20</span>
                                                                </div>
                                                                <div class="dreamingsb-price-new"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="variations">
                                        <tbody>
                                            <tr>
                                                <td class="label"><label>SIZE</label></td>
                                                <td class="value">
                                                    <div class="btn-group btn-group-sm">
                                                        <!-- <button type="button" class=" btn btn-dark size-btn" data-size="M">M</button>
                                                        <button type="button" class=" btn btn-outline-dark size-btn" data-size="L">L</button>
                                                        <button type="button" class=" btn btn-outline-dark size-btn" disabled data-size="XL">XL</button>
                                                        <button type="button" class=" btn btn-outline-dark size-btn" data-size="2XL">2XL</button>
                                                        <button type="button" class=" btn btn-outline-dark size-btn" data-size="3XL">3XL</button> -->
                                                        <?php
                                                        // Collect all unique sizes from $attributes, mapping size_name to variant_id(s)
                                                        $sizes = [];
                                                        if (!empty($attributes)) {
                                                            foreach ($attributes as $attr) {
                                                                if (!empty($attr['size_name']) && !empty($attr['id'])) {
                                                                    $size = $attr['size_name'];
                                                                    $variant_id = $attr['id'];
                                                                    // If multiple variant_ids per size, store as array
                                                                    if (!isset($sizes[$size])) {
                                                                        $sizes[$size] = [];
                                                                    }
                                                                    $sizes[$size][] = $variant_id;
                                                                }
                                                            }
                                                        }

                                                        // Define all possible sizes (customize as needed)
                                                        $all_sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL'];

                                                        foreach ($all_sizes as $size) {
                                                            $enabled = isset($sizes[$size]);
                                                            // Use the first variant_id for this size (if multiple, you can adjust as needed)
                                                            $variant_id = $enabled ? htmlspecialchars($sizes[$size][0]) : '';
                                                            ?>
                                                            <button type="button"
                                                                class="btn btn-outline-dark size-btn<?php echo $enabled ? '' : ' disabled'; ?>"
                                                                data-size="<?php echo htmlspecialchars($size); ?>"
                                                                <?php echo $enabled ? 'data-variant-id="' . $variant_id . '"' : 'disabled'; ?>>
                                                                <?php echo htmlspecialchars($size); ?>
                                                            </button>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                        <div class="field-error size-error" style="color: #c00; display: none; margin-top:6px; font-size:13px;"></div>
                                                    <a class="reset_variations" href="#"
                                                        style="visibility: hidden;">Clear</a>
                                                </td>
                                            </tr>
                                            
                                            <tr>                                                
                                                <td class="">
                                                    <div class="accordion-container">
                                                        <div class="accordion-section">
                                                            <div class="accordion-header">
                                                                <h3>SIZE CHART</h3>
                                                                <span class="accordion-icon">+</span>
                                                            </div>
                                                            <div class="accordion-content">
                                                                <img style="width: 100%;" src="<?php echo site_url();?>assetsfe/img/sizechart.webp">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <form class="variations_form cart">
                                        <div class="single_variation_wrap">
                                            <div class="akasha-variation single_variation"></div>
                                            <div
                                                class="akasha-variation-add-to-cart variations_button">
                                                <div class="quantity">
                                                    <span class="qty-label">Quantiy:</span>
                                                    <div class="control">
                                                        <a class="btn-number qtyminus quantity-minus" href="#">-</a>
                                                        <input type="text" data-step="1" min="1" max="10"
                                                            name="quantity" value="1" title="Qty"
                                                            class="input-qty input-text qty text" size="4"
                                                            pattern="[0-9]*" inputmode="numeric">
                                                        <a class="btn-number qtyplus quantity-plus" href="#">+</a>
                                                    </div>
                                                </div>
                                                <button type="submit"
                                                    class="single_add_to_cart_button button alt akasha-variation-selection-needed">
                                                    Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <div class="yith-wcwl-add-to-wishlist">
                                        <div class="yith-wcwl-add-button show">
                                            <a href="#" class=""><i class="flaticon-rocket-ship"></i>
                                                Delivery</a>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <a href="#" class="compare button" data-product_id="27" rel="nofollow">Share</a>
                                    <div class="product_meta">
                                        <div class="wcml-dropdown product wcml_currency_switcher">
                                            <ul>
                                                <li class="wcml-cs-active-currency">
                                                    <a class="wcml-cs-item-toggle">USD</a>
                                                    <ul class="wcml-cs-submenu">
                                                        <li>
                                                            <a>EUR</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                        <span class="sku_wrapper">SKU: <span class="sku">885B712</span></span>
                                        <span class="posted_in">Categories: 
                                            <a href="#" rel="tag">New arrivals</a>, 
                                            <a href="#" rel="tag">Summer Sale</a>
                                        </span>
                                    </div>
                                    <div class="akasha-share-socials">
                                        <h5 class="social-heading">Share: </h5>
                                        <a target="_blank" class="facebook" href="#">
                                            <i class="fa fa-facebook-f"></i>
                                        </a>
                                        <a target="_blank" class="twitter" href="#"><i class="fa fa-twitter"></i>
                                        </a>
                                        <a target="_blank" class="pinterest" href="#"> <i class="fa fa-pinterest"></i>
                                        </a>
                                        <a target="_blank" class="googleplus" href="#"><i class="fa fa-google-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                        <div class="accordion-container">
                            <div class="accordion-section">
                                <div class="accordion-header">
                                    <h3>DESCRIPTION</h3>
                                    <span class="accordion-icon">+</span>
                                </div>
                                <div class="accordion-content">

                                    <div class="container-table">
                                        <div class="container-cell">

                                            <p>The Xian Green Shirt is the perfect summer wear option. Crafted from a
                                                light weight fabric, it provides comfort and breathability. The half
                                                sleeves keep you cool, allowing for optimal performance and mobility.
                                            </p>
                                            <ul>
                                                <li>Short Sleeves</li>
                                                <li>Printed Design</li>
                                                <li>Spread Collar</li>
                                                <li>Curved Hem Design</li>
                                                <li>Spare Buttons Included</li>
                                            </ul>
                                        </div>
                                        <div class="container-cell">
                                            <ul>

                                                <li><b>FABRIC: </b>100% Rayon</li>
                                                <li><b>FIT: </b>Slim Fit</li>
                                                <li><b>SIZE: </b>Model is wearing a M size</li>
                                                <li><b>Model Height: </b>6 Feet</li>
                                                <li><b>WASH CARE: </b>Cold machine wash. For more details see the wash
                                                    care label attached.</li>

                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="accordion-section">
                                <div class="accordion-header">
                                    <h3>ADDITIONAL INFORMATION</h3>
                                    <span class="accordion-icon">+</span>
                                </div>
                                <div class="accordion-content">

                                    <p><b>
                                            Manufactured & Marketed by:
                                        </b></p>
                                    <table class="shop_attributes">
                                        <tbody>
                                            <tr>
                                                <th>Snitch Apparels Pvt. Ltd.</th>
                                                <td>
                                                    <p>No. 1/1, St. Johns Church Road, Bharathinagar, Bengaluru - 560005
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Country of Origin:</th>
                                                <td>
                                                    <p>India</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="accordion-section">
                                <div class="accordion-header">
                                    <h3>REVIEWS</h3>
                                    <span class="accordion-icon">+</span>
                                </div>
                                <div class="accordion-content">
                                    <div id="comments">
                                        <h2 class="akasha-Reviews-title">Reviews</h2>
                                        <p class="akasha-noreviews">There are no reviews yet.</p>
                                    </div>
                                    <div id="review_form_wrapper">
                                        <div id="review_form">
                                            <div id="respond" class="comment-respond">
                                                <span id="reply-title" class="comment-reply-title">Be the first to
                                                    review “T-shirt with skirt”</span>
                                                <form id="commentform" class="comment-form">
                                                    <p class="comment-notes"><span id="email-notes">Your email adchair
                                                            will not be published.</span>
                                                        Required fields are marked <span class="required">*</span></p>
                                                    <p class="comment-form-author">
                                                        <label for="author">Name&nbsp;<span
                                                                class="required">*</span></label>
                                                        <input id="author" name="author" value="" size="30" required=""
                                                            type="text">
                                                    </p>
                                                    <p class="comment-form-email"><label for="email">Email&nbsp;
                                                            <span class="required">*</span></label>
                                                        <input id="email" name="email" value="" size="30" required=""
                                                            type="email">
                                                    </p>
                                                    <div class="comment-form-rating"><label for="rating">Your
                                                            rating</label>
                                                        <p class="stars">
                                                            <span>
                                                                <a class="star-1" href="#">1</a>
                                                                <a class="star-2" href="#">2</a>
                                                                <a class="star-3" href="#">3</a>
                                                                <a class="star-4" href="#">4</a>
                                                                <a class="star-5" href="#">5</a>
                                                            </span>
                                                        </p>
                                                        <select title="product_cat" name="rating" id="rating"
                                                            required="" style="display: none;">
                                                            <option value="">Rate…</option>
                                                            <option value="5">Perfect</option>
                                                            <option value="4">Good</option>
                                                            <option value="3">Average</option>
                                                            <option value="2">Not that bad</option>
                                                            <option value="1">Very poor</option>
                                                        </select>
                                                    </div>
                                                    <p class="comment-form-comment"><label for="comment">Your
                                                            review&nbsp;<span class="required">*</span></label><textarea
                                                            id="comment" name="comment" cols="45" rows="8"
                                                            required=""></textarea></p><input name="wpml_language_code"
                                                        value="en" type="hidden">
                                                    <p class="form-submit"><input name="submit" id="submit"
                                                            class="submit" value="Submit" type="submit"> <input
                                                            name="comment_post_ID" value="27" id="comment_post_ID"
                                                            type="hidden">
                                                        <input name="comment_parent" id="comment_parent" value="0"
                                                            type="hidden">
                                                    </p>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                
                <!-- <div class="col-md-12 col-sm-12 dreaming_related-product">
                    <div class="block-title">
                        <h2 class="product-grid-title">
                            <span>Related Products</span>
                        </h2>
                    </div>
                    <div class=" auto-clear equal-container better-height akasha-products">
                        <ul class="row products columns-4">
                            <li class="product-item wow fadeInUp product-item rows-space-30 col-bg-4 col-xl-3 col-lg-6 col-md-6 col-sm-6 col-ts-6 style-01 post-24 product type-product status-publish has-post-thumbnail product_cat-chair product_cat-table product_cat-new-arrivals product_tag-light product_tag-hat product_tag-sock first instock featured shipping-taxable purchasable product-type-variable has-default-attributes"
                                data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
                                <div class="product-inner tooltip-right">
                                    <div class="product-thumb">


                                        <div id="demo1" class="carousel slide" data-ride="carousel"
                                            data-interval="2500" data-pause="hover" data-direction="right">
                                            <div class="carousel-inner">

                                                <div id="blue" class="carousel-item blue active"
                                                    style="transition: transform 0.6s ease-in-out;">
                                                    <img src="<?php echo site_url();?>assetsfe/klaks/2.jpg" alt="Blue product"
                                                        onclick="window.location.href='product-details.html';"
                                                        style="cursor: pointer;">

                                                </div>
                                                <div id="pink" class="carousel-item pink"
                                                    style="transition: transform 0.6s ease-in-out;">
                                                    <img onclick="window.location.href='product-details.html';"
                                                        src="<?php echo site_url();?>assetsfe/img/product-gray.jpg">
                                                </div>
                                                <div id="yellow" class="carousel-item yellow"
                                                    style="transition: transform 0.6s ease-in-out;">
                                                    <img onclick="window.location.href='product-details.html';"
                                                        src="<?php echo site_url();?>assetsfe/img/product-yellow.jpg"
                                                        alt="Yellow product">
                                                </div>

                                                <div id="black" class="carousel-item black"
                                                    style="transition: transform 0.6s ease-in-out;">
                                                    <img onclick="window.location.href='product-details.html';"
                                                        src="<?php echo site_url();?>assetsfe/img/product-black.jpg" alt="Black product">
                                                </div>
                                                <div id="gray" class="carousel-item gray"
                                                    style="transition: transform 0.6s ease-in-out;">
                                                    <img onclick="window.location.href='product-details.html';"
                                                        src="<?php echo site_url();?>assetsfe/img/product-gray.jpg" alt="Gray product">
                                                </div>
                                                <div class="carousel-item" style="transition: transform 0.6s ease-in-out;">
                                                    

                                                    <div class="video-container">
                                                        <video id="video" height="360" width="100%" controls>
                                                            <source src="<?php echo site_url();?>assetsfe/demo-video.mp4" type="video/mp4">
                                                            Your browser does not support HTML video.
                                                        </video>
                                                        <div class="video-overlay" id="overlay">
                                                            <div class="play-icon"></div>
                                                        </div>
                                                    </div> 

                                                </div>

                                            </div>


                                            <a class="carousel-control-prev" href="#demo1" data-slide="prev">
                                                <span class="carousel-control-prev-icon"></span>
                                            </a>
                                            <a class="carousel-control-next" href="#demo1" data-slide="next">
                                                <span class="carousel-control-next-icon"></span>
                                            </a>
                                        </div>




                                        <div class="flash">

                                            <span class="onnew"><span class="text">New</span></span>
                                        </div>
                                        <div class="group-button">
                                            <div class="yith-wcwl-add-to-wishlist">
                                                <div class="yith-wcwl-add-button show">
                                                    <a href="#" class="add_to_wishlist" data-product-id="<?php echo $product_view['id']; ?>">Add to Wishlist</a>
                                                </div>
                                            </div>
                                            

                                            <div class="akasha product compare-button">
                                                <a href="#" class="compare button">Compare</a>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="product-info equal-elem">

                                        <div class="color-option pb-2">
                                            <div class="circles">
                                                <span class="circle blue active" id="blue"></span>
                                                <span class="circle pink" id="pink"></span>
                                                <span class="circle yellow" id="yellow"></span>
                                                <span class="circle gray" id="gray"></span>
                                                <span class="circle black" id="black"></span>
                                            </div>
                                        </div>


                                        <h3 class="product-name product_title">
                                            <a href="#">Rever Neck</a>
                                        </h3>
                                        <div class="rating-wapper nostar">

                                            <span style="width:0%"><a href="#" tabindex="0">XS </a></span><span style="width:0%"><a href="#">S </a></span><span
                                                style="width:0%"><a href="#">M </a> </span><span
                                                style="width:0%"><a href="#">L </a>
                                            </span><span style="width:0%"><a href="#">XL </a> </span><span
                                                style="width:0%"><a href="#">2XL </a> </span><span
                                                style="width:0%"><a href="#">3XL </a> </span>

                                        </div>
                                        <span class="price">
                                            <span class="akasha-Price-amount amount">
                                                INR
                                                <span class="akasha-Price-currencySymbol blue"
                                                    style="padding-left: 10px;">₹
                                                    109.00
                                                </span>
                                                <span class="akasha-Price-currencySymbol pink"
                                                    style="padding-left: 10px;">₹
                                                    69.00
                                                </span>
                                                <span class="akasha-Price-currencySymbol yellow"
                                                    style="padding-left: 10px;">₹
                                                    139.00
                                                </span>
                                                <span class="akasha-Price-currencySymbol gray"
                                                    style="padding-left: 10px;">₹
                                                    119.00
                                                </span>
                                                <span class="akasha-Price-currencySymbol black"
                                                    style="padding-left: 10px;">₹
                                                    129.00
                                                </span>

                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="shop-all">
                        <a target=" _blank" href="products.html">View All</a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <div id="add-to-cart-error" style="color: red; margin-bottom: 10px; display: none;"></div>
    <script>
        var attributes = <?php echo json_encode($attributes); ?>;
        var selectedVariantId = attributes[0] ? attributes[0].id : null;
        var selectedQty = 1;
        // Helper to find attribute by variant_id
        function findAttributeById(id) {
            return attributes.find(function(attr) {
                return String(attr.id) === String(id);
            });
        }
        // Listen for size/circle/qty changes to update selectedVariantId/selectedQty
        document.addEventListener('DOMContentLoaded', function() {
            var colorErrorEl = document.querySelector('.color-error');
            var sizeErrorEl = document.querySelector('.size-error');

            // helpers to show/hide simple field errors
            function showColorError(msg){ if (colorErrorEl) { colorErrorEl.innerText = msg; colorErrorEl.style.display = 'block'; } }
            function clearColorError(){ if (colorErrorEl) { colorErrorEl.innerText = ''; colorErrorEl.style.display = 'none'; } }
            function showSizeError(msg){ if (sizeErrorEl) { sizeErrorEl.innerText = msg; sizeErrorEl.style.display = 'block'; } }
            function clearSizeError(){ if (sizeErrorEl) { sizeErrorEl.innerText = ''; sizeErrorEl.style.display = 'none'; } }

            document.querySelectorAll('.size-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    if (btn.classList.contains('disabled')) return;
                    selectedVariantId = btn.getAttribute('data-variant-id');
                    try { console.log('size clicked, data-size=', btn.getAttribute('data-size'), 'data-variant-id=', selectedVariantId); } catch(e){}
                    // clear size error when user selects
                    clearSizeError();
                });
            });
            document.querySelectorAll('.circle').forEach(function(circle) {
                circle.addEventListener('click', function() {
                    selectedVariantId = circle.getAttribute('data-variant-id');
                    try { console.log('color clicked, title=', circle.getAttribute('title'), 'data-variant-id=', selectedVariantId); } catch(e){}
                    // clear color error when user selects
                    clearColorError();
                });
            });
            document.querySelector('.input-qty')?.addEventListener('input', function(e) {
                selectedQty = this.value;
            });
            // Add to cart button click
            document.querySelector('.single_add_to_cart_button')?.addEventListener('click', function(e) {
                e.preventDefault();
                try { console.log('Add to cart clicked — selectedVariantId=', selectedVariantId); } catch(e){}
                // clear field-level errors first
                clearColorError(); clearSizeError();
                var errorDiv = document.getElementById('add-to-cart-error');
                if (errorDiv) { errorDiv.style.display = 'none'; errorDiv.innerText = ''; }
                var qty = document.querySelector('.input-qty')?.value || '';
                var name = document.querySelector('#active-product-title')?.innerText || '';
                var attr = findAttributeById(selectedVariantId);
                try { console.log('Resolved attribute for variant id:', selectedVariantId, attr); } catch(e){}
                // console.log('Selected attr:', attr);
                var size = attr?.size_name || '';
                var color = attr?.color_name || '';
                var price = attr?.price_name || '';
                var productId = attr?.product_id || '';
                var productInfoId = attr?.id || '';
                var variantId = attr?.id || '';
                var image = attr?.image || '';
                // Validation
                if (!qty || isNaN(qty) || parseInt(qty) < 1) {
                    try { console.log('Validation failed: invalid qty=', qty); } catch(e){}
                    if (errorDiv) { errorDiv.innerText = 'Please enter a valid quantity.'; errorDiv.style.display = 'block'; }
                    return;
                }
                if (!size) {
                    try { console.log('Validation failed: size not selected for variant id', selectedVariantId); } catch(e){}
                    showSizeError('Please select a size.');
                    return;
                }
                if (!color) {
                    try { console.log('Validation failed: color not selected for variant id', selectedVariantId); } catch(e){}
                    showColorError('Please select a color.');
                    return;
                }
                if (!price) {
                    try { console.log('Validation failed: price missing for attr', attr); } catch(e){}
                    if (errorDiv) { errorDiv.innerText = 'Price not available for this selection.'; errorDiv.style.display = 'block'; }
                    return;
                }

                const data = {
                    uniqueId,
                    qty,
                    size,
                    color,
                    price,
                    productInfoId,
                    productId,
                    image,
                    name
                };
                try { console.log('Sending AJAX add-to-cart with data:', data); } catch(e){}
                $.ajax({
                    url: '<?php echo site_url();?>cart/insertcart',
                    type: 'POST',
                    data,
                    success: function(response) {
                        try { console.log('Add to cart success, server response:', response); } catch(e){}
                        errorDiv.style.display = 'none';
                        try { $('#cartdivid').html(response); } catch(e) { console.warn('cart update failed', e); }
                        try {
                            // Update mobile cart count
                            if (window.updateMobileCartCount) {
                                // Extract cart count from response
                                var countMatch = response.match(/class="count">(\d+)<\/span>/);
                                var count = countMatch ? countMatch[1] : '0';
                                window.updateMobileCartCount(count);
                            }
                        } catch(e) { console.warn('Failed to update mobile cart count:', e); }
                        try { if (window.showToast) window.showToast('Added to cart', { type: 'success', timeout: 3000 }); } catch(e) { console.warn('toast failed', e); }
                    },
                    error: function(xhr, status, err) {
                        try { console.log('Add to cart AJAX error', status, err); } catch(e){}
                        console.log('Failed to add to cart');
                        errorDiv.innerText = 'Failed to add to cart. Please try again.';
                        errorDiv.style.display = 'block';
                    }
                });
            });
        });
    </script>
