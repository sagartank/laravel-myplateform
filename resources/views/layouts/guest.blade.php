<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  translate="no">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('images/mipo/favicon.png') }}">

        <title>{{ config('app.name', 'Mipo') }} @yield('pageTitle')</title>

        <x-website-seo/>

        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('plugins/nice-select/nice-select.css') }}">
        <link href="{{ asset('css/style-front.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/style-web.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive-web.css') }}">

        @yield('custom_style')
        <script>
            var route_name = ("{{ \Route::currentRouteName() }}");
        </script>
    </head>
    <body>
        <div>
            {{ $slot }}
        </div>

        <script src="{{ asset('plugins/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/bootstrap/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/nice-select/jquery.nice-select.min.js') }}"></script>
        <script src="{{ asset('plugins/toastr/toastr.min.js') }}" type="text/javascript"></script>

        <!-- Custom Javascript -->
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="{{ asset('js/script-dev.js') }}"></script>

        @yield('custom_script')
    </body>
</html>
