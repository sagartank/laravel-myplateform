<div class="links">
    <div class="container">
        <div class="links_section">
            <div class="use_link">
                <h6>{{ __('Useful links') }}</h6>
                <ul>
                    <li><a href="{{ route('marketing.home') }}">{{ __('Home') }}</a></li>
                    <li><a href="{{ route('about') }}">{{  __('How it Works') }}</a></li>
                    <li><a href="{{ route('faq') }}">{{  __('Faq') }}</a></li>
                    <li><a href="{{ route('blog') }}">{{ __('Blog') }}</a></li>
                    <li><a href="{{ route('marketing.contact-us-create') }}">{{ __('Contact Us') }}</a></li>
                </ul>
            </div>
            <div class="social_media">
                <h6>{{ __('Social Media') }}</h6>
                <ul>
                 @if($footerSocialMedia->isNotEmpty())
                    @foreach($footerSocialMedia as $socialMed)
                        <li><a href="{{ $socialMed->link }}">{{ $socialMed->name }}</a></li>    
                    @endforeach
                @endif
                </ul>
            </div>
            <div class="contactbox">
                <h6>{{ __('Contact us') }}</h6>
                <ul>
                    <li><a href="mailto:{{ $footerText->contact_email }}"><i><img src="{{ asset('images/marketing/mail.svg') }}" width="26" height="26" alt="mail"></i><span>{{ $footerText->contact_email }}</span></a></li>
                    <li><i><img src="{{ asset('images/marketing/address.svg') }}" width="26" height="26" alt="address"></i><p>{{ $footerText->address_line_1 ??  $footerText->address_line_2 }}</p></li>
                    <li><a href="tel:{{ $footerText->contact_phone }}"><i><img src="{{ asset('images/marketing/phone.svg') }}" width="26" height="26" alt="phone"></i><span>{{ $footerText->contact_phone }}</span></a></li>
                </ul>
            </div>
            <div class="downloadapp">
                <h6>{{ __('Download App') }}</h6>
                <a href="javascript:;" class="imagebox">
                    <img id="evt_install_pwa_footer" src="{{ asset('images/marketing/webapp.svg') }}" width="166" height="48" alt="webapp">
                </a>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="desktop_footer_section">
        <div class="container">
            <div class="ftr_sec">
                <div class="left_part">
                    <div class="ftr_logo">
                        <a href="javascript:;"><img src="{{ asset('images/marketing/mipo-white-logo.svg') }}" width="88" height="48" alt="mipo"></a>
                    </div>
                    <div class="ent_lang dropdown">
                        @if(App()->isLocale('en') == 'en')
                            <a class="lang-link" href="javascript:;">
                                <i><img src="{{ asset('images/marketing/log-eng.svg') }}" width="20" height="20" alt="eng"></i>
                                English 
                                <span><img src="{{ asset('images/marketing/lang-icon.svg') }}" width="14" height="14" alt="lang"></span>
                            </a>
                        @elseif(App()->isLocale('es') == 'es')
                            <a class="lang-link" href="javascript:;">
                                <i><img src="{{ asset('images/marketing/log-esp.svg') }}" width="20" height="20" alt="esp"></i>
                                Español 
                                <span><img src="{{ asset('images/marketing/lang-icon.svg') }}" width="14" height="14" alt="lang"></span>
                            </a>
                        @endif
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ url('locale', 'es') }}" class="{{ (App()->isLocale('es') == 'es') ? 'current' : '' }}">
                                    <i><img src="{{ asset('images/marketing/log-esp.svg') }}" width="20" height="20" alt="esp"></i>
                                    Español  
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('locale', 'en') }}" class="{{ (App()->isLocale('en') == 'en') ? 'current' : '' }}">
                                    <i><img src="{{ asset('images/marketing/log-eng.svg') }}" width="20" height="20" alt="eng"></i>
                                    English
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="right_part">
                    <ul>
                        <li><a href="{{ route('privacy-policy') }}">{{ __('terms and conditions') }}</a></li>
                        <li><a href="{{ route('privacy-policy') }}">{{ __('Privacy Policy') }}</a></li>
                    </ul>
                    <div class="copy">
                        <p>© Copyright 2023 MIPO</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile_footer_section">
        <div class="container">
            <div class="ftr_sec">
                <div class="left_part">
                    <div class="ftr_logo">
                        <a href="javascript:;"><img src="{{ asset('images/marketing/mipo-white-logo.svg') }}" width="88" height="48" alt="mipo"></a>
                    </div>
                    <div class="copy">
                        <p>© Copyright 2023 MIPO</p>
                    </div>
                    <div class="ent_lang dropdown">
                        @if (App()->isLocale('en') == 'en')
                            <a class="lang-link" href="javascript:;">
                                <i><img src="{{ asset('images/marketing/log-eng.svg') }}" width="20" height="20" alt="eng"></i>
                                English 
                                <span><img src="{{ asset('images/marketing/lang-icon.svg') }}" width="14" height="14" alt="lang"></span>
                            </a>
                        @elseif(App()->isLocale('es') == 'es')
                            <a class="lang-link" href="javascript:;">
                                <i><img src="{{ asset('images/marketing/log-esp.svg') }}" width="20" height="20" alt="esp"></i>
                                Español 
                                <span><img src="{{ asset('images/marketing/lang-icon.svg') }}" width="14" height="14" alt="lang"></span>
                            </a>
                        @endif
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ url('locale', 'es') }}"  class="{{ (App()->isLocale('es') == 'es') ? 'current' : '' }}">
                                    <i><img src="{{ asset('images/marketing/log-esp.svg') }}" width="20" height="20" alt="esp"></i>
                                    Español  
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('locale', 'en') }}"  class="{{ (App()->isLocale('en') == 'en') ? 'current' : '' }}">
                                    <i><img src="{{ asset('images/marketing/log-eng.svg') }}" width="20" height="20" alt="eng"></i>
                                    English
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="mobile_term">
        <ul>
            <li><a href="javascript:;">{{ __('terms and conditions') }}</a></li>
            <li><a href="javascript:;">{{ __('Privacy Policy') }}</a></li>
        </ul>
    </div>
</footer>