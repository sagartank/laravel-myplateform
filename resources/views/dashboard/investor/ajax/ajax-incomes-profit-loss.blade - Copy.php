@php
    $current_date = date('Y-m-d 11:00:00');
    
    $total_invested = $total_profit = $total_cashed = $total_due = $total_uncashable = 0;
    
    $total_cashed_amount = $total_due_amount = $total_uncashable_amount = 0;
    
    $total_profit = $investor_deals->whereIn('offer_status', ['Approved','Completed'])->where('is_disputed', 'No')->sum('amount');
    
    $total_invested = $investor_deals->whereIn('offer_status', ['Approved','Completed'])->where('is_disputed', 'No')->pluck('operations')->flatten()->pluck('amount')->sum(); 
    
        /*
            1.cashed_data as Total Documents Collected
            2.due_data as  Total Notes Receivable
            3.uncashable_data as total disputes
        */
        $cashed_data = $investor_deals->whereIn('offer_status', ['Completed'])->where('is_disputed', 'No')->pluck('operations')->flatten();
        
        $total_cashed = $cashed_data->pluck('amount')->sum();
        
        $due_data = $investor_deals->where('offer_status', 'Approved')->where('is_disputed', 'No')->pluck('operations')->flatten();
    
        $total_due = $due_data->pluck('amount')->sum();
        
        $uncashable_data = $investor_deals->where('offer_status', 'Approved')->where('is_disputed', 'Yes')->pluck('operations')->flatten();
        
        $total_uncashable = $uncashable_data->pluck('amount')->sum();
        
        $total_operation_amount = $total_cashed + $total_due + $total_uncashable;

        $total_disputes = $investor_deals->whereIn('offer_status', ['Approved']) ->where('is_disputed', 'Yes')->sum('amount');
@endphp
<div class="income_lista_row">
    <div class="income_lista_col">
        <div class="income_lista_box active-txt">
            <h4>{{ __('Total Profit') }}</h4>
            <div class="income_price">
                {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_profit) }}</div>
        </div>
    </div>
    <div class="income_lista_col">
        <div class="income_lista_box">
            <h4>{{ __('Total Invested') }}</h4>
            <div class="income_price">
                {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_invested) }}</div>
        </div>
    </div>
    <div class="income_lista_col">
        <div class="income_lista_box active-txt">
            <h4>{{ __('Total Collected') }}</h4>
            <div class="income_price">
                {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_cashed) }}</div>
        </div>
    </div>
    <div class="income_lista_col">
        <div class="income_lista_box waiting-txt">
            <h4>{{ __('Total Receivable') }}</h4>
            <div class="income_price">
                {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_due) }}</div>
        </div>
    </div>
    <div class="income_lista_col">
        <div class="income_lista_box error-txt">
            <h4>{{ __('Total Disputes') }}</h4>
            <div class="income_price">
                {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_disputes) }}</div>
        </div>
    </div>
    <div class="income_lista_col">
        <div class="income_lista_box">
            <h4>{{ __('Nominal Value of Purchased Documents') }}</h4>
            <div class="income_price">
                {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_operation_amount) }}</div>
        </div>
    </div>
</div>

<div class="income_lista_bottom">
    <div class="income_lista_bottom_col">

        <div class="income_lista_bottom_blk active-txt">
            <div class="income_lista_title">
                <h3>{{ __('Total Documents Collected') }}</h3>
            </div>
            <div class="income_lista_left">

                @forelse ($cashed_data as $cashed)
                    @php
                        $total_cashed_amount += $cashed->amount;
                    @endphp
                    <div class="cheque_part_row">
                        <div class="cheque_part_left">
                            <div class="cheque_left_top">
                                <label for="cheque_check_1">{{ $cashed->operation_type_number }}
                                    - <span>{{ $cashed->seller->name }}</span></label>
                            </div>
                            <div class="cheque_compnyname">{{ $cashed->issuer->company_name }}</div>
                        </div>
                        <div class="cheque_part_right">
                            <div class="income_lista_amount">
                                {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $cashed->amount) }}
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
                        {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_cashed_amount) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="income_lista_bottom_blk waiting-txt">
            <div class="income_lista_title">
                <h3>{{ __('Total Notes Receivable') }}</h3>
            </div>

            <div class="income_lista_left">

                @forelse ($due_data as $due)
                    @php
                        $total_due_amount += $due->amount;
                    @endphp

                    <div class="cheque_part_row">
                        <div class="cheque_part_left">
                            <div class="cheque_left_top">
                                <label for="cheque_check_1">{{ $due->operation_type_number }}
                                    - <span>{{ $due->seller->name }}</span></label>
                            </div>
                            <div class="cheque_compnyname">{{ $due->issuer->company_name }}</div>
                        </div>
                        <div class="cheque_part_right">
                            <div class="income_lista_amount">
                                {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $due->amount) }}
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
                        {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_due_amount) }}
                    </div>
                </div>
            </div>

        </div>

        <div class="income_lista_bottom_blk error-txt" >
            <div class="income_lista_title">
                <h3>{{ __('Total Documents Disputes') }}</h3>
            </div>
            <div class="income_lista_left">

                @forelse ($uncashable_data as $uncashable)
                    @php
                        $total_uncashable_amount += $uncashable->amount;
                    @endphp

                    <div class="cheque_part_row">
                        <div class="cheque_part_left">

                            <div class="cheque_left_top">
                                <label for="cheque_check_1">{{ $uncashable->operation_type_number }}
                                    - <span>{{ $uncashable->seller->name }}</span></label>
                            </div>
                            <div class="cheque_compnyname">{{ $uncashable->issuer->company_name }}</div>

                        </div>
                        <div class="cheque_part_right">
                            <div class="income_lista_amount">
                                {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $uncashable->amount) }}
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
                        {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_uncashable_amount) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="income_grand_total income_lista_bottom_blk">
            <div class="income_lista_title">
                <h3>{{ __('Nominal Value of Purchased Documents') }}</h3>
            </div>
            <div class="total_count_income_wrap">
                <div class="total_count_income">
                    <div class="total_count_income_total">
                        {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_uncashable_amount + $total_due_amount + $total_cashed_amount) }}
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="income_lista_bottom_col">
        <input type="hidden" name="pie_chart_data" id="pie_chart_data"
            data-currency-name="{{ $req_param['currency_type'] }}"
            data-uncashable-amount="{{ $total_uncashable_amount }}" data-due-amount="{{ $total_due_amount }}"
            data-cashed-amount="{{ $total_cashed_amount }}" />
        <div class="income_lista_chart_blk">
            <div class="income_lista_chart_img" id="div_pie_incomes_investor">
                <img src="{{ asset('images/chart_incom_img_1.svg') }}" alt="no-image">
            </div>
            <div class="income_lista_chart_priceblk">
                <div class="income_lista_chart_price">
                    {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_invested) }}
                </div>
                <div class="income_txt_totalinvest">{{ __('Total Invested') }}</div>
            </div>
        </div>
    </div>
</div>
