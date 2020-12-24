@extends('layouts.master')

@push('head-css')
    <style>
        .link-stats{
            cursor: pointer;
        }
    </style>
@endpush

@section('content')

    <div class="row mb-2">

        @if($user->is_admin)
        <div class="col-md-12">
            @php($updateVersionInfo = \Froiden\Envato\Functions\EnvatoUpdate::updateVersionInfo())
            @if(isset($updateVersionInfo['lastVersion']))

            <div class="alert alert-primary col-md-12">
                <div class="row">
                    <div class="col-md-10 d-flex align-items-center"><i class="fa fa-gift fa-3x mr-2"></i> @lang('modules.update.newUpdate') <span
                                class="badge badge-success">{{ $updateVersionInfo['lastVersion'] }}</span>
                    </div>

                    <div class="col-md-2 text-right">
                        <a href="{{ route('admin.settings.index') }}"
                            class="btn btn-success">@lang('app.update')</a>
                    </div>

                </div>
            </div>

            @endif
        </div>
        @endif

        @if (!$user->mobile_verified && $smsSettings->nexmo_status == 'active')
            <div id="verify-mobile-info" class="col-md-12">
                <div class="alert alert-info col-md-12" role="alert">
                    <div class="row">
                        <div class="col-md-10 d-flex align-items-center">
                            <i class="fa fa-info fa-3x mr-2"></i>
                            @lang('messages.info.verifyAlert')
                        </div>
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <a href="{{ route('admin.profile.index') }}" class="btn btn-warning">
                                @lang('menu.profile')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (strlen($smsSettings->nexmo_from) > 18)
            <div id="brand-length" class="col-md-12">
                <div class="alert alert-danger col-md-12" role="alert">
                    <div class="row">
                        <div class="col-md-10 d-flex align-items-center">
                            <i class="fa fa-exclamation-triangle fa-3x mr-2"></i>
                            @lang('messages.info.smsNameAlert')
                        </div>
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <a href="{{ route('admin.settings.index').'#sms-settings' }}" class="btn btn-info">
                                @lang('menu.settings')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-12">
            <h6>@lang('app.dateRange')</h6>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <input type="text" class="form-control datepicker" name="start_date" id="start-date"
                       placeholder="@lang('app.startDate')"
                       value="{{ \Carbon\Carbon::today()->subDays(30)->format($settings->date_format) }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <input type="text" class="form-control datepicker" name="end_date" id="end-date"
                       placeholder="@lang('app.endDate')" value="{{ \Carbon\Carbon::today()->format($settings->date_format) }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <button type="button" id="apply-filter" class="btn btn-success"><i
                            class="fa fa-check"></i> @lang('app.apply')</button>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <h4 class="text-uppercase mb-4">@lang('modules.dashboard.totalBooking'): <span id="total-booking">0</span></h4>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box link-stats" onclick="location.href='{{ route('admin.bookings.index', 'status=completed') }}'">
                <span class="info-box-icon bg-success"><i class="fa fa-calendar"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">@lang('modules.dashboard.completedBooking')</span>
                    <span class="info-box-number" id="completed-booking">0</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box link-stats" onclick="location.href='{{ route('admin.bookings.index', 'status=pending') }}'">
                <span class="info-box-icon bg-warning"><i class="fa fa-calendar"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">@lang('modules.dashboard.pendingBooking')</span>
                    <span class="info-box-number" id="pending-booking">0</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box link-stats" onclick="location.href='{{ route('admin.bookings.index', 'status=approved') }}'">
                <span class="info-box-icon bg-info"><i class="fa fa-calendar"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">@lang('modules.dashboard.approvedBooking')</span>
                    <span class="info-box-number" id="approved-booking">0</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box link-stats" onclick="location.href='{{ route('admin.bookings.index', 'status=in progress') }}'">
                <span class="info-box-icon bg-primary"><i class="fa fa-calendar"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">@lang('modules.dashboard.inProgressBooking')</span>
                    <span class="info-box-number" id="in-progress-booking">0</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box link-stats" onclick="location.href='{{ route('admin.bookings.index', 'status=canceled') }}'">
                <span class="info-box-icon bg-danger"><i class="fa fa-calendar"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">@lang('modules.dashboard.canceledBooking')</span>
                    <span class="info-box-number" id="canceled-booking">0</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-secondary"><i class="fa fa-building"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">@lang('modules.dashboard.walkInBookings')</span>
                    <span class="info-box-number" id="offline-booking">0</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa fa-internet-explorer"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">@lang('modules.dashboard.onlineBookings')</span>
                    <span class="info-box-number" id="online-booking">0</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        @if($user->is_admin)
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-dark-gradient"><i class="fa fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">@lang('modules.dashboard.totalCustomers')</span>
                        <span class="info-box-number" id="total-customers">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success">{{ $settings->currency->currency_symbol }}</span>

                    <div class="info-box-content">
                        <span class="info-box-text">@lang('modules.dashboard.totalEarning')</span>
                        <span class="info-box-number" id="total-earning">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        @endif
    </div>

    @if($user->is_admin)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('modules.dashboard.recentBookings')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table">
                            @forelse($recentSales as $booking)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.customers.show', $booking->user->id) }}" data-toggle="tooltip" data-original-title="{{ ucwords($booking->user->name)  }}"><img src="{{ $booking->user->user_image_url }}" class="border img-bordered-sm img-size-50 img-circle"  ></a>
                                    </td>
                                    <td>
                                        <a class="text-uppercase" href="{{ route('admin.customers.show', $booking->user->id) }}">{{ ucwords($booking->user->name)  }}</a><br>
                                        <i class="icon-email"></i> {{ $booking->user->email ?? '--' }}<br>
                                        <i class="icon-mobile"></i> {{ $booking->user->mobile ? $booking->user->formatted_mobile : '--' }}
                                    </td>
                                    <td>
                                        <ol>
                                        @foreach($booking->items as $key=>$item)
                                           <li>{{ ucwords($item->businessService->name) }} x{{ $item->quantity }}</li>
                                        @endforeach
                                        </ol>
                                    </td>
                                    <td class="text-muted">
                                        <i class="icon-calendar"></i> {{ $booking->date_time->format($settings->date_format) }}<br>
                                        <i class="icon-alarm-clock"></i> {{ $booking->date_time->format($settings->time_format) }}
                                    </td>
                                    <td>
                                        <span class="text-uppercase small border
                                        @if($booking->status == 'completed') border-success text-success @endif
                                        @if($booking->status == 'pending') border-warning text-warning @endif
                                        @if($booking->status == 'approved') border-info text-info @endif
                                        @if($booking->status == 'in progress') border-primary text-primary @endif
                                        @if($booking->status == 'canceled') border-danger text-danger @endif
                                                badge-pill">{{ $booking->status }}</span>

                                        @if(($booking->status == 'pending' || $booking->status == 'approved') && $booking->date_time->greaterThanOrEqualTo(\Carbon\Carbon::now()))
                                           <br><br><a href="javascript:;" data-booking-id="{{ $booking->id }}" class="btn btn-rounded btn-outline-dark btn-sm send-reminder"><i class="fa fa-send"></i> @lang('modules.booking.sendReminder')</a>
                                        @endif

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>@lang('messages.noRecordFound')</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div><!-- /.row -->
    @endif
