@extends('layouts.front')

@section('content')
    <section class="section">
        <section class="sp-80 bg-w">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="all-title">
                            <h3 class="sec-title">
                                @lang('front.headings.paymentSuccess')
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="billing-info payment-box success-box">
                    <div class="alert alert-success" role="alert">
                        @lang('front.bookingSuccessful')
                    </div>
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
