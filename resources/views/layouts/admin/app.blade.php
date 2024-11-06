<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" translate="no">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google" content="notranslate">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" href="{{ asset('images/mipo/favicon.png') }}">

    <title>{{ config('app.name', 'Mipo') }} Admin @yield('pageTitle')</title>

    <x-website-seo/>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app-admin.css', 'resources/css/theme-admin.css'])
    <!-- Theme -->

    @yield('custom_style')

</head>

<body class="font-sans antialiased">
    <div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
        @include('layouts.admin.sidebar')
    </div>

    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
        <div class="loader-div">
            <div class="loader-icon">
                <lottie-player autoplay loop mode="normal" style="width: 100px;">
                </lottie-player>
            </div>
        </div>
        <header class="header header-sticky mb-4">
            @include('layouts.admin.navigation')

            <div class="container-fluid d-block">
                {{ $header }}
            </div>
        </header>

        <div class="body flex-grow-1 px-3">
            {{ $slot }}
        </div>

        <footer class="footer">
            @include('layouts.admin.footer')
        </footer>
    </div>

    <!-- CoreUI and necessary plugins-->
    <script>
        var loader_path = "{{ asset('plugins/loader/loading_ring_medium.json') }}";
        var login_user_id = parseInt("{{ Auth::user()->id }}");
        var route_name = ("{{ \Route::currentRouteName() }}");
    </script>

    <script src="{{ asset('plugins/jquery-3.3.1.min.js') }}"></script>

    @vite(['resources/js/app-admin.js', 'resources/js/theme-admin.js']);
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/style-admin.css') }}">

    @include('layouts.admin.en_to_es_javascript')

    <script src="{{ asset('plugins/toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/loader/lottie-player.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('js/admin-script.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin-mipo-script.js') }}" type="text/javascript"></script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JNZCR76MVE"></script>
    <script>

        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-JNZCR76MVE');

        $('#header_languages').change(function(e) {
            e.preventDefault();
            var self = $(this);
            var url_lang = self.find('option:selected').attr('data-href');
            window.location.href = url_lang;
        });
    </script>
    @yield('custom_script')
</body>

</html>
