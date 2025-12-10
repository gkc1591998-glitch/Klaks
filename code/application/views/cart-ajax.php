<div class="block-minicart block-dreaming akasha-mini-cart akasha-dropdown mobile-account" id="cartdivid">
    <?php if($this->cart->total_items()== 0) { ?>
        <div class="shopcart-dropdown block-cart-link" data-akasha="akasha-dropdown">
            <a class="block-link link-dropdown" href="#">
                <span class="flaticon-bag"></span>
                <span class="count">0</span>
            </a>
        </div>
    <?php } else { ?>
        <div class="shopcart-dropdown block-cart-link" data-akasha="akasha-dropdown">
            <a class="block-link link-dropdown" href="<?php echo site_url();?>cart">
                <span class="flaticon-bag"></span>
                <span class="count"><?php echo $this->cart->total_items();?></span>
            </a>
        </div>
        <div class="widget akasha widget_shopping_cart">
            <div class="widget_shopping_cart_content">
                <h3 class="minicart-title">Your Cart<span class="minicart-number-items"><?php echo $this->cart->total_items();?></span></h3>
                <ul class="akasha-mini-cart cart_list product_list_widget">
                <?php foreach ($this->cart->contents() as $items){ ?>
                <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
                    <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
                    <?php $psize = '';?>
                    <?php if($option_name=='image'){ ?>
                        <li class="akasha-mini-cart-item mini_cart_item">
                            <a href="javascript:void(0);" class="remove remove_from_cart_button" data-rowid="<?php echo $items['rowid']; ?>" onClick="deletecart('<?php echo $items['rowid']; ?>');">×</a>
                            <a href="<?php echo site_url();?>products/product_view/<?php echo stripslashes(str_replace('\n','',$items['id']))?>/<?php echo $psize?>">
                                <img src="<?php echo site_url(); ?>images/products/<?php echo $option_value; ?>"
                                        class="attachment-akasha_thumbnail size-akasha_thumbnail"
                                        alt="img" width="600" height="778">
                                        <!-- <?php echo $items['name'];?>&nbsp; -->
                                        <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
                                            <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?> 
                                                <?php if($option_name=='size'){ ?>
                                                    <?php $psize = $option_value; ?>
                                                    <a href="<?php echo site_url();?>products/product_view/<?php echo stripslashes(str_replace('\n','',$items['id']))?>/<?php echo $psize?>">
                                                        <?php echo $items['name']?>&nbsp;(<?php echo $option_value; ?>) 
                                                    </a>
                                                <?php }?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                            </a>
                            <span class="quantity"><?php echo $items['qty'];?> × <span
                                    class="akasha-Price-amount amount"><span
                                    class="akasha-Price-currencySymbol">₹</span><?php echo $items['price'];?></span></span>
                        </li>
                    <?php }?>
                    <?php endforeach; ?> 
                <?php endif; ?>
                <?php } ?> 
                </ul>
                <p class="akasha-mini-cart__total total"><strong>Subtotal:</strong>
                    <span class="akasha-Price-amount amount"><span
                            class="akasha-Price-currencySymbol">₹</span><?php echo number_format($this->cart->total()); ?></span>
                </p>
                <p class="akasha-mini-cart__buttons buttons">
                    <a href="<?php echo site_url();?>cart" class="button akasha-forward">Viewcart</a>
                    <a href="<?php echo site_url();?>checkout" class="button checkout akasha-forward">Checkout</a>
                </p>
            </div>
        </div>
    <?php } ?>
</div>