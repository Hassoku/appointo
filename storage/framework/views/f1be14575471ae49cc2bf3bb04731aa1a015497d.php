<div class="table-responsive">
    <div class="d-flex justify-content-center justify-content-md-end mb-3">
        <a href="javascript:;" id="create-page" class="btn btn-rounded btn-primary mb-1"><i class="fa fa-plus"></i> <?php echo app('translator')->getFromJson('app.createNew'); ?></a>
    </div>

    <table id="myTable" class="table w-100">
        <thead>
            <tr>
                <th>#</th>
                <th><?php echo app('translator')->getFromJson('app.title'); ?></th>
                <th><?php echo app('translator')->getFromJson('app.slug'); ?></th>
                <th><?php echo app('translator')->getFromJson('app.action'); ?></th>
            </tr>
        </thead>
    </table>

</div>
<?php /**PATH E:\laragon\www\booking\resources\views/admin/page/index.blade.php ENDPATH**/ ?>