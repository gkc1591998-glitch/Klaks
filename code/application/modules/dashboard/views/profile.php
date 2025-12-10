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
                        <div class="main-content col-md-12">
                            <?php if ($this->session->flashdata('msg_succ') != '') { ?>
                                <div class="alert alert-block alert-success col-sm-12">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <i class="ace-icon fa fa-times"></i>
                                    </button>
                                    <p>
                                        <?php echo $this->session->flashdata('msg_succ') ? $this->session->flashdata('msg_succ') : ''; ?>
                                    </p>
                                </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('msg_fail_order') != '') { ?>
                                <div class="alert alert-block alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <i class="ace-icon fa fa-times"></i>
                                    </button>
                                    <p>
                                        <?php echo $this->session->flashdata('msg_fail_order') ? $this->session->flashdata('msg_fail_order') : ''; ?>
                                    </p>
                                </div>
                            <?php } ?>
                            <div class="page-main-content">
                                <div class="akasha">
                                    <div class="akasha-notices-wrapper"></div>
                                    <form action="<?php echo site_url(); ?>Register/edit" name="billing_form" id="billing" enctype="multipart/form-data" method="post" class="checkout akasha-checkout">
                                        <div class="col2-set" id="customer_details">
                                            <div class="col-1">
                                                <div class="akasha-billing-fields">
                                                    <h3>Profile update - <?php echo $this->session->userdata('user_name'); ?></h3>
                                                    <div class="akasha-billing-fields__field-wrapper">
                                                        <p class="form-row form-row-wide validate-required"
                                                            id="billing_first_name_field" data-priority="10"><label
                                                                for="billing_first_name" class="">First name&nbsp;</label><span
                                                                class="akasha-input-wrapper"><input type="text"
                                                                    class="input-text "
                                                                    name="fname"
                                                                    id="fname"
                                                                    value="<?php echo $record['fname']; ?>">

                                                            </span>
                                                        </p>
                                                        <p class="form-row form-row-wide validate-required"
                                                            id="billing_last_name_field" data-priority="20"><label
                                                                for="billing_last_name" class="">Last name&nbsp;</label><span
                                                                class="akasha-input-wrapper"><input type="text"
                                                                    class="input-text "
                                                                    name="lname"
                                                                    id="lname"
                                                                    placeholder="" value="<?php echo $record['lname']; ?>"
                                                                    autocomplete="family-name">

                                                            </span>

                                                        </p>
                                                        <p class="form-row form-row-wide validate-required validate-phone"
                                                            id="billing_phone_field" data-priority="100"><label for="billing_phone"
                                                                class="">Phone&nbsp;</label><span
                                                                class="akasha-input-wrapper"><input type="tel"
                                                                    class="input-text "
                                                                    name="mobile"
                                                                    id="mobile"
                                                                    placeholder="" value="<?php echo $record['mobile']; ?>"
                                                                    autocomplete="tel"></span>

                                                        </p>
                                                        <p class="form-row form-row-wide validate-required validate-email"
                                                            id="billing_email_field" data-priority="110"><label for="billing_email"
                                                                class="">Email
                                                                address&nbsp;</label><span
                                                                class="akasha-input-wrapper"><input type="email"
                                                                    class="input-text "
                                                                    name="email"
                                                                    id="email"
                                                                    placeholder="" value="<?php echo $record['email']; ?>"
                                                                    autocomplete="email username"></span>

                                                        </p>
                                                        <p class="form-row form-row-wide adchair-field validate-required"
                                                            id="billing_adchair_1_field" data-priority="50"><label
                                                                for="billing_adchair_1" class="">Street Address&nbsp;</label><span
                                                                class="akasha-input-wrapper"><input type="text"
                                                                    class="input-text "
                                                                    name="location"
                                                                    id="location"
                                                                    value="<?php echo $record['location']; ?>"

                                                                    </span>

                                                        </p>

                                                        <p class="form-row form-row-wide adchair-field validate-postcode"
                                                            id="billing_postcode_field" data-priority="65"
                                                            data-o_class="form-row form-row-wide adchair-field validate-postcode">
                                                            <label for="billing_postcode" class="">Postcode / ZIP&nbsp;</label><span
                                                                class="akasha-input-wrapper"><input type="text"
                                                                    class="input-text "
                                                                    name="zipcode"
                                                                    id="zipcode"
                                                                    placeholder="" value="<?php echo $record['zipcode']; ?>"
                                                                    autocomplete="postal-code"></span>

                                                        </p>
                                                        <p class="form-row form-row-wide adchair-field validate-required"
                                                            id="billing_city_field" data-priority="70"
                                                            data-o_class="form-row form-row-wide adchair-field validate-required">
                                                            <label for="billing_city" class="">Town / City&nbsp;</label><span
                                                                class="akasha-input-wrapper"><input type="text"
                                                                    class="input-text "
                                                                    name="city"
                                                                    id="city"
                                                                    placeholder="" value="<?php echo $record['city']; ?>"
                                                                    autocomplete="adchair-level2"></span>

                                                        </p>
                                                        <p class="form-row form-row-wide validate-required validate-phone"
                                                            id="billing_phone_field" data-priority="100"><label for="billing_phone"
                                                                class="">State&nbsp;</label><span
                                                                class="akasha-input-wrapper"><input type="tel"
                                                                    class="input-text "
                                                                    name="state"
                                                                    id="state"
                                                                    placeholder="" value="<?php echo $record['state']; ?>"
                                                                    autocomplete="tel"></span>

                                                        </p>
                                                        <p class="form-row form-row-wide validate-required validate-phone"
                                                            id="billing_phone_field" data-priority="100"><label for="billing_phone"
                                                                class="">Country&nbsp;</label><span
                                                                class="akasha-input-wrapper"><input type="tel"
                                                                    class="input-text "
                                                                    name="country"
                                                                    id="country"
                                                                    placeholder="" value="<?php echo $record['country']; ?>"
                                                                    autocomplete="tel"></span>

                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="button alt" name="submit" id="place_order" value="submit" data-value="">Update
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </main> -->
            </div>
        </div>
    </div>
</div>