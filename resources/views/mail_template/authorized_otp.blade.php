<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MIPO</title>
    <style>
        .mail_wrap{
            max-width: 570px;
            border-radius: 10px;
            font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            background: #fff;
            box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.20);
            margin: 0 auto;
        }
        .mail_wrap p{font-size: 14px;color: #707070;font-weight: 500;margin: 0;}
        .mail_wrap p+p{padding-top: 12px;}
        .numberblock{text-align: center;padding: 16px 24px;background: #FAFAFA;border-radius: 8px;margin-top: 36px;}
        .numberblock span+span{margin-left: 10px;}
        .numberblock span{font-size: 36px;font-weight: 600; color: #0D6EFD;}
        /* .btn{display: inline-block;} */
        .btn{display: inline-block;text-align: center;padding: 12px 0;color: #0D6EFD;background: #EEF8FF;width: 100%;border-radius: 8px; text-decoration: none;font-size: 20px;font-weight: 600;margin: 24px 0 0 0;transition: all 0.3s ease-in-out;}
        .btn:hover{background:#CEE2EF;}

        .accountbtn{display: inline-block;text-align: center;border-radius: 4px;box-shadow: 0px 2px 2px 0px rgba(255, 255, 255, 0.20);background: #fff; padding: 8px;font-size: 14px;font-weight: 600;color: #11295A;text-decoration: none;}
        .tabdata{padding: 30px 30px 68px 30px;}
    </style>
</head>
<body>
   <div class="mail_wrap">
    <table style="width: 100%;padding:27px 30px;background: #11295A;">
      <tr>
        <td><i><img src="{{ asset('images/mipo/mail_template/icon/logo-white_mipo.png') }}" alt="no-image"></i></td>
        <td style="text-align: end;">
          <a href="javascript:;" class="accountbtn"><i><img src="{{ asset('images/mipo/mail_template/icon/user.svg') }}" alt="no-image"></i><span style="display: inline-block;vertical-align:middle;margin:-9px 0 0 0;padding:0 0 0 6px">Account</span></a>
        </td>
      </tr>
  </table>
  <div class="tabdata">
    <table style="width: 100%;">
        <tr>
          <td style="font-size: 24px;font-weight:600;padding-bottom:32px;">Authorize New Device</td>
          <td style="text-align:end; font-size: 12px;color: #585858;padding-bottom:32px;">DEC 27,2022 <span style="padding: 0 0 0 4px">08:00 AM</span></td>
        </tr>
        <tr>
          <table style="width: 100%;">
            <tr>
                <p>Hi there,</p>
                <p>You recently attempted to log in to your [app name] account from a new device or location. As a security measure, we require additional confirmation before allowing access to your account.</p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text.</p>
                <p>Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance.</p>
            </tr>
          </table>
        </tr>
        <tr>
            <table>
                <tr>
                    <div class="numberblock">
                        <span>879878</span>
                    </div>
                </tr>
                <tr><p style="padding-top: 8px;padding-bottom: 32px;">Please note this code is only valid for 15 minutes.</p></tr>
            </table>
              <p style="text-align: center;color:#707070;padding-top:64px;">© Mipo 2023</p>
              <a href="{{ route('dashboard') }}" style="color:#0D6EFD;display:flex;text-decoration:none;justify-content:center;padding-top:10px;">www.mipo.com.py</a>
        </tr>
      </table>
    </div>
  </div>
</body>
</html>