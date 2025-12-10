/* Enhanced toast utility with mobile/desktop detection */
(function(window, document){
  'use strict';
  
  // Enhanced mobile detection
  function isMobile() {
    // Check screen size first
    if (window.innerWidth <= 768) return true;
    
    // Check user agent for mobile devices
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;
    return /android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(userAgent);
  }
  
  function ensureContainer(){
    var id = isMobile() ? 'appToastContainerMobile' : 'appToastContainer';
    var c = document.getElementById(id);
    if (!c) {
      c = document.createElement('div');
      c.id = id;
      if (isMobile()) {
        c.className = 'app-toast-container mobile';
        // Position above mobile footer cart
        c.style.position = 'fixed';
        c.style.bottom = '70px'; // Just above mobile footer
        c.style.left = '50%';
        c.style.transform = 'translateX(-50%)';
        c.style.zIndex = '99998'; // Below modals but above content
        c.style.width = '90%';
        c.style.maxWidth = '300px';
      } else {
        c.className = 'app-toast-container desktop';
        // Position near desktop cart (top right)
        c.style.position = 'fixed';
        c.style.top = '80px';
        c.style.right = '20px';
        c.style.zIndex = '99998';
        c.style.width = '320px';
      }
      c.setAttribute('aria-live','polite');
      c.setAttribute('aria-atomic','true');
      document.body.appendChild(c);
    }
    return c;
  }

  window.showToast = function(message, options){
    options = options || {};
    var type = options.type || 'info';
    var timeout = typeof options.timeout === 'number' ? options.timeout : 3500;
    var container = ensureContainer();
    if (!container) return null;
    var el = document.createElement('div');
    el.className = 'app-toast type-' + (type || 'info');
    if (type === 'success') {
      el.style.background = 'rgba(40, 167, 69, 0.95)';
      el.style.borderLeft = '4px solid rgba(255,255,255,0.3)';
    } else if (type === 'error') {
      el.style.background = 'rgba(220, 53, 69, 0.95)';
      el.style.borderLeft = '4px solid rgba(255,255,255,0.3)';
    } else {
      el.style.background = 'rgba(0, 0, 0, 0.85)';
      el.style.borderLeft = '4px solid rgba(255,255,255,0.15)';
    }
    var body = document.createElement('div');
    body.className = 'app-toast-body';
    body.textContent = message || '';
    var closeBtn = document.createElement('button');
    closeBtn.className = 'app-toast-close';
    closeBtn.setAttribute('aria-label','close');
    closeBtn.textContent = '×';
    el.appendChild(body);
    el.appendChild(closeBtn);
    container.appendChild(el);
    // allow transition
    setTimeout(function(){ el.classList.add('show'); }, 10);
    var remove = function(){
      el.classList.remove('show');
      setTimeout(function(){ try{ container.removeChild(el); }catch(e){} }, 260);
    };
    closeBtn.addEventListener('click', remove);
    if (timeout > 0) setTimeout(remove, timeout);
    return el;
  };

  // Enhanced mobile cart count update
  window.updateMobileCartCount = function(count) {
    console.log('Updating mobile cart count to:', count);
    
    // Convert count to number
    var cartCount = parseInt(count) || 0;
    
    // Update mobile footer cart count
    var mobileCartCount = document.querySelector('.mobile-cart-count');
    if (mobileCartCount) {
      mobileCartCount.textContent = cartCount;
      
      // Show/hide count based on value
      if (cartCount > 0) {
        mobileCartCount.style.display = 'inline-block';
        mobileCartCount.style.visibility = 'visible';
      } else {
        mobileCartCount.style.display = 'none';
        mobileCartCount.style.visibility = 'hidden';
      }
      console.log('Updated mobile footer cart count to:', cartCount);
    }
    
    // Update any other cart count elements in footer
    var footerCartCounts = document.querySelectorAll('.footer-device-mobile .count-icon');
    footerCartCounts.forEach(function(el) {
      if (el.classList.contains('mobile-cart-count')) {
        el.textContent = cartCount;
        if (cartCount > 0) {
          el.style.display = 'inline-block';
          el.style.visibility = 'visible';
        } else {
          el.style.display = 'none';
          el.style.visibility = 'hidden';
        }
      }
    });
    
    // Update header cart count if exists
    var headerCartCount = document.querySelector('#cartdivid .count');
    if (headerCartCount) {
      headerCartCount.textContent = cartCount;
    }
    
    // Update mobile header cart count  
    var mobileCartCount = document.querySelector('#mobile-cartdivid .count');
    if (mobileCartCount) {
      mobileCartCount.textContent = cartCount;
    }
  };

  // Debug function to check mobile detection
  window.debugMobileDetection = function() {
    console.log('Screen width:', window.innerWidth);
    console.log('User agent:', navigator.userAgent);
    console.log('Is mobile:', isMobile());
  };

})(window, document);
