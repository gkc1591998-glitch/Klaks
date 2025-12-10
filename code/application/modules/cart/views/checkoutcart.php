<?php
// Load color helper for better color management
if (!function_exists('get_best_color_match')) {
    $this->load->helper('color');
}
?>
<div id="cartid">
    <form class="akasha-cart-form">
        <table class="shop_table shop_table_responsive cart akasha-cart-form__contents"
            cellspacing="0">
            <thead>
                <tr>
                    <th class="product-remove">&nbsp;</th>
                    <th class="product-thumbnail">&nbsp;</th>  
                    <th class="product-subtotal">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->cart->contents() as $items) { ?>
                <tr class="akasha-cart-form__cart-item cart_item">
                    <td class="product-remove">
                        <a href="#" class="remove" aria-label="Remove this item"
                            onclick="deletecartcheckout('<?php echo $items['rowid']; ?>');">×</a>
                    </td>
                    <td class="product-thumbnail">
                        <div class="d-flex gap-2">
                            <div>
                                <?php 
                                
                                if ($this->cart->has_options($items['rowid'])) {
                                    foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value) {
                                        if ($option_name == 'image' && !empty($option_value)) {
                                            $img = site_url().'images/products/'.$option_value;
                                        }
                                    }
                                }
                                ?>
                                <a href="#"><img src="<?php echo $img; ?>"
                                    class="attachment-akasha_thumbnail size-akasha_thumbnail"
                                    alt="img" width="600" height="778"></a>
                            </div>
                            <div class=" mx-3">
                                <a href="#"><?php echo $items['name']; ?></a>
                                <p>
                                    <?php 
                                    $artno = isset($items['artno']) ? $items['artno'] : '';
                                    $size = '';
                                    $color = '';
                                    if ($this->cart->has_options($items['rowid'])) {
                                        foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value) {
                                            if ($option_name == 'size') $size = $option_value;
                                            if ($option_name == 'color') $color = $option_value;
                                            if ($option_name == 'artno') $artno = $option_value;
                                        }
                                    }
                                    ?>
                                    Size: <?php echo $size; ?><br/>
                                    <?php 
                                    // Use enhanced color matching from helper
                                    $colorMatch = get_best_color_match($color);
                                    $cssColor = $colorMatch['css_color'];
                                    $displayName = $colorMatch['display_name'];
                                    ?>
                                    Color: <span style="display:inline-block;width:16px;height:16px;border-radius:50%;background:<?php echo htmlspecialchars($cssColor); ?>;border:1px solid #ccc;vertical-align:middle;margin-right:5px;"></span> <?php echo $displayName; ?>
                                </p>
                                <p>
                                    <?php 
                                    $price = $items['price'];
                                    $old_price = isset($items['old_price']) ? $items['old_price'] : '';
                                    ?>
                                    <span class="akasha-Price-amount amount">Price: <strong><span class="akasha-Price-currencySymbol">₹</span><?php echo number_format($price,2); ?></span></strong>
                                    <?php /*if ($old_price && $old_price > $price) { ?>
                                        (<strike><span class="akasha-Price-currencySymbol">₹</span><?php echo number_format($old_price,2); ?></strike>)
                                    <?php } */?>
                                </p> 
                                <div class="counter-container">
                                    <button class="counter-btn decrement" type="button" onclick="updateCartQty(this, -1)">-</button>
                                    <div class="counter-value">
                                        <input type="text" data-step="1" min="1" max="10" name="quantity" value="<?php echo $items['qty']; ?>" title="Qty" class="input-qty input-text qty text" size="2" pattern="[0-9]*" inputmode="numeric" readonly id="cart-qnty-<?php echo $items['rowid']; ?>">
                                    </div>
                                    <button class="counter-btn increment" type="button" onclick="updateCartQty(this, 1)">+</button>
                                </div>
                                <div class="product-values">
                                    <input type="hidden" class="product_size" value="<?php echo $size; ?>">
                                    <input type="hidden" class="product_id" value="<?php echo $items['id']; ?>">
                                    <input type="hidden" class="cart_row_id" value="<?php echo $items['rowid']; ?>">
                                    <input type="hidden" class="product_price" value="<?php echo $price; ?>">
                                </div>          
                            </div>
                        </div> 
                    </td>                                             
                    <td class="product-subtotal" data-title="Total">
                        <span class="akasha-Price-amount amount"><span class="akasha-Price-currencySymbol">₹</span><?php echo number_format($items['subtotal'],2); ?></span>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>
    <div class="cart-collaterals">
        <div class="cart_totals ">
            <h2 class="akasha-proceed-to-checkout">CART TOTALS</h2>
            <table class=" shop_table_responsive" cellspacing="0">
                <tbody>
                    <tr class="cart-subtotal">
                        <th>Subtotal
                            <!-- <br/> -->
                            <!-- Estimated delivery fee  -->
                        </th>
                        <td data-title="Subtotal"><span class="akasha-Price-amount amount"><span
                                    class="akasha-Price-currencySymbol">₹</span><?php echo number_format($this->cart->total(),2); ?></span><br/>
                                    <!-- <span class="akasha-Price-currencySymbol">₹</span>149.00</span> -->
                        </td>
                    </tr>
                    <tr class="order-total">
                        <th>Total</th>
                        <td data-title="Total"><strong><span
                                    class="akasha-Price-amount amount"><span
                                        class="akasha-Price-currencySymbol">₹</span><?php echo number_format($this->cart->total(),2); ?></span></strong>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="akasha-proceed-to-checkout">
                <a href="<?php echo site_url(); ?>checkout" class="checkout-button button alt akasha-forward">
                    Proceed to checkout</a>
            </div>
        </div>
    </div>
</div>