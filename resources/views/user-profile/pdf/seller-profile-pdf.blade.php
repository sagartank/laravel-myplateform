<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>MIPO</title>

		<!--PDF Stylesheet by k-->
		<style>
			* {
				margin: 0px;
				padding: 0px;
				box-sizing: border-box;
			}
			body {
				font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
				font-size: 13px;
				color: #000;
				background: #fff;
				margin: 0px;
				padding: 0 25px 0 25px !important;
			}
			.profile_pdf_wrap {
				width: 100%;
				position: relative;
				font-size: 13px;
				color: #000;
				background: #fff;
				margin: 72px 0 0 0;
			}	
			table + table{margin-top: 10px;}

			tr:last-child,
			li:last-child {border-bottom: none !important;}

			ol li {list-style: none;}
		</style>
		<!--PDF Stylesheet by k-->
	</head>
	@php
		$datetime = \Carbon\Carbon::now();
		$download_datetime = $datetime->format('jS F Y, h:i A');
	@endphp
	<body>
		<div class="profile_pdf_wrap">
			<table style="width: 100%;">
				<tr>
					<th style="text-align: left;">
						<p style="color: #000000; font-size: 14px; font-weight: 600; text-transform: capitalize;">{{ $user->name }}<span style="color: #707070; padding:0 0 0 10px; font-size: 12px; font-weight: 500; text-transform: capitalize;">{{ $user->issuer?->company_name ?? ''}}</span></p>
					</th>
				</tr>
				<table style="width:100%; margin: 0;">
					<tr>
						<td style="text-align:left; color: #939393; font-weight: 500;">{{ $download_datetime }}</td>
						<td style="text-align:right;">
							<img alt="no-image" src="data:image/png;base64,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"/>
						</td>
					</tr>
				</table>
			</table>
			<table style="width: 100%; border-collapse: collapse;">
				<tr>
					<td style="padding: 0; border: 1px solid #707070;">
						<table style="width: 100%; border-collapse: collapse;">
							<tr style="width: 100%;">
								<td>
									<p style="font-weight: 600; padding: 6px 12px 8px 12px; color: #000000;">{!! __('Detail') !!}</p>
								</td>
							</tr>
							{{-- <tr style="width: 100%; border-bottom: 1px solid #707070; border-top: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{!! __('Country') !!}:</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">Paraguay</td>
							</tr> --}}
							<tr style="width: 100%; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{!! __('City name') !!}:</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{{ $user->city?->name ?? '' }}</td>
							</tr>
							<tr style="width: 100%; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{{ __('RUC') }}:</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{{ $user->issuer?->ruc_code ?? '' }}</td>
							</tr>
							<tr style="width: 100%; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{!! __('Date of Registry') !!}:</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{{ $user->user_registered_at }}</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			@php
			// $sold = $unsold = $draft = $rejected = $approved = $pending = $counter = $completed = 0;
			// if (isset($mi_operations_dashboard) && $mi_operations_dashboard->count() > 0) {
			// 	$approved = $mi_operations_dashboard->where('operations_status', 'Approved')->count();
			// 	$sold = $mi_operations_dashboard->pluck('offers')->flatten()->where('offer_status', 'Completed')->count();
			// 	$unsold = $mi_operations_dashboard->where('expiration_date', '<', date('Y-m-d'))->where('operations_status', '!=', 'Approved')->count();
			// 	$draft = $mi_operations_dashboard->where('operations_status', 'Draft')->count();
			// 	$rejected = $mi_operations_dashboard->where('operations_status', 'Rejected')->count();
			// 	$pending = $mi_operations_dashboard->where('operations_status', 'Pending')->count();
			// } 

			$sold = $unsold = $draft = $rejected = $approved = $pending = $openDisputes = $solvedDisputes = 0;
			if (isset($offers_status_dashboard) && $offers_status_dashboard->count()) {
				$soldApproved = $offers_status_dashboard?->where('offer_status', 'Approved')->first()?->total_offer_status;
				$soldCompleted = $offers_status_dashboard?->where('offer_status', 'Completed')->first()?->total_offer_status;
				$sold = $soldApproved + $soldCompleted;

				$solvedDisputes = $deal_disputes_dashboard->deals_disputes->where('resolved_by', '1')->count();
				$openDisputes = $deal_disputes_dashboard->deals_disputes->count();
			}

			if (isset($operations_status_dashboard) && $operations_status_dashboard->count()) {
				$draft = $operations_status_dashboard?->where('operations_status', 'Draft')->first()?->total_operations_status;
				$rejected = $operations_status_dashboard?->where('operations_status', 'Rejected')->first()?->total_operations_status;
				$approved = $operations_status_dashboard?->where('operations_status', 'Approved')->first()?->total_operations_status;
				$unsold = $approved;
				$pending = $operations_status_dashboard?->where('operations_status', 'Pending')->first()?->total_operations_status;

			}
            @endphp
			<table style="width: 100%; border-collapse: collapse;">
				<tr>
					<td style="padding: 0; border: 1px solid #707070;">
						<table style="width: 100%; border-collapse: collapse;">
							<tr style="width: 100%;">
								<td>
									<p style="font-weight: 600; padding: 6px 12px 8px 12px; color: #000000;">{!! __('Information') !!}</p>
								</td>
							</tr>
							<tr style="width: 100%; border-bottom: 1px solid #707070; border-top: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{!! __('Available Documents') !!}</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{{  ($approved - $sold)  }}</td>
							</tr>
							<tr style="width: 100%; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{!! __('Documents Sold') !!}</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{{ $sold }}</td>
							</tr>
							<tr style="width: 100%; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{!! __('Historic Operations') !!}</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{{ $sold + $unsold }}</td>
							</tr>
							<tr style="width: 100%; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{!! __('Unsold Operations') !!}</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{{ $unsold }}</td>
							</tr>
							<tr style="width: 100%; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{!! __('Open Disputes') !!}</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{{ ($openDisputes - $solvedDisputes) }}</td>
							</tr>
							<tr style="width: 100%; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{!! __('Solved Disputes') !!}</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{{ $solvedDisputes }}</td>
							</tr>
							<tr style="width: 100%; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{!! __('Average Day Delay in Payment') !!}</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{{ round($average_rating_days, 2) ?? 0 }}</td>
							</tr>
							<tr style="width: 100%; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{!! __('Average Retention') !!}</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{{ round($average_retention, 2) ?? 0 }}%</td>
							</tr>
							<tr style="width: 100%; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{!! __('Transactional Average') !!}</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">
									@php
									$usd_amount_avg =  $average_operation_values->where('preferred_currency', config('constants.CURRENCY_TYPE')[0])->avg('amount');
									$gs_amount_avg = $average_operation_values->where('preferred_currency', config('constants.CURRENCY_TYPE')[1])->avg('amount');
									@endphp
									{!! ('USD') !!} {{ app('common')->currencyNumberFormat(config('constants.CURRENCY_TYPE')[0], $usd_amount_avg) }}
									{!! ('GS') !!} {{ app('common')->currencyNumberFormat(config('constants.CURRENCY_TYPE')[1], $gs_amount_avg) }}
								</td>
							</tr>
							<tr style="width: 100%; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{!! __('Average Discount') !!}</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{{ round($average_discount) ?? 0 }}%</td>
							</tr>
							<tr style="width: 100%; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">
									<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAUCAYAAAD2rd/BAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAS1SURBVHgB1VZPiJtFFH9vZpJs0m5N1LZYleYggiDY3iqCm3ix2wqySEHxYAJeSindBW8V3YIHqWhDKXoRmqIHoWjraT0IyVqsPSjNQkHxsh/4p+q2brZrNl/yzczzzXyJm109LJFd6A++ZOZ9M/P95r3fezMAdxkQhsBrF1vPWzRVbmYBcfq9F0ZPwRZBwBDQVk9bTVl+wGo7fezT9l7YIigYAsZQEyxxfBCMhd+SK+ESbBGGInxrWRwZVd1XlZQPhgIvvF/ONWGLgM+9/lNBKQUoFF16Y+fskdMLY0rCfiAbkLSNT6YeCNzA0gcLBdZPwQpspEjOG9I5lIqWExp5OrgHQtVI71ZPINqi6wsl6pXiaL3/sckrywWwthB/GRuVp3dcXk/owPGZkkCbd21rRf3aufH6GsKHT/5KUiKgxHklcRaRSqiQuI0oILAGy6k0nOHo7xMyztGwTZBKIqgEQCuNIJBAJgRIhVWVwJJku4r7xDNmifQUG84D0b51/grAwESluL3Rtzx5fKbG3yrEPXvq6tnD04MzhNWcRJw8JqJ8FNmSMTwsItQRsR328gZq3N5njdMusON5LM/546Zx/+T61jpv+HbJcp/cGia2c7PQ0vL6v8k6UB4k1SZri3nYIISJyXK2E5oourGydPtoN2xfi+1cvLQjTo3WndtHTTe6YXpkOqGzGyTOPUeQjEVHMGp33vpr4efxznLzS+L+UttCM7Q+R5k0a91OcaPM7aDHIcuhOL9RwvjMiV+slODCz5qzxS/efrj+7NR3j6RG9/zIIfV2iXr/xZMPNV58h3WsqNZpM5E/LezczVXiXsGTWUIuDRJY/eil+8pu4clLi9luRsz/HtqsEAi5tIBMEsqs26p/X2M9S6h1WiHMzXy7IbJXz46jcF504TcRUDeS834XqT2aS5f3rpOMoW2LfobWga+9hnzXaOslwrUYeTx0W8tf9xevTOSa7dA0HVkH60JhWLP/QAcwBIT2IeeIckghXH3hte11zHGFtreFnqTXazyGSbqwe1nwv5CZx9csjpAlG29OOeKSNduHUnkYAsp9yBKT5XzuytgYhiEkZJIJODK8j3ZvdIc3ITm3THyke0+7JHNniERicbzy8se3rhsZzW4fyZxAsll3sriFEr7C4Jtc2gK/FiHrlkAlFTz61GONH658P+XMUtAZAvQJyitfYGrVNYT9Cxct9jTI1RcuEb33uGapaNAee9O3mTCauE0sIYuYRQvVpEzxO0NcGWHEeTrhiPhReWZR683wvzKhILvrngmut4Hrc1lrYu+Gw14Mvjl3qD5I+L/vEmG8ARd+J5W+UsLQk0TbC7PTM1cHvwHnbc1Vpt/mB107LWWQsHpioCqswlcNLFeKuQA2CM5tqAIvjEJAotVZ6hFu2lQcCvLRj+0sleZIKlm1XId4itIcGqnxIAjKIsdSkHqXBQPdldaBZCa9jVnP5UYyH1YO3e+O7suTX90psY/G4k+bOU6GaqW4Y92xTp+zXIJ4P9hYT3io6+UgDp6+WePyN+ZKo1Ki/NmxXVXYRAx1vRxEfGiQP0CsgU3HULe1Qbj6ytnGZ7yr15vP+H9LAuJN9zeue8+m4W/BTpN5i/rm5QAAAABJRU5ErkJggg==" alt="no-image" />
								</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{!! ($user->issuer?->registry_in_mipo == 'Yes') ? __('Yes') : __('No') !!}</td>
							</tr>
							<tr style="width: 100%; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{!! __('Verified Address') !!}</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{!! ($user->address_verify == 'Yes') ? __('Yes') : __('No') !!}</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table style="width: 100%; text-align:center; padding:8px 0;">
				<tr>
				  	<td>
						<a href="javascript:;" style="text-decoration:none; text-transform:uppercase; display:block; color: #000000; font-weight: 500;">
							www.mipo.com.py
						</a>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>