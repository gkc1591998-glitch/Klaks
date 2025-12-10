<div class="main-container no-sidebar">
    <!-- POST LAYOUT -->
    <div class="container">
		<div class="akasha-heading style-01">
                <div class="heading-inner">
                    <h3 class="title">
                    <?php echo (stripslashes(str_replace('\n','',$datas['name']))); ?></h3>
                </div>
        </div>
        <div class="row">
            <div class="main-content col-md-12 col-sm-12">
                <div class="blog-standard content-post">
                <?php echo (stripcslashes(str_replace('\n','',$datas['content']))); ?>
            </div>
        </div>
    </div>
</div>