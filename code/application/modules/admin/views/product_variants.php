<?php
// Load color helper for better color management
if (!function_exists('get_best_color_match')) {
    $this->load->helper('color');
}
?>
<div class="main-content">
  <div class="main-content-inner">
    <!-- #section:sizes/content.breadcrumbs -->
    <div class="breadcrumbs" id="breadcrumbs">
      <ul class="breadcrumb">
        <li>
          <i class="ace-icon fa fa-home home-icon"></i>
          <a href="<?php echo ADMIN_URL; ?>Home">Home</a>
        </li>
        <li>
          <a href="<?php echo ADMIN_URL; ?>Products/variants">Variants</a>
        </li>
        <li class="active">Main Page</li>
      </ul>
    </div>
    <!-- /section:sizes/content.breadcrumbs -->
    <div class="page-content">
      <div class="row">
        <div class="col-xs-12">
          <!-- <h3 class="header smaller lighter blue"><?php echo isset($variant) ? 'Edit Variant' : 'Variants'; ?></h3> -->
          <!-- Add/Edit Size Form -->
          <div class="widget-box">
            <div class="widget-header">
              <h4 class="widget-title"><?php echo isset($variant) ? 'Edit Variant' : 'Add Variant'; ?></h4>
            </div>
            <div class="widget-body">
              <div class="widget-main">
                <?php if (isset($size)) {
                  $action = site_url('admin/sizes/edit/' . $size->id);
                  $btn = 'Update';
                } else {
                  $action = site_url('admin/sizes/create');
                  $btn = 'Add';
                } ?>
                <form method="post" action="<?php echo base_url('admin/products/save_variant'); ?>" class="form-horizontal" enctype="multipart/form-data">
                  <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                  <input type="hidden" name="variant_id" value="<?php echo isset($variant) ? $variant['id'] : ''; ?>">

                  <!-- Color Selection -->
                  <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Color</label>
                    <div class="col-sm-9">
                      <select name="color_id" class="col-xs-10 col-sm-8 chosen-select" required>
                        <option value="">Select Color</option>
                        <?php if (isset($colors) && !empty($colors)): foreach ($colors as $color): ?>
                            <option value="<?php echo $color->id; ?>"
                              data-color="<?php echo isset($color->color_code) ? $color->color_code : $color->name; ?>"
                              <?php echo isset($variant) && $variant['color_id'] == $color->id ? 'selected' : ''; ?>>
                              <?php echo $color->name; ?>
                            </option>
                        <?php endforeach;
                        endif; ?>
                      </select>
                    </div>
                  </div>

                  <!-- Image Upload -->
                  <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Images</label>
                    <div class="col-sm-9">
                      <div class="image-upload-container col-xs-10 col-sm-8">
                        <input type="file" name="variant_images[]" multiple accept="image/*" class="file-input">
                        <div class="help-block">Drag images here or click to upload</div>
                        <div class="image-preview" id="imagePreview">
                          <?php if (isset($variant_images)): foreach ($variant_images as $img): ?>
                              <div class="image-item" id="image-<?php echo $img['id']; ?>">
                                <img src="<?php echo base_url('images/products/' . $img['image']); ?>" class="thumb" style="width:200px;height:200px;object-fit:cover;">
                                <span class="delete-image" data-id="<?php echo $img['id']; ?>" title="Delete Image"><i class="fa fa-trash" style="color:#d9534f;font-size:22px;cursor:pointer;"></i></span>
                              </div>
                          <?php endforeach;
                          endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Size and Price Matrix -->
                  <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Sizes</label>
                    <div class="col-sm-9">
                      <div class="size-price-container col-xs-10 col-sm-8">
                        <div class="row size-price-row">
                          <div class="col-sm-5">
                            <select name="size_id" class="form-control chosen-select" id="sizeSelect">
                              <option value="">Select Size</option>
                              <?php if (isset($sizes) && !empty($sizes)): foreach ($sizes as $size): ?>
                                  <option value="<?php echo $size->id; ?>"><?php echo $size->name; ?></option>
                              <?php endforeach;
                              endif; ?>
                            </select>
                          </div>
                          <div class="col-sm-5">
                            <select name="price_id" class="form-control chosen-select" id="priceSelect">
                              <option value="">Select Price</option>
                              <?php if (isset($prices) && !empty($prices)): foreach ($prices as $price): ?>
                                  <option value="<?php echo $price->id; ?>"
                                    data-price="<?php echo $price->name; ?>">
                                    ₹<?php echo number_format($price->name); ?>
                                  </option>
                              <?php endforeach;
                              endif; ?>
                            </select>
                          </div>
                          <div class="col-sm-2">
                            <button type="button" class="btn btn-sm btn-primary" id="addSizePrice">
                              <i class="ace-icon fa fa-plus"></i>
                            </button>
                          </div>
                        </div>

                        <div class="table-responsive" style="margin-top: 15px;">
                          <table class="table table-bordered table-striped" id="selectedSizesTable">
                            <thead>
                              <tr>
                                <th>Size</th>
                                <th>Price</th>
                                <th width="80">Status</th>
                                <th width="50">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php if (isset($variant_sizes) && !empty($variant_sizes)):
                                foreach ($variant_sizes as $size_id => $size_data):
                                  if ($size_data['price_id']): ?>
                                    <tr data-size-id="<?php echo $size_id; ?>">
                                      <td>
                                        <?php
                                        foreach ($sizes as $s) {
                                          if ($s->id == $size_id) {
                                            echo $s->name;
                                            break;
                                          }
                                        }
                                        ?>
                                        <input type="hidden" name="size_ids[]" value="<?php echo $size_id; ?>">
                                      </td>
                                      <td>
                                        <select name="price_ids[<?php echo $size_id; ?>]" class="form-control input-sm">
                                          <?php foreach ($prices as $price): ?>
                                            <option value="<?php echo $price->id; ?>"
                                              <?php echo $size_data['price_id'] == $price->id ? 'selected' : ''; ?>>
                                              ₹<?php echo number_format($price->name); ?>
                                            </option>
                                          <?php endforeach; ?>
                                        </select>
                                      </td>
                                      <td class="center">
                                        <label>
                                          <input type="checkbox" name="size_status[<?php echo $size_id; ?>]" value="1" class="ace"
                                            <?php echo $size_data['status'] == 1 ? 'checked' : ''; ?>>
                                          <span class="lbl"></span>
                                        </label>
                                      </td>
                                      <td>
                                        <button type="button" class="btn btn-xs btn-danger remove-size">
                                          <i class="ace-icon fa fa-trash-o"></i>
                                        </button>
                                      </td>
                                    </tr>
                              <?php endif;
                                endforeach;
                              endif; ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Tags Input -->
                  <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Tags</label>
                    <div class="col-sm-9">
                      <input type="text" name="tags" class="col-xs-10 col-sm-8 tag-input"
                        value="<?php echo isset($variant) ? $variant['tags'] : ''; ?>"
                        placeholder="Add tags">
                      <span class="help-block">&nbsp;Separate tags with commas</span>
                    </div>
                  </div>

                  <!-- Display Options -->
                  <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Show in Lux</label>
                    <div class="col-sm-9">
                      <label class="col-xs-10 col-sm-8">
                        <input type="checkbox" name="show_in_lux" value="1" class="ace"
                          <?php echo isset($variant) && $variant['show_in_lux'] == 1 ? 'checked' : ''; ?>>
                        <span class="lbl"> Display in Lux section</span>
                      </label>
                    </div>
                  </div>

                  <!-- Display Sections -->
                  <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Display Sections</label>
                    <div class="col-sm-9">
                      <div class="col-xs-10 col-sm-8">
                        <?php if (isset($sections) && !empty($sections)): foreach ($sections as $section): ?>
                            <label class="checkbox-inline">
                              <input type="checkbox" name="sections[]" value="<?php echo $section->id; ?>" class="ace"
                                <?php echo isset($variant_sections) && in_array($section->id, $variant_sections) ? 'checked' : ''; ?>>
                              <span class="lbl"> <?php echo $section->name; ?></span>
                            </label>
                        <?php endforeach;
                        endif; ?>
                      </div>
                    </div>
                  </div>

                  <!-- Form Actions -->
                  <div class="form-actions">
                    <div class="col-sm-offset-3 col-sm-9">
                      <button type="submit" class="btn btn-success">
                        <i class="ace-icon fa fa-check"></i> <?php echo isset($variant) ? 'Update Changes' : 'Add Changes'; ?>
                      </button>
                      <button type="button" class="btn" onclick="window.history.back();">
                        <i class="ace-icon fa fa-undo"></i> Cancel
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="space-10"></div>
          <form method="post" action="<?php echo ADMIN_URL; ?>sizes/delete_selected">
            <!-- <div class="clearfix">
                        <div class="pull-left tableTools-container"></div>
                        <div class="pull-right">
                            <button class="btn btn-danger" type="submit" onClick="return delete_selected_fields();" name="submit" value="submit">
                                <i class="ace-icon fa  fa-trash-o align-top bigger-125"></i>
                                Delete All
                            </button>
                        </div>
                    </div> -->
            <script type="text/javascript">
              function delete_selected_fields() {
                var checked_num = $('input[name=\"selected_ids[]\"]:checked').length;
                if (checked_num == 0) {
                  alert('Minimum One Check Box Must be Selected... ');
                  return false;
                } else if (checked_num > 0) {
                  if (confirm('Delete all selected?') == true) {
                    return true;
                  } else {
                    return false;
                  }
                }
              }
            </script>
            <?php if ($this->session->flashdata('msg_succ') != '') { ?>
              <div class="alert alert-block alert-success">
                <button type="button" class="close" data-dismiss="alert">
                  <i class="ace-icon fa fa-times"></i>
                </button>
                <p>
                  <?php echo $this->session->flashdata('msg_succ') ? $this->session->flashdata('msg_succ') : ''; ?>
                </p>
              </div>
            <?php } ?>
            <div class="table-header">&nbsp;</div>
            <div>
              <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th class="center" width="40">
                      <label class="pos-rel">
                        <input type="checkbox" class="ace" />
                        <span class="lbl"></span>
                      </label>
                    </th>
                    <!-- <th width="60">ID</th> -->
                    <th width="100">Image</th>
                    <th width="120">Color</th>
                    <th width="150">Price</th>
                    <th width="100">Tags</th>
                    <th>Sections</th>
                    <th width="80">In Lux</th>
                    <th width="80">Status</th>
                    <th width="120">Created</th>
                    <th width="120">Updated</th>
                    <th width="100">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (!empty($variants)) {
                    foreach ($variants as $variant) { ?>
                      <tr>
                        <td class="center">
                          <label class="pos-rel">
                            <input type="checkbox" name="selected_ids[]" value="<?php echo $variant['id']; ?>" class="ace" />
                            <span class="lbl"></span>
                          </label>
                        </td>
                        <!-- <td><?php echo $variant['id']; ?></td> -->
                        <td>
                          <?php if (!empty($variant['images'])): ?>
                            <img src="<?php echo base_url('images/products/' . $variant['images'][0]); ?>" width="50" height="50" class="img-thumbnail">
                          <?php endif; ?>
                        </td>
                        <td>
                          <?php 
                          // Use enhanced color matching from helper
                          $colorMatch = get_best_color_match($variant['color_name']);
                          $cssColor = $colorMatch['css_color'];
                          $displayName = $colorMatch['display_name'];
                          ?>
                          <span class="color-box" style="background-color: <?php echo htmlspecialchars($cssColor); ?>"></span>
                          <?php echo $displayName; ?>
                        </td>
                        <td>
                          <div class="size-price-matrix">
                            <?php
                            if (!empty($variant['sizes'])):
                              foreach ($variant['sizes'] as $size):
                                if ($size['price_id']): ?>
                                  <div class="size-price-row">
                                    <?php
                                    // Get size name
                                    foreach ($sizes as $s) {
                                      if ($s->id == $size['size_id']) {
                                        echo "<strong>" . $s->name . ":</strong> ";
                                        break;
                                      }
                                    }
                                    // Get price
                                    foreach ($prices as $p) {
                                      if ($p->id == $size['price_id']) {
                                        echo '₹' . number_format($p->name);
                                        break;
                                      }
                                    }
                                    ?>
                                    <?php if ($size['status']): ?>
                                      <span class="label label-success">✓</span>
                                    <?php endif; ?>
                                  </div>
                            <?php endif;
                              endforeach;
                            endif;
                            ?>
                          </div>
                        </td>
                        <td>
                          <?php if (!empty($variant['tags'])): ?>
                            <?php
                            $tags = explode(',', trim($variant['tags']));
                            foreach ($tags as $tag):
                              if (trim($tag) != ''): ?>
                                <span class="label label-info"><?php echo trim($tag); ?></span>
                          <?php endif;
                            endforeach;
                          endif; ?>
                        </td>
                        <td>
                          <?php if (!empty($variant['sections'])): foreach ($variant['sections'] as $section): ?>
                              <span class="label label-purple"><?php echo $section['name']; ?></span>
                          <?php endforeach;
                          endif; ?>
                        </td>
                        <td class="center">
                          <span class="label label-<?php echo $variant['show_in_lux'] ? 'success' : 'default'; ?>">
                            <?php echo $variant['show_in_lux'] ? 'Yes' : 'No'; ?>
                          </span>
                        </td>
                        <td>
                          <span class="label label-<?php echo $variant['status'] ? 'success' : 'danger'; ?>">
                            <?php echo $variant['status'] ? 'Active' : 'Inactive'; ?>
                          </span>
                        </td>
                        <td><?php echo date('Y-m-d H:i', strtotime($variant['created_date_time'])); ?></td>
                        <td><?php echo date('Y-m-d H:i', strtotime($variant['updated_date_time'])); ?></td>
                        <td>
                          <div class="hidden-sm hidden-xs action-buttons">
                            <!-- <a class="blue" href="<?php echo base_url('admin/products/variants/' . $product_id . '?action=view&id=' . $variant['id']); ?>" data-toggle="tooltip" title="View">
                                                      <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                                  </a> -->
                            <a class="green" href="<?php echo base_url('admin/products/variants/' . $product_id . '?action=edit&id=' . $variant['id']); ?>" data-toggle="tooltip" title="Edit">
                              <i class="ace-icon fa fa-pencil bigger-130"></i>
                            </a>
                            <a class="red" href="javascript:void(0);" onclick="deleteVariant(<?php echo $variant['id']; ?>)" data-toggle="tooltip" title="Delete">
                              <i class="ace-icon fa fa-trash-o bigger-130"></i>
                            </a>
                          </div>
                          <div class="hidden-md hidden-lg">
                            <div class="inline pos-rel">
                              <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                              </button>
                              <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                <!-- <li>
                                                              <a href="<?php echo base_url('admin/products/variants/' . $product_id . '?action=view&id=' . $variant['id']); ?>" class="tooltip-info" data-rel="tooltip" title="View">
                                                                  <span class="blue">
                                                                      <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                                  </span>
                                                              </a>
                                                          </li> -->
                                <li>
                                  <a href="<?php echo base_url('admin/products/variants/' . $product_id . '?action=edit&id=' . $variant['id']); ?>" class="tooltip-success" data-rel="tooltip" title="Edit">
                                    <span class="green">
                                      <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                    </span>
                                  </a>
                                </li>
                                <li>
                                  <a href="javascript:void(0);" onclick="deleteVariant(<?php echo $variant['id']; ?>)" class="tooltip-error" data-rel="tooltip" title="Delete">
                                    <span class="red">
                                      <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                    </span>
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </td>
                      </tr>
                  <?php }
                  } ?>
                </tbody>
              </table>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo  $this->load->view('footer_copywrite_div'); ?>
