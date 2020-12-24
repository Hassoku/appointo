@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center justify-content-md-end mb-3">
                        @permission('read_employee_group')
                        <a href="{{ route('admin.employee-group.index') }}" class="btn btn-rounded btn-info mb-1 mr-2"><i class="fa fa-list"></i> @lang('app.employeeGroup')</a>
                        @endpermission
                        @permission('create_employee')
                        <a href="{{ route('admin.employee.create') }}" class="btn btn-rounded btn-primary mb-1"><i class="fa fa-plus"></i> @lang('app.createNew')</a>
                        @endpermission
                    </div>
                    <div class="table-responsive">
                        <table id="myTable" class="table w-100">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('app.image')</th>
                                <th>@lang('app.name')</th>
                                <th>@lang('app.employeeGroup')</th>
                                <th>@lang('app.role')</th>
                                <th>@lang('app.action')</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-js')
    <script>
        $(document).ready(function() {
            var table = $('#myTable').dataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.employee.index') !!}',
                language: {
                    "url": "<?php echo __("app.datatable") ?>"
                },
                "fnDrawCallback": function( oSettings ) {
                    $("body").tooltip({
                        selector: '[data-toggle="tooltip"]'
                    });
                    $('.role_id').select2({
                        width: '100%'
                    });
                },
                columns: [
                    { data: 'DT_RowIndex'},
                    { data: 'image', name: 'image' },
                    { data: 'name', name: 'name' },
                    { data: 'group_id', name: 'group_id' },
                    { data: 'role_name', name: 'role_name' },
                    { data: 'action', name: 'action', width: '20%' }
                ]
            });
            new $.fn.dataTable.FixedHeader( table );

            $('body').on('change', '.role_id', function () {
                const user_id = $(this).data('user-id');
                const role_id = $(this).val();

                $.easyAjax({
                    url: '{{ route('admin.employee.changeRole') }}',
                    type: 'POST',
                    data: { _token: '{{ csrf_token() }}', user_id, role_id },
                    container: '#myTable',
                    success: function (response) {
                        if (response.status === 'success') {
                            table.fnDraw();
                        }
                    }
                })
            })

            $('body').on('click', '.delete-row', function(){
                var id = $(this).data('row-id');
                swal({
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    title: "@lang('errors.areYouSure')",
                    text: "@lang('errors.deleteWarning')",
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            var url = "{{ route('admin.employee.destroy',':id') }}";
                            url = url.replace(':id', id);

                            var token = "{{ csrf_token() }}";

                            $.easyAjax({
                                type: 'POST',
                                url: url,
                                data: {'_token': token, '_method': 'DELETE'},
                                success: function (response) {
                                    if (response.status == "success") {
                                        $.unblockUI();
                                        // swal("Deleted!", response.message, "success");
                                        table._fnDraw();
                                    }
                                }
                            });
                        }
                    });
            });
        } );
    </script>
@endpush
