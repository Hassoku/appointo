<?php $__env->startPush('head-css'); ?>
    <style>
        #myTable td{
            padding: 0;
        }

        .status{
            font-size: 80%;
        }

        .booking-selected{
            border: 3px solid var(--main-color);
        }

        .payments a {
            border: 2px solid;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-light">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <select name="" id="filter-status" class="form-control">
                                    <option value=""><?php echo app('translator')->getFromJson('app.filter'); ?> <?php echo app('translator')->getFromJson('app.status'); ?>: <?php echo app('translator')->getFromJson('app.viewAll'); ?></option>
                                    <option <?php if($status == 'completed'): ?> selected <?php endif; ?> value="completed"><?php echo app('translator')->getFromJson('app.completed'); ?></option>
                                    <option <?php if($status == 'pending'): ?> selected <?php endif; ?> value="pending"><?php echo app('translator')->getFromJson('app.pending'); ?></option>
                                    <option <?php if($status == 'approved'): ?> selected <?php endif; ?> value="approved"><?php echo app('translator')->getFromJson('app.approved'); ?></option>
                                    <option <?php if($status == 'in progress'): ?> selected <?php endif; ?> value="in progress"><?php echo app('translator')->getFromJson('app.in progress'); ?></option>
                                    <option <?php if($status == 'canceled'): ?> selected <?php endif; ?> value="canceled"><?php echo app('translator')->getFromJson('app.canceled'); ?></option>
                                </select>
                            </div>
                        </div>
                        <?php if($user->is_admin): ?>
                        <div class="col-md">
                            <div class="form-group">
                                <select name="" id="filter-customer" class="form-control select2">
                                    <option value=""><?php echo app('translator')->getFromJson('modules.booking.selectCustomer'); ?>: <?php echo app('translator')->getFromJson('app.viewAll'); ?></option>
                                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($customer->id); ?>"><?php echo e(ucwords($customer->name)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <select name="" id="filter-location" class="form-control select2">
                                    <option value=""><?php echo app('translator')->getFromJson('modules.booking.selectLocation'); ?>: <?php echo app('translator')->getFromJson('app.viewAll'); ?></option>
                                    <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($location->id); ?>"><?php echo e(ucwords($location->name)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <input type="text" class="form-control datepicker" name="filter_date" id="filter-date" placeholder="<?php echo app('translator')->getFromJson('app.booking'); ?> <?php echo app('translator')->getFromJson('app.date'); ?>">
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="col-md">
                            <div class="form-group">
                                <button type="button" id="reset-filter" class="btn btn-danger"><i class="fa fa-times"></i> <?php echo app('translator')->getFromJson('app.reset'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <form role="form" id="createForm"  class="ajax-form" method="POST">
                        <?php echo csrf_field(); ?>

                        <div class="row">
                            <?php if($user->is_admin): ?>
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-md mb-3 text-bold">
                                            <span id="selected-booking-count">0</span> <?php echo app('translator')->getFromJson('app.booking'); ?> <?php echo app('translator')->getFromJson('app.selected'); ?>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-group">
                                                <select id="change_status" name="change_status" class="form-control">
                                                    <option value=""><?php echo app('translator')->getFromJson('modules.booking.selectStatus'); ?></option>
                                                    <option value="completed"><?php echo app('translator')->getFromJson('app.completed'); ?></option>
                                                    <option value="pending"><?php echo app('translator')->getFromJson('app.pending'); ?></option>
                                                    <option value="approved"><?php echo app('translator')->getFromJson('app.approved'); ?></option>
                                                    <option value="in progress"><?php echo app('translator')->getFromJson('app.in progress'); ?></option>
                                                    <option value="canceled"><?php echo app('translator')->getFromJson('app.canceled'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md mb-3">
                                            <button type="button" id="change-status" disabled class="btn btn-primary"><?php echo app('translator')->getFromJson('modules.booking.changeStatus'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                        <div class="row">
                            <div class="col-md-12 alert alert-primary"><i class="fa fa-info-circle"></i> <?php echo app('translator')->getFromJson('modules.booking.selectNote'); ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="table-responsive">


                                    <table id="myTable" class="table table-borderless w-100">
                                        <thead class="hide">
                                        <tr>
                                            <th>#</th>
                                        </tr>
                                        </thead>
                                    </table>

                                </div>

                            </div>

                            <div class="col-md-6 pl-md-5" id="booking-detail">

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-js'); ?>
    <?php if($credentials->stripe_status == 'active' && !$user->is_admin): ?>
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <?php endif; ?>

    <?php if($credentials->razorpay_status == 'active' && !$user->is_admin): ?>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <?php endif; ?>

    <script>
        $(document).ready(function() {

            $('.select2').select2();

            $('.datepicker').datetimepicker({
                format: '<?php echo e($date_picker_format); ?>',
                allowInputToggle: true,
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                }
            }).on("dp.change", function (e) {
                table._fnDraw();
            });

            function updateBooking(currEle) {
                let url = '<?php echo e(route('admin.bookings.update', ':id')); ?>';
                url = url.replace(':id', currEle.data('booking-id'));

                $.easyAjax({
                    url: url,
                    container: '#update-form',
                    type: "POST",
                    data: $('#update-form').serialize(),
                    success: function (response) {
                        if (response.status == "success") {
                            $('#booking-detail').hide().html(response.view).fadeIn('slow');
                            table._fnDraw();
                        }
                    }
                })
            }

            $('body').on('click', '#update-booking', function () {
                let cartItems = $("input[name='cart_prices[]']").length;

                if(cartItems === 0){
                    swal('<?php echo app('translator')->getFromJson("modules.booking.addItemsToCart"); ?>');
                    $('#cart-item-error').html('<?php echo app('translator')->getFromJson("modules.booking.addItemsToCart"); ?>');
                    return false;
                }
                else {
                    $('#cart-item-error').html('');
                    var updateButtonEl = $(this);
                    if ($('#booking-status').val() == 'completed' && $('#payment-status').val() == 'pending' && $('.fa.fa-money').parent().text().indexOf('cash') !== -1) {
                        swal({
                            text: '<?php echo app('translator')->getFromJson("modules.booking.changePaymentStatus"); ?>',
                            closeOnClickOutside: false,
                            buttons: [
                                'NO', 'YES'
                            ]
                        }).then(function (isConfirmed) {
                            if (isConfirmed) {
                                $('#payment-status').val('completed');
                            }
                            updateBooking(updateButtonEl);
                        });
                    }
                    else {
                        updateBooking(updateButtonEl);
                    }
                }

            });

            var table = $('#myTable').dataTable({
                responsive: true,
                // processing: true,
                "searching": false,
                serverSide: true,
                "ordering": false,
                ajax: {'url' : '<?php echo route('admin.bookings.index'); ?>',
                    "data": function ( d ) {
                        return $.extend( {}, d, {
                            "filter_status": $('#filter-status').val(),
                            "filter_customer": $('#filter-customer').val(),
                            "filter_location": $('#filter-location').val(),
                            "filter_date": $('#filter-date').val(),
                        } );
                    }
                },
                language: {
                    "url": "<?php echo __("app.datatable") ?>"
                },
                "fnDrawCallback": function( oSettings ) {
                    $("body").tooltip({
                        selector: '[data-toggle="tooltip"]'
                    });
                },
                columns: [
                    { data: 'id', name: 'id' }
                ]
            });
            new $.fn.dataTable.FixedHeader( table );

            $('#change-status').click(function () {
                $.easyAjax({
                    url: '<?php echo e(route('admin.bookings.multiStatusUpdate')); ?>',
                    container: '#createForm',
                    type: "POST",
                    data: $('#createForm').serialize(),
                    success: function(response){
                        table._fnDraw();
                        $('#change-status').attr('disabled', true);
                    }
                })
            });

            $('#change_status').change(function () {
                if ($(this).hasClass('is-invalid')){
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.invalid-feedback').remove();
                }
            })

            $('body').on('click', '.delete-row', function(){
                var id = $(this).data('row-id');
                swal({
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    title: "<?php echo app('translator')->getFromJson('errors.areYouSure'); ?>",
                    text: "<?php echo app('translator')->getFromJson('errors.deleteWarning'); ?>",
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            var url = "<?php echo e(route('admin.bookings.destroy',':id')); ?>";
                            url = url.replace(':id', id);

                            var token = "<?php echo e(csrf_token()); ?>";

                            $.easyAjax({
                                type: 'POST',
                                url: url,
                                data: {'_token': token, '_method': 'DELETE'},
                                success: function (response) {
                                    if (response.status == "success") {
                                        $.unblockUI();
                                        table._fnDraw();
                                        $('#booking-detail').html('');
                                    }
                                }
                            });
                        }
                    });
            });

            $('body').on('click', '.cancel-row', function(){
                var id = $(this).data('row-id');
                swal({
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    title: "<?php echo app('translator')->getFromJson('errors.areYouSure'); ?>",
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            var url = "<?php echo e(route('admin.bookings.requestCancel',':id')); ?>";
                            url = url.replace(':id', id);

                            var token = "<?php echo e(csrf_token()); ?>";

                            $.easyAjax({
                                type: 'POST',
                                url: url,
                                data: {'_token': token, '_method': 'POST'},
                                success: function (response) {
                                    if (response.status == "success") {
                                        $.unblockUI();
                                        table._fnDraw();
                                        $('#booking-detail').html('');
                                    }
                                }
                            });
                        }
                    });
            });

            $('#myTable').on('click', '.view-booking-detail', function () {
                let bookingId = $(this).data('booking-id');
                let url = '<?php echo e(route('admin.bookings.show', ':id')); ?>';
                url = url.replace(':id', bookingId);

                $.easyAjax({
                    type: 'GET',
                    url: url,
                    success: function (response) {
                        if (response.status == "success") {
                            $('html, body').animate({
                                scrollTop: $("#booking-detail").offset().top-50
                            }, 2000);
                            $('#booking-detail').hide().html(response.view).fadeIn('slow');
                        }
                    }
                });
            });

            $('body').on('click', '.edit-booking', function () {
                let bookingId = $(this).data('booking-id');
                let url = '<?php echo e(route('admin.bookings.edit', ':id')); ?>';
                url = url.replace(':id', bookingId);

                $.easyAjax({
                    type: 'GET',
                    url: url,
                    success: function (response) {
                        if (response.status == "success") {
                            $('#booking-detail').hide().html(response.view).fadeIn('slow');
                        }
                    }
                });
            });

            $('#filter-status, #filter-customer, #filter-location').change(function () {
                table._fnDraw();
            });

            $('#reset-filter').click(function () {
                $('#filter-status, #filter-date').val('');
                $("#filter-customer").val('').trigger('change');
                $("#filter-location").val('').trigger('change');
                table._fnDraw();
            })

            $('body').on('click', '.send-reminder', function () {
                let bookingId = $(this).data('booking-id');

                $.easyAjax({
                    type: 'POST',
                    url: '<?php echo e(route("admin.bookings.sendReminder")); ?>',
                    data: {bookingId: bookingId, _token: '<?php echo e(csrf_token()); ?>'}
                });
            });

        });
    </script>
    <?php if($user->is_admin): ?>
    <script>
        $('#myTable').on('click', '.booking-div', function(){
            let checkbox = $(this).closest('.row').find('.booking-checkboxes');
            if(checkbox.is(":checked")){
                checkbox.removeAttr('checked');
                $(this).closest('.row').removeClass('booking-selected');
            }
            else{
                checkbox.attr('checked', true);
                $(this).closest('.row').addClass('booking-selected');
            }

            $('#selected-booking-count').html($('[name="booking_checkboxes[]"]:checked').length)
            if($('[name="booking_checkboxes[]"]:checked').length > 0){
                $('#change-status').removeAttr('disabled');
            }
            else{
                $('#change-status').attr('disabled', true);
            }
        })
    </script>
    <?php endif; ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\booking\resources\views/admin/booking/index.blade.php ENDPATH**/ ?>