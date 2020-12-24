@extends('layouts.front')

@push('styles')
    <style>
        .no-services{
            border: 1px solid #f7d8dd;
            background-color: #fbeeed;
            color: #d9534f;
            padding: 20px 0;
        }
    </style>
@endpush

@section('content')
    <section class="section">
        <section class="listings sp-80 bg-w">
            <div class="container">
                @if($services->count() > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="all-title">
                            <p> @lang('front.servicesTitle') </p>
                            <h3 class="sec-title">
                                @lang('front.services')
                            </h3>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row">
                    @forelse ($services as $item)
                        <div class="col-lg-4 col-md-6 col-12 mb-30 services-list service-category-{{ $item->category_id }}">
                            <div class="listing-item">
                                <div class="img-holder">
                                    <img src="{{ $item->image ? asset('user-uploads/service/'.$item->image) : asset('assets/img/pl-slide1.jpg') }}" alt="list">
                                    <div class="category-name">
                                        <i class="flaticon-fork mr-1"></i>{{ ucwords($item->category->name) }}
                                    </div>
                                    <div class="time-remaining">
                                        <i class="fa fa-clock-o mr-2"></i>
                                        <span data-service="{{ $item }}"></span>
                                    </div>
                                </div>
                                <div class="list-content">
                                    <h5 class="mb-2">
                                        <a href="{{ $item->service_detail_url }}">{{ ucwords($item->name) }}</a>
                                    </h5>
                                    <ul class="ctg-info centering h-center v-center">
                                        <li class="mt-1">
                                            <div class="service-price">
                                                <span class="unit">{{ $settings->currency->currency_symbol }}</span>{{ $item->discounted_price }}
                                            </div>
                                        </li>
                                        <li class="mt-1">
                                            <div class="dropdown add-items">
                                                <a href="javascript:;" class="btn-custom btn-blue dropdown-toggle add-to-cart"
                                                        data-service-price="{{ $item->discounted_price }}"
                                                        data-service-id="{{ $item->id }}"
                                                        data-service-name="{{ ucwords($item->name) }}"
                                                        aria-expanded="false">
                                                    @lang('app.add')
                                                    <span class="fa fa-plus"></span>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center mb-5">
                            <h3 class="no-services">
                                <i class="fa fa-exclamation-triangle"></i> @lang('front.noSearchRecordFound')</h3>
                        </div>
                    @endforelse
                    {{--<div class="row">--}}
                        <div class="col-12 text-right">
                            <div class="navigation">
                                <a href="{{ route('front.index') }}" class="btn btn-custom btn-dark"><i class="fa fa-angle-left mr-2"></i>@lang('front.navigation.goBack')</a>
                                @if ($services->count() > 0)
                                    <a href="javascript:;" onclick="goToPage('GET', '{{ route('front.bookingPage') }}')" class="btn btn-custom btn-dark">@lang('front.selectBookingTime') <i class="fa fa-angle-right ml-1"></i> </a>
                                @endif
                            </div>
                        </div>
                    {{--</div>--}}
                </div>
            </div>
        </section>
    </section>

@endsection

@push('footer-script')
    <script>
        $(function () {
            $('.time-remaining span').each(function () {
                var service = $(this).data('service');
                var html = service.time.toString()+' '+makeSingular(service.time, service.time_type);
                $(this).html(html);
            })
        })
        // add items to cart
        $(".add-to-cart").click(function () {
            let serviceId = $(this).data('service-id');
            let servicePrice = $(this).data('service-price');
            let serviceName = $(this).data('service-name');

            var data = {serviceId, servicePrice, serviceName, '_token': $("meta[name='csrf-token']").attr('content')};

            $.easyAjax({
                url: '{{ route('front.addOrUpdateProduct') }}',
                type: 'POST',
                data: data,
                success: function (response) {
                    $('.cart-badge').text(response.productsCount);
                }
            })
        });
    </script>
@endpush
