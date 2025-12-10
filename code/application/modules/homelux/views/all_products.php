<?php
// Load color helper for better color management
if (!function_exists('get_best_color_match')) {
    $this->load->helper('color');
}
?>
<style>
    /* Color Filter Styles */
    .color-filter-option {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 2px;
        cursor: pointer;
        border: 2px solid transparent;
        border-radius: 3px;
        padding: 2px;
        transition: border-color 0.3s ease;
    }
    
    .color-filter-option:hover {
        border-color: #ddd;
    }
    
    .color-filter-option.active {
        border-color: #890000;
    }
    
    .color-filter-option input[type="radio"] {
        display: none;
    }
    
    .color-square {
        width: 15px;
        height: 15px;
        border-radius: 2px;
        border: 1px solid #ddd;
        display: inline-block;
        position: relative;
    }
    
    .color-square.white {
        border: 2px solid #ddd;
    }
    
    .color-name {
        display: none; /* Hide color names */
    }
    
    /* Show solid gray for unknown colors instead of pattern */
    .color-square.unknown {
        background-color: #cccccc !important;
    }

    .size-btn {
        padding: 0px 16px !important;
    }
</style>
<style>
    .size-selector.active {
        background: none;
        color: #890000;
        /* border-radius: 4px; */
        /* padding: 2px 8px; */
        font-weight: bold;
        /* border: 1px solid #222; */
        transition: background 0.2s, color 0.2s;
    }

    .carousel-control-next-icon {
        background-image: none !important;
    }

    .carousel-control-prev-icon {
        background-image: none !important;
    }

    .size-btn.btn-dark {
        background: #222;
        color: #fff;
        border-radius: 4px;
        font-weight: bold;
        border: 1px solid #222;
        transition: background 0.2s, color 0.2s;
    }

    .size-btn.btn-outline-dark {
        background: #fff;
        color: #222;
        border: 1px solid #222;
    }

    .product-item.style-01 .group-button {
        position: absolute;
        right: 10px;
        top: 10px;
        z-index: 10;
    }

    /* Top Category Filter Styles */
    .filter-btn {
        display: inline-block;
        padding: 8px 16px;
        margin-right: 10px;
        background: #fff;
        color: #333;
        border: 1px solid #ddd;
        text-decoration: none;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .filter-btn:hover {
        background: #f5f5f5;
        text-decoration: none;
        color: #333;
    }

    .filter-btn.active {
        background: #222;
        color: #fff;
        border-color: #222;
    }

    .filter-scroll {
        display: flex;
        overflow-x: auto;
        padding: 10px 0;
        white-space: nowrap;
    }
</style>

<!-- Loader Overlay: Place at the top, outside AJAX-updated area -->
<div id="ajax-loader" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:2000;background:rgba(255,255,255,0.7);align-items:center;justify-content:center;">
    <div style="border:8px solid #f3f3f3;border-top:8px solid #222;border-radius:50%;width:60px;height:60px;animation:spin 1s linear infinite;"></div>
    <style>
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</div>
<style>
    #ajax-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 2000;
        background: rgba(255, 255, 255, 0.7);
        align-items: center;
        justify-content: center;
    }
</style>

