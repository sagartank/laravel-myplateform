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
			.mobile-app-modal { background: rgba(0, 0, 0, 0.80); z-index: 1; height: 100vh; position: relative; display: none; justify-content: center; align-items: center; flex-direction: column; }
			.mobile-app-modal .modal_wrap { z-index: 10; position: relative; background: #ffffff; border-radius: 8px; max-width: 314px; overflow: hidden; }
			.mobile-app-modal .modal_wrap .image { display: flex; margin: 12px 12px 16px auto; width: 24px; height: 24px; justify-content: flex-end; }
			.mobile-app-modal .modal_wrap .image img { width: 100%; height: auto; max-width: 100%; max-height: 100%; object-fit: cover; }
			.mobile-app-modal .modal-body .mi_images { display: block; margin: 0; width: 100%; height: 80px; margin-bottom: 16px; }
			.mobile-app-modal .modal-body .mi_images img { width: 100%; height: auto; max-width: 100%; max-height: 100%; object-fit: cover; }
			.mobile-app-modal .modal-body .text_wrapper { max-width: 260px; margin: 0 auto; }
			.mobile-app-modal .modal-body .text_wrapper h6 { color: #101010; font-size: 24px; font-style: normal; font-weight: 600; line-height: normal; margin-bottom: 16px; text-align: center; }
			.mobile-app-modal .modal-body .text_wrapper p { color: #939393; text-align: center; font-size: 12px; font-style: normal; font-weight: 500;line-height: 1.5; margin-bottom: 72px; }
			.mobile-app-modal .modal-footer { background: var(--light-mode-text-colour-light, #F9F9F9); padding: 5px 0; }
			.mobile-app-modal .modal-footer a { color: #939393; text-align: center; font-size: 12px; font-style: normal; font-weight: 500; line-height: 1.5; display: flex; justify-content: center; align-items: center; text-decoration: none; }

			@media (max-width: 767px) {

				.mobile-app-modal { display: flex; }
			}
		</style>
		<!--app install style by k-->
	</head>
	<body>
		<div class="mobile-app-modal">
			<div class="modal_wrap">
				<div class="image">
					<img src="{{ asset('images/mipo/mobile-application-dark-close.svg') }}" alt="no-img">
				</div>
				<div class="modal-body">
					<div class="mi_images">
						<img src="{{ asset('images/mipo/mipo-logo-application.png') }}" alt="no-img">
					</div>
					<div class="text_wrapper">
						<h6>{!! __('Install Mipo') !!}</h6>
						<p>{!! __('Install this application on your home screen for quick and easy access when you are on the go.') !!}</p>
					</div>
				</div>
				<div class="modal-footer">
					<a href="javascript:;">{!! __('Just tap') !!}<img src="{{ asset('images/mipo/app-export-icon.svg') }}" alt="no-img">{!! __('then ‘Add to Home Screen’') !!}</a>
				</div>
			</div>
		</div>
	</body>
</html>