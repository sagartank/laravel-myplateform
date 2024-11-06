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
			.mobile-device-app { background: rgba(0, 0, 0, 0.80); z-index: 1; height: 100vh; position: relative; display: none; justify-content: flex-end; align-items: center; flex-direction: column; padding-bottom: 30px; }
			.mobile-device-app .use_mipo { background: linear-gradient(273deg, #0D6EFD -40.51%, #4AA0DB 102.78%); border-radius: 8px; padding: 32px 50px; }
			.mobile-device-app .use_mipo h4 { color: #FFFFFF; text-align: center; font-size: 24px; font-style: normal; font-weight: 600; line-height: normal; margin-bottom: 40px; }
			.mobile-device-app .use_mipo .install_btn { display: flex; justify-content: center; }
			.mobile-device-app .use_mipo .install_btn a { display: block; background: #ffffff; border-radius: 4px; color: #0D6EFD; padding: 8px 48px; font-size: 16px; font-style: normal; font-weight: 500; line-height: normal; text-decoration: none; }
			.mobile-device-app .use_mipo .not_now { display: flex; justify-content: center; margin-top: 8px; }
			.mobile-device-app .use_mipo .not_now a { display: block; border-radius: 4px; color: #EEF8FF; padding: 8px 48px; font-size: 16px; font-style: normal; font-weight: 500; line-height: normal; text-decoration: none; }

			@media (max-width: 767px) {

				.mobile-device-app { display: flex; }
			}

		</style>
		<!--app install style by k-->
	</head>
	<body>
		<div class="mobile-device-app">
			<div class="use_mipo">
				<h4>{!! __('Use Mipo app anywhere, any device.') !!}</h4>
				<div class="install_btn">
					<a href="javascript:;">{!! __('Install') !!}</a>
				</div>
				<div class="not_now">
					<a href="javascript:;">{!! __('Not now') !!}</a>
				</div>
			</div>
		</div>
	</body>
</html>