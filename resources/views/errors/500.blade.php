<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ __('Mipo')}}</title>
	<link href="{{ asset('css/fonts.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/error-page.css') }}" rel="stylesheet" />
</head>
<body>
	<div class="error_page_sec">
		<div class="error_page_box">
			<h1>500</h1>
			<h5>{{ __('Oops… You just found an error page') }}</h5>
			<p>{{ __('We are sorry but our server encountered an internal error') }}</p>
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
			</div>
		</div>
	</div>
</body>
</html>