<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div id="search-page" class="card-body">
                    <h3 class="box-title"><?php echo app('translator')->getFromJson('front.searchHere'); ?></h3>
                    <form class="form-group" action="<?php echo e(route('admin.search.store')); ?>" novalidate method="POST" role="search">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        <div class="input-group">
                            <input type="text"  name="search_key" class="form-control" placeholder="<?php echo app('translator')->getFromJson('front.searchBy'); ?>" value="<?php echo e($searchKey); ?>">
                            <span class="input-group-btn"><button type="submit" class="btn waves-effect waves-light btn-info"><i class="fa fa-search"></i></button></span>
                        </div>
                    </form>
                    <h2 class="m-t-40">Search Result For "<?php echo e($searchKey); ?>"</h2>
                    <small>About <?php echo e(count($searchResults)); ?> result </small>
                    <hr>
                    <ul class="search-listing">
                        <?php $__empty_1 = true; $__currentLoopData = $searchResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li>
                                <h3>
                                    <a href="<?php echo e(route($result->route_name, $result->searchable_id)); ?>">
                                        <?php echo app('translator')->getFromJson('app.'.strtolower($result->searchable_type)); ?>: <?php echo e($result->title); ?>

                                    </a>
                                </h3>
                                <a href="<?php echo e(route($result->route_name, $result->searchable_id)); ?>" class="search-links"><?php echo e(route($result->route_name, $result->searchable_id)); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li>
                                No result found
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\booking\resources\views/admin/search/show.blade.php ENDPATH**/ ?>