<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
  <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
</a>

<!-- category scripts -->

<!--[if !IE]> -->
<script type="text/javascript">
  window.jQuery || document.write("<script src='<?php echo site_url(); ?>assets/js/jquery.js'>" + "<" + "/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='<?php echo site_url(); ?>assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->
<style type="text/css">
  .size-price-matrix {
    max-height: 150px;
    overflow-y: auto;
  }

  .size-price-row {
    padding: 3px 0;
    border-bottom: 1px solid #eee;
  }

  .size-price-row:last-child {
    border-bottom: none;
  }

  .size-price-row .label {
    margin-left: 5px;
  }

  .color-box {
    display: inline-block;
    width: 15px;
    height: 15px;
    margin-right: 5px;
    border: 1px solid #ccc;
    vertical-align: middle;
  }
  /* Image preview styles */
  .image-preview {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 10px;
  }
  .image-item {
    position: relative;
    width: 200px !important;
    height: 200px !important;
    flex: 0 0 200px !important;
    border: 1px solid #eee;
    border-radius: 6px;
    overflow: hidden;
    background: #fafafa;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
  }
  .image-item img.thumb {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    display: block !important;
  }
  /* Delete control */
  .image-item .delete-image,
  .image-item button.delete-image {
    position: absolute !important;
    top: 8px !important;
    right: 8px !important;
    background: rgba(255,255,255,0.95) !important;
    border-radius: 50% !important;
    padding: 6px !important;
    cursor: pointer !important;
    z-index: 5 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 6px !important;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12) !important;
  }
  .image-item .delete-image i,
  .image-item .delete-image span {
    pointer-events: none;
  }
  .image-item .delete-image:hover {
    background: #f2dede !important;
  }
