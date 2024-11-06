<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.cdnfonts.com/css/general-sans" rel="stylesheet">
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@701,200,500,301,201,1,300,2,601,600,401,501,400,700&display=swap" rel="stylesheet">
</head>

<body
    style="margin:0; padding:0; font-family: 'General Sans', sans-serif !important; font-size:14px !important; color:#000 !important;">

    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="content-block" style="background: #dee9f9;">
        <style>
            body,
            img,
            div,
            p,
            ul,
            li,
            span,
            strong,
            a {
                margin: 0;
                padding: 0;
            }

            table {
                border-spacing: 0;
                border-collapse: collapse;
            }

            table td {
                border-collapse: collapse;
            }

            a {
                color: #000000;
                text-decoration: underline;
                outline: none;
            }

            a:hover {
                text-decoration: none !important;
            }

            a[href^="tel"],
            a[href^="sms"] {
                text-decoration: none;
                color: #ffd204;
            }

            .mail_body .textblock p+p {
                margin-top: 15px;
            }
        </style>
        <tr>
            <td align="center" class="mail_body" style="padding-top: 70px;padding-bottom: 70px;">
                <table cellpadding="0" cellspacing="0" width="100%" align="center"
                    style="width: 600px;background-color: #FFF; border-radius: 4px;">
                    <tr>
                        <td style="padding: 28px 60px 90px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td class="mail-logo" style="padding-bottom: 60px; text-align: center;">
                                        <img src="{{ asset('images/logo.png') }}" style="max-width: 100%; border: none; height: auto; max-height: 75px; width: 75px;">
										{{-- <img src="{{ $message->embed(public_path().'\images\logo.png') }}" alt="logo"> --}}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="main-text">
                                        <h5
                                            style="margin-top: 0;margin-bottom: 25px; font-size: 24px; color: #0D6EFD; font-weight: 500;">
                                            Hello,
                                        </h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 15px;">
                                        <p>A request has been received for registeration of a new account with your mail
                                            for Mipo
                                            platform.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 15px;">
                                        <p>Your Password is</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 35px 0;">
                                        <div
                                            style="width: 100%;padding: 7px 0; font-size: 32px; color: #000; font-weight: 500; letter-spacing: .42em; background-color: #d9dade;text-align: center; border-radius: 4px;">
                                            {{ $password }}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 15px;">
                                        <p>Your access code is</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 35px 0;">
                                        <div
                                            style="width: 100%;padding: 7px 0; font-size: 32px; color: #000; font-weight: 500; letter-spacing: .42em; background-color: #d9dade;text-align: center; border-radius: 4px;">
                                            {{ $otp }}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 35px;">
                                        <p>If you didn’t request this, Please contact support center.</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="mail-footer"
                                        style="padding-top: 40px; text-align: center; border-top: 1px solid #bdbdbd;">
                                        <table cellpadding="0" cellspacing="0" width="100%" align="center">
                                            <tr>
                                                <td>
                                                    <h6
                                                        style="margin-top: 0;margin-bottom: 15px; font-size: 20px; color: #0D6EFD; font-weight: 500;">
                                                        MI Portfolio</h6>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>
                                                        <p><strong>Email us:</strong> contact@mipo.com.py
                                                            <span style="display: inline-block; margin: 0 5px;">|</span>
                                                            <strong>Website:</strong> www.mipo.com.py
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
</body>

</html>