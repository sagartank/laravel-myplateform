@include('emails.header')
    <p style="margin-top:2%">
        A request has been sing contract with your mail for Mipo platform.</p>
    </p>
    <p style="margin-top:2%">
        Your OTP code is
    </p>
    <p style="margin-top:2%">
    {{ $otp }}
    </p>
    <p style="margin-top:2%">
        Thank you for trusting MIPO!
    </p>
    <p style="margin-top:2%">
        Kind regards,<br>

        The MIP team.
    </p>
@include('emails.footer')