</style>
<script type="text/javascript">
  if ('ontouchstart' in document.documentElement) document.write("<script src='<?php echo site_url(); ?>assets/js/jquery.mobile.custom.js'>" + "<" + "/script>");
</script>
<script src="<?php echo site_url(); ?>assets/js/bootstrap.js"></script>

<!-- page specific plugin scripts -->
<script src="<?php echo site_url(); ?>assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo site_url(); ?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="<?php echo site_url(); ?>assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
<script src="<?php echo site_url(); ?>assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
<!-- ace scripts -->
<script src="<?php echo site_url(); ?>assets/js/ace/elements.scroller.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/elements.colorpicker.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/elements.fileinput.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/elements.typeahead.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/elements.wysiwyg.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/elements.spinner.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/elements.treeview.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/elements.wizard.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/elements.aside.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/ace.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/ace.ajax-content.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/ace.touch-drag.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/ace.sidebar.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/ace.sidebar-scroll-1.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/ace.submenu-hover.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/ace.widget-box.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/ace.settings.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/ace.settings-rtl.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/ace.settings-skin.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/ace.widget-on-reload.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/ace.searchbox-autocomplete.js"></script>
<script src="<?php echo site_url(); ?>assets/js/variants.js"></script>
<script type="text/javascript">
  var baseUrl = '<?php echo base_url(); ?>';
  
  jQuery(function($) {
    // Initialize chosen select
    if($.fn.chosen) {
      $('.chosen-select').chosen({
        width: '100%'
      });
    }
    
    // Handle adding size and price
    $(document).on('click', '#addSizePrice', function(e) {
      e.preventDefault();
      console.log('Add button clicked'); // Debug log
      
      var sizeId = $('#sizeSelect').val();
      var sizeName = $('#sizeSelect option:selected').text();
      var priceId = $('#priceSelect').val();
      var priceText = $('#priceSelect option:selected').text();

      console.log('Selected size:', sizeId, sizeName); // Debug log
      console.log('Selected price:', priceId, priceText); // Debug log

      if (!sizeId || !priceId) {
        alert('Please select both size and price');
        return;
      }

      // Check if size already exists
      if ($('#selectedSizesTable tbody tr[data-size-id="' + sizeId + '"]').length > 0) {
        alert('This size is already added');
        return;
      }

      // Create new row element
      var newRow = $('<tr>').attr('data-size-id', sizeId)
        .append($('<td>')
          .append(sizeName)
          .append($('<input>').attr({
            type: 'hidden',
            name: 'size_ids[]',
            value: sizeId
          }))
        )
        .append($('<td>')
          .append($('<select>')
            .attr({
              name: 'price_ids[' + sizeId + ']',
              class: 'form-control input-sm'
            })
            .html($('#priceSelect').html())
          )
        )
        .append($('<td>').addClass('center')
          .append($('<label>')
            .append($('<input>').attr({
              type: 'checkbox',
              name: 'size_status[' + sizeId + ']',
              value: '1',
              class: 'ace'
            }).prop('checked', true))
            .append($('<span>').addClass('lbl'))
          )
        )
        .append($('<td>')
          .append($('<button>').attr({
            type: 'button',
            class: 'btn btn-xs btn-danger remove-size'
          }).append($('<i>').addClass('ace-icon fa fa-trash-o')))
        );

      // Append the new row and set the selected price
      $('#selectedSizesTable tbody').append(newRow);
      $('select[name="price_ids[' + sizeId + ']"]').val(priceId);

      // Reset selects
      $('#sizeSelect').val('').trigger('chosen:updated');
      $('#priceSelect').val('').trigger('chosen:updated');
      
      console.log('Row added successfully'); // Debug log
    });

    // Handle removing size
    $(document).on('click', '.remove-size', function() {
      $(this).closest('tr').remove();
    });
  });
