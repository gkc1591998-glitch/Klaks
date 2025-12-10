(function(window, $){
    // product-cards.js
    // Uses window.productVariantsGroupedByColor[productId] to drive card UI.

    function initCardForDom($card){
        var pid = String($card.attr('data-product-id') || $card.find('[data-product-id]').first().attr('data-product-id') || '');
        // fallback: if no data-product-id, try to find an element with id="carousel-<id>" inside the card
        if (!pid) {
            var $old = $card.find('[id^="carousel-"]').first();
            if ($old.length) {
                var m = String($old.attr('id')||'').match(/^carousel-(\d+)/);
                if (m && m[1]) pid = m[1];
            }
        }
        if (!pid) return;
        var groups = window.productVariantsGroupedByColor && window.productVariantsGroupedByColor[pid] ? window.productVariantsGroupedByColor[pid] : [];
        var $carousel = $card.find('.product-carousel[data-product-id="' + pid + '"]').first();

        // Set first group's first variant id as the active default (carousel only)
        var defaultVariantId = null;
        if (groups.length && groups[0].variant_ids && groups[0].variant_ids.length) {
            defaultVariantId = String(groups[0].variant_ids[0]);
        }

        if (defaultVariantId) {
            var $t = $carousel.find('.carousel-item[data-variant-id="' + defaultVariantId + '"]').first();
            if ($t.length) {
                $carousel.find('.carousel-item').removeClass('active');
                $t.addClass('active');
            } else {
                $carousel.find('.carousel-item').removeClass('active');
                $carousel.find('.carousel-item').first().addClass('active');
            }
        }

        // Auto-select first color to show sizes on page load
        function autoSelectFirstColor() {
            var $firstColor = $card.find('.color-selector').first();
            if ($firstColor.length && !$firstColor.hasClass('active')) {
                $firstColor.trigger('click');
            }
        }
        
        // Multiple strategies for different browsers
        if ($card.find('.color-selector').length) {
            // Strategy 1: Immediate attempt
            autoSelectFirstColor();
            
            // Strategy 2: Short delay for fast browsers (Chrome)
            setTimeout(autoSelectFirstColor, 100);
            
            // Strategy 3: Longer delay as final fallback
            setTimeout(autoSelectFirstColor, 500);
        }

        // Helper: show price for a given variantId + size
        function showPriceFor(variantId, sizeName) {
            $card.find('.price-value').hide();
            if (variantId && sizeName) {
                $card.find('.price-value[data-variant-id="' + variantId + '"][data-size="' + sizeName + '"]').show();
            } else if (variantId) {
                $card.find('.price-value[data-variant-id="' + variantId + '"]').first().show();
            } else {
                $card.find('.price-value').first().show();
            }
        }

        // Color click handler (delegated): show sizes available for color, don't reveal price
        $card.on('click', '.color-selector', function(){
            var $this = $(this);
            $card.find('.color-selector').removeClass('active');
            $this.addClass('active');
            var variant_id = String($this.attr('data-variant-id') || '');
            var colorName = String($this.attr('data-color-name') || '').toLowerCase();

            // Hide all size selectors and clear attached variant ids
            $card.find('.size-selector').each(function(){ 
                $(this).removeAttr('data-variant-id').hide().removeClass('active'); 
            });

            // Find available sizes by inspecting the grouped data and price spans
            var availableSizes = [];
            var groups = window.productVariantsGroupedByColor && window.productVariantsGroupedByColor[pid] ? window.productVariantsGroupedByColor[pid] : [];
            
            // Find the matching color group
            var matchingGroup = null;
            for (var i = 0; i < groups.length; i++) {
                if (groups[i].color_name && groups[i].color_name.toLowerCase() === colorName) {
                    matchingGroup = groups[i];
                    break;
                }
            }
            
            if (matchingGroup && matchingGroup.sizes) {
                // Get variant ID for this color group
                var groupVariantId = '';
                if (matchingGroup.variant_ids && matchingGroup.variant_ids.length) {
                    groupVariantId = String(matchingGroup.variant_ids[0]);
                }
                
                // Collect available sizes for this color
                matchingGroup.sizes.forEach(function(sizeObj) {
                    if (sizeObj.size_name) {
                        availableSizes.push({
                            name: sizeObj.size_name,
                            price: sizeObj.price_name || '',
                            variantId: groupVariantId
                        });
                    }
                });
            }

            var lowestSize = null;
            var lowestPrice = null;
            
            if (availableSizes.length) {
                // Show available size buttons and set their variant IDs
                availableSizes.forEach(function(sizeInfo) {
                    var $sizeBtn = $card.find('.size-selector[data-size="' + sizeInfo.name + '"]');
                    if ($sizeBtn.length) {
                        $sizeBtn.attr('data-variant-id', sizeInfo.variantId).show();
                        
                        // Track lowest price size
                        var price = parseFloat(String(sizeInfo.price).replace(/[^0-9\.]/g, '')) || 0;
                        if (lowestPrice === null || price < lowestPrice) {
                            lowestPrice = price;
                            lowestSize = sizeInfo.name;
                        }
                    }
                });
            }

            // Keep prices hidden on color selection (price shown only after explicit size click)
            // Exception: For accessories with One Size, keep the default price visible
            var isAccessory = $card.find('.one-size-label').length > 0;
            
            $card.find('.price-value').hide();
            
            // For accessories, show the default accessory price immediately
            if (isAccessory) {
                $card.find('.default-accessory-price').show();
            }

            // Update carousel to first image for this variant id
            var targetVariantId = variant_id || (matchingGroup && matchingGroup.variant_ids && matchingGroup.variant_ids[0]);
            if (targetVariantId) {
                var $target = $carousel.find('.carousel-item[data-variant-id="' + targetVariantId + '"]');
                if ($target.length && typeof $carousel.carousel === 'function') {
                    var idx = $carousel.find('.carousel-item').index($target);
                    if (idx >= 0) {
                        $carousel.carousel(idx);
                    }
                }
            }

            // Mark the default (lowest) size active visually
            $card.find('.size-selector').removeClass('active');
            if (lowestSize) { 
                $card.find('.size-selector[data-size="' + lowestSize + '"]').addClass('active'); 
            }
        });

        // Size click: show price for the clicked size and move carousel
        $card.on('click', '.size-selector', function(){
            var $this = $(this);
            var size = String($this.attr('data-size')||'').trim();
            var variant_id = String($this.attr('data-variant-id') || '');
            
            // fallback: if size button wasn't attached a variant id, pick from active color
            if (!variant_id) {
                variant_id = (String($card.find('.color-selector.active').attr('data-variant-id')||'')).trim();
                if (variant_id) { $this.attr('data-variant-id', variant_id); }
            }

            // Visual active state
            $card.find('.size-selector').removeClass('active');
            $this.addClass('active');

            // Show the exact price for this size+variant
            $card.find('.price-value').hide();
            var $priceEl = $card.find('.price-value[data-variant-id="' + variant_id + '"][data-size="' + size + '"]');
            if ($priceEl.length) {
                $priceEl.show();
            } else {
                // Fallback: try to find price from grouped data
                var groups = window.productVariantsGroupedByColor && window.productVariantsGroupedByColor[pid] ? window.productVariantsGroupedByColor[pid] : [];
                var priceFound = false;
                
                for (var i = 0; i < groups.length; i++) {
                    var group = groups[i];
                    var groupVariantId = '';
                    if (group.variant_ids && group.variant_ids.length) {
                        groupVariantId = String(group.variant_ids[0]);
                    }
                    
                    if (groupVariantId === variant_id && group.sizes) {
                        for (var j = 0; j < group.sizes.length; j++) {
                            if (group.sizes[j].size_name === size && group.sizes[j].price_name) {
                                // Create and show a temporary price display
                                var $priceContainer = $card.find('#product-price-' + pid);
                                if ($priceContainer.length) {
                                    $priceContainer.find('.temp-price').remove();
                                    $priceContainer.append('<span class="temp-price" style="padding-left: 10px;">₹ ' + group.sizes[j].price_name + '</span>');
                                }
                                priceFound = true;
                                break;
                            }
                        }
                    }
                    if (priceFound) break;
                }
            }

            // Move carousel to variant image
            var $target = $carousel.find('.carousel-item[data-variant-id="' + variant_id + '"]');
            if ($target.length && typeof $carousel.carousel === 'function') {
                var idx = $carousel.find('.carousel-item').index($target);
                if (idx >= 0) {
                    $carousel.carousel(idx);
                }
            }
        });

        // Initialize sizes by triggering click of the active color (keeps prices hidden)
        var $firstColor = $card.find('.color-selector.active').first();
        if ($firstColor.length) { 
            // Delay to ensure DOM is ready
            setTimeout(function() {
                $firstColor.trigger('click');
                // After color click, ensure accessories show their price
                setTimeout(function() {
                    var isAccessory = $card.find('.one-size-label').length > 0;
                    if (isAccessory) {
                        $card.find('.default-accessory-price').show();
                    }
                }, 50);
            }, 100);
        } else {
            // If no active color, make first color active and trigger click
            var $firstAvailableColor = $card.find('.color-selector').first();
            if ($firstAvailableColor.length) {
                $firstAvailableColor.addClass('active');
                setTimeout(function() {
                    $firstAvailableColor.trigger('click');
                    // After color click, ensure accessories show their price
                    setTimeout(function() {
                        var isAccessory = $card.find('.one-size-label').length > 0;
                        if (isAccessory) {
                            $card.find('.default-accessory-price').show();
                        }
                    }, 50);
                }, 100);
            }
        }
    }

        // Initialize all present product cards by DOM nodes (handles duplicate product entries)
        $(function(){
            $('.product-item').each(function(){
                try { initCardForDom($(this)); } catch(e) { /* non-fatal */ }
            });
        });

        // Expose a lightweight initializer so other scripts (AJAX loaders) can re-run
        // initialization on freshly-inserted DOM. Accepts a DOM element or jQuery object
        // or CSS selector. If not provided, initializes the entire document.
        window.initProductCards = function(root){
            try {
                var $r = root ? (root instanceof jQuery ? root : $(root)) : $(document);
                var count = 0;
                $r.find('.product-item').each(function(){
                    try {
                        var $card = $(this);
                        var pid = String($card.attr('data-product-id') || '');
                        // If global variant data absent, attempt to read per-li data-variants JSON
                        if (pid && (!window.productVariantsGroupedByColor || !window.productVariantsGroupedByColor[pid])) {
                            var dv = $card.attr('data-variants');
                            if (dv) {
                                try {
                                    window.productVariantsGroupedByColor = window.productVariantsGroupedByColor || {};
                                    window.productVariantsGroupedByColor[pid] = JSON.parse(dv);
                                } catch(e) {
                                    // ignore parse errors
                                }
                            }
                        }
                        initCardForDom($card);
                        count++;
                    } catch(e) { /* non-fatal */ }
                });
                // init summary removed (telemetry kept minimal)
            } catch(e) {
                // graceful noop
            }
        };

})(window, jQuery);

// Auto-initialize when AJAX replaces the products container (safe fallback)
(function(){
    try {
        var observed = false;
        function ensureObserver(){
            if (observed) return;
            var container = document.getElementById('ajax-products-container');
            if (!container) return;
            observed = true;
            var mo = new MutationObserver(function(muts){
                // debounce small changes
                try { window.initProductCards && window.initProductCards(container); } catch(e) {}
            });
            mo.observe(container, { childList: true, subtree: true });
        }
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            ensureObserver();
        } else {
            document.addEventListener('DOMContentLoaded', ensureObserver);
        }
    } catch(e) { /* noop */ }
})();
