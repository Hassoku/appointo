@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">@lang('app.edit') @lang('app.service')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" id="createForm"  class="ajax-form" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id" value="{{ $businessService->id }}">
                        <div class="row">
                            <div class="col-md">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>@lang('app.service') @lang('app.name')</label>
                                    <input type="text" name="name" id="name" value="{{ $businessService->name }}" class="form-control form-control-lg">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label>@lang('app.service') @lang('app.slug')</label>
                                    <input type="text" name="slug" id="slug" value="{{ $businessService->slug }}" class="form-control form-control-lg">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('app.service') @lang('app.description')</label>
                                    <textarea name="description" id="description" cols="30" class="form-control-lg form-control" rows="4">{{ $businessService->description }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('app.price')</label>
                                    <input type="number" step="0.01" min="0" name="price" id="price" class="form-control form-control-lg" value="{{ $businessService->price }}"  />

                                </div>
                            </div>

                            <div class="col-md-4">

                                <div class="form-group">
                                    <label>@lang('modules.services.discount')</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-lg" id="discount" name="discount" min="0" value="{{ $businessService->discount }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary dropdown-toggle" id="discount-type-select" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('modules.services.'.$businessService->discount_type)</button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item discount_type" data-type="percent" href="javascript:;">@lang('modules.services.percent')</a>
                                                <a class="dropdown-item discount_type" data-type="fixed" href="javascript:;">@lang('modules.services.fixed')</a>
                                            </div>
                                        </div>

                                        <input type="hidden" id="discount-type" name="discount_type" value="{{ $businessService->discount_type }}">

                                    </div>

                                </div>
                            </div>

                            <div class="col-md-3 offset-md-1">
                                <div class="form-group">
                                    <label>@lang('modules.services.discountedPrice')</label>
                                    <p class="form-control-static" id="discounted-price" style="font-size: 1.5rem">--</p>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('app.location')</label>
                                    <div class="input-group">
                                        <select name="location_id" id="location_id" class="form-control form-control-lg">
                                            @foreach($locations as $location)
                                                <option
                                                        @if($location->id == $businessService->location_id) selected @endif
                                                        value="{{ $location->id }}">{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-success" onclick="javascript: location = '{{ route('admin.locations.create') }}';" type="button"><i class="fa fa-plus"></i> @lang('app.add')</button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('app.category')</label>
                                    <div class="input-group">
                                        <select name="category_id" id="category_id" class="form-control form-control-lg">
                                            @foreach($categories as $category)
                                                <option
                                                        @if($category->id == $businessService->category_id) selected @endif
                                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-success" id="add-category" type="button"><i class="fa fa-plus"></i> @lang('app.add')</button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>@lang('modules.services.time')</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" min="0" class="form-control form-control-lg" name="time" value="{{ $businessService->time }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary dropdown-toggle" id="time-type-select" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('app.'.$businessService->time_type)</button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item time_type" data-type="minutes" href="javascript:;">@lang('app.minutes')</a>
                                                <a class="dropdown-item time_type" data-type="hours" href="javascript:;">@lang('app.hours')</a>
                                                <a class="dropdown-item time_type" data-type="days" href="javascript:;">@lang('app.days')</a>
                                            </div>
                                        </div>

                                        <input type="hidden" id="time-type" name="time_type" value="{{ $businessService->time_type }}">

                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12">


                                <div class="form-group">
                                    <label for="exampleInputPassword1">@lang('app.image')</label>
                                    <div class="card">
                                        <div class="card-body">
                                            <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg" class="dropify"
                                                   data-default-file="{{ $businessService->service_image_url }}"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">@lang('app.status')</label>
                                    <select name="status" id="" class="form-control form-control-lg">
                                        <option
                                                @if($businessService->status == 'active') selected @endif
                                        value="active">@lang('app.active')</option>
                                        <option
                                                @if($businessService->status == 'deactive') selected @endif
                                        value="deactive">@lang('app.deactive')</option>
                                    </select>
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
        $(function () {
            $('#description').summernote({
                dialogsInBody: true,
                height: 300,
                toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ["view", ["fullscreen"]]
            ]
            })
        })
        $('.dropify').dropify({
            messages: {
                default: '@lang("app.dragDrop")',
                replace: '@lang("app.dragDropReplace")',
                remove: '@lang("app.remove")',
                error: '@lang('app.largeFile')'
            }
        });

        function createSlug(value) {
            value = value.replace(/\s\s+/g, ' ');
            let slug = value.split(' ').join('-').toLowerCase();
            slug = slug.replace(/--+/g, '-');
            $('#slug').val(slug);
        }

        $('#name').keyup(function(e) {
            createSlug($(this).val());
        });

        $('#slug').keyup(function(e) {
            createSlug($(this).val());
        });

        $('.discount_type').click(function () {
            var type = $(this).data('type');

            $('#discount-type-select').html(type);
            $('#discount-type').val(type);
            calculateDiscountedPrice();
        });

        $('.time_type').click(function () {
            var type = $(this).data('type');

            $('#time-type-select').html(type);
            $('#time-type').val(type);
        });

        $('#save-form').click(function () {

            $.easyAjax({
                url: '{{route('admin.business-services.update', $businessService->id)}}',
                container: '#createForm',
                type: "POST",
                redirect: true,
                file:true,
                data: $('#createForm').serialize()
            })
        });

        $('#add-category').click(function () {
            window.location = '{{ route("admin.categories.create") }}';
        });

        $('#discount, #price').keyup(function () {
            if ($(this).val() == '') {
                $(this).val(0);
            }
            calculateDiscountedPrice();
        });

        function calculateDiscountedPrice() {
            var price = $('#price').val();
            var discount = $('#discount').val();
            var discountType = $('#discount-type').val();

            if (discountType == 'percent') {
                if(discount > 100){
                    $('#discount').val(100);
                    discount = 100;
                }
            }
            else {
                if (parseInt(discount) > parseInt(price)) {
                    $('#discount').val(price);
                    discount = price;
                }
            }

            var discountedPrice = price;

            if(discount >= 0 && discount >= '' && price != '' && price > 0){
                if (discountType == 'percent') {
                    discountedPrice = parseFloat(price) - (parseFloat(price) * (parseFloat(discount) / 100));
                }
                else {
                    discountedPrice = parseFloat(price) - parseFloat(discount);
                }
            }

            if(discount != '' && price != '' && price > 0){
                $('#discounted-price').html(discountedPrice.toFixed(2));
            }
        }

        calculateDiscountedPrice();

    </script>

@endpush
