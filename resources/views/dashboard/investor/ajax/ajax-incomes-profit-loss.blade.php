@php
    $current_date = date('Y-m-d 11:00:00');
    
    $total_invested = $total_profit = $total_cashed = $total_due = $total_uncashable = 0;
    
    $total_cashed_amount = $total_due_amount = $total_uncashable_amount = 0;
    
    $total_profit_ = $investor_deals->whereIn('offer_status', ['Approved','Completed'])->where('is_disputed', 'No')->sum('amount');
    
    $total_invested = $investor_deals->whereIn('offer_status', ['Approved','Completed'])->where('is_disputed', 'No')
        ->pluck('operations')->flatten()->unique('operation_id')
        ->filter(function ($model_name) {
                return ($model_name->pivot->is_offered == 1);
        })
        ->pluck('amount')
        ->sum();
    
    $total_profit = ($total_invested - $total_profit_);
    
        /*
            1.cashed_data as Total Documents Collected
            2.due_data as  Total Notes Receivable
            3.uncashable_data as total disputes
        */
        $cashed_data = $investor_deals->whereIn('offer_status', ['Completed'])->where('is_disputed', 'No')->pluck('operations')->flatten();
        
        $total_cashed =  $investor_deals->whereIn('offer_status', ['Completed', 'Approved'])->where('is_cashed_buyer', 'Yes')->where('is_disputed', 'No')->sum('amount');
        
        $due_data = $investor_deals->where('offer_status', 'Approved')->where('is_disputed', 'No')->pluck('operations')->flatten();
    
        $total_pending_cashing = $investor_deals->whereIn('offer_status', ['Completed', 'Approved'])->where('is_cashed_buyer', 'No')->where('is_disputed', 'No')->sum('amount');
        
        $uncashable_data = $investor_deals->where('offer_status', 'Approved')->where('is_disputed', 'Yes')->pluck('operations')->flatten();
        
        $total_uncashable = $uncashable_data->pluck('amount')->sum();
        
        $total_operation_amount = $total_cashed + $total_due + $total_uncashable;

        $total_disputes = $investor_deals->whereIn('offer_status', ['Approved']) ->where('is_disputed', 'Yes')->sum('amount');
@endphp

<div class="icome-lista-rightbox">
    <div class="income_lista_row">
        <div class="income_lista_col">
            <div class="income_lista_box active-txt">
                <div class="income_price">
                    {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_profit) }}
                </div>
                <h4>{!! __('Total Profit') !!}</h4>
            </div>
        </div>
        <div class="income_lista_col">
            <div class="income_lista_box">
                <div class="income_price inbl_text">
                    {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_profit_) }}
                </div>
                <h4>{!! __('Total Invested') !!}</h4>
            </div>
        </div>
        <div class="income_lista_col">
            <div class="income_lista_box active-txt">
                <div class="income_price">
                    {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_cashed) }}
                </div>
                <h4>{!! __('Total Cashed') !!}</h4>
            </div>
        </div>
        <div class="income_lista_col">
            <div class="income_lista_box waiting-txt">
                <div class="income_price inyl_text">
                    {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_pending_cashing) }}
                </div>
                <h4>{!! __('Total Pending Cashing') !!}</h4>
            </div>
        </div>
        <div class="income_lista_col">
            <div class="income_lista_box error-txt">
                <div class="income_price inrd_text">
                    {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_disputes) }}
                </div>
                <h4>{!! __('Total Disputes') !!}</h4>
            </div>
        </div>
        <div class="income_lista_col">
            <div class="income_lista_box">
                <div class="income_price inbl_text">
                    {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_operation_amount) }}
                </div>
                <h4>{!! __('Nominal Value of Documents') !!}</h4>
            </div>
        </div>
    </div>
    <div class="income_lista_bottom">
        <div class="income_lista_bottom_col">
            <div class="income_lista_bottom_blk active-txt">
                <div class="income_lista_title">
                    <h3>{!! __('Total Documents Cashed') !!}</h3>
                </div>
                <div class="content_wrap">
                    <div class="income_lista_left">
                        @forelse ($cashed_data as $cashed)
                            @php
                                $total_cashed_amount += $cashed->amount;
                            @endphp
                            <div class="cheque_part_row">
                                <div class="cheque_part_left">
                                    <a href="#">
                                        <div class="cheque_left_top">
                                            <label for="cheque_check_1">{{ $cashed->operation_type_number }}
                                                - <span>{{ $cashed->seller->name }}</span></label>
                                        </div>
                                        <div class="cheque_compnyname">{{ $cashed->issuer->company_name }}</div>
                                    </a>
                                </div>
                                <div class="cheque_part_right">
                                    <div class="income_lista_amount">
                                        {{  app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $cashed->amount) }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="cheque_part_row">
                                <p>{!! __('No record found.') !!} </p>
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
            </div>
            <div class="income_lista_bottom_blk waiting-txt">
                <div class="income_lista_title head-wrap">
                    <h3>{!! __('Total Documents Pending Cashing') !!}</h3>
                </div>
                <div class="content_wrap">
                    <div class="income_lista_left">
                        @forelse ($due_data as $due)
                            @php
                                $total_due_amount += $due->amount;
                            @endphp
        
                            <div class="cheque_part_row">
                                <div class="cheque_part_left">
                                    <a href="#">
                                        <div class="cheque_left_top">
                                            <label for="cheque_check_1">{{ $due->operation_type_number }}
                                                - <span>{{ $due->seller->name }}</span></label>
                                        </div>
                                        <div class="cheque_compnyname">{{ $due->issuer->company_name }}</div>
                                    </a>
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
                        <div class="total_count_income total_wrap">
                            <div class="total_count_income_title">
                                {{ __('Total') }}
                            </div>
                            <div class="total_count_income_total">
                                {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_due_amount) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="income_lista_bottom_blk error-txt" >
                <div class="income_lista_title red-caption">
                    <h3>{!! __('Sold Documents with Recurso') !!}</h3>
                </div>
                <div class="content_wrap">
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
                        <div class="total_count_income red-alert">
                            <div class="total_count_income_title">
                                {{ __('Total') }}
                            </div>
                            <div class="total_count_income_total">
                                {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_uncashable_amount) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="income_grand_total income_lista_bottom_blk">
                <div class="income_lista_title black-tit">
                    <h3>{{ __('Nominal Value of Purchased Documents') }}</h3>
                </div>
                <div class="content_wrap">
                    <div class="total_count_income_wrap">
                        <div class="total_count_income totblack">
                            <div class="total_count_income_total">
                                {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_uncashable_amount + $total_due_amount + $total_cashed_amount) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="income_lista_bottom_col graph_wrapper">
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
                    <div class="income_txt_totalinvest">{!! __('Total Documents Purchased') !!}</div>
                </div>
            </div>
        </div>
    </div>
</div>