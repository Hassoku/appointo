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
        <div class="banner-area">
            <div id="banner-slider" class="carousel slide" data-ride="carousel">
                <ul class="carousel-indicators">
                    @php $count = 0 @endphp
                    @forelse($images as $image)
                        <li data-target="#banner-slider" data-slide-to="{{ $count }}" @if($count == 0) class="active" @endif></li>
                        @php $count++ @endphp
                    @empty
                        <li data-target="#banner-slider" data-slide-to="0" class="active"></li>
                        <li data-target="#banner-slider" data-slide-to="1"></li>
                        <li data-target="#banner-slider" data-slide-to="2"></li>
                        <li data-target="#banner-slider" data-slide-to="3"></li>
                    @endforelse
                </ul>
                <div class="carousel-inner">
                    @php $count = 0 @endphp
                    @forelse($images as $image)
                        <div class="carousel-item {{ $count == 0 ? 'active' : '' }}">
                            <a href="javascript:void(0);">
                                <img class="img-fluid" src="{{ asset('user-uploads/carousel-images/'.$image->file_name) }}" alt="carousel image">
                            </a>
                        </div>
                        @php $count++ @endphp
                    @empty
                        <div class="carousel-item active">
                            <a href="javascript:void(0);">
                                <img src="assets/img/banner.jpg" alt="Los Angeles">
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="javascript:void(0);">
                                <img src="assets/img/banner.jpg" alt="Chicago">
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="javascript:void(0);">
                                <img src="assets/img/banner.jpg" alt="Los Angeles">
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="javascript:void(0);">
                                <img src="assets/img/banner.jpg" alt="Chicago">
                            </a>
                        </div>

                    @endforelse

                </div>
                <div class="banner-controls">
                    <a class="carousel-control-prev" href="#banner-slider" data-slide="prev">
                        <span class="fa fa-angle-left"></span>
                    </a>
                    <a class="carousel-control-next" href="#banner-slider" data-slide="next">
                        <span class="fa fa-angle-right"></span>
                    </a>
                </div>
            </div>
        </div>

        <section class="categories sp-80-50 bg-dull">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="all-title">
                            <p>@lang('front.categoriesTitle')</p>
                            <h3 class="sec-title">
                                @lang('front.categories')
                            </h3>
                        </div>
                    </div>
                </div>
                <div id="categories" class="row justify-content-center">
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-30 categories-list">
                        <div class="ctg-item" style="background: var(--primary-color)">
                            <a href="javascript:;">
                                <div class="icon-box">
                                    <i class="flaticon-fork"></i>
                                </div>
                                <div class="content-box">
                                    <h5 class="mb-0">
                                        @lang('front.all')
                                    </h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    @foreach ($categories as $category)
                        @if($category->services->count() > 0)
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-30 categories-list" data-category-id="{{ $category->id }}">
                            <div class="ctg-item" style="background-image:url('{{ $category->category_image_url }}')">
                                <a href="javascript:;">
                                    <div class="icon-box">
                                        <i class="flaticon-fork"></i>
                                    </div>
                                    <div class="content-box">
                                        <h5 class="mb-0">
                                            {{ ucwords($category->name) }}
                                        </h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>

        <section class="listings sp-80 bg-w">
            <div class="container">
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
                <div id="services" class="row">
                    @foreach ($services as $service)
                        <div class="col-lg-3 col-md-6 col-12 mb-30 services-list service-category-{{ $service->category_id }}">
                            <div class="listing-item">
                                <div class="img-holder" style="background-image: url('{{ $service->service_image_url }}')">
                                    <div class="category-name">
                                        <i class="flaticon-fork mr-1"></i>{{ ucwords($service->category->name) }}
                                    </div>
                                </div>
                                <div class="list-content">
                                    <h5 class="mb-2">
                                        <a href="{{ $service->service_detail_url }}">{{ ucwords($service->name) }}</a>
                                    </h5>
                                    <ul class="ctg-info centering h-center v-center">
                                        <li class="mt-1">
                                            <div class="service-price">
                                                <span class="unit">{{ $settings->currency->currency_symbol }}</span>{{ $service->discounted_price }}
                                            </div>
                                        </li>
                                        <li class="mt-1">
                                            <div class="dropdown add-items">
                                                <a href="javascript:;" class="btn-custom btn-blue dropdown-toggle add-to-cart"
                                                        data-service-price="{{ $service->discounted_price }}"
                                                        data-service-id="{{ $service->id }}"
                                                        data-service-name="{{ ucwords($service->name) }}"
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
                    @endforeach

                    <div class="col-12 text-right">
                        @if ($services->count() > 0)
                            <a href="javascript:;" onclick="goToPage('GET', '{{ route('front.bookingPage') }}')" class="btn btn-custom">
                                @lang('front.selectBookingTime')
                                <i class="fa fa-angle-right ml-1"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </section>

