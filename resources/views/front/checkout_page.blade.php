@extends('layouts.front')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endpush

@section('content')
    <section class="section">
        <section class="cart-area sp-80">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="all-title">
                            <h3 class="sec-title">
                                @lang('front.headings.checkout')
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="billing-info">
                    @if(is_null($user))
                        <p class="mb-30">
                            @lang('front.accountAlready') ?
                            <a href="{{ route('login') }}"> @lang('front.loginNow') </a>
                        </p>
                    @endif
                    <div class="row d-flex justify-content-center">
                        @if(is_null($user))
                        <div class="col-lg-7 col-12 mb-30">
                            <h5>@lang('app.add') @lang('front.personalDetails')</h5>
                            <form id="personal-details" class="ajax-form" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <span>first name*</span>
                                            <input type="text" name="first_name" class="form-control" placeholder="First name">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <span>last name*</span>
                                            <input type="text" name="last_name" class="form-control" placeholder="Last name">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <span>email*</span>
                                            <input type="text" name="email" class="form-control" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <span>phone number*</span>
                                            <div class="form-row">
                                                <div class="col-sm-4">
                                                    <select name="calling_code" id="calling_code" class="form-control select2">
                                                        @foreach ($calling_codes as $code => $value)
                                                            <option value="{{ $value['dial_code'] }}"
                                                            @if (!is_null($user) && $user->calling_code)
                                                                {{ $user->calling_code == $value['dial_code'] ? 'selected' : '' }}
                                                            @endif>{{ $value['dial_code'] . ' - ' . $value['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" name="phone" class="form-control" placeholder="Phone no.">
                                                </div>
                                                @if ($smsSettings->nexmo_status == 'active')
                                                    <span class="text-info ml-2">
                                                        @lang('messages.info.verifyMessage')
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-12">
                                    <p class="c-theme">** @lang('front.accountCreateNotice')</p>
                                </div>
                            </div>
                        </div>
                        @elseif($smsSettings->nexmo_status == 'active' && !$user->mobile_verified)
                        <div class="col-lg-7 col-12 mb-30">
                            <h5>@lang('app.verifyMobile')</h5>
                            <div id="verify-mobile">
                                @include('partials.front_verify_phone')
                            </div>
                        </div>
                        @endif
                        <div class="{{ !$user || !$user->mobile_verified ? 'col-lg-5' : 'col-lg-7' }} col-12 mb-30">
                            <div class="booking-summary mb-30">
                                <h5>@lang('front.summary.checkout.heading.bookingSummary')</h5>
                                <ul>
                                    <li>
                                    <span>
                                        @lang('front.bookingDate'):
                                    </span>
                                        <span>
                                        {{ \Carbon\Carbon::createFromFormat('m/d/Y', $bookingDetails['bookingDate'])->format('l, F jS') }}
                                    </span>
                                    </li>
                                    <li>
                                    <span>
                                        @lang('front.bookingTime'):
                                    </span>
                                        <span>
                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $bookingDetails['bookingTime'])->format($settings->time_format) }}
                                    </span>
                                    </li>
                                    <li>
                                    <span>
                                        @lang('front.amountToPay'):
                                    </span>
                                    <span>
                                        {{ $settings->currency->currency_symbol.$totalAmount }}
                                    </span>
                                    </li>
                                </ul>
                            </div>
                            @if ($user)
                                <div class="instruction">
                                    <h5>@lang('front.additionalNotes')</h5>
                                    <form id="booking" class="ajax-form" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <textarea class="form-control" rows="4" name="additional_notes" placeholder="@lang('front.writeYourMessageHere')"></textarea>
                                        </div>
                                    </form>
                                </div>
                            @elseif ($smsSettings->nexmo_status == 'deactive')
                                <div class="instruction">
                                    <h5>@lang('front.additionalNotes')</h5>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="4" name="additional_notes" placeholder="@lang('front.writeYourMessageHere')" form="personal-details"></textarea>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-right">
                        <div class="navigation">
                            <a href="{{ route('front.cartPage') }}" class="btn btn-custom btn-dark"><i class="fa fa-angle-left mr-2"></i>@lang('front.navigation.goBack')</a>
                            @if (!$user)
                                @if ($smsSettings->nexmo_status == 'active')
                                    <a href="javascript:;" onclick="saveUser();" class="btn btn-custom btn-dark">
                                        @lang('front.navigation.toVerifyMobile')
                                        <i class="fa fa-angle-right ml-1"></i>
                                    </a>
                                @else
                                    <a href="javascript:;" onclick="saveUser();" class="btn btn-custom btn-dark">
                                        @lang('front.navigation.toPayment')
                                        <i class="fa fa-angle-right ml-1"></i>
                                    </a>
                                @endif
                            @else
                                @if ($smsSettings->nexmo_status == 'active')
                                <a href="javascript:;" onclick="saveBooking();" class="btn btn-custom btn-dark @if (!$user->mobile_verified) disabled @endif">
                                    @lang('front.navigation.toPayment')
                                    <i class="fa fa-angle-right ml-1"></i>
                                </a>
                                @else
                                    <a href="javascript:;" onclick="saveBooking();" class="btn btn-custom btn-dark">
                                        @lang('front.navigation.toPayment')
                                        <i class="fa fa-angle-right ml-1"></i>
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection

