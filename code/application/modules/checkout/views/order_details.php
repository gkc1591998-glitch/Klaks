<?php 
//    echo "<pre>";$order_details ."<br>";

//    echo "<pre>"; $order ."<br>";
?>
<main class="site-main main-container no-sidebar">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <?php if(isset($order_error) && $order_error != ''): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $order_error; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <?php if($this->session->flashdata('msg_order') != ''){ ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $this->session->flashdata('msg_order'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>
                <?php if($this->session->flashdata('msg_fail_order') != ''){ ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $this->session->flashdata('msg_fail_order'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>
                <?php if($this->session->flashdata('msg_fails') != ''){ ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $this->session->flashdata('msg_fails'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-dark text-white text-center">
                        <h3 class="mb-0">Order Details</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // Normalize variables: some controllers pass $order (meta) and $order_details (products array),
                        // others may pass a combined $order_details that contains both meta fields and products list.
                        $order_meta = [];
                        $products = [];

                        if (!empty($order) && is_array($order)) {
                            $order_meta = $order;
                        }

                        if (!empty($order_details) && is_array($order_details)) {
                            // If $order_details is a numeric-indexed products array (first element an array with 'id' or 'item_id')
                            if (isset($order_details[0]) && is_array($order_details[0]) && (isset($order_details[0]['id']) || isset($order_details[0]['item_id']))) {
                                $products = $order_details;
                            } elseif (isset($order_details['products']) && is_array($order_details['products'])) {
                                $products = $order_details['products'];
                            } else {
                                // Might be a combined array containing order meta keys
                                $order_meta = array_merge($order_meta, $order_details);
                                // No explicit products key in this shape
                            }
                        }

                        // If products not set but controller provided separate products in $order_details_products variable, try that
                        if (empty($products) && !empty($order_details_products) && is_array($order_details_products)) {
                            $products = $order_details_products;
                        }

                        // Helper accessors
                        $display_order_id = $order_meta['order_id'] ?? $order_meta['orderid'] ?? $order_meta['order_table_id'] ?? ($order_meta['order_table_id'] ?? '-');
                        $display_date = $order_meta['create_date_time'] ?? $order_meta['create_date'] ?? '-';
                        $display_amount = $order_meta['total'] ?? $order_meta['amount'] ?? $order_meta['cart_total'] ?? '-';
                        ?>

                        <?php if(!empty($order_meta)): ?>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>Order Info</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><strong>Order ID:</strong> <?php echo $display_order_id; ?></li>
                                    <li class="list-group-item"><strong>Order Date:</strong> <?php echo $display_date; ?></li>
                                    <li class="list-group-item"><strong>Amount:</strong> ₹<?php echo $display_amount; ?></li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5>Shipping Address</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><?php echo trim(($order_meta['dfname'] ?? '') . ' ' . ($order_meta['dlname'] ?? '')); ?></li>
                                    <li class="list-group-item"><?php echo $order_meta['dlocation'] ?? ''; ?></li>
                                    <li class="list-group-item"><?php echo trim(($order_meta['dcity'] ?? '') . ', ' . ($order_meta['dzipcode'] ?? '')); ?></li>
                                    <li class="list-group-item"><?php echo trim(($order_meta['dstate'] ?? '') . ', ' . ($order_meta['dcountry'] ?? '')); ?></li>
                                    <li class="list-group-item"><?php echo $order_meta['dmobile'] ?? ''; ?></li>
                                    <li class="list-group-item"><?php echo $order_meta['demail'] ?? ''; ?></li>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if(!empty($products) && is_array($products)): ?>
                        <h5 class="mb-3">Products</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Size</th>
                                        <th>Colour</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($products as $i => $prod): ?>
                                    <tr>
                                        <td><?php echo $i+1; ?></td>
                                        <td><?php echo $prod['name'] ?? ($prod['product_name'] ?? '-'); ?></td>
                                        <td><?php echo $prod['size'] ?? '-'; ?></td>
                                        <td><?php echo $prod['colour'] ?? ($prod['color'] ?? '-'); ?></td>
                                        <td><?php echo $prod['qty'] ?? '-'; ?></td>
                                        <td>₹<?php echo $prod['price'] ?? '-'; ?></td>
                                        <td>₹<?php echo isset($prod['qty'], $prod['price']) ? ($prod['qty'] * $prod['price']) : ($prod['subtotal'] ?? '-'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                        <div class="text-center mt-4">
                            <a href="<?php echo site_url(); ?>" class="btn btn-primary">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
