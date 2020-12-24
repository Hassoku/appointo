<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ ucfirst($settings->company_name)}}</title>

    <link rel="icon" href="{{ asset('favicon/favicon.ico') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/css/front-styles.css') }}">
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/helper.css') }}">

    <style>
        :root {
            --primary-color: {{ $frontThemeSettings->primary_color }};
            --dark-primary-color: {{ $frontThemeSettings->primary_color }};
        }
    </style>
</head>


<body>

    @include('sections.header')

    @yield('content')

    @include('sections.footer')

    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-lg in" id="application-modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> @lang('app.cancel')</button>
                    <button type="button" class="btn btn-success"><i class="fa fa-check"></i> @lang('app.save')</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}

    <script src="{{ asset('assets/js/front-scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.js"></script>
    <script>
        $(function() {
            toastr.options = {
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": true
            };
        });

        function makeSingular(time, type) {
            singular = '';

            if (time == 1) {
                switch (type) {
                    case 'minutes':
                        singular = 'minute';
                        break;
                    case 'hours':
                        singular = 'hour';
                        break;
                    case 'days':
                        singular = 'day';
                        break;
                    default:
                        break;
                }
                return singular;
            }
            return type;
        }

        function goToPage(method, pageUrl, data = null) {
            var options = {
                url: pageUrl,
                type: method,
                // container: 'section.section'
                success: function (response) {
                    if (response.status !== 'fail') {
                        window.location.href = pageUrl
                    }
                }
            };

            if (data) {
                options.data = data
            }

            $.easyAjax(options)
        }

        var LightenColor = function(color, percent) {
            var num = parseInt(color.replace('#',''),16),
                amt = Math.round(2.55 * percent),
                R = (num >> 16) + amt,
                B = (num >> 8 & 0x00FF) + amt,
                G = (num & 0x0000FF) + amt;

            return (0x1000000 + (R<255?R<1?0:R:255)*0x10000 + (B<255?B<1?0:B:255)*0x100 + (G<255?G<1?0:G:255)).toString(16).slice(1);
        };

        var DarkenColor = function(color, percent) {
            var num = parseInt(color.replace('#',''),16),
                amt = Math.round(2.55 * percent),
                R = (num >> 16) - amt,
                B = (num >> 8 & 0x00FF) - amt,
                G = (num & 0x0000FF) - amt;

            return (0x1000000 + (R<255?R<1?0:R:255)*0x10000 + (B<255?B<1?0:B:255)*0x100 + (G<255?G<1?0:G:255)).toString(16).slice(1);
        };

        var primaryColor = getComputedStyle(document.documentElement)
            .getPropertyValue('--primary-color');

        document.documentElement.style.setProperty('--dark-primary-color', '#'+DarkenColor(primaryColor, 15));
    </script>

    @stack('footer-script')

</body>

</html>
