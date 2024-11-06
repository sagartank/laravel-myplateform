{{--
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
--}}

<!-- Header start -->
@php
    $current_route_name =  \Route::currentRouteName();
    $active = 'current';
    $active_mob = 'active';
    $user = auth()->user(); 
    $count_notifications = $user->unreadNotifications->count();
@endphp



<header class="header_main">
    {{-- android app install notification --}}
        <div class="mobile_app_notification" id="mobile_app_notification">
            <div class="mobile_wrap">
                <div class="img_text">
                    <div class="image" id="android-close-btn">
                        <img src="{{ asset('images/mipo/mobile-application-white-close.svg') }}" alt="no-img">
                    </div>
                    <div class="text_wrapper">
                        <h6>{!! __('Mipo') !!}</h6>
                        <p>{!! __('Get our free app. It won’t take up space on your phone') !!}</p>
                    </div>
                </div>
                <div class="install_btn" id="androi_install_btn">
                    <a href="javascript:;">{!! __('Install') !!}</a>
                </div>
            </div>
        </div>
    {{-- android app install notification --}}
    <div class="container">
        <div class="header_wrap">
            <div class="head_left">
                <div class="logo">
                    <a href="/">
                        <!-- <img src="{{ asset('images/logo-white.svg') }}" alt="logo"> -->
                        <svg width="57" height="33" viewBox="0 0 57 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g filter="url(#filter0_d_4010_201)">
                            <path d="M5.87029 24.676V16.3554C5.87029 14.3037 6.86713 13.4488 8.12031 13.4488C9.51589 13.4488 10.2279 14.5601 10.2279 16.3269V24.676H15.0982V16.3554C15.0982 14.3037 16.1235 13.4488 17.3482 13.4488C18.7438 13.4488 19.4558 14.5601 19.4558 16.3269V24.676H24.3261V14.8166C24.3261 11.0837 22.19 9.06055 19.1425 9.06055C16.8925 9.06055 15.5254 9.9439 14.2153 11.4257C13.3609 9.88691 11.8229 9.06055 9.88615 9.06055C7.89246 9.06055 6.63928 9.85842 5.47155 11.2262V9.3455H1V24.676H5.87029Z" fill="white" class="svg-elem-1"></path>
                            <path d="M5.87029 24.676V16.3554C5.87029 14.3037 6.86713 13.4488 8.12031 13.4488C9.51589 13.4488 10.2279 14.5601 10.2279 16.3269V24.676H15.0982V16.3554C15.0982 14.3037 16.1235 13.4488 17.3482 13.4488C18.7438 13.4488 19.4558 14.5601 19.4558 16.3269V24.676H24.3261V14.8166C24.3261 11.0837 22.19 9.06055 19.1425 9.06055C16.8925 9.06055 15.5254 9.9439 14.2153 11.4257C13.3609 9.88691 11.8229 9.06055 9.88615 9.06055C7.89246 9.06055 6.63928 9.85842 5.47155 11.2262V9.3455H1V24.676H5.87029Z" stroke="white" class="svg-elem-2"></path>
                            </g>
                            <g filter="url(#filter1_d_4010_201)">
                            <path d="M28.2449 4.79254C28.2449 3.16831 26.9632 2 25.1119 2C23.2607 2 21.979 3.16831 21.979 4.79254C21.979 6.38828 23.2607 7.55659 25.1119 7.55659C26.9632 7.55659 28.2449 6.38828 28.2449 4.79254ZM27.5898 24.6761V9.3456H22.7195V24.6761H27.5898Z" fill="white" class="svg-elem-3"></path>
                            <path d="M28.2449 4.79254C28.2449 3.16831 26.9632 2 25.1119 2C23.2607 2 21.979 3.16831 21.979 4.79254C21.979 6.38828 23.2607 7.55659 25.1119 7.55659C26.9632 7.55659 28.2449 6.38828 28.2449 4.79254ZM27.5898 24.6761V9.3456H22.7195V24.6761H27.5898Z" stroke="white" class="svg-elem-4"></path>
                            </g>
                            <g filter="url(#filter2_d_4010_201)">
                            <path d="M42.1121 16.8681C42.1121 12.4909 39.4087 8.93799 35.2825 8.93799C33.4897 8.93799 31.9815 9.64858 30.7294 10.9561V9.34548H26.2617L26.2617 29.9998H31.1278V23.0929C32.323 24.2298 33.6889 24.7983 35.2825 24.7983C39.4087 24.7983 42.1121 21.3022 42.1121 16.8681ZM37.0468 16.8681C37.0468 19.3125 35.5955 20.4211 34.1158 20.4211C32.636 20.4211 31.1847 19.341 31.1847 16.8966C31.1847 14.4806 32.6076 13.3152 34.1158 13.3152C35.5955 13.3152 37.0468 14.4806 37.0468 16.8681Z" fill="white" class="svg-elem-5"></path>
                            <path d="M42.1121 16.8681C42.1121 12.4909 39.4087 8.93799 35.2825 8.93799C33.4897 8.93799 31.9815 9.64858 30.7294 10.9561V9.34548H26.2617L26.2617 29.9998H31.1278V23.0929C32.323 24.2298 33.6889 24.7983 35.2825 24.7983C39.4087 24.7983 42.1121 21.3022 42.1121 16.8681ZM37.0468 16.8681C37.0468 19.3125 35.5955 20.4211 34.1158 20.4211C32.636 20.4211 31.1847 19.341 31.1847 16.8966C31.1847 14.4806 32.6076 13.3152 34.1158 13.3152C35.5955 13.3152 37.0468 14.4806 37.0468 16.8681Z" stroke="white" class="svg-elem-6"></path>
                            </g>
                            <g filter="url(#filter3_d_4010_201)">
                            <path d="M46.1988 24.7963C50.6131 24.7963 54.0002 21.2438 54.0002 16.8671C54.0002 12.4905 50.6131 8.93799 46.1988 8.93799C41.7845 8.93799 38.3975 12.4905 38.3975 16.8671C38.3975 21.2438 41.7845 24.7963 46.1988 24.7963ZM46.1988 20.448C44.7274 20.448 43.3393 19.2544 43.3393 16.8671C43.3393 14.4799 44.7274 13.3146 46.1988 13.3146C47.6703 13.3146 49.0584 14.4799 49.0584 16.8671C49.0584 19.2544 47.6703 20.448 46.1988 20.448Z" fill="white" class="svg-elem-7"></path>
                            <path d="M46.1988 24.7963C50.6131 24.7963 54.0002 21.2438 54.0002 16.8671C54.0002 12.4905 50.6131 8.93799 46.1988 8.93799C41.7845 8.93799 38.3975 12.4905 38.3975 16.8671C38.3975 21.2438 41.7845 24.7963 46.1988 24.7963ZM46.1988 20.448C44.7274 20.448 43.3393 19.2544 43.3393 16.8671C43.3393 14.4799 44.7274 13.3146 46.1988 13.3146C47.6703 13.3146 49.0584 14.4799 49.0584 16.8671C49.0584 19.2544 47.6703 20.448 46.1988 20.448Z" stroke="white" class="svg-elem-8"></path>
                            </g>
                            <defs>
                            <filter id="filter0_d_4010_201" x="0.5" y="8.56055" width="24.3262" height="17.0492" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                            <feOffset dy="0.433923"></feOffset>
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"></feColorMatrix>
                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_4010_201"></feBlend>
                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_4010_201" result="shape"></feBlend>
                            </filter>
                            <filter id="filter1_d_4010_201" x="19.9212" y="0.665421" width="10.3817" height="26.7918" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                            <feOffset dy="0.723205"></feOffset>
                            <feGaussianBlur stdDeviation="0.778892"></feGaussianBlur>
                            <feColorMatrix type="matrix" values="0 0 0 0 0.101961 0 0 0 0 0.443137 0 0 0 0 0.858824 0 0 0 0.25 0"></feColorMatrix>
                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_4010_201"></feBlend>
                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_4010_201" result="shape"></feBlend>
                            </filter>
                            <filter id="filter2_d_4010_201" x="24.2039" y="7.60341" width="19.9662" height="25.1776" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                            <feOffset dy="0.723205"></feOffset>
                            <feGaussianBlur stdDeviation="0.778892"></feGaussianBlur>
                            <feColorMatrix type="matrix" values="0 0 0 0 0.101961 0 0 0 0 0.443137 0 0 0 0 0.858824 0 0 0 0.25 0"></feColorMatrix>
                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_4010_201"></feBlend>
                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_4010_201" result="shape"></feBlend>
                            </filter>
                            <filter id="filter3_d_4010_201" x="36.3397" y="7.60341" width="19.7181" height="19.974" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                            <feOffset dy="0.723205"></feOffset>
                            <feGaussianBlur stdDeviation="0.778892"></feGaussianBlur>
                            <feColorMatrix type="matrix" values="0 0 0 0 0.101961 0 0 0 0 0.443137 0 0 0 0 0.858824 0 0 0 0.25 0"></feColorMatrix>
                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_4010_201"></feBlend>
                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_4010_201" result="shape"></feBlend>
                            </filter>
                            </defs>
                        </svg>
                    </a>
                </div>
                <nav class="nav_links">
                    <ul>
                        @permission('user-side-dashboard')
                        <li class="{{ ($current_route_name == 'dashboard' || $current_route_name == 'notifications.index') ? $active : ''}} tur_first"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        @endpermission
                        @permission('explore-operations')
                        <li class="{{ ($current_route_name == 'explore-operations.index' || $current_route_name == 'explore-operations.details' || $current_route_name == 'offered-operations.index') ? $active : ''}} tur_second"><a href="{{route('explore-operations.index')}}">{{ __('Explore Operations') }}</a></li>
                        @endpermission
                        @permission('my-operations')
                        <li class="{{ ($current_route_name == 'operations.index' || $current_route_name == 'operations.details' || $current_route_name == 'operations.create') ? $active : ''}} tur_third"><a href="{{ route('operations.index') }}">{{ __('My Operations') }}</a></li>
                        @endpermission
                        @permission('buyer-seller-deals')
                        <li class="{{ ($current_route_name == 'deals.index' || $current_route_name == 'deals.details') ? $active : ''}} tur_fourth"><a href="{{ route('deals.index') }}">{{ __('Deals') }}</a></li>
                        @endpermission
                        @if(session('authAdminUser'))
                        <li class="text-bg-danger"><a href="javascript::;">{{ __('Logged as SuperAdmin') }}</a></li>
                        @endif
                    </ul>
                </nav>
            </div>
            <div class="head_right">
                <div class="mb_tawk">
                    <a href="javascript:void(0)" role="button" id="evt_mobile_tawk"><img role="button" src="{{ asset('images/mipo/mb-care.svg') }}" alt="no-image"></a>
                </div>
                <div class="head_notify">
                    <a href="javascript:void(0)">
                        <img src="{{ asset('images/mipo/head_noti.svg') }}" alt="notofication-image">
                        @if($count_notifications > 0)
                            <i class="headernoti_dot"><span></span></i>
                        @endif
                    </a>
                    @if($count_notifications > 0)
                        <x-notification></x-notification>
                    @endif
                </div>
                <div class="profile_box">
                    <div class="user_box">                        
                        <div class="dropdown">                            
                            <a href="javascript:;" class="custom_user_btn_dropdown">
                                <span class="thumb"><img id="user-login-profile" src="{{ Auth::user()->profile_image ? route('secure-image', Crypt::encryptString(Auth::user()->profile_image)) : asset('images/profile-stock.png') }}" alt="image"></span>
                                <div class="user_text">
                                    <h6 id="user-login-name">{{ Auth::user()->name }}</h6>
                                    <span>{{ __('Basic Account')}}</span>
                                </div>
                            </a>
                            <!-- <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                @permission('user-side-profile')
                                <li><a class="dropdown-item" href="{{route('profile.index')}}">{{ __('Profile') }}</a></li>
                                @endpermission
                                @if(session('authAdminUser'))
                                <li><a class="dropdown-item" id="" href="{{route('users.back-to-superadmin-login')}}">{{ __('Back to SuperAdmin') }}</a></li>
                                @else
                                <li><a class="dropdown-item" id="web-logout" href="javascript:;">{{ __('Logout') }}</a></li>
                                @endif
                            </ul> -->
                            <div class="custom_user_list">
                                <ul>
                                    <li class="user_acount_li">
                                        <div class="main_active_account">
                                            <a href="javascript:void(0)" class="dropdown_account main_account">
                                                <div class="dro-main">
                                                    <div class="dropdown_account_img">
                                                        <i>
                                                            <img src="{{ Auth::user()->profile_image ? route('secure-image', Crypt::encryptString(Auth::user()->profile_image)) : asset('images/profile-stock.png') }}" alt="mipo">
                                                        </i>
                                                    </div>
                                                    <div class="dropdown_account_dtl">
                                                        <div class="dropdown_account_name">{{ Auth::user()->name }}</div>
                                                        <div class="dropdown_account_email">{{ Auth::user()->email }}</div>
                                                    </div>
                                                    <div class="dorpdown_email">
                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="8" cy="8" r="8" fill="#F0FDF6"/>
                                                            <circle cx="7.99989" cy="8.00001" r="3.55555" fill="#198754"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </a>
                                            @if(count(app('common')->getUserCompanyList()) > 0)
                                                @foreach(app('common')->getUserCompanyList() as $cmp)
                                                <div class="dropdown_account_list">
                                                    <a href="{{ route('users.login-as-website-user', $cmp->slug) }}"  class="dropdown_account">
                                                        <div class="dropdown_account">
                                                            <div class="dropdown_account_img">
                                                                <i>
                                                                    <img src="{{ $cmp->profile_image ? route('secure-image', Crypt::encryptString($cmp->profile_image)) : asset('images/profile-stock.png') }}" alt="mipo">
                                                                </i>
                                                            </div>
                                                            <div class="dropdown_account_dtl">
                                                                <div class="dropdown_account_name">{{  $cmp->name }}</div>
                                                                <div class="dropdown_account_email">{{  $cmp->email }}</div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </li>
                                    <li class="sub_drop">
                                        <ul class="inner_drop">
                                            <li class="custom_user_links">
                                                <a href="{{ route('profile.index') }}">
                                                    <i class="light">
                                                        <img src="{{asset('images/user-icon-dropdown.svg')}}" alt="mipo">
                                                    </i>
                                                    <i class="dark">
                                                        <img src="{{asset('images/mipo/dark-account.svg')}}" alt="mipo">
                                                    </i>
                                                    {!! __('Account') !!}
                                                </a>
                                            </li>
                                            <li class="custom_user_links">
                                                <a href="javascript:;" id="install_our_app" class="cmn_trigger_installmipo">
                                                    <i class="light">
                                                        <img src="{{asset('images/mipo/profiledownload.svg')}}" alt="mipo">
                                                    </i>
                                                    <i class="dark">
                                                        <img src="{{asset('images/mipo/dark-download.svg')}}" alt="mipo">
                                                    </i>
                                                    {!! __('Download Our App') !!}
                                                </a>
                                            </li>
                                            <li class="custom_user_links" id="tutorial">
                                                <a href="javascript:;">
                                                    <i class="light">
                                                        <img src="{{asset('images/mipo/tutorial_pro.svg')}}" alt="mipo">
                                                    </i>
                                                    <i class="dark">
                                                        <img src="{{asset('images/mipo/dark-tour.svg')}}" alt="mipo">
                                                    </i>
                                                    {!! __('Tutorial') !!}
                                                </a>
                                            </li>
                                            <li class="custom_user_links">
                                                <div class="dark_mode_dropdown">
                                                    <div class="dark_mode_left">
                                                        <i class="light">
                                                            <img src="{{asset('images/darkmode-icon.svg')}}" alt="mipo">
                                                        </i>
                                                        <i class="dark">
                                                            <img src="{{asset('images/mipo/dark-moon.svg')}}" alt="mipo">
                                                        </i>
                                                        {!! __('Dark Mode') !!}
                                                    </div>
                                                    <div class="dark_mode_right">
                                                        <div class="form-check form-switch form-switch-lg">
                                                            <input class="form-check-input evt_dark_mode_right" type="checkbox" role="switch" id="darkmod">
                                                            <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            {{-- language tab:st --}}
                                            <li class="custom_user_links">
                                                <div class="lan_change_block">
                                                    <div class="lantitle_left">
                                                        <i class="light">
                                                            <img src="{{asset('images/mipo/lan_change.svg')}}" alt="translate">
                                                        </i>
                                                        <i class="dark">
                                                            <img src="{{asset('images/mipo/dark_trans.svg')}}" alt="translate">
                                                        </i>
                                                       <span class="text-16-medium">{!! __('Language') !!} </span>
                                                    </div>
                                                    <div class="lanchang_right">
                                                        <div class="lan-contain">
                                                            <a href="{{ url('locale', 'es') }}" data-language-short-code="es" data-select-language="Español" data-type="language"  class="lan_left {{ app()->getLocale() == 'es' ? 'active' : '' }}"><i><img src="{{ asset('images/mipo/log-esp.svg') }}" alt="no-image"></i>ES</a>
                                                            <a href="{{ url('locale', 'en') }}" data-language-short-code="en" data-select-language="English" data-type="language" class="lan-right {{ app()->getLocale() == 'en' ? 'active' : '' }}"><i><img src="{{ asset('images/mipo/log-eng.svg') }}" alt="no-image"></i>EN</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            {{-- language tab:nd --}}
                                            <li class="custom_user_links custom_user_links-sign-out">
                                                <a href="javascript:void(0)" id="web-logout" title="{{ __('Sign off')}}">
                                                    <i>
                                                        <img src="{{asset('images/sign-out-red-dropdown.svg')}}" alt="mipo">
                                                    </i>
                                                    {!! __('Log Out') !!}
                                                </a>
                                            </li>
                                            
                                            @if(session('authWebsiteUser'))
                                            <li class="custom_user_links">
                                                <a href="{{ route('users.back-to-website-login') }}">
                                                    <i>
                                                        <img src="{{asset('images/setting-icon-dropdown.svg')}}" alt="mipo">
                                                    </i>
                                                    {{ __('Back To Main Login')}}
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="mobile_nav">
    <ul>
        @permission('user-side-dashboard')
        <li class="mob_tur_first">
            <a href="{{ route('dashboard') }}" class="{{ ($current_route_name == 'dashboard' || $current_route_name == 'notifications.index') ? $active_mob : ''}}">
                <div class="icon">
                    <img class="default_img" src="{{ asset('images/mipo/mobiledefaulthome.svg') }}" alt="no-image">
                    <img class="active_img" src="{{ asset('images/mipo/mobileactivehome.svg') }}" alt="no-image">
                    <img class="dark_img" src="{{ asset('images/mipo/mobiledarkhome.svg') }}" alt="no-image">
                </div>
                {{-- <span>{{ __('Dashboard') }}</span> --}}
            </a>
        </li>
        @endpermission
        @permission('explore-operations')
        <li class="mob_tur_second">
            <a href="{{route('explore-operations.index')}}" class="{{ ($current_route_name == 'explore-operations.index' || $current_route_name == 'explore-operations.details' || $current_route_name == 'offered-operations.index') ? $active_mob : ''}}">
                <div class="icon">
                    <img class="default_img" src="{{ asset('images/mipo/mobiledefaultexplorar.svg') }}" alt="no-image">
                    <img class="active_img" src="{{ asset('images/mipo/mobileactiveexplorar.svg') }}" alt="no-image">
                    <img class="dark_img" src="{{ asset('images/mipo/mobiledarkexplorar.svg') }}" alt="no-image">
                </div>
                {{-- <span>{{ __('Explore')}}</span> --}}
            </a>
        </li>
        @endpermission
        @permission('my-operations')
        <li class="mob_tur_third">
            <a href="{{ route('operations.index') }}" class="{{ ($current_route_name == 'operations.index' || $current_route_name == 'operations.details' || $current_route_name == 'operations.create') ? $active_mob : ''}}">
                <div class="icon">
                    <img class="default_img" src="{{ asset('images/mipo/mobiledefaultdoc.svg') }}" alt="no-image">
                    <img class="active_img" src="{{ asset('images/mipo/mobileactivedoc.svg') }}" alt="no-image">
                    <img class="dark_img" src="{{ asset('images/mipo/mobiledarkdoc.svg') }}" alt="no-image">
                </div>
                {{-- <span>{{ __('Doctument') }}</span> --}}
            </a>
        </li>
        @endpermission
        @permission('buyer-seller-deals')
        <li class="mob_tur_fourth">
            <a href="{{ route('deals.index') }}" class="{{ ($current_route_name == 'deals.index' || $current_route_name == 'deals.details') ? $active_mob : ''}}">
                <div class="icon">
                    <img class="default_img" src="{{ asset('images/mipo/mobiledefaultdeal.svg') }}" alt="no-image">
                    <img class="active_img" src="{{ asset('images/mipo/mobileactivedeal.svg') }}" alt="no-image">
                    <img class="dark_img" src="{{ asset('images/mipo/mobiledarkdeals.svg') }}" alt="no-image">
                </div>
                {{-- <span>{{ __('Deals') }}</span> --}}
            </a>
        </li>
        @endpermission
    </ul>
</div>
<form action="{{ route('logout') }}" id="web-logout-form" name="logout-form" method="post">
    @csrf
</form>
<!-- Header end -->
