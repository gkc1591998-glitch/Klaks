<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url(); ?>assetsfe/klaks/favicon.png" />
    <link
        href="https://fonts.googleapis.com/css?family=BC+Novatic+CYR:400&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assetsfe/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assetsfe/css/animate.css" />
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assetsfe/css/bootstrap.min.css" /> -->
    <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assetsfe/css/chosen.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assetsfe/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assetsfe/css/jquery.scrollbar.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assetsfe/css/lightbox.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assetsfe/css/magnific-popup.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assetsfe/css/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assetsfe/fonts/flaticon.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assetsfe/css/megamenu.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assetsfe/css/dreaming-attribute.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assetsfe/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assetsfe/css/scrolling.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assetsfe/css/product-selectors.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assetsfe/css/toast.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assetsfe/css/wishlist-unified.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assetsfe/css/share-product.css" />
    <title>KLAKS </title>
    <style>
        .size-btn {
            padding: 0px 16px !important;
        }
        
        /* Wishlist Counter Styling */
        .wishlist-counter {
            position: absolute;
            top: 7px;
            right: -8px;
            background: #000;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 10px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            z-index: 10;
        }
        
        .block-link {
            position: relative;
        }
        
        /* Header Icons Alignment */
        .header-control .meta-dreaming {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .header-control .menu-item {
            margin-left: 10px;
        }
        
        .header-control .menu-item:first-child {
            margin-left: 0;
        }
        
        /* Force accessory prices to always be visible */
        .accessory-price-force-show {
            display: inline !important;
            visibility: visible !important;
            opacity: 1 !important;
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
            right: 5px;
            top: 0px;
        }
    </style>
</head>

<body>
    <div id="preloader" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #000; z-index: 10002; display: flex; justify-content: center; align-items: center;">
        <img src="<?php echo site_url(); ?>assetsfe/klaks/logo.png" alt="KLAKS Logo" style="max-width: 200px;">
    </div>
    <header id="header" class="header style-03 header-dark header-transparent" style="position: fixed;">
        <section class="a-section">
            <div class="a-section-marquee-box">
                <div class="marquee-text-wrapper">
                    <?php if (!empty($banners)) { ?>
                        <?php foreach ($banners as $banner) { ?>
                            <a href="#">
                                <h2 class="marquee-text"><?php echo htmlspecialchars($banner['name']); ?></h2><span class="separator">|</span>
                            </a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </section>
        <div class="header-wrap-stick header-desctop">
            <div class="header-position">
                <div class="header-middle">
                    <div class="akasha-menu-wapper"></div>
                    <div class="header-middle-inner">
                        <div class="header-menu">
                            <div class="box-header-nav menu-nocenter">
                                <ul id="menu-primary-menu" class="clone-main-menu akasha-clone-mobile-menu akasha-nav main-menu">
                                    <li id="menu-item-230"
                                        class="menu-item menu-item-type-post_type menu-item-object-megamenu menu-item-230 parent parent-megamenu item-megamenu">
                                        <a class="akasha-menu-item-title" title="Home" href="<?php echo site_url(); ?>home">HOME</a>

                                    </li>

                                    <li id="menu-item-230"
                                        class="menu-item menu-item-type-post_type menu-item-object-megamenu menu-item-230 parent parent-megamenu item-megamenu">
                                        <a class="akasha-menu-item-title" title="Home" href="<?php echo site_url(); ?>products/trending">TRENDING</a>

                                    </li>
                                    <li id="menu-item-230"
                                        class="menu-item menu-item-type-post_type menu-item-object-megamenu menu-item-230 parent parent-megamenu item-megamenu">
                                        <a class="akasha-menu-item-title" title="Home" href="<?php echo site_url(); ?>products/newly_launched">NEWLY LAUNCHED</a>

                                    </li>

                                    <li id="menu-item-230"
                                        class="menu-item menu-item-type-post_type menu-item-object-megamenu menu-item-230 parent parent-megamenu item-megamenu"
                                        style="background-color:#3C3C3C;">
                                        <a style="color:#FFFFFF;" class="akasha-menu-item-title" title="Home" href="<?php echo site_url(); ?>homelux">KLAKS LUX</a>
                                    </li>

                                    <li id="menu-item-230"
                                        class="menu-item menu-item-type-post_type menu-item-object-megamenu menu-item-230 parent parent-megamenu item-megamenu">
                                        <a class="akasha-menu-item-title" title="Home" href="<?php echo site_url(); ?>track">TRACK ORDER </a>

                                    </li>
                                    <li id="menu-item-230"
                                        class="menu-item menu-item-type-post_type menu-item-object-megamenu menu-item-230 parent parent-megamenu item-megamenu">
                                        <a class="akasha-menu-item-title" title="Home" href="<?php echo site_url(); ?>returns">RETURN/EXCHANGE </a>

                                    </li>

                                    <li id="menu-item-230"
                                        class="menu-item menu-item-type-post_type menu-item-object-megamenu menu-item-230 parent parent-megamenu item-megamenu">
                                        <a class="akasha-menu-item-title" title="Home" href="<?php echo site_url(); ?>contactus">CUSTOMER SUPPORT </a>

                                    </li>

                                </ul>
                            </div>
                            <div class="block-menu-bar">
                                <a class="menu-bar menu-toggle" href="#">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </a>
                            </div>
                        </div>
                        <div class="header-logo">
                            <a href="<?php echo site_url(); ?>home"><img alt="Akasha" src="<?php echo site_url(); ?>/images/logo/<?php echo $web_settings['logo']; ?>" class="logo"></a>
                        </div>
                        <div class="header-control">
                            <div class="header-control-inner">
                                <div class="meta-dreaming">

                                    <div class="header-search ">
                                        <div class=" ">
                                            <a href="<?php echo site_url(); ?>search" class=" block-link">
                                                <span class="flaticon-magnifying-glass-1"></span>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="akasha-dropdown-close">x</div>
                                    
                                    <!-- Wishlist Icon - Desktop -->
                                    <?php
                                    $wishlist_count = 0;
                                    if ($this->session->userdata('user_id')) {
                                        $this->load->model('Wishlist_model');
                                        $wishlist_count = $this->Wishlist_model->get_wishlist_count($this->session->userdata('user_id'));
                                    }
                                    $this->load->view('partials/wishlist_icon', [
                                        'is_header' => true,
                                        'url' => site_url('dashboard/wishlist'),
                                        'count' => $wishlist_count
                                    ]);
                                    ?>
                                    
                                    <!-- User Profile Dropdown -->
                                    <div class="menu-item block-user block-dreaming akasha-dropdown">
                                        <div class="shopcart-dropdown block-cart-link" data-akasha="akasha-dropdown">
                                            <?php if ($this->session->userdata('user_id') != '') { ?>
                                                <a class="block-link link-dropdown" href="<?php echo site_url(); ?>dashboard">
                                                    <span class="flaticon-profile"></span>
                                                </a>
                                                <a class="block-link link-dropdown" href="<?php echo site_url(); ?>logout">
                                                    <span class="flaticon-profile">Logout</span>
                                                </a>
                                            <?php } else { ?>
                                                <a class="block-link" href="<?php echo site_url(); ?>login">
                                                    <span class="flaticon-profile">Login</span>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Web/Desktop Cart Section (original) -->
                                    <div class="menu-item block-minicart block-dreaming akasha-mini-cart akasha-dropdown" id="cartdivid">
                                        <?php if ($this->cart->total_items() == 0) { ?>
                                            <div class="shopcart-dropdown block-cart-link" data-akasha="akasha-dropdown">
                                                <a class="block-link link-dropdown" href="#">
                                                    <span class="flaticon-bag"></span>
                                                    <span class="count">0</span>
                                                </a>
                                            </div>
                                        <?php } else { ?>
                                            <div class="shopcart-dropdown block-cart-link" data-akasha="akasha-dropdown">
                                                <a class="block-link link-dropdown" href="<?php echo site_url(); ?>cart">
                                                    <span class="flaticon-bag"></span>
                                                    <span class="count"><?php echo $this->cart->total_items(); ?></span>
                                                </a>
                                            </div>
                                            <div class="widget akasha widget_shopping_cart">
                                                <div class="widget_shopping_cart_content">
                                                    <h3 class="minicart-title">Your Cart<span class="minicart-number-items"><?php echo $this->cart->total_items(); ?></span></h3>
                                                    <ul class="akasha-mini-cart cart_list product_list_widget">
                                                        <?php foreach ($this->cart->contents() as $items) { ?>
                                                            <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
                                                                <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
                                                                    <?php $psize = ''; ?>
                                                                    <?php if ($option_name == 'image') { ?>
                                                                        <li class="akasha-mini-cart-item mini_cart_item">
                                                                            <a href="javascript:void(0);" class="remove remove_from_cart_button" data-rowid="<?php echo $items['rowid']; ?>" onClick="deletecart('<?php echo $items['rowid']; ?>');">×</a>
                                                                            <a href="<?php echo site_url(); ?>products/product_view/<?php echo stripslashes(str_replace('\n', '', $items['id'])) ?>/<?php echo $psize ?>">
                                                                                <img src="<?php echo site_url(); ?>images/products/<?php echo $option_value; ?>"
                                                                                    class="attachment-akasha_thumbnail size-akasha_thumbnail"
                                                                                    alt="img" width="600" height="778">
                                                                                <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
                                                                                    <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
                                                                                        <?php if ($option_name == 'size') { ?>
                                                                                            <?php $psize = $option_value; ?>
                                                                                            <a href="<?php echo site_url(); ?>products/product_view/<?php echo stripslashes(str_replace('\n', '', $items['id'])) ?>/<?php echo $psize ?>">
                                                                                                <?php echo $items['name'] ?>&nbsp;(<?php echo $option_value; ?>)
                                                                                            </a>
                                                                                        <?php } ?>
                                                                                    <?php endforeach; ?>
                                                                                <?php endif; ?>
                                                                            </a>
                                                                            <span class="quantity"><?php echo $items['qty']; ?> × <span
                                                                                    class="akasha-Price-amount amount"><span
                                                                                        class="akasha-Price-currencySymbol">₹</span><?php echo $items['price']; ?></span></span>
                                                                        </li>
                                                                    <?php } ?>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        <?php } ?>
                                                    </ul>
                                                    <p class="akasha-mini-cart__total total"><strong>Subtotal:</strong>
                                                        <span class="akasha-Price-amount amount"><span
                                                                class="akasha-Price-currencySymbol">₹</span><?php echo number_format($this->cart->total()); ?></span>
                                                    </p>
                                                    <p class="akasha-mini-cart__buttons buttons">
                                                        <a href="<?php echo site_url(); ?>cart" class="button akasha-forward">Viewcart</a>
                                                        <a href="<?php echo site_url(); ?>checkout" class="button checkout akasha-forward">Checkout</a>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                        <?php if ($this->cart->total_items() == 0) { ?>
                                            <div class="shopcart-dropdown block-cart-link" data-akasha="akasha-dropdown">
                                                <a class="block-link link-dropdown" href="#">
                                                    <span class="flaticon-bag"></span>
                                                    <span class="count">0</span>
                                                </a>
                                            </div>
                                        <?php } else { ?>
                                            <div class="shopcart-dropdown block-cart-link" data-akasha="akasha-dropdown">
                                                <a class="block-link link-dropdown" href="<?php echo site_url(); ?>cart">
                                                    <span class="flaticon-bag"></span>
                                                    <span class="count"><?php echo $this->cart->total_items(); ?></span>
                                                </a>
                                            </div>
                                            <div class="widget akasha widget_shopping_cart">
                                                <div class="widget_shopping_cart_content">
                                                    <h3 class="minicart-title">Your Cart<span class="minicart-number-items"><?php echo $this->cart->total_items(); ?></span></h3>
                                                    <ul class="akasha-mini-cart cart_list product_list_widget">
                                                        <?php foreach ($this->cart->contents() as $items) { ?>
                                                            <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
                                                                <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
                                                                    <?php $psize = ''; ?>
                                                                    <?php if ($option_name == 'image') { ?>
                                                                        <li class="akasha-mini-cart-item mini_cart_item">
                                                                            <a href="javascript:void(0);" class="remove remove_from_cart_button" data-rowid="<?php echo $items['rowid']; ?>" onClick="deletecart('<?php echo $items['rowid']; ?>');">×</a>
                                                                            <a href="<?php echo site_url(); ?>products/product_view/<?php echo stripslashes(str_replace('\n', '', $items['id'])) ?>/<?php echo $psize ?>">
                                                                                <img src="<?php echo site_url(); ?>images/products/<?php echo $option_value; ?>"
                                                                                    class="attachment-akasha_thumbnail size-akasha_thumbnail"
                                                                                    alt="img" width="600" height="778">
                                                                                <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
                                                                                    <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
                                                                                        <?php if ($option_name == 'size') { ?>
                                                                                            <?php $psize = $option_value; ?>
                                                                                            <a href="<?php echo site_url(); ?>products/product_view/<?php echo stripslashes(str_replace('\n', '', $items['id'])) ?>/<?php echo $psize ?>">
                                                                                                <?php echo $items['name'] ?>&nbsp;(<?php echo $option_value; ?>)
                                                                                            </a>
                                                                                        <?php } ?>
                                                                                    <?php endforeach; ?>
                                                                                <?php endif; ?>
                                                                            </a>
                                                                            <span class="quantity"><?php echo $items['qty']; ?> × <span
                                                                                    class="akasha-Price-amount amount"><span
                                                                                        class="akasha-Price-currencySymbol">₹</span><?php echo $items['price']; ?></span></span>
                                                                        </li>
                                                                    <?php } ?>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        <?php } ?>
                                                    </ul>
                                                    <p class="akasha-mini-cart__total total"><strong>Subtotal:</strong>
                                                        <span class="akasha-Price-amount amount"><span
                                                                class="akasha-Price-currencySymbol">₹</span><?php echo number_format($this->cart->total()); ?></span>
                                                    </p>
                                                    <p class="akasha-mini-cart__buttons buttons">
                                                        <a href="<?php echo site_url(); ?>cart" class="button akasha-forward">Viewcart</a>
                                                        <a href="<?php echo site_url(); ?>checkout" class="button checkout akasha-forward">Checkout</a>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-mobile">
            <div class="header-mobile-left wt">
                <div class="block-menu-bar">
                    <a class="menu-bar menu-toggle" href="#">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>

                </div>

            </div>

            <div class="header-mobile-left wt">
                <style>
                    .icon-logo {
                        width: 34px !important;

                    }
                </style>
                <div class="header-logo icon-logo">
                    <!-- <a href="<?php echo site_url(); ?>homelux"><img alt="Akasha" src="<?php echo site_url(); ?>/assetsfe/klaks/icon.png" class="logo"></a> -->
                </div>
            </div>

            <div class="header-mobile-mid wt2">
                <div class="header-logo">
                    <a href="<?php echo site_url(); ?>home"><img alt="Akasha" src="<?php echo site_url(); ?>/images/logo/<?php echo $web_settings['logo']; ?>" class="logo"></a>
                </div>
            </div>
            <div class="header-mobile-right wt3">
                <div class="header-control-inner">
                    <div class="meta-dreaming">
                        <div class="header-search akasha-dropdown">
                            <div class="header-search ">
                                <div class="header-search-inner">
                                    <a href="<?php echo site_url(); ?>search" class="link-dropdown block-link">
                                        <span class="flaticon-magnifying-glass-1"></span>
                                    </a>
                                </div>
                            </div>
                            <!-- <div class="block-search">
                                        <form role="search" method="get"
                                              class="form-search block-search-form akasha-live-search-form">
                                            <div class="form-content search-box results-search">
                                                <div class="inner">
                                                    <input autocomplete="off" class="searchfield txt-livesearch input"
                                                           name="s" value="" placeholder="Search here..." type="text">
                                                </div>
                                            </div>
                                            <input name="post_type" value="product" type="hidden">
                                            <input name="taxonomy" value="product_cat" type="hidden">
                                            <div class="category">
                                                <select title="product_cat" name="product_cat"
                                                        class="category-search-option"
                                                        tabindex="-1">
                                                    <option value="0">All Categories</option>
                                                    <option class="level-0" value="light">Shirts</option>
                                                    <option class="level-0" value="chair">T-Shirts</option>
                                                    <option class="level-0" value="table">Jeans</option>
                                                    <option class="level-0" value="bed">Jackets</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn-submit">
                                                <span class="flaticon-magnifying-glass-1"></span>
                                            </button>
                                        </form>
                                    </div> -->
                        </div>

                        <style>
                            .video-height {
                                height: 100% !important;
                                width: 100% !important
                            }

                            .wt2 {
                                width: 70% !important;
                            }

                            wt3 {
                                width: 20% !important;
                            }

                            .wt {
                                width: 5% !important;
                            }

                            @media (max-width: 728px) {
                                .mobile-account {
                                    display: none !important;
                                }

                                .video-height {
                                    height: 266px !important;
                                    width: 100% !important
                                }

                                .wt {
                                    width: 10% !important;
                                }

                                .wt2 {
                                    width: 33.33% !important;
                                }
                            }
                        </style>
                        
                        <!-- Wishlist Icon for Mobile -->
                        <?php
                        $wishlist_count_mobile = 0;
                        if ($this->session->userdata('user_id')) {
                            $this->load->model('Wishlist_model');
                            $wishlist_count_mobile = $this->Wishlist_model->get_wishlist_count($this->session->userdata('user_id'));
                        }
                        $this->load->view('partials/wishlist_icon', [
                            'is_header' => true,
                            'url' => site_url('dashboard/wishlist'),
                            'count' => $wishlist_count_mobile
                        ]);
                        ?>
                        
                        <div class="menu-item block-user block-dreaming akasha-dropdown mobile-account">
                            <!-- <a class="block-link" href="<?php echo site_url(); ?>login">
                            <span class="flaticon-profile"></span>
                        </a> -->
                            <?php if ($this->session->userdata('user_id') != '') { ?>
                                <a class="block-link link-dropdown" href="<?php echo site_url(); ?>dashboard">
                                    <span class="flaticon-profile"></span>
                                </a>
                                <!-- <a class="block-link link-dropdown" href="<?php echo site_url(); ?>logout">
                                <span class="flaticon-profile">Logout</span>
                            </a> -->
                            <?php } else { ?>
                                <a class="block-link" href="<?php echo site_url(); ?>login">
                                    <span class="flaticon-profile"></span>
                                </a>
                            <?php } ?>
                        </div>
                        <!-- Mobile Cart Section (visible on mobile only) -->
                        <div class="block-minicart block-dreaming akasha-mini-cart akasha-dropdown mobile-cart" id="mobile-cartdivid">
                            <?php if ($this->cart->total_items() == 0) { ?>
                                <div class="shopcart-dropdown block-cart-link" data-akasha="akasha-dropdown">
                                    <a class="block-link link-dropdown" href="#">
                                        <span class="flaticon-bag"></span>
                                        <span class="count">0</span>
                                    </a>
                                </div>
                            <?php } else { ?>
                                <div class="shopcart-dropdown block-cart-link" data-akasha="akasha-dropdown">
                                    <a class="block-link link-dropdown" href="<?php echo site_url(); ?>cart">
                                        <span class="flaticon-bag"></span>
                                        <span class="count"><?php echo $this->cart->total_items(); ?></span>
                                    </a>
                                </div>
                                <div class="widget akasha widget_shopping_cart">
                                    <div class="widget_shopping_cart_content">
                                        <h3 class="minicart-title">Your Cart<span class="minicart-number-items"><?php echo $this->cart->total_items(); ?></span></h3>
                                        <ul class="akasha-mini-cart cart_list product_list_widget">
                                            <?php foreach ($this->cart->contents() as $items) { ?>
                                                <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
                                                    <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
                                                        <?php $psize = ''; ?>
                                                        <?php if ($option_name == 'image') { ?>
                                                            <li class="akasha-mini-cart-item mini_cart_item">
                                                                <a href="javascript:void(0);" class="remove remove_from_cart_button" data-rowid="<?php echo $items['rowid']; ?>" onClick="deletecart('<?php echo $items['rowid']; ?>');">×</a>
                                                                <a href="<?php echo site_url(); ?>products/product_view/<?php echo stripslashes(str_replace('\n', '', $items['id'])) ?>/<?php echo $psize ?>">
                                                                    <img src="<?php echo site_url(); ?>images/products/<?php echo $option_value; ?>"
                                                                        class="attachment-akasha_thumbnail size-akasha_thumbnail"
                                                                        alt="img" width="600" height="778">
                                                                    <!-- <?php echo $items['name']; ?>&nbsp; -->
                                                                    <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
                                                                        <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
                                                                            <?php if ($option_name == 'size') { ?>
                                                                                <?php $psize = $option_value; ?>
                                                                                <a href="<?php echo site_url(); ?>products/product_view/<?php echo stripslashes(str_replace('\n', '', $items['id'])) ?>/<?php echo $psize ?>">
                                                                                    <?php echo $items['name'] ?>&nbsp;(<?php echo $option_value; ?>)
                                                                                </a>
                                                                            <?php } ?>
                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                </a>
                                                                <span class="quantity"><?php echo $items['qty']; ?> × <span
                                                                        class="akasha-Price-amount amount"><span
                                                                            class="akasha-Price-currencySymbol">₹</span><?php echo $items['price']; ?></span></span>
                                                            </li>
                                                        <?php } ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php } ?>
                                        </ul>
                                        <p class="akasha-mini-cart__total total"><strong>Subtotal:</strong>
                                            <span class="akasha-Price-amount amount"><span
                                                    class="akasha-Price-currencySymbol">₹</span><?php echo number_format($this->cart->total()); ?></span>
                                        </p>
                                        <p class="akasha-mini-cart__buttons buttons">
                                            <a href="<?php echo site_url(); ?>cart" class="button akasha-forward">Viewcart</a>
                                            <a href="<?php echo site_url(); ?>checkout" class="button checkout akasha-forward">Checkout</a>
                                        </p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
    </header>