<div class="row mb-3 mr-0 ml-0  rounded">
    <span class="d-none">
        <input type="checkbox" name="booking_checkboxes[]" value="<?php echo e($row->id); ?>" class="booking-checkboxes" id="booking-<?php echo e($row->id); ?>">
    </span>
    <div class="py-2 col-md-2
    <?php if($row->status == 'completed'): ?> bg-success <?php endif; ?>
    <?php if($row->status == 'pending'): ?> bg-warning <?php endif; ?>
    <?php if($row->status == 'approved'): ?> bg-info <?php endif; ?>
    <?php if($row->status == 'in progress'): ?> bg-primary <?php endif; ?>
    <?php if($row->status == 'canceled'): ?> bg-danger <?php endif; ?>
     text-center booking-time booking-div rounded-left d-flex align-items-center justify-content-center">
        <div>
            <h5><?php echo e($row->date_time->format('d M')); ?></h5>
            <span class="badge border <?php if($row->status == 'pending'): ?> border-dark <?php endif; ?> font-weight-normal"><?php echo e($row->date_time->format($settings->time_format)); ?></span><br>
            <small class="text-uppercase"><?php echo app('translator')->getFromJson('app.booking'); ?> # <?php echo e($row->id); ?></small>
        </div>
    </div>
    <div class="col-md-9 bg-light-gradient booking-div p-2 text-uppercase">
        <h6 class="font-weight-bold"><?php echo e(ucwords($row->user->name)); ?></h6>

        <div class="row mb-2">
            <div class="col-md-5 text-lowercase">
                <i class="fa fa-envelope-o"></i>
                <?php if(!is_null($row->user->email)): ?>
                    <?php if(strlen($row->user->email) > 17): ?>
                        <?php echo e(substr($row->user->email, 0, 18).'...'); ?>

                    <?php else: ?>
                        <?php echo e($row->user->email); ?>

                    <?php endif; ?>
                <?php else: ?> -- <?php endif; ?>
            </div>
            <div class="col-md-4">
                <i class="fa fa-phone"></i> <?php echo e($row->user->mobile ? $row->user->formatted_mobile : '--'); ?>

            </div>
            <div class="col-md-3">
                <span class="badge bg-light small border status
                 <?php if($row->status == 'completed'): ?> border-success <?php endif; ?>
                <?php if($row->status == 'pending'): ?> border-warning <?php endif; ?>
                <?php if($row->status == 'approved'): ?> border-info <?php endif; ?>
                <?php if($row->status == 'in progress'): ?> border-primary <?php endif; ?>
                <?php if($row->status == 'canceled'): ?> border-danger <?php endif; ?>
                        badge-pill"><?php echo app('translator')->getFromJson('app.'.$row->status); ?></span>
            </div>
        </div>

        <?php $__currentLoopData = $row->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span class="small text-primary"><?php echo e($item->businessService->name); ?> &bull;</span>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="col-md-1 text-right border-left bg-light rounded-right d-flex align-items-center justify-content-center">
        <button type="button" data-booking-id="<?php echo e($row->id); ?>" class="btn bg-transparent text-primary p-3 btn-social-icon rounded-right view-booking-detail"><i class="fa fa-chevron-right"></i></button>
    </div>
</div>
<?php /**PATH E:\laragon\www\booking\resources\views/admin/booking/list_view.blade.php ENDPATH**/ ?>