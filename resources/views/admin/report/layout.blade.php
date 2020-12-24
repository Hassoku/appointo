@extends('layouts.master')

@push('head-css')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.css') }}">
@endpush

@section('content')
    <ul class="nav nav-tabs mb-5" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="earning-tab" data-toggle="tab" href="#earning" role="tab" aria-controls="earning"
                aria-selected="true">@lang('menu.earningReport')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="sales-tab" data-toggle="tab" href="#sales" role="tab" aria-controls="sales"
                aria-selected="false">@lang('menu.salesReport')</a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" id="customer-tab" data-toggle="tab" href="#customer" role="tab" aria-controls="customer"
                aria-selected="false">Customer Report</a>
        </li> --}}
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="earning" role="tabpanel" aria-labelledby="earning-tab">@include('admin.report.earning')</div>
        <div class="tab-pane fade" id="sales" role="tabpanel" aria-labelledby="sales-tab">@include('admin.report.sales')</div>
        {{-- <div class="tab-pane fade" id="customer" role="tabpanel" aria-labelledby="customer-tab">...</div> --}}
    </div>
@endsection

@push('footer-js')
    <script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        const renderTable = (tableId, url, data, columns=[]) => {
            $("#"+tableId).dataTable().fnDestroy();
            const table = $("#"+tableId).dataTable({
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'csvHtml5', text: '@lang("app.exportCSV")' }
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
            let token = "{{ csrf_token() }}";

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
@endpush
