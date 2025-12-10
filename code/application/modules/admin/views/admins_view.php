<?php $this->load->view('admin_header'); ?>
<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php echo ADMIN_URL; ?>Home">Home</a>
                </li>
                <li class="active">Passcode</li>
            </ul>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- <h3 class="header smaller lighter blue">Passcode</h3> -->
                    <!-- Add Admin Form -->
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="widget-title">Passcode</h4>
                        </div>
                        <div class="widget-body">
                            <div class="widget-main">
                                <?php if (validation_errors()): ?>
                                    <div class="alert alert-danger"><?php echo validation_errors(); ?></div>
                                <?php endif; ?>
                                <?php
                                $is_edit = isset($edit_admin) && $edit_admin;
                                $form_action = $is_edit ? 'admin/admins/edit_submit/' . $edit_admin['id'] : 'admin/admins/create';
                                echo form_open($form_action, ['class' => 'form-horizontal']);
                                ?>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="name">Passcode</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="col-xs-10 col-sm-8" id="name" name="name" placeholder="Passcode" required value="<?php echo $is_edit ? htmlspecialchars($edit_admin['name']) : set_value('name'); ?>" />
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="status">Status</label>
                                        <div class="col-sm-9">
                                            <select class="col-xs-10 col-sm-8" id="status" name="status" required>
                                                <option value=1 <?php echo ($is_edit && ($edit_admin['status'] == 1 || $edit_admin['status'] == 1)) ? 'selected' : ''; ?>>Active</option>
                                                <option value=0 <?php echo ($is_edit && ($edit_admin['status'] == 0 || $edit_admin['status'] == 0)) ? 'selected' : ''; ?>>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="username">Username</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="col-xs-10 col-sm-8" id="username" name="username" placeholder="Username" required value="<?php echo $is_edit ? htmlspecialchars($edit_admin['username']) : set_value('username'); ?>" <?php echo $is_edit ? 'readonly' : ''; ?> />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="password">Password<?php if($is_edit) echo ' (leave blank to keep current)'; ?></label>
                                        <div class="col-sm-9">
                                            <input type="password" class="col-xs-10 col-sm-8" id="password" name="password" placeholder="Password" <?php echo $is_edit ? '' : 'required'; ?> />
                                        </div>
                                    </div> -->
                                    <div class="form-actions text-left">
                                        <?php if($is_edit): ?>
                                            <button type="submit" class="btn btn-success">
                                                <i class="ace-icon fa fa-check"></i> Update Passcode
                                            </button>
                                            <a href="<?php echo ADMIN_URL; ?>admins" class="btn btn-default">Cancel</a>
                                        <?php endif; ?>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="space-10"></div>
                    <div class="table-header">Passcode</div>
                    <div>
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <!-- <th class="center">ID</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Username</th>
                                    <th>Role</th> -->
                                    <th>Passcode</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($admins)): ?>
                                    <?php foreach ($admins as $admin): ?>
                                        <tr>
                                            <td><?php echo isset($admin['name']) ? htmlspecialchars($admin['name']) : '-'; ?></td>
                                            <!-- <td class="center"><?php echo isset($admin['id']) ? $admin['id'] : '-'; ?></td> -->
                                            <!-- <td><?php echo isset($admin['name']) ? htmlspecialchars($admin['name']) : ''; ?></td>
                                            <td>
                                                <span class="label label-<?php echo (isset($admin['status']) && ($admin['status'] == 1 || $admin['status'] == 'active')) ? 'success' : 'danger'; ?> arrowed-in arrowed-in-right">
                                                    <?php echo isset($admin['status']) ? ( ($admin['status'] == 1 || $admin['status'] == 'active') ? 'Active' : 'Inactive' ) : '-'; ?>
                                                </span>
                                            </td>
                                            <td><?php echo isset($admin['username']) ? htmlspecialchars($admin['username']) : ''; ?></td>
                                            <td><?php echo isset($admin['role']) ? htmlspecialchars($admin['role']) : ''; ?></td> -->
                                            <td><?php echo isset($admin['created_date_time']) ? htmlspecialchars($admin['created_date_time']) : '-'; ?></td>
                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons">
                                                    <a class="green" href="<?php echo ADMIN_URL; ?>admins/edit/<?php echo $admin['id']; ?>">
                                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                    </a>
                                                    <!-- <a class="red" href="javascript:void(0);" onclick="if(confirm('Confirm Delete?')){window.location='<?php echo ADMIN_URL; ?>admins/delete/<?php echo $admin['id']; ?>';}">
                                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                    </a> -->
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="7">No admins found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->load->view('footer_copywrite_div'); ?>
<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
    <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
</a>
<!-- ace scripts and datatables -->
<script src="<?php echo site_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo site_url(); ?>assets/js/bootstrap.js"></script>
<script src="<?php echo site_url(); ?>assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo site_url(); ?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="<?php echo site_url(); ?>assets/js/ace/ace.js"></script>
<script type="text/javascript">
jQuery(function($) {
    $('#dynamic-table').dataTable({
        bAutoWidth: false,
        "aoColumns": [null, null, { "bSortable": false }],
        "aaSorting": []
    });
});
</script>
</script>
