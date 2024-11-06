
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>MIPO</title>

	<!--PDF Stylesheet-->
	<style>
		@font-face {
			font-family: 'GeneralSans';
			src: url("{{asset('fonts/GeneralSans-Regular.woff2')}}") format('woff2'),
				url("{{asset('fonts/GeneralSans-Regular.woff')}}") format('woff'),
				url("{{asset('fonts/GeneralSans-Regular.ttf')}}") format('truetype');
			font-weight: 400;
			font-display: swap;
			font-style: normal;
			}

			@font-face {
			font-family: 'GeneralSans';
			src: url("{{asset('GeneralSans-Medium.woff2')}}") format('woff2'),
				url("{{asset('GeneralSans-Medium.woff')}}") format('woff'),
				url("{{asset('GeneralSans-Medium.ttf')}}") format('truetype');
			font-weight: 500;
			font-display: swap;
			font-style: normal;
			}

			@font-face {
			font-family: 'GeneralSans';
			src: url("{{asset('GeneralSans-Bold.woff2')}}") format('woff2'),
				url("{{asset('GeneralSans-Bold.woff')}}") format('woff'),
				url("{{asset('GeneralSans-Bold.ttf')}}") format('truetype');
			font-weight: 700;
			font-display: swap;
			font-style: normal;
			}

        @page {
            size: 7in 9.25in;
            margin: 27mm 16mm 27mm 16mm;
        }
        * {
			font-family: 'GeneralSans';
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }
        body {
			font-family: 'GeneralSans';
            font-size: 10px;
            color: #000;
            background: #fff;
            margin: 0px;
            padding: 0px;
        }
        .pdf-wrapper {
            width: 100%;
            position: relative;
        }	
		header {position: relative;top: 0;left: 0;right: 0;}
		.pdf-header {padding: 0 20px 20px;}
		.pdf-header table {width: 100%;}
		.pdf-header .logo {width:80px;}
		.pdf-header .logo img {width: 100%;height: auto;}
		.pdf-header .head-date {text-align: right;}
		.pdf-header .head-date .date-title {color: #ADADAD;font-size: 12px;}
		.pdf-header .head-date .pdf-date {font-size: 14px;color: #000;font-weight: 600;}
		.pdf-body {padding: 0 0 40px;}
		.pdf-body .h2 {font-size: 14px;padding: 0 20px 20px;font-weight: 600;}	
        .pdf-body table {
            width: 100%;
            border: none;
            border-collapse: collapse;
            margin: 0px;
            padding: 0px;
        }
        .pdf-body table tr {}
        .pdf-body table tr td {
			font-family: 'GeneralSans';
            font-size: 10px;
            color: #ADADAD;
            line-height: 18px;
            vertical-align: bottom;
            margin: 0px;
            padding: 2px 10px;
        }
        .pdf-body table tr td strong {display: inline-block;vertical-align: middle;
            color: #000;
            font-weight: normal;
        }	
		.pdf-body table.content-table > tr > td {vertical-align: bottom;}
		.pdf-body table .rating {display: inline-block;vertical-align: middle;font-size: 0;line-height: 1;}
		.pdf-body table .rating	ul {display: inline-block;vertical-align: middle;font-size: 0;list-style: none;margin: 0;padding: 0;}
		.pdf-body table .rating	ul li {display: inline-block;vertical-align: middle;font-size: 0;list-style: none;padding: 0 3px;}
		.pdf-body table .rating	ul li.active path {fill: #FFC107;}
		.pdf-body table .cheque ul {display: inline-block;vertical-align: middle;font-size: 0;list-style: none;margin: 0;padding: 0;}
		.pdf-body table .cheque ul li {margin: 0;padding: 0;list-style: none;font-size: 10px;}
		.pdf-body .document {margin-top: 30px;}
		.pdf-body .document img {width: 100%;height: auto;}
		footer {position: fixed;bottom: 0;left: 0;right: 0;}
		footer table {width: 100%;}
		.pdf-footer {background: #13153B;padding: 14px 20px;}
		.pdf-footer p {color: #fff;}
		.mian-title {  }
	</style>
	<!--PDF Stylesheet-->
</head>

<body>
	<div class="pdf-wrapper">
		<header>
			<div class="pdf-header">
				<table>
					<tr>
						<td>
							<div class="logo text-center" style="margin: 0 auto;">
								<a href="#">
									<img alt="" src="data:image/png;base64,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" />
								</a>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</header>
		<div class="pdf-body">
			<table class="content-table">
				<tr>
					<td width="80%">
						<table>
							<tr>
								<td class="mian-title" style="text-align: center; color: #000; font-weight: 700; text-transform: uppercase; font-size: 20px;">CERTIFICADO DE CESION</td>
							</tr>
							<tr>
								<td class="sub-heading" style="text-align: center; color: #000; font-weight: 700; text-transform: uppercase; font-size: 15px;">“DERECHO DE COBRO”</td>
							</tr>
							{{-- <tr>
								<td style="text-align: center; padding: 15px 0 0;">
									<img src="data:image/png;base64,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" alt="" style="width: 50px; height: auto; ">
								</td>
							</tr> --}}
							<tr>
								<td style="text-align: center; padding: 5px 0 10px 0;">
									<img src="data:image/png;base64, {!! base64_encode(QrCode::size(100)->generate(route('profile.index'))) !!} ">
								</td>
							</tr>
							
							<tr>
								<td style="text-align: center;">
									<table style="width: auto; margin: 0 auto;">
										<tr>
											<td style="color: #000; font-weight: 500; text-transform: uppercase; font-size: 12px; padding-top: 0; padding-bottom: 0;">Deudor:</td>
											<td style="color: #000; font-weight: 500; text-transform: uppercase; font-size: 12px; padding-top: 0; padding-bottom: 0;">{{ $deals->buyer->name }}</td>
										</tr>
										<tr>
											<td style="color: #000; font-weight: 500; text-transform: uppercase; font-size: 12px; padding-top: 0; padding-bottom: 0;">Cedente:</td>
											<td style="color: #000; font-weight: 500; text-transform: uppercase; font-size: 12px; padding-top: 0; padding-bottom: 0;">{{  $deals->operations->first()?->seller->name }}</td>
										</tr>
										<tr>
											<td style="color: #000; font-weight: 500; text-transform: uppercase; font-size: 12px; padding-top: 0; padding-bottom: 0;">Factor:</td>
											<td style="color: #000; font-weight: 500; text-transform: uppercase; font-size: 12px; padding-top: 0; padding-bottom: 0;">{{  $deals->operations->first()?->issuer->company_name }}</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td style="padding-top: 10px;  padding-bottom: 0;">
									<table style="width: auto; margin: 0 auto;">
										<tr>
											<td style="color: #000; font-weight: 500; text-transform: uppercase; font-size: 8px; padding-top: 0; padding-bottom: 0;">Facture Nro:</td>
											<td style="color: #000; font-weight: 500; text-transform: uppercase; font-size: 8px; padding-top: 0; padding-bottom: 0;">{{ $deals->operations->first()->operation_number }}</td>
										</tr>
										<tr>
											<td style="color: #000; font-weight: 500; text-transform: uppercase; font-size: 8px; padding-top: 0; padding-bottom: 0;">Fecha de Emision:</td>
											<td style="color: #000; font-weight: 500; text-transform: uppercase; font-size: 8px; padding-top: 0; padding-bottom: 0;">{{  $deals->operations->first()->issuance_date }}</td>
										</tr>
										<tr>
											<td style="color: #000; font-weight: 500; text-transform: uppercase; font-size: 8px; padding-top: 0; padding-bottom: 0;">Fecha de Cobro:</td>
											<td style="color: #000; font-weight: 500; text-transform: uppercase; font-size: 8px; padding-top: 0; padding-bottom: 0;">{{  $deals->cashed_date_buyer }}</td>
										</tr>
										@php
											$offer_amount = app('common')->currencyNumberFormat($deals->operations->first()->preferred_currency, $deals->amount);
										@endphp
										<tr>
											<td style="color: #000; font-weight: 500; text-transform: uppercase; font-size: 8px; padding-top: 0; padding-bottom: 0;">Monto:</td>
											<td style="color: #000; font-weight: 500; text-transform: uppercase; font-size: 8px; padding-top: 0; padding-bottom: 0;">{{  $deals->operations->first()->preferred_currency.' '.$offer_amount }}</td>
										</tr>

										<tr>
											<td style="color: #1378c1; font-weight: 500; text-transform: uppercase; font-size: 8px; padding-top: 0; padding-bottom: 0;" colspan="2">SEOG: {{ $deals->deals_seog->seog_name }} Fecha {{ $deals->deals_seog->created_at }} </td>
										</tr>
										
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<footer>
			<div class="pdf-footer">
				<table>
					<tr>
						<td>
							<p>MIPORTAFOLIO</p>
							<p>Phone: +595 971 663 789</p>
							<p>email: contacto@mipo.com.py</p>
						</td>
						<td>
							<img alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAaCAYAAAD1wA/qAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAASaSURBVHgB7VddaFxFFJ659+5PdrP5s8bYhjbBtLUSLVUoIWKN+lQptah5UBGhxQcRi30RKoiL+tIHQy1YKAhFRYlBUKvYCtUEjVWCpQSCtIbUrWuy2+0mm929d+/OnT/P3br27t2buMI2NtDvZXfOfHNnzpzznZlBqI4wTbOrUKRj8m9wIf9IZ8getNpgFNhR6QIXInfkyHQAXWcoqI5QNLSpyoZxpH93SxtaTSCUv+GOCGNiDq02fP3zdJNuWMcpE3nOBbOoODeT1O9GqxmDgyMqWkHgZNp8JBjUcNnQHNZ+wRgvXp6n/aGQ8rCKeSulItbUGPgS7LEyb3z8fGTj5g27w2GlV1EVRUV4cujTX0++8NiW+8ocxhgKBjTE+LUJP/g+9kMXy6p9O+55KhJS7scStQiJY5cSuRNbulvHnIv7ZjIZ3ra+ebAt4u9nXK6RCOW4QKMzs+bJrT2RVIUnlHLmzOm5y/knTJOe8qg+gnMZtcdcWTSfF0Jm3BxisXln27K4myInL84/CamXkB4wCfspkzE3IClxTqcHwZTx4oHuDIPwtwYGRrUlHdELNCWXQaHITkD+c68+i1aavRyBsVm5DKB/Rjet92UNWMxbYyNn4g2l1LId0TSlLvkMKYh8PmXJdi2ASCNFwTXzDcIONwZ9BzxngTSa55y/ZxSKE0t9gBA6Cf3H4W8M/UfAYnVYwDvFonhNymvjbSewhw+gsW9NIl6BCI+4+xr86v6FnPlAVWpRyhKmlN1lomkWR90h1QvF74ZGzpRCCs0uWMBiranFIHdm0+TO8vc/G/29xTDpeKmPiSo+aOVt58JBv2+6OZYFnCpHGDvtHJjTrefcA9OZwuNOjl4wh70WvoQjH7p3NXnF2FWa27URcFcjoxOpDic3Gp3yQ8pWFBXYiB8VjzAuONvEomk355aWhgqOpvkWUI0oEn7WbaMYn0PS/leZVyCVuYe2tydRhSO9lqrhqUoevsNLI9LZ8KuqQP+Oq2Nq0KgQOOi2kQJvtT8Am+viSm2Z2ZxNva6XRvcEXmgIqDvdtts7GvpskdtidwKqV2csltlWMQVoEopRfwUPod/q60gNEdE0vCNnklcPHRqP2G1K6YMBVXm9NNyjZK1d1zQM75xS8YnHs22GyYY1VamIFBykp6rEDsZPnKRstrhTVmPAySla7N2SuGuoWmVQxg3GeMLNByF78oklpoFvue1Q6f6cmEp1aKieqCG1yoBdDcFPyGmzD08oBkhV1arzxO/DPe6Q25oqCnFwe297csVTC3TAl+u3uDh6KZHfA5dEuhwPfJDZvHWg0a+VyvmKix3OoL1wVg0xeK847XBmLMBh91Jz2P9i97qmL3SKN0GafSTdFQoM8IA7PZvObW5tDh4u23E8nupxEheIyG3t6fjnimwfQPv2ta93cjo7b03bV/1y+8KF2TWhkK+FEIQCTVef5xZBOOjDd629LfK5c2zOsJ5pbgx8bL9Xjh3b1VcQPJDPs4twhY8hD0SjUeXZvS/f2xjWWg2GUl+dTZzf/+hGglYScXgdusWZ1cnT6Dqgvqn1P+KmIzca/gLGWfiiEOqNZwAAAABJRU5ErkJggg==" />
						</td>
					</tr>
				</table>
			</div>
		</footer>
	</div>
</body>
</html>