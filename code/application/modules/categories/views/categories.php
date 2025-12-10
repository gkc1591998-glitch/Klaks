<div class="main-container shop-page left-sidebar">
  <div class="section-001">
    <div class="container">
      <div class="row">
        <?php if(!empty($categories)): ?>
          <?php foreach($categories as $category): ?>
            <div class="col-md-4 col-6 my-3">
              <div class="akasha-banner style-03 left-center">
                <a href="<?php echo site_url('products/'.$category['slug']); ?>">
                  <div class="banner-inner">
                    <figure class="banner-thumb">
                      <?php 
                        $image_path = !empty($category['image']) ? $category['image'] : 'default-category.jpg';
                      ?>
                      <img src="<?php echo site_url('images/category/'.$image_path); ?>" class="attachment-full size-full" alt="<?php echo $category['name']; ?>">
                    </figure>
                    <div class="banner-info">
                      <div class="banner-content">
                        <div class="cate">
                          <?php echo $category['name']; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-12">
            <div class="alert alert-info">
              No categories found.
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>