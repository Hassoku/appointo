<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-light">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="form-control form-control-lg" type="text" id="customer-search" placeholder="<?php echo app('translator')->getFromJson('modules.customer.search'); ?>">
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="row" id="customer-list">
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-js'); ?>
    <script>
        $(document).ready(function() {


            const showCustomerList = (take = <?php echo e($recordsLoad); ?>) => {
                let param = $('#customer-search').val();

                $.easyAjax({
                    type: 'GET',
                    url: '<?php echo e(route('admin.customers.index')); ?>',
                    data: {'param': param, 'take': take},
                    success: function (response) {
                        if (response.status == "success") {
                            $.unblockUI();
                            $('#customer-list').html(response.view);
                        }
                    }
                });
            };

            $('#customer-search').keyup(function () {
                showCustomerList();
            });

            $('body').on('click', '#load-more', function () {
                let take = $(this).data('take');
                showCustomerList(take);
            });

            showCustomerList();

        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\booking\resources\views/admin/customer/index.blade.php ENDPATH**/ ?>