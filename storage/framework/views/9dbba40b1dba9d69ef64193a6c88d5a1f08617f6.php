<footer class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="company-details text-center">
                        <div class="row justify-content-center mb-5 pb-4 border-bottom">
                            <div class="col-md-4 col-sm-6 col-12 mb-30">
                                <div class="f-content">
                                    <i class="fa fa-map-marker"></i>
                                    <p>
                                        <strong><?php echo e($settings->company_name); ?></strong>
                                    </p>
                                    <p><?php echo $settings->formatted_address; ?></p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12 mb-30">
                                <div class="f-content">
                                    <i class="fa fa-phone"></i>
                                    <?php echo e($settings->formatted_phone_number); ?>


                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12 mb-30">
                                <div class="f-content">
                                    <i class="fa fa-envelope"></i>
                                    <a href="mailto:<?php echo e($settings->company_email); ?>"><?php echo e($settings->company_email); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="quick-link d-flex flex-wrap align-items-center justify-content-between">
                
                <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page->id !== 2): ?>
                        <a href="<?php echo e(route('front.page', $page->slug)); ?>">
                            <?php echo e($page->title); ?></a>
                    <?php else: ?>
                        <?php
                            $contactPageSlug = $page->slug;
                            $contactPageTitle = $page->title;
                        ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('front.page', $contactPageSlug)); ?>"><?php echo e($contactPageTitle); ?></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    © <?php echo e(ucfirst($settings->company_name)); ?> <?php echo e(\Carbon\Carbon::now()->year); ?>

                </div>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH E:\laragon\www\booking\resources\views/sections/footer.blade.php ENDPATH**/ ?>