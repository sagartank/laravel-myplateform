<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.cdnfonts.com/css/general-sans" rel="stylesheet">
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@701,200,500,301,201,1,300,2,601,600,401,501,400,700&display=swap" rel="stylesheet">
</head>
<body style="margin:0; padding:0; font-family: 'General Sans', sans-serif !important; font-size:14px !important; color:#000 !important;">

<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" class="content-block">
    <style>
        body, img, div, p, ul, li, span, strong, a {
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
        a[href^="tel"], a[href^="sms"] {
            text-decoration: none;
            color: #ffd204;
        }
        .mail_body .textblock p + p {
            margin-top: 15px;
        }
    </style>
    <tr>
        <td align="center" class="mail_body">
            <table cellpadding="0" cellspacing="0" width="100%" align="center" style="position: relative; width: 100%; max-width: 700px; margin: 70px auto 0; background-color: #FFF; border-radius: 4px; padding: 28px 60px 90px;">
                <tr style="padding-bottom: 60px;">
                    <td class="mail-logo">
                        <img src="{{ asset('images/logo.svg') }}" width="100%">
                    </td>
                </tr>

                <tr style="padding-bottom: 35px;">
                    <td class="main-text">
                        <h5 style="margin-bottom: 25px; font-size: 24px; color: #0D6EFD; font-weight: 500;">Hello,</h5>
                        <p >A request has been received for registeration of a new account with your mail for Mipo platform.</p>
                        <p>Your access code is</p>
                        <div style="display: -webkit-box; display: -ms-flexbox; display: flex; width: 100%; height: 56px; margin: 35px 0; font-size: 32px; color: #000; font-weight: 500; letter-spacing: .42em; background-color: #d9dade; -webkit-box-align: center; -ms-flex-align: center; align-items: center; -webkit-box-pack: center; -ms-flex-pack: center; justify-content: center; border-radius: 4px;">
                            {{ $otp }}
                        </div>
                        <p>If you didn’t request this, Please contact support center.</p>
                    </td>
                </tr>

                <tr style="position: relative; width: 100%; padding-top: 40px; text-align: center; border-top: 1px solid #bdbdbd;">
                    <td class="mail-footer">
                        <table cellpadding="0" cellspacing="0" width="100%" align="center">
                            <tr>
                                <td>
                                    <h6 style="margin-bottom: 15px; font-size: 20px; color: #0D6EFD; font-weight: 500;">MI Portfolio</h6>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="display: -webkit-box; display: -ms-flexbox; display: flex; -webkit-box-pack: center; -ms-flex-pack: center; justify-content: center;">
                                        <p><strong>Email us:</strong> contact@mipo.com.py</p>
                                        <span style="display: inline-block; margin: 0 5px;">|</span>
                                        <p><strong>Website:</strong> www.mipo.com.py</p>
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
</body>
</html>
