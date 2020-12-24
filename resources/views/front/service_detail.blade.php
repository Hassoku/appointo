@extends('layouts.front')

@section('content')
    <section class="section">
        <section class="service-detail sp-80">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>{{ $service->name }}</h4>
                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <div class="detail-image mb-30">
                            <img src="{{ $service->service_image_url }}" alt="service">
                        </div>
                        <div class="content">
                            {!! $service->description !!}
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 mb-60">
                        <div class="detail-info mb-5">
                            <ul>
                                <li>
                                    <span>
                                        @lang('app.service') @lang('app.name')
                                    </span>
                                    <span>
                                        {{ $service->name }}
                                    </span>
                                </li>
                                <li>
                                    <span>
                                        @lang('app.price')
                                    </span>
                                    <span>
                                        {{ $settings->currency->currency_symbol.' '.$service->price }}
                                    </span>
                                </li>
                                <li>
                                    <span>
                                        @lang('app.time')
                                    </span>
                                    <span>
                                        {{ $service->time }}  @lang('app.'.$service->time_type)
                                    </span>
                                </li>
                                <li>
                                    <span>
                                       @lang('app.discount')
                                    </span>
                                    <span>
                                        @switch($service->discount_type)
                                            @case('percent')
                                                {{ $service->discount.' %' }}
                                            @break
                                            @case('fixed')
                                                {{ $settings->currency->currency_symbol.' '.$service->discount }}
                                            @break
                                        @endswitch
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <ul class="add-qty">
                            <li>
                                <span class="text-capitalize mb-2 d-block">@lang('app.add') @lang('app.quantity')</span>
                                <div class="qty-wrap">
                                    <div class="qty-elements">
                                        <a class="decrement_qty" href="javascript:void(0)" onclick="decreaseQuantity(this)">-</a>
                                    </div>
                                    @php
                                        $product = current($reqProduct);
                                    @endphp
                                    <input name="qty" value="{{ sizeof($reqProduct) > 0 ? $product['serviceQuantity'] : 1 }}" size="4" title="Quantity" class="input-text qty" data-id="{{ $service->id }}" data-price="{{$product['servicePrice']}}" autocomplete="none" />
                                    <div class="qty-elements">
                                        <a class="increment_qty" href="javascript:void(0)" onclick="increaseQuantity(this)">+</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="update @if(sizeof($reqProduct) == 0) hide @endif">
                                    <div class="row">
                                        <div class="col-md mb-2">
                                            <a href="javascript:void(0)" class="btn btn-custom update-cart">@lang('front.buttons.updateCart')</a>
                                        </div>
                                        <div class="col-md">
                                            <a href="javascript:void(0)" onclick="deleteProduct(this)" class="btn btn-custom-danger">
                                                @lang('front.table.deleteProduct')
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="add @if(sizeof($reqProduct) > 0) hide @endif">
                                    <div class="row">
                                        <div class="col">
                                            <a href="javascript:void(0)" class="btn btn-custom add-to-cart">@lang('front.addItem')</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-right">
                        <div class="navigation mt-4">
                            <a href="{{ route('front.index') }}" class="btn btn-custom btn-dark">
                                <i class="fa fa-angle-left mr-2"></i>@lang('front.navigation.goBack')
                            </a>
                            <a href="javascript:;" class="btn btn-custom btn-dark" onclick="goToPage('GET', '{{ route('front.bookingPage') }}');">@lang('front.selectBookingTime') <i class="fa fa-angle-right ml-2"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

@endsection

@push('footer-script')
    <script>
        function increaseQuantity(ele) {
            var input = $(ele).parent().siblings('input');
            var currentValue = input.val();

            input.val(parseInt(currentValue) + 1);
        }

        function decreaseQuantity(ele) {
            var input = $(ele).parent().siblings('input');
            var currentValue = input.val();

            if (currentValue > 1) {
                input.val(parseInt(currentValue) - 1);
            }
        }

        $('input.qty').on('blur', function () {
            if ($(this).val() == '' || $(this).val() == 0) {
                $(this).val(1);
            }
        });

        function deleteProduct(ele) {
            let key = $('input.qty').data('id');

            var url = '{{ route('front.deleteFrontProduct', ':id') }}';
            url = url.replace(':id', key);

            $.easyAjax({
                url: url,
                type: 'POST',
                data: {_token: $("meta[name='csrf-token']").attr('content')},
                redirect: false,
                success: function (response) {
                    $('.cart-badge').text(response.productsCount);
                    $(ele).parents('.update').addClass('hide').siblings('.add').removeClass('hide')
                    $('input.qty').val(1);
                }
            })
        }

        // add items to cart
        $('body').on('click', '.add-to-cart, .update-cart', function () {
            let serviceId = '{{ $service->id }}';
            let servicePrice = '{{ $service->price }}';
            let serviceName = '{{ $service->name }}';
            let serviceQuantity = $('.qty').val();
            let $this = $(this);

            var data = {serviceId, servicePrice, serviceName, serviceQuantity, _token: $("meta[name='csrf-token']").attr('content')};

            $.easyAjax({
                url: '{{ route('front.addOrUpdateProduct') }}',
                type: 'POST',
                data: data,
                success: function (response) {
                    $('.cart-badge').text(response.productsCount);
                    let addButton = $this.parents('.add');

                    if (addButton.length > 0) {
                        addButton.addClass('hide').siblings('.update').removeClass('hide');
                    }
                }
            })
        });
    </script>
@endpush
