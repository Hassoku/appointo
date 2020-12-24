@extends('layouts.front')

@section('content')
    <section class="section">
        <section class="sp-80 bg-w">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="all-title">
                            <h3 class="sec-title">
                                @lang('front.headings.payment')
                            </h3>
                        </div>
                    </div>
                </div>
                <div id="invoice_container" class="billing-info payment-box success-box">
                    @if ($message = session()->get('success'))
                        <div class="alert alert-success alert-dismissable" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            {!! $message !!}
                        </div>
                        {{ session()->forget('success') }}
                    @endif
                    @if ($message = session()->get('error'))
                        <div class="alert alert-danger alert-dismissable" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            {!! $message !!}
                        </div>
                    @endif

                    @if ($message = session()->get('error'))
                        <div class="payment-type">
                            <h5>please pay again with</h5>
                            <div class="payments">
                                @if($credentials->stripe_status == 'active' && $booking->amount_to_pay > 0)
                                    <a href="javascript:;" id="stripePaymentButton" class="btn btn-custom btn-blue"><i class="fa fa-cc-stripe mr-2"></i>@lang('front.buttons.stripe')</a>
                                @endif
                                @if($credentials->paypal_status == 'active' && $booking->amount_to_pay > 0)
                                    <a href="{{ route('front.paypal') }}" class="btn btn-custom"><i class="fa fa-paypal mr-2"></i>@lang('front.buttons.paypal')</a>
                                @endif
                                @if($credentials->razorpay_status == 'active' && $booking->amount_to_pay > 0)
                                    <a href="javascript:startRazorPayPayment();" class="btn btn-custom btn-blue"><i class="fa fa-credit-card mr-2"></i>@lang('front.buttons.razorpay')</a>
                                @endif
                                @if($credentials->offline_payment == 1)
                                    <a href="{{ route('front.offline-payment', [$booking->id]) }}" class="btn btn-custom btn-blue"><i class="fa fa-money mr-2"></i>@lang('front.buttons.offlinePayment')</a>
                                @endif
                            </div>
                        </div>
                    {{ session()->forget('error') }}
                    @endif
                </div>
                <div class="row mt-30">
                    <div class="col-12 text-center">
                        <a href="{{ route('front.index') }}" class="btn btn-custom">
                            <i class="fa fa-home mr-2"></i>
                            @lang('front.navigation.backToHome')</a>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection

@push('footer-script')
    @if($credentials->stripe_status == 'active')
        <script src="https://checkout.stripe.com/checkout.js"></script>
    @endif
    @if($credentials->razorpay_status == 'active')
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script>
            var options = {
                "key": "{{ $credentials->razorpay_key }}", // Enter the Key ID generated from the Dashboard
                "amount": "{{ $booking->amount_to_pay * 100 }}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise or INR 500.
                "currency": "INR",
                "name": "{{ $booking->user->name }}",
                "description": "@lang('app.booking') @lang('front.headings.payment')",
                "image": "{{ $settings->logo_url }}",
                "handler": function (response){
                    confirmRazorPayPayment(response.razorpay_payment_id, '{{ $booking->id }}', response);
                },
                "prefill": {
                    "email": "{{ $booking->user->email }}",
                    "contact": "{{ $booking->user->mobile }}"
                },
                "notes": {
                    "booking_id": "{{ $booking->id }}"
                },
                "theme": {
                    "color": "{{ $frontThemeSetting->primary_color }}"
                }
            };
            var rzp1 = new Razorpay(options);

            function startRazorPayPayment() {
                rzp1.open();
            }

            function confirmRazorPayPayment(paymentId, bookingId, response) {
                $.easyAjax({
                    url: '{{ route('front.razorpay') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        payment_id: paymentId,
                        booking_id: bookingId,
                        response: response
                    },
                    container: '#invoice_container',
                    redirect: true
                });
            }
        </script>
    @endif
    <script>
        @if($credentials->stripe_status == 'active')
        var token_triggered = false;
        var handler = StripeCheckout.configure({
            key: '{{ $credentials->stripe_client_id }}',
            image: '{{ $settings->logo_url }}',
            locale: 'auto',
            closed: function(data) {
                if (!token_triggered) {
                    $.easyUnblockUI('.statusSection');
                } else {
                    $.easyBlockUI('.statusSection');
                }
            },
            token: function(token) {
                token_triggered = true;
                // You can access the token ID with `token.id`.
                // Get the token ID to your server-side code for use.
                $.easyAjax({
                    url: '{{route('front.stripe', [$booking->id])}}',
                    container: '#invoice_container',
                    type: "POST",
                    redirect: true,
                    data: {token: token, "_token" : "{{ csrf_token() }}"}
                })
            }
        });

        document.getElementById('stripePaymentButton').addEventListener('click', function(e) {
            // Open Checkout with further options:
            handler.open({
                name: '{{ $setting->company_name }}',
                amount: {{ $booking->total*100 }},
                currency: '{{ $setting->currency->currency_code }}',
                email: "{{ $user->email }}"
            });
            $.easyBlockUI('.statusSection');
            e.preventDefault();
        });

        // Close Checkout on page navigation:
        window.addEventListener('popstate', function() {
            alert('hello');
            handler.close();
        });

        @endif
    </script>
@endpush
