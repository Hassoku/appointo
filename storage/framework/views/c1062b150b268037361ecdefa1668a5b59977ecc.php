<div class="modal-header">
    <h4 class="modal-title"><?php echo app('translator')->getFromJson('app.edit'); ?> <?php echo app('translator')->getFromJson('menu.bookingTimes'); ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form id="createProjectCategory" class="ajax-form" method="POST" autocomplete="off">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="form-body">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <h4 class="form-control-static"><?php echo app('translator')->getFromJson('app.'.$bookingTime->day); ?></h4>
                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('modules.settings.openTime'); ?></label>

                        <div class="input-group date time-picker">
                            <input type="text" class="form-control" name="start_time" value="<?php echo e($bookingTime->start_time); ?>">
                            <span class="input-group-append input-group-addon">
                                <button type="button" class="btn btn-info"><span class="fa fa-clock-o"></span></button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('modules.settings.closeTime'); ?></label>

                        <div class="input-group date time-picker">
                            <input type="text" class="form-control" name="end_time" value="<?php echo e($bookingTime->end_time); ?>">
                            <span class="input-group-append input-group-addon">
                                <button type="button" class="btn btn-info"><span class="fa fa-clock-o"></span></button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('modules.settings.slotDuration'); ?></label>

                        <div class="input-group justify-content-center align-items-center">
                            <input id="slot_duration" type="number" class="form-control" name="slot_duration" value="<?php echo e($bookingTime->slot_duration); ?>" min="1">
                            <span class="ml-3">
                                <?php echo app('translator')->getFromJson('app.minutes'); ?>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('modules.settings.allowMultipleBooking'); ?></label>
                        <select name="multiple_booking" id="multiple_booking" class="form-control" onchange="toggle('#show_max_booking');">
                            <option
                                    <?php if($bookingTime->multiple_booking == 'yes'): ?> selected <?php endif; ?>
                            value="yes"><?php echo app('translator')->getFromJson('app.yes'); ?></option>
                            <option
                                    <?php if($bookingTime->multiple_booking == 'no'): ?> selected <?php endif; ?>
                            value="no"><?php echo app('translator')->getFromJson('app.no'); ?></option>
                        </select>
                    </div>

                    <div class="form-group" id="show_max_booking">
                        <label for="max_booking"><?php echo app('translator')->getFromJson('modules.settings.maxBookingAllowed'); ?> <span class="text-info">( <?php echo app('translator')->getFromJson('modules.settings.maxBookingAllowedInfo'); ?> )</span></label>
                        <input class="form-control" type="number" name="max_booking" id="max_booking" value="<?php echo e($bookingTime->max_booking); ?>" step="1" min="0">
                    </div>

                    <div class="form-group">
                        <label><?php echo app('translator')->getFromJson('app.status'); ?></label>
                        <select name="status" id="status" class="form-control">
                            <option
                                    <?php if($bookingTime->status == 'enabled'): ?> selected <?php endif; ?>
                                    value="enabled"><?php echo app('translator')->getFromJson('app.enabled'); ?></option>
                            <option
                                    <?php if($bookingTime->status == 'disabled'): ?> selected <?php endif; ?>
                                    value="disabled"><?php echo app('translator')->getFromJson('app.disabled'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="save-category" class="btn btn-success"> <i class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
        </div>
    </form>
</div>


<script>
    $(function () {
        <?php if($bookingTime->multiple_booking === 'yes'): ?>
            $('#show_max_booking').show();
        <?php else: ?>
            $('#show_max_booking').hide();
        <?php endif; ?>

        function toggle(elementBox) {
            var elBox = $(elementBox);
            elBox.slideToggle();
        }
    })

    $('.time-picker').datetimepicker({
        format: '<?php echo e($time_picker_format); ?>',
        allowInputToggle: true,
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        }
    });

    $('#save-category').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('admin.booking-times.update', $bookingTime->id)); ?>',
            container: '#createProjectCategory',
            type: "POST",
            data: $('#createProjectCategory').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        })
    });

    $('#slot_duration,#max_booking').focus(function () {
        $(this).select();
    })
</script>
<?php /**PATH E:\laragon\www\booking\resources\views/admin/booking-time/edit.blade.php ENDPATH**/ ?>