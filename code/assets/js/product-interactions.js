$(document).ready(function() {
    // Delegate color selection so it works for AJAX-inserted items
    $(document).on('click', '.color-selector', function() {
        var $el = $(this);
        var productId = $el.data('product-id');
        var uniqueId = $el.data('variant-id') || $el.data('first-variant');
        var color = $el.data('color') || $el.data('color-name');

        // Update price display
        $('#product-price-' + productId + ' .price-value').hide();
        $('#product-price-' + productId + ' .price-value[data-variant-id="' + uniqueId + '"]').show();

        // Update carousel (prefer carousel API)
        var $carousel = $('#carousel-' + productId);
        var $target = $carousel.find('.carousel-item[data-variant-id="' + uniqueId + '"]').first();
        if ($target.length && typeof $carousel.carousel === 'function') {
            var idx = $carousel.find('.carousel-item').index($target);
            if (idx < 0) idx = 0;
            try { $carousel.carousel(idx); } catch (e) { $carousel.find('.carousel-item').removeClass('active'); $target.addClass('active'); }
        } else {
            $carousel.find('.carousel-item').removeClass('active');
            $target.addClass('active');
        }

        // Update selected state of color circles
        $el.closest('.circles').find('.color-selector').removeClass('selected');
        $el.addClass('selected');
    });

    // Delegate size selection so it works for AJAX-inserted items
    $(document).on('click', '.size-selector', function() {
        var $el = $(this);
        var productId = $el.data('product-id');
        var uniqueId = $el.data('variant-id') || ($el.closest('.product-item').find('.color-selector.active').data('first-variant') || '');

        // Update price display
        $('#product-price-' + productId + ' .price-value').hide();
        if (uniqueId) {
            $('#product-price-' + productId + ' .price-value[data-variant-id="' + uniqueId + '"]').show();
        } else {
            $('#product-price-' + productId + ' .price-value').first().show();
        }

        // Update carousel (prefer carousel API)
        var $carousel = $('#carousel-' + productId);
        var $target = $carousel.find('.carousel-item[data-variant-id="' + uniqueId + '"]').first();
        if ($target.length && typeof $carousel.carousel === 'function') {
            var idx = $carousel.find('.carousel-item').index($target);
            if (idx < 0) idx = 0;
            try { $carousel.carousel(idx); } catch (e) { $carousel.find('.carousel-item').removeClass('active'); $target.addClass('active'); }
        } else {
            $carousel.find('.carousel-item').removeClass('active');
            $target.addClass('active');
        }

        // Update selected state of size buttons
        $el.closest('.rating-wapper').find('.size-selector').removeClass('selected');
        $el.addClass('selected');
    });

    // Add CSS for selected states
    $('<style>')
        .text(`
            .color-selector.selected {
                border: 2px solid #000;
                transform: scale(1.1);
            }
            .size-selector.selected {
                font-weight: bold;
                text-decoration: underline;
            }
        `)
        .appendTo('head');
});
