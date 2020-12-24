<div class="row">
    <div class="col-md-12 text-right mt-2 mb-2">
        <?php if($user->can('update_booking')): ?>
        <button class="btn btn-sm btn-outline-primary edit-booking" data-booking-id="<?php echo e($booking->id); ?>" type="button"><i class="fa fa-edit"></i> <?php echo app('translator')->getFromJson('app.edit'); ?></button>
        <?php endif; ?>
        <?php if($user->roles()->withoutGlobalScopes()->first()->hasPermission('delete_booking')): ?>
        <button class="btn btn-sm btn-outline-danger delete-row" data-row-id="<?php echo e($booking->id); ?>" type="button"><i class="fa fa-times"></i> <?php echo app('translator')->getFromJson('app.delete'); ?> <?php echo app('translator')->getFromJson('app.booking'); ?></button>
        <?php endif; ?>
        <?php if($booking->status == 'pending'): ?>
            <?php if($user->roles()->withoutGlobalScopes()->first()->hasPermission('create_booking')): ?>
            <a href="javascript:;" data-booking-id="<?php echo e($booking->id); ?>" class="btn btn-outline-dark btn-sm send-reminder"><i class="fa fa-send"></i> <?php echo app('translator')->getFromJson('modules.booking.sendReminder'); ?></a>
            <?php endif; ?>
            <?php if($user->roles()->withoutGlobalScopes()->first()->hasPermission('update_booking')): ?>
            <button class="btn btn-sm btn-outline-danger cancel-row" data-row-id="<?php echo e($booking->id); ?>" type="button"><i class="fa fa-times"></i> <?php echo app('translator')->getFromJson('modules.booking.requestCancellation'); ?></button>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="col-md-12 text-center mb-3">
        <img src="<?php echo e($booking->user->user_image_url); ?>" class="border img-bordered-sm img-size-100 img-circle">
        <h6 class="text-uppercase mt-2"><?php echo e(ucwords($booking->user->name)); ?></h6>
    </div>

</div>

<div class="row">
    <div class="col-md-6 border-right"> <strong><?php echo app('translator')->getFromJson('app.email'); ?></strong> <br>
        <p class="text-muted"><i class="icon-email"></i> <?php echo e($booking->user->email ?? '--'); ?></p>
    </div>
    <div class="col-md-6"> <strong><?php echo app('translator')->getFromJson('app.mobile'); ?></strong> <br>
        <p class="text-muted"><i class="icon-mobile"></i> <?php echo e($booking->user->mobile ? $booking->user->formatted_mobile : '--'); ?></p>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-4 border-right"> <strong><?php echo app('translator')->getFromJson('app.booking'); ?> <?php echo app('translator')->getFromJson('app.date'); ?></strong> <br>
        <p class="text-primary"><i class="icon-calendar"></i> <?php echo e($booking->date_time->format($settings->date_format)); ?></p>
    </div>
    <div class="col-sm-4 border-right"> <strong><?php echo app('translator')->getFromJson('app.booking'); ?> <?php echo app('translator')->getFromJson('app.time'); ?></strong> <br>
        <p class="text-primary"><i class="icon-alarm-clock"></i> <?php echo e($booking->date_time->format($settings->time_format)); ?> </p>
    </div>
    <div class="col-sm-4"> <strong><?php echo app('translator')->getFromJson('app.booking'); ?> <?php echo app('translator')->getFromJson('app.status'); ?></strong> <br>
        <span class="text-uppercase small border
        <?php if($booking->status == 'completed'): ?> border-success text-success <?php endif; ?>
        <?php if($booking->status == 'pending'): ?> border-warning text-warning <?php endif; ?>
        <?php if($booking->status == 'approved'): ?> border-info text-info <?php endif; ?>
        <?php if($booking->status == 'in progress'): ?> border-primary text-primary <?php endif; ?>
        <?php if($booking->status == 'canceled'): ?> border-danger text-danger <?php endif; ?>
         badge-pill"><?php echo e($booking->status); ?></span>
    </div>
</div>
<hr>
<?php if($booking->employee_id): ?>
<div class="row">
    <div class="col-sm-4"> <strong><?php echo app('translator')->getFromJson('menu.employee'); ?> </strong> <br>
        <p class="text-primary"><i class="icon-user"></i> <?php echo e($booking->employee->name); ?></p>
    </div>
