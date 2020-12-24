<div class="modal-header">
    <h4 class="modal-title">@lang('app.edit') @lang('app.currency')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form id="createProjectCategory" class="ajax-form" method="POST" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="form-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">@lang('app.currency') @lang('app.name')</label>

                        <input type="text" class="form-control form-control-lg" id="currency_name" name="currency_name" value="{{ $currency->currency_name }}">
                    </div>

                    <div class="form-group">
                        <label class="control-label">@lang('app.currencySymbol')</label>

                        <input type="text" class="form-control form-control-lg" id="currency_symbol" name="currency_symbol" value="{{ $currency->currency_symbol }}">
                    </div>

                    <div class="form-group">
                        <label class="control-label">@lang('app.currencyCode')</label>

                        <input type="text" class="form-control form-control-lg" id="currency_code" name="currency_code" value="{{ $currency->currency_code }}">
                    </div>
                </div>

            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="update-currency" class="btn btn-success"> <i class="fa fa-check"></i> @lang('app.save')</button>
        </div>
    </form></div>


<script>


    $('#update-currency').click(function () {
        $.easyAjax({
            url: '{{route('admin.currency-settings.update', $currency->id)}}',
            container: '#createProjectCategory',
            type: "POST",
            data: $('#createProjectCategory').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        })
    });
</script>