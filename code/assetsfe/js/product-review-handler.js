/**
 * Product Review Form Handler
 * Handles review form submission and displays success/error messages
 * Uses emoji rating system with satisfaction colors
 */

(function() {
    'use strict';

    let selectedRating = 0;

    // Initialize when DOM is ready
    function initReviewForm() {
        const form = document.getElementById('commentform');
        const submitBtn = document.querySelector('.btn-submit');
        const messageContainer = document.getElementById('form-message');

        if (!form) {
            console.log('Review form not found yet, will try again...');
            return;
        }

        console.log('Review form initialized');

        // Setup rating button clicks
        const ratingButtons = document.querySelectorAll('.rating-btn');
        
        ratingButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Get rating from data attribute
                const rating = parseInt(this.getAttribute('data-rating'));
                
                console.log('Rating selected: ' + rating);
                
                selectedRating = rating;
                const ratingInput = document.getElementById('rating');
                if (ratingInput) {
                    ratingInput.value = selectedRating;
                }
                
                // Remove active class from all buttons
                ratingButtons.forEach(b => b.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
            });
        });

        // Setup form submission handler
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const name = document.getElementById('author').value.trim();
            const email = document.getElementById('email').value.trim();
            const comment = document.getElementById('comment').value.trim();
            const productId = document.getElementById('product_id').value;
            const variantId = document.getElementById('variant_id_input').value;

            // Validation
            if (!name || !email || !comment) {
                showMessage('Please fill all required fields.', 'error');
                return;
            }

            if (selectedRating === 0) {
                showMessage('Please select a rating.', 'error');
                return;
            }

            if (!isValidEmail(email)) {
                showMessage('Please enter a valid email address.', 'error');
                return;
            }

            // Disable submit button
            if (submitBtn) {
                submitBtn.disabled = true;
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Submitting...';
            }

            // Prepare data as URL-encoded string (like traditional form submission)
            const params = new URLSearchParams();
            params.append('name', name);
            params.append('email', email);
            params.append('rating', selectedRating);
            params.append('comment', comment);
            params.append('product_id', productId);
            params.append('variant_id', variantId);

            // Construct the proper endpoint URL using base_url from hidden input
            const baseUrlInput = document.getElementById('base_url');
            const baseUrl = baseUrlInput ? baseUrlInput.value : '';
            const submitUrl = baseUrl + 'products/submit_review';
            
            console.log('Submitting review to:', submitUrl);
            console.log('Form data:', {name, email, selectedRating, productId, variantId});

            // Submit via AJAX
            fetch(submitUrl, {
                method: 'POST',
                body: params,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
            .then(response => {
                // console.log('Response status:', response.status);
                // console.log('Response headers:', response.headers);
                if (!response.ok) {
                    console.error('HTTP Error:', response.status, response.statusText);
                }
                return response.text(); // First get as text to see what we're actually getting
            })
            .then(text => {
                console.log('Raw response text:', text);
                try {
                    const data = JSON.parse(text);
                    // console.log('Parsed response data:', data);
                    if (data.success) {
                        showMessage('Thank you! Your review has been submitted successfully.', 'success');
                        
                        // Reset form
                        form.reset();
                        selectedRating = 0;
                        
                        // Reset rating buttons
                        ratingButtons.forEach(b => b.classList.remove('active'));
                        document.getElementById('rating').value = 0;

                        // Reload reviews after 2 seconds
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    } else {
                        showMessage(data.message || 'Failed to submit review. Please try again.', 'error');
                    }
                } catch (e) {
                    // console.error('Failed to parse JSON:', e);
                    showMessage('Server returned invalid response. Check console for details.', 'error');
                }
            })
            .catch(error => {
                // console.error('Error submitting review:', error);
                showMessage('An error occurred. Please check your connection and try again.', 'error');
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Submit Review';
                }
            });
        });

        // Helper function to validate email
        function isValidEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        // Helper function to show messages
        function showMessage(message, type) {
            if (!messageContainer) return;

            messageContainer.textContent = message;
            messageContainer.className = 'form-message ' + type;
            messageContainer.style.display = 'block';

            // Auto-hide after 5 seconds (unless it's success which reloads)
            if (type !== 'success') {
                setTimeout(() => {
                    messageContainer.style.display = 'none';
                }, 5000);
            }
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initReviewForm);
    } else {
        initReviewForm();
    }

    // Also try with jQuery if available
    if (typeof jQuery !== 'undefined') {
        jQuery(function() {
            initReviewForm();
        });
    }

})();
