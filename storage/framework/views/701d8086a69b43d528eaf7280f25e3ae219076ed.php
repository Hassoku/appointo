<form id="create-role" class="ajax-form">
    <?php echo csrf_field(); ?>
    <div class="form-body">
        <h5><?php echo app('translator')->getFromJson('modules.rolePermission.addRole'); ?></h5>
        <div class="row">
            <div class="col-sm-12 ">
                <div class="form-group">
                    <label><?php echo app('translator')->getFromJson('modules.rolePermission.forms.displayName'); ?></label>
                    <input type="text" name="display_name" id="display_name" class="form-control">
                </div>
            </div>
            <div class="col-sm-12 ">
                <div class="form-group">
                    <label><?php echo app('translator')->getFromJson('modules.rolePermission.forms.description'); ?></label>
                    <input type="text" name="description" id="description" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <button type="button" id="save-create-role" class="btn btn-success"> <i class="fa fa-check"></i>
            <?php echo app('translator')->getFromJson('app.add'); ?></button>
    </div>
</form>
<?php /**PATH E:\laragon\www\booking\resources\views/admin/role-permission/create_form.blade.php ENDPATH**/ ?>