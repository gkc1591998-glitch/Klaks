/**
 * Wishlist functionality for KLAKS e-commerce website
 * Handles adding/removing products from wishlist via AJAX
 */

console.log('WISHLIST.JS LOADED - This should appear first!');

// Wishlist object
var KLAKS_Wishlist = {
    
    // Initialize wishlist functionality
    init: function() {
        this.bindEvents();
        this.updateWishlistCount();
        this.checkExistingWishlistItems();
    },
    
    // Bind click events
    bindEvents: function() {
        // Add to wishlist
        $(document).on('click', '.add_to_wishlist', this.addToWishlist);
        
        // Remove from wishlist (on product pages)
        $(document).on('click', '.remove_from_wishlist', this.removeFromWishlist);
        
        // Toggle wishlist state
        $(document).on('click', '.toggle_wishlist', this.toggleWishlist);
        
        // Clear wishlist
        $(document).on('click', '#clear-wishlist-btn', this.clearWishlist);
    },
    
    // Add product to wishlist
    addToWishlist: function(e) {
        e.preventDefault();
        
        var $this = $(this);
        // IMPORTANT: Use .attr() for variant ID to get the current DOM value (not cached .data())
        // This ensures we get the LATEST variant ID after color circle is clicked
        var variantId = $this.attr('data-variant-id') || $this.attr('data-product-more-info-id');
        var productId = $this.attr('data-product-id') || $this.closest('.product-item').attr('data-product-id') || $this.closest('[data-product-id]').attr('data-product-id');
        
        console.log('Add to wishlist clicked:', {
            productId: productId,
            variantId: variantId,
            buttonElement: $this[0],
            buttonDataVariantId: $this.data('variant-id'),
            buttonAttrVariantId: $this.attr('data-variant-id')
        });
        
        // Try to find product ID from various sources
        if (!productId) {
            // Look for product ID in URL or other attributes
            var href = $this.attr('href');
            if (href && href.includes('product')) {
                var matches = href.match(/(\d+)/);
                if (matches) {
                    productId = matches[0];
                }
            }
        }
        
        if (!productId) {
            KLAKS_Wishlist.showMessage('Product ID not found', 'error');
            return;
        }
        
        // Check if user is logged in
        if (!KLAKS_Wishlist.isUserLoggedIn()) {
            KLAKS_Wishlist.showMessage('Please login to add items to wishlist', 'error');
            return;
        }
        
        // Show loading state
        $this.addClass('loading');
        
        // Prepare data with variant information
        var data = {
            product_id: productId
        };
        
        // Add variant ID if available (this is important for multi-variant products)
        if (variantId) {
            data.product_more_info_id = variantId;
            data.variant_id = variantId; // Additional field for clarity
        }
        
        console.log('Adding to wishlist with data:', data);
        
        // AJAX request
        $.ajax({
            url: site_url + 'Dashboard/add_to_wishlist',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                $this.removeClass('loading');
                
                if (response.status === 'success') {
                    // Update button state
                    KLAKS_Wishlist.updateButtonState($this, true);
                    
                    // Update wishlist count
                    KLAKS_Wishlist.updateWishlistCountDisplay(response.wishlist_count);
                    
                    // Show success message
                    KLAKS_Wishlist.showMessage(response.message, 'success');
                } else {
                    KLAKS_Wishlist.showMessage(response.message, 'error');
                }
            },
            error: function() {
                $this.removeClass('loading');
                KLAKS_Wishlist.showMessage('An error occurred. Please try again.', 'error');
            }
        });
    },
    
    // Remove product from wishlist
    removeFromWishlist: function(e) {
        e.preventDefault();
        
        var $this = $(this);
        var productId = $this.data('product-id');
        var variantId = $this.data('variant-id') || $this.data('product-more-info-id');
        
        console.log('Remove clicked:', {
            productId: productId,
            variantId: variantId,
            hasRemoveClass: $this.hasClass('remove'),
            element: $this[0]
        });
        
        if (!productId) {
            KLAKS_Wishlist.showMessage('Product ID not found', 'error');
            return;
        }
        
        // Show confirmation for wishlist page removes
        if ($this.hasClass('remove') && !confirm('Are you sure you want to remove this item from your wishlist?')) {
            return;
        }
        
        // Show loading state
        $this.addClass('loading');
        
        // Prepare data with variant information
        var data = {
            product_id: productId
        };
        
        // Add variant ID if available
        if (variantId) {
            data.product_more_info_id = variantId;
            data.variant_id = variantId; // Additional field for clarity
        }
        
        console.log('AJAX URL:', site_url + 'Dashboard/remove_from_wishlist');
        console.log('AJAX Data:', data);
        
        // AJAX request
        $.ajax({
            url: site_url + 'Dashboard/remove_from_wishlist',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                console.log('Remove AJAX success:', response);
                $this.removeClass('loading');
                
                if (response.status === 'success') {
                    // Check if we're on the wishlist page
                    var $row = $this.closest('tr');
                    if ($row.length && $row.attr('id') && $row.attr('id').startsWith('wishlist-row-')) {
                        // Remove the row with animation
                        $row.fadeOut(300, function() {
                            $(this).remove();
                            // Check if no more items
                            if ($('.wishlist_table tbody tr').length === 0) {
                                location.reload(); // Reload to show empty state
                            } else {
                                // Update count in title if exists
                                $('.wishlist-title h2').text('My Wishlist on Klaks (' + response.wishlist_count + ' items)');
                            }
                        });
                    } else {
                        // Update button state for product pages
                        KLAKS_Wishlist.updateButtonState($this, false);
                    }
                    
                    // Update wishlist count
                    KLAKS_Wishlist.updateWishlistCountDisplay(response.wishlist_count);
                    
                    // Show success message
                    KLAKS_Wishlist.showMessage(response.message, 'success');
                } else {
                    KLAKS_Wishlist.showMessage(response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.log('Remove AJAX error:', {
                    xhr: xhr,
                    status: status,
                    error: error,
                    responseText: xhr.responseText
                });
                $this.removeClass('loading');
                KLAKS_Wishlist.showMessage('An error occurred. Please try again.', 'error');
            }
        });
    },
    
        // Clear all wishlist items
    clearWishlist: function(e) {
        e.preventDefault();
        
        var $this = $(this);
        
        console.log('Clear wishlist clicked:', {
            hasClearClass: $this.hasClass('clear-wishlist'),
            element: $this[0]
        });
        
        if (!confirm('Are you sure you want to clear all items from your wishlist?')) {
            return;
        }
        
        console.log('AJAX URL:', site_url + 'Dashboard/clear_wishlist');
        
        // AJAX request
        $.ajax({
            url: site_url + 'Dashboard/clear_wishlist',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                console.log('Clear AJAX success:', response);
                if (response.status === 'success') {
                    // Reload the page to show empty state
                    location.reload();
                } else {
                    KLAKS_Wishlist.showMessage(response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.log('Clear AJAX error:', {
                    xhr: xhr,
                    status: status,
                    error: error,
                    responseText: xhr.responseText
                });
                KLAKS_Wishlist.showMessage('An error occurred. Please try again.', 'error');
            }
        });
    },
    
    // Toggle wishlist state
    toggleWishlist: function(e) {
        e.preventDefault();
        
        var $this = $(this);
        var isInWishlist = $this.hasClass('in-wishlist');
        
        if (isInWishlist) {
            // Remove from wishlist
            KLAKS_Wishlist.removeFromWishlist.call(this, e);
        } else {
            // Add to wishlist
            KLAKS_Wishlist.addToWishlist.call(this, e);
        }
    },
    
    // Update button state
    updateButtonState: function($button, isInWishlist) {
        console.log('updateButtonState called:', {
            isInWishlist: isInWishlist,
            buttonElement: $button[0],
            buttonLength: $button.length,
            currentClasses: $button.attr('class'),
            variantId: $button.data('variant-id'),
            productId: $button.data('product-id')
        });
        
        if (isInWishlist) {
            $button.addClass('in-wishlist');
            $button.removeClass('add_to_wishlist').addClass('remove_from_wishlist');
            
            // Change icon from outline to filled heart (Flaticon icons)
            var $icon = $button.find('.wishlist-icon-state');
            console.log('Setting to wishlisted, icon element found:', $icon.length);
            if ($icon.length) {
                // Switch from flaticon-heart to flaticon-valentines-heart (filled)
                $icon.removeClass('flaticon-heart').addClass('flaticon-valentines-heart');
                $button.addClass('wishlist-added');
                console.log('Icon updated to filled heart');
            }
            
            $button.attr('data-tooltip', 'Remove from Wishlist');
        } else {
            $button.removeClass('in-wishlist');
            $button.removeClass('remove_from_wishlist').addClass('add_to_wishlist');
            
            // Change icon from filled back to outline heart (Flaticon icons)
            var $icon = $button.find('.wishlist-icon-state');
            console.log('Setting to not wishlisted, icon element found:', $icon.length);
            if ($icon.length) {
                // Switch from flaticon-valentines-heart to flaticon-heart (outline)
                $icon.removeClass('flaticon-valentines-heart').addClass('flaticon-heart');
                $button.removeClass('wishlist-added');
                console.log('Icon updated to outline heart');
            }
            
            $button.attr('data-tooltip', 'Add to Wishlist');
        }
        
        console.log('updateButtonState complete, new classes:', $button.attr('class'));
    },
    
    // Update wishlist count in navigation
    updateWishlistCountDisplay: function(count) {
        $('.wishlist-count').text(count);
        $('.wishlist-counter').text(count);
        
        // Update mobile footer wishlist count if exists
        $('.device-wishlist .count').text(count);
    },
    
    // Update wishlist count on page load
    updateWishlistCount: function() {
        if (!KLAKS_Wishlist.isUserLoggedIn()) {
            return;
        }
        
        // This could be loaded from server or via AJAX
        // For now, we'll skip this as count will be updated on actions
    },
    
    // Check existing wishlist items and update button states (variant-aware)
    checkExistingWishlistItems: function() {
        if (!KLAKS_Wishlist.isUserLoggedIn()) {
            return;
        }
        
        // Get all products and their variants on the current page
        var productIds = [];
        var productElements = [];
        
        $('.product-item, .add_to_wishlist').each(function() {
            var productId = $(this).data('product-id');
            if (productId && $.inArray(productId, productIds) === -1) {
                productIds.push(productId);
                productElements.push($(this));
            }
        });
        
        if (productIds.length === 0) {
            return; // No products found
        }
        
        console.log('Checking variant wishlist status for products:', productIds);
        
        // Use the new variant-aware endpoint
        $.ajax({
            url: site_url + 'Dashboard/check_variant_wishlist_items',
            type: 'POST',
            data: {
                product_ids: productIds
            },
            dataType: 'json',
            success: function(response) {
                console.log('Variant wishlist response:', response);
                
                if (response.status === 'success' && response.wishlist_variants) {
                    // Update wishlist status for each variant button on the page
                    $('.add_to_wishlist, .klaks_product_wislist').each(function() {
                        var $button = $(this);
                        var productId = $button.data('product-id');
                        var variantId = $button.data('variant-id') || $button.data('product-more-info-id');
                        
                        if (productId && response.wishlist_variants[productId]) {
                            var wishlisted_variants = response.wishlist_variants[productId] || [];
                            var isInWishlist = false;
                            var otherVariantsCount = 0;
                            
                            if (variantId) {
                                // Check if this specific variant is in wishlist
                                isInWishlist = $.inArray(variantId.toString(), wishlisted_variants.map(String)) !== -1;
                                
                                // Count other variants that are wishlisted
                                wishlisted_variants.forEach(function(wVariantId) {
                                    if (wVariantId.toString() !== variantId.toString() && wVariantId !== 'all') {
                                        otherVariantsCount++;
                                    }
                                });
                            } else {
                                // For products without variants, check if any variant exists
                                isInWishlist = wishlisted_variants.length > 0 && 
                                              ($.inArray('all', wishlisted_variants) !== -1 || wishlisted_variants.length > 0);
                            }
                            
                            KLAKS_Wishlist.updateButtonState($button, isInWishlist);
                            
                            // Store the count of other variants for tooltip/indicator
                            // $button.data('other-variants-count', otherVariantsCount);
                            
                            // // Update button title to indicate other wishlisted variants
                            // if (isInWishlist && otherVariantsCount > 0) {
                            //     $button.attr('data-tooltip', 'In Wishlist (+ ' + otherVariantsCount + ' other variant' + (otherVariantsCount > 1 ? 's' : '') + ')');
                            // } else if (isInWishlist) {
                            //     $button.attr('data-tooltip', 'In Wishlist');
                            // } else if (otherVariantsCount > 0) {
                            //     $button.attr('data-tooltip', 'Save this variant too! (You have ' + otherVariantsCount + ' variant' + (otherVariantsCount > 1 ? 's' : '') + ' saved)');
                            // } else {
                            //     $button.attr('data-tooltip', 'Add to Wishlist');
                            // }
                        }
                    });
                }
            },
            error: function() {
                console.log('Could not check variant wishlist items, falling back to old method');
                // Fallback to the old variant checking method
                KLAKS_Wishlist.checkExistingWishlistItemsFallback();
            }
        });
    },
    
    // Fallback method using the old checking approach
    checkExistingWishlistItemsFallback: function() {
        // Get all variants on the current page (not just products)
        var variants = [];
        $('.add_to_wishlist, .klaks_product_wislist').each(function() {
            var variantId = $(this).data('variant-id') || $(this).data('product-more-info-id');
            var productId = $(this).data('product-id');
            
            if (variantId && productId) {
                variants.push({
                    variantId: variantId,
                    productId: productId,
                    button: $(this)
                });
            }
        });
        
        console.log('Fallback: Checking existing wishlist items for variants:', variants.length);
        
        if (variants.length > 0) {
            // Get user's wishlist and check each variant
            $.ajax({
                url: site_url + 'Dashboard/get_user_wishlist_items',
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    console.log('Fallback wishlist items response:', response);
                    
                    if (response.status === 'success' && response.wishlist_items) {
                        // Check each variant button against wishlist items
                        variants.forEach(function(variant) {
                            var isInWishlist = false;
                            
                            response.wishlist_items.forEach(function(item) {
                                if (item.product_more_info_id == variant.variantId || 
                                    item.variant_id == variant.variantId) {
                                    isInWishlist = true;
                                }
                            });
                            
                            KLAKS_Wishlist.updateButtonState(variant.button, isInWishlist);
                        });
                    }
                },
                error: function() {
                    console.log('Could not check existing wishlist items');
                }
            });
        }
    },
    
    // Check if a specific variant is in wishlist (for color switching)
    checkSingleVariantWishlistStatus: function(variantId, $button) {
        if (!variantId || !$button.length) {
            console.log('checkSingleVariantWishlistStatus: early return - variantId=' + variantId + ', buttonLength=' + $button.length);
            return;
        }
        
        console.log('checkSingleVariantWishlistStatus: Starting variant check:', {
            variantId: variantId,
            buttonElement: $button[0],
            buttonDataVariantId: $button.data('variant-id'),
            buttonDataProductMoreInfoId: $button.data('product-more-info-id'),
            buttonClasses: $button.attr('class')
        });
        
        var productId = $button.data('product-id');
        if (!productId) {
            console.log('checkSingleVariantWishlistStatus: no productId found');
            KLAKS_Wishlist.updateButtonState($button, false);
            return;
        }
        
        // Use the new variant-aware endpoint
        $.ajax({
            url: site_url + 'Dashboard/check_variant_wishlist_items',
            type: 'POST',
            data: {
                product_ids: [productId]
            },
            dataType: 'json',
            success: function(response) {
                console.log('checkSingleVariantWishlistStatus: AJAX success response:', response);
                $button.removeClass('checking-status');
                
                if (response.status === 'success' && response.wishlist_variants) {
                    var wishlisted_variants = response.wishlist_variants[productId] || [];
                    console.log('checkSingleVariantWishlistStatus: wishlisted_variants for product ' + productId + ':', wishlisted_variants);
                    
                    var isInWishlist = $.inArray(variantId.toString(), wishlisted_variants.map(String)) !== -1;
                    console.log('checkSingleVariantWishlistStatus: isInWishlist=' + isInWishlist + ' (checking if ' + variantId + ' in ' + JSON.stringify(wishlisted_variants) + ')');
                    
                    KLAKS_Wishlist.updateButtonState($button, isInWishlist);
                    
                    // Track other wishlisted variants to show user exact state
                    var otherVariantsCount = 0;
                    wishlisted_variants.forEach(function(wVariantId) {
                        if (wVariantId.toString() !== variantId.toString() && wVariantId !== 'all') {
                            otherVariantsCount++;
                        }
                    });
                    
                    // Update button data attributes with tooltip info (for custom tooltip positioning)
                    if (isInWishlist && otherVariantsCount > 0) {
                        $button.attr('data-tooltip', 'In Wishlist (+ ' + otherVariantsCount + ' other variant' + (otherVariantsCount > 1 ? 's' : '') + ')');
                    } else if (isInWishlist) {
                        $button.attr('data-tooltip', 'In Wishlist');
                    } else if (otherVariantsCount > 0) {
                        $button.attr('data-tooltip', 'Save this variant too! (You have ' + otherVariantsCount + ' variant' + (otherVariantsCount > 1 ? 's' : '') + ' saved)');
                    } else {
                        $button.attr('data-tooltip', 'Add to Wishlist');
                    }
                } else {
                    // Default to not in wishlist if check fails
                    console.log('checkSingleVariantWishlistStatus: response status not success or no wishlist_variants');
                    KLAKS_Wishlist.updateButtonState($button, false);
                }
            },
            error: function(xhr, status, error) {
                console.log('checkSingleVariantWishlistStatus: AJAX error:', {
                    status: status,
                    error: error,
                    responseText: xhr.responseText
                });
                console.log('Single variant wishlist check failed, trying fallback method');
                $button.removeClass('checking-status');
                
                // Fallback: Use existing check_wishlist_items but filter by variant
                KLAKS_Wishlist.checkVariantWishlistFallback(variantId, $button);
            }
        });
    },
    
    // Fallback method to check variant wishlist status
    checkVariantWishlistFallback: function(variantId, $button) {
        var productId = $button.data('product-id');
        
        if (!productId) {
            KLAKS_Wishlist.updateButtonState($button, false);
            return;
        }
        
        // Get all wishlist items and check if this specific variant is included
        $.ajax({
            url: site_url + 'Dashboard/get_user_wishlist_items',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                console.log('Fallback wishlist check response:', response);
                
                var isInWishlist = false;
                var otherVariantsCount = 0;
                
                if (response.status === 'success' && response.wishlist_items) {
                    // Check if any wishlist item matches this variant and count others for same product
                    response.wishlist_items.forEach(function(item) {
                        if (item.product_more_info_id == variantId || 
                            item.variant_id == variantId) {
                            isInWishlist = true;
                        } else if (item.product_id == productId) {
                            // Count other wishlisted variants for this product
                            otherVariantsCount++;
                        }
                    });
                }
                
                KLAKS_Wishlist.updateButtonState($button, isInWishlist);
                
                // Update button title to show exact variant state + other variants info
                if (isInWishlist && otherVariantsCount > 0) {
                    $button.attr('data-tooltip', 'In Wishlist (+ ' + otherVariantsCount + ' other variant' + (otherVariantsCount > 1 ? 's' : '') + ')');
                } else if (isInWishlist) {
                    $button.attr('data-tooltip', 'In Wishlist');
                } else if (otherVariantsCount > 0) {
                    $button.attr('data-tooltip', 'Save this variant too! (You have ' + otherVariantsCount + ' variant' + (otherVariantsCount > 1 ? 's' : '') + ' saved)');
                } else {
                    $button.attr('data-tooltip', 'Add to Wishlist');
                }
            },
            error: function() {
                console.log('Fallback wishlist check also failed, defaulting to false');
                // Default to not in wishlist if both methods fail
                KLAKS_Wishlist.updateButtonState($button, false);
            }
        });
    },
    
    // Check if user is logged in
    isUserLoggedIn: function() {
        // You might need to adjust this based on your authentication system
        // This is a simple check - you can make it more robust
        return typeof user_logged_in !== 'undefined' && user_logged_in === true;
    },
    
    // Show notification message
    showMessage: function(message, type) {
        var notificationClass = type === 'success' ? 'alert-success' : 'alert-danger';
        
        // Create notification element
        var notification = $('<div class="wishlist-notification alert ' + notificationClass + '">' + message + '</div>');
        
        // Add to top of page or specific container
        var container = $('.main-content').first();
        if (container.length === 0) {
            container = $('body');
        }
        
        container.prepend(notification);
        
        // Auto hide after 3 seconds
        setTimeout(function() {
            notification.fadeOut(function() {
                $(this).remove();
            });
        }, 3000);
    }
};

