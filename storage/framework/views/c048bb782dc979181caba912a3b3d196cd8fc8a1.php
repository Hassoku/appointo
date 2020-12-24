<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/select2.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <section class="section">
        <section class="cart-area sp-80">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="all-title">
                            <h3 class="sec-title">
                                <?php echo app('translator')->getFromJson('front.headings.checkout'); ?>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="billing-info">
                    <?php if(is_null($user)): ?>
                        <p class="mb-30">
                            <?php echo app('translator')->getFromJson('front.accountAlready'); ?> ?
                            <a href="<?php echo e(route('login')); ?>"> <?php echo app('translator')->getFromJson('front.loginNow'); ?> </a>
                        </p>
                    <?php endif; ?>
                    <div class="row d-flex justify-content-center">
                        <?php if(is_null($user)): ?>
                        <div class="col-lg-7 col-12 mb-30">
                            <h5><?php echo app('translator')->getFromJson('app.add'); ?> <?php echo app('translator')->getFromJson('front.personalDetails'); ?></h5>
                            <form id="personal-details" class="ajax-form" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <span>first name*</span>
                                            <input type="text" name="first_name" class="form-control" placeholder="First name">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <span>last name*</span>
                                            <input type="text" name="last_name" class="form-control" placeholder="Last name">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <span>email*</span>
                                            <input type="text" name="email" class="form-control" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <span>phone number*</span>
                                            <div class="form-row">
                                                <div class="col-sm-4">
                                                    <select name="calling_code" id="calling_code" class="form-control select2">
                                                        <?php $__currentLoopData = $calling_codes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($value['dial_code']); ?>"
                                                            <?php if(!is_null($user) && $user->calling_code): ?>
                                                                <?php echo e($user->calling_code == $value['dial_code'] ? 'selected' : ''); ?>

                                                            <?php endif; ?>><?php echo e($value['dial_code'] . ' - ' . $value['name']); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" name="phone" class="form-control" placeholder="Phone no.">
                                                </div>
                                                <?php if($smsSettings->nexmo_status == 'active'): ?>
                                                    <span class="text-info ml-2">
                                                        <?php echo app('translator')->getFromJson('messages.info.verifyMessage'); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-12">
                                    <p class="c-theme">** <?php echo app('translator')->getFromJson('front.accountCreateNotice'); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php elseif($smsSettings->nexmo_status == 'active' && !$user->mobile_verified): ?>
                        <div class="col-lg-7 col-12 mb-30">
                            <h5><?php echo app('translator')->getFromJson('app.verifyMobile'); ?></h5>
                            <div id="verify-mobile">
                                <?php echo $__env->make('partials.front_verify_phone', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="<?php echo e(!$user || !$user->mobile_verified ? 'col-lg-5' : 'col-lg-7'); ?> col-12 mb-30">
                            <div class="booking-summary mb-30">
                                <h5><?php echo app('translator')->getFromJson('front.summary.checkout.heading.bookingSummary'); ?></h5>
                                <ul>
                                    <li>
                                    <span>
                                        <?php echo app('translator')->getFromJson('front.bookingDate'); ?>:
                                    </span>
                                        <span>
                                        <?php echo e(\Carbon\Carbon::createFromFormat('m/d/Y', $bookingDetails['bookingDate'])->format('l, F jS')); ?>

                                    </span>
                                    </li>
                                    <li>
                                    <span>
                                        <?php echo app('translator')->getFromJson('front.bookingTime'); ?>:
                                    </span>
                                        <span>
                                        <?php echo e(\Carbon\Carbon::createFromFormat('H:i:s', $bookingDetails['bookingTime'])->format($settings->time_format)); ?>

                                    </span>
                                    </li>
                                    <li>
                                    <span>
                                        <?php echo app('translator')->getFromJson('front.amountToPay'); ?>:
                                    </span>
                                    <span>
                                        <?php echo e($settings->currency->currency_symbol.$totalAmount); ?>

                                    </span>
                                    </li>
                                </ul>
                            </div>
                            <?php if($user): ?>
                                <div class="instruction">
                                    <h5><?php echo app('translator')->getFromJson('front.additionalNotes'); ?></h5>
                                    <form id="booking" class="ajax-form" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="form-group">
                                            <textarea class="form-control" rows="4" name="additional_notes" placeholder="<?php echo app('translator')->getFromJson('front.writeYourMessageHere'); ?>"></textarea>
                                        </div>
                                    </form>
                                </div>
                            <?php elseif($smsSettings->nexmo_status == 'deactive'): ?>
                                <div class="instruction">
                                    <h5><?php echo app('translator')->getFromJson('front.additionalNotes'); ?></h5>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="4" name="additional_notes" placeholder="<?php echo app('translator')->getFromJson('front.writeYourMessageHere'); ?>" form="personal-details"></textarea>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-right">
                        <div class="navigation">
                            <a href="<?php echo e(route('front.cartPage')); ?>" class="btn btn-custom btn-dark"><i class="fa fa-angle-left mr-2"></i><?php echo app('translator')->getFromJson('front.navigation.goBack'); ?></a>
                            <?php if(!$user): ?>
                                <?php if($smsSettings->nexmo_status == 'active'): ?>
                                    <a href="javascript:;" onclick="saveUser();" class="btn btn-custom btn-dark">
                                        <?php echo app('translator')->getFromJson('front.navigation.toVerifyMobile'); ?>
                                        <i class="fa fa-angle-right ml-1"></i>
                                    </a>
                                <?php else: ?>
                                    <a href="javascript:;" onclick="saveUser();" class="btn btn-custom btn-dark">
                                        <?php echo app('translator')->getFromJson('front.navigation.toPayment'); ?>
                                        <i class="fa fa-angle-right ml-1"></i>
                                    </a>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if($smsSettings->nexmo_status == 'active'): ?>
                                <a href="javascript:;" onclick="saveBooking();" class="btn btn-custom btn-dark <?php if(!$user->mobile_verified): ?> disabled <?php endif; ?>">
                                    <?php echo app('translator')->getFromJson('front.navigation.toPayment'); ?>
                                    <i class="fa fa-angle-right ml-1"></i>
                                </a>
                                <?php else: ?>
                                    <a href="javascript:;" onclick="saveBooking();" class="btn btn-custom btn-dark">
                                        <?php echo app('translator')->getFromJson('front.navigation.toPayment'); ?>
                                        <i class="fa fa-angle-right ml-1"></i>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>
    <script src="<?php echo e(asset('assets/js/select2.min.js')); ?>"></script>
    <script>
        $('.select2').select2();

        function saveUser() {
            var url =  '<?php echo e(route('front.saveBooking')); ?>';
            var form = $('#personal-details');

            $.easyAjax({
                url: url,
                type: 'POST',
                container: '#personal-details',
                data: form.serialize()
            })
        }

        function saveBooking() {
            $.easyAjax({
                url: '<?php echo e(route('front.saveBooking')); ?>',
                type: 'POST',
                container: '#booking',
                data: $('#booking').serialize()
            })
        }
    </script>
    <script>
        <?php if($smsSettings->nexmo_status == 'active' && $user && !$user->mobile_verified && !session()->has('verify:request_id')): ?>
            sendOTPRequest();
        <?php endif; ?>

        var x = '';

        function clearLocalStorage() {
            localStorage.removeItem('otp_expiry');
            localStorage.removeItem('otp_attempts');
        }

        function checkSessionAndRemove() {
            $.easyAjax({
                url: '<?php echo e(route('removeSession')); ?>',
                type: 'GET',
                data: {'sessions': ['verify:request_id']}
            })
        }

        function startCounter(deadline) {
            x = setInterval(function() {
                var now = new Date().getTime();
                var t = deadline - now;

                var days = Math.floor(t / (1000 * 60 * 60 * 24));
                var hours = Math.floor((t%(1000 * 60 * 60 * 24))/(1000 * 60 * 60));
                var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((t % (1000 * 60)) / 1000);

                $('#demo').html('Time Left: '+minutes + ":" + seconds);
                $('.attempts_left').html(`${localStorage.getItem('otp_attempts')} attempts left`);

                if (t <= 0) {
                    clearInterval(x);
                    clearLocalStorage();
                    checkSessionAndRemove();
                    location.href = '<?php echo e(route('front.cartPage')); ?>'
                }
            }, 1000);
        }

        if (localStorage.getItem('otp_expiry') !== null) {
            let localExpiryTime = localStorage.getItem('otp_expiry');
            let now = new Date().getTime();

            if (localExpiryTime - now < 0) {
                clearLocalStorage();
                checkSessionAndRemove();
            }
            else {
                $('#otp').focus().select();
                startCounter(localStorage.getItem('otp_expiry'));
            }
        }

        function sendOTPRequest() {
            $.easyAjax({
                url: '<?php echo e(route('sendOtpCode')); ?>',
                type: 'POST',
                container: '#request-otp-form',
                messagePosition: 'inline',
                data: $('#request-otp-form').serialize(),
                success: function (response) {
                    if (response.status == 'success') {
                        localStorage.setItem('otp_attempts', 3);

                        $('#verify-mobile').html(response.view);
                        $('.attempts_left').html(`3 attempts left`);

                        $('#otp').focus();

                        var now = new Date().getTime();
                        var deadline = new Date(now + parseInt('<?php echo e(config('nexmo.settings.pin_expiry')); ?>')*1000).getTime();

                        localStorage.setItem('otp_expiry', deadline);
                        startCounter(deadline);
                        // intialize countdown
                    }
                    if (response.status == 'fail') {
                        $('#mobile').focus();
                    }
                }
            });
        }

        function sendVerifyRequest() {
            $.easyAjax({
                url: '<?php echo e(route('verifyOtpCode')); ?>',
                type: 'POST',
                container: '#verify-otp-form',
                messagePosition: 'inline',
                data: $('#verify-otp-form').serialize(),
                success: function (response) {
                    if (response.status == 'success') {
                        clearLocalStorage();

                        location.reload();
                        $('#verify-mobile-info').html('');

                        // select2 reinitialize
                        $('.select2').select2();
                    }
                    if (response.status == 'fail') {
                        // show number of attempts left
                        let currentAttempts = localStorage.getItem('otp_attempts');

                        if (currentAttempts == 1) {
                            clearLocalStorage();
                        }
                        else {
                            currentAttempts -= 1;

                            $('.attempts_left').html(`${currentAttempts} attempts left`);
                            $('#otp').focus().select();
                            localStorage.setItem('otp_attempts', currentAttempts);
                        }

                        if (Object.keys(response.data).length > 0) {
                            $('#verify-mobile').html(response.data.view);

                            // select2 reinitialize
                            $('.select2').select2();

                            clearInterval(x);
                        }
                    }
                }
            });
        }

        $('body').on('submit', '#request-otp-form', function (e) {
            e.preventDefault();
            sendOTPRequest();
        })

        $('body').on('click', '#request-otp', function () {
            sendOTPRequest();
        })

        $('body').on('submit', '#verify-otp-form', function (e) {
            e.preventDefault();
            sendVerifyRequest();
        })

        $('body').on('click', '#verify-otp', function() {
            sendVerifyRequest();
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\booking\resources\views/front/checkout_page.blade.php ENDPATH**/ ?>