@push('footer-script')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script>
        $('.select2').select2();

        function saveUser() {
            var url =  '{{ route('front.saveBooking') }}';
            var form = $('#personal-details');

            $.easyAjax({
                url: url,
                type: 'POST',
                container: '#personal-details',
                data: form.serialize()
            })
        }

        function saveBooking() {
            $.easyAjax({
                url: '{{ route('front.saveBooking') }}',
                type: 'POST',
                container: '#booking',
                data: $('#booking').serialize()
            })
        }
    </script>
    <script>
        @if ($smsSettings->nexmo_status == 'active' && $user && !$user->mobile_verified && !session()->has('verify:request_id'))
            sendOTPRequest();
        @endif

        var x = '';

        function clearLocalStorage() {
            localStorage.removeItem('otp_expiry');
            localStorage.removeItem('otp_attempts');
        }

        function checkSessionAndRemove() {
            $.easyAjax({
                url: '{{ route('removeSession') }}',
                type: 'GET',
                data: {'sessions': ['verify:request_id']}
            })
        }

        function startCounter(deadline) {
            x = setInterval(function() {
                var now = new Date().getTime();
                var t = deadline - now;

                var days = Math.floor(t / (1000 * 60 * 60 * 24));
                var hours = Math.floor((t%(1000 * 60 * 60 * 24))/(1000 * 60 * 60));
                var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((t % (1000 * 60)) / 1000);

                $('#demo').html('Time Left: '+minutes + ":" + seconds);
                $('.attempts_left').html(`${localStorage.getItem('otp_attempts')} attempts left`);

                if (t <= 0) {
                    clearInterval(x);
                    clearLocalStorage();
                    checkSessionAndRemove();
                    location.href = '{{ route('front.cartPage') }}'
                }
            }, 1000);
        }

        if (localStorage.getItem('otp_expiry') !== null) {
            let localExpiryTime = localStorage.getItem('otp_expiry');
            let now = new Date().getTime();

            if (localExpiryTime - now < 0) {
                clearLocalStorage();
                checkSessionAndRemove();
            }
            else {
                $('#otp').focus().select();
                startCounter(localStorage.getItem('otp_expiry'));
            }
        }

        function sendOTPRequest() {
            $.easyAjax({
                url: '{{ route('sendOtpCode') }}',
                type: 'POST',
                container: '#request-otp-form',
                messagePosition: 'inline',
                data: $('#request-otp-form').serialize(),
                success: function (response) {
                    if (response.status == 'success') {
                        localStorage.setItem('otp_attempts', 3);

                        $('#verify-mobile').html(response.view);
                        $('.attempts_left').html(`3 attempts left`);

                        $('#otp').focus();

                        var now = new Date().getTime();
                        var deadline = new Date(now + parseInt('{{ config('nexmo.settings.pin_expiry') }}')*1000).getTime();

                        localStorage.setItem('otp_expiry', deadline);
                        startCounter(deadline);
                        // intialize countdown
                    }
                    if (response.status == 'fail') {
                        $('#mobile').focus();
                    }
                }
            });
        }

        function sendVerifyRequest() {
            $.easyAjax({
                url: '{{ route('verifyOtpCode') }}',
                type: 'POST',
                container: '#verify-otp-form',
                messagePosition: 'inline',
                data: $('#verify-otp-form').serialize(),
                success: function (response) {
                    if (response.status == 'success') {
                        clearLocalStorage();

                        location.reload();
                        $('#verify-mobile-info').html('');

                        // select2 reinitialize
                        $('.select2').select2();
                    }
                    if (response.status == 'fail') {
                        // show number of attempts left
                        let currentAttempts = localStorage.getItem('otp_attempts');

                        if (currentAttempts == 1) {
                            clearLocalStorage();
                        }
                        else {
                            currentAttempts -= 1;

                            $('.attempts_left').html(`${currentAttempts} attempts left`);
                            $('#otp').focus().select();
                            localStorage.setItem('otp_attempts', currentAttempts);
                        }

                        if (Object.keys(response.data).length > 0) {
                            $('#verify-mobile').html(response.data.view);

                            // select2 reinitialize
                            $('.select2').select2();

                            clearInterval(x);
                        }
                    }
                }
            });
        }

        $('body').on('submit', '#request-otp-form', function (e) {
            e.preventDefault();
            sendOTPRequest();
        })

        $('body').on('click', '#request-otp', function () {
            sendOTPRequest();
        })

        $('body').on('submit', '#verify-otp-form', function (e) {
            e.preventDefault();
            sendVerifyRequest();
        })

        $('body').on('click', '#verify-otp', function() {
            sendVerifyRequest();
        })
    </script>
@endpush
