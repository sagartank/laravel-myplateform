@php
    $current_date = date('Y-m-d 11:00:00');
    $total_invested_amount = $self_risk_amount = $gauranteed_risk_amount = 0;
    $total_invested = $total_self_risk = $total_gauranteed_risk = 0;
    
    $invested_data = $investor_deals
        ->whereIn('offer_status', ['Approved','Completed'])
        ->where('is_disputed', 'No');
    
    $total_invested_amount = $invested_data->sum('amount');
    
    $self_risk_data = $investor_deals
        ->whereIn('offer_status', ['Approved','Completed'])
        ->where('is_mipo_plus', 'No');
    
    
    $gauranteed_risk_data = $investor_deals
        ->whereIn('offer_status', ['Approved','Completed'])
        ->where('is_mipo_plus', 'Yes');
    
    $user_type = 'buyer';
    if ($req_param['preferred_dashboard'] == 'Borrower') {
        $user_type = 'seller';
    }

    $self_risk_amount = $gauranteed_risk_amount = 0;
    
    $self_risk_amount = $self_risk_data->sum('amount');
    
    $gauranteed_risk_amount = $gauranteed_risk_data->sum('amount');

@endphp

<div class="icome-ajax-rightbox">
    <div class="income_lista_row">
        <div class="income_lista_col">
            <div class="income_lista_box">
                <div class="income_price ingra_text">
                    {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], ($self_risk_amount + $gauranteed_risk_amount)) }}
                </div>
                <h4>{!! __('Total Invested') !!}</h4>
            </div>
        </div>
        <div class="income_lista_col">
            <div class="income_lista_box">
                <div class="income_price ingra_text">
                    {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $self_risk_amount) }}
                </div>
                <h4>{!! __('Investments') !!}</h4>
            </div>
        </div>
        <div class="income_lista_col">
            <div class="income_lista_box active-txt">
                <div class="income_price" style="color: var(--m-green-text);">
                    {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $gauranteed_risk_amount) }}
                </div>
                <h4>{!! __('MIPO+ investments') !!}</h4>
            </div>
        </div>
    </div>
    <div class="income_lista_bottom">
        <div class="income_lista_bottom_col">
            <div class="income_lista_bottom_blk">
                <div class="income_lista_title">
                    <h3>{{ __('Total Invested') }}</h3>
                </div>
                <div class="content_wrap">
                    <div class="income_lista_left">
                        @forelse ($invested_data as $invested)
                            @php
                                $total_invested += $invested->amount;
                            @endphp
                            <div class="cheque_part_row">
                                <div class="cheque_part_left evt_operations_details" data-operations-details-link="{{ route('operations.details', $invested->slug) }}" role="button" title="Click More Details">
                                    <div class="cheque_left_top">
                                        <label for="cheque_check_1">{{ $invested->operations->first()->operation_type_number }} <span>{{ $invested->operations->first()->seller->name }}</span></label>
                                    </div>
                                    <div class="cheque_compnyname">{{ $invested->operations->first()->issuer->company_name }}</div>
                                </div>
                                <div class="cheque_part_right">
                                    <div class="income_lista_amount">
                                        {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $invested->amount) }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="cheque_part_row">
                                <p>{{ __('No record found.') }} </p>
                            </div>
                        @endforelse
                    </div>
                    <div class="total_count_income_wrap">
                        <div class="total_count_income">
                            <div class="total_count_income_title">
                                {{ __('Total') }}
                            </div>
                            <div class="total_count_income_total">
                                {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_invested) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="income_lista_bottom_blk">
                <div class="income_lista_title">
                    <h3>{{ __('Investments') }}</h3>
                </div>
                <div class="content_wrap">
                    <div class="income_lista_left">
                        @forelse ($self_risk_data as $self_risk)
                            @php
                                $total_self_risk += $self_risk->amount;
                            @endphp
                            <div class="cheque_part_row">
                                @if ($self_risk->offer_type == 'Single')
                                    <div class="cheque_part_left evt_deals_details"
                                        data-deals-details-link="{{ route('deals.details', [$self_risk->slug, $user_type]) }}"
                                        title="Click More Details">
                                        <div class="cheque_left_top">
                                            <label
                                                for="cheque_check_1">{{ $self_risk->operations->first()->operation_type_number }}
                                                <span>{{ $self_risk->buyer?->name }}</span></label>
                                        </div>
                                        <div class="cheque_compnyname">{{ $self_risk->operations->first()->issuer->company_name }}
                                        </div>
                                    </div>
                                @elseif($self_risk->offer_type == 'Group')
                                    <div class="cheque_part_left evt_deals_details"
                                        data-deals-details-link="{{ route('deals.details', [$self_risk->slug, $user_type]) }}"
                                        title="Click More Details">
                                        <div class="cheque_left_top">
                                            <label for="cheque_check_1">{{ __('Group Offer') }}
                                                <span>{{ $self_risk->buyer?->name }}</span></label>
                                        </div>
                                        <div class="cheque_compnyname">{{ __('Mix') }}</div>
                                    </div>
                                @endif
                                <div class="cheque_part_right">
                                    <div class="income_lista_amount">
                                        {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $self_risk->amount) }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="cheque_part_row">
                                <p>{{ __('No record found.') }} </p>
                            </div>
                        @endforelse
                    </div>
                    <div class="total_count_income_wrap">
                        <div class="total_count_income">
                            <div class="total_count_income_title">
                                {{ __('Total') }}
                            </div>
                            <div class="total_count_income_total">
                                {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_self_risk) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="income_lista_bottom_blk active-txt">
                <div class="income_lista_title">
                    <h3>{{ __('MIPO+ investments') }}</h3>
                </div>
                <div class="content_wrap">
                    <div class="income_lista_left">
                        @forelse ($gauranteed_risk_data as $gauranteed_risk)
                            @php
                                $total_gauranteed_risk += $gauranteed_risk->amount;
                            @endphp
                            <div class="cheque_part_row">
                                @if ($gauranteed_risk->offer_type == 'Single')
                                    <div class="cheque_part_left evt_deals_details"
                                        data-deals-details-link="{{ route('deals.details', [$self_risk->slug, $user_type]) }}"
                                        title="Click More Details">
                                        <div class="cheque_left_top">
                                            <label
                                                for="cheque_check_1">{{ $gauranteed_risk->operations->first()->operation_type_number }}
                                                <span>{{ $gauranteed_risk->buyer?->name }}</span></label>
                                        </div>
                                        <div class="cheque_compnyname">
                                            {{ $gauranteed_risk->operations->first()->issuer->company_name }}</div>
                                    </div>
                                @elseif($gauranteed_risk->offer_type == 'Group')
                                    <div class="cheque_part_left evt_deals_details"
                                        data-deals-details-link="{{ route('deals.details', [$self_risk->slug, $user_type]) }}"
                                        title="Click More Details">
                                        <div class="cheque_left_top">
                                            <label for="cheque_check_1">{{ __('Group Offer') }}
                                                <span>{{ $gauranteed_risk->buyer?->name }}</span></label>
                                        </div>
                                        <div class="cheque_compnyname">{{ __('Mix') }}</div>
                                    </div>
                                @endif
                                <div class="cheque_part_right">
                                    <div class="income_lista_amount">
                                        {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $gauranteed_risk->amount) }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="cheque_part_row">
                                <p>{{ __('No record found.') }} </p>
                            </div>
                        @endforelse
                    </div>
                    <div class="total_count_income_wrap">
                        <div class="total_count_income gre_wrap">
                            <div class="total_count_income_title">
                                {{ __('Total') }}
                            </div>
                            <div class="total_count_income_total">
                                {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_gauranteed_risk) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="income_lista_bottom_col gr-wrap">
            <input type="hidden" name="pie_chart_data" id="pie_chart_data"
                data-currency-name="{{ $req_param['currency_type'] }}" data-mipo-amount="{{ $gauranteed_risk_amount }}"
                data-invested-amount="{{ $total_invested_amount }}" data-self-risk-amount="{{ $self_risk_amount }}" />
            <div class="income_lista_chart_blk">
                <div class="income_lista_chart_img" id="div_pie_risk_managment_investor">
                    <img src="{{ asset('images/risk-management-image.svg') }}" alt="no-image">
                </div>
            </div>
        </div>
    </div>
</div>