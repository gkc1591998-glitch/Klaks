<div class="main-container shop-page left-sidebar">

    <div class="container pb-2">
        <div class="block-search">
            <form role="search" method="POST" action="<?php echo site_url('search'); ?>" class="form-search block-search-form akasha-live-search-form">
                <div class="search-container">
                    <div class="input-group">
                        <input type="text" name="search_query" class="form-control search-input01"
                            placeholder="Search for products..."
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn search-btn" type="submit" name="submit" value="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <!-- <div class="search-suggestions">
                        <div class="suggestion-header">
                            <span>Popular Searches</span>
                        </div>
                        <div class="suggestion-items">
                            <a href="#" class="suggestion-item">
                                <i class="fa fa-search"></i>
                                <span>Shirts</span>
                            </a>
                            <a href="#" class="suggestion-item">
                                <i class="fa fa-search"></i>
                                <span>T-Shirts</span>
                            </a>
                            <a href="#" class="suggestion-item">
                                <i class="fa fa-search"></i>
                                <span>Jeans</span>
                            </a>
                        </div>
                    </div> -->
                </div>
            </form>
        </div>


    </div>
    <!-- <?php if (isset($debug_result_count) || isset($debug_last_query)): ?>
        <div class="container">
            <div class="alert alert-info" style="word-break:break-all;font-size:12px;">
                <strong>Debug:</strong>
                <div>Results: <?php echo isset($debug_result_count) ? intval($debug_result_count) : 'n/a'; ?></div>
                <?php if (!empty($debug_last_query)): ?>
                    <div style="margin-top:6px;"><em>SQL:</em> <?php echo htmlspecialchars($debug_last_query); ?></div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?> -->
    <!-- <div class="container py-1">
        <div class="row">

            <div class="col-12">
                <h4 class="search-results-title">
                    SEARCH RESULTS
                    <span class="badge badge-dark">3</span>
                </h4>
            </div>
            <div class="col-12">

                <table class="table">
                    <thead class="bg-dark text-white">
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 100px">
                                <a href="product-details.html" target="_blank"><img src="<?php echo site_url() ?>assetsfe/klaks/1.jpg" alt="T-Shirt" style="width: 100%"></a>
                            </td>
                            <td class="align-middle"><a href="product-details.html" target="_blank">T-Shirt</a></td>
                            <td class="align-middle">₹139.00</td>
                        </tr>
                        <tr>
                            <td style="width: 100px">
                                <img src="<?php echo site_url() ?>assetsfe/klaks/2.jpg" alt="Sweatshirt" style="width: 100%">
                            </td>
                            <td class="align-middle">Sweatshirt</td>
                            <td class="align-middle">₹129.00</td>
                        </tr>
                        <tr>
                            <td style="width: 100px">
                                <img src="<?php echo site_url() ?>assetsfe/klaks/3.jpg" alt="T-shirt with skirt" style="width: 100%">
                            </td>
                            <td class="align-middle">T-shirt with skirt – Pink</td>
                            <td class="align-middle">₹150.00</td>
                        </tr>
                    </tbody>
                </table>

            </div>

        </div>
    </div> -->


    <!-- <div class="container py-1">
        <div>
            <div class="category-filter-mobile">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Recent Searches</h6>
                            <div class="searchtag filter-scroll">
                                <a href="klaks-lux.html" class="searchtag filter-btn">PLUS</a>
                                <a href="klaks-lux.html" class="searchtag filter-btn">SHIRTS</a>
                                <a href="klaks-lux.html" class="searchtag filter-btn">OVERSHIRT</a>
                                <a href="klaks-lux.html" class="searchtag filter-btn">LUXE</a>
                                <a href="klaks-lux.html" class="searchtag filter-btn">PLUS</a>
                                <a href="klaks-lux.html" class="searchtag filter-btn">OVERSHIRT</a>
                                <a href="klaks-lux.html" class="searchtag filter-btn">LUXE</a>
                                <a href="klaks-lux.html" class="searchtag filter-btn">PLUS</a>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <h6>Top Searches</h6>
                            <div class="searchtag filter-scroll">
                                <a href="klaks-lux.html" class="searchtag filter-btn">PLUS</a>
                                <a href="klaks-lux.html" class="searchtag filter-btn">SHIRTS</a>
                                <a href="klaks-lux.html" class="searchtag filter-btn">OVERSHIRT</a>
                                <a href="klaks-lux.html" class="searchtag filter-btn">LUXE</a>
                                <a href="klaks-lux.html" class="searchtag filter-btn">PLUS</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <div class="container py-1">
        <div>
            <div class="category-filter-mobile mb-4 ">
                <div class="container">
                    <h6>Trending</h6>
                    <div class="searchtag filter-scroll">
                        <a href="" class="searchtag filter-btn active">ALL</a>
                        <a href="klaks-lux.html" class="searchtag filter-btn">NEW</a>
                        <a href="klaks-lux.html" class="searchtag filter-btn">SHIRTS</a>
                        <a href="klaks-lux.html" class="searchtag filter-btn">OVERSHIRT</a>
                        <a href="klaks-lux.html" class="searchtag filter-btn">LUXE</a>
                        <a href="klaks-lux.html" class="searchtag filter-btn">PLUS</a>
                        <a href="klaks-lux.html" class="searchtag filter-btn">SHIRTS</a>
                        <a href="klaks-lux.html" class="searchtag filter-btn">OVERSHIRT</a>
                        <a href="klaks-lux.html" class="searchtag filter-btn">LUXE</a>
                        <a href="klaks-lux.html" class="searchtag filter-btn">PLUS</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <!-- <?php if (isset($msg_success)) : ?>
                <div class="alert alert-success"><?php echo $msg_success; ?></div>
            <?php endif; ?>
            <?php if (isset($msg_fails)) : ?>
                <div class="alert alert-danger"><?php echo $msg_fails; ?></div>
            <?php endif; ?> -->
            <div class="main-content col-xl-9 col-lg-8 col-md-8 col-sm-12 has-sidebar">
                <div class=" auto-clear equal-container better-height akasha-products">
                    <ul class="row products columns-3">
                        <?php
                            $products = isset($products) ? $products : [];
                            include VIEWPATH . '_product_card_dynamic.php';
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>