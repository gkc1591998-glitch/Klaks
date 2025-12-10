window.addEventListener('load', function() {
    // Show preloader until page fully loads
    document.getElementById('preloader').style.display = 'flex';
    
    // Once everything is loaded, fade out preloader
    setTimeout(function() {
        document.getElementById('preloader').style.opacity = '0';
        document.getElementById('preloader').style.transition = 'opacity 0.5s';
        
        // Remove preloader from DOM after fade
        setTimeout(function() {
            document.getElementById('preloader').style.display = 'none';
        }, 500);
    }, 100); // Shorter delay to ensure page is ready
});


// function toggleFilterSidebar() {
//     const widgetArea = document.getElementById('widget-area');
    
//     // Toggle d-none class for mobile view
//     widgetArea.classList.toggle('d-none');
    
//     // Keep the d-md-block class for desktop view
//     widgetArea.classList.add('d-md-block');
    
//     // Add mobile-specific styling
//     if (!widgetArea.classList.contains('d-none')) {
//         widgetArea.style.position = 'fixed';
//         widgetArea.style.top = '0';
//         widgetArea.style.left = '0';
//         widgetArea.style.width = '100%';
//         widgetArea.style.height = '100vh';
//         widgetArea.style.backgroundColor = 'white';
//         widgetArea.style.zIndex = '1000';
//         widgetArea.style.overflowY = 'auto';
//         widgetArea.style.padding = '20px';
//     } else {
//         widgetArea.style = null;
//     }
// }



// document.addEventListener('DOMContentLoaded', function() {
//     // Get all color circles
//     const circles = document.querySelectorAll('.circle');
    
//     circles.forEach(circle => {
//         circle.addEventListener('click', function() {
//             // Get the color class (blue, pink, yellow, etc)
//             const color = this.classList[1];
//             const productItem = this.closest('.product-item');
            
//             // Remove active class from all circles and images
//             productItem.querySelectorAll('.circle').forEach(c => c.classList.remove('active'));
//             productItem.querySelectorAll('.carousel-item').forEach(img => img.classList.remove('active'));
            
//             // Add active class to clicked circle and corresponding image
//             this.classList.add('active');
//             productItem.querySelector(`.carousel-item.${color}`).classList.add('active');
            
//             // Hide all price spans and show the one for selected color
//             productItem.querySelectorAll('.akasha-Price-currencySymbol').forEach(price => {
//                 price.style.display = 'none';
//             });
//             productItem.querySelector(`.akasha-Price-currencySymbol.${color}`).style.display = 'inline';
//         });
//     });
    
//     // Show initial prices for active colors
//     document.querySelectorAll('.product-item').forEach(item => {
//         const activeColor = item.querySelector('.circle.active').classList[1];
//         item.querySelectorAll('.akasha-Price-currencySymbol').forEach(price => {
//             price.style.display = 'none';
//         });
//         item.querySelector(`.akasha-Price-currencySymbol.${activeColor}`).style.display = 'inline';
//     });
// });
 


// function toggleListView(event) {
//     event.preventDefault();

//     // Get all product items under main-content
//     const productItems = document.querySelectorAll('.main-content .product-item');

//     // Toggle classes for each product item
//     productItems.forEach(item => {
//         if (item.classList.contains('col-ts-6')) {
//             item.classList.remove('col-ts-6');
//             item.classList.add('col-ts-12');
//         } else {
//             item.classList.remove('col-ts-12');
//             item.classList.add('col-ts-6');
//         }
//     });

//     const productInfoElements = document.querySelectorAll('.product-info');

//     // Toggle display for each element
//     productInfoElements.forEach(element => {
//         if (element.style.display === 'none') {
//             element.style.display = 'block';
//         }

//     });


//     // Toggle active class on the clicked button
//     const gridButtons = document.querySelectorAll('.modes-mode');
//     gridButtons.forEach(btn => btn.classList.remove('active'));
//     event.currentTarget.classList.add('active');
// }

// function toggleProductInfo(event) {
//     event.preventDefault();

//     // Get all elements with class product-info
//     const productInfoElements = document.querySelectorAll('.product-info');

//     // Toggle display for each element
//     productInfoElements.forEach(element => {
//         if (element.style.display === 'none') {
//             element.style.display = 'block';
//         } else {
//             element.style.display = 'none';
//         }

//     });

//     // Get all product items under main-content
//     const productItems = document.querySelectorAll('.main-content .product-item');

//     // Toggle classes for each product item
//     productItems.forEach(item => {
//         if (item.classList.contains('col-ts-12')) {
//             item.classList.remove('col-ts-12');
//             item.classList.add('col-ts-6');
//         }
//     });

//     // Toggle active class on the clicked button
//     const gridButtons = document.querySelectorAll('.modes-mode');
//     gridButtons.forEach(btn => btn.classList.remove('active'));
//     event.currentTarget.classList.add('active');
// }

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.accordion-header').forEach(header => {
        header.addEventListener('click', () => {
            const section = header.parentElement;
            const isActive = section.classList.contains('active');

            // Close all sections
            document.querySelectorAll('.accordion-section').forEach(section => {
                section.classList.remove('active');
            });

            // Open clicked section if it wasn't already active
            if (!isActive) {
                section.classList.add('active');
            }
        });
    });
});



// let isMouseOverGallery = false;

// document.querySelector('.flex-viewport')?.addEventListener('mouseenter', function() {
    
//     isMouseOverGallery = true;
// });

// document.querySelector('.flex-viewport')?.addEventListener('mouseleave', function() {
//     isMouseOverGallery = false;
// });

// setInterval(function() {
//     if (!isMouseOverGallery) {
//         const nextButton = document.querySelector('.next.slick-arrow');
//         if (nextButton) {
//             nextButton.click();
//         }
//     }
// }, 3000);
 
// document.addEventListener('DOMContentLoaded', function() {
//     const video = document.getElementById("video");
//     const overlay = document.getElementById("overlay");
//     if (video && overlay) {
//         overlay.addEventListener("click", function() {
//             video.play();
//             overlay.style.display = "none"; // Hide overlay when video starts
//         });
//     } else {
//         // Optional: log a warning for missing elements
//         if (!video) console.warn('Element with id "video" not found.');
//         if (!overlay) console.warn('Element with id "overlay" not found.');
//     }
// });