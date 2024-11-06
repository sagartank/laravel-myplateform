<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" translate="no">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google" content="notranslate">
    <link rel="icon" type="image/png" href="{{ asset('images/mipo/favicon.png') }}">

    <x-website-pwa/>
    
    <title>{{ config('app.name', 'Mipo') }} @yield('pageTitle')</title>
    
    <x-website-seo/>

    <!-- scripts and css -->
    @vite(['resources/js/app.js', 'resources/css/app.css'])

    <link rel="stylesheet" href="{{ asset('css/style-front.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tostr-notification-custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-web.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive-web.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/shepherd/shepherd.css') }}">
    
    <!-- Custom CSS -->
    <style>
    .pace {
	-webkit-pointer-events: none;
	pointer-events: none;

	-webkit-user-select: none;
	-moz-user-select: none;
	user-select: none;
    }

    .pace-inactive {
        display: none;
    }

    .pace .pace-progress {
        background: #0D6EFD;
        position: fixed;
        z-index: 2000;
        top: 0;
        right: 100%;
        width: 100%;
        height: 5px;
    }
    </style>
    @yield('custom_style')
</head>

<body class="font-sans antialiased">

    <div class="dashboard_main">
        @include('layouts.navigation')
        <div class="loader-div pace">
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

    @include('layouts.install-mipo-app')

    @include('layouts.en_to_es_javascript')

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
    <script src="{{ asset('plugins/shepherd/shepherd.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <!-- Custom Javascript -->
    <script src="{{ asset('js/constant.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/script-dev.js') }}"></script>
    <script src="{{ asset('js/script-web.js') }}"></script>
    <script src="{{ asset('js/temp.js') }}"></script>
    {{-- <script src="{{ asset('js/pace.min.js') }}"></script> --}}
    @yield('custom_script')

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JNZCR76MVE"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-JNZCR76MVE');
    </script>
    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").then(function(reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
    </script>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        // var Tawk_API = Tawk_API || {},
        //     Tawk_LoadStart = new Date();
        // (function() {
        //     var s1 = document.createElement("script"),
        //         s0 = document.getElementsByTagName("script")[0];
        //     s1.async = true;
        //     // s1.src = 'https://embed.tawk.to/647875a3ad80445890f06964/1h1r8n28m' for skt;
        //     s1.src='https://embed.tawk.to/646352fe74285f0ec46bb89b/1h0hvocm4';
        //     s1.charset = 'UTF-8';
        //     s1.setAttribute('crossorigin', '*');
        //     s0.parentNode.insertBefore(s1, s0);
        
        //     Tawk_API.visitor = {
        //     name: "{{ Auth::user()->name }}",
        //     email: "{{ Auth::user()->email }}",
        //     // hash: '{{ hash_hmac("sha256", "Auth::user()->email", "9382a61a2011f325b7ae97a47745609d83f0b9fb") }} for skt'
        //     hash: '{{ hash_hmac("sha256", "Auth::user()->email", "c0000f7e237423c6795f8648cbaddaccf202d277") }}'
        // };
        // })();
        
        // $(document).on('click', '.evt_web_open_chat', function(){
        //     Tawk_API.toggle()
        // });
    </script>
    <!--End of Tawk.to Script-->
</body>
</html>
