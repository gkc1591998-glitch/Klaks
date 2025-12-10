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
        <div id="product-27" class="post-27 product type-product status-publish has-post-thumbnail product_cat-table product_cat-new-arrivals product_cat-lamp product_tag-table product_tag-sock first instock shipping-taxable purchasable product-type-variable has-default-attributes">
          <div class="main-contain-summary">
            <div class="contain-left has-gallery">
              <div class="single-left">
                <!-- <div class="share-button">
                  <a href="#" class="share-toggle" data-toggle="tooltip" title="Share">
                    <i class="fa fa-share-alt" style="font-size: 18px;"></i>
                  </a>
                </div> -->
                <div class="akasha-product-gallery akasha-product-gallery--with-images akasha-product-gallery--columns-4 images">
                  <a href="javascript:void(0)" class="akasha-product-gallery__trigger add_to_wishlist" 
                     data-product-id="<?php echo $product_view['id']; ?>"
                     data-product-more-info-id="<?php echo !empty($variants[0]['variant_id']) ? $variants[0]['variant_id'] : ''; ?>"
                     data-variant-id="<?php echo !empty($variants[0]['variant_id']) ? $variants[0]['variant_id'] : ''; ?>"
                     data-tooltip="Add to Wishlist">
                    ♡
                  </a>
                  <div class="flex-viewport">
                    <figure class="akasha-product-gallery__wrapper" id="variant-images">
                      <?php 
                      $first_color_images = !empty($variants_grouped_by_color[0]['images']) ? $variants_grouped_by_color[0]['images'] : (!empty($variants[0]['images']) ? $variants[0]['images'] : []);
                      $first_color_name = !empty($variants_grouped_by_color[0]['color_name']) ? $variants_grouped_by_color[0]['color_name'] : (!empty($variants[0]['color_name']) ? $variants[0]['color_name'] : 'default color');
                      if (!empty($first_color_images)): ?>
                        <?php foreach ($first_color_images as $idx => $img): ?>
                          <div class="akasha-product-gallery__image">
                            <img 
                              src="<?php echo site_url() ?>images/products/<?php echo htmlspecialchars($img); ?>"
                              alt="<?php echo htmlspecialchars($product_view['title'] . ' in ' . $first_color_name . ' color. Product image. Plain background. Neutral tone'); ?>">
                          </div>
                        <?php endforeach; ?>
                      <?php endif; ?>
                      <?php if (!empty($product_view['product_video'])): ?>
                        <div class="akasha-product-gallery__image">
                          <div class="video-container">
                            <video id="video" class="product-video" controls aria-label="<?php echo htmlspecialchars($product_view['title'] . ' product video. Controls available. Neutral tone'); ?>">
                              <source src="<?php echo site_url(); ?>images/videos/products/<?php echo htmlspecialchars($product_view['product_video']); ?>" type="video/mp4">
                              Your browser does not support HTML video.
                            </video>
                            <div class="video-overlay" id="overlay">
                              <div class="play-icon"></div>
                            </div>
                          </div>
                        </div>
                      <?php endif; ?>
                    </figure>
                    <ol style="display: none;" class="flex-control-nav flex-control-thumbs">
                      <?php 
                      $first_color_images = !empty($variants_grouped_by_color[0]['images']) ? $variants_grouped_by_color[0]['images'] : (!empty($variants[0]['images']) ? $variants[0]['images'] : []);
                      $first_color_name = !empty($variants_grouped_by_color[0]['color_name']) ? $variants_grouped_by_color[0]['color_name'] : (!empty($variants[0]['color_name']) ? $variants[0]['color_name'] : 'default color');
                      if (!empty($first_color_images)): ?>
                        <?php foreach ($first_color_images as $idx => $img): ?>
                          <li>
                            <img src="<?php echo site_url() ?>images/products/<?php echo htmlspecialchars($img); ?>" 
                                 alt="<?php echo htmlspecialchars($product_view['title'] . ' in ' . $first_color_name . ' color. Thumbnail view ' . ($idx + 1) . '.'); ?>">
                          </li>
                        <?php endforeach; ?>
                      <?php endif; ?>
                      <?php if (!empty($product_view['product_video'])): ?>
                        <li>
                          <img src="<?php echo site_url(); ?>assetsfe/img/video-thumb.png"
                               alt="<?php echo htmlspecialchars($product_view['title'] . ' product video thumbnail.'); ?>">
                        </li>
                      <?php endif; ?>
                    </ol>
                  </div>
                </div>
              </div>
              <div class="summary entry-summary">
                <h1 class="product_title entry-title" id="active-product-title"><?php echo (stripslashes(str_replace('\n', '', $product_view['title']))); ?></h1>
                <span class="price">
                  <span class="akasha-Price-amount amount" id="variant-price">
                    ₹ <?php echo !empty($variants_grouped_by_color[0]['sizes']) ? $variants_grouped_by_color[0]['sizes'][0]['price_name'] : '0'; ?>
                  </span>
                </span>

                <div class="d-flex d-flex justify-content-between">
                  <div>
                    <h6>Colors</h6>
                    <div class="color-option pb-2">
                      <div class="circles">
                        <?php 
                        $colorSequentialIndex = 0;
                        foreach ($variants_grouped_by_color as $colorId => $colorGroup): 
                        ?>
                          <?php
                          // Get first variant of this color for the swatch
                          $firstVariantId = !empty($colorGroup['variant_ids'][0]) ? $colorGroup['variant_ids'][0] : null;
                          // Find the first variant with images for this color
                          $swatchImg = '';
                          if (!empty($colorGroup['images'])) {
                            $swatchImg = $colorGroup['images'][0];
                          }
                          // Fallback to color
                          $colorMatch = get_best_color_match($colorGroup['color_name']);
                          $cssColor = $colorMatch['css_color'];
                          // Build inline style: use image if available, otherwise use color
                          $styleAttr = 'display:inline-block;width:50px;height:50px;border-radius:50%;margin-right:8px;vertical-align:middle;overflow:hidden;border:2px solid #eee;cursor:pointer;';
                          if ($swatchImg) {
                            $styleAttr .= 'background-image:url(' . site_url() . 'images/products/' . htmlspecialchars($swatchImg) . ');background-size:cover;background-position:center;';
                          } else {
                            $styleAttr .= 'background-color:' . htmlspecialchars($cssColor) . ';';
                          }
                          ?>
                          <span class="circle" data-color-index="<?php echo $colorSequentialIndex; ?>" title="<?php echo htmlspecialchars($colorGroup['color_name']); ?>" style="<?php echo $styleAttr; ?>"></span>
                        <?php 
                        $colorSequentialIndex++;
                        endforeach; 
                        ?>
                      </div>
                      <div id="color-validation-msg" class="size-validation-error" style="display: none; color: #e74c3c; font-size: 12px; margin-top: 8px;">
                        ⚠ Please select a color
                      </div>
                    </div>
                  </div>
                  <div>
                    <h6 class="mb-2">User Rating</h6>
                    <div class="d-flex align-items-center justify-content-center">
                      <span class="text-warning fs-4" id="variant-rating-stars"></span>
                      <span class="ms-2 fs-5" id="variant-rating-value"></span>
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
                    <?php
                    // Check if this is an accessory (One Size only)
                    $is_accessory = false;
                    $current_color_sizes = !empty($variants_grouped_by_color[0]['sizes']) ? $variants_grouped_by_color[0]['sizes'] : [];
                    if (count($current_color_sizes) == 1) {
                        $size_name = strtolower(trim($current_color_sizes[0]['size_name'] ?? ''));
                        $is_accessory = in_array($size_name, ['one size', 'free size', 'onesize', 'freesize']);
                    }
                    ?>
                    
                    <?php if (!$is_accessory): ?>
                    <tr>
                      <td class="label"><label>SIZE</label></td>
                      <td class="value">
                        <div class="btn-group btn-group-sm" id="variant-sizes">
                          <?php
                          $all_sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL'];
                          // Use variants_grouped_by_color for proper size-price mapping
                          foreach ($all_sizes as $i => $size) {
                            // Find size in current color's sizes array
                            $size_data = null;
                            $size_index = null;
                            foreach ($current_color_sizes as $idx => $size_info) {
                              if ($size_info['size_name'] == $size) {
                                $size_data = $size_info;
                                $size_index = $idx;
                                break;
                              }
                            }
                            $enabled = $size_data !== null;
                            $price = $enabled ? htmlspecialchars($size_data['price_name']) : '';
                          ?>
                            <button type="button"
                              class="btn size-btn <?php echo $enabled ? 'btn-outline-dark' : 'btn-outline-dark disabled'; ?>"
                              data-size="<?php echo htmlspecialchars($size); ?>"
                              <?php echo $enabled ? 'data-price="' . $price . '" data-size-index="' . $size_index . '"' : 'disabled'; ?>>
                              <?php echo htmlspecialchars($size); ?>
                            </button>
                          <?php
                          }
                          ?>
                        </div>
                        <a class="reset_variations" href="#" style="visibility: hidden;">Clear</a>
                        <div id="size-validation-msg" class="size-validation-error" style="display: none; color: #e74c3c; font-size: 12px; margin-top: 8px;">
                          ⚠ Please select a size
                        </div>
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
                              <img style="width: 100%;" src="<?php echo site_url(); ?>assetsfe/img/sizechart.webp">
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <?php else: ?>
                    <tr style="display:none;">
                      <td class="label"></td>
                      <td class="value">
                        <!-- Auto-select One Size for accessories -->
                        <input type="hidden" id="auto-selected-size" 
                               data-size="<?php echo htmlspecialchars($current_color_sizes[0]['size_name']); ?>"
                               data-price="<?php echo htmlspecialchars($current_color_sizes[0]['price_name']); ?>"
                               data-size-index="0">
                      </td>
                    </tr>
                    <?php endif; ?>
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
                      <button type="button"
                        class="single_add_to_cart_button button alt akasha-variation-selection-needed">
                        Add to cart
                      </button>
                      <!-- <div id="add-to-cart-error" style="color: red; margin-top: 10px; margin-bottom: 10px; display: none;"></div> -->
                    </div>
                  </div>
                </form>

                <div class="clear"></div>
                <a href="#" class="compare button share-btn" data-product_id="27" rel="nofollow" onclick="event.preventDefault(); showShareDialog();">Share</a>
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
                  <span class="sku_wrapper">SKU: <span class="sku" id="variant-sku"></span></span>
                  <span class="posted_in">Tags: <span id="variant-tags"></span></span>
                </div>
                <div class="akasha-share-socials" id="shareContainer">
                  <h5 class="social-heading">Share: </h5>
                  <a href="#" class="share-icon facebook-share" title="Share on Facebook" onclick="event.preventDefault(); shareProduct('facebook');" target="_blank">
                    <i class="fa fa-facebook-f"></i>
                  </a>
                  <a href="#" class="share-icon twitter-share" title="Share on Twitter" onclick="event.preventDefault(); shareProduct('twitter');" target="_blank">
                    <i class="fa fa-twitter"></i>
                  </a>
                  <a href="#" class="share-icon linkedin-share" title="Share on LinkedIn" onclick="event.preventDefault(); shareProduct('linkedin');" target="_blank">
                    <i class="fa fa-linkedin"></i>
                  </a>
                  <a href="#" class="share-icon whatsapp-share" title="Share on WhatsApp" onclick="event.preventDefault(); shareProduct('whatsapp');" target="_blank">
                    <i class="fa fa-whatsapp"></i>
                  </a>
                  <a href="#" class="share-icon pinterest-share" title="Share on Pinterest" onclick="event.preventDefault(); shareProduct('pinterest');" target="_blank">
                    <i class="fa fa-pinterest"></i>
                  </a>
                  <a href="#" class="share-icon email-share" title="Share via Email" onclick="event.preventDefault(); shareProduct('email');" target="_blank">
                    <i class="fa fa-envelope"></i>
                  </a>
                  <a href="#" class="share-icon copy-link" title="Copy Link" onclick="event.preventDefault(); shareProduct('copy');">
                    <i class="fa fa-link"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        
        <!-- Product Description Accordion -->
        <div class="accordion-container">
          <div class="accordion-section">
            <div class="accordion-header">
              <h3>DESCRIPTION</h3>
              <span class="accordion-icon">+</span>
            </div>
            <div class="accordion-content">
              <div class="container-table">
                <div class="container-cell">
                  <p><?php echo nl2br(trim(preg_replace('/[\r\n]+/', ' ', strip_tags($product_view['content'])))); ?></p>
                </div>
                <div class="container-cell">
                  <p><?php echo nl2br(trim(preg_replace('/[\r\n]+/', ' ', strip_tags($product_view['additional_info'])))); ?></p>
                </div>
              </div>
            </div>
          </div>

          <!-- <div class="accordion-section">
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
                </div> -->

          <!-- REVIEWS & REVIEW FORM ACCORDION -->
          <div class="accordion-container">
            <!-- Reviews Display Section -->
            <div class="accordion-section">
              <div class="accordion-header">
                <h3>REVIEWS</h3>
                <span class="accordion-icon">+</span>
              </div>
              <div class="accordion-content">
                <div id="reviews-list" class="reviews-list">
                  <?php if (!empty($reviews) && is_array($reviews)): ?>
                    <?php foreach ($reviews as $r): ?>
                      <div class="single-review">
                        <div class="review-header">
                          <strong class="review-name"><?php echo htmlspecialchars($r['name']); ?></strong>
                          <span class="review-rating">★ <?php echo htmlspecialchars($r['rating']); ?>/5</span>
                        </div>
                        <span class="review-date"><?php echo htmlspecialchars($r['created_at']); ?></span>
                        <p class="review-comment"><?php echo nl2br(htmlspecialchars($r['comment'])); ?></p>
                      </div>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <p class="no-reviews">No reviews yet. Be the first to review this product!</p>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <!-- Review Form Section -->
            <div class="accordion-section">
              <div class="accordion-header">
                <h3>WRITE A REVIEW</h3>
                <span class="accordion-icon">+</span>
              </div>
              <div class="accordion-content">
                <form id="commentform" class="simple-review-form">
                  
                  <div class="form-row">
                    <div class="form-group">
                      <label for="author">Your Name *</label>
                      <input id="author" name="author" type="text" required placeholder="Enter your name">
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group">
                      <label for="email">Your Email *</label>
                      <input id="email" name="email" type="email" required placeholder="Enter your email">
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group">
                      <label for="rating">Rating *</label>
                      <div class="emoji-rating">
                        <input type="hidden" id="rating" name="rating" value="0">
                        <div class="rating-options">
                          <div class="rating-item">
                            <button type="button" class="rating-btn" data-rating="1" title="Very Poor">
                              <span class="rating-emoji">😠</span>
                              <span class="rating-number">1</span>
                            </button>
                            <span class="rating-item-label">Poor</span>
                          </div>
                          <div class="rating-item">
                            <button type="button" class="rating-btn" data-rating="2" title="Poor">
                              <span class="rating-emoji">😞</span>
                              <span class="rating-number">2</span>
                            </button>
                            <span class="rating-item-label">Fair</span>
                          </div>
                          <div class="rating-item">
                            <button type="button" class="rating-btn" data-rating="3" title="Average">
                              <span class="rating-emoji">😐</span>
                              <span class="rating-number">3</span>
                            </button>
                            <span class="rating-item-label">Average</span>
                          </div>
                          <div class="rating-item">
                            <button type="button" class="rating-btn" data-rating="4" title="Good">
                              <span class="rating-emoji">🙂</span>
                              <span class="rating-number">4</span>
                            </button>
                            <span class="rating-item-label">Good</span>
                          </div>
                          <div class="rating-item">
                            <button type="button" class="rating-btn" data-rating="5" title="Excellent">
                              <span class="rating-emoji">😄</span>
                              <span class="rating-number">5</span>
                            </button>
                            <span class="rating-item-label">Excellent</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group">
                      <label for="comment">Your Review *</label>
                      <textarea id="comment" name="comment" rows="4" required placeholder="Share your experience with this product..."></textarea>
                    </div>
                  </div>

                  <input type="hidden" id="product_id" name="product_id" value="<?php echo isset($product_view['id']) ? (int)$product_view['id'] : 0; ?>">
                  <input type="hidden" id="variant_id_input" name="variant_id" value="">
                  <input type="hidden" id="base_url" value="<?php echo site_url(); ?>">

                  <div class="form-row form-actions">
                    <button type="submit" class="btn-submit">Submit Review</button>
                    <span class="form-note">* Required fields</span>
                  </div>

                </form>
                <div id="form-message" class="form-message" style="display: none;"></div>
              </div>
            </div>
          </div>
        </div>

      <div class="col-md-12 col-sm-12 dreaming_related-product">
        <div class="block-title">
          <h2 class="product-grid-title">
            <span>Related Products</span>
          </h2>
        </div>

        <div id="related-products-container" class="auto-clear equal-container better-height akasha-products">
          <ul class="row products columns-4">
            <?php
              $products = isset($related_products) ? $related_products : (isset($related_products) ? $related_products : []);
              if (!empty($products)) {
                include VIEWPATH . '_product_card_dynamic.php';
              }
            ?>
          </ul>
        </div>

        <script>
          (function(){
            try {
              var container = document.getElementById('related-products-container');
              if (!container) return;
              // ensure per-li data-variants are available in window.productVariantsGroupedByColor
              try {
                window.productVariantsGroupedByColor = window.productVariantsGroupedByColor || {};
                var lis = container.querySelectorAll('.product-item');
                lis.forEach(function(li){
                  try {
                    var pid = String(li.getAttribute('data-product-id') || '');
                    if (!pid) return;
                    if (!window.productVariantsGroupedByColor[pid]) {
                      var dv = li.getAttribute('data-variants');
                      if (dv) {
                        try { window.productVariantsGroupedByColor[pid] = JSON.parse(dv); } catch(e) { /* ignore parse */ }
                      }
                    }
                  } catch(e) { /* ignore */ }
                });
              } catch(e) { /* ignore */ }

              function tryInit(){
                try {
                  if (window.initProductCards) {
                    try { window.initProductCards(container); } catch(e) {}
                  }
                } catch(e) {}
              }
              // run now and slightly later to ensure dependent scripts (jQuery/plugins) are ready
              tryInit();
              setTimeout(tryInit, 120);
              setTimeout(tryInit, 500);
            } catch(e) {}
          })();
        </script>

        <div class="shop-all">
          <a target=" _blank" href="products.html">View All</a>
        </div>

      </div>
    </div>
  </div>
