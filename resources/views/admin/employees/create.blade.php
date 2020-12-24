@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">@lang('app.add') @lang('menu.employee')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" id="createForm"  class="ajax-form" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.name')</label>
                                    <input type="text" class="form-control form-control-lg" name="name" value="">
                                </div>

                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.email')</label>
                                    <input type="email" class="form-control form-control-lg" name="email" value="">
                                </div>

                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.password')</label>
                                    <input type="password" class="form-control form-control-lg" name="password">
                                    <span class="help-block">@lang('messages.leaveBlank')</span>
                                </div>

                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.mobile')</label>
                                    <div class="form-row">
                                        <div class="col-md-2 mb-2">
                                            <select name="calling_code" id="calling_code" class="form-control select2">
                                                @foreach ($calling_codes as $code => $value)
                                                    <option value="{{ $value['dial_code'] }}">
                                                        {{ $value['dial_code'] . ' - ' . $value['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="mobile">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>@lang('app.employeeGroup')</label>
                                    <div class="input-group">
                                        <select name="group_id" id="group_id" class="form-control form-control-lg">
                                            <option value="0">@lang('app.selectEmployeeGroup')</option>
                                            @foreach($groups as $group)
                                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-success" id="add-group" type="button"><i class="fa fa-plus"></i> @lang('app.add')</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>@lang('app.assignRole')</label>
                                    <select name="role_id" id="role_id" class="form-control form-control-lg">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">@lang('app.image')</label>
                                    <div class="card">
                                        <div class="card-body">
                                            <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg" data-default-file="{{ asset('img/default-avatar-user.png')  }}" class="dropify"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="button" id="save-form" class="btn btn-success btn-light-round"><i
                                                class="fa fa-check"></i> @lang('app.save')</button>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('footer-js')

    <script>
        $('.dropify').dropify({
            messages: {
                default: '@lang("app.dragDrop")',
                replace: '@lang("app.dragDropReplace")',
                remove: '@lang("app.remove")',
                error: '@lang('app.largeFile')'
            }
        });
        $('#add-group').click(function () {
            window.location = '{{ route("admin.employee-group.create") }}';
        })
        $('#save-form').click(function () {

            $.easyAjax({
                url: '{{route('admin.employee.store')}}',
                container: '#createForm',
                type: "POST",
                redirect: true,
                file:true
            })
        });

    </script>

@endpush
