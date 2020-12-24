<?php $__env->startPush('head-css'); ?>
    <style>
        #myTable td{
            padding: 0;
        }

        .status{
            font-size: 80%;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="widget-user-image">
                                <img class="img-circle elevation-2" src="<?php echo e($customer->user_image_url); ?>" alt="User Avatar">
                            </div>
                            <!-- /.widget-user-image -->
                        </div>
                        <div class="col-md-10 text-white">
                            <h3 class="widget-user-username"><?php echo e(ucwords($customer->name)); ?>

                                <?php if (app('laratrust')->can('update_customer')) : ?>
                                <a href="<?php echo e(route('admin.customers.edit', $customer->id)); ?>" class="btn btn-outline-light"><?php echo app('translator')->getFromJson('app.edit'); ?></a>
                                <?php endif; // app('laratrust')->can ?>
                                <?php if (app('laratrust')->can('delete_customer')) : ?>
                                <a href="javascript:;" class="btn btn-outline-light delete-row" data-row-id="<?php echo e($customer->id); ?>"><?php echo app('translator')->getFromJson('app.delete'); ?></a>
                                <?php endif; // app('laratrust')->can ?>
                            </h3>
                            <div>
                                <p><i class="fa fa-envelope"></i>: <?php echo e($customer->email); ?></p>
                                <p><i class="fa fa-phone"></i>: <?php echo e($customer->mobile ? $customer->formatted_mobile : '--'); ?></p>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card-footer row">

                    <div class="col-md-10 offset-md-2">
                        <div class="row">

                            <div class="col-md-12">
                                <h4><?php echo app('translator')->getFromJson('modules.customer.bookingStats'); ?></h4>
                            </div>

                            <div class="col-md-2 text-center mt-3 border-right">
                                <h6 class="text-uppercase"><?php echo app('translator')->getFromJson('app.completed'); ?></h6>
                                <p><?php echo e($completedBookings); ?></p>
                            </div>

                            <div class="col-md-2 text-center mt-3 border-right">
                                <h6 class="text-uppercase"><?php echo app('translator')->getFromJson('app.pending'); ?></h6>
                                <p><?php echo e($pendingBookings); ?></p>
                            </div>

                            <div class="col-md-2 text-center mt-3 border-right">
                                <h6 class="text-uppercase"><?php echo app('translator')->getFromJson('app.in progress'); ?></h6>
                                <p><?php echo e($inProgressBookings); ?></p>
                            </div>

                            <div class="col-md-2 text-center mt-3 border-right">
                                <h6 class="text-uppercase"><?php echo app('translator')->getFromJson('app.canceled'); ?></h6>
                                <p><?php echo e($canceledBookings); ?></p>
                            </div>

                            <div class="col-md-2 text-center mt-3">
                                <h6 class="text-uppercase"><?php echo app('translator')->getFromJson('modules.booking.earning'); ?></h6>
                                <p><?php echo e($settings->currency->currency_symbol); ?><?php echo e(round($earning, 2)); ?></p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-light">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="" id="filter-status" class="form-control">
                                    <option value=""><?php echo app('translator')->getFromJson('app.filter'); ?> <?php echo app('translator')->getFromJson('app.status'); ?>: <?php echo app('translator')->getFromJson('app.viewAll'); ?></option>
                                    <option value="completed"><?php echo app('translator')->getFromJson('app.completed'); ?></option>
                                    <option value="pending"><?php echo app('translator')->getFromJson('app.pending'); ?></option>
                                    <option value="in progress"><?php echo app('translator')->getFromJson('app.in progress'); ?></option>
                                    <option value="canceled"><?php echo app('translator')->getFromJson('app.canceled'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control datepicker" name="filter_date" id="filter-date" placeholder="<?php echo app('translator')->getFromJson('app.booking'); ?> <?php echo app('translator')->getFromJson('app.date'); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="button" id="reset-filter" class="btn btn-danger"><i class="fa fa-times"></i> <?php echo app('translator')->getFromJson('app.reset'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
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

                        <div class="col-md-5 offset-md-1" id="booking-detail">

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-js'); ?>
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
                            "filter_customer": '<?php echo e($customer->id); ?>',
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
//                                    swal("Deleted!", response.message, "success");
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
//                                    swal("Deleted!", response.message, "success");
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

            $('#filter-status, #filter-customer').change(function () {
                table._fnDraw();
            })

            $('#reset-filter').click(function () {
                $('#filter-status, #filter-date').val('');
                $("#filter-customer").val('').trigger('change');
                table._fnDraw();
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
                            var url = "<?php echo e(route('admin.customers.destroy',':id')); ?>";
                            url = url.replace(':id', id);

                            var token = "<?php echo e(csrf_token()); ?>";

                            $.easyAjax({
                                type: 'POST',
                                url: url,
                                data: {'_token': token, '_method': 'DELETE'},
                                success: function (response) {
                                    if (response.status == "success") {
                                        $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                                        table._fnDraw();
                                        $('#booking-detail').html('');
                                    }
                                }
                            });
                        }
                    });
            });


        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\booking\resources\views/admin/customer/show.blade.php ENDPATH**/ ?>