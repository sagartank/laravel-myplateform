@props(['user', 'preferred_dashboard', 'currency_type', 'preferred_contact_method', 'notifications'])

<div class="setting_wrap">
    <div class="setting_inner">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="firstbox">
                    <div class="profile_inputbox">
                        <label for="dashboard" class="text-14-semibold">{!! __('Dashboard') !!}</label>
                        <select class="form-select selectbox text-12-medium init_nice_select evt-user-profile-setting-form" name="preferred_dashboard" id="preferred_dashboard"
                        data-type="preferred_dashboard">
                            @if ($preferred_dashboard)
                            @foreach ($preferred_dashboard as $key => $val)
                                <option
                                    {{ $user->preferred_dashboard == $key ? 'selected' : '' }}
                                    value="{{ $key }}">
                                    {{ __($val) }}</option>
                            @endforeach
                        @endif
                        </select>
                    </div>

                    <div class="profile_inputbox">
                        <label for="currency" class="text-14-semibold">{!! __('Currency') !!}</label>
                        <select class="form-select selectbox text-12-medium init_nice_select evt-user-profile-setting-form" name="preferred_currency" id="preferred_currency"
                        data-type="preferred_currency">
                            @if ($currency_type)
                            @foreach ($currency_type as $key => $val)
                                <option
                                    {{ $user->preferred_currency == $val ? 'selected' : '' }}
                                    value="{{ $val }}">
                                    {{ $val }}</option>
                            @endforeach
                        @endif
                        </select>
                    </div>

                    <div class="profile_inputbox">
                        <label for="contact method" class="text-14-semibold">{!! __('Contact Method') !!}</label>
                        <select class="form-select selectbox text-12-medium init_nice_select evt-user-profile-setting-form" name="preferred_contact_method"
                        id="preferred_contact_method"
                        data-type="preferred_contact_method">
                            @if ($preferred_contact_method)
                            @foreach ($preferred_contact_method as $key => $val)
                                <option
                                    {{ $user->preferred_contact_method == $val ? 'selected' : '' }}
                                    value="{{ $val }}">
                                    {{ __($val) }}</option>
                            @endforeach
                        @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="secondbox">
                    <div class="language_blk">
                        <div class="ent_lang dropdown ">
                            <p class="text-14-semibold">{{ __('Language') }}</p>
                        
                            <a class="lang-link" href="javascript:;">
                                
                                <div class="contry_text">
                                    @if (App()->isLocale('es') == 'es')
                                        <i><img src="{{ asset('images/mipo/log-esp.svg') }}" alt="no-image"></i>
                                        <span class="text-12-medium">Español</span>
                                    @elseif(App()->isLocale('en') == 'en')
                                        <i><img src="{{ asset('images/mipo/log-eng.svg') }}" alt="no-image"></i>
                                        <span class="text-12-medium">English</span>
                                    @endif
                                </div>

                                <i><img src="{{ asset('images/mipo/tranlation_icon.svg') }}" alt="no-image"></i></a>

                            <ul class="dropdown-menu ">
                                
                                <li class="evt-user-profile-setting-form" data-language-short-code="es" data-select-language="Español" data-type="language">
                                    <a href="{{ url('locale', 'es') }}" class="contry_text"><i><img src="{{ asset('images/mipo/log-esp.svg') }}" alt="no-image"></i>
                                        <span class="text-12-medium">Español</span>
                                    </a>
                                </li>

                                <li class="current evt-user-profile-setting-form" data-language-short-code="en" data-select-language="English" data-type="language">
                                    <a href="{{ url('locale', 'en') }}" class="contry_text"><i><img src="{{ asset('images/mipo/log-eng.svg') }}" alt="no-image"></i>
                                        <span class="text-12-medium">English</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <div class="mode_changebox">
                        <p class="text-14-semibold">{{ __('MODE CHANGE') }}</p>
                        <div class="darkbox">
                            <p class="text-12-medium">{!! __('Dark mode') !!}</p>
                            <div class="form-check form-switch">
                                <input class="form-check-input evt_dark_mode_right" type="checkbox" role="switch" id="darkmode">
                                <label class="form-check-label" for="darkmode"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
              {{--   <div class="notification_box">
                    <p class="text-14-semibold">{!! __('Notification') !!}</p>
                    <div class="noti_listing">
                        @forelse ($notifications as $key => $notification)
                        <div class="list_icon">
                            <input type="checkbox" name="user_notification" value="{{ $notification->notification_type }}" id="notification_{{$key}}">
                            <label for="notification_{{$key}}">{{ $notification->notification_title }}</label>
                        </div>
                        @empty
                            <p> {{ __(' No Record Found.')}}</p>
                        @endforelse
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>