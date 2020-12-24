<div class="modal-header">
    <h4 class="modal-title">@lang('modules.booking.customerDetails')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form id="createProjectCategory" class="ajax-form" method="POST" autocomplete="off">
        @csrf
        <div class="form-body">
            <div class="row">
                <div class="col-sm-12">

                    <div class="form-group">
                        <label>@lang('app.name')</label>

                        <input type="text" class="form-control form-control-lg" id="username" name="name">
                    </div>

                    <div class="form-group">
                        <label>@lang('app.mobile')</label>
                        <div class="form-row">
                            <div class="col-md-4 mb-2">
                                <select name="calling_code" id="calling_code" class="form-control select2">
                                    @foreach ($calling_codes as $code => $value)
                                        <option value="{{ $value['dial_code'] }}">
                                            {{ $value['dial_code'] . ' - ' . $value['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="mobile">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>@lang('app.email')</label>

                        <input type="text" class="form-control form-control-lg" name="email" >
                    </div>

                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="save-category" class="btn btn-success">@lang('app.continue') <i class="fa fa-arrow-right"></i></button>
        </div>
    </form></div>


<script>
    $('#calling_code.select2').select2();

    $('#save-category').click(function () {
        let username = $('#username').val();
        $.easyAjax({
            url: '{{route('admin.customers.store')}}',
            container: '#createProjectCategory',
            type: "POST",
            data: $('#createProjectCategory').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    $('#user_id').select2({
                        ajax: {
                            url: "{{ route('admin.pos.search-customer') }}",
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    q: params.term, // search term
                                    page: params.page
                                };
                            },
                            processResults: function (data, params) {
                                // parse the results into the format expected by Select2
                                // since we are using custom formatting functions we do not need to
                                // alter the remote JSON data, except to indicate that infinite
                                // scrolling can be used
                                params.page = params.page || 1;

                                return {
                                    results: data.items,
                                    pagination: {
                                        more: (params.page * 30) < data.total_count
                                    }
                                };

                                customerDetails(1);
                            },
                            cache: true
                        },
                        placeholder: "@lang('modules.booking.selectCustomer')",
                        escapeMarkup: function (markup) {
                            return markup;
                        }, // let our custom formatter work
                        minimumInputLength: 1,
                        templateResult: formatRepo,
                        templateSelection: formatRepoSelection,
                    });
                    $('#user_id').val(response.user_id);
                    customerDetails(response.user_id);
                    $('#user-error').text('');
                    $('#application-modal').modal('hide');
                }
            }
        })
    });
</script>
