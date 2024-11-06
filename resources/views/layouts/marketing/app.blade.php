<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  translate="no">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <x-website-pwa/>

        <title>{{ config('app.name', 'Mipo') }} @yield('pageTitle')</title>

        <x-website-seo/>

		<link rel="stylesheet" type="text/css" href="{{ asset('css/marketing/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/marketing/style.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('fonts/marketing/font.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/marketing/responsive.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/marketing/owl.carousel.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/toastr/toastr.min.css') }}">
        <link href="https://vjs.zencdn.net/8.6.1/video-js.css" rel="stylesheet" />

        @yield('custom_style')
	</head>
	<body>
		<div class="main_wapper">
           
            @include('layouts.marketing.navigation')
            
            {{ $slot }}

            @include('layouts.marketing.footer')

        </div>
        <script>
            var all_fields_are_required_en_msg = "{{ __('All fields are required.') }}";
        </script>
        <script src="{{ asset('js/marketing/bootstrap.min.js') }}"></script>
		<script src="{{ asset('js/marketing/jquery.min.js') }}"></script>
		<script src="{{ asset('js/marketing/owl.carousel.min.js') }}"></script>
		{{-- <script src="{{ asset('js/marketing/gsap.min.js') }}"></script> --}}
		{{-- <script src="{{ asset('js/marketing/ScrollTrigger.min.js') }}"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.3.4/gsap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.3.4/ScrollTrigger.min.js"></script>
        <script src="{{ asset('plugins/toastr/toastr.min.js') }}" type="text/javascript"></script>
        <script src="https://vjs.zencdn.net/8.6.1/video.min.js"></script>
		<script src="{{ asset('js/marketing/script.js') }}"></script>

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

                // install app pwa
                let deferredPrompt = null;

                window.addEventListener('beforeinstallprompt', (e) => {
                    deferredPrompt = e;
                });

                const installApp = document.getElementById('download_here_pwa');

                installApp.addEventListener('click', async () => {
                    if (deferredPrompt !== null) {
                        deferredPrompt.prompt();
                        const { outcome } = await deferredPrompt.userChoice;
                        if (outcome === 'accepted') {
                            deferredPrompt = null;
                        }
                    }
                });
        </script>
        @yield('custom_script')
	</body>
</html>