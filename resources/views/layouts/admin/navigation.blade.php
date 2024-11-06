<div class="container-fluid">
    <button class="header-toggler px-md-0 me-md-3" type="button"
        onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
        <i class="icon icon-2xl cil-hamburger-menu"></i>
    </button>
    <a class="header-brand d-md-none" href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('images/logo.png') }}" width="70">
    </a>
    <ul class="header-nav d-none d-md-flex">
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        {{--        <li class="nav-item"><a class="nav-link" href="javascript:;">Users</a></li> --}}
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.index') }}">{{ __('Settings') }}</a>
        </li>
    </ul>

    <ul class="header-nav ms-auto d-none d-md-flex">
        <li class="nav-item">
            <a class="nav-link" href="javascript:;">
                <svg class="icon icon-lg">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
                </svg>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:;">
                <svg class="icon icon-lg">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-list-rich"></use>
                </svg>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:;">
                <svg class="icon icon-lg">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-envelope-open"></use>
                </svg>
            </a>
        </li>
    </ul>
    <ul class="header-nav ms-3">
        @php
            $notifications = Auth()->user()->unreadNotifications;
            $is_send_admin_notification = config('constants.SEND_NOTIFICATION_ADMIN');
        @endphp
         @if ($notifications->count() > 0 && $is_send_admin_notification == true)
        <li>
            <div class="admin_notibox">
                <img src="{{ asset('images/mipo/blacknoti.svg') }}" alt="no-image" role="button">
                <i class="notidot"></i>
            </div>
            <div class="notify_dropdon">
                <div class="notify_title">
                    <h4>{{ __('Notifications')}}</h4>
                    {{-- <p><a href="javascript:;">{{ __('Mark all as read')}}</a></p> --}}
                </div>

                <div class="notify_list">
                    @foreach ($notifications as $key => $notification)  
                        <div class="notify_item flxrow">
                            <div class="notify_user flxrow">
                                <div class="user flxfix"></div>
                                <div class="info flxflexi">
                                    {{-- <h6>{!! $notification->data['name'] ?? $notification->data['email'] !!}</h6> --}}
                                    <p>{!! $notification->data['title'] ?? '' !!}</p>
                                </div>
                            </div>
                            <div class="min_ago">{!!  $notification->created_at->diffForHumans() !!}</div>
                        </div>
                    @endforeach
                </div>
                <div class="seeallbtn" id="sell_all_notification"><a href="{{ route('admin.notificaiton-list') }}">{{ __('See all notifications')}}</a>
                </div>
            </div>
        </li>
        @endif 
        <li class="nav-item dropdown">
            <select class="" name="header_languages" id="header_languages">
                @foreach (config('constants.languages') as $short_code => $language)
                    <option data-href="{{ url('locale', $short_code) }}"
                        {{ App()->isLocale($short_code) ? 'selected' : '' }} value="{{ $short_code }}">
                        {{ $language }}</option>
                @endforeach
            </select>

        </li>
        <li class="nav-item dropdown">
            <a class="nav-link py-0" data-coreui-toggle="dropdown" href="javascript:;" role="button"
                aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-md"><img class="avatar-img" src="{{ asset('images/profile-stock.png') }}"
                        alt="user@email.com"></div>
            </a>
            <div class="dropdown-menu dropdown-menu-end pt-0">
                {{-- <div class="dropdown-header bg-light py-2">
                    <div class="fw-semibold">Account</div>
                </div>
                <a class="dropdown-item" href="javascript:;">
                    <svg class="icon me-2">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
                    </svg> Updates<span class="badge badge-sm bg-info ms-2">42</span>
                </a>
                <a class="dropdown-item" href="javascript:;">
                    <svg class="icon me-2">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-envelope-open"></use>
                    </svg> Messages<span class="badge badge-sm bg-success ms-2">42</span>
                </a>
                <a class="dropdown-item" href="javascript:;">
                    <svg class="icon me-2">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-task"></use>
                    </svg> Tasks<span class="badge badge-sm bg-danger ms-2">42</span>
                </a>
                <a class="dropdown-item" href="javascript:;">
                    <svg class="icon me-2">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-comment-square"></use>
                    </svg> Comments<span class="badge badge-sm bg-warning ms-2">42</span>
                </a>
                <div class="dropdown-header bg-light py-2">
                    <div class="fw-semibold">Settings</div>
                </div>
                <a class="dropdown-item" href="javascript:;">
                    <svg class="icon me-2">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                    </svg> Profile
                </a>
                <a class="dropdown-item" href="javascript:;">
                    <svg class="icon me-2">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                    </svg> Settings
                </a>
                <a class="dropdown-item" href="javascript:;">
                    <svg class="icon me-2">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-credit-card"></use>
                    </svg> Payments<span class="badge badge-sm bg-secondary ms-2">42</span>
                </a>
                <a class="dropdown-item" href="javascript:;">
                    <svg class="icon me-2">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-file"></use>
                    </svg>Projects<span class="badge badge-sm bg-primary ms-2">42</span>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:;">
                    <svg class="icon me-2">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                    </svg> Lock Account
                </a>
                --}}
                <a class="dropdown-item mt-2" href="route('admin.logout')"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout"
                        width="80" height="80" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                        <path d="M7 12h14l-3 -3m0 6l3 -3" />
                    </svg>
                    {{ __('Logout') }}
                    <form method="POST" action="{{ route('admin.logout') }}" class="d-none" id="logout-form">
                        @csrf
                    </form>
                </a>
            </div>
        </li>
    </ul>
</div>
<div class="header-divider"></div>
