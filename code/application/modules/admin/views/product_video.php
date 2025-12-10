<?php $this->load->view('admin_header'); ?>

<div class="main-content">
  <div class="main-content-inner">
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
      <ul class="breadcrumb">
        <li>
          <i class="ace-icon fa fa-home home-icon"></i>
          <a href="<?php echo base_url('admin/dashboard'); ?>">Home</a>
        </li>
        <li>
          <a href="<?php echo base_url('admin/products'); ?>">Products</a>
        </li>
        <li class="active">Product Video</li>
      </ul>
    </div>

    <div class="page-content">
      <div class="row">
        <div class="col-xs-12">
          <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
          <?php } elseif ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
          <?php } ?>

          <div class="widget-box">
            <div class="widget-header">
              <h4 class="widget-title">Product Video Management</h4>
            </div>

            <div class="widget-body">
              <div class="widget-main">
                <?php echo form_open_multipart('admin/products/upload_video/' . $product_id, array('class' => 'form-horizontal')); ?>

                <?php if (!empty($product_video)) { ?>
                  <div class="form-group">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                      <video width="320" height="240" controls>
                        <source src="<?php echo base_url('videos/products/' . $product_video); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                      </video>
                    </div>
                    <div class="col-sm-3"></div>
                  </div>
                <?php } ?>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Product Video</label>
                  <div class="col-sm-9">
                    <input type="file" name="product_video" accept="video/mp4,video/x-m4v,video/avi,video/x-msvideo,video/quicktime,video/x-ms-wmv,video/x-flv,video/webm,video/x-matroska,video/*" class="form-control">
                    <small class="text-muted">Supported formats: MP4, AVI, MOV, WMV, FLV, WEBM, MKV, maximum size: 5MB</small>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary">Upload Video</button>
                    <?php if (!empty($product_video)) { ?>
                      <a href="<?php echo base_url('admin/products/delete_video/' . $product_id); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this video?');">Delete Video</a>
                    <?php } ?>
                    <a href="<?php echo base_url('admin/products'); ?>" class="btn btn-default">Back to Products</a>
                  </div>
                </div>
                <?php echo form_close(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>