<?php
// AJAX endpoint for product grid only (no header/footer)
// Uses the shared product card template for consistency
if (!empty($products)) : ?>
    <div class="auto-clear equal-container better-height akasha-products">
        <ul class="row products columns-3">
            <?php
            // Use the same product display as home module
            include VIEWPATH . '_product_card_dynamic.php';
            ?>
        </ul>
    </div>
<?php else : ?>
    <div class="auto-clear equal-container better-height akasha-products">
        <p>No luxury products found.</p>
    </div>
<?php endif; ?>