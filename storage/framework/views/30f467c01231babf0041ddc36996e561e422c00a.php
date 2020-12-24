<?php if($bookingTime->status == 'enabled'): ?>
    <?php if($bookingTime->multiple_booking === 'yes' && $bookingTime->max_booking !== 0 && $bookings->count() >= $bookingTime->max_booking): ?>
        <div class="alert alert-custom mt-3">
            <?php echo app('translator')->getFromJson('front.maxBookingLimitReached'); ?>
        </div>
    <?php else: ?>
        <ul class="time-slots px-1 py-1 px-md-5 py-md-5">
            <?php for($d = $startTime;$d < $endTime;$d->addMinutes($bookingTime->slot_duration)): ?>
                <?php $slotAvailable = 1; ?>
                <?php if($bookingTime->multiple_booking === 'no' && $bookings->count() > 0): ?>
                    <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($booking->date_time->format($settings->time_format) == $d->format($settings->time_format)): ?>
                            <?php $slotAvailable = 0; ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

                <?php if($slotAvailable == 1): ?>
                    <li>
                        <label class="custom-control custom-radio">
                            <input type="radio" value="<?php echo e($d->format('H:i:s')); ?>" class="custom-control-input" name="booking_time">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description"><?php echo e($d->format($settings->time_format)); ?></span>
                        </label>
                    </li>
                <?php endif; ?>
            <?php endfor; ?>
        </ul>
    <?php endif; ?>
<?php else: ?>
    <div class="alert alert-custom mt-3">
        <?php echo app('translator')->getFromJson('front.bookingSlotNotAvailable'); ?>
    </div>
<?php endif; ?>
<?php /**PATH E:\laragon\www\booking\resources\views/front/booking_slots.blade.php ENDPATH**/ ?>