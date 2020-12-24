@extends('layouts.auth')

@section('content')
    <span class="logo-box">
        <img src="{{ $frontThemeSettings->logo_url }}" alt="logo">
    </span>
    @if (session('status'))
        <div class="alert alert-success alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {{ session('status') }}
        </div>
    @endif
    <h4 class="mb-30">@lang('app.resetPassword')</h4>
    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="input-group">
            <i class="fa fa-envelope"></i>
            <input type="email" name="email" id="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required autofocus>
            <label for="email">@lang('app.email')</label>
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <button type="submit" class="btn btn-custom btn-blue w-100 mb-3">@lang('app.sendPassResetLink')</button>
        <div class="social-auth-links text-center">
            <p>- OR -</p>
        </div>
        <div class="d-flex justify-content-between">
            <a href="{{ route('front.index') }}" class="btn btn-custom">@lang('front.navigation.backToHome')</a>
            <a href="{{ route('login') }}" class="btn btn-custom btn-blue">@lang('app.signIn')</a>
        </div>
    </form>
@endsection
