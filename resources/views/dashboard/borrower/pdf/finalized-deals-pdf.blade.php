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
			.finalized_deals_pdf_wrap {
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
		/* finalized operations */
		$total_finalized_doc_sold = $total_finalized_doc_sold_amount = 0;
		$datetime = \Carbon\Carbon::now();
		$download_datetime = $datetime->format('jS F Y, h:i A');
		
		$finalized_doc_sold_data = $borrower_deals
			->whereIn('offer_status', ['Approved','Completed'])
			->where('is_disputed', 'No')
			->pluck('operations')
			->flatten();
		
		$total_finalized_doc_sold = $finalized_doc_sold_data->pluck('amount')->sum();
		
		$total_finalized_doc_accepted  = $total_finalized_doc_accepted_amount = 0;

		$total_finalized_doc_accepted = $borrower_deals
			->whereIn('offer_status', ['Approved','Completed'])
			->where('is_disputed', 'No')
			->pluck('amount')
			->sum();

		$finalized_doc_accepted_data = $borrower_deals
			->whereIn('offer_status', ['Approved','Completed'])
			->where('is_disputed', 'No')
			->pluck('operations')
			->flatten();
		
		$total_finalized_avg_discount = 0;
		
		$total_finalized_avg_discount = $borrower_deals
			->whereIn('offer_status', ['Approved','Completed'])
			->where('is_disputed', 'No')
			->pluck('net_profit')
			->avg();
	@endphp
	<body>
		<div class="finalized_deals_pdf_wrap">
			<table style="width: 100%;">
				<tr>
					<th style="text-align: left;">
						<p style="color: #000000; font-size: 14px; font-weight: 600; text-transform: capitalize;">{!! __('Finalized Deals') !!}<span style="color: #707070; padding:0 0 0 10px; font-size: 12px; font-weight: 500; text-transform: capitalize;">{!! __('Seller') !!}</span></p>
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
									<p style="font-weight: 600; padding: 6px 12px 8px 12px; color: #000000;">{!! __('Information') !!}</p>
								</td>
							</tr>
							<tr style="width: 100%; border-bottom: 1px solid #707070; border-top: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{!! __('Total Documents Sold') !!}</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_finalized_doc_sold) }}</td>
							</tr>
							<tr style="width: 100%; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{!! __('Total Accepted Offers') !!}</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_finalized_doc_accepted) }}</td>
							</tr>
							<tr style="width: 100%; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{!! __('Average Discount') !!}</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_finalized_avg_discount) }} %</td>
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
									<p style="font-weight: 600; padding: 6px 12px 8px 12px; color: #000000;">{!! __('Total Documents Sold') !!}</p>
								</td>
							</tr>
							@forelse ($finalized_doc_sold_data as $finalized_doc_sold)
							@php
								$total_finalized_doc_sold_amount += $finalized_doc_sold->amount;
							@endphp
							<tr style="width: 100%; border-bottom: 1px solid #707070; border-top: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{{ $finalized_doc_sold->operation_type_number.' - '.$finalized_doc_sold->seller->name  }}</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $finalized_doc_sold->amount) }}</td>
							</tr>
							@empty
							
							@endforelse
							
							<tr style="width: 100%; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{!! __('Total') !!}</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_finalized_doc_sold_amount) }}</td>
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
									<p style="font-weight: 600; padding: 6px 12px 8px 12px; color: #000000;">{!! __('Total Accepted Offers') !!}</p>
								</td>
							</tr>
							@forelse ($finalized_doc_accepted_data as $finalized_doc_accepted)
								@php
									$total_finalized_doc_accepted_amount += $finalized_doc_accepted->amount;
								@endphp
								<tr style="width: 100%; border-bottom: 1px solid #707070; border-top: 1px solid #707070; ">
									<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{{ $finalized_doc_accepted->operation_type_number.'-'.$finalized_doc_accepted->seller->name  }}</td>
									<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $finalized_doc_accepted->amount) }}</td>
								</tr>
							@empty
							
							@endforelse
							<tr style="width: 100%; border-bottom: 1px solid #707070;">
								<td style="color: #000000; font-weight: 500; padding: 4px 12px; text-align: left;">{!! __('Total') !!}</td>
								<td style="color: #707070; font-weight: 500; padding: 4px 12px; text-align: right;">  {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_finalized_doc_accepted_amount) }}</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		{{-- 	<table style="width: 100%; border-collapse: collapse;">
				<tr>
					<td style="padding: 0; border: 1px solid #707070;">
						<table style="width: 100%; border-collapse: collapse;">
							<tr style="width: 100%;">
								<td style="font-weight: 600; padding: 6px 12px 8px 12px; text-align: left; color: #000000;">{!! __('Discount Given Over Sold Operations') !!}</td>
								<td style="color: #707070; font-weight: 500; padding: 6px 12px 8px 12px; text-align: right;">1.400,00 USD</td>
							</tr>
						</table>
					</td>
				</tr>
			</table --}}
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