@endsection

@push('footer-js')
    <script>
        $('.datepicker').datetimepicker({
            format: '{{ $date_picker_format }}',
            allowInputToggle: true,
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right'
            }
        })

        function calculateStats() {
            let startDate = $('#start-date').val();
            let endDate = $('#end-date').val();

            $.easyAjax({
                type: 'GET',
                url: '{{ route("admin.dashboard") }}',
                data: {startDate: startDate, endDate: endDate},
                success: function (response) {
                    if (response.status == "success") {
                        $.unblockUI();
                        $('#total-booking').html(response.totalBooking)
                        $('#in-progress-booking').html(response.inProgressBooking)
                        $('#pending-booking').html(response.pendingBooking)
                        $('#approved-booking').html(response.approvedBooking)
                        $('#completed-booking').html(response.completedBooking)
                        $('#canceled-booking').html(response.canceledBooking)
                        $('#offline-booking').html(response.offlineBooking)
                        $('#online-booking').html(response.onlineBooking)
                        $('#total-customers').html(response.totalCustomers)
                        $('#total-earning').html(response.totalEarnings)
                    }
                }
            });

        }

        calculateStats();

        $('#apply-filter').click(function () {
            calculateStats();
        });

        $('.send-reminder').click(function () {
            let bookingId = $(this).data('booking-id');

            $.easyAjax({
                type: 'POST',
                url: '{{ route("admin.bookings.sendReminder") }}',
                data: {bookingId: bookingId, _token: '{{ csrf_token() }}'}
            });
        });
    </script>
@endpush
