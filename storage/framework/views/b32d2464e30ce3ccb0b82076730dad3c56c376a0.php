<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?php if (app('laratrust')->can('create_business_service')) : ?>
                    <div class="d-flex justify-content-center justify-content-md-end mb-3">
                        <a href="<?php echo e(route('admin.business-services.create')); ?>" class="btn btn-rounded btn-primary mb-1"><i class="fa fa-plus"></i> <?php echo app('translator')->getFromJson('app.createNew'); ?></a>
                    </div>
                    <?php endif; // app('laratrust')->can ?>
                    <div class="table-responsive">
                        <table id="myTable" class="table w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo app('translator')->getFromJson('app.image'); ?></th>
                                    <th><?php echo app('translator')->getFromJson('app.name'); ?></th>
                                    <th><?php echo app('translator')->getFromJson('app.location'); ?></th>
                                    <th><?php echo app('translator')->getFromJson('app.category'); ?></th>
                                    <th><?php echo app('translator')->getFromJson('app.price'); ?></th>
                                    <th><?php echo app('translator')->getFromJson('app.status'); ?></th>
                                    <th><?php echo app('translator')->getFromJson('app.action'); ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-js'); ?>
    <script>
        $(document).ready(function() {
            var table = $('#myTable').dataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '<?php echo route('admin.business-services.index'); ?>',
                language: {
                    "url": "<?php echo __("app.datatable") ?>"
                },
                "fnDrawCallback": function( oSettings ) {
                    $("body").tooltip({
                        selector: '[data-toggle="tooltip"]'
                    });
                },
                order: [[0, 'DESC']],
                columns: [
                    { data: 'DT_RowIndex'},
                    { data: 'image', name: 'image' },
                    { data: 'name', name: 'name' },
                    { data: 'location_id', name: 'location_id' },
                    { data: 'category_id', name: 'category_id' },
                    { data: 'price', name: 'price' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', width: '20%' }
                ]
            });
            new $.fn.dataTable.FixedHeader( table );

            $('body').on('click', '.delete-row', function(){
                var id = $(this).data('row-id');
                swal({
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    title: "<?php echo app('translator')->getFromJson('errors.areYouSure'); ?>",
                    text: "<?php echo app('translator')->getFromJson('errors.deleteWarning'); ?>",
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            var url = "<?php echo e(route('admin.business-services.destroy',':id')); ?>";
                            url = url.replace(':id', id);

                            var token = "<?php echo e(csrf_token()); ?>";

                            $.easyAjax({
                                type: 'POST',
                                url: url,
                                data: {'_token': token, '_method': 'DELETE'},
                                success: function (response) {
                                    if (response.status == "success") {
                                        $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                                        table._fnDraw();
                                    }
                                }
                            });
                        }
                    });
            });
        } );
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\booking\resources\views/admin/business_service/index.blade.php ENDPATH**/ ?>