@endsection

@push('footer-script')
    <script>
        $(function() {
            // change services as per catergory selected
            $('body').on('click', '.categories-list', (function() {
                let id = $(this).data('category-id');
                if(id){
                    $('.services-list').hide();
                    $('.service-category-'+id).fadeIn();
                }
                else{
                    $('.services-list').fadeIn();
                }

                $('html, body').animate({
                    scrollTop: $(".listings").offset().top
                }, 1000);
            }));

            if (localStorage.getItem('location') !== '') {
                var url = '{{ route('front.index', ['location' => 'variable']) }}';
                url = url.replace('variable', localStorage.getItem('location'));

                $.easyAjax({
                    url: url,
                    type: 'GET',
                    success: function (response) {
                        var categories = `
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-30 categories-list">
                            <div class="ctg-item" style="background: var(--primary-color)">
                                <a href="javascript:;">
                                    <div class="icon-box">
                                        <i class="flaticon-fork"></i>
                                    </div>
                                    <div class="content-box">
                                        <h5 class="mb-0">
                                            @lang('front.all')
                                        </h5>
                                    </div>
                                </a>
                            </div>
                        </div>`;

                        response.categories.forEach(category => {
                            if (category.services.length > 0) {
                                var url = category.category_image_url;

                                categories += `
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-30 categories-list" data-category-id="${category.id}">
                                    <div class="ctg-item" style="background-image:url('${url}')">
                                        <a href="javascript:;">
                                            <div class="icon-box">
                                                <i class="flaticon-fork"></i>
                                            </div>
                                            <div class="content-box">
                                                <h5 class="mb-0">
                                                    ${category.name}
                                                </h5>
                                            </div>
                                        </a>
                                    </div>
                                </div>`
                            }
                        });
                        $('#categories').html(categories);

                        var services = '';

                        if (response.services.length > 0) {
                            response.services.forEach(service => {
                                services += `
                                    <div class="col-lg-3 col-md-6 col-12 mb-30 services-list service-category-${service.category_id}">
                                        <div class="listing-item">
                                            <div class="img-holder" style="background-image: url('${ service.service_image_url }')">
                                                <div class="category-name">
                                                    <i class="flaticon-fork mr-1"></i>${service.category.name}
                                                </div>
                                                <div class="time-remaining">
                                                    <i class="fa fa-clock-o mr-2"></i>
                                                    <span>${service.time} ${makeSingular(service.time, service.time_type)}</span>
                                                </div>
                                            </div>
                                            <div class="list-content">
                                                <h5 class="mb-2">
                                                    <a href="${service.service_detail_url}">${service.name}</a>
                                                </h5>
                                               
                                                <ul class="ctg-info centering h-center v-center">
                                                    <li class="mt-1">
                                                        <div class="service-price">
                                                            <span class="unit">{{ $settings->currency->currency_symbol }}</span>${service.discounted_price}
                                                        </div>
                                                    </li>
                                                    <li class="mt-1">
                                                        <div class="dropdown add-items">
                                                            <a href="javascript:;" class="btn-custom btn-blue dropdown-toggle add-to-cart"
                                                        data-service-price="${service.discounted_price}"
                                                        data-service-id="${service.id}"
                                                        data-service-name="${service.name}"
                                                        aria-expanded="false">
                                                                @lang('app.add')
                                                                <span class="fa fa-plus"></span>
                                                            </a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>`
                            });

                        services += `
                            <div class="col-12 text-right">
                                <a href="javascript:;" onclick="goToPage('GET', '{{ route('front.bookingPage') }}')" class="btn btn-custom">
                                    @lang('front.selectBookingTime')
                                    <i class="fa fa-angle-right ml-1"></i>
                                </a>
                            </div>`;
                        }
                        else {
                            services += `
                            <div class="col-12 text-center mb-5">
                                <h3 class="no-services">
                                    <i class="fa fa-exclamation-triangle"></i> @lang('front.noSearchRecordFound')
                                </h3>
                            </div>
                            `
                        }

                        $('#services').html(services);
                    }
                })
            }
        })
    </script>
    <script>
        // add items to cart
        $('body').on('click', '.add-to-cart', function () {
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