console.log('BEFORE DOCUMENT READY - jQuery loaded?', typeof jQuery !== 'undefined');

// Initialize wishlist functionality when document is ready
$(document).ready(function() {
    // Set site URL if not already defined
    if (typeof site_url === 'undefined') {
        // Try to get from a global variable or construct it
        if (window.location.pathname.includes('/klaks/')) {
            site_url = window.location.origin + '/klaks/';
        } else {
            site_url = window.location.origin + '/';
        }
    }
    
    console.log('Wishlist JS: site_url =', site_url);
    console.log('Wishlist JS: user_logged_in =', typeof user_logged_in !== 'undefined' ? user_logged_in : 'undefined');
    
    // Initialize wishlist
    KLAKS_Wishlist.init();
    
    // Debug: Log available elements
    console.log('Clear wishlist button found:', $('#clear-wishlist-btn').length);
    console.log('Remove buttons found:', $('.remove-from-wishlist').length);
    console.log('Color selectors found:', $('.color-selector').length);
    
    // Handle color selector clicks for variant wishlist updates
    $(document).on('click', '.color-selector', function(e) {
        console.log('WISHLIST: Color selector click event fired');
        
        var $colorCircle = $(this);
        var variantId = String($colorCircle.data('variant-id') || '').trim();
        var productId = $colorCircle.data('product-id');
        
        if (!variantId || !productId) {
            console.log('WISHLIST: Color selector missing variant or product ID, skipping');
            return;
        }
        
        console.log('WISHLIST: Processing color circle click for variant ' + variantId + ' (product ' + productId + ')');
        
        // Delay slightly to allow other handlers to process first (product-cards.js, product-interactions.js)
        setTimeout(function() {
            var $productItem = $colorCircle.closest('.product-item');
            var $wishlistBtn = $productItem.find('.add_to_wishlist, .remove_from_wishlist');
            
            if (!$wishlistBtn.length) {
                console.log('WISHLIST: No wishlist button found for product', productId);
                return;
            }
            
            console.log('WISHLIST: Found wishlist button:', {
                element: $wishlistBtn[0],
                currentClasses: $wishlistBtn.attr('class'),
                currentVariantId: $wishlistBtn.data('variant-id'),
                colorVariantId: variantId
            });
            
            // CRITICAL: Update the button's variant ID to match the selected color
            // This ensures the next AJAX check uses the correct variant
            $wishlistBtn.attr('data-variant-id', variantId);
            $wishlistBtn.attr('data-product-more-info-id', variantId);
            $wishlistBtn.data('variant-id', variantId);
            $wishlistBtn.data('product-more-info-id', variantId);
            
            console.log('WISHLIST: Updated button variant IDs to:', variantId);
            
            // Force clear any loading state
            $wishlistBtn.removeClass('checking-status');
            
            // Now check if this specific variant is in the wishlist
            if (KLAKS_Wishlist.isUserLoggedIn()) {
                console.log('WISHLIST: User logged in, checking wishlist status for variant', variantId);
                $wishlistBtn.addClass('checking-status');
                KLAKS_Wishlist.checkSingleVariantWishlistStatus(variantId, $wishlistBtn);
            } else {
                console.log('WISHLIST: User not logged in, showing empty heart');
                KLAKS_Wishlist.updateButtonState($wishlistBtn, false);
            }
        }, 10); // Small delay to let other handlers complete
        
    });

$(document).on('click', '.add_to_wishlist', function(e) {
    KLAKS_Wishlist.addToWishlist.call(this, e);
});
$(document).on('click', '.remove-from-wishlist', function(e) {
    KLAKS_Wishlist.removeFromWishlist.call(this, e);
});
$(document).on('click', '.toggle_wishlist', function(e) {
    KLAKS_Wishlist.toggleWishlist.call(this, e);
});
$(document).on('click', '#clear-wishlist-btn', function(e) {
    KLAKS_Wishlist.clearWishlist.call(this, e);
});

// CSS for wishlist notifications and custom tooltips
$('head').append(`
<style>
.wishlist-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    padding: 15px 20px;
    border-radius: 4px;
    font-weight: 500;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.wishlist-notification.alert-success {
    background-color: #000000;
    border-color: #333333;
    color: #ffffff;
}

.wishlist-notification.alert-danger {
    background-color: #000000;
    border-color: #333333;
    color: #ffffff;
}

.add_to_wishlist.loading::after {
    content: " Loading...";
    font-size: 0.9em;
    color: #999;
}

.yith-wcwl-add-to-wishlist .loading {
    opacity: 0.6;
    pointer-events: none;
}

.wishlist-btn.checking-status {
    opacity: 0.7;
    pointer-events: none;
}

.wishlist-btn.checking-status .wishlist-heart-icon::after {
    content: "...";
    position: absolute;
    right: -8px;
    font-size: 10px;
}

/* Custom Tooltip Styling - Only for product cards, NOT view-product page */
.product-item .add_to_wishlist[data-tooltip],
.product-item .remove_from_wishlist[data-tooltip] {
    position: relative;
}

.product-item .add_to_wishlist[data-tooltip]:hover::before,
.product-item .remove_from_wishlist[data-tooltip]:hover::before {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 125%;
    left: 50%;
    transform: translateX(-50%);
    background-color: #333333;
    color: #ffffff;
    padding: 8px 12px;
    border-radius: 4px;
    font-size: 12px;
    white-space: nowrap;
    z-index: 1000;
    pointer-events: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    font-weight: 500;
}

.product-item .add_to_wishlist[data-tooltip]:hover::after,
.product-item .remove_from_wishlist[data-tooltip]:hover::after {
    content: '';
    position: absolute;
    bottom: 120%;
    left: 50%;
    transform: translateX(-50%);
    border: 6px solid transparent;
    border-top-color: #333333;
    z-index: 1000;
    pointer-events: none;
}

/* Mobile tooltip - show below on touch devices */
@media (max-width: 768px) {
    .product-item .add_to_wishlist[data-tooltip]:hover::before,
    .product-item .remove_from_wishlist[data-tooltip]:hover::before {
        bottom: auto;
        top: 125%;
    }
    
    .product-item .add_to_wishlist[data-tooltip]:hover::after,
    .product-item .remove_from_wishlist[data-tooltip]:hover::after {
        bottom: auto;
        top: 120%;
        border: 6px solid transparent;
        border-bottom-color: #333333;
        border-top-color: transparent;
    }
}
</style>
`);

// ==========================================
// CUSTOM TOOLTIP SYSTEM FOR WISHLIST BUTTONS
// ==========================================
(function() {
    var $tooltip = null;
    var tooltipTimeout = null;

    function positionTooltip($button) {
        if (!$tooltip) return;
        
        var offset = $button.offset();
        var buttonWidth = $button.outerWidth();
        var buttonHeight = $button.outerHeight();
        var tooltipWidth = $tooltip.outerWidth();
        var tooltipHeight = $tooltip.outerHeight();
        
        // Position above the button
        var left = offset.left + (buttonWidth / 2) - (tooltipWidth / 2);
        var top = offset.top - tooltipHeight - 10; // 10px gap
        
        // Viewport bounds checking
        var viewportWidth = $(window).width();
        
        if (left < 10) {
            left = 10;
        } else if (left + tooltipWidth > viewportWidth - 10) {
            left = viewportWidth - tooltipWidth - 10;
        }
        
        // Check if tooltip would go above viewport
        if (top < 0) {
            // Show below instead
            top = offset.top + buttonHeight + 10;
        }
        
        $tooltip.css({
            left: left + 'px',
            top: top + 'px'
        });
    }

    function showTooltip($button) {
        var tooltipText = $button.attr('data-tooltip') || $button.attr('title');
        
        if (!tooltipText) return;
        
        // Create tooltip if needed
        if (!$tooltip) {
            $tooltip = $('<div class="klaks-tooltip"></div>').appendTo('body');
        }
        
        $tooltip.text(tooltipText);
        positionTooltip($button);
        
        // Show with fade
        $tooltip.stop(true, true).fadeIn(200);
        
        // Re-position on scroll/resize
        var repositionHandler = function() {
            positionTooltip($button);
        };
        
        $(window).on('scroll.klaksTooltip resize.klaksTooltip', repositionHandler);
        $tooltip.data('reposition-handler', repositionHandler);
    }

    function hideTooltip() {
        if ($tooltip) {
            $tooltip.stop(true, true).fadeOut(200);
            $(window).off('scroll.klaksTooltip resize.klaksTooltip');
        }
    }

    // Attach tooltip handlers to all wishlist buttons
    $(document).on('mouseenter', '.add_to_wishlist, .remove_from_wishlist, .klaks_product_wislist', function() {
        clearTimeout(tooltipTimeout);
        showTooltip($(this));
    });

    $(document).on('mouseleave', '.add_to_wishlist, .remove_from_wishlist, .klaks_product_wislist', function() {
        tooltipTimeout = setTimeout(hideTooltip, 100);
    });
})();

// ==========================================
// CUSTOM TOOLTIP CSS
// ==========================================
$('head').append(`
<style>
.klaks-tooltip {
    position: fixed;
    background-color: #333333;
    color: #ffffff;
    padding: 10px 14px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
    white-space: nowrap;
    z-index: 99999;
    pointer-events: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    display: none;
    opacity: 0.95;
    max-width: 200px;
    word-wrap: break-word;
    white-space: normal;
}

.klaks-tooltip.visible {
    display: block;
}
</style>
`);

}); // End of $(document).ready()