</div>
<hr>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed">
            <thead class="bg-secondary">
            <tr>
                <th>#</th>
                <th><?php echo app('translator')->getFromJson('app.item'); ?></th>
                <th><?php echo app('translator')->getFromJson('app.unitPrice'); ?></th>
                <th><?php echo app('translator')->getFromJson('app.quantity'); ?></th>
                <th class="text-right"><?php echo app('translator')->getFromJson('app.amount'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $booking->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key+1); ?>.</td>
                    <td><?php echo e(ucwords($item->businessService->name)); ?></td>
                    <td><?php echo e($settings->currency->currency_symbol.number_format((float)$item->unit_price, 2, '.', '')); ?></td>
                    <td>x<?php echo e($item->quantity); ?></td>
                    <td class="text-right"><?php echo e($settings->currency->currency_symbol.number_format((float)($item->businessService->discounted_price  * $item->quantity), 2, '.', '')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>

        </table>
    </div>
    <div class="col-md-7 border-top">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-condensed">
                    <tr class="h6">
                        <td class="border-top-0"><?php echo app('translator')->getFromJson('modules.booking.paymentMethod'); ?></td>
                        <td class="border-top-0 "><i class="fa fa-money"></i> <?php echo e($booking->payment_gateway); ?></td>
                    </tr>
                    <tr class="h6">
                        <td><?php echo app('translator')->getFromJson('modules.booking.paymentStatus'); ?></td>
                        <td>
                            <?php if($booking->payment_status == 'completed'): ?>
                                <span class="text-success  font-weight-normal"><i class="fa fa-check-circle"></i> <?php echo e(ucfirst($booking->payment_status)); ?></span></td>
                            <?php endif; ?>
                            <?php if($booking->payment_status == 'pending'): ?>
                                <span class="text-warning font-weight-normal"><i class="fa fa-times-circle"></i> <?php echo e(ucfirst($booking->payment_status)); ?></span></td>
                            <?php endif; ?>
                    </tr>

                    <?php if($booking->payment_status == 'pending' && !$user->is_admin && !$user->is_employee): ?>
                    <tr>
                        <td colspan="2">
                            <div class="payment-type">
                                <h5><?php echo app('translator')->getFromJson('front.paymentMethod'); ?></h5>
                                <div class="payments text-center">
                                    <?php if($credentials->stripe_status == 'active'): ?>
                                    <a href="javascript:;" id="stripePaymentButton" data-bookingId="<?php echo e($booking->id); ?>" class="btn btn-custom btn-blue mb-2"><i class="fa fa-cc-stripe mr-2"></i><?php echo app('translator')->getFromJson('front.buttons.stripe'); ?></a>
                                    <?php endif; ?>
                                    <?php if($credentials->paypal_status == 'active'): ?>
                                    <a href="<?php echo e(route('front.paypal', $booking->id)); ?>" class="btn btn-custom btn-blue mb-2"><i class="fa fa-paypal mr-2"></i><?php echo app('translator')->getFromJson('front.buttons.paypal'); ?></a>
                                    <?php endif; ?>
                                    <?php if($credentials->razorpay_status == 'active'): ?>
                                    <a href="javascript:startRazorPayPayment();" class="btn btn-custom btn-blue mb-2"><i class="fa fa-card mr-2"></i><?php echo app('translator')->getFromJson('front.buttons.razorpay'); ?></a>
                                    <?php endif; ?>
                                    <?php if($credentials->offline_payment == 1): ?>
                                    <a href="<?php echo e(route('front.offline-payment', $booking->id)); ?>" class="btn btn-custom btn-blue mb-2"><i class="fa fa-money mr-2"></i><?php echo app('translator')->getFromJson('app.offline'); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <?php if($booking->status == 'completed'): ?>
                    <tr>
                        <td>
                            <a href="<?php echo e(route('admin.bookings.download', $booking->id)); ?>" class="btn btn-success btn-sm"><i class="fa fa-download"></i> <?php echo app('translator')->getFromJson('app.download'); ?> <?php echo app('translator')->getFromJson('app.receipt'); ?></a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-5 border-top">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-condensed">
                    <tr class="h6">
                        <td class="border-top-0 text-right"><?php echo app('translator')->getFromJson('app.subTotal'); ?></td>
                        <td class="border-top-0"><?php echo e($settings->currency->currency_symbol.number_format((float)$booking->original_amount, 2, '.', '')); ?></td>
                    </tr>
                    <?php if($booking->discount > 0): ?>
                    <tr class="h6">
                        <td class="text-right"><?php echo app('translator')->getFromJson('app.discount'); ?></td>
                        <td><?php echo e($settings->currency->currency_symbol.number_format((float)$booking->discount, 2, '.', '')); ?></td>
                    </tr>
                    <?php endif; ?>


                    <?php if($booking->tax_amount > 0): ?>
                    <tr class="h6">
                        <td class="text-right"><?php echo e($booking->tax_name.' ('.$booking->tax_percent.'%)'); ?></td>
                        <td><?php echo e($settings->currency->currency_symbol.number_format((float)$booking->tax_amount, 2, '.', '')); ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr class="h5">
                        <td class="text-right"><?php echo app('translator')->getFromJson('app.total'); ?></td>
                        <td><?php echo e($settings->currency->currency_symbol.number_format((float)$booking->amount_to_pay, 2, '.', '')); ?></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>

    <?php if(!is_null($booking->additional_notes)): ?>
    <div class="col-md-12 font-italic">
        <h4 class="text-info"><?php echo app('translator')->getFromJson('modules.booking.customerMessage'); ?></h4>
        <p class="text-lg">
            <?php echo $booking->additional_notes; ?>

        </p>
    </div>
    <?php endif; ?>

</div>

<?php if($credentials->stripe_status == 'active' && $booking->payment_status == 'pending' && !$user->is_admin): ?>
    <script>
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
                    url: '<?php echo e(route('front.stripe', $booking->id)); ?>',
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
    </script>
<?php endif; ?>

<?php if($credentials->razorpay_status == 'active' && $booking->payment_status == 'pending' && !$user->is_admin): ?>
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
                container: 'body',
                redirect: true
            });
        }
    </script>
<?php endif; ?>
<?php /**PATH E:\laragon\www\booking\resources\views/admin/booking/show.blade.php ENDPATH**/ ?>