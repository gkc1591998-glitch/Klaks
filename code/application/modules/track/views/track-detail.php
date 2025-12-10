<!--container-->

  
  <div class="page-heading">
  
  <div class="page-title">
    <h2>blog-detail</h2>
  </div>
</div>

<div class="main-container col2-right-layout">
         <div class="main container"> 
          <div class="row">                          
 <div class="col-left sidebar col-sm-3 blog-side">
        <div id="secondary" class="widget_wrapper13" role="complementary">
          <div id="recent-posts-4" class="popular-posts widget widget__sidebar wow bounceInUp animated animated animated" style="visibility: visible;">
            <h2 class="widget-title">Most Popular Posts</h2>
            <div class="widget-content">
              

              <ul class="posts-list unstyled clearfix">
                <?php if(count($datas) > 0){
                   foreach ($datas as $value){ ?>
                <li>
                   <figure class="featured-thumb"> <a href="#"> <img src="<?php echo site_url();?>images/blog/<?php echo (stripslashes(str_replace('\n','',$value['image']))); ?>" alt="blog image"> </a> </figure>
                  <!--featured-thumb-->
                  <div class="content-info">
                    <h4><a href="#" title="Lorem ipsum dolor sit amet"><?php echo (stripslashes(str_replace('\n','',$value['title']))); ?></a></h4>
                    <p class="post-meta"><i class="icon-calendar"></i>
                      <time class="entry-date" datetime="2015-05-11T11:07:27+00:00"><?php echo date("F jS, Y", strtotime($value['create_date_time']));?></time>
                      .</p>
                  </div>
                </li>
                <?php } } ?>
              </ul>

            </div>
            <!--widget-content--> 
          </div>
          <div id="categories-2" class="widget widget_categories wow bounceInUp animated animated animated" style="visibility: visible;">
            <h2 class="widget-title">Categories</h2>
            <div class="content">
             <ul>
            <?php if(count($cat) > 0){
                   foreach ($cat as $value){ ?>
           
              <li class="cat-item cat-item-19599"><a href="<?php echo site_url();?>products/prouct_by_category/<?php echo $value['id'];?>"><?php echo (stripcslashes(str_replace('\n','',$value['name']))); ?></a></li>
              <?php } } ?>

            </ul>
          
            </div>
          </div>
          <!-- Banner Ad Block -->

     
        </div>
      </div>                           
<div class="col-main col-sm-9 wow bounceInUp animated animated animated" style="visibility: visible;">
    <!--<div class="page-title"><h2></h2></div>-->
<div id="main" class="blog-wrapper">
    
  <div id="primary" class="site-content">
    <div id="content" role="main">
              <article id="post-29" class="blog_entry clearfix">
          <header class="blog_entry-header clearfix">
              <div class="blog_entry-header-inner">
                <h2 class="blog_entry-title">
                  <?php echo (stripslashes(str_replace('\n','',$record['title']))); ?>           
                </h2>
              </div> <!--blog_entry-header-inner-->
          </header> <!--blog_entry-header clearfix-->
          <div class="entry-content">
            
            <div class="featured-thumb"><a href="#"><img src="<?php echo site_url();?>images/blog/<?php echo (stripslashes(str_replace('\n','',$record['image']))); ?>" alt="blog image"></a>
            </div>
            <br>
            <div class="entry-content">
            <p><?php echo (stripcslashes(str_replace('\n','',$record['content']))); ?></p>
            </div>          

          </div>
          
        </article>
              
    </div>
  </div>

</div> <!--#main wrapper grid_8-->

        

  </div> <!--col-main col-sm-9-->
            </div>    
         </div><!--main-container-->

        </div>






<div class="our-features-box wow bounceInUp animated animated category">
    <div class="container">
      <ul>
        <li>
          <div class="feature-box free-shipping">
            <div class="icon-truck"></div>
            <div class="content" style="font-size: 14px;">100 % Quality ,Service & Convenience.</div>
          </div>
        </li>
        <li>
          <div class="feature-box need-help">
            <div class="icon-support"></div>
            <div class="content">Need Help Call us :  +91 9872469999</div>
          </div>
        </li>
        <li>
          <div class="feature-box money-back">
            <div class="icon-money"></div>
            <div class="content">Large Variety of Categories</div>
          </div>
        </li>
        <li class="last">
          <div class="feature-box return-policy">
            <div class="icon-return"></div>
            <div class="content">Best Prices & Offers</div>
          </div>
        </li>
      </ul>
    </div>
  </div>