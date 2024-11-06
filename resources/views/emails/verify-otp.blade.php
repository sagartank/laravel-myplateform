<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MIPO</title>
    <style>
        .mail_wrap {
            max-width: 570px;
            border-radius: 10px;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            background: #fff;
            box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.20);
            margin: 0 auto;
        }

        .mail_wrap p {
            font-size: 14px;
            color: #707070;
            font-weight: 500;
            margin: 0;
        }

        .mail_wrap p+p {
            padding-top: 12px;
        }

        .numberblock {
            text-align: center;
            padding: 16px 24px;
            background: #FAFAFA;
            border-radius: 8px;
            margin-top: 36px;
        }

        .numberblock span+span {
            margin-left: 10px;
        }

        .numberblock span {
            font-size: 36px;
            font-weight: 600;
            color: #0D6EFD;
        }

        /* .btn{display: inline-block;} */
        .btn {
            display: inline-block;
            text-align: center;
            padding: 12px 0;
            color: #0D6EFD;
            background: #EEF8FF;
            width: 100%;
            border-radius: 8px;
            text-decoration: none;
            font-size: 20px;
            font-weight: 600;
            margin: 24px 0 0 0;
            transition: all 0.3s ease-in-out;
        }

        .btn:hover {
            background: #CEE2EF;
        }

        .accountbtn {
            display: inline-block;
            text-align: center;
            border-radius: 4px;
            box-shadow: 0px 2px 2px 0px rgba(255, 255, 255, 0.20);
            background: #fff;
            padding: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #11295A;
            text-decoration: none;
        }

        .tabdata {
            padding: 30px 30px 68px 30px;
        }
    </style>
</head>

<body>
    <div class="mail_wrap">
        <table style="width: 100%;padding:27px 30px;background: #11295A;">
            <tr>
                <td><i><img src="{{ asset('images/mipo/mail_template/icon/logo-white_mipo.png') }}" alt="no-image"></i>
                </td>
                <td style="text-align: end;">
                    <a href="javascript:;" class="accountbtn"><i><img
                                src="{{ asset('images/mipo/mail_template/icon/user.png') }}" alt="no-image"></i><span
                            style="display: inline-block;vertical-align:middle;margin:-9px 0 0 0;padding:0 0 0 6px">{{ __('Your account') }}</span></a>
                </td>
            </tr>
        </table>
        <div class="tabdata">
            <table style="width: 100%;">
                <tr>
                    <table style="width: 100%;">
                        <tr>
                            <p>Hola!</p>
                            <p>Hemos recibido una solicitud de registro de una nueva cuenta en la plataforma MIPO.</p>
                            <p>Su código de acceso es</p>
                        </tr>
                    </table>
                </tr>
                <tr>
                    <table style="width: 100%;">
                        <tr>
                            <div class="numberblock">
                                <span>{{ $otp }}</span>
                            </div>
                        </tr>
                        <tr>
                            <p style="margin-top:2%">
                                Si usted no solicito esto, favor contactar con Atención al Cliente.
                            </p>
                        </tr>
                    </table>
                    <p style="text-align: center;color:#707070;padding-top:64px;">© Mipo {{ date('Y') }}</p>
                    <a href="{{ route('dashboard') }}" style="color:#0D6EFD;display:flex;text-decoration:none;justify-content:center;padding-top:10px;">www.mipo.com.py</a>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
