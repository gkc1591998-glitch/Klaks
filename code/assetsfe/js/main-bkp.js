window.addEventListener('load', function() {
    // Show preloader until page fully loads
    var preloader = document.getElementById('preloader');
    if (preloader) {
        preloader.style.display = 'flex';
        
        // Once everything is loaded, fade out preloader
        setTimeout(function() {
            preloader.style.opacity = '0';
            preloader.style.transition = 'opacity 0.5s';
            
            // Remove preloader from DOM after fade
            setTimeout(function() {
                preloader.style.display = 'none';
            }, 500);
        }, 100); // Shorter delay to ensure page is ready
    }
});

// document.addEventListener('DOMContentLoaded', function() {
//     // Get all color circles
//     const circles = document.querySelectorAll('.circle');
    
//     circles.forEach(circle => {
//         circle.addEventListener('click', function() {
//             // Get the color class (blue, pink, yellow, etc)
//             const color = this.classList[1];
//             const productItem = this.closest('.product-item');
//             if (!productItem) return;
//             // Remove active class from all circles and images
//             productItem.querySelectorAll('.circle').forEach(c => c && c.classList.remove('active'));
//             productItem.querySelectorAll('.carousel-item').forEach(img => img && img.classList.remove('active'));
//             // Add active class to clicked circle and corresponding image
//             this.classList.add('active');
//             const carousel = productItem.querySelector(`.carousel-item.${color}`);
//             if (carousel) {
//                 carousel.classList.add('active');
//             }
//             // Hide all price spans and show the one for selected color
//             productItem.querySelectorAll('.akasha-Price-currencySymbol').forEach(price => {
//                 if (price && price.style) price.style.display = 'none';
//             });
//             const priceEl = productItem.querySelector(`.akasha-Price-currencySymbol.${color}`);
//             if (priceEl && priceEl.style) {
//                 priceEl.style.display = 'inline';
//             }
//         });
//     });
//     // Show initial prices for active colors
//     document.querySelectorAll('.product-item').forEach(item => {
//         const activeCircle = item.querySelector('.circle.active');
//         if (!activeCircle) return;
//         const activeColor = activeCircle.classList[1];
//         item.querySelectorAll('.akasha-Price-currencySymbol').forEach(price => {
//             if (price && price.style) price.style.display = 'none';
//         });
//         const priceEl = item.querySelector(`.akasha-Price-currencySymbol.${activeColor}`);
//         if (priceEl && priceEl.style) {
//             priceEl.style.display = 'inline';
//         }
//     });
// });

 
// const video = document.getElementById("video");
// const overlay = document.getElementById("overlay");

// overlay.addEventListener("click", function() {
//     video.play();
//     overlay.style.display = "none"; // Hide overlay when video starts
// });

// Note: 404 errors for images mean the files are missing on the server. You must upload the missing images or update the image paths in your backend code. The JS cannot fix missing files.
// For Google Maps API warning, add async and defer to your script tag as suggested in the warning message.



