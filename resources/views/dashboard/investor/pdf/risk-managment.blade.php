<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>MIPO</title>

	<!--PDF Stylesheet-->
	<style>
        @page {
            size: 8.268in 11.693in;
            margin: 27mm 16mm 27mm 16mm;
        }
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
			font-family: 'Arial', sans-serif;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            color: #000;
            background: #F5F7F9;
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
		.pdf-header .head-date .date-title {color: #000000;font-size: 12px;}
		.pdf-header .head-date .pdf-date {font-size: 14px;color: #000;font-weight: 600;}
		.pdf-body {padding: 0 0 40px;}
		.pdf-body .h2 {font-size: 14px;padding: 0 20px 4px;font-weight: 600;}	
		.pdf-body .h5 {font-size: 9px;padding: 0 20px 20px;font-weight: 500; color: #0D6EFD;}	
        .pdf-body table {
            width: 100%;
            border: none;
            border-collapse: collapse;
            margin: 0px;
            padding: 0px;
        }
        .pdf-body table tr {}
        .pdf-body table tr td {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            color: #000000;
            line-height: 18px;
            vertical-align: top;
            margin: 0px;
            padding: 2px 10px;
        } 
        .pdf-body table tr td strong {display: inline-block;vertical-align: middle;
            color: #000;
            font-weight: normal;
        }	
		.pdf-body table.content-table > tr > td {vertical-align: top;}
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

		.pdf-footer {  padding: 14px 20px; border-top: 1px solid #ADADAD; }
		.pdf-footer table tr td { text-align: center;  }
		.pdf-footer h5 { font-size: 13px; color: #0D6EFD; padding-bottom: 8px; font-family: 'Arial', sans-serif; }
		.pdf-footer p {color: #000000; font-family: 'Arial', sans-serif; }
		.pdf_income_lista_row { width: 100%; }
		.pdf_income_lista_col { width: 33.33%; padding: 10px; }
		.pdf_income_lista_box { background: #ffffff;border: 1px solid #eeeeee; }
		.pdf_income_lista_box .h4 {font-family: 'Arial', sans-serif; font-weight: 500;font-size: 10px;line-height: 135%;color: #000; padding: 15px 10px 0; }
		.left_row_pdf .h4 {font-family: 'Arial', sans-serif; font-weight: 500;font-size: 13px;line-height: 135%;color: #000; padding: 0 10px 10px 10px; }
		.pdf_income_lista_box .income_price {font-family: 'Arial', sans-serif; font-weight: 500;font-size: 12px;line-height: 135%;color: #000; padding: 4px 10px 15px 10px; }
		body .pdf_color_green { color: #198754 !important; }
		body .pdf_color_red { color: #DC3545 !important; }
		body .pdf_color_waiting { color: #FFC107 !important; }
		.pdf_income_lista_bottom_blk{background: #fff;border: 1px solid #eeeeee; padding: 20px 0 !important; }
		.pdf_title_block_top { padding: 0 10px 10px; }
		.pdf_chaque_name { font-family: 'Arial', sans-serif; font-weight: 500;font-size: 10px;line-height: 135%;color: #000; }
		.pdf_chaque_ownar { font-family: 'Arial', sans-serif; font-weight: 500;font-size: 7px;line-height: 135%;color: #0D6EFD; }
		.pdf_chaque_amount { font-family: 'Arial', sans-serif; font-size: 7px; color: #000; text-align: right; }
		.pdf_total_count_income { padding: 8px; border: solid 1px #eeeeee; }
		.pdf_total_count_income_title,
		.pdf_total_count_income_total { color: #000000 !important; font-weight: 500; font-size: 12px !important; font-family: 'Arial', sans-serif; }
		.pdf_total_count_income_total { text-align: right; }
		.right_row_pdf {background: #fff;border: 1px solid #eeeeee;padding: 20px 20px !important; text-align: center; }
		.income_lista_chart_price { width: 100%; text-align: center; font-size: 22px;line-height: 1.350;color: #000; font-style: normal; font-weight: 500; }
		.income_txt_totalinvest { width: 100%; text-align: center; font-size: 10px;line-height: 1.30769;color: #000; font-style: normal; font-weight: 500; }
	</style>
	<!--PDF Stylesheet-->
</head>
@php
    $current_date = date('Y-m-d 11:00:00');
    $total_invested_amount = $self_risk_amount = $gauranteed_risk_amount = 0;
    $total_invested = $total_self_risk = $total_gauranteed_risk = 0;
    
    $invested_data = $investor_deals
        ->where('offer_status', 'Approved')
        ->where('is_disputed', 'No')
        ->where('expires_at', '>=', $current_date)
        ->pluck('operations')
        ->flatten();
    
    $total_invested_amount = $invested_data->pluck('amount')->sum();
    
    $self_risk_data = $investor_deals
        ->where('offer_status', 'Approved')
        ->where('expires_at', '>=', $current_date)
        ->where('is_mipo_plus', 'No')
        ->where('is_cashed', 'No');
    
    $self_risk_amount = $self_risk_data->sum('amount');
    
    $gauranteed_risk_data = $investor_deals
        ->where('offer_status', 'Approved')
        ->where('expires_at', '>=', $current_date)
        ->where('is_mipo_plus', 'Yes')
        ->where('is_cashed', 'No');
    
    $gauranteed_risk_amount = $gauranteed_risk_data->sum('amount');
    
    $user_type = 'buyer';
    if ($req_param['preferred_dashboard'] == 'Borrower') {
        $user_type = 'seller';
    }
@endphp
<body>
	<div class="pdf-wrapper">
		<header>
			<div class="pdf-header">
				<table>
					<tr>
						<td>
							<div class="logo text-center">
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
			<div class="h2">{{ __('Risk Managment')}}</div>
			<div class="h5">{{ __('Investors')}}</div>
			<table class="content-table ">
				<tr>
					<td colspan="2">
						<table class="pdf_income_lista_row">
							<tr>
								<td class="pdf_income_lista_col">
									<table class="pdf_income_lista_box">
										<tr>
											<td class="h4">{{ __('Total Invested') }}</td>
										</tr>
										<tr>
											<td class="income_price">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_invested_amount) }}</td>
										</tr>
									</table>
								</td>
								<td class="pdf_income_lista_col">
									<table class="pdf_income_lista_box">
										<tr>
											<td class="h4">{{ __('Regular Investment') }}</td>
										</tr>
										<tr>
											<td class="income_price">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $self_risk_amount) }}</td>
										</tr>
									</table>
								</td>
                                <td class="pdf_income_lista_col">
									<table class="pdf_income_lista_box">
										<tr>
											<td class="h4">{{ __('MIPO+') }}</td>
										</tr>
										<tr>
											<td class="income_price pdf_color_green">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $gauranteed_risk_amount) }}</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table>
							<tr>
								<td style="width: 50%;" class="left_row_pdf">
									<table>
										<tr>
											<td style="padding: 0;">
												<table>
													<tr>
														<td class="pdf_income_lista_bottom_blk">
															<table>
																<tr>
																	<td class="pdf_title_block_top h4">
																		{{ __('Total Invested') }}
																	</td>
																</tr>
                                                                @forelse ($invested_data as $invested)
                                                                @php
                                                                    $total_invested += $invested->amount;
                                                                @endphp
																<tr>
																	<td style="border-bottom: 1px solid #dfdfdf; padding: 5px 10px;">
																		<table>
																			<tr>
																				<td style="padding: 0 10px 0 0 !important;">
																					<div class="pdf_chaque_name">{{ $invested->operation_type_number.' - '.$invested->seller->name  }}</div>
																					<div class="pdf_chaque_ownar">{{ $invested->issuer->company_name }}</div>
																				</td>
																				<td class="pdf_chaque_amount" style="padding: 0 0 0 10px !important; vertical-align: top;">
																					{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $invested->amount) }}
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
                                                                @empty
                                                                <tr>
                                                                    <td>{{ __('No record found.') }} </td>
                                                                </tr>
                                                            @endforelse
																<tr>
																	<td style="padding-top: 15px;">
																		<table>
																			<tr>
																				<td class="pdf_total_count_income">
																					<table>
																						<tr>
																							<td style="padding: 0 10px 0 0 !important;" class="pdf_total_count_income_title">
                                                                                                {{ __('Total') }}
																							</td>
																							<td class="pdf_total_count_income_total" style="padding: 0 0 0 10px !important;vertical-align: top;">
																								{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_invested) }}
																							</td>
																						</tr>
																					</table>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td style="padding: 15px 0 0 0;">
												<table>
													<tr>
														<td class="pdf_income_lista_bottom_blk">
															<table>
																<tr>
																	<td class="pdf_title_block_top h4">
																		{{ __('Regular Investment') }}
																	</td>
																</tr>
                                                                @forelse ($self_risk_data as $self_risk)
                                                                    @php
                                                                        $total_self_risk += $self_risk->amount;
                                                                    @endphp
                                                                    @if ($self_risk->offer_type == 'Single')
                                                                        <tr>
                                                                            <td style="padding: 5px 10px;">
                                                                                <table>
                                                                                    <tr>
                                                                                        <td style="padding: 0 10px 0 0 !important;">
                                                                                            <div class="pdf_chaque_name">{{ $self_risk->operations->first()->operation_type_number.' '.$self_risk->buyer?->name }}</div>
                                                                                            <div class="pdf_chaque_ownar">{{ $self_risk->operations->first()->issuer->company_name }}</div>
                                                                                        </td>
                                                                                        <td class="pdf_chaque_amount" style="padding: 0 0 0 10px !important; vertical-align: top;">
                                                                                            {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $self_risk->amount) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    @elseif($self_risk->offer_type == 'Group')
                                                                        <tr>
                                                                            <td style="padding: 5px 10px;">
                                                                                <table>
                                                                                    <tr>
                                                                                        <td style="padding: 0 10px 0 0 !important;">
                                                                                            <div class="pdf_chaque_name">{{ __('Group Offer Mix') }}</div>
                                                                                            <div class="pdf_chaque_ownar">{{ $self_risk->buyer?->name }} </div>
                                                                                        </td>
                                                                                        <td class="pdf_chaque_amount" style="padding: 0 0 0 10px !important; vertical-align: top;">
                                                                                            {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $self_risk->amount) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @empty
                                                                    <tr>
                                                                        <td>{{ __('No record found.') }} </td>
                                                                    </tr>
                                                                @endforelse
																<tr>
																	<td style="padding-top: 15px;">
																		<table>
																			<tr>
																				<td class="pdf_total_count_income">
																					<table>
																						<tr>
																							<td style="padding: 0 10px 0 0 !important;" class="pdf_total_count_income_title">
                                                                                                {{ __('Total') }}
																							</td>
																							<td class="pdf_total_count_income_total" style="padding: 0 0 0 10px !important;vertical-align: top;">
                                                                                                {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_self_risk) }}
																							</td>
																						</tr>
																					</table>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
								<td style="width: 50%;">
									<table>
                                        <input type="hidden" name="pie_chart_data" id="pie_chart_data"
                                        data-currency-name="{{ $req_param['currency_type'] }}" data-mipo-amount="{{ $gauranteed_risk_amount }}"
                                        data-invested-amount="{{ $total_invested_amount }}" data-self-risk-amount="{{ $self_risk_amount }}" />
										<tr>
											<td class="right_row_pdf">
												<table>
													<tr>
														<td>
                                                            <img style="width: auto; height: auto; max-width: 100%; " src="{{ $pie_chart_image }}" alt="no-image">
														</td>
													</tr>
													{{-- <tr>
														<td>
															<div class="income_lista_chart_price">
															</div>
															<div class="income_txt_totalinvest">{{ __('Total Invested') }}</div>
														</td>
													</tr> --}}
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							
						</table>
					</td>
				</tr>
				<tr>
					<td style="width: 50%;" class="left_row_pdf">
						<table>
							<tr>
                                <td style="padding: 15px 0 0 0;">
                                    <table>
                                        <tr>
                                            <td class="pdf_income_lista_bottom_blk">
                                                <table>
                                                    <tr>
                                                        <td class="pdf_title_block_top h4">
                                                            {{ __('MIPO+ (Gauranteed Buy Back)') }}
                                                        </td>
                                                    </tr>
                                                    @forelse ($gauranteed_risk_data as $gauranteed_risk)
                                                        @php
                                                            $total_gauranteed_risk += $gauranteed_risk->amount;
                                                        @endphp
                                                        @if ($gauranteed_risk->offer_type == 'Single')
                                                            <tr>
                                                                <td style="padding: 5px 10px;">
                                                                    <table>
                                                                        <tr>
                                                                            <td style="padding: 0 10px 0 0 !important;">
                                                                                <div class="pdf_chaque_name">{{ $gauranteed_risk->operations->first()->operation_type_number.' '.$gauranteed_risk->buyer?->name }}</div>
                                                                                <div class="pdf_chaque_ownar">{{ $gauranteed_risk->operations->first()->issuer->company_name }}</div>
                                                                            </td>
                                                                            <td class="pdf_chaque_amount" style="padding: 0 0 0 10px !important; vertical-align: top;">
                                                                                {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $gauranteed_risk->amount) }}
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        @elseif($gauranteed_risk->offer_type == 'Group')
                                                            <tr>
                                                                <td style="padding: 5px 10px;">
                                                                    <table>
                                                                        <tr>
                                                                            <td style="padding: 0 10px 0 0 !important;">
                                                                                <div class="pdf_chaque_name">{{ __('Group Offer Mix') }}</div>
                                                                                <div class="pdf_chaque_ownar">{{ $gauranteed_risk->buyer?->name }} </div>
                                                                            </td>
                                                                            <td class="pdf_chaque_amount" style="padding: 0 0 0 10px !important; vertical-align: top;">
                                                                                {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $gauranteed_risk->amount) }}
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @empty
                                                        <tr>
                                                            <td>{{ __('No record found.') }} </td>
                                                        </tr>
                                                    @endforelse
                                                    <tr>
                                                        <td style="padding-top: 15px;">
                                                            <table>
                                                                <tr>
                                                                    <td class="pdf_total_count_income">
                                                                        <table>
                                                                            <tr>
                                                                                <td style="padding: 0 10px 0 0 !important;" class="pdf_total_count_income_title pdf_color_green">
                                                                                    {{ __('Total') }}
                                                                                </td>
                                                                                <td class="pdf_total_count_income_total pdf_color_green" style="padding: 0 0 0 10px !important;vertical-align: top;">
                                                                                    {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_self_risk) }}
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
						</table>
					</td>
					<td style="width: 50%;" class="left_row_pdf"></td>
				</tr>
			</table>
		</div>
		<footer>
			<div class="pdf-footer">
				<table>
					<tr>
						<td>
							<h5>{{ __('MIPORTAFOLIO')}}</h5>
							<p><strong>{{ __('Email us:')}}</strong> contact@mipo.com &nbsp; | &nbsp; <strong>Website:</strong> www.mipo.com</p>
						</td>
					</tr>
				</table>
			</div>
		</footer>
	</div>
</body>
</html>