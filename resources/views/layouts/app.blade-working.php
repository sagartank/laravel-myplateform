<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- PWA  -->
        <meta name="theme-color" content="#0D6EFD"/>
        <link rel="apple-touch-icon" href="{{ asset('/images/logo.svg') }}">
        <link rel="manifest" href="{{ asset('/manifest.json') }}">

        <title>{{ config('app.name', 'Mipo') }}</title>

        <!-- Scripts -->
        @vite(['resources/js/app.js'])

        <!-- Custom CSS -->
        <link href="{{ asset('plugins/nice-select/nice-select.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/toastr/toastr.min.css') }}" rel="stylesheet">
        
        @yield('custom_style')
        <link href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
        <!-- <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" /> -->
        <link href="{{ asset('css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />

        <link href="{{ asset('css/style-front.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/responsive.css') }}" rel="stylesheet" />
    </head>
    <body class="font-sans antialiased">

        <div class="dashboard_main">
            @include('layouts.navigation')
            <div class="loader-div">
                <div class="loader-icon">
                    <lottie-player autoplay loop mode="normal" style="width: 100px;">
                    </lottie-player>
                </div>
            </div>

            <!-- Page Content -->
            <div>
                {{ $slot }}
            </div>
        </div>
        
        <script>
            var loader_path  = "{{ asset('plugins/loader/loading_ring_medium.json') }}";
            var login_user_id = parseInt("{{ Auth::user()->id }}");
            var route_name = ("{{ \Route::currentRouteName() }}");
        </script>
        <script src="{{ asset('plugins/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/bootstrap/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/nice-select/jquery.nice-select.min.js') }}"></script>
        <script src="{{ asset('plugins/toastr/toastr.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/loader/lottie-player.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('plugins/jquery-validation/additional-methods.js') }}"></script>
        <script src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>
        <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
        <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('js/responsive.bootstrap5.min.js') }}"></script>

        <script src="{{ asset('js/custom-validation.js') }}"></script>
        <script src="{{ asset('js/jquery.number.min.js') }}"></script>
        <script src="{{ asset('plugins/blockui/jquery.blockUI.js') }}"></script>
        <!-- Custom Javascript -->
        <script src="{{ asset('js/constant.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="{{ asset('js/script-dev.js') }}"></script>
        
        @yield('custom_script')

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-JNZCR76MVE"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'G-JNZCR76MVE');
        </script>
        <script src="{{ asset('/sw.js') }}"></script>
        <script>
            if (!navigator.serviceWorker.controller) {
                navigator.serviceWorker.register("/sw.js").then(function (reg) {
                    console.log("Service worker has been registered for scope: " + reg.scope);
                });
            }
        </script>
    </body>
</html>
