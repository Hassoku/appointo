<h4><?php echo app('translator')->getFromJson('menu.rolesPermissions'); ?></h4>
<div class="col-sm-12">
    <a href="javascript:;" id="addRole" class="btn btn-success btn-sm btn-outline waves-effect waves-light "><i class="fa fa-gear"></i> <?php echo app('translator')->getFromJson("modules.rolePermission.addRole"); ?></a>
</div>

<?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-12 b-all mt-2">
        <div class="row bg-dark p-3 justify-content-center align-items-center">
            <div class="col-md-4">
                <h5 class="text-white mt-2 mb-2"><strong><?php echo e(ucwords($role->display_name)); ?></strong></h5>
            </div>
            <div class="col-md-4 text-center role-members">
                <button class="btn btn-xs btn-danger btn-rounded show-members" data-role-id="<?php echo e($role->id); ?>"><i class="fa fa-users"></i> <?php echo e($role->member_count); ?> <?php echo app('translator')->getFromJson('modules.rolePermission.members'); ?></button>
            </div>
            <div class="col-md-4">
                <button class="btn btn-default btn-sm btn-rounded pull-right" onclick="toggle('#role-permission-<?php echo e($role->id); ?>')" data-role-id="<?php echo e($role->id); ?>"><i class="fa fa-key"></i> <?php echo app('translator')->getFromJson('modules.rolePermission.permissions'); ?></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 b-t permission-section" style="display: none;" id="role-permission-<?php echo e($role->id); ?>" >
                <table class="table ">
                    <thead>
                    <tr class="bg-white">
                        <th>
                            <div class="form-group d-flex">
                                <label class="switch mr-2">
                                    <input type="checkbox"
                                        <?php if(count($role->permissions) == $totalPermissions): ?>
                                            checked
                                        <?php endif; ?> onchange="toggleAllPermissions({ roleId: <?php echo e($role->id); ?>}, this);">
                                    <span class="slider round"></span>
                                </label>
                                <?php echo app('translator')->getFromJson('modules.rolePermission.selectAll'); ?>
                            </div>
                        </th>
                        <th><?php echo app('translator')->getFromJson('app.add'); ?></th>
                        <th><?php echo app('translator')->getFromJson('app.view'); ?></th>
                        <th><?php echo app('translator')->getFromJson('app.update'); ?></th>
                        <th><?php echo app('translator')->getFromJson('app.delete'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(ucwords($module->display_name)); ?>


                                    <?php if($module->description != trans($module->description)): ?>
                                        <a class="mytooltip" data-toggle="tooltip" data-placement="top" title="<?php echo app('translator')->getFromJson($module->description); ?>">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>

                                <?php $__currentLoopData = $module->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td>
                                        <label class="switch permissions">
                                            <input type="checkbox"
                                                <?php if($role->hasPermission([$permission->name])): ?>
                                                    checked
                                                <?php endif; ?> value="active" onchange="togglePermission({ roleId: <?php echo e($role->id); ?>, permissionId: <?php echo e($permission->id); ?>}, this);">
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php if(count($module->permissions) < 4): ?>
                                    <?php for($i=1; $i<=(4-count($module->permissions)); $i++): ?>
                                        <td>&nbsp;</td>
                                    <?php endfor; ?>
                                <?php endif; ?>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->startPush('footer-js'); ?>
    <script>
        const create_form = `<?php echo $__env->make('admin.role-permission.create_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>`;
        let table_modified = false;

        function togglePermission(options, ele) {
            let assignPermission = 'no';

            if ($(ele).is(':checked')) {
                assignPermission = 'yes';
            }

            options = {...options, _token: '<?php echo e(csrf_token()); ?>', assignPermission};

            $.easyAjax({
                url: '<?php echo e(route('admin.role-permission.store')); ?>',
                type: 'POST',
                data: options,
            })
        }

        function toggleAllPermissions(options, ele) {
            let assignPermission = 'no';

            if ($(ele).is(':checked')) {
                assignPermission = 'yes';
            }

            options = {...options, _token: '<?php echo e(csrf_token()); ?>', assignPermission};

            $.easyAjax({
                url: '<?php echo e(route('admin.role-permission.toggleAllPermissions')); ?>',
                type: 'POST',
                data: options,
                success: function (response) {
                    if (response.status == 'success') {
                        $(`#role-permission-${ options.roleId } .permissions input`).each(function (index, input) {
                            if ($(ele).is(':checked') !== $(input).is(':checked')) {
                                $(input).prop('checked', $(ele).is(':checked'));
                            }
                        })
                    }
                }
            })
        }

        $('#addRole').click(function () {
            const url = '<?php echo e(route('admin.role-permission.create')); ?>';

            $.ajaxModal('#application-lg-modal', url);
        })

        $('#application-lg-modal').on('hide.bs.modal', function (e) {
            if (table_modified) {
                window.location.reload();
            }
            else {
                $('#roleTable').DataTable().destroy();
            }
        })

        $('body').on('click', '#save-create-role', function () {
            var url = '<?php echo e(route("admin.role-permission.addRole")); ?>';

            $.easyAjax({
                url: url,
                type: 'POST',
                data: $('#create-role').serialize(),
                container: '#application-lg-modal',
                success: function (response) {
                    $('#create-edit-form').html(create_form);
                    roleTable.fnDraw();
                    table_modified = true;
                }
            })
        })

        $('body').on('click', '.edit-role', function () {
            var id = $(this).data('role-id');
            var url = '<?php echo e(route("admin.role-permission.edit", ":id")); ?>';
            url = url.replace(':id', id);

            $.easyAjax({
                url: url,
                type: 'GET',
                container: '#application-lg-modal',
                success: function (response) {
                    $('#create-edit-form').html(response.view);
                }
            })
        })

        $('body').on('click', '#save-edit-role', function () {
            const id = $('#edit-role').data('role-id');
            var url = '<?php echo e(route("admin.role-permission.update", ":id")); ?>';
            url = url.replace(':id', id);

            $.easyAjax({
                url: url,
                type: 'PUT',
                data: $('#edit-role').serialize(),
                container: '#application-lg-modal',
                success: function (response) {
                    $('#create-edit-form').html(create_form);
                    roleTable.fnDraw();
                    table_modified = true;
                }
            })
        })

        $('body').on('click', '#cancel-edit-role', function () {
            $('#create-edit-form').html(create_form);
        })

        $('body').on('click', '.delete-role', function () {
            const id = $(this).data('role-id');
            swal({
                icon: "warning",
                buttons: true,
                dangerMode: true,
                title: "<?php echo app('translator')->getFromJson('errors.areYouSure'); ?>",
                text: "<?php echo app('translator')->getFromJson('errors.deleteWarning'); ?>",
            })
            .then((willDelete) => {
                if (willDelete) {
                    var url = '<?php echo e(route("admin.role-permission.destroy", ":id")); ?>';
                    url = url.replace(':id', id);
                    const _token = '<?php echo e(csrf_token()); ?>';

                    $.easyAjax({
                        url: url,
                        type: 'POST',
                        data: { _token, _method: 'DELETE' },
                        container: '#application-lg-modal',
                        success: function (response) {
                            roleTable.fnDraw();
                            table_modified = true;
                        }
                    });
                }
            });
        })

        $('.show-members').click(function () {
            const id = $(this).data('role-id');
            let url = '<?php echo e(route('admin.role-permission.show', ':id')); ?>';
            url = url.replace(':id', id);

            $.ajaxModal('#application-lg-modal', url);
        })
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\laragon\www\booking\resources\views/admin/role-permission/index.blade.php ENDPATH**/ ?>