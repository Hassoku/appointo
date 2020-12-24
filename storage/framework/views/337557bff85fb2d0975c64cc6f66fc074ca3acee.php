<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title"><?php echo app('translator')->getFromJson('app.add'); ?> <?php echo app('translator')->getFromJson('menu.employee'); ?></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" id="createForm"  class="ajax-form" method="POST">
                        <?php echo csrf_field(); ?>

                        <div class="row">
                            <div class="col-md-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('app.name'); ?></label>
                                    <input type="text" class="form-control form-control-lg" name="name" value="">
                                </div>

                                <!-- text input -->
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('app.email'); ?></label>
                                    <input type="email" class="form-control form-control-lg" name="email" value="">
                                </div>

                                <!-- text input -->
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('app.password'); ?></label>
                                    <input type="password" class="form-control form-control-lg" name="password">
                                    <span class="help-block"><?php echo app('translator')->getFromJson('messages.leaveBlank'); ?></span>
                                </div>

                                <!-- text input -->
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('app.mobile'); ?></label>
                                    <div class="form-row">
                                        <div class="col-md-2 mb-2">
                                            <select name="calling_code" id="calling_code" class="form-control select2">
                                                <?php $__currentLoopData = $calling_codes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($value['dial_code']); ?>">
                                                        <?php echo e($value['dial_code'] . ' - ' . $value['name']); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="mobile">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('app.employeeGroup'); ?></label>
                                    <div class="input-group">
                                        <select name="group_id" id="group_id" class="form-control form-control-lg">
                                            <option value="0"><?php echo app('translator')->getFromJson('app.selectEmployeeGroup'); ?></option>
                                            <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($group->id); ?>"><?php echo e($group->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-success" id="add-group" type="button"><i class="fa fa-plus"></i> <?php echo app('translator')->getFromJson('app.add'); ?></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('app.assignRole'); ?></label>
                                    <select name="role_id" id="role_id" class="form-control form-control-lg">
                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($role->id); ?>"><?php echo e($role->display_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1"><?php echo app('translator')->getFromJson('app.image'); ?></label>
                                    <div class="card">
                                        <div class="card-body">
                                            <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg" data-default-file="<?php echo e(asset('img/default-avatar-user.png')); ?>" class="dropify"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="button" id="save-form" class="btn btn-success btn-light-round"><i
                                                class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-js'); ?>

    <script>
        $('.dropify').dropify({
            messages: {
                default: '<?php echo app('translator')->getFromJson("app.dragDrop"); ?>',
                replace: '<?php echo app('translator')->getFromJson("app.dragDropReplace"); ?>',
                remove: '<?php echo app('translator')->getFromJson("app.remove"); ?>',
                error: '<?php echo app('translator')->getFromJson('app.largeFile'); ?>'
            }
        });
        $('#add-group').click(function () {
            window.location = '<?php echo e(route("admin.employee-group.create")); ?>';
        })
        $('#save-form').click(function () {

            $.easyAjax({
                url: '<?php echo e(route('admin.employee.store')); ?>',
                container: '#createForm',
                type: "POST",
                redirect: true,
                file:true
            })
        });

    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\booking\resources\views/admin/employees/create.blade.php ENDPATH**/ ?>