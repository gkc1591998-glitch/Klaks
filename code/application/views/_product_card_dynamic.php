<?php 
// Shared product card template used across all modules
// Partial expects $products to be supplied by the caller (home.php/search.php/etc). If none provided, show a friendly message.

// Include color conversion functions
include_once(APPPATH . 'includes/color_functions.php');
?>
<?php if (!empty($products)) : ?>
    <?php foreach ($products as $product): ?>
        <li class="product-item wow fadeInUp product-item rows-space-30 col-bg-4 col-xl-3 col-lg-6 col-md-6 col-sm-6 col-ts-6 style-01"
            data-product-id="<?php echo $product['id']; ?>"
            data-variants='<?php echo htmlspecialchars(json_encode($grouped_indexed ?? []), ENT_QUOTES); ?>'
            data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
            <div class="product-inner tooltip-right">
                <div class="product-thumb">
                    <!-- Product Image Carousel -->
                    <div id="carousel-<?php echo $product['id']; ?>" class="carousel slide product-carousel" data-product-id="<?php echo $product['id']; ?>" data-ride="carousel"
                        data-interval="2500" data-pause="hover" data-direction="right">
                        <div class="carousel-inner">
                            <?php
                            // Use server-provided grouped variant structure (variants_grouped_by_color)
                            $images = [];
                            $grouped_indexed = [];
                            if (!empty($product['variants_grouped_by_color'])) {
                                $grouped_indexed = $product['variants_grouped_by_color'];
                                // flatten images from groups for carousel
                                foreach ($grouped_indexed as $g) {
                                    $variant_id = !empty($g['variant_ids'][0]) ? $g['variant_ids'][0] : '';
                                    if (!empty($g['images'])) {
                                        foreach ($g['images'] as $imgFile) {
                                            $images[] = [
                                                'src' => site_url('images/products/' . $imgFile),
                                                'variant_id' => $variant_id
                                            ];
                                        }
                                    }
                                }
                            }

                            foreach ($images as $idx => $img): ?>
                                    <div class="carousel-item <?php echo ($idx === 0) ? 'active' : ''; ?>" data-variant-id="<?php echo $img['variant_id']; ?>" data-product-id="<?php echo $product['id']; ?>">
                                    <img src="<?php echo $img['src']; ?>"
                                        data-variant-id="<?php echo $img['variant_id']; ?>"
                                        data-product-id="<?php echo $product['id']; ?>"
                                        onclick="window.location.href='<?php echo site_url(); ?>products/product_view/<?php echo $product['id']; ?>/<?php echo $img['variant_id']; ?>';">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a class="carousel-control-prev" href="#carousel-<?php echo $product['id']; ?>" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#carousel-<?php echo $product['id']; ?>" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>
                    <div class="flash">
                        <?php if ($product['available'] == 'In Stock'): ?>
                            <span class="onnew"><span class="text">New</span></span>
                        <?php endif; ?>
                    </div>
                    <div class="group-button">
                        <?php 
                        // Get the first image's variant_id for wishlist (default)
                        $first_variant_id = '';
                        if (!empty($images) && isset($images[0])) {
                            $first_variant_id = $images[0]['variant_id'];
                        }
                        // Load wishlist partial
                        $this->load->view('partials/wishlist_icon', [
                            'is_header' => false,
                            'product_id' => $product['id'],
                            'variant_id' => $first_variant_id,
                            'icon_type' => 'flaticon'
                        ]);
                        ?>
                    </div>
                </div>
                <div class="product-info equal-elem">
                    <!-- Dynamic Color Circles -->
                    <div class="color-option" style="padding-bottom:5px;">
                        <div class="circles">
                            <?php if (!empty($grouped_indexed)): ?>
                                <?php foreach ($grouped_indexed as $ci => $group): ?>
                                    <?php
                                    $swatchImg = !empty($group['images'][0]) ? site_url('images/products/' . $group['images'][0]) : '';
                                    $variant_id = !empty($group['variant_ids'][0]) ? $group['variant_ids'][0] : '';
                                    $colorName = $group['color_name'] ?? '';
                                    
                                    // Use simple color functions
                                    $colorInfo = get_complete_color_info($colorName);
                                    $cssColor = $colorInfo['css_color'];
                                    $displayName = $colorInfo['display_name'];
                                    ?>
                                    <span class="circle color-selector<?php echo $ci === 0 ? ' active' : ''; ?>"
                                        title="<?php echo htmlspecialchars($displayName); ?>"
                                        data-variant-id="<?php echo htmlspecialchars($variant_id); ?>"
                                        data-product-id="<?php echo $product['id']; ?>"
                                        data-color-name="<?php echo htmlspecialchars($colorName); ?>"
                                        style="display:inline-block;width:16px;height:16px;border-radius:50%;margin-right:4px;vertical-align:middle;overflow:hidden;border:2px solid #eee;cursor:pointer;background:<?php echo htmlspecialchars($cssColor); ?> !important;">
                                    </span>
                                <?php endforeach; ?>
                                <?php else: ?>
                                    <!-- No color groups for this product — render a small placeholder (avoid nested <li> which breaks layout) -->
                                    <div class="no-color-placeholder" style="display:inline-block;margin-right:6px;color:#777;">&nbsp;</div>
                                <?php endif; ?>
                        </div>
                    </div>
                    <h3 class="product-name product_title">
                        <a href="<?php echo site_url(); ?>products/product_view/<?php echo $product['id']; ?>">
                            <?php echo htmlspecialchars($product['title']); ?>
                        </a>
                    </h3>
                    <!-- Dynamic Sizes -->
                    <div class="rating-wapper nostar" style="margin-bottom:5px;">
                                <?php
                                // Build sizes list from grouped variants (unique sizes across groups)
                                $size_order = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL'];
                                $size_attrs = [];
                                $all_sizes_by_color = []; // Track sizes by color for better mapping
                                
                                // Check if this is an accessory (One Size only)
                                $is_accessory = false;
                                if (!empty($product['variants_grouped_by_color']) && count($product['variants_grouped_by_color']) > 0) {
                                    $first_group_sizes = $product['variants_grouped_by_color'][0]['sizes'] ?? [];
                                    if (count($first_group_sizes) == 1) {
                                        $size_name = strtolower(trim($first_group_sizes[0]['size_name'] ?? ''));
                                        $is_accessory = in_array($size_name, ['one size', 'free size', 'onesize', 'freesize']);
                                    }
                                }
                                
                                if (!empty($product['variants_grouped_by_color'])) {
                                    foreach ($product['variants_grouped_by_color'] as $color_idx => $g) {
                                        $variant_id = !empty($g['variant_ids'][0]) ? $g['variant_ids'][0] : '';
                                        $color_name = $g['color_name'] ?? '';
                                        
                                        if (!empty($g['sizes'])) {
                                            foreach ($g['sizes'] as $s) {
                                                $size_key = strtoupper(trim($s['size_name']));
                                                // Store all sizes with their color mapping
                                                $all_sizes_by_color[$size_key][] = [
                                                    'variant_id' => $variant_id,
                                                    'size_name' => $s['size_name'],
                                                    'color_name' => $color_name,
                                                    'price_name' => $s['price_name'] ?? ''
                                                ];
                                                
                                                // Keep unique sizes for display
                                                $found = false;
                                                foreach ($size_attrs as $existing) {
                                                    if (strtoupper(trim($existing['size_name'])) === $size_key) {
                                                        $found = true;
                                                        break;
                                                    }
                                                }
                                                if (!$found) {
                                                    $size_attrs[] = [
                                                        'variant_id' => $variant_id, 
                                                        'size_name' => $s['size_name'],
                                                        'is_first_color' => $color_idx === 0
                                                    ];
                                                }
                                            }
                                        }
                                    }
                                    
                                    // Sort sizes by predefined order
                                    usort($size_attrs, function ($a, $b) use ($size_order) {
                                        $a_idx = array_search(strtoupper($a['size_name']), $size_order);
                                        $b_idx = array_search(strtoupper($b['size_name']), $size_order);
                                        if ($a_idx === false) $a_idx = 999;
                                        if ($b_idx === false) $b_idx = 999;
                                        return $a_idx - $b_idx;
                                    });
                                    
                                    // For accessories, show "One Size" label instead of size selectors
                                    if ($is_accessory) {
                                        echo '<span class="one-size-label" style="font-size:11px;color:#666;padding:2px 6px;background:#f5f5f5;border-radius:2px;">One Size</span>';
                                    } else {
                                        foreach ($size_attrs as $attr): ?>
                                            <span class="size-selector"
                                                style="cursor:pointer;display:<?php echo $attr['is_first_color'] ? 'inline-block' : 'none'; ?>;margin-right:1px;padding:1px 4px;border:1px solid #ddd;border-radius:2px;font-size:11px;"
                                                data-product-id="<?php echo $product['id']; ?>"
                                                data-size="<?php echo htmlspecialchars($attr['size_name']); ?>"
                                                <?php if ($attr['is_first_color']): ?>data-variant-id="<?php echo htmlspecialchars($attr['variant_id']); ?>"<?php endif; ?>>
                                                <?php echo $attr['size_name']; ?>
                                            </span>
                                    <?php endforeach;
                                    }
                                }
                                ?>
                    </div>
                    <!-- Dynamic Prices -->
                    <span class="price">
                        <span class="akasha-Price-amount amount" id="product-price-<?php echo $product['id']; ?>">
                            <?php
                            $price_displayed = false;
                            
                            // For accessories, always show the default price immediately
                            if ($is_accessory && !empty($product['variants_grouped_by_color'])) {
                                $first_group = $product['variants_grouped_by_color'][0];
                                if (!empty($first_group['sizes'][0]['price_name'])) {
                                    echo '<span class="akasha-Price-currencySymbol price-value default-accessory-price accessory-price-force-show" style="display: inline !important; font-weight: 500;">₹ ' . $first_group['sizes'][0]['price_name'] . '</span>';
                                    $price_displayed = true;
                                }
                            }
                            
                            // For regular products or if accessory price wasn't shown, show first available price
                            if (!$price_displayed && !empty($product['variants_grouped_by_color'])) {
                                $first_group = $product['variants_grouped_by_color'][0];
                                if (!empty($first_group['sizes'][0]['price_name'])) {
                                    echo '<span class="akasha-Price-currencySymbol price-value default-regular-price" style="display: inline; font-weight: 500;">₹ ' . $first_group['sizes'][0]['price_name'] . '</span>';
                                    $price_displayed = true;
                                }
                            }
                            ?>
                            
                            <?php if (!empty($product['variants_grouped_by_color'])): ?>
                                <?php foreach ($product['variants_grouped_by_color'] as $color_idx => $g): ?>
                                    <?php
                                    $variant_id = !empty($g['variant_ids'][0]) ? $g['variant_ids'][0] : '';
                                    if (!empty($g['sizes'])) {
                                        foreach ($g['sizes'] as $size_idx => $s): ?>
                                            <span class="akasha-Price-currencySymbol price-value variant-price"
                                                data-variant-id="<?php echo $variant_id; ?>"
                                                data-size="<?php echo htmlspecialchars($s['size_name']); ?>"
                                                data-product-id="<?php echo $product['id']; ?>"
                                                data-color-name="<?php echo htmlspecialchars($g['color_name']); ?>"
                                                style="display: none; font-weight: 500;">
                                                ₹ <?php echo $s['price_name']; ?>
                                            </span>
                                        <?php endforeach;
                                    }
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </span>
                    </span>
                </div>
            </div>
            <script>
                // expose grouped by color data for this product (centralized JS will consume this)
                window.productVariantsGroupedByColor = window.productVariantsGroupedByColor || {};
                window.productVariantsGroupedByColor[<?php echo $product['id']; ?>] = <?php echo json_encode($grouped_indexed ?? []); ?>;
            </script>
        </li>
    <?php endforeach; ?>
<?php else: ?>
    <!-- Global fallback when no products supplied: render a single full-width alert -->
    <li class="col-12">
        <div class="alert alert-warning">No products found.</div>
    </li>
<?php endif; ?>
