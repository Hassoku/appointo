<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-4">
                        <h6><?php echo app('translator')->getFromJson('app.dateRange'); ?></h6>
                        <div id="reportmonth" class="form-group"
                            style="background: #fff; cursor: pointer; padding: 15px 20px; border: 1px solid #ccc;">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span>
                                <input type="text" readonly id="month_year" style="border: none" value="<?php echo e(\Carbon\Carbon::now()->format('F, Y')); ?>">
                            </span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>
                </div>
                <!-- Custom Tabs -->
                <div class="card">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3"><?php echo app('translator')->getFromJson('menu.salesReport'); ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div id="sales-graph-container">
                                    <canvas id="salesChart" style="height: 400px !important"></canvas>
                                </div>

                                <hr>
                                <div class="table-responsive">

                                    <table id="salesTable" class="table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th><?php echo app('translator')->getFromJson('app.service'); ?> #</th>
                                                <th><?php echo app('translator')->getFromJson('app.serviceName'); ?></th>
                                                <th><?php echo app('translator')->getFromJson('app.customer'); ?></th>
                                                <th><?php echo app('translator')->getFromJson('app.sales'); ?></th>
                                                <th><?php echo app('translator')->getFromJson('app.amount'); ?></th>
                                                <th><?php echo app('translator')->getFromJson('app.paid_on'); ?></th>
                                            </tr>
                                        </thead>
                                    </table>

                                </div>

                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- ./card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
</div>

<?php $__env->startPush('footer-js'); ?>
    <script>
        $(function() {
            $('#reportmonth').on('click', function () {
                $(this).find('input').datepicker('show')
            })

            $('#reportmonth input').datepicker({
                format: "MM, yyyy",
                autoclose: true,
                viewMode: "months",
                minViewMode: "months"
            });

            function sales_cb(date) {
                chartRequest(
                    '<?php echo e(route("admin.reports.salesReportChart")); ?>',
                    {
                        month: moment(date).month()+1,
                        year: moment(date).year()
                    },
                    'salesChart',
                    'sales-graph-container',
                    '<?php echo app('translator')->getFromJson("app.sales"); ?>'
                );
                renderTable(
                    'salesTable',
                    '<?php echo route('admin.reports.salesTable'); ?>',
                    {
                        month: moment(date).month()+1,
                        year: moment(date).year()
                    },
                    [
                        { data: 'service_name', name: 'service_name' },
                        { data: 'customer_name', name: 'customer_name' },
                        { data: 'sales', name: 'sales' },
                        { data: 'amount', name: 'amount' },
                        { data: 'paid_on', name: 'paid_on' },
                    ]
                );
            }

            $('#reportmonth input').datepicker()
            .on('changeMonth', function(e) {
                sales_cb(e.date);
            });

            sales_cb(moment().toISOString());
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\laragon\www\booking\resources\views/admin/report/sales.blade.php ENDPATH**/ ?>