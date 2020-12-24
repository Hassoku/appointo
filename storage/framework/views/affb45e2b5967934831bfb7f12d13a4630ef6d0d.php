<?php $__env->startPush('head-css'); ?>
    <style>
        .link-stats{
            cursor: pointer;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row mb-2">

        <?php if($user->is_admin): ?>
        <div class="col-md-12">
            <?php ($updateVersionInfo = \Froiden\Envato\Functions\EnvatoUpdate::updateVersionInfo()); ?>
            <?php if(isset($updateVersionInfo['lastVersion'])): ?>

            <div class="alert alert-primary col-md-12">
                <div class="row">
                    <div class="col-md-10 d-flex align-items-center"><i class="fa fa-gift fa-3x mr-2"></i> <?php echo app('translator')->getFromJson('modules.update.newUpdate'); ?> <span
                                class="badge badge-success"><?php echo e($updateVersionInfo['lastVersion']); ?></span>
                    </div>

                    <div class="col-md-2 text-right">
                        <a href="<?php echo e(route('admin.settings.index')); ?>"
                            class="btn btn-success"><?php echo app('translator')->getFromJson('app.update'); ?></a>
                    </div>

                </div>
            </div>

            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if(!$user->mobile_verified && $smsSettings->nexmo_status == 'active'): ?>
            <div id="verify-mobile-info" class="col-md-12">
                <div class="alert alert-info col-md-12" role="alert">
                    <div class="row">
                        <div class="col-md-10 d-flex align-items-center">
                            <i class="fa fa-info fa-3x mr-2"></i>
                            <?php echo app('translator')->getFromJson('messages.info.verifyAlert'); ?>
                        </div>
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <a href="<?php echo e(route('admin.profile.index')); ?>" class="btn btn-warning">
                                <?php echo app('translator')->getFromJson('menu.profile'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if(strlen($smsSettings->nexmo_from) > 18): ?>
            <div id="brand-length" class="col-md-12">
                <div class="alert alert-danger col-md-12" role="alert">
                    <div class="row">
                        <div class="col-md-10 d-flex align-items-center">
                            <i class="fa fa-exclamation-triangle fa-3x mr-2"></i>
                            <?php echo app('translator')->getFromJson('messages.info.smsNameAlert'); ?>
                        </div>
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <a href="<?php echo e(route('admin.settings.index').'#sms-settings'); ?>" class="btn btn-info">
                                <?php echo app('translator')->getFromJson('menu.settings'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-md-12">
            <h6><?php echo app('translator')->getFromJson('app.dateRange'); ?></h6>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <input type="text" class="form-control datepicker" name="start_date" id="start-date"
                       placeholder="<?php echo app('translator')->getFromJson('app.startDate'); ?>"
                       value="<?php echo e(\Carbon\Carbon::today()->subDays(30)->format($settings->date_format)); ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <input type="text" class="form-control datepicker" name="end_date" id="end-date"
                       placeholder="<?php echo app('translator')->getFromJson('app.endDate'); ?>" value="<?php echo e(\Carbon\Carbon::today()->format($settings->date_format)); ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <button type="button" id="apply-filter" class="btn btn-success"><i
                            class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.apply'); ?></button>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <h4 class="text-uppercase mb-4"><?php echo app('translator')->getFromJson('modules.dashboard.totalBooking'); ?>: <span id="total-booking">0</span></h4>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box link-stats" onclick="location.href='<?php echo e(route('admin.bookings.index', 'status=completed')); ?>'">
                <span class="info-box-icon bg-success"><i class="fa fa-calendar"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><?php echo app('translator')->getFromJson('modules.dashboard.completedBooking'); ?></span>
                    <span class="info-box-number" id="completed-booking">0</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box link-stats" onclick="location.href='<?php echo e(route('admin.bookings.index', 'status=pending')); ?>'">
                <span class="info-box-icon bg-warning"><i class="fa fa-calendar"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><?php echo app('translator')->getFromJson('modules.dashboard.pendingBooking'); ?></span>
                    <span class="info-box-number" id="pending-booking">0</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box link-stats" onclick="location.href='<?php echo e(route('admin.bookings.index', 'status=approved')); ?>'">
                <span class="info-box-icon bg-info"><i class="fa fa-calendar"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><?php echo app('translator')->getFromJson('modules.dashboard.approvedBooking'); ?></span>
                    <span class="info-box-number" id="approved-booking">0</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box link-stats" onclick="location.href='<?php echo e(route('admin.bookings.index', 'status=in progress')); ?>'">
                <span class="info-box-icon bg-primary"><i class="fa fa-calendar"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><?php echo app('translator')->getFromJson('modules.dashboard.inProgressBooking'); ?></span>
                    <span class="info-box-number" id="in-progress-booking">0</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box link-stats" onclick="location.href='<?php echo e(route('admin.bookings.index', 'status=canceled')); ?>'">
                <span class="info-box-icon bg-danger"><i class="fa fa-calendar"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><?php echo app('translator')->getFromJson('modules.dashboard.canceledBooking'); ?></span>
                    <span class="info-box-number" id="canceled-booking">0</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-secondary"><i class="fa fa-building"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><?php echo app('translator')->getFromJson('modules.dashboard.walkInBookings'); ?></span>
                    <span class="info-box-number" id="offline-booking">0</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa fa-internet-explorer"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><?php echo app('translator')->getFromJson('modules.dashboard.onlineBookings'); ?></span>
                    <span class="info-box-number" id="online-booking">0</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <?php if($user->is_admin): ?>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-dark-gradient"><i class="fa fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><?php echo app('translator')->getFromJson('modules.dashboard.totalCustomers'); ?></span>
                        <span class="info-box-number" id="total-customers">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><?php echo e($settings->currency->currency_symbol); ?></span>

                    <div class="info-box-content">
                        <span class="info-box-text"><?php echo app('translator')->getFromJson('modules.dashboard.totalEarning'); ?></span>
                        <span class="info-box-number" id="total-earning">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        <?php endif; ?>
    </div>

    <?php if($user->is_admin): ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo app('translator')->getFromJson('modules.dashboard.recentBookings'); ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table">
                            <?php $__empty_1 = true; $__currentLoopData = $recentSales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo e(route('admin.customers.show', $booking->user->id)); ?>" data-toggle="tooltip" data-original-title="<?php echo e(ucwords($booking->user->name)); ?>"><img src="<?php echo e($booking->user->user_image_url); ?>" class="border img-bordered-sm img-size-50 img-circle"  ></a>
                                    </td>
                                    <td>
                                        <a class="text-uppercase" href="<?php echo e(route('admin.customers.show', $booking->user->id)); ?>"><?php echo e(ucwords($booking->user->name)); ?></a><br>
                                        <i class="icon-email"></i> <?php echo e($booking->user->email ?? '--'); ?><br>
                                        <i class="icon-mobile"></i> <?php echo e($booking->user->mobile ? $booking->user->formatted_mobile : '--'); ?>

                                    </td>
                                    <td>
                                        <ol>
                                        <?php $__currentLoopData = $booking->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                           <li><?php echo e(ucwords($item->businessService->name)); ?> x<?php echo e($item->quantity); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ol>
                                    </td>
                                    <td class="text-muted">
                                        <i class="icon-calendar"></i> <?php echo e($booking->date_time->format($settings->date_format)); ?><br>
                                        <i class="icon-alarm-clock"></i> <?php echo e($booking->date_time->format($settings->time_format)); ?>

                                    </td>
                                    <td>
                                        <span class="text-uppercase small border
                                        <?php if($booking->status == 'completed'): ?> border-success text-success <?php endif; ?>
                                        <?php if($booking->status == 'pending'): ?> border-warning text-warning <?php endif; ?>
                                        <?php if($booking->status == 'approved'): ?> border-info text-info <?php endif; ?>
                                        <?php if($booking->status == 'in progress'): ?> border-primary text-primary <?php endif; ?>
                                        <?php if($booking->status == 'canceled'): ?> border-danger text-danger <?php endif; ?>
                                                badge-pill"><?php echo e($booking->status); ?></span>

                                        <?php if(($booking->status == 'pending' || $booking->status == 'approved') && $booking->date_time->greaterThanOrEqualTo(\Carbon\Carbon::now())): ?>
                                           <br><br><a href="javascript:;" data-booking-id="<?php echo e($booking->id); ?>" class="btn btn-rounded btn-outline-dark btn-sm send-reminder"><i class="fa fa-send"></i> <?php echo app('translator')->getFromJson('modules.booking.sendReminder'); ?></a>
                                        <?php endif; ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td><?php echo app('translator')->getFromJson('messages.noRecordFound'); ?></td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div><!-- /.row -->
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-js'); ?>
    <script>
        $('.datepicker').datetimepicker({
            format: '<?php echo e($date_picker_format); ?>',
            allowInputToggle: true,
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right'
            }
        })

        function calculateStats() {
            let startDate = $('#start-date').val();
            let endDate = $('#end-date').val();

            $.easyAjax({
                type: 'GET',
                url: '<?php echo e(route("admin.dashboard")); ?>',
                data: {startDate: startDate, endDate: endDate},
                success: function (response) {
                    if (response.status == "success") {
                        $.unblockUI();
                        $('#total-booking').html(response.totalBooking)
                        $('#in-progress-booking').html(response.inProgressBooking)
                        $('#pending-booking').html(response.pendingBooking)
                        $('#approved-booking').html(response.approvedBooking)
                        $('#completed-booking').html(response.completedBooking)
                        $('#canceled-booking').html(response.canceledBooking)
                        $('#offline-booking').html(response.offlineBooking)
                        $('#online-booking').html(response.onlineBooking)
                        $('#total-customers').html(response.totalCustomers)
                        $('#total-earning').html(response.totalEarnings)
                    }
                }
            });

        }

        calculateStats();

        $('#apply-filter').click(function () {
            calculateStats();
        });

        $('.send-reminder').click(function () {
            let bookingId = $(this).data('booking-id');

            $.easyAjax({
                type: 'POST',
                url: '<?php echo e(route("admin.bookings.sendReminder")); ?>',
                data: {bookingId: bookingId, _token: '<?php echo e(csrf_token()); ?>'}
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\booking\resources\views/admin/dashboard/index.blade.php ENDPATH**/ ?>