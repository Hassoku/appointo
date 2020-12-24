<?php $__env->startSection('content'); ?>
    <section class="section">
        <section class="cart-area sp-80">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="all-title">
                            <h3 class="sec-title">
                                <?php echo app('translator')->getFromJson('front.headings.bookingDetails'); ?>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-12 mb-30">
                        <div class="shopping-cart-table">
                            <table class="table table-responsive-md">
                                <thead>
                                <tr>
                                    <th><?php echo app('translator')->getFromJson('front.table.headings.serviceName'); ?></th>
                                    <th><?php echo app('translator')->getFromJson('front.table.headings.unitPrice'); ?></th>
                                    <th><?php echo app('translator')->getFromJson('front.table.headings.quantity'); ?></th>
                                    <th><?php echo app('translator')->getFromJson('front.table.headings.subTotal'); ?></th>
                                    <?php if(!is_null($products)): ?>
                                        <th>&nbsp;</th>
                                    <?php endif; ?>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php if(!is_null($products)): ?>
                                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr id="<?php echo e($key); ?>">
                                                <td><?php echo e($product['serviceName']); ?></td>
                                                <td><?php echo e($settings->currency->currency_symbol.$product['servicePrice']); ?></td>
                                                <td>
                                                    <div class="qty-wrap">
                                                        <div class="qty-elements">
                                                            <a class="decrement_qty" href="javascript:void(0)" onclick="decreaseQuantity(this)">-</a>
                                                        </div>
                                                        <input name="qty" value="<?php echo e($product['serviceQuantity']); ?>" title="Quantity"
                                                            class="input-text qty" data-id="<?php echo e($key); ?>" data-price="<?php echo e($product['servicePrice']); ?>" autocomplete="none" />
                                                        <div class="qty-elements">
                                                            <a class="increment_qty" href="javascript:void(0)" onclick="increaseQuantity(this)">+</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="sub-total"><?php echo e($settings->currency->currency_symbol); ?><span><?php echo e($product['serviceQuantity'] * $product['servicePrice']); ?></span></td>
                                                <td>
                                                    <a title="<?php echo app('translator')->getFromJson('front.table.deleteProduct'); ?>" href="javascript:;" onclick="deleteProduct(this, '<?php echo e($key); ?>')" class="delete-btn">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-danger">Cart is empty. Please add some products to continue.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="cart-buttons">
                                            <li>
                                            </li>
                                            <li>
                                                <a href="<?php echo e(route('front.index')); ?>" class="btn btn-custom btn-blue"><?php echo app('translator')->getFromJson('front.buttons.continueBooking'); ?></a>
                                                <?php if(!is_null($products)): ?>
                                                    <a href="javascript:;" onclick="deleteProduct(this, 'all')" class="btn btn-custom btn-blue"><?php echo app('translator')->getFromJson('front.buttons.clearCart'); ?></a>
                                                <?php endif; ?>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 mb-30">
                        <div class="cart-block">
                            <div class="final-cart">
                                <h5><?php echo app('translator')->getFromJson('front.summary.cart.heading.cartTotal'); ?></h5>
                                <div class="cart-value">
                                    <ul>
                                        <li>
                                            <span>
                                                <?php echo app('translator')->getFromJson('front.summary.cart.subTotal'); ?>
                                            </span>
                                            <span id="sub-total">
                                            </span>
                                        </li>
                                        <?php if(!is_null($tax)): ?>
                                            <li>
                                                <span>
                                                    <?php echo e($tax->tax_name); ?> (<?php echo e($tax->percent); ?>%):
                                                </span>
                                                <span id="tax">
                                                </span>
                                            </li>
                                        <?php endif; ?>
                                        <li>
                                            <span>
                                                <?php echo app('translator')->getFromJson('front.summary.cart.totalAmount'); ?>:
                                            </span>
                                            <span id="total">
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(!is_null($products)): ?>
                    <div class="row">
                        <div class="col-12 text-right">
                            <div class="navigation">
                                <a href="<?php echo e(route('front.bookingPage')); ?>" class="btn btn-custom btn-dark"><i class="fa fa-angle-left mr-2"></i><?php echo app('translator')->getFromJson('front.navigation.goBack'); ?></a>
                                <a href="<?php echo e(route('front.checkoutPage')); ?>" class="btn btn-custom btn-dark">
                                    <?php echo e(!is_null($bookingDetails) ? __('front.navigation.toCheckout') : __('front.selectBookingTime')); ?>

                                    <i class="fa fa-angle-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>
    <script>
        $(function () {
            calculateTotal();
        });

        var cartUpdate;

        function calculateTotal() {
            let cartTotal = tax = totalAmount = 0.00;

            $('.sub-total>span').each(function () {
                cartTotal += parseFloat($(this).text());
            });

            $('#sub-total').text('<?php echo e($settings->currency->currency_symbol); ?>'+cartTotal.toFixed(2));

            // calculate and display tax
            <?php if(!is_null($tax)): ?>
                let taxPercent = parseFloat('<?php echo e($tax->percent); ?>');
                tax = (taxPercent * cartTotal)/100;

                $('#tax').text('<?php echo e($settings->currency->currency_symbol); ?>'+tax.toFixed(2));
            <?php endif; ?>

            totalAmount = cartTotal + tax;

            $('#total').text('<?php echo e($settings->currency->currency_symbol); ?>'+totalAmount.toFixed(2));
        }

        function increaseQuantity(ele) {
            var input = $(ele).parent().siblings('input');
            var currentValue = input.val();

            input.val(parseInt(currentValue) + 1);
            input.trigger('keyup');
        }

        function decreaseQuantity(ele) {
            var input = $(ele).parent().siblings('input');
            var currentValue = input.val();

            if (currentValue > 1) {
                input.val(parseInt(currentValue) - 1);
                input.trigger('keyup');
            }
        }

        function deleteProduct(ele, key) {
            var url = '<?php echo e(route('front.deleteProduct', ':id')); ?>';
            url = url.replace(':id', key);

            $.easyAjax({
                url: url,
                type: 'POST',
                data: {_token: $("meta[name='csrf-token']").attr('content')},
                redirect: false,
                success: function (response) {
                    if (response.status == 'success') {
                        if (response.action == "redirect") {
                            var message = "";
                            if (typeof response.message != "undefined") {
                                message += response.message;
                            }

                            $.showToastr(message, "success", {
                                positionClass: "toast-top-right"
                            });

                            setTimeout(function () {
                                window.location.href = response.url;
                            }, 1000);
                        }
                        else {
                            $(ele).parents(`tr#${key}`).remove();
                            calculateTotal();
                            $('.cart-badge').text(response.productsCount);
                        }
                    }
                }
            })
        }

        function updateCart() {
            let products = <?php echo json_encode($products); ?>;
            let data = {};
            $('input.qty').each(function () {
                const serviceId = $(this).data('id');
                products[serviceId].serviceQuantity = parseInt($(this).val());
            });
            data.products = products;
            data._token = '<?php echo e(csrf_token()); ?>';

            $.easyAjax({
                url: '<?php echo e(route('front.updateCart')); ?>',
                type: 'POST',
                data: data
            })

        }

        $('input.qty').on('keyup', function () {
            const id = $(this).data('id');
            const price = $(this).data('price');
            const quantity = $(this).val();
            let subTotal = 0;

            clearTimeout(cartUpdate);

            if (quantity == '') {
                subTotal = price * 1;
            }
            else {
                subTotal = price * quantity;
            }

            $(`tr#${id}`).find('.sub-total>span').text(subTotal.toFixed(2));
            calculateTotal();

            cartUpdate = setTimeout(() => {
                updateCart();
            }, 500);
        });

        $('input.qty').on('blur', function () {
            if ($(this).val() == '' || $(this).val() == 0) {
                $(this).val(1);
            }
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\booking\resources\views/front/cart_page.blade.php ENDPATH**/ ?>