<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>MIPO</title>
		<link rel="stylesheet" href="{{ asset('fonts/fonts.css') }}">

		<!--app install style by k-->
		<style>
			* {
				margin: 0px;
				padding: 0px;
				box-sizing: border-box;
			}
			body {
				font-family: 'GeneralSans';
				margin: 0;
				padding: 0;
			}
			.mobile-app-notification { width: 100%; background: #007BFF; padding: 10px 14px; display: none; }
			.mobile-app-notification .mobile_wrap { display: flex; align-items: center; justify-content: space-between; }
			.mobile-app-notification .mobile_wrap .img_text { display: flex; align-items: center; }
			.mobile-app-notification .mobile_wrap .image { display: flex; margin-right: 16px; width: 24px; height: 24px; }
			.mobile-app-notification .mobile_wrap .image img { width: 100%; height: auto; max-width: 100%; max-height: 100%; object-fit: cover; }
			.mobile-app-notification .mobile_wrap .text_wrapper { max-width: 230px; }
			.mobile-app-notification .mobile_wrap .text_wrapper h6 { color: #ffffff; font-size: 16px; font-style: normal; font-weight: 600; line-height: normal; }
			.mobile-app-notification .mobile_wrap .text_wrapper p { color: #ffffff; font-size: 14px; font-style: normal; font-weight: 500; line-height: normal; }
			.mobile-app-notification .mobile_wrap .install_btn a { display: block; background: #ffffff; border-radius: 4px; color: #0D6EFD; padding: 8px 25px; font-size: 14px; font-style: normal; font-weight: 500; line-height: normal; text-decoration: none; }

			@media (max-width: 767px) {

				.mobile-app-notification { display: block; }
			}

		</style>
		<!--app install style by k-->
	</head>
	<body>
		<div class="mobile-app-notification">
			<div class="mobile_wrap">
				<div class="img_text">
					<div class="image">
						<img src="{{ asset('images/mipo/mobile-application-white-close.svg') }}" alt="no-img">
					</div>
					<div class="text_wrapper">
						<h6>{!! __('Mipo') !!}</h6>
						<p>{!! __('Get our free app. It won’t take up space on your phone') !!}</p>
					</div>
				</div>
				<div class="install_btn">
					<a href="javascript:;">{!! __('Install') !!}</a>
				</div>
			</div>
		</div>
	</body>
</html>