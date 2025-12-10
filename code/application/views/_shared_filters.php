<?php
/**
 * Shared Filter Components
 * Used across products, homelux, and other modules to maintain consistency
 */

// Include color functions for consistent color handling
if (!function_exists('get_complete_color_info')) {
    include_once APPPATH . 'includes/color_functions.php';
}
?>

<!-- Shared Category Filter -->
<?php function render_category_filter($categories = [], $show_for_trending = false) { ?>
    <!-- Accordion: CATEGORY -->
    <div class="accordion-container">
        <div class="accordion-section">
            <div class="accordion-header">
                <h3>CATEGORY</h3>
                <span class="accordion-icon">+</span>
            </div>
            <div class="accordion-content">
                <div class="btnfilter">
                    <div class="btnfilter-options">
                        <?php if ($show_for_trending): ?>
                            <!-- Special categories for trending page -->
                            <label class="btnfilter-option">
                                <input type="radio" name="category" value="men">
                                <span class="btnfilter-label">Men</span>
                            </label>
                            <label class="btnfilter-option">
                                <input type="radio" name="category" value="women">
                                <span class="btnfilter-label">Women</span>
                            </label>
                            <label class="btnfilter-option">
                                <input type="radio" name="category" value="accessories">
                                <span class="btnfilter-label">Accessories</span>
                            </label>
                        <?php else: ?>
                            <!-- Regular categories -->
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <label class="btnfilter-option">
                                        <input type="radio" name="category" value="<?php echo htmlspecialchars($category['slug']); ?>">
                                        <span class="btnfilter-label"><?php echo htmlspecialchars($category['name']); ?></span>
                                    </label>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div style="color: red; padding: 10px;">No categories available</div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Shared Size Filter -->
<?php function render_size_filter($available_sizes = []) { ?>
    <!-- Accordion: SIZE -->
    <div class="accordion-container">
        <div class="accordion-section">
            <div class="accordion-header">
                <h3>SIZE</h3>
                <span class="accordion-icon">+</span>
            </div>
            <div class="accordion-content">
                <div class="btnfilter">
                    <div class="btnfilter-options">
                        <?php if (!empty($available_sizes)): ?>
                            <?php foreach ($available_sizes as $size): ?>
                                <label class="btnfilter-option">
                                    <input type="radio" name="size" value="<?php echo htmlspecialchars($size['name']); ?>">
                                    <span class="btnfilter-label"><?php echo htmlspecialchars($size['name']); ?></span>
                                </label>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Fallback predefined sizes -->
                            <?php 
                            $predefined_sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                            foreach ($predefined_sizes as $size): ?>
                                <label class="btnfilter-option">
                                    <input type="radio" name="size" value="<?php echo $size; ?>">
                                    <span class="btnfilter-label"><?php echo $size; ?></span>
                                </label>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Shared Color Filter -->
<?php function render_color_filter($available_colors = []) { ?>
    <!-- Accordion: COLOR -->
    <div class="accordion-container">
        <div class="accordion-section">
            <div class="accordion-header">
                <h3>COLOR</h3>
                <span class="accordion-icon">+</span>
            </div>
            <div class="accordion-content">
                <div class="btnfilter">
                    <div class="btnfilter-options">
                        <?php if (!empty($available_colors)): ?>
                            <?php foreach ($available_colors as $color): ?>
                                <?php 
                                    $colorName = htmlspecialchars($color['name']);
                                    
                                    // Use standardized color matching
                                    $colorInfo = get_complete_color_info($colorName);
                                    $cssColor = $colorInfo['css_color'];
                                    $displayName = $colorInfo['display_name'];
                                ?>
                                <label class="color-filter-option" title="<?php echo $displayName; ?>">
                                    <input type="radio" name="color" value="<?php echo $colorName; ?>">
                                    <span class="color-square" style="background-color: <?php echo htmlspecialchars($cssColor); ?>;"></span>
                                </label>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Fallback to hardcoded colors -->
                            <label class="color-filter-option" title="Blue">
                                <input type="radio" name="color" value="blue">
                                <span class="color-square" style="background-color: #0000ff;"></span>
                            </label>
                            <label class="color-filter-option" title="Gray">
                                <input type="radio" name="color" value="gray">
                                <span class="color-square" style="background-color: #808080;"></span>
                            </label>
                            <label class="color-filter-option" title="Black">
                                <input type="radio" name="color" value="black">
                                <span class="color-square" style="background-color: #000000;"></span>
                            </label>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Shared Price Filter -->
<?php function render_price_filter() { ?>
    <!-- Accordion: PRICE -->
    <div class="accordion-container">
        <div class="accordion-section">
            <div class="accordion-header">
                <h3>PRICE</h3>
                <span class="accordion-icon">+</span>
            </div>
            <div class="accordion-content">
                <div class="btnfilter">
                    <div class="btnfilter-options">
                        <label class="btnfilter-option">
                            <input type="radio" name="price" value="0-500">
                            <span class="btnfilter-label">₹0 - ₹500</span>
                        </label>
                        <label class="btnfilter-option">
                            <input type="radio" name="price" value="500-1000">
                            <span class="btnfilter-label">₹500 - ₹1000</span>
                        </label>
                        <label class="btnfilter-option">
                            <input type="radio" name="price" value="1000-2000">
                            <span class="btnfilter-label">₹1000 - ₹2000</span>
                        </label>
                        <label class="btnfilter-option">
                            <input type="radio" name="price" value="2000-5000">
                            <span class="btnfilter-label">₹2000 - ₹5000</span>
                        </label>
                        <label class="btnfilter-option">
                            <input type="radio" name="price" value="5000+">
                            <span class="btnfilter-label">₹5000+</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Shared Sort Filter -->
<?php function render_sort_filter() { ?>
    <!-- Accordion: SORT -->
    <div class="accordion-container">
        <div class="accordion-section">
            <div class="accordion-header">
                <h3>SORT BY</h3>
                <span class="accordion-icon">+</span>
            </div>
            <div class="accordion-content">
                <div class="btnfilter">
                    <div class="btnfilter-options">
                        <label class="btnfilter-option">
                            <input type="radio" name="sort" value="newest">
                            <span class="btnfilter-label">Newest First</span>
                        </label>
                        <label class="btnfilter-option">
                            <input type="radio" name="sort" value="price_low">
                            <span class="btnfilter-label">Price: Low to High</span>
                        </label>
                        <label class="btnfilter-option">
                            <input type="radio" name="sort" value="price_high">
                            <span class="btnfilter-label">Price: High to Low</span>
                        </label>
                        <label class="btnfilter-option">
                            <input type="radio" name="sort" value="popular">
                            <span class="btnfilter-label">Most Popular</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>