<?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="col-md-3">
        <!-- Widget: user widget style 1 -->
        <div class="card card-widget widget-user customer-card" onclick="location.href='<?php echo e(route('admin.customers.show', $customer->id)); ?>'">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header text-white" style="background-color: var(--active-color)">
                <h5 class="widget-user-username"><?php echo e(ucwords($customer->name)); ?></h5>
                <h6 class="widget-user-desc"><i class="fa fa-envelope"></i> <?php echo e($customer->email ?? '--'); ?></h6>
                <h6 class="widget-user-desc"><i class="fa fa-phone"></i> <?php echo e($customer->mobile ? $customer->formatted_mobile : '--'); ?></h6>
            </div>
            <div class="widget-user-image">
                <img class="img-circle elevation-2" src="<?php echo e($customer->user_image_url); ?>" alt="User Avatar">
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-6 border-right">
                        <div class="description-block">
                            <h5 class="description-header"><?php echo e(count($customer->completedBookings)); ?></h5>
                            <span class="description-text"><?php echo app('translator')->getFromJson('menu.bookings'); ?></span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <div class="description-block">
                            <h5 class="description-header"><?php echo e($customer->created_at->format($settings->date_format)); ?></h5>
                            <span class="description-text"><?php echo app('translator')->getFromJson('modules.customer.since'); ?></span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->

                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.widget-user -->
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-md-4">
        <?php echo app('translator')->getFromJson('messages.noRecordFound'); ?>
    </div>
<?php endif; ?>

<?php
    $loadedRecords = ($totalRecords - ($totalRecords - count($customers)));
    $takeRecords = $recordsLoad + $loadedRecords;
?>

<?php if($totalRecords > $loadedRecords): ?>
    <div class="col-md-12 text-center">
        <a href="javascript:;" data-take="<?php echo e($takeRecords); ?>" id="load-more" class="btn btn-lg btn-outline-dark"><?php echo app('translator')->getFromJson('app.loadMore'); ?></a>
    </div>
<?php endif; ?>
<?php /**PATH E:\laragon\www\booking\resources\views/admin/customer/list_ajax.blade.php ENDPATH**/ ?>