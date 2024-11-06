<x-guest-layout>
    @section('custom_style')

    @endsection

        <div class="forgot-password-page">
            <div class="page-logo">
                <a href="/"><img src="{{ asset('images/logo.png') }}"></a>
            </div>
            <div class="forgot-block-main">
                <div class="forgot-block-inner">
                    <div class="forgot-text">
                        <h6>{{ __('New Password') }}</h6>
                        <p>{{ __('Please create a new password that you don’t use on any other site.') }}</p>
                    </div>
                    <div class="forgot-form">
                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <input type="hidden" name="email" value="{{ $request->input('email') }}">

                            <div class="input-row">
                                <div class="flxrow">
                                    <div class="pass-info">
                                        <label class="form-label" for="password">{{ __('New Password') }}</label>
                                        <i class="info">
                                            <img src="{{ asset('images/info-icon.svg') }}" alt="">
                                        </i>
                                        <ul class="info-tip">
                                            <li>{{ __('Atleast 8 character long') }}</li>
                                            <li>{{ __('One uppercase character') }}</li>
                                            <li>{{ __('One lowercase character') }}</li>
                                            <li>{{ __('One special character') }}</li>
                                            <li>{{ __('One digit') }}</li>
                                        </ul>
                                    </div>

                                </div>
                                <div class="input-group password">
                                    <input class="form-control" type="password" id="password" name="password" required>
                                    <i class="icon"></i>
                                </div>
                            </div>
                            <div class="input-row">
                                <label class="form-label con_pass" for="password_confirmation">{{ __('Conform Password') }}</label>
                                <div class="input-group password">
                                    <input class="form-control @error('password') is-invalid @enderror" type="password" id="password_confirmation" name="password_confirmation" required>
                                    @error('password')
                                        <x-error-alert :message="$message" />
                                    @enderror
                                </div>
                            </div>
                            <div class="btnbox">
                                <input class="primary-btn" type="submit" value="{{ __('Reset Password') }}">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="thankyou-box" style="display: none ;">
                    <div class="center-img"><img src="{{ asset('images/reset-img.svg') }}" alt=""></div>
                    <div class="forgot-text">
                        <h6>{{ __('New Password is successfully changed') }}</h6>

                    </div>
                    <div class="forgot-form">

                        <div class="btnbox">
                            <a href="{{ route('login') }}" class="primary-btn active">{{ __('Login to Account') }}</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    @section('custom_script')
        <script>
            $(document).ready(function () {

                <?php if(session('status')) { ?>
                $('.forgot-block-inner').hide();
                $('.thankyou-box').show();
                <?php } ?>

                $(".input-group.password .icon").on("click", function(){
                    let input = $('#password');
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });

            });
        </script>
    @endsection
</x-guest-layout>
