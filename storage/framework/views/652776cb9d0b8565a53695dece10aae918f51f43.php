<?php $__env->startPush('styles'); ?>
    <style>
        .no-services{
            border: 1px solid #f7d8dd;
            background-color: #fbeeed;
            color: #d9534f;
            padding: 20px 0;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <section class="section">
        <div class="banner-area">
            <div id="banner-slider" class="carousel slide" data-ride="carousel">
                <ul class="carousel-indicators">
                    <?php $count = 0 ?>
                    <?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li data-target="#banner-slider" data-slide-to="<?php echo e($count); ?>" <?php if($count == 0): ?> class="active" <?php endif; ?>></li>
                        <?php $count++ ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li data-target="#banner-slider" data-slide-to="0" class="active"></li>
                        <li data-target="#banner-slider" data-slide-to="1"></li>
                        <li data-target="#banner-slider" data-slide-to="2"></li>
                        <li data-target="#banner-slider" data-slide-to="3"></li>
                    <?php endif; ?>
                </ul>
                <div class="carousel-inner">
                    <?php $count = 0 ?>
                    <?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="carousel-item <?php echo e($count == 0 ? 'active' : ''); ?>">
                            <a href="javascript:void(0);">
                                <img class="img-fluid" src="<?php echo e(asset('user-uploads/carousel-images/'.$image->file_name)); ?>" alt="carousel image">
                            </a>
                        </div>
                        <?php $count++ ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
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

                    <?php endif; ?>

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
                            <p><?php echo app('translator')->getFromJson('front.categoriesTitle'); ?></p>
                            <h3 class="sec-title">
                                <?php echo app('translator')->getFromJson('front.categories'); ?>
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
                                        <?php echo app('translator')->getFromJson('front.all'); ?>
                                    </h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($category->services->count() > 0): ?>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-30 categories-list" data-category-id="<?php echo e($category->id); ?>">
                            <div class="ctg-item" style="background-image:url('<?php echo e($category->category_image_url); ?>')">
                                <a href="javascript:;">
                                    <div class="icon-box">
                                        <i class="flaticon-fork"></i>
                                    </div>
                                    <div class="content-box">
                                        <h5 class="mb-0">
                                            <?php echo e(ucwords($category->name)); ?>

                                        </h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>

        <section class="listings sp-80 bg-w">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="all-title">
                            <p> <?php echo app('translator')->getFromJson('front.servicesTitle'); ?> </p>
                            <h3 class="sec-title">
                                <?php echo app('translator')->getFromJson('front.services'); ?>
                            </h3>
                        </div>
                    </div>
                </div>
                <div id="services" class="row">
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-3 col-md-6 col-12 mb-30 services-list service-category-<?php echo e($service->category_id); ?>">
                            <div class="listing-item">
                                <div class="img-holder" style="background-image: url('<?php echo e($service->service_image_url); ?>')">
                                    <div class="category-name">
                                        <i class="flaticon-fork mr-1"></i><?php echo e(ucwords($service->category->name)); ?>

                                    </div>
                                </div>
                                <div class="list-content">
                                    <h5 class="mb-2">
                                        <a href="<?php echo e($service->service_detail_url); ?>"><?php echo e(ucwords($service->name)); ?></a>
                                    </h5>
                                    <ul class="ctg-info centering h-center v-center">
                                        <li class="mt-1">
                                            <div class="service-price">
                                                <span class="unit"><?php echo e($settings->currency->currency_symbol); ?></span><?php echo e($service->discounted_price); ?>

                                            </div>
                                        </li>
                                        <li class="mt-1">
                                            <div class="dropdown add-items">
                                                <a href="javascript:;" class="btn-custom btn-blue dropdown-toggle add-to-cart"
                                                        data-service-price="<?php echo e($service->discounted_price); ?>"
                                                        data-service-id="<?php echo e($service->id); ?>"
                                                        data-service-name="<?php echo e(ucwords($service->name)); ?>"
                                                        aria-expanded="false">
                                                    <?php echo app('translator')->getFromJson('app.add'); ?>
                                                    <span class="fa fa-plus"></span>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="col-12 text-right">
                        <?php if($services->count() > 0): ?>
                            <a href="javascript:;" onclick="goToPage('GET', '<?php echo e(route('front.bookingPage')); ?>')" class="btn btn-custom">
                                <?php echo app('translator')->getFromJson('front.selectBookingTime'); ?>
                                <i class="fa fa-angle-right ml-1"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>
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
                var url = '<?php echo e(route('front.index', ['location' => 'variable'])); ?>';
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
                                            <?php echo app('translator')->getFromJson('front.all'); ?>
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
                                                            <span class="unit"><?php echo e($settings->currency->currency_symbol); ?></span>${service.discounted_price}
                                                        </div>
                                                    </li>
                                                    <li class="mt-1">
                                                        <div class="dropdown add-items">
                                                            <a href="javascript:;" class="btn-custom btn-blue dropdown-toggle add-to-cart"
                                                        data-service-price="${service.discounted_price}"
                                                        data-service-id="${service.id}"
                                                        data-service-name="${service.name}"
                                                        aria-expanded="false">
                                                                <?php echo app('translator')->getFromJson('app.add'); ?>
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
                                <a href="javascript:;" onclick="goToPage('GET', '<?php echo e(route('front.bookingPage')); ?>')" class="btn btn-custom">
                                    <?php echo app('translator')->getFromJson('front.selectBookingTime'); ?>
                                    <i class="fa fa-angle-right ml-1"></i>
                                </a>
                            </div>`;
                        }
                        else {
                            services += `
                            <div class="col-12 text-center mb-5">
                                <h3 class="no-services">
                                    <i class="fa fa-exclamation-triangle"></i> <?php echo app('translator')->getFromJson('front.noSearchRecordFound'); ?>
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
                url: '<?php echo e(route('front.addOrUpdateProduct')); ?>',
                type: 'POST',
                data: data,
                success: function (response) {
                    $('.cart-badge').text(response.productsCount);
                }
            })
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\booking\resources\views/front/index.blade.php ENDPATH**/ ?>