@extends('layouts.front')

@section('content')
    <section class="section">
        <section class="cart-area sp-80">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="all-title">
                            <h3 class="sec-title">
                                @lang('front.headings.bookingDetails')
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
                                    <th>@lang('front.table.headings.serviceName')</th>
                                    <th>@lang('front.table.headings.unitPrice')</th>
                                    <th>@lang('front.table.headings.quantity')</th>
                                    <th>@lang('front.table.headings.subTotal')</th>
                                    @if (!is_null($products))
                                        <th>&nbsp;</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                    @if (!is_null($products))
                                        @foreach($products as $key => $product)
                                            <tr id="{{ $key }}">
                                                <td>{{ $product['serviceName'] }}</td>
                                                <td>{{ $settings->currency->currency_symbol.$product['servicePrice'] }}</td>
                                                <td>
                                                    <div class="qty-wrap">
                                                        <div class="qty-elements">
                                                            <a class="decrement_qty" href="javascript:void(0)" onclick="decreaseQuantity(this)">-</a>
                                                        </div>
                                                        <input name="qty" value="{{ $product['serviceQuantity'] }}" title="Quantity"
                                                            class="input-text qty" data-id="{{ $key }}" data-price="{{$product['servicePrice']}}" autocomplete="none" />
                                                        <div class="qty-elements">
                                                            <a class="increment_qty" href="javascript:void(0)" onclick="increaseQuantity(this)">+</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="sub-total">{{ $settings->currency->currency_symbol }}<span>{{ $product['serviceQuantity'] * $product['servicePrice'] }}</span></td>
                                                <td>
                                                    <a title="@lang('front.table.deleteProduct')" href="javascript:;" onclick="deleteProduct(this, '{{ $key }}')" class="delete-btn">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center text-danger">Cart is empty. Please add some products to continue.</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="cart-buttons">
                                            <li>
                                            </li>
                                            <li>
                                                <a href="{{ route('front.index') }}" class="btn btn-custom btn-blue">@lang('front.buttons.continueBooking')</a>
                                                @if (!is_null($products))
                                                    <a href="javascript:;" onclick="deleteProduct(this, 'all')" class="btn btn-custom btn-blue">@lang('front.buttons.clearCart')</a>
                                                @endif
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
                                <h5>@lang('front.summary.cart.heading.cartTotal')</h5>
                                <div class="cart-value">
                                    <ul>
                                        <li>
                                            <span>
                                                @lang('front.summary.cart.subTotal')
                                            </span>
                                            <span id="sub-total">
                                            </span>
                                        </li>
                                        @if(!is_null($tax))
                                            <li>
                                                <span>
                                                    {{ $tax->tax_name }} ({{ $tax->percent }}%):
                                                </span>
                                                <span id="tax">
                                                </span>
                                            </li>
                                        @endif
                                        <li>
                                            <span>
                                                @lang('front.summary.cart.totalAmount'):
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
                @if (!is_null($products))
                    <div class="row">
                        <div class="col-12 text-right">
                            <div class="navigation">
                                <a href="{{ route('front.bookingPage') }}" class="btn btn-custom btn-dark"><i class="fa fa-angle-left mr-2"></i>@lang('front.navigation.goBack')</a>
                                <a href="{{ route('front.checkoutPage') }}" class="btn btn-custom btn-dark">
                                    {{ !is_null($bookingDetails) ? __('front.navigation.toCheckout') : __('front.selectBookingTime') }}
                                    <i class="fa fa-angle-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </section>
@endsection

@push('footer-script')
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

            $('#sub-total').text('{{ $settings->currency->currency_symbol }}'+cartTotal.toFixed(2));

            // calculate and display tax
            @if(!is_null($tax))
                let taxPercent = parseFloat('{{ $tax->percent }}');
                tax = (taxPercent * cartTotal)/100;

                $('#tax').text('{{ $settings->currency->currency_symbol }}'+tax.toFixed(2));
            @endif

            totalAmount = cartTotal + tax;

            $('#total').text('{{ $settings->currency->currency_symbol }}'+totalAmount.toFixed(2));
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
            var url = '{{ route('front.deleteProduct', ':id') }}';
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
            let products = {!! json_encode($products) !!};
            let data = {};
            $('input.qty').each(function () {
                const serviceId = $(this).data('id');
                products[serviceId].serviceQuantity = parseInt($(this).val());
            });
            data.products = products;
            data._token = '{{ csrf_token() }}';

            $.easyAjax({
                url: '{{ route('front.updateCart') }}',
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
@endpush
