<div class="main-container shop-page left-sidebar">
    <div class="row">
        <div class="sidebar col-xl-3 col-lg-4 col-md-4 col-sm-12">
            <div class="shop-control">
                <div class="grid-view-mode pc filter">
                    <style>
                        @media (min-width: 991px) {
                            .pc {
                                display: none !important;
                            }

                            .filter {
                                padding-top: 7px;
                            }
                        }

                        @media (max-width: 768px) {
                            .pc2 {
                                display: none !important;
                            }

                            .filter {
                                padding-top: 7px;
                            }
                        }
                    </style>
                </div>
            </div>
            <div id="widget-area" class="widget-area shop-sidebar">
                <div id="akasha_product_categories-3" class="widget akasha widget_product_categories">
                    <h2 class="ml-4"><a href="<?php echo site_url() ?>dashboard">Dashboard</a></h2>
                    <ul class="product-categories ml-4" style="list-style-type: none;">
                        <li class=""><a href="<?php echo site_url() ?>dashboard/profile">Profile</a>
                        </li>
                        <li class=""><a href="<?php echo site_url() ?>dashboard/orders">Orders</a>
                        </li>
                        <!-- <li class=""><a href="<?php echo site_url() ?>dashboard/address">Address</a>
                        </li> -->
                        <li class=""><a href="<?php echo site_url() ?>dashboard/wishlist">Wishlist</a>
                        </li>
                        <li class=""><a href="<?php echo site_url() ?>login/logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="main-content col-xl-9 col-lg-8 col-md-8 col-sm-12 has-sidebar">
            <div class=" auto-clear equal-container better-height akasha-products">
                <!-- <main class="site-main  main-container no-sidebar"> -->
                <div class="container">
                    <div class="row">
                        <div class="content-area shop-grid-content full_width col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="site-main">
                                <h3 class="custom_blog_title">
                                    Your Wishlist
                                </h3>
                                
                                <?php if (!empty($wishlist_items)): ?>
                                <div class="akasha-notices-wrapper"></div>
                                
                                <div class="wishlist-title">
                                    <h2>My Wishlist on Klaks (<?php echo $wishlist_count; ?> items)</h2>
                                </div>
                                
                                <table class="akasha-table shop_table shop_table_responsive cart wishlist_table" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="product-remove"></th>
                                            <th class="product-thumbnail"></th>
                                            <th class="product-name">Product Name</th>
                                            <th class="product-price">Unit Price</th>
                                            <th class="product-stock-status">Stock Status</th>
                                            <th class="product-add-to-cart">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($wishlist_items as $item): ?>
                                            <?php 
                                            // Get first attribute with price for display (refactored logic)
                                            $default_attr = null;
                                            $default_image = null;
                                            $default_price = '0.00';
                                            
                                            // Try to get from variants_grouped_by_color first
                                            if (!empty($item['variants_grouped_by_color'])) {
                                                $first_variant = reset($item['variants_grouped_by_color']);
                                                if (!empty($first_variant['images'])) {
                                                    $default_image = $first_variant['images'][0];
                                                }
                                                if (!empty($first_variant['sizes']) && is_array($first_variant['sizes'])) {
                                                    $first_size = reset($first_variant['sizes']);
                                                    if (!empty($first_size['price_name'])) {
                                                        $default_price = $first_size['price_name'];
                                                    }
                                                }
                                            }
                                            
                                            // Fallback to attributes
                                            if (!empty($item['attributes'])) {
                                                foreach ($item['attributes'] as $attr) {
                                                    if (!empty($attr['price_name'])) {
                                                        $default_attr = $attr;
                                                        $default_price = $attr['price_name'];
                                                        break;
                                                    }
                                                }
                                                if (!$default_attr && !empty($item['attributes'][0])) {
                                                    $default_attr = $item['attributes'][0];
                                                    if (!empty($default_attr['price_name'])) {
                                                        $default_price = $default_attr['price_name'];
                                                    }
                                                }
                                            }
                                            ?>
                                        <tr id="wishlist-row-<?php echo $item['id']; ?>">
                                            <td class="product-remove">
                                                <div>
                                                    <a href="javascript:void(0)" class="remove remove-from-wishlist" 
                                                    data-product-id="<?php echo $item['id']; ?>" 
                                                    data-product-more-info-id="<?php echo isset($item['product_more_info_id']) ? $item['product_more_info_id'] : ''; ?>"
                                                    aria-label="Remove this item">×</a>
                                                </div>
                                            </td>
                                            <td class="product-thumbnail">
                                                <a href="<?php echo site_url('products/product_view/' . $item['id']); ?>">
                                                    <?php if ($default_image): ?>
                                                        <img width="180" height="180" 
                                                            src="<?php echo site_url('images/products/' . $default_image); ?>" 
                                                            class="attachment-akasha_thumbnail size-akasha_thumbnail" 
                                                            alt="<?php echo htmlspecialchars($item['title']); ?>">
                                                    <?php elseif ($default_attr && !empty($default_attr['image'])): ?>
                                                        <img width="180" height="180" 
                                                            src="<?php echo site_url('images/products/' . $default_attr['image']); ?>" 
                                                            class="attachment-akasha_thumbnail size-akasha_thumbnail" 
                                                            alt="<?php echo htmlspecialchars($item['title']); ?>">
                                                    <?php elseif (!empty($item['image1'])): ?>
                                                        <img width="180" height="180" 
                                                            src="<?php echo site_url('images/products/' . $item['image1']); ?>" 
                                                            class="attachment-akasha_thumbnail size-akasha_thumbnail" 
                                                            alt="<?php echo htmlspecialchars($item['title']); ?>">
                                                    <?php else: ?>
                                                        <img width="180" height="180" 
                                                            src="<?php echo site_url('assets/images/placeholder.jpg'); ?>" 
                                                            class="attachment-akasha_thumbnail size-akasha_thumbnail" 
                                                            alt="No Image">
                                                    <?php endif; ?>
                                                </a>
                                            </td>
                                            <td class="product-name" data-title="Product">
                                                <a href="<?php echo site_url('products/view-product/' . $item['id']); ?>">
                                                    <?php echo htmlspecialchars($item['title']); ?>
                                                </a>
                                                <?php if (!empty($item['content'])): ?>
                                                    <div class="variation">
                                                        <dd class="variation-description">
                                                            <p><?php echo substr(strip_tags($item['content']), 0, 100) . '...'; ?></p>
                                                        </dd>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!empty($item['attributes'])): ?>
                                                    <div class="variation">
                                                        <dd class="variation-attributes">
                                                            <strong>Available Variants:</strong><br>
                                                            <?php foreach ($item['attributes'] as $attr): ?>
                                                                <?php if (!empty($attr['size_name']) || !empty($attr['color_name'])): ?>
                                                                    <span class="variant" style="margin-right: 15px;">
                                                                        <?php if (!empty($attr['size_name'])): ?>
                                                                            Size: <?php echo htmlspecialchars($attr['size_name']); ?>
                                                                        <?php endif; ?>
                                                                        <?php if (!empty($attr['color_name'])): ?>
                                                                            | Color: <?php echo htmlspecialchars($attr['color_name']); ?>
                                                                        <?php endif; ?>
                                                                        <?php if (!empty($attr['price_name'])): ?>
                                                                            | ₹<?php echo number_format((float)$attr['price_name'], 2); ?>
                                                                        <?php endif; ?>
                                                                    </span><br>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </dd>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="product-price" data-title="Price">
                                                <div class="akasha-Price-amount amount">
                                                    <?php if (!empty($default_price) && $default_price !== '0.00'): ?>
                                                        <span class="akasha-Price-currencySymbol">₹</span><?php echo number_format((float)$default_price, 2); ?>
                                                        <?php if (!empty($item['attributes']) && count($item['attributes']) > 1): ?>
                                                            <small style="display: block; color: #666;">Starting price</small>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <span class="akasha-Price-currencySymbol">₹</span>0.00
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="product-stock-status" data-title="Stock Status">
                                                <span class="wishlist-in-stock">
                                                    <?php echo !empty($item['available']) ? htmlspecialchars($item['available']) : 'In Stock'; ?>
                                                </span>
                                            </td>
                                            <td class="product-add-to-cart" data-title="">
                                                <div class="akasha-variation-add-to-cart variations_button">
                                                    <a href="<?php echo site_url('products/product_view/' . $item['id']); ?>" 
                                                    class="button product_type_simple add_to_cart_button" style="background:#000;color:#fff;margin-right:10px;border:none;">
                                                        Select Options
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                
                                <div class="wishlist-actions" style="margin-top: 20px; margin-bottom: 20px;">
                                    <a href="javascript:void(0)" class="btn clear-wishlist" id="clear-wishlist-btn" style="background:#000;color:#fff;margin-right:10px;border:none;">
                                        <i class="fa fa-trash"></i> Clear All Items
                                    </a>
                                    <a href="<?php echo site_url('products'); ?>" class="btn" style="background:#000;color:#fff;margin-right:10px;border:none;">
                                        <i class="fa fa-shopping-bag"></i> Continue Shopping
                                    </a>
                                </div>
                                
                                <?php else: ?>
                                
                                <div class="akasha-notices-wrapper"></div>
                                
                                <div class="wishlist-title">
                                    <h2>My Wishlist on Klaks (0 items)</h2>
                                </div>
                                
                                <table class="akasha-table shop_table shop_table_responsive cart wishlist_table" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="product-remove"></th>
                                            <th class="product-thumbnail"></th>
                                            <th class="product-name">Product Name</th>
                                            <th class="product-price">Unit Price</th>
                                            <th class="product-stock-status">Stock Status</th>
                                            <th class="product-add-to-cart">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="6" class="wishlist-empty">
                                                No products added to the wishlist
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                                <div class="wishlist-actions" style="margin-top: 20px;">
                                    <a href="<?php echo site_url('products'); ?>" class="button">
                                        Browse Products
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </main> -->
            </div>
        </div>
    </div>
</div>
