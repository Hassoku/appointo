<div class="d-flex justify-content-center justify-content-md-end mb-3">
    <a href="javascript:;" id="create-language" class="btn btn-rounded btn-primary mb-1 mr-2">
        <i class="fa fa-plus"></i> <?php echo app('translator')->getFromJson('app.createNew'); ?>
    </a>
    <a href="<?php echo e(url('/translations')); ?>" target="_blank" id="translations" class="btn btn-rounded btn-warning mb-1">
        <i class="fa fa-cog"></i> <?php echo app('translator')->getFromJson('app.translations'); ?>
    </a>
</div>
<div class="table-responsive">
    <table id="langTable" class="table w-100">
        <thead>
            <tr>
                <th>#</th>
                <th><?php echo app('translator')->getFromJson('app.name'); ?></th>
                <th><?php echo app('translator')->getFromJson('app.code'); ?></th>
                <th><?php echo app('translator')->getFromJson('app.status'); ?></th>
                <th><?php echo app('translator')->getFromJson('app.action'); ?></th>
            </tr>
        </thead>
    </table>
</div>
<?php /**PATH E:\laragon\www\booking\resources\views/admin/language/index.blade.php ENDPATH**/ ?>