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
				font-size: 9px;
				color: #000;
				background: #fff;
				margin-top: 10mm;
    			margin-bottom: 10mm;
				padding: 0 25px 0 25px !important;
			}
			 table {
			border-collapse: collapse;
      		width: 100%;
			page-break-before: avoid;
		} 
			.platform_activity_pdf_wrap {
				width: 100%;
				position: relative;
				font-size: 9px;
				color: #000;
				background: #fff;
			}
			.red {
				color: #DC3545 !important;
			}
			.green {
				color: #198754 !important;
			}
			.black {
				color: #000000 !important;
			}
			.pending{
				color: #0D6EFD !important;
			}

			table + table{margin-top: 15px;}

			tr:last-child,
			li:last-child {border-bottom: none !important;}

			ol li {list-style: none;}
			/* .page-break {
            page-break-before: always;
            page-break-after: always;
        } */
		</style>
		<!--PDF Stylesheet by k-->
	</head>
	<body>
		<div class="platform_activity_pdf_wrap">
			<table style="width: 100%;">
				<table style="width:100%; margin: 0;">
					<tr>
					<th style="text-align: left;">
						<p style="color: #000000; font-size: 14px; font-weight: 600; text-transform: capitalize;">{{ __('Platform Activity') }}<span style="color: #707070; padding:0 0 0 10px; font-size: 12px; font-weight: 500; text-transform: capitalize;">{{ __('User') }} {{ $user->slug }}</span></p>
					</th>
				</tr>
					<tr>
						<td style="text-align:left; color: #939393; font-weight: 500;">{{ date('d/m/Y h:i A') }}</td>
						<td style="text-align:right;">
							<img alt="no-image" src="data:image/png;base64,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"/>
						</td>
					</tr>
				</table>
			</table>
			<table style="width: 100%; border: 1px solid #707070;border-collapse: collapse;">
				<tr>
					<td style="border-collapse: collapse;border-right:1px solid #707070;padding:5px 12px;">
						<table style="width:50%;">
							<tr>
								<td>
									<p style="color: #000000; font-weight: 500;">{{ __('Name') }}: {{ $user->name }} <span style="color: #707070; font-weight: 500;">
										{{ floor($user->ratings_avg_rating_number) }}/5 ({{ ($user->ratings_count) }})
									</span></p>
								</td>
							</tr>
							<tr>
								<td style="color: #000000; font-weight: 500;">{{ __('Last name') }}: {{ $user->last_name }}</td>
							</tr>
							<tr>
								<td style="color: #000000; font-weight: 500;">RUC/CI/DV: {{ $user->issuer?->ruc_code }}</td>
							</tr>
							<tr>
								<td style="color: #000000; font-weight: 500;">{{ __('Account level') }}: {{ __($user->user_level) }}</td>
							</tr>
							<tr>
								<td style="color: #000000; font-weight: 500;">Mipo+: {{ __($user->issuer?->registry_in_mipo ?? '') }}</td>
							</tr>
						</table>
					</td>
					<td style="border-collapse: collapse;border-right:1px solid #707070;width:50%;">
						<table style="width:100%;border-collapse: collapse;">
							<tr style="border-bottom: 1px solid #707070;">
								<td style="text-align:left; padding: 4px 12px; color: #000000; font-weight: 500;">{{ __('Email') }}</td>
								<td style="text-align:right; padding: 4px 12px; color:#707070; font-weight: 500;">{{ $user->email }}</td>
							</tr>
							<tr style="border-bottom: 1px solid #707070;">
								<td style="text-align:left; padding: 4px 12px; color: #000000; font-weight: 500;">{{ __('Phone') }}</td>
								<td style="text-align:right; padding: 4px 12px; color:#707070; font-weight: 500;">{{ $user->phone_number }}</td>
							</tr>
							<tr style="border-bottom: 1px solid #707070;">
								<td style="text-align:left; padding: 4px 12px; color: #000000;  font-weight: 500;">{{__('Date of Birth') }}</td>
								<td style="text-align:right; padding: 4px 12px; color:#707070; font-weight: 500;">{{ $user->birth_date }}</td>
							</tr>
							<tr>
								<td style="text-align:left; padding: 4px 12px; color: #000000; font-weight: 500;">{{__('Marital Status') }}</td>
								<td style="text-align:right; padding: 4px 12px; color:#707070; font-weight: 500;">{{ __($user->marital_status) }}</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table style="width: 100%; border-collapse: collapse;">
				<tr>
					<td style="padding: 0; border: 1px solid #707070;">
						<table style="width: 100%; border-collapse: collapse;">
							<tr style="width: 100%;">
								<td>
									<p style="font-weight: 600; padding: 6px 12px 8px 12px; color: #000000; ">{{ __('Active Operations') }}</p>
								</td>
							</tr>
							<tr>
								<td style="text-align:left; padding: 4px 12px; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('Seller') }}</td>
								<td style="text-align:center; padding: 4px 12px; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('OP No.') }}</td>
								<td style="text-align:center; padding: 4px 12px; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('OP Type') }}</td>
								<td style="text-align:center; padding: 4px 12px; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('Amount') }}</td>
								<td style="text-align:center; padding: 4px 12px; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('Currency') }}</td>
								<td style="text-align:center; padding: 4px 12px; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('MIPO+') }}</td>
								<td style="text-align:center; padding: 4px 12px; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('Status') }}</td>
							</tr>
							@if($user_active_operations->count())
								@foreach($user_active_operations as $user_active_operation_val)
										@php
												$class_op ="";
											if($user_active_operation_val->operations_status == 'Draft') {
												$class_op = "black";
											} else if($user_active_operation_val->operations_status == 'Rejected') {
												$class_op ="red";
											} else if($user_active_operation_val->operations_status == 'Approved') {
												$class_op ="green";
											} else if($user_active_operation_val->operations_status == 'Pending') {
												$class_op ="pending";
											}
												
											$class_mipo = "red";
											if($user_active_operation_val->mipo_verified == 'Yes') {
												$class_mipo = "green";
											}
										@endphp
									<tr style="border-bottom: 1px solid #000000;">
										<th style="color: #939393; font-weight: 500; padding: 4px 12px; text-align:left;">{{ $user_active_operation_val->seller?->name }}</th>
										<th style="color: #939393; font-weight: 500; padding: 4px 12px;">{{ $user_active_operation_val->operation_number }}</th>
										<th style="color: #939393; font-weight: 500; padding: 4px 12px;">
											{{ ($user_active_operation_val->operation_type == 'Cheque') ? __('Check') : __($user_active_operation_val->operation_type) }}
										</th>
										<th style="color: #939393; font-weight: 500; padding: 4px 12px;">
											{!! app('common')->currencyBySymbolPDF($user_active_operation_val->preferred_currency) !!} {{ app('common')->currencyNumberFormat($user_active_operation_val->preferred_currency, $user_active_operation_val->amount) }}
										<th style="color: #939393; font-weight: 500; padding: 4px 12px;">{{ $user_active_operation_val->preferred_currency }}</th>
										<th style="font-weight: 500; padding: 4px 12px;" class="{{ $class_mipo }}">{{ __($user_active_operation_val->mipo_verified) }}</th>
										<th style="color: #939393; font-weight: 500; padding: 4px 12px;" class="{{ $class_op }}">{{ __($user_active_operation_val->operations_status) }}</th>
									</tr>
								@endforeach
							@endif
						</table>
					</td>
				</tr>
			</table>
			<table style="width: 100%; border-collapse: collapse;">
				<tr>
					<td style="padding: 0; border: 1px solid #707070;">
						<table style="width: 100%; border-collapse: collapse;">
							<tr style="width: 100%;">
								<td>
									<p style="font-weight: 600; padding: 6px 12px 8px 12px; color: #000000; ">{{ __('Sold Operations') }}</p>
								</td>
							</tr>
							<tr>
								<td style="text-align:left; padding: 4px 0 0 12px; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('Buyer') }}</td>
								<td style="text-align:center; padding: 4px 0; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">C.I./RUC</td>
								<td style="text-align:center; padding: 4px 0; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('OP Type') }}</td>
								<td style="text-align:center; padding: 4px 0; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('Nominal value') }}</td>
								<td style="text-align:center; padding: 4px 0; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('Offer Value') }}</td>
								<td style="text-align:center; padding: 4px 0; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('Discount') }}</td>
								<td style="text-align:center; padding: 4px 0; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('Desc') }} %</td>
								<td style="text-align:center; padding: 4px 0; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('Status') }}</td>
							</tr>
							@if($user_sold_operations->count())
								@foreach($user_sold_operations as $user_sold_operation_val)
									@php
										$discount_amount = $percentage_discount = 0;
										$currency = $user_sold_operation_val->operations->first()?->preferred_currency;
										$currency_sign = app('common')->currencyBySymbolPDF($user_sold_operation_val->operations->first()?->preferred_currency);
										$op_val = $user_sold_operation_val->operations->first()?->amount;
										$of_val = $user_sold_operation_val->amount;

										$offer_status = "Send Docs";
										$offer_status_color = "red";
										if($user_sold_operation_val->is_seller_deals_contract == 'No' || $user_sold_operation_val->is_buyer_deals_contract == "No") {
											$offer_status = "Pend. Signature";
										} else if($user_sold_operation_val->is_mipo_commission_payment == 'Yes') {
											$offer_status = "Collected";
											$offer_status_color = "green";
										}
										$discount_amount = ($op_val - $of_val);
										$percentage_discount = (($discount_amount/$op_val)*100);
									@endphp
									<tr style="border-bottom: 1px solid #000000;">
										<th style="color: #939393; font-weight: 500; padding: 4px 0 0 12px; text-align:left;">{{ $user_sold_operation_val->buyer->name }}</th>
										<th style="color: #939393; font-weight: 500; padding: 4px 0;">{{ $user_sold_operation_val->operations->first()?->issuer->ruc_code }}</th>
										<th style="color: #939393; font-weight: 500; padding: 4px 0;">
											{{ ($user_sold_operation_val->operations->first()?->operation_type == 'Cheque') ? __('Check') : __($user_sold_operation_val->operations->first()?->operation_type) }}
										</th>
										</th>
										<th style="color: #939393; font-weight: 500; padding: 4px 0;">
											{!! $currency_sign !!} {{ app('common')->currencyNumberFormat($currency, $op_val) }}
										</th>
										<th style="color: #939393; font-weight: 500; padding: 4px 0;">
											{!! $currency_sign !!} {{ app('common')->currencyNumberFormat($currency, $of_val) }}
										</th>
										<th style="font-weight: 500; padding: 4px 0;" class="red">
											{!! $currency_sign !!}
											{{ app('common')->currencyNumberFormat($currency, $discount_amount) }}
										</th>
										<th style="color: #939393; font-weight: 500; padding: 4px 0;" class="red">{{ round($percentage_discount, 2) }}%</th>
										<th style="color: #939393; font-weight: 500; padding: 4px 0;" class="{{ $offer_status_color }}">{{ __($offer_status) }}</th>
									</tr>
								@endforeach
							@endif
						</table>
					</td>
				</tr>
			</table>
			<table style="width: 100%; border-collapse: collapse;">
				<tr>
					<td style="padding: 0; border: 1px solid #707070;">
						<table style="width: 100%; border-collapse: collapse;">
							<tr style="width: 100%;">
								<td>
									<p style="font-weight: 600; padding: 6px 12px 8px 12px; color: #000000; ">{{ __('Purchased Operations') }}</p>
								</td>
							</tr>
							<tr>
								<td style="text-align:left; padding: 4px 0 0 12px; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('Seller') }}</td>
								<td style="text-align:center; padding: 4px 0; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">C.I./RUC</td>
								<td style="text-align:center; padding: 4px 0; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('OP Type') }}</td>
								<td style="text-align:center; padding: 4px 0; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('Nominal value') }}</td>
								<td style="text-align:center; padding: 4px 0; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('Offer Value') }}</td>
								<td style="text-align:center; padding: 4px 0; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('Profit') }}</td>
								<td style="text-align:center; padding: 4px 0; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('Commissions') }}</td>
								<td style="text-align:center; padding: 4px 0; color: #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;  font-weight: 500;">{{ __('Status') }}</td>
							</tr>
							@if($user_buy_operations->count())
								@foreach($user_buy_operations as $user_buy_operation_val)
									@php
										$profit_amount = $percentage_discount = 0;
										$currency = $user_buy_operation_val->operations->first()?->preferred_currency;
										$currency_sign = app('common')->currencyBySymbolPDF($user_buy_operation_val->operations->first()?->preferred_currency);
										$op_val = $user_buy_operation_val->operations->first()?->amount;
										$of_val = $user_buy_operation_val->amount;

										$offer_status = "Send Docs";
										$offer_status_color = "red";
										if($user_buy_operation_val->is_seller_deals_contract == 'No' || $user_buy_operation_val->is_buyer_deals_contract == "No") {
											$offer_status = "Pend. Signature";
										} else if($user_buy_operation_val->is_mipo_commission_payment == 'Yes') {
											$offer_status = "Collected";
											$offer_status_color = "green";
										}

										$profit_amount = ($op_val - $of_val);
										$percentage_discount = (($profit_amount/$of_val)*100);
									@endphp
									<tr style="border-bottom: 1px solid #000000;">
										<th style="color: #939393; font-weight: 500; padding: 4px 0 0 12px; text-align:left;">{{ $user_buy_operation_val->buyer?->name }}</th>
										<th style="color: #939393; font-weight: 500; padding: 4px 0;">{{ $user_buy_operation_val->operations->first()?->issuer->ruc_code }}</th>
										<th style="color: #939393; font-weight: 500; padding: 4px 0;">
											{{ ($user_buy_operation_val->operations->first()?->operation_type == 'Cheque') ? __('Check') : __($user_buy_operation_val->operations->first()?->operation_type) }}
										</th>
										<th style="color: #939393; font-weight: 500; padding: 4px 0;">
											{!! $currency_sign !!} {{ app('common')->currencyNumberFormat($currency, $op_val) }}
										</th>
										<th style="color: #939393; font-weight: 500; padding: 4px 0;">
											{!! $currency_sign !!} {{ app('common')->currencyNumberFormat($currency, $of_val) }}
										</th>
										<th style=" color: #939393; font-weight: 500; padding: 4px 0;">
											{!! $currency_sign !!}
											{{ app('common')->currencyNumberFormat($currency, $profit_amount) }}
										</th>
										<th style="color: #939393; font-weight: 500; padding: 4px 0;" class="green">{{ round($percentage_discount,2) }}</th>
										<th style="color: #939393; font-weight: 500; padding: 4px 0;" class="{{ $offer_status_color }}">{{ __($offer_status) }}</th>
									</tr>
							@endforeach
							@endif
						</table>
					</td>
				</tr>
			</table>
			<table style="width: 100%; text-align:center; padding: 8px 0;">
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