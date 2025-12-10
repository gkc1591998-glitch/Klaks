
<?php if($products){ foreach($products as $key => $value){ ?>
    <li class="product-item wow fadeInUp product-item rows-space-30 col-bg-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-ts-6 style-01 post-24 product type-product status-publish has-post-thumbnail product_cat-chair product_cat-table product_cat-new-arrivals product_tag-light product_tag-hat product_tag-sock first instock featured shipping-taxable purchasable product-type-variable has-default-attributes" data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp">
        <div class="product-inner tooltip-right">
            <div class="product-thumb">
                <a class="thumb-link" href="<?php echo site_url();?>products/product_view/<?php echo stripslashes(str_replace('\n','',$value['id']))?>" tabindex="0">
                    <img class="img-responsive" src="<?php echo site_url();?>images/products/<?php echo stripslashes(str_replace('\n','',$value['image1']))?>" alt="<?php echo stripslashes(str_replace('\n','',$value['title']))?>" width="270" height="350">
                </a>
                <div class="flash">
                    <span class="onnew"><span class="text">New</span></span></div>
                </div>
                <div class="product-info equal-elem">
                    <h3 class="product-name product_title">
                    <a href="<?php echo site_url();?>products/product_view/<?php echo stripslashes(str_replace('\n','',$value['id']))?>"><?php echo stripslashes(str_replace('\n','',$value['title']))?></a>
                    </h3>
                    <div class="rating-wapper nostar">
                    <span style="width:0%"><a href="#" tabindex="0">XS </a></span><span style="width:0%"><a href="#">S </a></span><span style="width:0%"><a href="#">M </a> </span><span style="width:0%"><a href="#">L </a> </span><span style="width:0%"><a href="#">XL </a> </span><span style="width:0%"><a href="#">2XL </a> </span><span style="width:0%"><a href="#">3XL </a> </span>
                    </div>
                    <span class="price">
                        <span class="akasha-Price-amount amount">
                            INR
                            <span class="akasha-Price-currencySymbol" style="padding-left: 10px;">₹ <?php echo stripslashes(str_replace('\n','',$value['price_range']))?></span>
                        </span>
                    </span>
                </div>
            </div>
        </li>
<?php }} else { ?>
    <div align="center" style="color: red; padding: 200px;"> <h1>No records found </h1></div>
<?php } ?>
