$(document).ready(function () {
  function updateCartQty(btn, delta) {
    var container = btn.closest(".counter-container");
    var valueInput = container.querySelector(".counter-value input");
    var quantity = parseInt(valueInput.value);
    if (isNaN(quantity)) quantity = 1;
    quantity += delta;
    if (quantity < 1) quantity = 1;
    valueInput.value = quantity;

    // Gather info
    var parent = btn.closest(".mx-3");
    var size = parent.querySelector(".product_size").value;
    var id = parent.querySelector(".product_id").value;
    var rowId = parent.querySelector(".cart_row_id").value;
    var price = parent.querySelector(".product_price").value;

    // Ajax update
    jQuery.ajax({
      type: "POST",
      url: "<?php echo site_url(); ?>cart/updatecart",
      data: {
        qty: quantity,
        rowId: rowId,
        price: price,
      },
      complete: function (data) {
        console.log("Cart updated:", data);
        var op = data.responseText.trim();
        jQuery("#cartid").html(op);
      },
    });
  }

  function deletecartcheckout(valu) {
    console.log('deletecartcheckout (cart-functions.js) called with rowid:', valu);
    
    jQuery.ajax({
      type: "POST",
      url: "<?php echo site_url(); ?>cart/deletecart",
      data: "valu=" + valu,
      success: function (data) {
        console.log('Cart page delete success (cart-functions.js)');
        var op = data.trim();
        
        // Replace the entire cart div (AJAX response includes the outer div)
        jQuery("#cartid").replaceWith(op);
      },
      error: function(xhr, status, error) {
        console.error('Cart page delete failed:', status, error);
      }
    });
  }

  function deletecart(valu) {
    console.log('deletecart (cart-functions.js) called with rowid:', valu);
    
    // Remember if cart was open before deletion
    var wasOpen = jQuery("#cartdivid").hasClass('open');
    
    jQuery.ajax({
      type: "POST",
      url: "<?php echo site_url(); ?>products/deletecart",
      data: "valu=" + valu,
      success: function (data) {
        console.log('Cart delete success (cart-functions.js)');
        var op = data.trim();
        
        // Replace the entire cart div (AJAX response includes the outer div)
        jQuery("#cartdivid").replaceWith(op);
        
        // Keep cart open if it was open before and still has items
        if (wasOpen && jQuery("#cartdivid .widget_shopping_cart").length > 0) {
          jQuery("#cartdivid").addClass('open');
        }
      },
      error: function(xhr, status, error) {
        console.error('Cart delete failed:', status, error);
      }
    });
  }
});
