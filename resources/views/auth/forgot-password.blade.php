<x-guest-layout>
    @section('custom_style')
    @endsection

    <div class="fg_pass_wrap">
        <div class="forgot-password-page">
            <div class="page-logo">
                <a href="/"><img src="{{ asset('images/logo.svg') }}" alt="" /></a>
            </div>

            <div class="forgot-block-main">
                <div class="forgot-text">
                    <h6>{{ __('Have you forgot your password') }}</h6>
                    <p>{{ __('Did you forget your password? No problem. Just let us know your email address and we will send you a password reset link that will allow you to choose a new one.') }}</p>
                </div>
                <div class="forgot-form">
                    @if (session('status'))
                        <div class="text-success text-s">
                            <small>
                                {{ session('status') }}
                            </small>
                        </div>
                    @endif
                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="input-row">
                            <label class="form-label" for="email">{{ __('Email address') }}</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email') }}" required autofocus >
                            @error('email')
                                <x-error-alert :message="$message" />
                            @enderror
                        </div>
                        <div class="btnbox">
                            <input class="primary-btn" type="submit" value="{{ __('Forgot Password') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="copy_section">
            <p>{!! __('© Copyright 2023 MIPO') !!}</p>
        </div>
    </div>

    @section('custom_script')
    @endsection
</x-guest-layout>
