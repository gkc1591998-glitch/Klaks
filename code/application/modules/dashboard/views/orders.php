<div class="main-container shop-page left-sidebar">
    <div class="row">
        <div class="sidebar col-xl-3 col-lg-4 col-md-4 col-sm-12">
            <div class="shop-control">
                <div class="grid-view-mode pc filter">
                    <style>
                        @media (min-width: 991px) {
                            .pc{
                                display: none!important;
                            }
                            .filter{
                            padding-top: 7px;
                        }
                        }
                        
                        @media (max-width: 768px) {
                            .pc2{
                                display: none!important;
                            }
                            .filter{
                            padding-top: 7px;
                        }
                        }
                    </style>
                </div>
            </div>
            <div id="widget-area" class="widget-area shop-sidebar">
                <div id="akasha_product_categories-3" class="widget akasha widget_product_categories">
                    <h2 class="ml-4"><a href="<?php echo site_url()?>dashboard">Dashboard</a></h2>
                    <ul class="product-categories ml-4" style="list-style-type: none;">
                        <li class=""><a href="<?php echo site_url()?>dashboard/profile">Profile</a>
                        </li>
                        <li class=""><a href="<?php echo site_url()?>dashboard/orders">Orders</a>
                        </li>
                        <!-- <li class=""><a href="<?php echo site_url()?>dashboard/address">Address</a>
                        </li> -->
                        <li class=""><a href="<?php echo site_url()?>dashboard/wishlist">Wishlist</a>
                        </li>
                        <li class=""><a href="<?php echo site_url()?>login/logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    
        <div class="main-content col-xl-9 col-lg-8 col-md-8 col-sm-12 has-sidebar">
            <div class=" auto-clear equal-container better-height akasha-products">            
            <div class="container">
                <div class="row">
                    <div class="main-content col-md-12">
                        <div class="page-main-content">
                            <div class="akasha">
                                <div class="akasha-notices-wrapper"><h1 style='color: #890000;'>Orders</h1></div>
                                    <table class="shop_table shop_table_responsive cart akasha-cart-form__contents"
                                        cellspacing="0">
                                        <thead>
                                        <tr>
                                            <!-- <th class="product-remove">&nbsp;</th> -->
                                            <th class="product-thumbnail">Image</th>
                                            <th class="product-name">Product</th>
                                            <th class="product-name">Size</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-quantity">Quantity</th>
                                            <th class="product-subtotal">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(count($products) > 0){ foreach($products as $key => $value){ ?>
                                        <tr class="akasha-cart-form__cart-item cart_item">
                                            <td class="product-thumbnail">
                                                <a href="<?php echo site_url();?>products/product_view/<?php echo stripslashes(str_replace('\n','',$value['id']))?>"><img src="<?php echo site_url();?>images/products/<?php echo stripslashes(str_replace('\n','',$value['image']))?>" class="attachment-akasha_thumbnail size-akasha_thumbnail"
                                                alt="img" width="600" height="778"></a>      
                                            </td>
                                            <td class="product-name" data-title="Product">
                                                <a href="#"><?php echo $value['name']; ?></a>
                                            </td>
                                            <!-- <td class="product-name product-size-div">
                                                <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
                                                    <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?> 
                                                        <?php if($option_name=='size'){ ?>
                                                            <a class="change-value color change_status_cart" <?php if($option_value == "XS"){ echo 'style="font-weight:bold; color: #890000;"';} ?> href="javascript:void(0);">XS</a>
                                                            <a class="change-value color change_status_cart" <?php if($option_value == "S"){ echo 'style="font-weight:bold; color: #890000;"';} ?> href="javascript:void(0);">S</a>
                                                            <a class="change-value color change_status_cart" <?php if($option_value == "M"){ echo 'style="font-weight:bold; color: #890000;"';} ?> href="javascript:void(0);">M</a>
                                                            <a class="change-value color change_status_cart" <?php if($option_value == "L"){ echo 'style="font-weight:bold; color: #890000;"';} ?> href="javascript:void(0);">L</a>
                                                            <a class="change-value color change_status_cart" <?php if($option_value == "XL"){ echo 'style="font-weight:bold; color: #890000;"';} ?> href="javascript:void(0);">XL</a>
                                                            <a class="change-value color change_status_cart" <?php if($option_value == "2XL"){ echo 'style="font-weight:bold; color: #890000;"';} ?> href="javascript:void(0);">2XL</a>
                                                            <a class="change-value color change_status_cart" <?php if($option_value == "3XL"){ echo 'style="font-weight:bold; color: #890000;"';} ?> href="javascript:void(0);">3XL</a>
                                                            <div class="product-values">
                                                                <input type="hidden" class="product_size" value="<?php echo $option_value; ?>">
                                                                <input type="hidden" class="product_id" value="<?php echo $items['id']; ?>">
                                                                <input type="hidden" class="cart_row_id" value="<?php echo $items['rowid']; ?>">
                                                            </div>
                                                        <?php }?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </td> -->
                                            <td class="product-name product-size-div" data-title="Size">
                                                <span class="akasha-Price-amount amount"><span
                                                        class="akasha-Price-currencySymbol"></span id="product_price"><?php echo $value['sizes']; ?></span>
                                            </td>
                                            <td class="product-price" data-title="Price">
                                                <span class="akasha-Price-amount amount"><span
                                                        class="akasha-Price-currencySymbol">₹</span id="product_price"><?php echo $value['price']; ?></span>
                                            </td>
                                            <td class="product-quantity" data-title="Quantity">
                                                <span class="akasha-Price-amount amount"><span
                                                        class="akasha-Price-currencySymbol"></span id="product_price"><?php echo $value['qty']; ?></span>
                                            </td>
                                            <td class="product-subtotal" data-title="Total">
                                                <span class="akasha-Price-amount amount">
                                                    <span class="akasha-Price-currencySymbol">₹</span><?php echo stripslashes(str_replace("\n","",$value['sub_total'])); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6"><b style='color: #890000; font-size: 15px;'>Shipping Address:</b></br>
                                                <b>Name: </b> &nbsp;&nbsp;<?php echo stripslashes(str_replace("\n","",$value['delivery_address']['first_name']));?>&nbsp;<?php echo stripslashes(str_replace("\n","",$value['delivery_address']['last_name']));?></br>
                                                <b>Mobile: </b> &nbsp;&nbsp; <?php echo stripslashes(str_replace("\n","",$value['delivery_address']['mobile']));?> </br>
                                                <b>Email: </b> &nbsp;&nbsp; <?php echo stripslashes(str_replace("\n","",$value['delivery_address']['email']));?></br>
                                                <b>Address : </b> &nbsp;&nbsp; <?php echo stripslashes(str_replace("\n","",$value['delivery_address']['location']));?>,<?php echo stripslashes(str_replace("\n","",$value['delivery_address']['city']));?>,<?php echo stripslashes(str_replace("\n","",$value['delivery_address']['state']));?>,<?php echo stripslashes(str_replace("\n","",$value['delivery_address']['country']));?></br>
                                                <b>Zip Code : </b> &nbsp;&nbsp; <?php echo stripslashes(str_replace("\n","",$value['delivery_address']['zipcode']));?></br>
                                                <b>Order created on : </b> &nbsp;&nbsp; <b><?php echo date('d-M-Y h:i A',strtotime($value['delivery_address']['order_created_on']));?></b>
                                            </td>
                                        </tr>
                                        <?php } } else {?>
                                            <tr>
                                                <h4> No orders found!</h4>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- <main class="site-main main-container no-sidebar">
    <div class="container">
        <div class="row">
            <div class="main-content col-md-12">
                <div class="page-main-content">
                    <div class="akasha">
                        <div class="akasha-notices-wrapper"></div>
                        <form class="akasha-cart-form" id="cartid">
                            <table class="shop_table shop_table_responsive cart akasha-cart-form__contents"
                                   cellspacing="0">
                                <thead>
                                <tr>
                                    <th class="product-remove">&nbsp;</th>
                                    <th class="product-thumbnail"></th>
                                    <th class="product-name">Product</th>
                                    <th class="product-name">Size</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-subtotal">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($this->cart->contents() as $items){ ?>
                                <tr class="akasha-cart-form__cart-item cart_item">
                                    <td class="product-remove">
                                        <a href="#"
                                           class="remove" aria-label="Remove this item" data-product_id=""
                                           data-product_sku="" onclick="deletecartcheckout('<?php echo $items['rowid']; ?>');">×</a></td>
                                    <td class="product-thumbnail">
                                        <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
                                            <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?> 
                                                <?php if($option_name=='image'){ ?>
							                        <a href="<?php echo site_url();?>products/product_view/<?php echo stripslashes(str_replace('\n','',$items['id']))?>"><img src="<?php echo site_url();?>images/products/<?php echo $option_value; ?>" class="attachment-akasha_thumbnail size-akasha_thumbnail"
                                                    alt="img" width="600" height="778"></a>
							                    <?php }?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="product-name" data-title="Product">
                                        <a href="#"><?php echo $items['name']; ?></a>
                                    </td>
                                    <td class="product-name product-size-div">
                                        <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
                                            <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?> 
                                                <?php if($option_name=='size'){ ?>
                                                    <a class="change-value color change_status_cart" <?php if($option_value == "XS"){ echo 'style="font-weight:bold; color: #890000;"';} ?> href="javascript:void(0);">XS</a>
                                                    <a class="change-value color change_status_cart" <?php if($option_value == "S"){ echo 'style="font-weight:bold; color: #890000;"';} ?> href="javascript:void(0);">S</a>
                                                    <a class="change-value color change_status_cart" <?php if($option_value == "M"){ echo 'style="font-weight:bold; color: #890000;"';} ?> href="javascript:void(0);">M</a>
                                                    <a class="change-value color change_status_cart" <?php if($option_value == "L"){ echo 'style="font-weight:bold; color: #890000;"';} ?> href="javascript:void(0);">L</a>
                                                    <a class="change-value color change_status_cart" <?php if($option_value == "XL"){ echo 'style="font-weight:bold; color: #890000;"';} ?> href="javascript:void(0);">XL</a>
                                                    <a class="change-value color change_status_cart" <?php if($option_value == "2XL"){ echo 'style="font-weight:bold; color: #890000;"';} ?> href="javascript:void(0);">2XL</a>
                                                    <a class="change-value color change_status_cart" <?php if($option_value == "3XL"){ echo 'style="font-weight:bold; color: #890000;"';} ?> href="javascript:void(0);">3XL</a>
                                                    <div class="product-values">
                                                        <input type="hidden" class="product_size" value="<?php echo $option_value; ?>">
                                                        <input type="hidden" class="product_id" value="<?php echo $items['id']; ?>">
                                                        <input type="hidden" class="cart_row_id" value="<?php echo $items['rowid']; ?>">
                                                    </div>
                                                <?php }?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="product-price" data-title="Price">
                                        <span class="akasha-Price-amount amount"><span
                                                class="akasha-Price-currencySymbol">₹</span id="product_price"><?php echo $items['price']; ?></span>
                                    </td>
                                    <td class="product-quantity" data-title="Quantity">
                                        <div class="quantity">
                                            <span class="qty-label">Quantiy:</span>
                                            <div class="control">
                                                <a class="btn-number qtyminus quantity-minus" id="cart-subs-<?php echo $items['rowid']; ?>" onclick="subs('<?php echo $items['rowid']; ?>', <?php echo $items['id']; ?>,'cartPage')">-</a>
                                                <input type="text" data-step="1" min="1" max="10" name="quantity" value="<?php echo $items['qty']; ?>" title="Qty" class="input-qty input-text qty text" size="4" pattern="[0-9]*" inputmode="numeric" id="cart-qnty-<?php echo $items['rowid']; ?>">
                                                <a class="btn-number qtyplus quantity-plus" id="cart-adds-<?php echo $items['rowid']; ?>" onclick="adds('<?php echo $items['rowid']; ?>',<?php echo $items['id']; ?>,'cartPage')">+</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="product-subtotal" data-title="Total">
                                        <span class="akasha-Price-amount amount">
                                            <span class="akasha-Price-currencySymbol">₹</span><?php echo stripslashes(str_replace("\n","",$items['subtotal'])); ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        
                            <div class="cart-collaterals">
                                <div class="cart_totals ">
                                    <h2>Cart totals</h2>
                                    <table class="shop_table shop_table_responsive" cellspacing="0">
                                        <tbody>
                                        <tr class="cart-subtotal">
                                            <th>Subtotal</th>
                                            <td data-title="Subtotal">
                                                <span class="akasha-Price-amount amount">
                                                <span class="akasha-Price-currencySymbol">
                                                ₹</span><?php echo number_format($this->cart->total());?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="order-total">
                                            <th>Total</th>
                                            <td data-title="Total">
                                                <strong>
                                                    <span class="akasha-Price-amount amount">
                                                    <span class="akasha-Price-currencySymbol">
                                                    ₹</span><?php echo number_format($this->cart->total());?> 
                                                    <span>
                                                </strong>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="akasha-proceed-to-checkout">
                                        <a href="<?php echo site_url();?>checkout/check"
                                        class="checkout-button button alt akasha-forward">
                                            Proceed to checkout</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-12 col-sm-12 dreaming_crosssell-product">
                            <div class="block-title">
                                <h2 class="product-grid-title">
                                    <span>Cross Sell Products</span>
                                </h2>
                            </div>
                            <div class="owl-slick owl-products equal-container better-height"
                                 data-slick="{&quot;arrows&quot;:false,&quot;slidesMargin&quot;:30,&quot;dots&quot;:true,&quot;infinite&quot;:false,&quot;slidesToShow&quot;:4}"
                                 data-responsive="[{&quot;breakpoint&quot;:480,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:768,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:992,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1500,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;30&quot;}}]">
                                <div class="product-item style-01 post-278 page type-page status-publish hentry">
                                    <div class="product-inner tooltip-right">
										<div class="product-thumb">
											<a class="thumb-link"
											   href="#" tabindex="0">
												<img class="img-responsive"
													 src="assetsfe/klaks/1.jpg"
													 alt="Utility Pockets" width="270" height="350">
											</a>
											<div class="flash">
												<span class="onnew"><span class="text">New</span></span></div>
										</div>
									   <div class="product-info equal-elem">
                                            <h3 class="product-name product_title">
                                                <a href="#">Rever Neck</a>
                                            </h3>
                                            <div class="rating-wapper nostar">
                                                <span style="width:0%"><a href="#" tabindex="0">XS </a></span><span style="width:0%"><a href="#">S </a></span><span style="width:0%"><a href="#">M </a> </span><span style="width:0%"><a href="#">L </a> </span><span style="width:0%"><a href="#">XL </a> </span><span style="width:0%"><a href="#">2XL </a> </span><span style="width:0%"><a href="#">3XL </a> </span>
                                            </div>
                                            <span class="price">
                                                <span class="akasha-Price-amount amount">
                                                    INR
                                                    <span class="akasha-Price-currencySymbol" style="padding-left: 10px;">₹ 109.00</span>
                                                </span>
                                            </span>
                                        </div>
									</div>
                                </div>
                                <div class="product-item style-01 post-36 product type-product status-publish has-post-thumbnail product_cat-table product_cat-bed product_tag-light product_tag-table product_tag-sock first instock sale shipping-taxable purchasable product-type-simple">
                                    <div class="product-inner tooltip-right">
										<div class="product-thumb">
											<a class="thumb-link"
											   href="#" tabindex="0">
												<img class="img-responsive"
													 src="assetsfe/klaks/1.jpg"
													 alt="Utility Pockets" width="270" height="350">
											</a>
											<div class="flash">
												
												<span class="onnew"><span class="text">New</span></span></div>
										   
										</div>
									   <div class="product-info equal-elem">
														<h3 class="product-name product_title">
															<a href="#">Rever Neck</a>
														</h3>
														<div class="rating-wapper nostar">
															
																<span style="width:0%"><a href="#" tabindex="0">XS </a></span><span style="width:0%"><a href="#">S </a></span><span style="width:0%"><a href="#">M </a> </span><span style="width:0%"><a href="#">L </a> </span><span style="width:0%"><a href="#">XL </a> </span><span style="width:0%"><a href="#">2XL </a> </span><span style="width:0%"><a href="#">3XL </a> </span>
															
														</div>
														<span class="price">
															<span class="akasha-Price-amount amount">
																INR
																<span class="akasha-Price-currencySymbol" style="padding-left: 10px;">₹ 109.00</span>
																
															</span>
														</span>
													</div>
									</div>
                                </div>
                                <div class="product-item style-01 post-32 product type-product status-publish has-post-thumbnail product_cat-light product_cat-chair product_cat-sofas product_tag-hat product_tag-sock  instock sale featured shipping-taxable purchasable product-type-simple">
                                    <div class="product-inner tooltip-right">
										<div class="product-thumb">
											<a class="thumb-link"
											   href="#" tabindex="0">
												<img class="img-responsive"
													 src="assetsfe/klaks/1.jpg"
													 alt="Utility Pockets" width="270" height="350">
											</a>
											<div class="flash">
												<span class="onnew">
                                                    <span class="text">New</span>
                                                </span>
                                            </div>
										</div>
									    <div class="product-info equal-elem">
                                            <h3 class="product-name product_title">
                                                <a href="#">Rever Neck</a>
                                            </h3>
                                            <div class="rating-wapper nostar">
                                                <span style="width:0%"><a href="#" tabindex="0">XS </a></span><span style="width:0%"><a href="#">S </a></span><span style="width:0%"><a href="#">M </a> </span><span style="width:0%"><a href="#">L </a> </span><span style="width:0%"><a href="#">XL </a> </span><span style="width:0%"><a href="#">2XL </a> </span><span style="width:0%"><a href="#">3XL </a> </span>
                                            </div>
                                            <span class="price">
                                                <span class="akasha-Price-amount amount">
                                                    INR
                                                    <span class="akasha-Price-currencySymbol" style="padding-left: 10px;">₹ 109.00</span>
                                                </span>
                                            </span>
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
</main> -->