<div class="main-container shop-page left-sidebar">
    <div class="container">
        <div style="background-image: url(<?php echo site_url()?>assetsfe/img/lux.gif); background-position: center;">
            <div class="container">                        
                <div class="row justify-content-center p-3">
                    <h4 class="font-bold text-white letter-spacing-lg" style="letter-spacing: 15px;">KLAKS LUX</h4>
                </div>
            </div>                        
        </div>
    </div><br/>
    
    <div class="container">
        <div>
            <div class="category-filter-mobile mb-4 ">
                <div class="container">
                    <div class="filter-scroll">
                        <?php if (!empty($is_trending_page) && !empty($top_categories)): ?>
                            <!-- Trending page - show Men, Women, Accessories -->
                            <a href="javascript:void(0);" class="filter-btn ajax-filter-btn active" data-type="all" data-category-slug="">ALL</a>
                            <?php foreach ($top_categories as $top_cat): ?>
                                <a href="javascript:void(0);" class="filter-btn ajax-filter-btn top-category-btn" 
                                   data-type="<?php echo htmlspecialchars($top_cat['name']); ?>"
                                   data-category-slug="<?php echo htmlspecialchars($top_cat['slug']); ?>">
                                    <?php echo htmlspecialchars($top_cat['name']); ?>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Regular page - show existing categories -->
                            <a href="javascript:void(0);" class="filter-btn ajax-filter-btn" data-type="all">ALL</a>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <a href="javascript:void(0);" class="filter-btn ajax-filter-btn" data-type="<?php echo htmlspecialchars($category['name']); ?>">
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">

            <div class="sidebar col-xl-3 col-lg-4 col-md-4 col-sm-12 ">

                <div class="d-flex justify-content-between align-items-center d-block d-md-none">
                    <div class="grid-view-mode">
                        <a href="" data-toggle="tooltip" data-placement="top"
                            class="modes-mode mode-grid display-mode active" value="grid">
                            <span class="button-inner">
                                <svg width="24" height="24" fill="none" class="undefined">
                                    <path stroke="#000" d="M.5.669h17V17.58H.5zM9.5 1v10.526M0 11.026h18"></path>
                                </svg>
                            </span>
                        </a>
                        <a href="#" data-toggle="tooltip" data-placement="top"
                            class="modes-mode mode-list display-mode" value="list" onclick="toggleListView(event)">
                            <span class="button-inner">
                                <svg width="24" height="24" fill="none" class="undefined">
                                    <path stroke="#DADADA" d="M.5.669h17V17.58H.5zM0 9.974h17.053"></path>
                                </svg>
                            </span>
                        </a>
                        <a href="#" data-toggle="tooltip" data-placement="top"
                            class="modes-mode mode-list display-mode" value="list"
                            onclick="toggleProductInfo(event)">
                            <span class="button-inner">
                                <svg width="24" height="24" fill="none" class="undefined">
                                    <path stroke="#DADADA"
                                        d="M.5.669h17V17.58H.5zM0 7.131h17.053M0 12.815h17.053M6.186 1.947v16.105M11.867 1.947v16.105">
                                    </path>
                                </svg>
                            </span>
                        </a>
                    </div>
                    <div>
                        <button class="btn btn-secondary" onclick="toggleFilterSidebar()">
                            <i class="fa fa-filter"></i>
                        </button>

                    </div>
                </div>


                <div id="widget-area" class="widget-area shop-sidebar  d-none d-md-block">

                    <div id="akasha_product_search-2" class="widget akasha widget_product_search">
                        <form class="akasha-product-search" id="search-form">
                            <input id="akasha-product-search-field-0" class="search-field"
                                placeholder="Search products…" value="" name="s" type="search">
                            <button type="submit" value="Search">Search</button>
                        </form>
                    </div>

                    <!-- Accordion: SORT BY -->
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
                                            <input type="radio" name="sort" value="popular">
                                            <span class="btnfilter-label">Popular</span>
                                        </label>
                                        <label class="btnfilter-option">
                                            <input type="radio" name="sort" value="new">
                                            <span class="btnfilter-label">NEW</span>
                                        </label>
                                        <label class="btnfilter-option">
                                            <input type="radio" name="sort" value="high-to-low">
                                            <span class="btnfilter-label">Price: High to low</span>
                                        </label>
                                        <label class="btnfilter-option">
                                            <input type="radio" name="sort" value="low-to-high">
                                            <span class="btnfilter-label">Price: low to high</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Subcategory Section (for trending page) -->
                    <?php if (!empty($is_trending_page)): ?>
                    <div class="accordion-container" id="dynamic-subcategory-section" style="display: none;">
                        <div class="accordion-section">
                            <div class="accordion-header">
                                <h3 id="subcategory-section-title">SUBCATEGORIES</h3>
                                <span class="accordion-icon">+</span>
                            </div>
                            <div class="accordion-content">
                                <div class="btnfilter">
                                    <div class="btnfilter-options" id="dynamic-subcategory-options">
                                        <!-- Subcategories will be loaded here dynamically -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Accordion: CATEGORY (for regular pages) -->
                    <?php if (empty($is_trending_page)): ?>
                    <div class="accordion-container">
                        <div class="accordion-section">
                            <div class="accordion-header">
                                <h3>CATEGORY</h3>
                                <span class="accordion-icon">+</span>
                            </div>
                            <div class="accordion-content">
                                <div class="btnfilter">
                                    <div class="btnfilter-options">
                                        <?php if (!empty($categories)): ?>
                                            <?php foreach ($categories as $category): ?>
                                                <label class="btnfilter-option">
                                                    <input type="radio" name="category" value="<?php echo htmlspecialchars($category['name']); ?>">
                                                    <span class="btnfilter-label"><?php echo htmlspecialchars($category['name']); ?></span>
                                                </label>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div style="color: red; padding: 10px;">No categories available</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

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
                                            <?php
                                            // Sort sizes in proper order
                                            $size_order = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL'];
                                            usort($available_sizes, function ($a, $b) use ($size_order) {
                                                $a_idx = array_search(strtoupper($a['name']), $size_order);
                                                $b_idx = array_search(strtoupper($b['name']), $size_order);
                                                if ($a_idx === false) $a_idx = 999;
                                                if ($b_idx === false) $b_idx = 999;
                                                return $a_idx - $b_idx;
                                            });
                                            ?>
                                            <?php foreach ($available_sizes as $size): ?>
                                                <label class="btnfilter-option">
                                                    <input type="radio" name="size" value="<?php echo htmlspecialchars($size['name']); ?>">
                                                    <span class="btnfilter-label"><?php echo htmlspecialchars($size['name']); ?></span>
                                                </label>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <!-- Fallback to hardcoded sizes -->
                                            <label class="btnfilter-option">
                                                <input type="radio" name="size" value="XS">
                                                <span class="btnfilter-label">XS</span>
                                            </label>
                                            <label class="btnfilter-option">
                                                <input type="radio" name="size" value="S">
                                                <span class="btnfilter-label">S</span>
                                            </label>
                                            <label class="btnfilter-option">
                                                <input type="radio" name="size" value="M">
                                                <span class="btnfilter-label">M</span>
                                            </label>
                                            <label class="btnfilter-option">
                                                <input type="radio" name="size" value="L">
                                                <span class="btnfilter-label">L</span>
                                            </label>
                                            <label class="btnfilter-option">
                                                <input type="radio" name="size" value="XL">
                                                <span class="btnfilter-label">XL</span>
                                            </label>
                                            <label class="btnfilter-option">
                                                <input type="radio" name="size" value="2XL">
                                                <span class="btnfilter-label">2XL</span>
                                            </label>
                                            <label class="btnfilter-option">
                                                <input type="radio" name="size" value="3XL">
                                                <span class="btnfilter-label">3XL</span>
                                            </label>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <style>
                                    .btnfilter {
                                        padding: 10px 0;
                                    }

                                    .btnfilter-options {
                                        display: flex;
                                        flex-wrap: wrap;
                                        gap: 10px;
                                    }

                                    .btnfilter-option {
                                        position: relative;
                                        cursor: pointer;
                                    }

                                    .btnfilter-option input[type="radio"] {
                                        position: absolute;
                                        opacity: 0;
                                    }

                                    .btnfilter-label {
                                        display: inline-block;
                                        padding: 5px 10px;
                                        border: 1px solid #ccc;
                                        min-width: 45px;
                                        text-align: center;
                                        transition: all 0.3s ease;
                                        text-transform: uppercase;
                                    }

                                    .btnfilter-option input[type="radio"]:checked+.btnfilter-label {
                                        background: #000;
                                        color: #fff;
                                        border-color: #000;
                                    }

                                    .btnfilter-option:hover .btnfilter-label {
                                        border-color: #000;
                                    }
                                </style>
                            </div>
                        </div>
                    </div>

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
                                                    
                                                    // Use enhanced color matching from helper
                                                    $colorMatch = get_best_color_match($colorName);
                                                    $cssColor = $colorMatch['css_color'];
                                                    $displayName = $colorMatch['display_name'];
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

                    <!-- Accordion: FIT -->
                    <!-- <div class="accordion-container">
                        <div class="accordion-section">
                            <div class="accordion-header">
                                <h3>FIT</h3>
                                <span class="accordion-icon">+</span>
                            </div>
                            <div class="accordion-content">
                                <div class="btnfilter-options">
                                    <label class="btnfilter-option">
                                        <input type="radio" name="fit" value="fit-01">
                                        <span class="btnfilter-label">fit -01</span>
                                    </label>
                                    <label class="btnfilter-option">
                                        <input type="radio" name="fit" value="fit-02">
                                        <span class="btnfilter-label">fit -02</span>
                                    </label>
                                    <label class="btnfilter-option">
                                        <input type="radio" name="fit" value="fit-03">
                                        <span class="btnfilter-label">fit -03</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Accordion: PRICE -->
                    <div class="accordion-container">
                        <div class="accordion-section">
                            <div class="accordion-header">
                                <h3>PRICE</h3>
                                <span class="accordion-icon">+</span>
                            </div>
                            <div class="accordion-content">
                                <div id="akasha_price_filter-2" class="widget akasha widget_price_filter">
                                    <h2 class="widgettitle">Price (INR )<span class="arrow"></span></h2>
                                    <form method="get" action="#" id="price-filter-form">
                                        <div class="price_slider_wrapper">
                                            <div data-label-reasult="Range:" data-min="100" data-max="5000" data-unit="₹"
                                                class="price_slider" data-value-min="100" data-value-max="2000" id="price-slider">
                                            </div>
                                            <div class="price_slider_amount">
                                                <button type="button" class="button" id="price-filter-btn">Filter</button>
                                                <div class="price_label">
                                                    Price: <span class="from" id="price-from">₹100</span> — <span class="to" id="price-to">₹5000</span>
                                                </div>
                                                <!-- Hidden inputs to store min/max values -->
                                                <input type="hidden" id="price-min" value="100">
                                                <input type="hidden" id="price-max" value="5000">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-dark p-2 px-5  d-md-none" onclick="toggleFilterSidebar()">
                        <i class="fa fa-close"></i>
                    </button>

                    <!-- Debug Test Button -->
                    <!-- <button class="btn btn-warning mt-2" onclick="testFilter()" style="width: 100%;">
                        TEST FILTER (Debug)
                    </button>
                    
                    <button class="btn btn-info mt-2" onclick="testAjaxEndpoint()" style="width: 100%;">
                        TEST AJAX ENDPOINT
                    </button> -->

                    <div class="sticky-bottom-buttons fixed-bottom bg-white p-3 d-flex justify-content-between shadow-sm d-md-none">
                        <button type="button" class="btn btn-outline-secondary w-50 fw-medium rounded">CLEAR</button>
                        <button type="submit" class="btn btn-dark w-50 fw-medium rounded">APPLY (705)</button>
                    </div>

                </div><!-- .widget-area -->
            </div>

            <div class="main-content col-xl-9 col-lg-8 col-md-8 col-sm-12 has-sidebar" style="position:relative;">
                <div id="ajax-products-container">
                    <!-- Product grid will be loaded here -->
                    <div class=" auto-clear equal-container better-height akasha-products">
                        <ul class="row products columns-3">
                            <?php
                            // Use the same product display as home module
                            include VIEWPATH . '_product_card_dynamic.php';
                            ?>
                        </ul>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script>
        jQuery(document).ready(function($) {
            // Accordion logic
            $('.accordion-header').off('click');
            $('.accordion-header').on('click', function(e) {
                e.preventDefault();
                var section = $(this).closest('.accordion-section');
                var isActive = section.hasClass('active');
                // Close all
                $('.accordion-section').removeClass('active');
                $('.accordion-icon').text('+');
                // Open clicked if not already
                if (!isActive) {
                    section.addClass('active');
                    $(this).find('.accordion-icon').text('-');
                }
            });
            // Start with all closed
            $('.accordion-section').removeClass('active');
            $('.accordion-icon').text('+');

            <?php if (!empty($is_trending_page)): ?>
            // Top category filter functionality for trending page
            $('.top-category-btn').on('click', function(e) {
                e.preventDefault();
                
                var categorySlug = $(this).data('category-slug');
                var categoryName = $(this).data('type');
                
                console.log('Top category clicked:', categoryName, categorySlug);
                
                // Remove active class from all top category buttons
                $('.top-category-btn').removeClass('active');
                // Add active class to clicked button
                $(this).addClass('active');
                
                if (categorySlug && categorySlug !== '') {
                    // Load subcategories for this category
                    loadSubcategories(categorySlug, categoryName);
                    
                    // Filter products by category
                    filterProductsByCategory(categorySlug);
                } else {
                    // "ALL" was clicked - hide subcategory section and show all products
                    $('#dynamic-subcategory-section').hide();
                    loadAllTrendingProducts();
                }
            });

            // Function to load subcategories dynamically
            function loadSubcategories(categorySlug, categoryName) {
                console.log('Loading subcategories for:', categorySlug);
                
                $.ajax({
                    url: '<?php echo site_url('homelux/ajax_get_subcategories'); ?>',
                    type: 'POST',
                    data: {
                        category_slug: categorySlug
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('Subcategories loaded:', response);
                        if (response.success && response.subcategories) {
                            // Update section title
                            $('#subcategory-section-title').text(categoryName.toUpperCase() + ' SUBCATEGORIES');
                            
                            // Clear and populate subcategory options
                            var optionsHtml = '';
                            $.each(response.subcategories, function(index, subcat) {
                                optionsHtml += '<label class="btnfilter-option">';
                                optionsHtml += '<input type="radio" name="subcategory" value="' + subcat.slug + '">';
                                optionsHtml += '<span class="btnfilter-label">' + subcat.subcategory_name + '</span>';
                                optionsHtml += '</label>';
                            });
                            
                            $('#dynamic-subcategory-options').html(optionsHtml);
                            
                            // Show the subcategory section
                            $('#dynamic-subcategory-section').show();
                            
                            // Add event listeners to new subcategory options
                            $('input[name="subcategory"]').on('change', function() {
                                if (this.checked) {
                                    var subcatSlug = $(this).val();
                                    console.log('Subcategory selected:', subcatSlug);
                                    filterProductsBySubcategory(subcatSlug);
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error loading subcategories:', error);
                    }
                });
            }

            // Function to filter products by category
            function filterProductsByCategory(categorySlug) {
                console.log('Filtering products by category:', categorySlug);
                
                $.ajax({
                    url: '<?php echo site_url('homelux/ajax_products'); ?>',
                    type: 'POST',
                    data: {
                        type: categorySlug
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#ajax-products-container').html(response.html);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error filtering by category:', error);
                    }
                });
            }

            // Function to filter products by subcategory
            function filterProductsBySubcategory(subcatSlug) {
                console.log('Filtering products by subcategory:', subcatSlug);
                
                $.ajax({
                    url: '<?php echo site_url('homelux/ajax_products'); ?>',
                    type: 'POST',
                    data: {
                        type: subcatSlug
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#ajax-products-container').html(response.html);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error filtering by subcategory:', error);
                    }
                });
            }

            // Function to load all trending products
            function loadAllTrendingProducts() {
                console.log('Loading all trending products');
                
                $.ajax({
                    url: '<?php echo site_url('homelux/ajax_products'); ?>',
                    type: 'POST',
                    data: {
                        type: 'trending'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#ajax-products-container').html(response.html);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error loading trending products:', error);
                    }
                });
            }
            <?php endif; ?>
        });
    </script>

<!-- <script>
    jQuery(document).ready(function($) {
        // Accordion logic
        $('.accordion-header').off('click');
        $('.accordion-header').on('click', function(e) {
            e.preventDefault();
            var section = $(this).closest('.accordion-section');
            var isActive = section.hasClass('active');
            // Close all
            $('.accordion-section').removeClass('active');
            $('.accordion-icon').text('+');
            // Open clicked if not already
            if (!isActive) {
                section.addClass('active');
                $(this).find('.accordion-icon').text('-');
            }
        });
        // Optionally, start with all closed
        $('.accordion-section').removeClass('active');
        $('.accordion-icon').text('+');

        // Debug: Check if categories are available
        // console.log('Categories found in DOM:', $('input[type="radio"][name="category"]').length);
        $('input[type="radio"][name="category"]').each(function(i, el) {
            console.log('Category option ' + i + ':', $(el).val());
        });

        // Side navigation category filters - use same logic as top category filters
        $('input[type="radio"][name="category"]').on('change', function() {
            console.log('Side category event triggered');
            if (this.checked) {
                var categoryValue = $(this).val();
                console.log('Side category filter clicked:', categoryValue);
                
                // Use the same AJAX logic as top category filters
                $('#ajax-loader').show();
                
                // Clear top category filter active states
                $('.ajax-filter-btn').removeClass('active');
                
                console.log('Making AJAX call to ajax_products with type:', categoryValue);
                
                $.ajax({
                    url: '<?php echo site_url('products/ajax_products'); ?>',
                    type: 'POST',
                    data: {
                        type: categoryValue
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('Side category filter success:', response);
                        if (response.success) {
                            $('#ajax-products-container').html(response.html);
                            try { if (window.initProductCards) window.initProductCards($('#ajax-products-container')); } catch(e) {}
                        } else {
                            alert('Filter failed: ' + response.message);
                        }
                        $('#ajax-loader').hide();
                    },
                    error: function(xhr, status, error) {
                        console.log('Side category filter error:', status, error);
                        console.log('Response:', xhr.responseText);
                        alert('Filter error: ' + error);
                        $('#ajax-loader').hide();
                    }
                });
            }
        });

        // Side navigation SIZE filters
        $('input[type="radio"][name="size"]').on('change', function() {
            console.log('Side size event triggered');
            if (this.checked) {
                var sizeValue = $(this).val();
                console.log('Side size filter clicked:', sizeValue);
                
                $('#ajax-loader').show();
                
                // Clear top category filter active states
                $('.ajax-filter-btn').removeClass('active');
                
                $.ajax({
                    url: '<?php echo site_url('products/ajax_filter_products'); ?>',
                    type: 'POST',
                    data: {
                        size: sizeValue
                    },
                        success: function(response) {
                        console.log('Side size filter success');
                        $('#ajax-products-container').html(response);
                        try { if (window.initProductCards) window.initProductCards($('#ajax-products-container')); } catch(e) {}
                        $('#ajax-loader').hide();
                    },
                    error: function(xhr, status, error) {
                        console.log('Side size filter error:', status, error);
                        console.log('Response:', xhr.responseText);
                        alert('Size filter error: ' + error);
                        $('#ajax-loader').hide();
                    }
                });
            }
        });

        // Side navigation COLOR filters - Updated for new color square design
        $('.color-filter-option').on('click', function() {
            console.log('Color filter option clicked');
            
            var $this = $(this);
            var $input = $this.find('input[type="radio"]');
            var colorValue = $input.val();
            
            // Remove active class from all color options
            $('.color-filter-option').removeClass('active');
            
            // Add active class to clicked option
            $this.addClass('active');
            
            // Check the radio button
            $input.prop('checked', true);
            
            console.log('Side color filter clicked:', colorValue);
            
            $('#ajax-loader').show();
            
            // Clear top category filter active states
            $('.ajax-filter-btn').removeClass('active');
            
            $.ajax({
                url: '<?php echo site_url('homelux/ajax_filter_products'); ?>',
                type: 'POST',
                data: {
                    color: colorValue
                },
                success: function(response) {
                    console.log('Side color filter success');
                    $('#ajax-products-container').html(response);
                    try { if (window.initProductCards) window.initProductCards($('#ajax-products-container')); } catch(e) {}
                    $('#ajax-loader').hide();
                },
                error: function(xhr, status, error) {
                    console.log('Side color filter error:', status, error);
                    console.log('Response:', xhr.responseText);
                    alert('Color filter error: ' + error);
                    $('#ajax-loader').hide();
                }
            });
        });

        // Keep the old radio button change event as fallback
        $('input[type="radio"][name="color"]').on('change', function() {
            console.log('Side color event triggered (fallback)');
            if (this.checked) {
                var colorValue = $(this).val();
                console.log('Side color filter clicked (fallback):', colorValue);
                
                $('#ajax-loader').show();
                
                // Clear top category filter active states
                $('.ajax-filter-btn').removeClass('active');
                
                $.ajax({
                    url: '<?php echo site_url('homelux/ajax_filter_products'); ?>',
                    type: 'POST',
                    data: {
                        color: colorValue
                    },
                        success: function(response) {
                        console.log('Side color filter success (fallback)');
                        $('#ajax-products-container').html(response);
                        try { if (window.initProductCards) window.initProductCards($('#ajax-products-container')); } catch(e) {}
                        $('#ajax-loader').hide();
                    },
                    error: function(xhr, status, error) {
                        console.log('Side color filter error (fallback):', status, error);
                        console.log('Response:', xhr.responseText);
                        alert('Color filter error: ' + error);
                        $('#ajax-loader').hide();
                    }
                });
            }
        });

        // Side navigation SORT BY filters
        $('input[type="radio"][name="sort"]').on('change', function() {
            console.log('Side sort event triggered');
            if (this.checked) {
                var sortValue = $(this).val();
                console.log('Side sort filter clicked:', sortValue);
                
                $('#ajax-loader').show();
                
                // Clear top category filter active states
                $('.ajax-filter-btn').removeClass('active');
                
                $.ajax({
                    url: '<?php echo site_url('products/ajax_filter_products'); ?>',
                    type: 'POST',
                    data: {
                        sort: sortValue
                    },
                        success: function(response) {
                        console.log('Side sort filter success');
                        $('#ajax-products-container').html(response);
                        try { if (window.initProductCards) window.initProductCards($('#ajax-products-container')); } catch(e) {}
                        $('#ajax-loader').hide();
                    },
                    error: function(xhr, status, error) {
                        console.log('Side sort filter error:', status, error);
                        console.log('Response Text:', xhr.responseText);
                        console.log('Status Code:', xhr.status);
                        console.log('Ready State:', xhr.readyState);
                        
                        // Show detailed error information
                        var errorMsg = 'Sort filter error details:\n';
                        errorMsg += 'Status: ' + status + '\n';
                        errorMsg += 'Error: ' + error + '\n';
                        errorMsg += 'Status Code: ' + xhr.status + '\n';
                        errorMsg += 'Response: ' + xhr.responseText.substring(0, 500);
                        
                        alert(errorMsg);
                        $('#ajax-loader').hide();
                    }
                });
            }
        });

        // Price filter functionality
        $('#price-filter-btn').on('click', function(e) {
            e.preventDefault();
            console.log('Price filter button clicked');
            
            // Get the current price range values
            var minPrice = $('#price-min').val() || 100;
            var maxPrice = $('#price-max').val() || 5000;
            
            console.log('Price range filter:', minPrice, 'to', maxPrice);
            
            $('#ajax-loader').show();
            
            // Clear top category filter active states
            $('.ajax-filter-btn').removeClass('active');
            
            $.ajax({
                url: '<?php echo site_url('products/ajax_filter_products'); ?>',
                type: 'POST',
                data: {
                    price_min: minPrice,
                    price_max: maxPrice
                },
                success: function(response) {
                    console.log('Price filter success');
                    $('#ajax-products-container').html(response);
                    try { if (window.initProductCards) window.initProductCards($('#ajax-products-container')); } catch(e) {}
                    $('#ajax-loader').hide();
                },
                error: function(xhr, status, error) {
                    console.log('Price filter error:', status, error);
                    console.log('Response:', xhr.responseText);
                    alert('Price filter error: ' + error);
                    $('#ajax-loader').hide();
                }
            });
        });

        // Simple price slider simulation (if there's no actual slider library)
        // This creates a basic range input simulation
        if ($('#price-slider').length && typeof $.fn.slider === 'undefined') {
            // Create simple range inputs if no slider library is available
            var $slider = $('#price-slider');
            var $wrapper = $slider.closest('.price_slider_wrapper');
            
            if (!$wrapper.find('.simple-price-range').length) {
                $wrapper.prepend(`
                    <div class="simple-price-range" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px;">Min Price:</label>
                        <input type="range" id="price-range-min" min="100" max="5000" value="100" step="100" style="width: 100%; margin-bottom: 10px;">
                        <label style="display: block; margin-bottom: 5px;">Max Price:</label>
                        <input type="range" id="price-range-max" min="100" max="5000" value="5000" step="100" style="width: 100%;">
                    </div>
                `);
                
                // Update hidden inputs and display when ranges change
                $('#price-range-min, #price-range-max').on('input', function() {
                    var minVal = parseInt($('#price-range-min').val());
                    var maxVal = parseInt($('#price-range-max').val());
                    
                    // Ensure min is always less than max
                    if (minVal >= maxVal) {
                        if (this.id === 'price-range-min') {
                            maxVal = minVal + 100;
                            $('#price-range-max').val(maxVal);
                        } else {
                            minVal = maxVal - 100;
                            $('#price-range-min').val(minVal);
                        }
                    }
                    
                    $('#price-min').val(minVal);
                    $('#price-max').val(maxVal);
                    $('#price-from').text('₹' + minVal);
                    $('#price-to').text('₹' + maxVal);
                });
            }
        }

        // Search functionality
        var searchTimeout;
        
        // Handle search input changes (typing)
        $('#akasha-product-search-field-0').on('input', function() {
            var searchTerm = $(this).val().trim();
            
            // Clear previous timeout
            clearTimeout(searchTimeout);
            
            // Set a small delay to avoid too many AJAX calls while typing
            searchTimeout = setTimeout(function() {
                performSearch(searchTerm);
            }, 300);
        });
        
        // Handle search form submission
        $('#search-form').on('submit', function(e) {
            e.preventDefault();
            var searchTerm = $('#akasha-product-search-field-0').val().trim();
            performSearch(searchTerm);
        });
        
        // Search function
        function performSearch(searchTerm) {
            console.log('Performing search for:', searchTerm);
            
            $('#ajax-loader').show();
            
            // Clear all filter active states
            $('.ajax-filter-btn').removeClass('active');
            $('input[type="radio"]').prop('checked', false);
            
            if (searchTerm === '') {
                // If search is empty, load all products
                console.log('Search cleared, loading all products');
                $.ajax({
                    url: '<?php echo site_url('products/ajax_products'); ?>',
                    type: 'POST',
                    data: {
                        type: 'all'
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('All products loaded after search clear');
                        if (response.success) {
                            $('#ajax-products-container').html(response.html);
                            try { if (window.initProductCards) window.initProductCards($('#ajax-products-container')); } catch(e) {}
                        } else {
                            alert('Failed to load products: ' + response.message);
                        }
                        $('#ajax-loader').hide();
                    },
                    error: function(xhr, status, error) {
                        console.log('Error loading all products:', status, error);
                        alert('Error loading products: ' + error);
                        $('#ajax-loader').hide();
                    }
                });
            } else {
                // Perform search with the term
                $.ajax({
                    url: '<?php echo site_url('products/ajax_filter_products'); ?>',
                    type: 'POST',
                    data: {
                        search: searchTerm
                    },
                    success: function(response) {
                        console.log('Search completed for:', searchTerm);
                        $('#ajax-products-container').html(response);
                        $('#ajax-loader').hide();
                    },
                    error: function(xhr, status, error) {
                        console.log('Search error:', status, error);
                        console.log('Response:', xhr.responseText);
                        alert('Search error: ' + error);
                        $('#ajax-loader').hide();
                    }
                });
            }
        }
    });
</script>

<script>
    // Test function for AJAX endpoint
    function testAjaxEndpoint() {
        console.log('Testing AJAX endpoint...');
        $.ajax({
            url: '<?php echo site_url('products/test_ajax'); ?>',
            type: 'POST',
            data: {
                test: 'sort',
                value: 'popular'
            },
            success: function(response) {
                console.log('Test AJAX success:', response);
                alert('Test successful: ' + JSON.stringify(response));
            },
            error: function(xhr, status, error) {
                console.log('Test AJAX error:', status, error);
                console.log('Response:', xhr.responseText);
                alert('Test failed: ' + error + '\nResponse: ' + xhr.responseText);
            }
        });
    }
</script> -->