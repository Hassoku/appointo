<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="keywords" content="">

        <title>{{ $pageTitle . ' | ' . $settings->company_name }}</title>

        <link rel="icon" href="{{ asset('favicon/favicon.ico') }}" type="image/x-icon" />
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        {{--<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.css') }}">--}}
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

        <style>
            :root {
                --primary-color: {{ $frontThemeSettings->primary_color }};
                --dark-primary-color: {{ $frontThemeSettings->primary_color }};
            }
        </style>
    </head>
    <body class="login-body-wrapper">
        <div class="login-page">
            <div class="login-box">
                <div class="logo-login text-center">
                    @yield('content')
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        {{--<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>--}}

    </body>
</html>
