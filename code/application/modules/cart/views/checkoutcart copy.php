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
                <a href="<?php echo site_url();?>checkout"
                class="checkout-button button alt akasha-forward">
                    Proceed to checkout</a>
            </div>
        </div>
    </div>
</form>
