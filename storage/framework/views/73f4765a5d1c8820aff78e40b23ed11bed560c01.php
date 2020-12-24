<?php $__env->startPush('head-css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap-datepicker3.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <ul class="nav nav-tabs mb-5" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="earning-tab" data-toggle="tab" href="#earning" role="tab" aria-controls="earning"
                aria-selected="true"><?php echo app('translator')->getFromJson('menu.earningReport'); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="sales-tab" data-toggle="tab" href="#sales" role="tab" aria-controls="sales"
                aria-selected="false"><?php echo app('translator')->getFromJson('menu.salesReport'); ?></a>
        </li>
        
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="earning" role="tabpanel" aria-labelledby="earning-tab"><?php echo $__env->make('admin.report.earning', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div>
        <div class="tab-pane fade" id="sales" role="tabpanel" aria-labelledby="sales-tab"><?php echo $__env->make('admin.report.sales', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div>
        
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-js'); ?>
    <script src="<?php echo e(asset('assets/js/bootstrap-datepicker.min.js')); ?>"></script>
    <script>
        const renderTable = (tableId, url, data, columns=[]) => {
            $("#"+tableId).dataTable().fnDestroy();
            const table = $("#"+tableId).dataTable({
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'csvHtml5', text: '<?php echo app('translator')->getFromJson("app.exportCSV"); ?>' }
                ],
                responsive: true,
                // processing: true,
                serverSide: true,
                ajax: {'url' : url,
                    "data": function ( d ) {
                        return $.extend( {}, d, data );
                    }
                },
                language: {
                    "url": "<?php echo __("app.datatable") ?>"
                },
                "fnDrawCallback": function( oSettings ) {
                    $("body").tooltip({
                        selector: '[data-toggle="tooltip"]'
                    });
                },
                columns: [
                    { data: 'DT_RowIndex'},
                    ...columns
                ]
            });
            new $.fn.dataTable.FixedHeader( table );
        }

        const generateChart = (labels, data, chartId, label) => {
            const ctx = document.getElementById(chartId).getContext('2d');
            const labelArray = labels;
            const dataArray = data;

            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [...labelArray],
                    datasets: [{
                        label: label,
                        data: [...dataArray],
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        }

        const chartRequest = (url, data, chartId, containerId, label) => {
            let token = "<?php echo e(csrf_token()); ?>";

            $.easyAjax({
                type: 'POST',
                url: url,
                data: {...data, '_token': token},
                success: function (response) {
                    if (response.status == "success") {
                        $.unblockUI();
                        resetCanvas(chartId, containerId);
                        generateChart(response.labels, response.data, chartId, label);
                    }
                }
            });
        }

        const resetCanvas = (chartId, containerId) => {
            $('#'+chartId).remove(); // this is my <canvas> element
            $('#'+containerId).append('<canvas id="'+chartId+'" style="height: 400px !important"><canvas>');
            canvas = document.querySelector('#'+chartId);
            ctx = canvas.getContext('2d');
            ctx.canvas.width = $('#graph').width(); // resize to parent width
            ctx.canvas.height = $('#graph').height(); // resize to parent height
            var x = canvas.width/2;
            var y = canvas.height/2;
            ctx.font = '10pt Verdana';
            ctx.textAlign = 'center';
            ctx.fillText('This text is centered on the canvas', x, y);
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\laragon\www\booking\resources\views/admin/report/layout.blade.php ENDPATH**/ ?>