<div class="modal-header">
    <h4 class="modal-title">@lang('app.edit') @lang('menu.bookingTimes')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form id="createProjectCategory" class="ajax-form" method="POST" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="form-body">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <h4 class="form-control-static">@lang('app.'.$bookingTime->day)</h4>
                    </div>

                    <div class="form-group">
                        <label>@lang('modules.settings.openTime')</label>

                        <div class="input-group date time-picker">
                            <input type="text" class="form-control" name="start_time" value="{{ $bookingTime->start_time }}">
                            <span class="input-group-append input-group-addon">
                                <button type="button" class="btn btn-info"><span class="fa fa-clock-o"></span></button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>@lang('modules.settings.closeTime')</label>

                        <div class="input-group date time-picker">
                            <input type="text" class="form-control" name="end_time" value="{{ $bookingTime->end_time }}">
                            <span class="input-group-append input-group-addon">
                                <button type="button" class="btn btn-info"><span class="fa fa-clock-o"></span></button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>@lang('modules.settings.slotDuration')</label>

                        <div class="input-group justify-content-center align-items-center">
                            <input id="slot_duration" type="number" class="form-control" name="slot_duration" value="{{ $bookingTime->slot_duration }}" min="1">
                            <span class="ml-3">
                                @lang('app.minutes')
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>@lang('modules.settings.allowMultipleBooking')</label>
                        <select name="multiple_booking" id="multiple_booking" class="form-control" onchange="toggle('#show_max_booking');">
                            <option
                                    @if($bookingTime->multiple_booking == 'yes') selected @endif
                            value="yes">@lang('app.yes')</option>
                            <option
                                    @if($bookingTime->multiple_booking == 'no') selected @endif
                            value="no">@lang('app.no')</option>
                        </select>
                    </div>

                    <div class="form-group" id="show_max_booking">
                        <label for="max_booking">@lang('modules.settings.maxBookingAllowed') <span class="text-info">( @lang('modules.settings.maxBookingAllowedInfo') )</span></label>
                        <input class="form-control" type="number" name="max_booking" id="max_booking" value="{{ $bookingTime->max_booking }}" step="1" min="0">
                    </div>

                    <div class="form-group">
                        <label>@lang('app.status')</label>
                        <select name="status" id="status" class="form-control">
                            <option
                                    @if($bookingTime->status == 'enabled') selected @endif
                                    value="enabled">@lang('app.enabled')</option>
                            <option
                                    @if($bookingTime->status == 'disabled') selected @endif
                                    value="disabled">@lang('app.disabled')</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="save-category" class="btn btn-success"> <i class="fa fa-check"></i> @lang('app.save')</button>
        </div>
    </form>
</div>


<script>
    $(function () {
        @if ($bookingTime->multiple_booking === 'yes')
            $('#show_max_booking').show();
        @else
            $('#show_max_booking').hide();
        @endif

        function toggle(elementBox) {
            var elBox = $(elementBox);
            elBox.slideToggle();
        }
    })

    $('.time-picker').datetimepicker({
        format: '{{ $time_picker_format }}',
        allowInputToggle: true,
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        }
    });

    $('#save-category').click(function () {
        $.easyAjax({
            url: '{{route('admin.booking-times.update', $bookingTime->id)}}',
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

    $('#slot_duration,#max_booking').focus(function () {
        $(this).select();
    })
</script>
