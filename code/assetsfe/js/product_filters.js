// product_filters.js - robust loader and handler (single implementation)
(function () {
  // startup log removed for cleanup; keep safeLog for errors

  function safeLog() { if (window.console && console.log) console.log.apply(console, arguments); }

  function getDataAttributes(el) {
    if (!el) return { name: '', subcatid: '', subcatslug: '' };
    return {
      name: el.getAttribute('data-name') || (el.dataset && el.dataset.name) || '',
      subcatid: el.getAttribute('data-subcatid') || el.getAttribute('data-subcat-id') || (el.dataset && (el.dataset.subcatid || el.dataset.subcatId)) || '',
      subcatslug: el.getAttribute('data-sub-cat-slug') || el.getAttribute('data-subcat-slug') || (el.dataset && (el.dataset.subCatSlug || el.dataset.subcatSlug)) || ''
    };
  }

  function showLoader() {
    var l = document.getElementById('ajax-loader');
    if (l) l.style.display = 'flex';
  }

  function hideLoader() {
    var l = document.getElementById('ajax-loader');
    if (l) l.style.display = 'none';
  }

  function handleClick(el) {
    safeLog('product_filters: clicked', el);
    // normalize active class
    var others = document.querySelectorAll('.ajax-filter-btn, .ajax-filter-top-btn');
    Array.prototype.forEach.call(others, function (o) { o.classList.remove('active'); });
    el.classList.add('active');

    // clear sidebar radios
    var radios = document.querySelectorAll('input[type="radio"]');
    Array.prototype.forEach.call(radios, function (r) { r.checked = false; });

    var data = getDataAttributes(el);
    var payload = { name: data.name, subcatid: data.subcatid, 'sub-cat-slug': data.subcatslug };
    safeLog('product filter payload:', payload);

    // show loader
    showLoader();

    // perform AJAX — use fetch if available, fallback to XHR
    try {
      var url = (typeof site_url !== 'undefined' ? site_url : '/') + 'products/ajax_products';

      if (window.fetch) {
        var form = new FormData();
        Object.keys(payload).forEach(function (k) { form.append(k, payload[k]); });
      fetch(url, { method: 'POST', body: form, credentials: 'same-origin' }).then(function (res) {
          return res.json().catch(function () { return null; });
        }).then(function (json) {
          hideLoader();
          if (json && json.success) {
            var container = document.getElementById('ajax-products-container');
            if (container) container.innerHTML = json.html;
        // Re-run product card initialization for newly injected content
        try { if (window.initProductCards) window.initProductCards(document.getElementById('ajax-products-container')); } catch(e) {}
          } else {
            safeLog('product_filters: server returned error', json);
          }
        }).catch(function (err) { hideLoader(); safeLog('product_filters: fetch error', err); });
      } else {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4) {
            hideLoader();
                try {
                  var json = JSON.parse(xhr.responseText);
                  if (json && json.success) {
                    var container = document.getElementById('ajax-products-container');
                    if (container) container.innerHTML = json.html;
                    try { if (window.initProductCards) window.initProductCards(document.getElementById('ajax-products-container')); } catch(e) {}
                  } else {
                    safeLog('product_filters: XHR server error', xhr.responseText);
                  }
                } catch (e) {
                  safeLog('product_filters: XHR parse error', e, xhr.responseText);
                }
          }
        };
        var params = [];
        Object.keys(payload).forEach(function (k) { params.push(encodeURIComponent(k) + '=' + encodeURIComponent(payload[k])); });
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(params.join('&'));
      }
    } catch (e) {
      hideLoader();
      safeLog('product_filters: AJAX exception', e);
    }
  }

  function attachHandlers() {
    if (window.jQuery) {
      jQuery(document).on('click', '.ajax-filter-btn, .ajax-filter-top-btn', function (e) {
        e.preventDefault();
        handleClick(this);
      });
    } else {
      // vanilla attach
      document.addEventListener('click', function (ev) {
        var target = ev.target;
        while (target && target !== document) {
          if (target.matches && (target.matches('.ajax-filter-btn') || target.matches('.ajax-filter-top-btn'))) {
            ev.preventDefault();
            handleClick(target);
            return;
          }
          target = target.parentNode;
        }
      }, false);
    }

    // Ensure loader hidden on start
    hideLoader();

    // Side filters: delegate radio changes (size, color, category, sort, fit), price filter, and search
    function handleSideFilterPayload(payload) {
      try { showLoader(); } catch(e){}
      try { var url = (typeof site_url !== 'undefined' ? site_url : '/') + 'products/ajax_filter_products'; } catch(e){ var url = '/products/ajax_filter_products'; }
      // use fetch if available
      if (window.fetch) {
        var form = new FormData();
        Object.keys(payload).forEach(function(k){ form.append(k, payload[k]); });
        fetch(url, { method: 'POST', body: form, credentials: 'same-origin' }).then(function(res){ return res.text(); }).then(function(html){ try { var container = document.getElementById('ajax-products-container'); if (container) container.innerHTML = html; try{ if (window.initProductCards) window.initProductCards(container); } catch(e){} } catch(e){}; try{ hideLoader(); } catch(e){}; }).catch(function(err){ try{ hideLoader(); }catch(e){}; safeLog('product_filters: side fetch error', err); });
      } else {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.onreadystatechange = function(){ if (xhr.readyState === 4) { try { var container = document.getElementById('ajax-products-container'); if (container) container.innerHTML = xhr.responseText; try{ if (window.initProductCards) window.initProductCards(container); } catch(e){} } catch(e){} try{ hideLoader(); } catch(e){} } };
        // send urlencoded
        var params = [];
        Object.keys(payload).forEach(function(k){ params.push(encodeURIComponent(k) + '=' + encodeURIComponent(payload[k])); });
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xhr.send(params.join('&'));
      }
    }

    if (window.jQuery) {
      // delegate radio changes for side filters
      jQuery(document).on('change', 'input[type="radio"][name="size"], input[type="radio"][name="color"], input[type="radio"][name="category"], input[type="radio"][name="sort"], input[type="radio"][name="fit"]', function(e){
        var $el = jQuery(this);
        if (!$el.prop('checked')) return;
        var payload = {};
        payload[$el.attr('name')] = $el.val();
        // clear top category active state
        jQuery('.ajax-filter-btn, .ajax-filter-top-btn').removeClass('active');
        handleSideFilterPayload(payload);
      });

      // In some themes the label element is clicked instead of the input itself.
      // Delegate clicks on the label wrapper to ensure the filter always fires.
      jQuery(document).on('click', '.btnfilter-option, .btnfilter-label', function(e){
        // locate the input inside the clicked element
        var $inp = jQuery(this).is('input[type="radio"]') ? jQuery(this) : jQuery(this).find('input[type="radio"]').first();
        if (!$inp || !$inp.length) return;
        // mark checked (ensures state) and build payload
        $inp.prop('checked', true);
        var payload = {};
        payload[$inp.attr('name')] = $inp.val();
        jQuery('.ajax-filter-btn, .ajax-filter-top-btn').removeClass('active');
        handleSideFilterPayload(payload);
      });

      // price filter button
      jQuery(document).on('click', '#price-filter-btn', function(e){
        e.preventDefault();
        var min = jQuery('#price-min').val();
        var max = jQuery('#price-max').val();
        jQuery('.ajax-filter-btn, .ajax-filter-top-btn').removeClass('active');
        handleSideFilterPayload({ price_min: min, price_max: max });
      });

      // search form
      jQuery(document).on('submit', '#search-form', function(e){
        e.preventDefault();
        var searchTerm = jQuery(this).find('.search-field').val() || '';
        jQuery('.ajax-filter-btn, .ajax-filter-top-btn').removeClass('active');
        handleSideFilterPayload({ search: searchTerm });
      });
    } else {
      // vanilla fallbacks
      document.addEventListener('change', function(ev){
        var t = ev.target;
        if (!t) return;
        if (t.matches && t.matches('input[type="radio"][name="size"], input[type="radio"][name="color"], input[type="radio"][name="category"], input[type="radio"][name="sort"], input[type="radio"][name="fit"]')) {
          if (!t.checked) return;
          var payload = {}; payload[t.name] = t.value;
          // clear top category active state
          var tops = document.querySelectorAll('.ajax-filter-btn, .ajax-filter-top-btn'); Array.prototype.forEach.call(tops, function(x){ x.classList.remove('active'); });
          handleSideFilterPayload(payload);
        }
      }, false);

      document.addEventListener('click', function(ev){
        var t = ev.target;
        if (!t) return;
        if (t.matches && t.matches('#price-filter-btn')) {
          ev.preventDefault();
          var min = document.getElementById('price-min') ? document.getElementById('price-min').value : '';
          var max = document.getElementById('price-max') ? document.getElementById('price-max').value : '';
          var tops = document.querySelectorAll('.ajax-filter-btn, .ajax-filter-top-btn'); Array.prototype.forEach.call(tops, function(x){ x.classList.remove('active'); });
          handleSideFilterPayload({ price_min: min, price_max: max });
        }
        // handle clicks on the styled filter label wrapper
        var el = t.closest ? t.closest('.btnfilter-option') : (function(){
          var n = t; while(n && n !== document){ if (n.classList && n.classList.contains('btnfilter-option')) return n; n = n.parentNode; } return null; })();
        if (el) {
          ev.preventDefault();
          var inp = el.querySelector('input[type="radio"]');
          if (inp) {
            inp.checked = true;
            var payload = {}; payload[inp.name] = inp.value;
            var tops = document.querySelectorAll('.ajax-filter-btn, .ajax-filter-top-btn'); Array.prototype.forEach.call(tops, function(x){ x.classList.remove('active'); });
            handleSideFilterPayload(payload);
            return;
          }
        }
        // search form submit handled via delegation on submit
      }, false);

      document.addEventListener('submit', function(ev){
        var t = ev.target;
        if (!t) return;
        if (t.matches && t.matches('#search-form')) {
          ev.preventDefault();
          var field = t.querySelector('.search-field');
          var searchTerm = field ? field.value : '';
          var tops = document.querySelectorAll('.ajax-filter-btn, .ajax-filter-top-btn'); Array.prototype.forEach.call(tops, function(x){ x.classList.remove('active'); });
          handleSideFilterPayload({ search: searchTerm });
        }
      }, false);
    }
  }

  if (document.readyState === 'complete' || document.readyState === 'interactive') {
    attachHandlers();
  } else {
    document.addEventListener('DOMContentLoaded', attachHandlers);
  }

})();

  // // Side navigation category filters - use same logic as top category filters
  // $('input[type="radio"][name="category"]').on("change", function () {
  //   console.log("Side category event triggered");
  //   if (this.checked) {
  //     var categoryValue = $(this).val();
  //     console.log("Side category filter clicked:", categoryValue);

  //     // Use the same AJAX logic as top category filters
  //     $("#ajax-loader").show();

  //     // Clear top category filter active states
  //     $(".ajax-filter-btn").removeClass("active");

  //     console.log(
  //       "Making AJAX call to ajax_products with type:",
  //       categoryValue
  //     );

  //     $.ajax({
  //       url: site_url + "products/ajax_products",
  //       type: "POST",
  //       data: {
  //         type: categoryValue,
  //       },
  //       dataType: "json",
  //       success: function (response) {
  //         console.log("Side category filter success:", response);
  //         if (response.success) {
  //           $("#ajax-products-container").html(response.html);
  //         } else {
  //           // alert("Filter failed: " + response.message);
  //         }
  //         $("#ajax-loader").hide();
  //       },
  //       error: function (xhr, status, error) {
  //         console.log("Side category filter error:", status, error);
  //         // console.log("Response:", xhr.responseText);
  //         // alert("Filter error: " + error);
  //         $("#ajax-loader").hide();
  //       },
  //     });
  //   }
  // });

  // // For size and color filters, we can implement them later if needed
  // // For now, let's focus on getting category filters working perfectly

  // // Additional specific binding for categories (debug) using event delegation
  // $(document).on("change", 'input[name="category"]', function () {
  //   console.log("Category filter specifically triggered:", $(this).val());
  // });

  // // Product search functionality
  // $(".akasha-product-search").on("submit", function (e) {
  //   e.preventDefault();
  //   var searchTerm = $(this).find(".search-field").val();

  //   if (searchTerm.length > 0) {
  //     $("#ajax-loader").show();

  //     $.ajax({
  //       url: site_url + "products/ajax_filter_products",
  //       type: "POST",
  //       data: {
  //         search: searchTerm,
  //       },
  //       success: function (response) {
  //         $("#ajax-products-container").html(response);
  //         $("#ajax-loader").hide();
  //       },
  //       error: function () {
  //         // alert("Error searching products");
  //         $("#ajax-loader").hide();
  //       },
  //     });
  //   }
  // });

  // // Clear filters
  // $(".btn-outline-secondary").on("click", function () {
  //   // Uncheck all radio buttons
  //   $('input[type="radio"]').prop("checked", false);

  //   // Clear search field
  //   $(".search-field").val("");

  //   // Reload all products
  //   $("#ajax-loader").show();

  //   $.ajax({
  //     url: site_url + "products/ajax_products/all",
  //     type: "GET",
  //     success: function (response) {
  //       if (response.success) {
  //         $("#ajax-products-container").html(response.html);
  //       }
  //       $("#ajax-loader").hide();
  //     },
  //     error: function () {
  //       $("#ajax-loader").hide();
  //       location.reload(); // Fallback to page reload
  //     },
  //   });
  // });

  // // Note: top filter handling is centralized above to support subcategory object/id payloads

  // // Side navigation SIZE filters
  // $('input[type="radio"][name="size"]').on("change", function () {
  //   console.log("Side size event triggered");
  //   if (this.checked) {
  //     var sizeValue = $(this).val();
  //     console.log("Side size filter clicked:", sizeValue);

  //     $("#ajax-loader").show();

  //     // Clear top category filter active states
  //     $(".ajax-filter-btn").removeClass("active");

  //     $.ajax({
  //       url: site_url + "products/ajax_filter_products",
  //       type: "POST",
  //       data: {
  //         size: sizeValue,
  //       },
  //       success: function (response) {
  //         console.log("Side size filter success");
  //         $("#ajax-products-container").html(response);
  //         $("#ajax-loader").hide();
  //       },
  //       error: function (xhr, status, error) {
  //         console.log("Side size filter error:", status, error);
  //         console.log("Response:", xhr.responseText);
  //         // alert("Size filter error: " + error);
  //         $("#ajax-loader").hide();
  //       },
  //     });
  //   }
  // });

  // // Side navigation COLOR filters
  // $('input[type="radio"][name="color"]').on("change", function () {
  //   console.log("Side color event triggered");
  //   if (this.checked) {
  //     var colorValue = $(this).val();
  //     console.log("Side color filter clicked:", colorValue);

  //     $("#ajax-loader").show();

  //     // Clear top category filter active states
  //     $(".ajax-filter-btn").removeClass("active");

  //     $.ajax({
  //       url: site_url + "products/ajax_filter_products",
  //       type: "POST",
  //       data: {
  //         color: colorValue,
  //       },
  //       success: function (response) {
  //         console.log("Side color filter success");
  //         $("#ajax-products-container").html(response);
  //         $("#ajax-loader").hide();
  //       },
  //       error: function (xhr, status, error) {
  //         console.log("Side color filter error:", status, error);
  //         console.log("Response:", xhr.responseText);
  //         // alert("Color filter error: " + error);
  //         $("#ajax-loader").hide();
  //       },
  //     });
  //   }
  // });

  // // Side navigation SORT BY filters
  // $('input[type="radio"][name="sort"]').on("change", function () {
  //   console.log("Side sort event triggered");
  //   if (this.checked) {
  //     var sortValue = $(this).val();
  //     console.log("Side sort filter clicked:", sortValue);

  //     $("#ajax-loader").show();

  //     // Clear top category filter active states
  //     $(".ajax-filter-btn").removeClass("active");

  //     $.ajax({
  //       url: site_url + "products/ajax_filter_products",
  //       type: "POST",
  //       data: {
  //         sort: sortValue,
  //       },
  //       success: function (response) {
  //         console.log("Side sort filter success");
  //         $("#ajax-products-container").html(response);
  //         $("#ajax-loader").hide();
  //       },
  //       error: function (xhr, status, error) {
  //         console.log("Side sort filter error:", status, error);
  //         console.log("Response:", xhr.responseText);
  //         // alert("Sort filter error: " + error);
  //         $("#ajax-loader").hide();
  //       },
  //     });
  //   }
  // });

  // // Price filter functionality
  // $("#price-filter-btn").on("click", function (e) {
  //   e.preventDefault();
  //   console.log("Price filter button clicked");

  //   // Get the current price range values
  //   var minPrice = $("#price-min").val() || 500;
  //   var maxPrice = $("#price-max").val() || 5000;

  //   console.log("Price range filter:", minPrice, "to", maxPrice);

  //   $("#ajax-loader").show();

  //   // Clear top category filter active states
  //   $(".ajax-filter-btn").removeClass("active");

  //   $.ajax({
  //     url: site_url + "products/ajax_filter_products",
  //     type: "POST",
  //     data: {
  //       price_min: minPrice,
  //       price_max: maxPrice,
  //     },
  //     success: function (response) {
  //       console.log("Price filter success");
  //       $("#ajax-products-container").html(response);
  //       $("#ajax-loader").hide();
  //     },
  //     error: function (xhr, status, error) {
  //       console.log("Price filter error:", status, error);
  //       console.log("Response:", xhr.responseText);
  //       // alert("Price filter error: " + error);
  //       $("#ajax-loader").hide();
  //     },
  //   });
  // });

  // // Simple price slider simulation (if there's no actual slider library)
  // // This creates a basic range input simulation
  // if ($("#price-slider").length && typeof $.fn.slider === "undefined") {
  //   // Create simple range inputs if no slider library is available
  //   var $slider = $("#price-slider");
  //   var $wrapper = $slider.closest(".price_slider_wrapper");

  //   if (!$wrapper.find(".simple-price-range").length) {
  //     $wrapper.prepend(`
  //               <div class="simple-price-range" style="margin-bottom: 15px;">
  //                   <label style="display: block; margin-bottom: 5px;">Min Price:</label>
  //                   <input type="range" id="price-range-min" min="500" max="5000" value="500" step="100" style="width: 100%; margin-bottom: 10px;">
  //                   <label style="display: block; margin-bottom: 5px;">Max Price:</label>
  //                   <input type="range" id="price-range-max" min="500" max="5000" value="5000" step="100" style="width: 100%;">
  //               </div>
  //           `);

  //     // Update hidden inputs and display when ranges change
  //     $("#price-range-min, #price-range-max").on("input", function () {
  //       var minVal = parseInt($("#price-range-min").val());
  //       var maxVal = parseInt($("#price-range-max").val());

  //       // Ensure min is always less than max
  //       if (minVal >= maxVal) {
  //         if (this.id === "price-range-min") {
  //           maxVal = minVal + 100;
  //           $("#price-range-max").val(maxVal);
  //         } else {
  //           minVal = maxVal - 100;
  //           $("#price-range-min").val(minVal);
  //         }
  //       }

  //       $("#price-min").val(minVal);
  //       $("#price-max").val(maxVal);
  //       $("#price-from").text("₹" + minVal);
  //       $("#price-to").text("₹" + maxVal);
  //     });
  //   }
  // }

  // // Search functionality
  // var searchTimeout;

  // // Handle search input changes (typing)
  // $("#akasha-product-search-field-0").on("input", function () {
  //   var searchTerm = $(this).val().trim();

  //   // Clear previous timeout
  //   clearTimeout(searchTimeout);

  //   // Set a small delay to avoid too many AJAX calls while typing
  //   searchTimeout = setTimeout(function () {
  //     performSearch(searchTerm);
  //   }, 300);
  // });

  // // Handle search form submission
  // $("#search-form").on("submit", function (e) {
  //   e.preventDefault();
  //   var searchTerm = $("#akasha-product-search-field-0").val().trim();
  //   performSearch(searchTerm);
  // });

  // // Search function
  // function performSearch(searchTerm) {
  //   console.log("Performing search for:", searchTerm);

  //   $("#ajax-loader").show();

  //   // Clear all filter active states
  //   $(".ajax-filter-btn").removeClass("active");
  //   $('input[type="radio"]').prop("checked", false);

  //   if (searchTerm === "") {
  //     // If search is empty, load all products
  //     console.log("Search cleared, loading all products");
  //     $.ajax({
  //       url: site_url + "products/ajax_products",
  //       type: "POST",
  //       data: {
  //         type: "all",
  //       },
  //       dataType: "json",
  //       success: function (response) {
  //         console.log("All products loaded after search clear");
  //         if (response.success) {
  //           $("#ajax-products-container").html(response.html);
  //         } else {
  //           // alert("Failed to load products: " + response.message);
  //         }
  //         $("#ajax-loader").hide();
  //       },
  //       error: function (xhr, status, error) {
  //         console.log("Error loading all products:", status, error);
  //         // alert("Error loading products: " + error);
  //         $("#ajax-loader").hide();
  //       },
  //     });
  //   } else {
  //     // Perform search with the term
  //     $.ajax({
  //       url: site_url + "products/ajax_filter_products",
  //       type: "POST",
  //       data: {
  //         search: searchTerm,
  //       },
  //       success: function (response) {
  //         console.log("Search completed for:", searchTerm);
  //         $("#ajax-products-container").html(response);
  //         $("#ajax-loader").hide();
  //       },
  //       error: function (xhr, status, error) {
  //         console.log("Search error:", status, error);
  //         console.log("Response:", xhr.responseText);
  //         // alert("Search error: " + error);
  //         $("#ajax-loader").hide();
  //       },
  //     });
  //   }
  // }
