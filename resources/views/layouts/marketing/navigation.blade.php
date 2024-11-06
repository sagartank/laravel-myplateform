<header class="header">
    <div class="header_wrap">
        <div class="container">
            <div class="main_header">
                <div class="header_logo">
                    <a href="javascript:;"><img src="{{ asset('images/marketing/mipo-logo.svg') }}" width="75" height="40" alt="mipo"></a>
                </div>
                <div class="ham_loginbtn">
                    <a href="{{ route('dashboard') }}">{{ Auth::check() ? __('Your account') : __('Login') }}</a>
                </div>
                <div class="menu-toggler">
                    <div class="menu-toggler-icon"></div>
                </div>
                @php
                    $current_route_name =  \Route::currentRouteName();
                    $active = 'active';
                @endphp
                <div class="navigation_bar">
                    <div class="nav-bar">
                        <ul>
                            <li><a href="{{ route('marketing.home') }}" class="{{ ($current_route_name == 'marketing.home') ? $active : ''}}">{{ __('Home') }}</a></li>
                            <li><a href="{{ route('about') }}" class="{{ ($current_route_name == 'about') ? $active : ''}}">{{  __('How it Works') }}</a></li>
                            <li><a href="{{ route('faq') }}" class="{{ ($current_route_name == 'faq') ? $active : ''}}">{{  __('F.A.Q.') }}</a></li>
                            <li><a href="{{ route('blog') }}" class="{{ ($current_route_name == 'blog' || $current_route_name == 'blog.post') ? $active : ''}}">{{ __('Blog') }}</a></li>
                            <li><a href="{{ route('marketing.contact-us-create') }}" class="{{ ($current_route_name == 'marketing.contact-us-create') ? $active : ''}}">{{ __('Contact Us') }}</a></li>
                        </ul>
                    </div>
                    <div class="header_btn">
                        <div class="{{ Auth::check() ? 'get_btn' : 'login_btn' }}">
                            <a href="{{ route('dashboard') }}">{{ Auth::check() ? __('Your account') : __('Login') }}</a>
                        </div>
                        
                        @if(!Auth::check())
                            <div class="get_btn">
                                <a href="{{ route('register') }}">{{ __('Create Account') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>