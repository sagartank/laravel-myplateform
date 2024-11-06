
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0" />
	<title>{{ __('MIPO') }}</title>
	<!--Stylesheet-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet" />
	<!--Stylesheet-->
</head>

<body>
	<div class="inner-page-outer terms_condi">
		<div class="default-page">
			<div class="container-xl">
				<div class="logo text-center">
					<a href="/"><img src="{{ asset('images/logo.svg') }}" alt="" /></a>
				</div>				
				<div class="default-content">
					{!! $privacy_policy->description !!}
				</div>
			</div>
		</div>
	</div>
	<!--JavaScript-->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
	<!--JavaScript-->
</body>
</html>