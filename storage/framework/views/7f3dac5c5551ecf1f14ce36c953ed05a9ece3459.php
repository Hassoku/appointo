<?php $__env->startSection('content'); ?>
    <section class="section sp-80 bg-w">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="all-title">
                        <h3 class="sec-title">
                            <?php echo e($page->title); ?>

                        </h3>
                    </div>
                </div>
            </div>
            <div class="content mx-5">
                <?php echo $page->content; ?>

                <?php if($page->id == 2): ?>
                    <hr>
                    <div class="row">
                        <form class="contact-form col-md-6" id="contact_form" method="post" action="">
                            <?php echo csrf_field(); ?>
                            <div id="alert"></div>
                            <div class="form-group">
                                <label>Name:</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Email:</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Details of problem:</label>
                                <textarea name="details" class="form-control" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="button" name="submit" onclick="javascript:contactSubmit();" class="btn btn-custom">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>
    <script>
        function contactSubmit() {
            $.easyAjax({
                url: '<?php echo e(route('front.contact')); ?>',
                type: 'POST',
                container: '#contact_form',
                formReset: true,
                data: $('#contact_form').serialize()
            })
        }

        $('body').on('keypress', '#contact_form input,#contact_form textarea', function(e) {
            $(this).siblings('.invalid-feedback').remove();
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\booking\resources\views/front/page.blade.php ENDPATH**/ ?>