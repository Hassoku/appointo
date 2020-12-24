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
    <form action="{{ route('password.request') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
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
        <div class="input-group">
            <i class="fa fa-lock"></i>
            <input type="password" id="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
            <label for="password">@lang('app.password')</label>
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="input-group">
            <i class="fa fa-lock"></i>
            <input type="password" id="password_confirmation" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password_confirmation" required>
            <label for="password_confirmation">@lang('app.passwordConfirmation')</label>
        </div>
        <button type="submit" class="btn btn-custom btn-blue w-100 mb-3">@lang('app.resetPassword')</button>
        <div class="social-auth-links text-center">
            <p>- OR -</p>
        </div>
        <a href="{{ route('login') }}" class="btn btn-custom w-100 mb-3">@lang('app.signIn')</a>
    </form>
@endsection
