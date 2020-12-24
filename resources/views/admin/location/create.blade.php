@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">@lang('app.add') @lang('app.location')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" id="createForm"  class="ajax-form" method="POST">
                        @csrf

                        <input type="hidden" name="redirect_url" value="{{ url()->previous() }}">

                        <div class="row">
                            <div class="col-md-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.location') @lang('app.name')</label>
                                    <input type="text" class="form-control form-control-lg" name="name">
                                </div>

                                {{--<div class="form-group">--}}
                                    {{--<label for="exampleInputPassword1">@lang('app.image')</label>--}}
                                    {{--<div class="card">--}}
                                        {{--<div class="card-body">--}}
                                            {{--<input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg" class="dropify"--}}
                                            {{--/>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

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
        {{--$('.dropify').dropify({--}}
            {{--messages: {--}}
                {{--default: '@lang("app.dragDrop")',--}}
                {{--replace: '@lang("app.dragDropReplace")',--}}
                {{--remove: '@lang("app.remove")',--}}
                {{--error: '@lang('app.largeFile')'--}}
            {{--}--}}
        {{--});--}}

        $('#save-form').click(function () {

            $.easyAjax({
                url: '{{route('admin.locations.store')}}',
                container: '#createForm',
                type: "POST",
                redirect: true,
                file:true,
                data: $('#createForm').serialize()
            })
        });

    </script>

@endpush
