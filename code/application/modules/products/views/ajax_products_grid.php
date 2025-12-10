<?php
if (!empty($products)) : ?>
  <div class="auto-clear equal-container better-height akasha-products">
    <ul class="row products columns-3">
      <?php
      // Lookup products by slug only; show empty if not present
      $products = isset($products) ? $products : array();
      include VIEWPATH . '_product_card_dynamic.php';
      ?>
    </ul>
  </div>
<?php else: ?>
  <div class="alert alert-warning">No products found.</div>
<?php endif; ?>

<script>
  (function(){
    try {
      var container = document.getElementById('ajax-products-container');
      if (window.initProductCards) { try{ window.initProductCards(container); } catch(e){} }
    } catch(e) {}
  })();
</script>