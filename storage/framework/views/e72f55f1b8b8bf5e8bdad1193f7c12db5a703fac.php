<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title"><?php echo app('translator')->getFromJson('app.add'); ?> <?php echo app('translator')->getFromJson('app.location'); ?></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" id="createForm"  class="ajax-form" method="POST">
                        <?php echo csrf_field(); ?>

                        <input type="hidden" name="redirect_url" value="<?php echo e(url()->previous()); ?>">

                        <div class="row">
                            <div class="col-md-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label><?php echo app('translator')->getFromJson('app.location'); ?> <?php echo app('translator')->getFromJson('app.name'); ?></label>
                                    <input type="text" class="form-control form-control-lg" name="name">
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
        
            
                
                
                
                
            
        

        $('#save-form').click(function () {

            $.easyAjax({
                url: '<?php echo e(route('admin.locations.store')); ?>',
                container: '#createForm',
                type: "POST",
                redirect: true,
                file:true,
                data: $('#createForm').serialize()
            })
        });

    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\booking\resources\views/admin/location/create.blade.php ENDPATH**/ ?>