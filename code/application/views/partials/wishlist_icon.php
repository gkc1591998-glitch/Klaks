<?php
/**
 * Unified Wishlist Icon Partial
 * 
 * Single reusable component for consistent wishlist UI across all pages.
 * Always uses flaticon-heart icon (KLAKS design standard).
 * 
 * @param bool   $is_header    - true = header counter badge, false = product card button
 * @param string $url          - Link URL (e.g., site_url('dashboard/wishlist'))
 * @param int    $product_id   - Product ID (required for product cards)
 * @param int    $variant_id   - Variant/Product More Info ID (optional, for variant-specific wishlisting)
 * @param int    $count        - Wishlist counter value (for header use)
 * @param string $extra_class  - Additional CSS classes
 */

// Extract variables with defaults
$url = isset($url) ? $url : site_url('dashboard/wishlist');
$product_id = isset($product_id) ? (int)$product_id : 0;
$variant_id = isset($variant_id) ? (int)$variant_id : 0;
$count = isset($count) ? (int)$count : 0;
$is_header = isset($is_header) ? (bool)$is_header : false;
$extra_class = isset($extra_class) ? $extra_class : '';

// Determine if user is logged in
$user_id = $this->session->userdata('user_id') ?? null;
$is_logged_in = !empty($user_id);

// For header counter display
if ($is_header) {
    ?>
    <div class="menu-item block-user block-dreaming akasha-dropdown mobile-account">
        <a class="block-link" href="<?php echo htmlspecialchars($url); ?>" aria-label="Wishlist" title="Wishlist">
            <span class="flaticon-heart" aria-hidden="true"></span>
            <span class="wishlist-counter" role="status" aria-live="polite">
                <?php echo (int)$count; ?>
            </span>
        </a>
    </div>
    <?php
} else {
    // Product card wishlist button
    $data_attributes = 'data-product-id="' . (int)$product_id . '"';
    if ($variant_id > 0) {
        $data_attributes .= ' data-variant-id="' . (int)$variant_id . '"';
        $data_attributes .= ' data-product-more-info-id="' . (int)$variant_id . '"';
    }
    ?>
    <div class="yith-wcwl-add-to-wishlist">
        <div class="yith-wcwl-add-button show">
            <a href="javascript:void(0)" 
               class="add_to_wishlist wishlist-btn <?php echo htmlspecialchars($extra_class); ?>"
               <?php echo $data_attributes; ?>
               title="Add to Wishlist"
               aria-label="Add to Wishlist"
               role="button">
                <span class="flaticon-heart wishlist-icon-state" aria-hidden="true"></span>
            </a>
        </div>
    </div>
    <?php
}
?>