</div>
<script>
  var variants = <?php echo json_encode($variants); ?>;
  var variants_grouped_by_color_obj = <?php echo json_encode($variants_grouped_by_color); ?>;
  // Convert object (keyed by color_id) to array (sequential indices)
  var variants_grouped_by_color = Object.values(variants_grouped_by_color_obj);
  var product_view = <?php echo json_encode($product_view); ?>;
  var selected_variant_unique = '<?php echo isset($selected_variant_unique) ? $selected_variant_unique : ''; ?>';
  var selectedColorIndex = -1;  // NO default color selected - user must click
  var selectedSizeIndex = -1;  // Size requires manual selection
  var selectedQty = 1;
  var userSelectedColor = false;  // User has NOT selected a color yet
  var userSelectedSize = false;  // Track if user actively selected size

  function updateVariantView(colorIndex, autoSelectSize) {
    // autoSelectSize defaults to false - don't auto-select size by default
    if (typeof autoSelectSize === 'undefined') {
      autoSelectSize = false;
    }
    // Use color index to get color data (this is the correct array)
    var colorData = variants_grouped_by_color[colorIndex];
    
    // Safety check - if colorData is not found, log and return
    if (!colorData) {
      console.error('colorData is null/undefined for colorIndex:', colorIndex, 'variants_grouped_by_color:', variants_grouped_by_color);
      return;
    }
    
    // Only use variant array as a fallback if needed
    var variant = null;
    if (colorData && colorData.variant_ids && colorData.variant_ids.length > 0) {
      // Find first variant that matches this color
      var firstVariantId = colorData.variant_ids[0];
      for (var v = 0; v < variants.length; v++) {
        if (variants[v].id == firstVariantId) {
          variant = variants[v];
          break;
        }
      }
    }
    
    // generate a color name fallback
    var colorName = (colorData && colorData.color_name) ? colorData.color_name : (variant && variant.color_name ? variant.color_name : 'default color');

    function escapeAttr(s) {
      return String(s || '').replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    // Update images - use colorData.images if available, fallback to variant.images
    var images = (colorData && colorData.images) ? colorData.images : (variant && variant.images ? variant.images : []);
    var imagesHtml = '';
    var thumbsHtml = '';
    if (images && images.length) {
      images.forEach(function(img, i) {
        var altText = escapeAttr((product_view && product_view.title ? product_view.title : 'Product') + ' in ' + colorName + ' color. Product image. Plain background. Neutral tone');
        imagesHtml += '<div class="akasha-product-gallery__image"><img src="<?php echo site_url() ?>images/products/' + img + '" alt="' + altText + '"></div>';
        var thumbAlt = escapeAttr((product_view && product_view.title ? product_view.title : 'Product') + ' thumbnail ' + (i + 1) + ' in ' + colorName + ' color');
        thumbsHtml += '<li><img src="<?php echo site_url() ?>images/products/' + img + '" alt="' + thumbAlt + '"></li>';
      });
    } else {
      // Fallback placeholder when no images for variant
      imagesHtml += '<div class="akasha-product-gallery__image"><img src="<?php echo site_url() ?>assetsfe/img/no-image.png" alt="' + escapeAttr((product_view && product_view.title ? product_view.title : 'Product') + ' no product image available') + '"></div>';
      thumbsHtml += '<li><img src="<?php echo site_url() ?>assetsfe/img/no-image.png" alt="No product thumbnail available"></li>';
    }
    // include product video thumb if present (keep behavior from server markup)
    if (product_view.product_video || (typeof product_view !== 'undefined' && product_view.product_video)) {
      var videoFile = (product_view.product_video || (typeof product_view !== 'undefined' && product_view.product_video) || '');
      imagesHtml += '<div class="akasha-product-gallery__image"><div class="video-container"><video id="video" class="product-video" controls aria-label="' + escapeAttr((product_view && product_view.title ? product_view.title : 'Product') + ' product video. Controls available. Neutral tone') + '"><source src="<?php echo site_url(); ?>images/videos/products/' + videoFile + '" type="video/mp4">Your browser does not support HTML video.</video><div class="video-overlay" id="overlay"><div class="play-icon"></div></div></div></div>';
      thumbsHtml += '<li><img src="<?php echo site_url(); ?>assetsfe/img/video-thumb.png" alt="' + escapeAttr((product_view && product_view.title ? product_view.title : 'Product') + ' product video thumbnail') + '"></li>';
    }

    var wrapper = document.getElementById('variant-images');
    if (wrapper) wrapper.innerHTML = imagesHtml;
    // update thumbnail nav
    var thumbs = document.querySelector('.flex-control-nav');
    if (thumbs) thumbs.innerHTML = thumbsHtml;

    // Ensure any injected <video> elements do not autoplay
    try {
      var videos = (wrapper && wrapper.querySelectorAll) ? wrapper.querySelectorAll('video') : [];
      videos.forEach(function(v) {
        try {
          v.pause();
          v.removeAttribute('autoplay');
          v.currentTime = 0;
        } catch (e) {
          // ignore
        }
      });
    } catch (e) {
      /* ignore */
    }

    // Reinitialize Slick (used by akasha theme) so the gallery becomes a carousel instead of stacked markup
    if (typeof jQuery !== 'undefined') {
      var $ = jQuery;
      var $main = $('.akasha-product-gallery__wrapper');
      var $nav = $('.flex-control-nav');

      // destroy existing slick instances if present
      try {
        if ($main.hasClass('slick-initialized')) {
          $main.slick('unslick');
        }
      } catch (e) {
        /* ignore */
      }
      try {
        if ($nav.hasClass('slick-initialized')) {
          $nav.slick('unslick');
        }
      } catch (e) {
        /* ignore */
      }

      // reinit with same options as the theme
      if ($main.length) {
        $main.slick({
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false,
          draggable: false,
          fade: true,
          asNavFor: '.flex-control-nav'
        });
      }
      if ($nav.length) {
        $nav.slick({
          vertical: true,
          slidesToShow: 3,
          slidesToScroll: 1,
          asNavFor: '.akasha-product-gallery__wrapper',
          dots: false,
          arrows: true,
          prevArrow: '<span class="fa fa-angle-up prev"></span>',
          nextArrow: '<span class="fa fa-angle-down next"></span>',
          focusOnSelect: true,
          slidesMargin: 14,
          responsive: [{
            breakpoint: 991,
            settings: {
              vertical: false,
              slidesToShow: 3,
              prevArrow: '<span class="fa fa-angle-left prev"></span>',
              nextArrow: '<span class="fa fa-angle-right next"></span>'
            }
          }]
        });
      }
    }
    // Update sizes: always show all sizes, disable unavailable
    var allSizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL'];
    var sizesHtml = '';
    var currentColorData = variants_grouped_by_color[selectedColorIndex] || {};
    var currentSizes = currentColorData.sizes || [];
    
    // Check if this is an accessory (One Size only)
    var isAccessory = false;
    if (currentSizes.length === 1) {
      var sizeName = (currentSizes[0].size_name || '').toLowerCase().trim();
      isAccessory = ['one size', 'free size', 'onesize', 'freesize'].includes(sizeName);
    }
    
    if (isAccessory) {
      // For accessories, hide size selector and auto-select
      var sizeElement = document.getElementById('variant-sizes');
      var sizeRow = sizeElement ? sizeElement.parentElement.parentElement : null;
      if (sizeRow) sizeRow.style.display = 'none';
      selectedSizeIndex = 0;
      // Update price immediately for auto-selected size
      var autoSize = currentSizes[0];
      if (autoSize && autoSize.price_name) {
        document.getElementById('variant-price').innerText = '₹ ' + autoSize.price_name;
      }
      // Mark as accessory globally
      window.isAccessoryProduct = true;
    } else {
      // Show size selector for regular products
      var sizeElement = document.getElementById('variant-sizes');
      var sizeRow = sizeElement ? sizeElement.parentElement.parentElement : null;
      if (sizeRow) sizeRow.style.display = '';
      
      allSizes.forEach(function(size, i) {
        // Find size in current color's sizes array
        var sizeData = null;
        var sizeIndex = null;
        for (var j = 0; j < currentSizes.length; j++) {
          if (currentSizes[j].size_name === size) {
            sizeData = currentSizes[j];
            sizeIndex = j;
            break;
          }
        }
        var enabled = sizeData !== null;
        var price = enabled ? sizeData.price_name : '';
        sizesHtml += '<button type="button" class="btn size-btn ' + (enabled ? 'btn-outline-dark' : 'btn-outline-dark disabled') + '" data-size="' + size + '" ' + (enabled ? 'data-price="' + price + '" data-size-index="' + sizeIndex + '"' : 'disabled') + '>' + size + '</button>';
      });
      var variantSizesElement = document.getElementById('variant-sizes');
      if (variantSizesElement) {
        variantSizesElement.innerHTML = sizesHtml;
      }
      
      // Update price to first available size price
      var firstSize = currentSizes.length > 0 ? currentSizes[0] : null;
      if (firstSize && firstSize.price_name) {
        document.getElementById('variant-price').innerText = '₹ ' + firstSize.price_name;
      }
      
      selectedSizeIndex = 0;
      // Highlight first enabled size ONLY if autoSelectSize is true
      if (autoSelectSize) {
        setTimeout(function() {
          var btns = document.querySelectorAll('#variant-sizes .size-btn');
          for (var b = 0; b < btns.length; b++) {
            btns[b].classList.remove('btn-dark');
            btns[b].classList.add('btn-outline-dark');
          }
          for (var b = 0; b < btns.length; b++) {
            if (!btns[b].classList.contains('disabled')) {
              btns[b].classList.remove('btn-outline-dark');
              btns[b].classList.add('btn-dark');
              break;
            }
          }
        }, 10);
      } else {
        // Just clear all selections, don't auto-select
        setTimeout(function() {
          var btns = document.querySelectorAll('#variant-sizes .size-btn');
          for (var b = 0; b < btns.length; b++) {
            btns[b].classList.remove('btn-dark');
            btns[b].classList.add('btn-outline-dark');
          }
        }, 10);
      }
    }
    // Update SKU and tags - only if variant exists
    if (variant) {
      document.getElementById('variant-sku').innerText = variant.sku_code ? variant.sku_code : '';
      document.getElementById('variant-tags').innerText = variant.tags ? variant.tags : '';
      // ensure hidden variant_id in review form is set for this variant
      try {
        var vidInput = document.getElementById('variant_id_input');
        if (vidInput) vidInput.value = variant.variant_id || variant.sku_code || '';
      } catch (e) {
        /* ignore */
      }
    }
    // Update ratings - use colorData or variant as source
    try {
      var rating = 4.5; // default
      if (variant && variant.ratings) {
        rating = parseFloat(variant.ratings);
      } else if (colorData && colorData.ratings && colorData.ratings.length > 0) {
        rating = parseFloat(colorData.ratings[0]);
      }
      
      var fullStars = Math.floor(rating);
      var halfStar = (rating - fullStars) >= 0.5 ? 1 : 0;
      var emptyStars = 5 - fullStars - halfStar;
      var starsHtml = '';
      for (var s = 0; s < fullStars; s++) starsHtml += '<i class="fa fa-star"></i>';
      if (halfStar) starsHtml += '<i class="fa fa-star-half-o"></i>';
      for (var s = 0; s < emptyStars; s++) starsHtml += '<i class="fa fa-star-o"></i>';
      
      var ratingStarsEl = document.getElementById('variant-rating-stars');
      if (ratingStarsEl) {
        ratingStarsEl.innerHTML = starsHtml;
      }
      // document.getElementById('variant-rating-value').innerText = rating + ' out of 5';
    } catch (ratingsError) {
      console.error('Error updating ratings:', ratingsError, 'variant:', variant, 'colorData:', colorData);
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded fired');
    // Add a small delay to ensure all elements are fully rendered
    setTimeout(function() {
      console.log('Initial state: selectedColorIndex=', selectedColorIndex, 'userSelectedColor=', userSelectedColor);
      // Check if this is an accessory product and set up accordingly
      var currentColorData = variants_grouped_by_color[0] || {};
      var currentSizes = currentColorData.sizes || [];
      var isAccessory = false;
      
      if (currentSizes.length === 1) {
        var sizeName = (currentSizes[0].size_name || '').toLowerCase().trim();
        isAccessory = ['one size', 'free size', 'onesize', 'freesize'].includes(sizeName);
      }
      
      console.log('Initial accessory check:', isAccessory, 'sizes:', currentSizes);
      
      if (isAccessory) {
        // For accessories, immediately hide size selector and set defaults
        var sizeElement = document.getElementById('variant-sizes');
        var sizeRow = sizeElement ? sizeElement.parentElement.parentElement : null;
        if (sizeRow) sizeRow.style.display = 'none';
        
        selectedSizeIndex = 0;
        selectedColorIndex = 0;
        userSelectedColor = false; // User hasn't manually selected yet - this is auto-set for accessories
        
        // Set the price immediately
        var autoSize = currentSizes[0];
        if (autoSize && autoSize.price_name) {
          var priceElement = document.getElementById('variant-price');
          if (priceElement) {
            priceElement.innerText = '₹ ' + autoSize.price_name;
          }
        }
        
        // Mark this as an accessory product globally for add to cart validation
        window.isAccessoryProduct = true;
        
        console.log('Accessory setup complete:', {
          selectedSizeIndex: selectedSizeIndex,
          selectedColorIndex: selectedColorIndex,
          price: autoSize ? autoSize.price_name : 'none',
          isAccessoryProduct: window.isAccessoryProduct
        });
      }
      
      // If variant unique id passed via URL, try to find matching variant and select it
      console.log('selected_variant_unique:', selected_variant_unique);
      if (selected_variant_unique && selected_variant_unique.length) {
        console.log('Searching for matching variant...');
        for (var vi = 0; vi < variants.length; vi++) {
          var v = variants[vi];
          // variants may include a list of size_ids or other id arrays; check sku_code and variant_id and images unique ids
          if ((v.sku_code && String(v.sku_code) === selected_variant_unique) || (v.variant_id && String(v.variant_id) === selected_variant_unique)) {
            console.log('Found matching variant at vi=', vi, 'variant_id=', v.variant_id, 'sku_code=', v.sku_code);
            // Find the color index that matches this variant
            for (var ci = 0; ci < variants_grouped_by_color.length; ci++) {
              var colorGroup = variants_grouped_by_color[ci];
              if (colorGroup.variant_ids && colorGroup.variant_ids.indexOf(v.variant_id) !== -1) {
                console.log('Found color group at ci=', ci);
                selectedColorIndex = ci;
                userSelectedColor = false; // URL selection doesn't count as user manually selecting
                break;
              }
            }
            break;
          }
          // check images filenames for unique matching (some grids use unique_id as image unique)
          if (v.images && v.images.indexOf(selected_variant_unique) !== -1) {
            console.log('Found matching variant by image at vi=', vi);
            // Find the color index that matches this variant
            for (var ci = 0; ci < variants_grouped_by_color.length; ci++) {
              var colorGroup = variants_grouped_by_color[ci];
              if (colorGroup.variant_ids && colorGroup.variant_ids.indexOf(v.variant_id) !== -1) {
                console.log('Found color group at ci=', ci);
                selectedColorIndex = ci;
                userSelectedColor = false; // URL selection doesn't count as user manually selecting
                break;
              }
            }
            break;
          }
        }
        console.log('After variant matching: selectedColorIndex=', selectedColorIndex, 'userSelectedColor=', userSelectedColor);
      }
      
      // Show images for the first color on page load (but DON'T select the color)
      console.log('Loading images for first color (no selection)...');
      if (variants_grouped_by_color && variants_grouped_by_color.length > 0) {
        // Use updateVariantView to properly display first color's images
        // This ensures all image/price/sizes are properly set
        updateVariantView(0, false);
      }
      
      // DON'T mark any color circle as active - user must select
      console.log('No color selected by default - user must click');
    }, 100);

    
    document.querySelectorAll('.circle').forEach(function(circle, i) {
      circle.addEventListener('click', function() {
        // Use data-color-index attribute which is the actual variant index from PHP
        var variantIndex = parseInt(this.getAttribute('data-color-index'));
        selectedColorIndex = variantIndex;
        userSelectedColor = true; // Mark that user actively selected a color
        selectedSizeIndex = -1; // Reset size selection when color changes
        
        console.log('Color circle clicked: variantIndex=', variantIndex, 'selectedColorIndex=', selectedColorIndex);
        
        // Hide color validation message when user selects a color
        var colorValidationMsg = document.getElementById('color-validation-msg');
        if (colorValidationMsg) {
          colorValidationMsg.style.display = 'none';
        }
        
        updateVariantView(variantIndex);
        
        // Remove active class and reset border for all circles
        document.querySelectorAll('.circle').forEach(function(c) {
          c.classList.remove('active');
          c.style.setProperty('border', '2px solid #eee', 'important');
        });
        
        // Add active class and apply black border to clicked circle
        circle.classList.add('active');
        circle.style.setProperty('border', '2px solid #222', 'important');
        console.log('Circle border applied to:', circle, 'Border:', circle.style.border);
        
        // Check if new color is also an accessory
        var newColorData = variants_grouped_by_color[variantIndex] || {};
        var newSizes = newColorData.sizes || [];
        var isNewColorAccessory = false;
        
        if (newSizes.length === 1) {
          var sizeName = (newSizes[0].size_name || '').toLowerCase().trim();
          isNewColorAccessory = ['one size', 'free size', 'onesize', 'freesize'].includes(sizeName);
        }
        
        if (isNewColorAccessory) {
          // For accessories, maintain the accessory state and auto-select
          window.isAccessoryProduct = true;
          selectedSizeIndex = 0;
          var sizeElement = document.getElementById('variant-sizes');
          var sizeRow = sizeElement ? sizeElement.parentElement.parentElement : null;
          if (sizeRow) sizeRow.style.display = 'none';
        } else {
          // For regular products, show size selector and handle normal size selection
          window.isAccessoryProduct = false;
          var sizeElement = document.getElementById('variant-sizes');
          var sizeRow = sizeElement ? sizeElement.parentElement.parentElement : null;
          if (sizeRow) sizeRow.style.display = '';
          
          // Reset size button selection (but DON'T auto-select)
          document.querySelectorAll('.size-btn').forEach(function(btn) {
            btn.classList.remove('btn-dark');
            btn.classList.add('btn-outline-dark');
          });
          
          // Reset selectedSizeIndex - let user manually select size
          selectedSizeIndex = -1;
          userSelectedSize = false;
          
          // Show validation message to remind user to select size
          var validationMsg = document.getElementById('size-validation-msg');
          if (validationMsg) {
            validationMsg.style.display = 'block';
          }
        }
        
        // Update price to first available size's price for the new color
        var colorData = variants_grouped_by_color[variantIndex] || {};
        var firstSize = colorData.sizes && colorData.sizes[0];
        if (firstSize) {
          document.getElementById('variant-price').innerText = '₹ ' + firstSize.price_name;
        }
        
        // update hidden variant id for review form when color is changed
        try {
          var vidInput = document.getElementById('variant_id_input');
          if (colorData && colorData.variant_ids && colorData.variant_ids[0]) {
            vidInput.value = colorData.variant_ids[0];
          }
        } catch (e) {
          /* ignore */
        }
        
        // Update wishlist button for new variant
        updateWishlistButtonForVariant(variantIndex);
      });
    });
    var variantSizesElement = document.getElementById('variant-sizes');
    if (variantSizesElement) {
      variantSizesElement.addEventListener('click', function(e) {
        if (e.target.classList.contains('size-btn') && !e.target.classList.contains('disabled')) {
          // Remove btn-dark from all buttons
          document.querySelectorAll('.size-btn').forEach(function(btn) {
            btn.classList.remove('btn-dark');
            btn.classList.add('btn-outline-dark');
          });
          // Add btn-dark to clicked button
          e.target.classList.remove('btn-outline-dark');
          e.target.classList.add('btn-dark');
          document.getElementById('variant-price').innerText = '₹ ' + e.target.getAttribute('data-price');
          selectedSizeIndex = parseInt(e.target.getAttribute('data-size-index'));
          userSelectedSize = true; // Mark that user actively selected a size
          
          // Hide validation message when size is selected
          var validationMsg = document.getElementById('size-validation-msg');
          if (validationMsg) {
            validationMsg.style.display = 'none';
          }
        }
      });
    }
    
    // Initialize wishlist functionality using KLAKS_Wishlist
    var wishlistBtn = document.querySelector('.akasha-product-gallery__trigger.add_to_wishlist');
    if (wishlistBtn && typeof $ !== 'undefined' && typeof KLAKS_Wishlist !== 'undefined') {
      var $wishlistBtn = $(wishlistBtn);
      
      // Use the centralized KLAKS_Wishlist click handler
      $wishlistBtn.on('click', function(e) {
        KLAKS_Wishlist.addToWishlist.call(this, e);
      });
      
      // Initialize wishlist status for default variant
      if (variants && variants.length > 0) {
        updateWishlistButtonForVariant(0);
      }
    }
    document.querySelector('.input-qty')?.addEventListener('input', function(e) {
      selectedQty = this.value;
    });
    
    // Prevent form submission - handle all validation in button click handler
    var cartForm = document.querySelector('.variations_form.cart');
    if (cartForm) {
      cartForm.addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('Form submit prevented - using button handler instead');
        return false;
      });
    }
    
    document.querySelector('.single_add_to_cart_button')?.addEventListener('click', function(e) {
      e.preventDefault();
      console.log('Add to cart clicked! selectedColorIndex=', selectedColorIndex, 'userSelectedColor=', userSelectedColor);
      var errorDiv = document.getElementById('add-to-cart-error');
      if (errorDiv) { errorDiv.style.display = 'none'; errorDiv.innerText = ''; }
      var qty = document.querySelector('.input-qty')?.value || '';
      var name = document.querySelector('#active-product-title')?.innerText || '';
      
      // FIRST: Check if user has selected a color
      console.log('=== COLOR VALIDATION CHECK ===');
      console.log('selectedColorIndex:', selectedColorIndex, '(type:', typeof selectedColorIndex + ')');
      console.log('userSelectedColor:', userSelectedColor, '(type:', typeof userSelectedColor + ')');
      console.log('isNaN(selectedColorIndex):', isNaN(selectedColorIndex));
      
      // Color validation FAILS if selectedColorIndex is NaN, negative, or not a valid number
      var isColorInvalid = isNaN(selectedColorIndex) || selectedColorIndex < 0 || selectedColorIndex === undefined || selectedColorIndex === null;
      
      if (isColorInvalid) {
        console.log('Color validation FAILED - selectedColorIndex is invalid');
        if (errorDiv) { errorDiv.innerText = 'Please select a color.'; errorDiv.style.display = 'block'; }
        
        // Show inline color validation message
        var colorValidationMsg = document.getElementById('color-validation-msg');
        if (colorValidationMsg) {
          console.log('Displaying color validation message');
          colorValidationMsg.style.display = 'block';
        }
        
        if (window.showToast) {
          window.showToast('Please select a color', { type: 'warning', timeout: 3000 });
        }
        return false;
      }
      console.log('Color validation PASSED - continuing with order');
      
      // Defensive: ensure selectedColorIndex resolves to an existing variant
      var colorData = (Array.isArray(variants_grouped_by_color) && variants_grouped_by_color.length && typeof variants_grouped_by_color[selectedColorIndex] !== 'undefined') ? variants_grouped_by_color[selectedColorIndex] : null;
      
      // Check if this is an accessory product
      var isAccessoryProduct = window.isAccessoryProduct || false;
      if (!isAccessoryProduct && colorData.sizes && colorData.sizes.length === 1) {
        var sizeName = (colorData.sizes[0].size_name || '').toLowerCase().trim();
        isAccessoryProduct = ['one size', 'free size', 'onesize', 'freesize'].includes(sizeName);
      }
      
      // Validate quantity NEXT
      if (!qty || isNaN(qty) || parseInt(qty) < 1) {
        if (errorDiv) { errorDiv.innerText = 'Please enter a valid quantity.'; errorDiv.style.display = 'block'; }
        if (window.showToast) {
          window.showToast('Please enter a valid quantity', { type: 'warning', timeout: 3000 });
        }
        return;
      }
      
      // For regular products: user must actively select size
      if (!isAccessoryProduct && !userSelectedSize) {
        if (errorDiv) { errorDiv.innerText = 'Please select a size.'; errorDiv.style.display = 'block'; }
        
        // Also show inline validation message
        var validationMsg = document.getElementById('size-validation-msg');
        if (validationMsg) {
          validationMsg.style.display = 'block';
        }
        
        if (window.showToast) {
          window.showToast('Please select a size', { type: 'warning', timeout: 3000 });
        }
        return;
      }
      
      // Get size data (for accessories, use first size; for regular products, use selected size)
      var sizeIndex = isAccessoryProduct ? 0 : selectedSizeIndex;
      var sizeData = (colorData.sizes && colorData.sizes[sizeIndex]) ? colorData.sizes[sizeIndex] : null;
      
      if (!sizeData) {
        if (errorDiv) { errorDiv.innerText = 'Please select a valid size.'; errorDiv.style.display = 'block'; }
        if (window.showToast) {
          window.showToast('Invalid size selection', { type: 'error', timeout: 3000 });
        }
        return;
      }
      
      var size = sizeData.size_name || '';
      var color = colorData.color_name || '';
      var price = sizeData.price_name || '';
      var productId = colorData.variant_ids[0] || '';
      var image = colorData.images[0] || '';
      
      console.log('Add to cart validation:', {
        userSelectedSize: userSelectedSize,
        isAccessory: isAccessoryProduct,
        selectedColorIndex: selectedColorIndex,
        selectedSizeIndex: sizeIndex,
        sizeData: sizeData,
        size: size,
        color: color,
        price: price
      });
      
      if (!price) {
        if (errorDiv) { errorDiv.innerText = 'Price not available for this selection.'; errorDiv.style.display = 'block'; }
        if (window.showToast) {
          window.showToast('Price not available', { type: 'error', timeout: 3000 });
        }
        return;
      }

      const data = {
        qty,
        size,
        color,
        price,
        productId: productId,
        productInfoId: productId,
        uniqueId: sizeData.size_id || '',
        image,
        name
      };
      console.log('data:', data);
      
      // Try JSON format first for modern cart handling
      var jsonData = Object.assign({}, data, { format: 'json' });
      
      $.ajax({
        url: '<?php echo site_url(); ?>cart/insertcart',
        type: 'POST',
        data: jsonData,
        dataType: 'json',
        success: function(response) {
          if (errorDiv) { errorDiv.style.display = 'none'; }
          
          // Handle JSON response
          if (response && response.status === 'success') {
            // Update mobile cart count
            if (window.updateMobileCartCount && response.cart_count !== undefined) {
              window.updateMobileCartCount(response.cart_count);
            }
            
            // Show toast notification
            if (window.showToast) {
              window.showToast(response.message || 'Added to cart', { type: 'success', timeout: 3000 });
            }
            
            // Refresh the cart dropdown HTML to show new item
            $.ajax({
              url: '<?php echo site_url(); ?>products/get_cart_html',
              type: 'GET',
              success: function(cartHtml) {
                console.log('Cart HTML refreshed after add to cart');
                
                // Replace the cart dropdown HTML
                if (cartHtml && cartHtml.trim()) {
                  $('#cartdivid').replaceWith(cartHtml);
                  
                  // Open the cart dropdown to show the newly added item
                  setTimeout(function() {
                    $('#cartdivid').addClass('open');
                  }, 100);
                }
              },
              error: function() {
                console.warn('Failed to refresh cart HTML, updating count only');
                
                // Fallback: just update the count
                try {
                  var headerCount = document.querySelector('#cartdivid .count');
                  if (headerCount && response.cart_count !== undefined) {
                    headerCount.textContent = response.cart_count;
                  }
                  
                  var mobileHeaderCount = document.querySelector('#mobile-cartdivid .count');
                  if (mobileHeaderCount && response.cart_count !== undefined) {
                    mobileHeaderCount.textContent = response.cart_count;
                  }
                } catch (e) {
                  console.warn('Failed to update header cart count:', e);
                }
              }
            });
            
          } else {
            // Handle error response
            var message = response && response.message ? response.message : 'Failed to add product to cart';
            if (window.showToast) {
              window.showToast(message, { type: 'error', timeout: 4000 });
            }
            if (errorDiv) { 
              errorDiv.innerText = message;
              errorDiv.style.display = 'block';
            }
          }
        },
        error: function(xhr, status, error) {
          console.warn('JSON cart request failed, falling back to HTML:', error);
          
          // Fallback to HTML format for legacy compatibility
          $.ajax({
            url: '<?php echo site_url(); ?>cart/insertcart',
            type: 'POST',
            data: data,
            success: function(response) {
              errorDiv.style.display = 'none';
              try {
                // Update cart UI (legacy) - use replaceWith to avoid nested divs
                $('#cartdivid').replaceWith(response);
                
                // Open the cart dropdown to show the newly added item
                setTimeout(function() {
                  $('#cartdivid').addClass('open');
                }, 100);
              } catch (e) {
                console.warn('Failed to update cartdivid:', e);
              }
              try {
                // Update mobile cart count (legacy method)
                if (window.updateMobileCartCount) {
                  // Extract cart count from HTML response
                  var countMatch = response.match(/class="count">(\d+)<\/span>/);
                  var count = countMatch ? countMatch[1] : '0';
                  window.updateMobileCartCount(count);
                }
              } catch (e) {
                console.warn('Failed to update mobile cart count:', e);
              }
              try {
                // Show toast notification
                if (window.showToast) {
                  window.showToast('Added to cart', { type: 'success', timeout: 3000 });
                }
              } catch (e) {
                console.warn('showToast failed', e);
              }
            },
            error: function() {
              if (errorDiv) { 
                errorDiv.innerText = 'Failed to add to cart. Please try again.';
                errorDiv.style.display = 'block';
              }
              if (window.showToast) {
                window.showToast('Failed to add to cart. Please try again.', { type: 'error', timeout: 4000 });
              }
            }
          });
        }
      });
    });
    // Review form submit via AJAX
    var reviewForm = document.getElementById('commentform');
    if (reviewForm) {
      // make submit button visible (in case CSS hid it)
      try {
        var submitBtn = document.getElementById('submit');
        if (submitBtn) submitBtn.style.display = '';
      } catch (e) {
        /* ignore */
      }
      // star rating click handlers: set hidden select and highlight
      var starLinks = document.querySelectorAll('.comment-form-rating .stars a');
      if (starLinks && starLinks.length) {
        starLinks.forEach(function(a) {
          a.addEventListener('click', function(ev) {
            ev.preventDefault();
            var cls = (this.className || '').match(/star-(\d)/);
            var val = cls ? cls[1] : null;
            if (!val) return;
            // set hidden select
            var sel = document.getElementById('rating');
            if (sel) sel.value = val;
            // visual highlight
            starLinks.forEach(function(s) {
              s.style.color = '#ccc';
            });
            for (var k = 0; k < val; k++) {
              if (starLinks[k]) starLinks[k].style.color = '#f5c518';
            }
          });
        });
      }
      reviewForm.addEventListener('submit', function(ev) {
        ev.preventDefault();
        var name = document.getElementById('author')?.value || '';
        var email = document.getElementById('email')?.value || '';
        var comment = document.getElementById('comment')?.value || '';
        var rating = document.getElementById('rating')?.value || 0;
        var product_id = document.getElementById('product_id')?.value || 0;
        var variant_id = document.getElementById('variant_id_input')?.value || '';
        if (!name || !email || !comment) {
          alert('Please fill name, email and comment.');
          return;
        }
        var payload = {
          name: name,
          email: email,
          comment: comment,
          rating: rating,
          product_id: product_id,
          variant_id: variant_id
        };
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?php echo site_url(); ?>products/submit_review', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4) {
            try {
              var res = JSON.parse(xhr.responseText);
            } catch (e) {
              alert('Unexpected server response');
              return;
            }
            if (res.success) {
              // prepend review to list
              var reviewsList = document.getElementById('reviews-list');
              if (reviewsList) {
                var div = document.createElement('div');
                div.className = 'single-review';
                var now = new Date();
                div.innerHTML = '<strong>' + escapeHtml(name) + '</strong> <span class="review-meta"> &nbsp;' + now.toISOString().slice(0, 19).replace('T', ' ') + ' &nbsp; Rating: ' + escapeHtml(rating) + '</span><p>' + nl2br(escapeHtml(comment)) + '</p>';
                reviewsList.insertBefore(div, reviewsList.firstChild);
              }
              // clear form
              document.getElementById('author').value = '';
              document.getElementById('email').value = '';
              document.getElementById('comment').value = '';
              document.getElementById('rating').value = '';
              alert('Thank you for your review.');
            } else {
              alert(res.message || 'Failed to submit review');
            }
          }
        };
        // encode payload
        var encoded = Object.keys(payload).map(function(k) {
          return encodeURIComponent(k) + '=' + encodeURIComponent(payload[k]);
        }).join('&');
        xhr.send(encoded);
      });
    }

    function escapeHtml(str) {
      return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function nl2br(str) {
      return String(str).replace(/\n/g, '<br>');
    }
    
    // Wishlist functionality for color combos - UPDATE BUTTON WHEN VARIANT CHANGES
    function updateWishlistButtonForVariant(variantIndex) {
      var variant = variants[variantIndex] || {};
      var variantId = variant.variant_id || variant.sku_code || '';
      var productId = product_view.id || '';
      
      var wishlistBtn = document.querySelector('.akasha-product-gallery__trigger.add_to_wishlist');
      if (wishlistBtn) {
        // Update button data attributes to latest variant
        wishlistBtn.setAttribute('data-variant-id', variantId);
        wishlistBtn.setAttribute('data-product-more-info-id', variantId);
        wishlistBtn.setAttribute('data-product-id', productId);
        
        // Trigger the KLAKS_Wishlist check if jQuery is available
        if (typeof $ !== 'undefined' && typeof KLAKS_Wishlist !== 'undefined') {
          KLAKS_Wishlist.checkSingleVariantWishlistStatus(variantId, $(wishlistBtn));
        }
      }
    }
  });
</script>

      </div> <!-- /main-content -->
    </div> <!-- /row -->
  </div> <!-- /container -->
</div> <!-- /main-container -->