</script>
<!-- inline scripts related to this page -->
<script type="text/javascript">
  jQuery(function($) {
    //initiate dataTables plugin
    var oTable1 =
      $('#dynamic-table')
      //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
      .dataTable({
        bAutoWidth: false,
        "aoColumns": [{
            "bSortable": false
          },
          null, null, null, null, null,
          {
            "bSortable": false
          }
        ],
        "aaSorting": [],
        //,
        //"sScrollY": "200px",
        //"bPaginate": false,
        //"sScrollX": "100%",
        //"sScrollXInner": "120%",
        //"bScrollCollapse": true,
        //Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
        //you may want to wrap the table inside a "div.dataTables_borderWrap" element
        //"iDisplayLength": 50
      });
    //oTable1.fnAdjustColumnSizing();
    //TableTools settings
    TableTools.classes.container = "btn-group btn-overlap";
    TableTools.classes.print = {
      "body": "DTTT_Print",
      "info": "tableTools-alert gritter-item-wrapper gritter-info gritter-center white",
      "message": "tableTools-print-navbar"
    }
    //initiate TableTools extension
    var tableTools_obj = new $.fn.dataTable.TableTools(oTable1, {
      "sSwfPath": "<?php echo site_url(); ?>assets/js/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf", //in Ace demo <?php echo site_url(); ?>assets will be replaced by correct assets path
      "sRowSelector": "td:not(:last-child)",
      "sRowSelect": "multi",
      "fnRowSelected": function(row) {
        //check checkbox when row is selected
        try {
          $(row).find('input[type=checkbox]').get(0).checked = true
        } catch (e) {}
      },
      "fnRowDeselected": function(row) {
        //uncheck checkbox
        try {
          $(row).find('input[type=checkbox]').get(0).checked = false
        } catch (e) {}
      },
      "sSelectedClass": "success",
      "aButtons": [{
          "sExtends": "copy",
          "sToolTip": "Copy to clipboard",
          "sButtonClass": "btn btn-white btn-primary btn-bold",
          "sButtonText": "<i class='fa fa-copy bigger-110 pink'></i>",
          "fnComplete": function() {
            this.fnInfo('<h3 class="no-margin-top smaller">Table copied</h3>\
									<p>Copied ' + (oTable1.fnSettings().fnRecordsTotal()) + ' row(s) to the clipboard.</p>',
              1500
            );
          }
        },
        {
          "sExtends": "csv",
          "sToolTip": "Export to CSV",
          "sButtonClass": "btn btn-white btn-primary  btn-bold",
          "sButtonText": "<i class='fa fa-file-excel-o bigger-110 green'></i>"
        },
        {
          "sExtends": "pdf",
          "sToolTip": "Export to PDF",
          "sButtonClass": "btn btn-white btn-primary  btn-bold",
          "sButtonText": "<i class='fa fa-file-pdf-o bigger-110 red'></i>"
        },

        {
          "sExtends": "print",
          "sToolTip": "Print view",
          "sButtonClass": "btn btn-white btn-primary  btn-bold",
          "sButtonText": "<i class='fa fa-print bigger-110 grey'></i>",
          "sMessage": "<div class='navbar navbar-default'><div class='navbar-header pull-left'><a class='navbar-brand' href='#'><small>Optional Navbar &amp; Text</small></a></div></div>",
          "sInfo": "<h3 class='no-margin-top'>Print view</h3>\
									  <p>Please use your browser's print function to\
									  print this table.\
									  <br />Press <b>escape</b> when finished.</p>",
        }
      ]
    });
    //we put a container before our table and append TableTools element to it
    $(tableTools_obj.fnContainer()).appendTo($('.tableTools-container'));
    //also add tooltips to table tools buttons
    //addding tooltips directly to "A" buttons results in buttons disappearing (weired! don't know why!)
    //so we add tooltips to the "DIV" child after it becomes inserted
    //flash objects inside table tools buttons are inserted with some delay (100ms) (for some reason)
    setTimeout(function() {
      $(tableTools_obj.fnContainer()).find('a.DTTT_button').each(function() {
        var div = $(this).find('> div');
        if (div.length > 0) div.tooltip({
          container: 'body'
        });
        else $(this).tooltip({
          container: 'body'
        });
      });
    }, 200);

    //ColVis extension
    var colvis = new $.fn.dataTable.ColVis(oTable1, {
      "buttonText": "<i class='fa fa-search'></i>",
      "aiExclude": [0, 6],
      "bShowAll": true,
      //"bRestore": true,
      "sAlign": "right",
      "fnLabel": function(i, title, th) {
        return $(th).text(); //remove icons, etc
      }
    });

    //style it
    $(colvis.button()).addClass('btn-group').find('button').addClass('btn btn-white btn-info btn-bold')

    //and append it to our table tools btn-group, also add tooltip
    $(colvis.button())
      .prependTo('.tableTools-container .btn-group')
      .attr('title', 'Show/hide columns').tooltip({
        container: 'body'
      });

    //and make the list, buttons and checkboxed Ace-like
    $(colvis.dom.collection)
      .addClass('dropdown-menu dropdown-light dropdown-caret dropdown-caret-right')
      .find('li').wrapInner('<a href="javascript:void(0)" />') //'A' tag is required for better styling
      .find('input[type=checkbox]').addClass('ace').next().addClass('lbl padding-8');

    //table checkboxes
    $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

    //select/deselect all rows according to table header checkbox
    $('#dynamic-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function() {
      var th_checked = this.checked; //checkbox inside "TH" table header

      $(this).closest('table').find('tbody > tr').each(function() {
        var row = this;
        if (th_checked) tableTools_obj.fnSelect(row);
        else tableTools_obj.fnDeselect(row);
      });
    });
    //select/deselect a row when the checkbox is checked/unchecked
    $('#dynamic-table').on('click', 'td input[type=checkbox]', function() {
      var row = $(this).closest('tr').get(0);
      if (!this.checked) tableTools_obj.fnSelect(row);
      else tableTools_obj.fnDeselect($(this).closest('tr').get(0));
    });

    $(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
      e.stopImmediatePropagation();
      e.stopPropagation();
      e.preventDefault();
    });

    //And for the first simple table, which doesn't have TableTools or dataTables
    //select/deselect all rows according to table header checkbox
    var active_class = 'active';
    $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function() {
      var th_checked = this.checked; //checkbox inside "TH" table header

      $(this).closest('table').find('tbody > tr').each(function() {
        var row = this;
        if (th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
        else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
      });
    });
    //select/deselect a row when the checkbox is checked/unchecked
    $('#simple-table').on('click', 'td input[type=checkbox]', function() {
      var $row = $(this).closest('tr');
      if (this.checked) $row.addClass(active_class);
      else $row.removeClass(active_class);
    });

    /********************************/
    //add tooltip for small view action buttons in dropdown menu
    $('[data-rel="tooltip"]').tooltip({
      placement: tooltip_placement
    });
    //tooltip placement on right or left
    function tooltip_placement(context, source) {
      var $source = $(source);
      var $parent = $source.closest('table')
      var off1 = $parent.offset();
      var w1 = $parent.width();
      var off2 = $source.offset();
      //var w2 = $source.width();
      if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2)) return 'right';
      return 'left';
    }

  })
</script>

<!-- the following scripts are used in demo only for onpage help and you don't need them -->
<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/ace.onpage-help.css" />
<link rel="stylesheet" href="<?php echo site_url(); ?>docs/assets/js/themes/sunburst.css" />

<script type="text/javascript">
  ace.vars['base'] = '..';
</script>
<script src="<?php echo site_url(); ?>assets/js/ace/elements.onpage-help.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/ace.onpage-help.js"></script>
<script src="<?php echo site_url(); ?>docs/assets/js/rainbow.js"></script>
<script src="<?php echo site_url(); ?>docs/assets/js/language/generic.js"></script>
<script src="<?php echo site_url(); ?>docs/assets/js/language/html.js"></script>
<script src="<?php echo site_url(); ?>docs/assets/js/language/css.js"></script>
<script src="<?php echo site_url(); ?>docs/assets/js/language/javascript.js"></script>
</body>

</html>