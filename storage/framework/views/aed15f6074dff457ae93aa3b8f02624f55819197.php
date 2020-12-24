<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title"><?php echo app('translator')->getFromJson('app.edit'); ?> <?php echo app('translator')->getFromJson('app.category'); ?></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" id="createForm"  class="ajax-form" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="hidden" name="id" value="<?php echo e($category->id); ?>">
                        <div class="row">
                            <div class="col-md">
                                <!-- text input -->
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('app.category'); ?> <?php echo app('translator')->getFromJson('app.name'); ?></label>
                                    <input type="text" name="name" id="name" class="form-control form-control-lg" value="<?php echo e($category->name); ?>">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('app.category'); ?> <?php echo app('translator')->getFromJson('app.slug'); ?></label>
                                    <input type="text" name="slug" id="slug" class="form-control form-control-lg" value="<?php echo e($category->slug); ?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1"><?php echo app('translator')->getFromJson('app.image'); ?></label>
                                    <div class="card">
                                        <div class="card-body">
                                            <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg" class="dropify"
                                                   data-default-file="<?php echo e($category->category_image_url); ?>"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for=""><?php echo app('translator')->getFromJson('app.status'); ?></label>
                                    <select name="status" id="" class="form-control form-control-lg">
                                        <option
                                                <?php if($category->status == 'active'): ?> selected <?php endif; ?>
                                                value="active"><?php echo app('translator')->getFromJson('app.active'); ?></option>
                                        <option
                                                <?php if($category->status == 'deactive'): ?> selected <?php endif; ?>
                                        value="deactive"><?php echo app('translator')->getFromJson('app.deactive'); ?></option>
                                    </select>
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

        function createSlug(value) {
            value = value.replace(/\s\s+/g, ' ');
            let slug = value.split(' ').join('-').toLowerCase();
            slug = slug.replace(/--+/g, '-');
            $('#slug').val(slug);
        }

        $('#name').keyup(function(e) {
            createSlug($(this).val());
        });

        $('#slug').keyup(function(e) {
            createSlug($(this).val());
        });

        $('#save-form').click(function () {

            $.easyAjax({
                url: '<?php echo e(route('admin.categories.update', $category->id)); ?>',
                container: '#createForm',
                type: "POST",
                redirect: true,
                file:true,
                data: $('#createForm').serialize()
            })
        });
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\booking\resources\views/admin/category/edit.blade.php ENDPATH**/ ?>