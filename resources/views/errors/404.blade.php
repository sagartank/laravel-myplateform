<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ __('Mipo')}}</title>
	<link href="{{ asset('css/fonts.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/style-web.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/responsive-web.css') }}" rel="stylesheet" />
</head>
<body>
	<div class="error_page_sec">
		<div class="error_page_box">
			<h1>404</h1>
			<div class="error_caption">
				<h5>{{ __('Oops… You just found an error page') }}</h5>
				<p>{{ __('We are sorry but the page you are looking for was not found') }}</p>
				<div class="back_btn_error">
					<a href="/">
						<i>
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<g clip-path="url(#clip0_1301_1449)">
								<path d="M4.16663 10H15.8333" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M4.16663 10L9.16663 15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M4.16663 10L9.16663 5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								</g>
								<defs>
								<clipPath id="clip0_1301_1449">
								<rect width="20" height="20" fill="white"/>
								</clipPath>
								</defs>
							</svg>
						</i>
						{{ __('Take me back') }}
					</a>
					<a href="/">
						<i>
							<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
								<g id="rotate">
									<g clip-path="url(#clip0_2439_95807)">
										<path id="Vector" d="M18 11.9098C17.7778 13.5979 16.9453 15.1475 15.6585 16.2685C14.3716 17.3895 12.7186 18.0051 11.0088 18C9.29902 17.9949 7.6497 17.3695 6.3696 16.2408C5.0895 15.1122 4.26638 13.5576 4.0543 11.8682C3.84223 10.1789 4.25575 8.4704 5.21746 7.06271C6.17916 5.65502 7.62313 4.6446 9.27904 4.22058C10.935 3.79656 12.6893 3.98801 14.2137 4.75911C15.7381 5.53021 16.928 6.82808 17.5606 8.40977M18 4.03477V8.40977H13.6064" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
									</g>
								</g>
								<defs>
									<clipPath id="clip0_2439_95807">
										<rect width="22" height="22" rx="11" fill="white"/>
									</clipPath>
								</defs>
							</svg>								
						</i>
						{{ __('Retry') }}
					</a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>