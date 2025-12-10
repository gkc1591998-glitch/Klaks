/**
 * Product Sharing Functionality
 * Supports: Facebook, Twitter, LinkedIn, WhatsApp, Pinterest, Email, Copy Link
 * Uses: Native Web Share API with fallback to social sharing URLs
 */

(function() {
    'use strict';

    // Get product information
    function getProductInfo() {
        const pageUrl = window.location.href;
        const pageTitle = document.querySelector('h1.entry-title')?.textContent || document.title;
        const priceElement = document.querySelector('.akasha-Price-amount.amount')?.textContent || '';
        const description = document.querySelector('.akasha-product-details__short-description')?.textContent || '';
        
        // Extract image from first product image
        const productImage = document.querySelector('.akasha-product-gallery__image img')?.src || '';

        return {
            url: pageUrl,
            title: pageTitle.trim(),
            price: priceElement.trim(),
            description: description.trim().substring(0, 100), // First 100 chars
            image: productImage
        };
    }

    // Show share dialog using Web Share API
    function showWebShareDialog() {
        const product = getProductInfo();
        const shareData = {
            title: product.title,
            text: `Check out this product: ${product.title} ${product.price}`,
            url: product.url
        };

        if (navigator.share) {
            navigator.share(shareData)
                .then(() => console.log('Share successful'))
                .catch((error) => {
                    if (error.name !== 'AbortError') {
                        console.error('Error sharing:', error);
                    }
                });
        } else {
            // Fallback: show toast notification
            showToast('Web Share API not supported. Use social buttons below to share.', 'warning');
        }
    }

    // Share to Facebook
    function shareToFacebook() {
        const product = getProductInfo();
        const facebookUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + 
                          encodeURIComponent(product.url);
        window.open(facebookUrl, 'facebook-share', 'width=600,height=600');
    }

    // Share to Twitter
    function shareToTwitter() {
        const product = getProductInfo();
        const twitterUrl = 'https://twitter.com/intent/tweet?url=' + 
                         encodeURIComponent(product.url) + 
                         '&text=' + 
                         encodeURIComponent(`Check out: ${product.title} ${product.price}`);
        window.open(twitterUrl, 'twitter-share', 'width=600,height=400');
    }

    // Share to LinkedIn
    function shareToLinkedIn() {
        const product = getProductInfo();
        const linkedinUrl = 'https://www.linkedin.com/sharing/share-offsite/?url=' + 
                          encodeURIComponent(product.url);
        window.open(linkedinUrl, 'linkedin-share', 'width=600,height=600');
    }

    // Share to WhatsApp
    function shareToWhatsApp() {
        const product = getProductInfo();
        const whatsappUrl = 'https://web.whatsapp.com/send?text=' + 
                          encodeURIComponent(`Check out this product: ${product.title} ${product.price} ${product.url}`);
        window.open(whatsappUrl, 'whatsapp-share', 'width=600,height=600');
    }

    // Share to Pinterest
    function shareToPinterest() {
        const product = getProductInfo();
        const pinterestUrl = 'https://pinterest.com/pin/create/button/?url=' + 
                           encodeURIComponent(product.url) + 
                           '&description=' + 
                           encodeURIComponent(product.title) +
                           (product.image ? '&media=' + encodeURIComponent(product.image) : '');
        window.open(pinterestUrl, 'pinterest-share', 'width=750,height=500');
    }

    // Share via Email
    function shareViaEmail() {
        const product = getProductInfo();
        const subject = encodeURIComponent(`Check out this product: ${product.title}`);
        const body = encodeURIComponent(
            `I thought you might like this product:\n\n` +
            `${product.title}\n` +
            `${product.price}\n\n` +
            `${product.url}`
        );
        window.location.href = `mailto:?subject=${subject}&body=${body}`;
    }

    // Copy link to clipboard
    function copyLinkToClipboard() {
        const product = getProductInfo();
        const text = product.url;
        
        // Use modern Clipboard API if available
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text)
                .then(() => {
                    showToast('Link copied to clipboard!', 'success');
                })
                .catch(() => {
                    fallbackCopyToClipboard(text);
                });
        } else {
            fallbackCopyToClipboard(text);
        }
    }

    // Fallback copy to clipboard for older browsers
    function fallbackCopyToClipboard(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();
        
        try {
            document.execCommand('copy');
            showToast('Link copied to clipboard!', 'success');
        } catch (error) {
            console.error('Failed to copy:', error);
            showToast('Failed to copy link', 'error');
        }
        
        document.body.removeChild(textarea);
    }

    // Show toast notification
    function showToast(message, type = 'info') {
        // Check if custom toast library is available
        if (typeof window.showToastMessage === 'function') {
            window.showToastMessage(message, type);
        } else if (typeof window.Toast !== 'undefined') {
            window.Toast.show({
                message: message,
                type: type,
                duration: 3000
            });
        } else {
            // Fallback alert
            alert(message);
        }
    }

    // Main share function
    window.shareProduct = function(platform) {
        switch(platform) {
            case 'facebook':
                shareToFacebook();
                break;
            case 'twitter':
                shareToTwitter();
                break;
            case 'linkedin':
                shareToLinkedIn();
                break;
            case 'whatsapp':
                shareToWhatsApp();
                break;
            case 'pinterest':
                shareToPinterest();
                break;
            case 'email':
                shareViaEmail();
                break;
            case 'copy':
                copyLinkToClipboard();
                break;
            default:
                console.warn('Unknown share platform:', platform);
        }
    };

    // Show Web Share Dialog
    window.showShareDialog = function() {
        showWebShareDialog();
    };

    // Make share info available globally for debugging
    window.getProductShareInfo = getProductInfo;

})();
