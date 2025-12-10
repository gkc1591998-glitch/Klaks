/**
 * Product Gallery Video Auto-play
 * Automatically plays video when the video slide is reached in the product gallery
 */

(function() {
    'use strict';

    function initVideoAutoplay() {
        // Check if we're on a product page with gallery
        const mainSlide = document.querySelector('.akasha-product-gallery__wrapper');
        const video = document.querySelector('.product-video');
        
        if (!mainSlide || !video) {
            return;
        }

        // If using jQuery/Slick
        if (typeof jQuery !== 'undefined') {
            const $gallery = jQuery('.product-gallery-slick');
            
            if ($gallery.length > 0) {
                // Listen for Slick afterChange event
                $gallery.on('afterChange', function(event, slick, currentSlide) {
                    // Find video slide index
                    const totalSlides = slick.$slides.length;
                    const videoSlideIndex = totalSlides - 1; // Last slide is video
                    
                    if (currentSlide === videoSlideIndex) {
                        // We're on the video slide
                        setTimeout(function() {
                            const vid = document.querySelector('.product-video');
                            if (vid && vid.paused) {
                                vid.play();
                            }
                        }, 300);
                    } else {
                        // We're not on video slide - pause it
                        if (video.paused === false) {
                            video.pause();
                            video.currentTime = 0;
                        }
                    }
                });

                // Initialize - check if video is already visible on load
                setTimeout(function() {
                    const videoSlideIndex = slick.$slides.length - 1;
                    if (slick.currentSlide === videoSlideIndex) {
                        const vid = document.querySelector('.product-video');
                        if (vid && vid.paused) {
                            vid.play();
                        }
                    }
                }, 500);
            }
        }

        // Handle thumbnail click to video slide
        const videoThumbnail = document.querySelector('.flex-control-nav li:last-child');
        if (videoThumbnail) {
            videoThumbnail.addEventListener('click', function() {
                setTimeout(function() {
                    const vid = document.querySelector('.product-video');
                    if (vid && vid.paused) {
                        vid.play();
                    }
                }, 300);
            });
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initVideoAutoplay);
    } else {
        initVideoAutoplay();
    }

    // Also handle jQuery ready if available
    if (typeof jQuery !== 'undefined') {
        jQuery(function() {
            initVideoAutoplay();
        });
    }

})();
