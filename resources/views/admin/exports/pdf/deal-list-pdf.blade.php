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
				color: #000;
				background: #fff;
				margin: 0px;
				padding: 0 10px !important;
				margin-top: 20mm;
				margin-bottom: 20mm;
			}
			table {
				border-collapse: collapse;
      			width: 100%;
				page-break-before: avoid;
			} 
			
			.deals_export_pdf_wrap {
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
			table + table{margin-top: 15px;}

			tr:last-child,
			li:last-child {border-bottom: none !important;}

			ol li {list-style: none;}
		</style>
		<!--PDF Stylesheet by k-->
	</head>
	<body>
		<div class="deals_export_pdf_wrap">
			<table style="width: 100%;">
				
				<table style="width:100%; margin: 0;">
					<tr>
						<th style="text-align: left;">
							<p style="color: #000000; font-size: 14px; font-weight: 600; text-transform: capitalize;">
								Operaciones Concretadas
								{{-- <span style="color: #707070; padding:0 0 0 10px; font-size: 12px; font-weight: 500; text-transform: capitalize;">CHEQUE - OP123</span> --}}
							</p>
						</th>
					</tr>
					<tr>
						<td style="text-align:left; color: #939393; font-weight: 500;">{{ date ('d-m-Y h:i A') }}</td>
						<td style="text-align:right;">
							<img alt="no-image" src="data:image/png;base64,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"/>
						</td>
					</tr>
				</table>
			</table>

			<table style="width: 100%; border-collapse: collapse; border: 1px solid #707070;">
				<tr>
					<td style="padding: 0;">
						<table style="width: 100%; border-collapse: collapse;">
							<tr style="border-bottom: 1px solid #000000;">
								<td style="width:10%; text-align:left; padding: 4px 2px; color: #000000; font-weight: 500;">Nro OP</td>
								<td style="width:10%; text-align:center; padding: 4px 2px; color: #000000; font-weight: 500;">Vendedor</td>
								<td style="width:8%; text-align:center; padding: 4px 2px; color: #000000; font-weight: 500;">Comprador</td>
								<td style="width:8%; text-align:center; padding: 4px 2px; color: #000000; font-weight: 500;">Pagador</td>
								<td style="width:8%; text-align:center; padding: 4px 2px; color: #000000; font-weight: 500;">Tipo de OP</td>
								<td style="width:8%; text-align:center; padding: 4px 2px; color: #000000; font-weight: 500;">Valor Nominal</td>
								<td style="width:8%; text-align:center; padding: 4px 2px; color: #000000; font-weight: 500;">Oferta</td>
								<td style="width:8%; text-align:center; padding: 4px 2px; color: #000000; font-weight: 500;">D/U</td>
								<td style="width:8%; text-align:center; padding: 4px 2px; color: #000000; font-weight: 500;">Comision</td>
								<td style="width:8%; text-align:center; padding: 4px 2px; color: #000000; font-weight: 500;">MIPO+</td>
								<td style="width:8%; text-align:center; padding: 4px 2px; color: #000000; font-weight: 500;">Fecha Exp.</td>
								<td style="width:8%; text-align:left; padding: 4px 2px; color: #000000; font-weight: 500;">Estado</td>
							</tr>
							@if($data->isNotEmpty())
								@php
									$total_op_amount_gs = $total_op_amount_usd = 0;
									$total_of_amount_gs = $total_of_amount_usd = 0;
									$total_diff_amount_gs = $total_diff_amount_usd = 0;
									$total_comm_amount_gs = $total_comm_amount_usd = 0;
									$total_mipo_amount_gs = $total_mipo_amount_usd = 0;
								@endphp
							@foreach($data as $val)
								@php
									$preferred_currency = $val->operations?->first()->preferred_currency;
									$currency_symbol = app('common')->currencyBySymbolPDF($preferred_currency);
									
									$op_amount = $val->operations?->first()->amount;
									$operation_amount = app('common')->currencyNumberFormat($preferred_currency, $op_amount);
									$of_amount =  $val->amount;
									$my_diff = ($op_amount - $of_amount);
									$diff = app('common')->currencyNumberFormat($preferred_currency , ($op_amount - $of_amount));
									$offer_amount = app('common')->currencyNumberFormat($preferred_currency ,$of_amount);
									$net_profit = app('common')->currencyNumberFormat($preferred_currency, $val->net_profit);
									$retention = app('common')->currencyNumberFormat($preferred_currency, $val->retention);
									$mipo_commission = app('common')->currencyNumberFormat($preferred_currency, $val->mipo_commission);
									$mi_coins_seller =  $val->operations?->first()->seller?->mi_coins_poinst?->sum('points');
									$mi_coins_buyer =  $val->buyer?->mi_coins_poinst?->sum('points');

										if($preferred_currency == 'USD') {
											$total_op_amount_usd += $op_amount; 
											$total_of_amount_usd += $of_amount; 
											$total_diff_amount_usd += $my_diff; 
											$total_comm_amount_usd += $val->mipo_commission; 
											$total_mipo_amount_usd += $val->mipo_plus_commission; 
										}else {
											$total_op_amount_gs += $op_amount; 
											$total_of_amount_gs += $of_amount; 
											$total_diff_amount_gs += $my_diff; 
											$total_comm_amount_gs += $val->mipo_commission; 
											$total_mipo_amount_gs += $val->mipo_plus_commission;
										}

										$offer_status = "Send Docs";
										$offer_status_color = "red";
										if($val->is_seller_deals_contract == 'No' || $val->is_buyer_deals_contract == "No") {
											$offer_status = "Pend. Signature";
										} else if($val->is_mipo_commission_payment == 'Yes') {
											$offer_status = "Collected";
											$offer_status_color = "green";
										}

										$class_mipo = "red";
											if($val->is_mipo_plus == 'Yes') {
												$class_mipo = "green";
											}
									@endphp
									
									<tr style="border-bottom: 1px solid #000000;">
										<th style="width:10%; color: #939393; font-weight: 500; padding: 4px 2px; text-align:left;">{{ $val->operations->first()?->operation_number }}</th>
										<th style="width:10%; color: #939393; font-weight: 500; padding: 4px 2px;">{{ $val->operations->first()?->seller->name }}</th>
										<th style="width:8%; color: #939393; font-weight: 500; padding: 4px 2px;">{{ $val->buyer?->name }}</th>
										<th style="width:8%; color: #939393; font-weight: 500; padding: 4px 2px;">{{ $val->operations->first()?->issuer?->company_name ?? '-' }}</th>
										<th style="width:8%; color: #939393; font-weight: 500; padding: 4px 2px;">{{ $val->operations->first()?->operation_type }}</th>
										<th style="width:8%; color: #939393; font-weight: 500; padding: 4px 2px;">{{ $currency_symbol.''.$operation_amount }}</th>
										<th style="width:8%; color: #939393; font-weight: 500; padding: 4px 2px;">{{ $currency_symbol.''.$offer_amount }}</th>
										<th style="width:8%; color: #939393; font-weight: 500; padding: 4px 2px;">{{ $currency_symbol.''. $diff }}</th>
										<th style="width:8%; color: #939393; font-weight: 500; padding: 4px 2px;">{{ $currency_symbol.''. $mipo_commission }}</th>
										<th style="width:8%; font-weight: 500; padding: 4px 2px;" class="{{ $class_mipo }}">{{ __($val->is_mipo_plus) }}</th>
										<th style="width:8%; color: #939393; font-weight: 500; padding: 4px 2px;">{{ $val->expires_at }}</th>
										<th style="width:8%; font-weight: 500; padding: 4px 2px; text-align:left;" class="{{ $offer_status_color }}">{{ __($offer_status) }}</th>
									</tr>
								@endforeach
							@endif
							<tr>
								<th style="width:10%;  color: #0D6EFD; font-weight: 500; padding: 4px 0 0 0;"></th>
								<th style="width:10%; color: #0D6EFD; font-weight: 500; padding: 4px 0 0 0;"></th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 4px 0 0 0;"></th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 4px 0 0 0;"></th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 4px 0 0 0;"></th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 4px 0 0 0;">Gs. {{ app('common')->currencyNumberFormat('Gs.', $total_op_amount_gs) }}</th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 4px 0 0 0;">Gs. {{ app('common')->currencyNumberFormat('Gs.', $total_of_amount_gs) }}</th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 4px 0 0 0;">Gs. {{ app('common')->currencyNumberFormat('Gs.', $total_diff_amount_gs) }}</th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 4px 0 0 0;">Gs. {{ app('common')->currencyNumberFormat('Gs.', $total_comm_amount_gs) }}</th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 4px 0 0 0;"></th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 4px 0 0 0;"></th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 4px 0 0 0;"></th>
							</tr>
							<tr>
								<th style="width:10%; color: #0D6EFD; font-weight: 500; padding: 0 0 4px 0;"></th>
								<th style="width:10%; color: #0D6EFD; font-weight: 500; padding: 0 0 4px 0;"></th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 0 0 4px 0;"></th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 0 0 4px 0;"></th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 0 0 4px 0;"></th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 0 0 4px 0;">USD {{ app('common')->currencyNumberFormat('USD',$total_op_amount_usd) }}</th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 0 0 4px 0;">USD {{ app('common')->currencyNumberFormat('USD',$total_of_amount_usd) }}</th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 0 0 4px 0;">USD {{ app('common')->currencyNumberFormat('USD',$total_diff_amount_usd) }}</th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 0 0 4px 0;">USD {{ app('common')->currencyNumberFormat('USD', $total_comm_amount_usd) }}</th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 0 0 4px 0;"></th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 0 0 4px 0;"></th>
								<th style="width:8%; color: #0D6EFD; font-weight: 500; padding: 0 0 4px 0;"></th>
							</tr>
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