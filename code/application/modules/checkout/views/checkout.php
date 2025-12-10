<main class="site-main  main-container no-sidebar">
    <div class="container">
        <div class="row">
            <div class="main-content col-md-12">
                <div class="page-main-content">
                    <div class="akasha">
                        <!-- <div class="akasha-notices-wrapper">
                            <?php if (!empty($order_error)) { ?>
                                <div class="alert alert-danger" role="alert"><?php echo $order_error; ?></div>
                            <?php } ?>
                        </div> -->

                        <?php
                        // Provide a small helper to prefer posted form values (when controller returns validation failures)
                        if (!isset($form_values) || !is_array($form_values)) {
                            $form_values = [];
                        }
                        if (!function_exists('fv')) {
                            function fv($key, $recordKey = '') {
                                global $form_values, $record;
                                if (!empty($form_values) && isset($form_values[$key])) {
                                    return htmlspecialchars($form_values[$key], ENT_QUOTES, 'UTF-8');
                                }
                                if (!empty($record) && $recordKey !== '' && isset($record[$recordKey])) {
                                    return htmlspecialchars($record[$recordKey], ENT_QUOTES, 'UTF-8');
                                }
                                return set_value($key);
                            }
                        }

                        ?>

                        <form action="<?php echo site_url('checkout/order');?>" name="billing_form" id="billing_form" enctype="multipart/form-data" method="post" class="checkout akasha-checkout">
                            <div class="col2-set" id="customer_details">
                                <div class="col-1">
                                    <div class="akasha-billing-fields">
                                        <h3>Billing details</h3>
                                        <div class="akasha-billing-fields__field-wrapper">
                                            <p class="form-row form-row-wide validate-required"
                                               id="billing_first_name_field" data-priority="10"><label
                                                    for="billing_first_name" class="">First name&nbsp;<abbr
                                                    class="required" title="required">*</abbr></label><span
                                                    class="akasha-input-wrapper"><input type="text"
                                                                                             class="input-text "
                                                                                             name="dfname" 
                                                                                             id="dfname"
                                                                                             value="<?php echo fv('dfname', 'fname'); ?>">
                                                                                             <?php echo form_error('dfname'); ?>
                                                                                            </span>
                                            </p>
                                            <p class="form-row form-row-wide validate-required"
                                               id="billing_last_name_field" data-priority="20"><label
                                                    for="billing_last_name" class="">Last name&nbsp;<abbr
                                                    class="required" title="required">*</abbr></label><span
                                                    class="akasha-input-wrapper"><input type="text"
                                                                                             class="input-text "
                                                                                             name="dlname"
                                                                                             id="dlname"
                                                                                             placeholder="" value="<?php echo fv('dlname', 'lname'); ?>"
                                                                                             autocomplete="family-name">
                                                                                             <?php echo form_error('dlname'); ?>
                                                                                            </span>
                                                                                             
                                            </p>
                                            <p class="form-row form-row-wide validate-required validate-phone"
                                               id="billing_phone_field" data-priority="100"><label for="billing_phone"
                                                                                                   class="">Phone&nbsp;<abbr
                                                    class="required" title="required">*</abbr></label><span
                                                    class="akasha-input-wrapper"><input type="tel"
                                                                                             class="input-text "
                                                                                             name="dmobile"
                                                                                             id="dmobile"
                                                                                             placeholder="" value="<?php echo fv('dmobile', 'mobile'); ?>"
                                                                                             autocomplete="tel"></span>
                                                                                             <?php echo form_error('dmobile'); ?>
                                            </p>
                                            <p class="form-row form-row-wide validate-required validate-email"
                                               id="billing_email_field" data-priority="110"><label for="billing_email"
                                                                                                   class="">Email
                                                address&nbsp;<abbr class="required"
                                                                   title="required">*</abbr></label><span
                                                    class="akasha-input-wrapper"><input type="email"
                                                                                             class="input-text "
                                                                                             name="demail"
                                                                                             id="demail"
                                                                                             placeholder="" value="<?php echo fv('demail', 'email'); ?>"
                                                                                             autocomplete="email username"></span>
                                                                                             <?php echo form_error('demail'); ?>
                                            </p>
                                            <p class="form-row form-row-wide adchair-field validate-required"
                                               id="billing_adchair_1_field" data-priority="50"><label
                                                    for="billing_adchair_1" class="">Street Address&nbsp;<abbr
                                                    class="required" title="required">*</abbr></label><span
                                                    class="akasha-input-wrapper"><input type="text"
                                                                                             class="input-text "
                                                                                             name="dlocation"
                                                                                             id="dlocation"
                                                                                             value="<?php echo fv('dlocation', 'location'); ?>">
                                                                                             <?php echo form_error('dlocation'); ?>
                                                                                            </span>
                                                                                             
                                            </p>
                                            
                                            <p class="form-row form-row-wide adchair-field validate-postcode"
                                               id="billing_postcode_field" data-priority="65"
                                               data-o_class="form-row form-row-wide adchair-field validate-postcode">
                                                <label for="billing_postcode" class="">Postcode / ZIP&nbsp;<abbr
                                                class="required" title="required">*</abbr></label><span
                                                    class="akasha-input-wrapper"><input type="text"
                                                                                             class="input-text "
                                                                                             name="dzipcode"
                                                                                             id="dzipcode"
                                                                                             placeholder="" value="<?php echo fv('dzipcode', 'zipcode'); ?>"
                                                                                             autocomplete="postal-code"></span>
                                                                                             <?php echo form_error('dzipcode'); ?>
                                            </p>
                                            <p class="form-row form-row-wide adchair-field validate-required"
                                               id="billing_city_field" data-priority="70"
                                               data-o_class="form-row form-row-wide adchair-field validate-required">
                                                <label for="billing_city" class="">Town / City&nbsp;<abbr
                                                        class="required" title="required">*</abbr></label><span
                                                    class="akasha-input-wrapper"><input type="text"
                                                                                             class="input-text "
                                                                                             name="dcity"
                                                                                             id="dcity"
                                                                                             placeholder="" value="<?php echo fv('dcity', 'city'); ?>"
                                                                                             autocomplete="adchair-level2"></span>
                                                                                             <?php echo form_error('dcity'); ?>
                                            </p>
                                            <p class="form-row form-row-wide validate-required validate-phone"
                                               id="billing_phone_field" data-priority="100"><label for="billing_phone"
                                                                                                   class="">State&nbsp;<abbr
                                                    class="required" title="required">*</abbr></label><span
                                                    class="akasha-input-wrapper"><input type="tel"
                                                                                             class="input-text "
                                                                                             name="dstate"
                                                                                             id="dstate"
                                                                                             placeholder="" value="<?php echo fv('dstate', 'state'); ?>"
                                                                                             autocomplete="tel"></span>
                                                                                             <?php echo form_error('dstate'); ?>
                                            </p>
                                            <p class="form-row form-row-wide validate-required validate-phone"
                                               id="billing_phone_field" data-priority="100"><label for="billing_phone"
                                                                                                   class="">Country&nbsp;<abbr
                                                    class="required" title="required">*</abbr></label><span
                                                    class="akasha-input-wrapper"><input type="tel"
                                                                                             class="input-text "
                                                                                             name="dcountry"
                                                                                             id="dcountry"
                                                                                             placeholder="" value="<?php echo fv('dcountry', 'country'); ?>"
                                                                                             autocomplete="tel"></span>
                                                                                             <?php echo form_error('dcountry'); ?>
                                            </p>
                                          </div>
                                    </div>
                                </div>
                            </div>
                            <h3 id="order_review_heading">Your order</h3>
                            <div id="order_review" class="akasha-checkout-review-order">
                                <table class="shop_table akasha-checkout-review-order-table">
                                    <thead>
                                    <tr>
                                        <th class="product-name">Product</th>
                                        <th class="product-total">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($this->cart->contents() as $items){ ?>
                                    <tr class="cart_item">
                                        <td class="product-name">
                                        <?php echo $items['name']; ?>&nbsp;&nbsp; <strong class="product-quantity">×
                                        <?php echo $items['qty']; ?></strong></td>
                                        <td class="product-total">
                                            <span class="akasha-Price-amount amount"><span
                                                    class="akasha-Price-currencySymbol">₹</span><?php echo $items['price']; ?></span></td>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr class="cart-subtotal">
                                        <th>Subtotal</th>
                                        <td><span class="akasha-Price-amount amount"><span
                                                class="akasha-Price-currencySymbol">₹</span><?php echo stripslashes(str_replace("\n","",$items['subtotal'])); ?></span></td>
                                    </tr>
                                    <tr class="order-total">
                                        <th>Total</th>
                                        <td><strong><span class="akasha-Price-amount amount"><span
                                                class="akasha-Price-currencySymbol">₹</span><?php echo number_format($this->cart->total());?> </span></strong>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                                <div id="payment" class="akasha-checkout-payment">
                                    <ul class="wc_payment_methods payment_methods methods">
                                        <li class="wc_payment_method payment_method_cod">
                                            <input id="payment_method_cod" type="radio" class="input-radio"
                                                   name="payment_method" value="cod" data-order_button_text="">
                                            <label for="payment_method_cod">
                                                Cash on delivery </label>
                                        </li>
                                        <li class="wc_payment_method payment_method_razorpay">
                                            <input id="payment_method_razorpay" type="radio" class="input-radio"
                                                   name="payment_method" value="razorpay" data-order_button_text="">
                                            <label for="payment_method_razorpay">Pay with razor pay </label>
                                        </li>
                                        <?php echo form_error('payment_method'); ?>
                                    </ul>
                                    <div class="form-row place-order">
                                        <button type="submit" name="submit" value="submit">Place
                                            order
                                        </button>
                                      </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script type="text/javascript">

        function FillBilling(f) {

          if(f.billingtoo.checked == true) {

            f.sfname.value   =   f.dfname.value;

            f.slname.value   =   f.dlname.value;

            f.smobile.value  =   f.dmobile.value;

            f.semail.value   =   f.demail.value;

            f.scountry.value =   f.dcountry.value;

            f.sstate.value   =   f.dstate.value;

            f.scity.value    =   f.dcity.value;

            f.slocation.value =   f.dlocation.value;

            f.szipcode.value =   f.dzipcode.value;

          } else {

             f.sfname.value    = "";

             f.slname.value    = ""; 

             f.smobile.value   = "";

             f.semail.value    = "";

             f.scountry.value  = "";

             f.sstate.value    = "";

             f.scity.value     = "";

             f.slocation.value = "";

             f.szipcode.value  = "";

          }

       }

</script>
