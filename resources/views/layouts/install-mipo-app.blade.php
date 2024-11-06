{{-- desktop app install notification --}}

<div id="destop_notification_app" class="destop_notification_app">
    <div class="mobile_wrap">
        <div class="img_text">
            <div class="image" id="desktop-close-btn">
                <img src="{{ asset('images/mipo/mobile-application-white-close.svg') }}" alt="no-img">
            </div>
            <div class="text_wrapper">
                <h6>{!! __('Mipo') !!}</h6>
                <p>{!! __('Get our free app. It won’t take up space on your device') !!}</p>
            </div>
        </div>
        <div class="install_btn">
            <a href="javascript:;" class="cmn_trigger_installmipo" id="desk_install_btn">{!! __('Install') !!}</a>
        </div>
    </div>
</div>

{{-- desktop app install notification --}}



{{-- iphone app install notification --}}

<div class="iphone_app_modal" id="iphone_app_modal">
    <div class="iphone_modal_content">
        <div class="modal_wrap">
            <div class="image">
                <img id="iphone-close-btn" src="{{ asset('images/mipo/mobile-application-dark-close.svg') }}" alt="no-img">
            </div>
            <div class="modal-body">
                <div class="mi_images">
                    <img src="{{ asset('images/mipo/mipo-logo-application.png') }}" alt="no-img">
                </div>
                <div class="text_wrapper">
                    <h6>{!! __('Install Mipo') !!}</h6>
                    <p>{!! __('Install this application on your home screen for quick and easy access when you are on the go.') !!}</p>
                </div>
            </div>
            <div class="modal-footer" class="cmn_trigger_installmipo" id="login_install_wrapper">
                <a href="javascript:;">{!! __('Just tap') !!}<img src="{{ asset('images/mipo/app-export-icon.svg') }}" alt="no-img">{!! __('then Add to Home Screen') !!}</a>
            </div>
        </div>
    </div>
</div>

{{-- iphone app install notification --}}



{{-- authantication page app install notification --}}

<div class="login_device_app" id="login_device_app">
    <div class="logregister_app_install">
        <div class="use_mipo">
            <h4>{!! __('Use Mipo app anywhere, any device.') !!}</h4>
            <div class="install_btn" class="cmn_trigger_installmipo" id="log_install_btn">
                <a href="javascript:;">{!! __('Install') !!}</a>
            </div>
            <div class="not_now" id="login-close-btn">
                <a href="javascript:;">{!! __('Not now') !!}</a>
            </div>
        </div>
    </div>
</div>

{{-- authantication page app install notification --}}