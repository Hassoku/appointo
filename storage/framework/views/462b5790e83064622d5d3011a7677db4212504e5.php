<?php $__env->startSection('content'); ?>
    <section class="section">
        <section class="sp-80 bg-w">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="all-title">
                            <h3 class="sec-title">
                                <?php echo app('translator')->getFromJson('front.headings.payment'); ?>
                            </h3>
                        </div>
                    </div>
                </div>
                <div id="invoice_container" class="billing-info payment-box">
                    <div class="booking-summary mb-60">
                        <h5><?php echo app('translator')->getFromJson('front.summary.checkout.heading.bookingSummary'); ?></h5>
                        <ul>
                            <li>
                            <span>
                                <?php echo app('translator')->getFromJson('front.bookingDate'); ?>:
                            </span>
                                <span>
                                <?php echo e($booking->date_time->format('l, F jS')); ?>

                            </span>
                            </li>
                            <li>
                            <span>
                                <?php echo app('translator')->getFromJson('front.bookingTime'); ?>:
                            </span>
                                <span>
                                <?php echo e($booking->date_time->format($settings->time_format)); ?>

                            </span>
                            </li>
                            <li>
                            <span>
                                <?php echo app('translator')->getFromJson('front.amountToPay'); ?>:
                            </span>
                                <span>
                                <?php echo e($settings->currency->currency_symbol.$booking->amount_to_pay); ?>

                            </span>
                            </li>
                        </ul>
                    </div>
                    <div class="payment-type">
                        <h5><?php echo app('translator')->getFromJson('front.paymentMethod'); ?></h5>
                        <div class="payments">
                            <?php if($credentials->stripe_status == 'active' && $booking->amount_to_pay > 0): ?>
                            <a href="javascript:;" id="stripePaymentButton" class="btn btn-custom btn-blue"><i class="fa fa-cc-stripe mr-2"></i><?php echo app('translator')->getFromJson('front.buttons.stripe'); ?></a>
                            <?php endif; ?>
                            <?php if($credentials->paypal_status == 'active' && $booking->amount_to_pay > 0): ?>
                            <a href="<?php echo e(route('front.paypal')); ?>" class="btn btn-custom btn-blue"><i class="fa fa-paypal mr-2"></i><?php echo app('translator')->getFromJson('front.buttons.paypal'); ?></a>
                            <?php endif; ?>
                            <?php if($credentials->razorpay_status == 'active' && $booking->amount_to_pay > 0): ?>
                            <a href="javascript:startRazorPayPayment();" class="btn btn-custom btn-blue"><i class="fa fa-credit-card mr-2"></i><?php echo app('translator')->getFromJson('front.buttons.razorpay'); ?></a>
                            <?php endif; ?>
                            <?php if($credentials->offline_payment == 1): ?>
                            <a href="<?php echo e(route('front.offline-payment')); ?>" class="btn btn-custom btn-blue"><i class="fa fa-money mr-2"></i><?php echo app('translator')->getFromJson('front.buttons.offlinePayment'); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row mt-30">
                    <div class="col-12 text-center">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-custom">
                            <i class="fa fa-home mr-2"></i>
                            <?php echo app('translator')->getFromJson('front.navigation.toAccount'); ?></a>
                    </div>
                </div>
            </div>
        </section>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>
    <?php if($credentials->stripe_status == 'active'): ?>
        <script src="https://checkout.stripe.com/checkout.js"></script>
    <?php endif; ?>
    <?php if($credentials->razorpay_status == 'active'): ?>
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script>
            var options = {
                "key": "<?php echo e($credentials->razorpay_key); ?>", // Enter the Key ID generated from the Dashboard
                "amount": "<?php echo e($booking->amount_to_pay * 100); ?>", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise or INR 500.
                "currency": "INR",
                "name": "<?php echo e($booking->user->name); ?>",
                "description": "<?php echo app('translator')->getFromJson('app.booking'); ?> <?php echo app('translator')->getFromJson('front.headings.payment'); ?>",
                "image": "<?php echo e($settings->logo_url); ?>",
                "handler": function (response){
                    confirmRazorPayPayment(response.razorpay_payment_id, '<?php echo e($booking->id); ?>', response);
                },
                "prefill": {
                    "email": "<?php echo e($booking->user->email); ?>",
                    "contact": "<?php echo e($booking->user->mobile); ?>"
                },
                "notes": {
                    "booking_id": "<?php echo e($booking->id); ?>"
                },
                "theme": {
                    "color": "<?php echo e($frontThemeSetting->primary_color); ?>"
                }
            };
            var rzp1 = new Razorpay(options);

            function startRazorPayPayment() {
                rzp1.open();
            }

            function confirmRazorPayPayment(paymentId, bookingId, response) {
                $.easyAjax({
                    url: '<?php echo e(route('front.razorpay')); ?>',
                    type: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        payment_id: paymentId,
                        booking_id: bookingId,
                        response: response
                    },
                    container: '#invoice_container',
                    redirect: true
                });
            }
        </script>
    <?php endif; ?>
    <script>
        <?php if($credentials->stripe_status == 'active'): ?>
            var token_triggered = false;
            var handler = StripeCheckout.configure({
                key: '<?php echo e($credentials->stripe_client_id); ?>',
                image: '<?php echo e($settings->logo_url); ?>',
                locale: 'auto',
                closed: function(data) {
                    if (!token_triggered) {
                        $.easyUnblockUI('.statusSection');
                    } else {
                        $.easyBlockUI('.statusSection');
                    }
                },
                token: function(token) {
                    token_triggered = true;
                    // You can access the token ID with `token.id`.
                    // Get the token ID to your server-side code for use.
                    $.easyAjax({
                        url: '<?php echo e(route('front.stripe')); ?>',
                        container: '#invoice_container',
                        type: "POST",
                        redirect: true,
                        data: {token: token, "_token" : "<?php echo e(csrf_token()); ?>"}
                    })
                }
            });

            document.getElementById('stripePaymentButton').addEventListener('click', function(e) {
                // Open Checkout with further options:
                handler.open({
                    name: '<?php echo e($setting->company_name); ?>',
                    amount: <?php echo e($booking->amount_to_pay * 100); ?>,
                    currency: '<?php echo e($setting->currency->currency_code); ?>',
                    email: "<?php echo e($user->email); ?>"
                });
                $.easyBlockUI('.statusSection');
                e.preventDefault();
            });

            // Close Checkout on page navigation:
            window.addEventListener('popstate', function() {
                alert('hello');
                handler.close();
            });
        <?php endif; ?>
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\booking\resources\views/front/payment-gateway.blade.php ENDPATH**/ ?>