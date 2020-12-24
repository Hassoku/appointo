<?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-4">
        <div class="card">
            <div class="img-holder">
                <img class="card-img-top img-fluid" src="<?php echo e(asset('user-uploads/carousel-images/'.$image->file_name)); ?>" alt="carousel-image">
            </div>
            <div class="card-body">
                <button id="<?php echo e($image->id); ?>" class="btn btn-danger pull-right delete-carousel-row">
                    <?php echo app('translator')->getFromJson('app.delete'); ?>
                </button>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH E:\laragon\www\booking\resources\views/partials/carousel_images.blade.php ENDPATH**/ ?>