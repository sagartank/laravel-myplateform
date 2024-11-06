<x-guest-layout>
    @section('pageTitle', 'User OTP')
    @section('custom_style')
    @endsection

        <div class="otp-pass_varify">
            <div class="page-logo">
                <a href="javascript:;"><img src="{{ asset('images/mipo/mipo-logo-otp.svg') }}" alt="mipo" /></a>
            </div>

            <div class="forgot-block-main otp-verification-page">
                <div class="center-img"><img src="{{ asset('images/mipo/send-otp.svg') }}" alt="mipo"></div>
                <div class="forgot-text">
                    <h6>{!! __('Submit OTP') !!}</h6>
                    <p>{!! __('We’ve sent the OTP code through email, please check and type on the field below for verification') !!}.</p>
                </div>
                <div class="forgot-form">
                    <form action="" method="POST">
                        @csrf
                        <div class="input-row">
                            <div class="input-group pin multibox">
                                <span class="one-colum"><input class="form-control @if(session('error')) is-invalid @endif" type="text" name="otp[]" inputmode="numeric" autocomplete="one-time-code" maxlength="1" pattern="\d{1}" required autofocus></span>
                                <span class="one-colum"><input class="form-control @if(session('error')) is-invalid @endif" type="text" name="otp[]" inputmode="numeric" autocomplete="one-time-code" maxlength="1" pattern="\d{1}" required></span>
                                <span class="one-colum"><input class="form-control @if(session('error')) is-invalid @endif" type="text" name="otp[]" inputmode="numeric" autocomplete="one-time-code" maxlength="1" pattern="\d{1}" required></span>
                                <span class="one-colum"><input class="form-control @if(session('error')) is-invalid @endif" type="text" name="otp[]" inputmode="numeric" autocomplete="one-time-code" maxlength="1" pattern="\d{1}" required></span>
                                <span class="one-colum"><input class="form-control @if(session('error')) is-invalid @endif" type="text" name="otp[]" inputmode="numeric" autocomplete="one-time-code" maxlength="1" pattern="\d{1}" required></span>
                                <span class="one-colum"><input class="form-control @if(session('error')) is-invalid @endif" type="text" name="otp[]" inputmode="numeric" autocomplete="one-time-code" maxlength="1" pattern="\d{1}" required></span>
                            </div>

                            @if(session('error'))
                                <div class="invalid-feedback d-block text-center">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>

                        <div class="btnbox">
                            <input class="primary-btn" type="submit" value="{{ __('Submit') }}">
                        </div>
                    </form>
                    <div class="resend-text">
                        <p>{{ __('Didn’t get OTP Code?') }} <a href="javascript:;" onclick="event.preventDefault(); resendOtp();" id="otp_resend_btn">{{ __('Resend Code') }}</a></p>
                        <form id="resend-otp-form" class="d-none" action="{{ route('resend.otp') }}" method="POST">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="cop_right">
            <p>{!! __(Config::get('constants.COPY_RIGHT')) !!}</p>
        </div>

    @section('custom_script')
        <script>
            var resend_code_en_msg = "{{ __('Resend Code') }}";
            $(document).ready(function () {
                const els = (sel, par) => (par || document).querySelectorAll(sel);

                els(".pin").forEach((elGroup) => {

                    const elsInputOuter = [...elGroup.children];
                    const elsInput = elsInputOuter.map((el) => el.firstChild);
                    const len = elsInput.length;

                    const handlePaste = (ev) => {
                        const clip = ev.clipboardData.getData('text');          // Get clipboard data
                        const pin = clip.replace(/\s/g, "");                    // Sanitize string
                        const ch = [...pin];                                    // Create array of chars
                        elsInput.forEach((el, i) => el.value = ch[i]??"");      // Populate inputs
                        elsInput[pin.length - 1]??elsInput[len - 1].focus();    // Focus input
                    };

                    const handleInput = (ev) => {
                        const elInp = ev.currentTarget;
                        const i = elsInput.indexOf(elInp);
                        if (elInp.value && (i+1) % len) elsInput[i + 1].focus();  // focus next
                    };

                    const handleKeyDn = (ev) => {
                        const elInp = ev.currentTarget
                        const i = elsInput.indexOf(elInp);
                        if (!elInp.value && ev.key === "Backspace" && i) elsInput[i - 1].focus(); // Focus previous
                    };

                    // Add the same events to every input in group:
                    elsInput.forEach(elInp => {
                        elInp.addEventListener("paste", handlePaste);   // Handle pasting
                        elInp.addEventListener("input", handleInput);   // Handle typing
                        elInp.addEventListener("keydown", handleKeyDn); // Handle deleting
                    });
                });
            });

            function resendOtp() {
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-Token': "{{ csrf_token() }}",
                    },
                    url: "{{ route('resend.otp') }}",
                    success: function (res) {
                        if (res.success) {
                            toastr.success(res.message);
                            $('#otp_resend_btn').text(resend_code_en_msg).removeAttr('onclick').css('pointer-events', 'none');
                        }
                        else {
                            toastr.error(res.message);
                        }
                    },
                    error: function (xhr) {
                        ajaxErrorMsg(xhr);
                    }
                });
            }

            function ajaxErrorMsg(xhr) {
                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function (key, val) {
                        toastr.error(val);
                    });
                } else {
                    toastr.error(xhr.statusText);
                }
            }
        </script>
    @endsection
</x-guest-layout>
