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
			.destop_notification_app { width: 100%; position: fixed; left: 20px; bottom: 20px; background: #007BFF; padding: 10px 14px; max-width: 425px; border-radius: 8px; display: none; }
			.destop_notification_app .mobile_wrap { display: flex; align-items: center; justify-content: space-between; }
			.destop_notification_app .mobile_wrap .img_text { display: flex; align-items: center; }
			.destop_notification_app .mobile_wrap .image { display: flex; margin-right: 16px; width: 24px; height: 24px; cursor: pointer; }
			.destop_notification_app .mobile_wrap .image img { width: 100%; height: auto; max-width: 100%; max-height: 100%; object-fit: cover; }
			.destop_notification_app .mobile_wrap .text_wrapper { max-width: 230px; }
			.destop_notification_app .mobile_wrap .text_wrapper h6 { color: #ffffff; font-size: 16px; font-style: normal; font-weight: 600; line-height: normal; margin: 0; }
			.destop_notification_app .mobile_wrap .text_wrapper p { color: #ffffff; font-size: 14px; font-style: normal; font-weight: 500; line-height: normal; margin: 0; }
			.destop_notification_app .mobile_wrap .install_btn a { display: block; background: #ffffff; border-radius: 4px; color: #0D6EFD; padding: 8px 25px; font-size: 14px; font-style: normal; font-weight: 500; line-height: normal; text-decoration: none; }

			@media (max-width: 767px) {

				.destop_notification_app { display: none !important; }
			}

		</style>
		<!--app install style by k-->
	</head>
	<body>
		<div id="destop_notification_app" class="destop_notification_app">
			<div class="mobile_wrap">
				<div class="img_text">
					<div class="image" id="close-btn">
						<img src="{{ asset('images/mipo/mobile-application-white-close.svg') }}" alt="no-img">
					</div>
					<div class="text_wrapper">
						<h6>{!! __('Mipo') !!}</h6>
						<p>{!! __('Get our free app. It won’t take up space on your phone') !!}</p>
					</div>
				</div>
				<div class="install_btn">
					<a href="javascript:;" id="desk_install_btn">{!! __('Install') !!}</a>
				</div>
			</div>
		</div>
	</body>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script>
		let noti_tab = document.getElementById('destop_notification_app')
		$(document).ready(function() {
			setTimeout(function() {
				let selectedBuysellTab = localStorage.getItem("desk_noti");
				if(selectedBuysellTab) {
					noti_tab.style.display = "none";
				} else {
					noti_tab.style.display = "block";
				}
			}, 5000);
		});

		document.getElementById('close-btn').addEventListener('click', function() {
			noti_tab.style.display = "none";
			localStorage.setItem("desk_noti",false);
		})

		// install app:st
		let install_Prompt = null;
		const install_button = document.getElementById("desk_install_btn");

		window.addEventListener("beforeinstallprompt", (event) => {
		event.preventDefault();
		install_Prompt = event;
		install_button.removeAttribute("hidden");
		});

		console.log(install_button)
		install_button.addEventListener("click", async () => {
			if (!install_Prompt) {
			return;
			}
			const result = await install_Prompt.prompt();
			console.log(`Install prompt was: ${result.outcome}`);
			disableInAppInstallPrompt();
		});
		
		function disableInAppInstallPrompt() {
			install_Prompt = null;
			install_button.setAttribute("hidden", "");
		}

		//install app:nd
	</script>
</html>