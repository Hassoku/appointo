<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap-datepicker3.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <section class="section">
        <section class="booking-time sp-80 bg-w">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="all-title">
                        <h3 class="sec-title">
                            <?php echo app('translator')->getFromJson('front.selectBookingTime'); ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="booking-slots w-100">
                <div class="w-100">
                    <div class="date-picker w-100">
                        <div id="datepicker"></div>
                        <input type="hidden" id="booking_date" name="booking_date">
                    </div>
                    <div class="slots-wrapper">
                    </div>
                </div>
            </div>
            <div class="row mt-30">
                <div class="col-12">
                    <div class="navigation">
                        <a href="<?php echo e(route('front.index')); ?>" class="btn btn-custom btn-dark"><i class="fa fa-angle-left mr-2"></i><?php echo app('translator')->getFromJson('front.navigation.goBack'); ?></a>
                        <a href="javascript:;" onclick="addBookingDetails()" class="btn btn-custom btn-dark"><?php echo app('translator')->getFromJson('front.next'); ?> <i class="fa fa-angle-right ml-1"></i> </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>
    <script src="<?php echo e(asset('front-assets/js/date.format.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/bootstrap-datepicker.min.js')); ?>"></script>

    <script>
        $(function () {
            <?php if(sizeof($bookingDetails) > 0): ?>
                getBookingSlots({ bookingDate:  '<?php echo e($bookingDetails['bookingDate']); ?>', _token: "<?php echo e(csrf_token()); ?>"});

                var bookingDate = '<?php echo e($bookingDetails['bookingDate']); ?>';

                bookingDetails.bookingDate = bookingDate;

                $('#datepicker').datepicker('update', new Date(bookingDate));
            <?php endif; ?>
        });

        $('#datepicker').datepicker({
            // todayHighlight: true,
            templates: {
                leftArrow: '<i class="fa fa-chevron-left"></i>',
                rightArrow: '<i class="fa fa-chevron-right"></i>'
            },
            startDate: '-0d',
            // language: 'es'
        });

        var bookingDetails = {_token: $("meta[name='csrf-token']").attr('content')};

        function getBookingSlots(data) {
            $.easyAjax({
                url: "<?php echo e(route('front.bookingSlots')); ?>",
                type: "POST",
                data: data,
                success: function (response) {
                    if(response.status == 'success'){
                        $('.slots-wrapper').html(response.view);
                        // check for cookie
                        <?php if(sizeof($bookingDetails) > 0): ?>
                            $('.slots-wrapper').css('display', 'flex');

                            var bookingTime = '<?php echo e($bookingDetails['bookingTime']); ?>';
                            var bookingDate = '<?php echo e($bookingDetails['bookingDate']); ?>';

                            if (bookingDate == bookingDetails.bookingDate) {
                                bookingDetails.bookingTime = bookingTime;
                                $(`input[value='${bookingTime}']`).attr('checked', true);
                            }
                            else {
                                bookingDetails.bookingTime = '';
                            }
                        <?php else: ?>
                            bookingDetails.bookingTime = '';
                        <?php endif; ?>
                    }
                }
            })
        }

        $('#datepicker').on('changeDate', function() {
            $('.slots-wrapper').css({'display': 'flex', 'align-items': 'center'});
            var initialHeight = $('.slots-wrapper').css('height');
            var html = '<div class="loading text-white d-flex align-items-center" style="height: '+initialHeight+';">Loading... </div>';
            $('.slots-wrapper').html(html);

            $('html, body').animate({
                scrollTop: $(".slots-wrapper").offset().top
            }, 1000);

            $('#booking_date').val(
                $('#datepicker').datepicker('getFormattedDate')
            );
            bookingDetails.bookingDate = dateFormat(new Date($('#booking_date').val()), "mm/dd/yyyy");

            getBookingSlots({ bookingDate:  $('#datepicker').datepicker('getFormattedDate'), _token: "<?php echo e(csrf_token()); ?>"})
        });

        $(document).on('change', $('input[name="booking_time"]'), function (e) {
            bookingDetails.bookingTime = $(this).find('input[name="booking_time"]:checked').val();
        });

        function addBookingDetails() {
            $.easyAjax({
                url: '<?php echo e(route('front.addBookingDetails')); ?>',
                type: 'POST',
                container: 'section.section',
                data: bookingDetails,
                success: function (response) {
                    if (response.status == 'success') {
                        window.location.href = '<?php echo e(route('front.cartPage')); ?>'
                    }
                },
                error: function (err) {
                   var errors = err.responseJSON.errors;
                    for (var error in errors) {
                       $.showToastr(errors[error][0], 'error')
                    }
                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\booking\resources\views/front/booking_page.blade.php ENDPATH**/ ?>