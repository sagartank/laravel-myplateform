@php
    $current_date = date('Y-m-d 11:00:00');
    $seller_document_sold =  $seller_document_cashed = $seller_on_going_deals = $seller_pending_action = $seller_counter_offered = 0;
    $total_sold_amount = $total_cashed_amount = $total_overall_discount = 0;
    $total_doc_sold_with_resources = $total_doc_sold_without_resources = 0;
    $total_avg_retention = 0;

    $total_invested_amount = $total_profit_amount = 0;

    $commissions_pending_qty =  $commissions_pending_amount = 0;
    $commissions_paid =  $total_save_vs_regular_ac = 0;

    $mi_coins_available = $mi_coins_cashed = 0;
    $total_mipo_qty = $total_mipo_deals_amount = 0;

    $best_seller = 0;
    $current_offers = $expired_offers = $offer_received = $received_counter_offers =  0; 
    
    $buyer_purchased_documents = $buyer_document_cashed = $buyer_operations_in_process = $buyer_pending_action = 
    $buyer_received_counter_offers = $buyer_pending_reviews = $buyer_total_profit = $buyer_total_invested = $buyer_offer_sent = $buyer_offer_won =  0;
    
    if(isset($important_data_deals)) {
        $seller_document_sold = $important_data_deals->where('offer_status', 'Approved')->count();
        $seller_document_cashed = $important_data_deals->where('is_cashed_buyer', 'Yes')->count();
        $seller_on_going_deals = $important_data_deals->where('offer_status', 'Approved')->count();
        $seller_pending_action = $important_data_deals->where('offer_status', 'Approved')->where('is_seller_deals_contract', 'No')->count();
        $seller_counter_offered = $important_data_deals->where('offer_status', 'Counter')->count();
        
        $buyer_purchased_documents = $important_data_deals->where('is_disputed', 'No')->where('offer_status', 'Approved')->count();
        $buyer_document_cashed = $important_data_deals->where('is_disputed', 'No')->where('is_cashed_buyer', 'Yes')->where('offer_status', 'Approved')->count();
        $buyer_operations_in_process = $important_data_deals->where('offer_status', 'Approved')->count();
        $buyer_pending_action = $important_data_deals->where('offer_status', 'Approved')->where('is_buyer_deals_contract', 'No')->count();
        $buyer_received_counter_offers = $important_data_deals->where('is_disputed', 'No')->where('offer_status', 'Counter')->pluck('operations')
            ->flatten()->unique('operation_id')
            ->filter(function ($model_name) {
                    return ($model_name->pivot->is_offered == 0);
            })
            ->count();
        $buyer_pending_reviews = $important_data_deals->where('is_disputed', 'No')->whereIn('offer_status',['Approved','Completed'])->where('is_rated_buyer', 'No')->count();
        $buyer_total_profit = $important_data_deals->where('is_disputed', 'No')->where('offer_status', 'Approved')->pluck('operations')
            ->flatten()->unique('operation_id')
            ->filter(function ($model_name) {
                    return ($model_name->pivot->is_offered == 1);
            })
            ->sum('amount');
        $buyer_total_invested = $important_data_deals->where('is_disputed', 'No')->where('offer_status', 'Approved')->sum('amount');

        $buyer_offer_sent = $important_data_deals->whereIn('offer_status', ['Pending', 'Counter','Approved', 'Completed'])
            /* ->pluck('operations')
            ->flatten()->unique('operation_id')
            ->filter(function ($model_name) {
                    return ($model_name->pivot->is_offered == 0);
            }) */
            ->count();
        
        $buyer_offer_won = $important_data_deals->whereIn('offer_status', ['Approved', 'Completed'])->count();

        
        $total_sold_amount = $important_data_deals->where('is_disputed', 'No')->where('offer_status', 'Approved')->pluck('operations')
            ->flatten()->unique('operation_id')
            ->filter(function ($model_name) {
                    return ($model_name->pivot->is_offered == 1);
            })
            ->sum('amount'); //total sold

        $total_cashed_amount = $important_data_deals->where('is_disputed', 'No')
            ->where('offer_status', 'Approved')
            ->filter(function ($model_name) {
                    return ($model_name->is_cashed_seller == 'Yes' || $model_name->is_qr_code_seller == 'Yes');
            })
            ->sum('amount'); // Total charged
        
        $total_deal_amount = $important_data_deals->where('is_disputed', 'No')->where('offer_status', 'Approved')->sum('amount');
                
        $total_overall_discount = ($total_sold_amount - $total_deal_amount); // Average Discount


        $current_offers = $important_data_deals
            ->whereIn('offer_status', ['Pending','Counter'])
            ->pluck('operations')
            ->flatten()->unique('operation_id')
            ->filter(function ($model_name) {
                    return ($model_name->pivot->is_offered == 0);
            })
            ->count();

        $expired_offers = $important_data_deals->where('expires_at', '<=', $current_date)
            ->whereIn('offer_status', ['Pending','Counter'])
            ->pluck('operations')
            ->flatten()->unique('operation_id')
            ->filter(function ($model_name) {
                    return ($model_name->pivot->is_offered == 0);
            })->count();

        // $offer_received = $important_data_deals->whereIn('offer_status', ['Pending', 'Counter'])->count();  // Offers Received

        $offer_received = $important_data_deals->whereIn('offer_status', ['Pending', 'Counter','Approved', 'Completed'])
           /*  ->pluck('operations')
            ->flatten()->unique('operation_id')
            ->filter(function ($model_name) {
                    return ($model_name->pivot->is_offered == 0);
            }) */
            ->count();
        
        $offer_accept = $important_data_deals->whereIn('offer_status', ['Approved', 'Completed'])->count();  // Offers Accept

        $total_avg_retention = $important_data_deals->where('offer_status', 'Approved')->avg('retention');

        $total_doc_sold_with_resources = $important_data_deals->pluck('operations')->flatten()->unique('operation_id')->where('responsibility', 'With')
        ->filter(function ($model_name) {
                    return ($model_name->pivot->is_offered == 1);
            })
        ->count();

        $total_doc_sold_without_resources = $important_data_deals->pluck('operations')->flatten()->unique('operation_id')->where('responsibility', 'Without')
        ->filter(function ($model_name) {
                    return ($model_name->pivot->is_offered == 1);
            })
        ->count();


        $total_invested_amount = $important_data_deals->where('is_disputed', 'No')->where('offer_status', 'Approved')->sum('amount');

        $total_mipo_qty = $important_data_deals->whereIn('offer_status', ['Approved', 'Completed'])->where('is_mipo_plus', 'Yes')->count();
        $total_mipo_deals_amount = $important_data_deals->whereIn('offer_status', ['Approved', 'Completed'])->where('is_mipo_plus', 'Yes')->sum('amount');

        // $total_profit_amount = $important_data_deals->where('offer_status', 'Approved')->sum('amount');

        $total_profit_amount = $important_data_deals->where('is_disputed', 'No')->where('offer_status', 'Approved')->pluck('operations')
            ->flatten()->unique('operation_id')
            ->filter(function ($model_name) {
                    return ($model_name->pivot->is_offered == 1);
            })
            ->sum('amount');

        $commissions_pending_qty = $important_data_deals->where('offer_status', 'Approved')->where('is_mipo_commission_payment', 'No')->count();

        $commissions_pending_amount = $important_data_deals->where('offer_status', 'Approved')->where('is_mipo_commission_payment', 'No')->sum('mipo_commission');

        $commissions_paid = $important_data_deals->where('offer_status', 'Approved')->where('is_mipo_commission_payment', 'Yes')->sum('mipo_commission');

        $total_save_vs_regular_ac = $important_data_deals->where('offer_status', 'Approved')->where('is_mipo_plus', 'Yes')->sum('mipo_plus_commission');

        if($req_param['preferred_dashboard'] == 'Investor') {
            $mi_coins_available = $micoins_point->where('credit', 'Yes')->where('withdraw', 'No')->sum('points');
            $mi_coins_cashed = $micoins_point->where('credit', 'No')->where('withdraw', 'Yes')->sum('points');
        }

        $best_seller = 0;
    }

@endphp
@if ($req_param['preferred_dashboard'] == 'Borrower')
    @if($req_param['user_account_type'] == 'Enterprise' && isset($enterprises_data)  &&  $enterprises_data->count() > 0)
        <div class="sub_user_row">
            <div class="row_title">
                <h3>{!! __('SUB USER Metrics') !!}</h3>
            </div>
            <div class="row five-cols">
                @forelse ($enterprises_data as $index => $enterprise_user)
                    @php
                        $total_sold = $enterprise_user->operations->flatten()->pluck('offers')->flatten()->where('offer_status', 'Approved')->sum('amount');
                        $total_cashed = $enterprise_user->operations->flatten()->pluck('offers')->flatten()->where('is_cashed_buyer', 'Yes')->sum('amount');
                        $total_disputes = $enterprise_user->operations->flatten()->pluck('offers')->flatten()->where('is_disputed', 'Yes')->sum('amount');
                    @endphp
                <div class="col-lg-4">
                    <div class="sub_user_block">
                        <div class="top_text">
                            <div class="left_box">
                                <img src="{{ $enterprise_user->profile_image_url }}" alt="no-image">
                                <div class="left_content">
                                    <p>{{  $enterprise_user->name }} {{ ($index +1)}}</p>
                                    <span>{!! __('Performance') !!}</span>
                                </div>
                            </div>
                            <div class="right_box">

                                {{ app('common')->getProfitLoss($total_sold, $total_cashed) }} {{ __('%')}}
                                <span>{{ __('Discount') }}</span>
                                {{-- <p>{{ __('Avg. Discount') }}</p> --}}
                            </div>
                        </div>
                        <div class="body_text">
                            <ul>
                                <li>
                                    <span>{{ __('Total Sold') }}</span>
                                    <span style="color: var(--m-green-text);">
                                        {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_sold) }}
                                    </span>
                                    
                                </li>
                                <li>
                                    <span>{{ __('Accepted Offers') }}</span>
                                    <span style="color: var(--m-text-red-color);">
                                        {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_cashed) }}
                                    </span>
                                    
                                </li>
                                <li>
                                    <span>{{ __('Total Discounts') }}</span>
                                    <span style="color: var(--m-text-red-color);">
                                        {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_disputes) }}
                                    </span>
                                    
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @empty
                {{ __('No record found')}}
                @endforelse
            </div>
        </div>
    @endif

    <div class="imp_data_row">
        <div class="row_title">
            <h3>{{ __('DETAILED INFORMATION') }}</h3>
        </div>
        
        <div class="row five-cols">
            <div class="col evt_target_link" data-href="{{ route('deals.index') }}" data-active="seller" role="button">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-light-grey);">{{ ($seller_document_sold) }}</span>
                    <h6>{{ __('Sold Documents') }}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col evt_target_link" data-href="{{ route('deals.index') }}" data-active="seller" role="button">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-light-grey);">{{ ($seller_document_cashed) }}</span>
                    <h6>{{ __('Cashed Documents') }}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col evt_target_link" data-href="{{ route('deals.index') }}" data-active="seller" role="button">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-light-grey);">{{ ($seller_on_going_deals) }}</span>
                    <h6>{{ __('Ongoing Operations') }}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col evt_target_link" data-href="{{ route('operations.index') }}" data-active="operations" role="button">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-light-grey);">{{ ($seller_pending_action) }}</span>
                    <h6>{{ __('Pending Actions') }}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col evt_target_link" data-href="{{ route('operations.index') }}" data-active="operations" role="button">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-light-grey);">{{ ($seller_counter_offered) }}</span>
                    <h6>{{ __('Counter Offers') }}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-green-text);">{{ $current_offers }}</span>
                    <h6>{{ __('Offers Pending Review') }}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-red-color);">{{ $expired_offers }}</span>
                    <h6>{{ __('Expired Offers') }}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col evt_target_link" data-href="{{ route('deals.index') }}" data-active="seller" role="button">
                <div class="user_data_block">
                    <p>
                        <span style="color: var(--m-green-text);font-size: 16px;font-weight: 500;">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_overall_discount) }}</span>
                    </p>
                    <h6>{{ __('Average Discount') }}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col evt_target_link" data-href="{{ route('deals.index') }}" data-active="seller" role="button">
                <div class="user_data_block">
                    <p>
                        <span style="color: var(--m-green-text);font-size: 16px;font-weight: 500;">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_cashed_amount) }}</span>
                    </p>
                    <h6>{{ __('Total Cashed') }}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col evt_target_link" data-href="{{ route('deals.index')}}" data-active="seller" role="button">
                <div class="user_data_block">
                    <p>
                        <span style="color: var(--m-text-light-grey);font-size: 16px;font-weight: 500;"> {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_sold_amount) }}</span>
                    </p>
                    <h6>{{ __('Total Sold')}}</h6>
                </div>
            </div>
            <!-- Col end -->
            {{--  <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Avg. Delay Days') }}</h6>
                    <span class="number" style="color: var(--mipo-red);">{{ round($average_rating_days ?? 0 , 2)}}%</span>
                </div>
            </div> --}}
            <!-- Col end -->
            {{-- <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Avg. Retention') }}</h6>
                    <span class="number" style="color: var(--mipo-red);">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_avg_retention) }}%</span>
                </div>
            </div> --}}
            <!-- Col end -->
        </div>

        <div class="row">
              <div class="col-lg-3 col-md-6">
                <div class="user_data_block evt_target_link" data-href="{{ route('deals.index') }}" data-active="seller" role="button">
                    <span class="number" style="color: var(--m-text-light-grey);">{{ $total_doc_sold_with_resources }}</span>
                    <h6>{{ __('Documents Sold With Resources') }}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block  evt_target_link" data-href="{{ route('deals.index') }}" data-active="seller" role="button">
                    <span class="number" style="color: var(--m-text-light-grey);">{{ $total_doc_sold_without_resources }}</span>
                    <h6>{{ __('Documents Sold Without Resources') }}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-light-grey);">{{ __($best_seller_name->best_seller ?? 'N/A') }}</span>
                    <h6>{{ __('Best Seller') }}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <span class="number mbnumdeg" style="color: var(--m-text-black); font-size: 16px; font-weight: 500;justify-content: space-between;padding: 0 7px;">
                        {{ __('Received Offers') }}: {{ $offer_received }} &nbsp;
                        <p class="number" style="color: var(--m-green-text); font-size: 16px; font-weight: 500;">{{ __('Effectiveness') }}</p>
                    </span>
                    <span class="number mbnumdeg" style="color: var(--m-green-text); font-size: 16px; font-weight: 500; justify-content: space-between;padding: 0 7px;">
                        {{ __('Accepted Offers') }}: {{ $offer_accept }}  &nbsp; &nbsp;
                        <p class="number" style="color: var(--m-green-text); font-size: 16px; font-weight: 500;">
                            @if($offer_accept > 0)
                                {{ 
                                    round((($offer_received * 100) / $offer_accept),2)
                                }}
                                {{ '%' }}
                            @else
                                0%
                            @endif
                        </p>
                    </span>
                    <h6>{{ __('Received Offers vs. Accepted Offers') }}</h6>
                </div>
            </div> 
        
            <!-- Col end -->
        
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <p>
                        <span style="color: var(--m-text-red-color);font-size: 16px;font-weight: 500;">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'],
                        //   $due_seven_days->sum('amount')
                        $due_seven_days->pluck('operations')
                            ->flatten()->unique('operation_id')
                            ->filter(function ($model_name) {
                                    return ($model_name->pivot->is_offered == 1);
                            })
                            ->pluck('amount')
                            ->sum()
                            ) }}</span>
                    </p>
                    <h6>{!! __('Due &lt; 7 Days') !!}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <p>
                        <span style="color: var(--m-text-yellow-color);font-size: 16px;font-weight: 500;">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'],
                        //  $due_fifteen_days->sum('amount')
                        $due_fifteen_days->pluck('operations')
                            ->flatten()->unique('operation_id')
                            ->filter(function ($model_name) {
                                    return ($model_name->pivot->is_offered == 1);
                            })
                            ->pluck('amount')
                            ->sum()
                        ) }}</span>
                    </p>
                    <h6>{!! __('Due &lt; 15 Days') !!}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <p>
                        <span style="color: var(--m-green-text);font-size: 16px;font-weight: 500;">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'],
                        //  $due_thirty_days->sum('amount')
                        $due_thirty_days->pluck('operations')
                            ->flatten()->unique('operation_id')
                            ->filter(function ($model_name) {
                                    return ($model_name->pivot->is_offered == 1);
                            })
                            ->pluck('amount')
                            ->sum()
                        ) }}</span>
                        {{-- <span style="color: var(--mipo-green);">Gs. 23.420.000</span> --}}
                    </p>
                    <h6>{!! __('Due &lt; 30 Days') !!}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <p>
                        <span style="color: var(--m-green-text);font-size: 16px;font-weight: 500;">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'],
                        //  $exp_thirty_days->sum('amount')
                            $exp_thirty_days->pluck('operations')
                            ->flatten()->unique('operation_id')
                            ->filter(function ($model_name) {
                                    return ($model_name->pivot->is_offered == 1);
                            })
                            ->pluck('amount')
                            ->sum()
                        ) }}</span>
                        {{-- <span style="color: var(--mipo-green);">Gs. 80.966.000</span> --}}
                    </p>
                    <h6>{!! __('Due &gt; 30 Days') !!}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-red-color);">{{ $due_seven_days->count() }}</span>
                    <h6>{!!__('Due &lt; 7 Days') !!}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-yellow-color);">{{ $due_fifteen_days->count() }}</span>
                    <h6>{!! __('Due &lt; 15 Days')  !!}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-green-text);">{{ $due_thirty_days->count() }}</span>
                    <h6>{!! __('Due &lt; 30 Days')  !!}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-green-text);">{{ $exp_thirty_days->count() }}</span>
                    <h6>{!! __('Due &gt; 30 Days')  !!}</h6>
                </div>
            </div>
        </div>
    </div>
    
    @php
        $user_type = 'buyer';
        if ($req_param['preferred_dashboard'] == 'Borrower') {
            $user_type = 'seller';
        }
    @endphp

    <div class="imp_data_row">
        <div class="main_open_wrapper">
            <div class="row">
                <div class="col-lg-6" id="line-chart">
                    <input type="hidden" name="line_chart_data" id="line_chart_data"
                    data-line-label-first="{{ __('Nominal Value') }}";
                    data-line-label-second="{{ __('Sale Value') }}";
                    data-line-chart-offer="{{ json_encode($line_chart_offers_data) }}" 
                    data-line-chart-operation="{{ json_encode($line_chart_operation_data) }}"
                    data-line-chart-lable="{{json_encode($line_chart_lable) }}" />
                    <div class="chart_table_wrap">
                        <div class="chart" id="div_line_chart_finalized_operations_borrower">
                            <img src="{{ asset('images/mipo/dashboardchartimg.png') }}" alt="no-image">
                        </div>
                        <div class="table_wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th><img src="{{ asset('images/mipo/dashboardmipoimg.svg') }}" alt="no-image"></th>
                                        <th class="text-14-semibold">{!! __('Nominal Value') !!}</th>
                                        <th class="text-14-semibold">{!! __('Sale Value') !!}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($dashboard_line_chart_table as $dashboard_line_chart_table_val)
                                        @php
                                            $preferred_currency = $dashboard_line_chart_table_val->operations->first()->preferred_currency
                                        @endphp
                                        <tr>
                                            <td class="text-14-semibold">{{ $dashboard_line_chart_table_val->operations->first()->operation_number }}</td>
                                            <td class="text-14">{{ app('common')->currencyBySymbol($preferred_currency).' '.app('common')->currencyNumberFormat($preferred_currency, $dashboard_line_chart_table_val->operations->first()->amount) }}</td>
                                            <td class="text-14">{{ app('common')->currencyBySymbol($preferred_currency).' '.app('common')->currencyNumberFormat($preferred_currency, $dashboard_line_chart_table_val->amount) }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3"></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="head_table_wrap">
                        <h6 class="text-24-medium">{!! __('OPEN DISPUTES') !!}</h6>
                        <div class="dash_table">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="text-12-medium">{!! __('OPERATION') !!}</th>
                                        <th class="text-12-medium">{!! __('AMOUNT') !!}</th>
                                        <th class="text-12-medium">{!! __('SELLER') !!}</th>
                                        <th class="text-12-medium">{!! __('EXPIRATION') !!}</th>
                                        <th class="text-12-medium">{!! __('DAYS OPEN') !!}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($open_disputes && $open_disputes->where('is_disputed', 'Yes')->count() > 0)
                                        @foreach ($open_disputes->where('is_disputed', 'Yes') as $open_dispute)
                                            <tr class="evt_deals_details"  data-deals-details-link="{{ route('deals.details', [$open_dispute->slug, $user_type]) }}"
                                                role="button" title="Click More Details">
                                                <th class="text-14-medium">{{ $open_dispute->operations->first()->operation_type_number  }}</th>
                                                <td class="text-14-medium">{{ app('common')->currencyBySymbol($req_param['currency_type']) }}{{ app('common')->currencyNumberFormat($req_param['currency_type'], $open_dispute->amount) }}</td>
                                                <td class="text-14-medium">{{ $open_dispute->operations->first()->seller->name }}</td>
                                                <td class="text-14-medium">{{ $open_dispute->offer_expire_date_iso }}</td>
                                                <td class="text-14-medium high_red">{{ $open_dispute->offer_expire_days }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">
                                                <p class="text-center font-weight-bold text-danger mt-3">
                                                    {{ __('No record found') }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mobile_open_wrap">
                        <h5 class="text-20-semibold">{!! __('OPEN DISPUTES') !!}</h5>
                        @if ($open_disputes && $open_disputes->where('is_disputed', 'Yes')->count() > 0)
                            @foreach ($open_disputes->where('is_disputed', 'Yes') as $open_dispute)
                            <div class="open_mobile_content"  data-deals-details-link="{{ route('deals.details', [$open_dispute->slug, $user_type]) }}"
                                role="button" title="Click More Details">
                                <div class="lr_section">
                                    <p class="text-16-medium">{!! __('OPERATION') !!}</p>
                                    <h6 class="text-16-medium">{{ $open_dispute->operations->first()->operation_type_number  }}</h6>
                                </div>
                                <div class="lr_section">
                                    <p class="text-16-medium">{!! __('AMOUNT') !!}</p>
                                    <h6 class="text-16-medium">{{ app('common')->currencyBySymbol($req_param['currency_type']) }}{{ app('common')->currencyNumberFormat($req_param['currency_type'], $open_dispute->amount) }}</h6>
                                </div>
                                <div class="lr_section">
                                    <p class="text-16-medium">{!! __('SELLER') !!}</p>
                                    <h6 class="text-16-medium">{{ $open_dispute->operations->first()->seller->name }}</h6>
                                </div>
                                <div class="lr_section">
                                    <p class="text-16-medium">{!! __('EXPIRATION') !!}</p>
                                    <h6 class="text-16-medium">{{ $open_dispute->offer_expire_date_iso }}</h6>
                                </div>
                                <div class="lr_section">
                                    <p class="text-16-medium">{!! __('DAYS OPEN') !!}</p>
                                    <h6 class="text-16-medium high_red">{{ $open_dispute->offer_expire_days }}</h6>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- *****************************************************************************Investor************************************************************************************************** --}}
@elseif ($req_param['preferred_dashboard'] == 'Investor')
    @if($req_param['user_account_type'] == 'Enterprise' && $investor_data->count() > 0)
        <div class="sub_user_row">
            <div class="row_title">
                <h3>{!! __('SUB USER Returns') !!}</h3>
            </div>
            <div class="row five-cols">
                @forelse ($investor_data as $index => $enterprise_investor_user)
                @php
                    $total_invested = $enterprise_investor_user->operations->flatten()->sum('amount');
                    $total_profit = $enterprise_investor_user->operations->flatten()->pluck('offers')->flatten()->where('offer_status', 'Approved')->sum('amount');
                    $total_disputes = $enterprise_investor_user->operations->flatten()->pluck('offers')->flatten()->where('is_disputed', 'Yes')->sum('amount');
                @endphp
                <div class="col-lg-4">
                    <div class="sub_user_block">
                        <div class="top_text">
                            <div class="left_box">
                                <img src="{{ $enterprise_investor_user->profile_image_url }}" alt="no-image">
                                <div class="left_content">
                                    <p>{{  $enterprise_investor_user->name }} {{ ($index +1)}}</p>
                                    <span>{{ __('Profit/Loss') }}</span>
                                </div>
                            </div>
                            <div class="right_box">
                                {{ app('common')->getProfitLoss($total_invested, $total_profit) }} {{ __('%')}}
                            </div>
                        </div>
                        <div class="body_text">
                            <ul>
                                <li>
                                    <span>{!! __('Total Bought') !!}</span>
                                    <span style="color: var(--m-text-light-grey);">
                                        {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_invested) }}
                                    </span>
                                    
                                </li>
                                <li>
                                    <span>{!! __('Profit') !!}</span>
                                    <span style="color: var(--m-green-text);">
                                        {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_profit) }}
                                    </span>
                                    
                                </li>
                                <li>
                                    <span>{!! __('Disputes') !!}</span>
                                    <span style="color: var(--m-text-red-color);">
                                        {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_disputes) }}
                                    </span>
                                    
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @empty
                {{ __('No record found')}}
                @endforelse
            </div>
        </div>
    @endif
    <div class="imp_data_row">
        <div class="row_title">
            <h3> {{ __('DETAILED INFORMATION') }} </h3>
        </div>

        <div class="row five-cols">

            <div class="col">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-light-grey);">{{ $buyer_purchased_documents }} </span>
                    <h6>{!! __('Purchased Documents') !!}</h6>
                </div>
            </div>
            <!-- Col end -->

            <div class="col">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-light-grey);"> {{ $buyer_document_cashed }}</span>
                    <h6>{!! __('Cashed Docuemnts') !!}</h6>
                </div>
            </div>
            <!-- Col end -->

            <div class="col">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-light-grey);">{{ $buyer_operations_in_process }}</span>
                    <h6>{!! __('Operations In Process') !!}</h6>
                </div>
            </div>

            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-light-grey);">{{ $buyer_pending_action }}</span>
                    <h6>{{ __('Pending Actions') }}</h6>
                </div>
            </div>
            <!-- Col end -->

            <div class="col">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-light-grey);">{{ $buyer_received_counter_offers }}</span>
                    <h6>{!! __('Received Counter Offers') !!}</h6>
                </div>
            </div>
            <!-- Col end -->

            <div class="col">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-red-color);">{{ $buyer_pending_reviews }}</span>
                    <h6>{!! __('Pending Reviews') !!}</h6>
                </div>
            </div>

            <!-- Col end -->

            <div class="col">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-red-color);">
                        {{ ($buyer_offer_sent- $buyer_offer_won) }}
                    </span>
                    <h6>{!! __('Lost Offers') !!}</h6>
                </div>
            </div>

            <!-- Col end -->

            <div class="col">
                <div class="user_data_block">
                    <p>
                        <span style="color: var(--m-green-text); font-size: 16px; font-weight: 500;">  
                            {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $buyer_total_profit) }}
                        </span>
                    </p>
                    <h6>{{ __('Total Profit') }}</h6>
                </div>
            </div>
            <!-- Col end -->

            <div class="col">
                <div class="user_data_block">
                    <p>
                        <span style="color: var(--m-green-text); font-size: 16px; font-weight: 500;"> 
                            {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $buyer_total_invested) }}
                        </span>
                    </p>
                    <h6>{{ __('Total Invested') }}</h6>
                </div>
            </div>

            <!-- Col end -->

            <div class="col">
                <div class="user_data_block">
                    <p>
                        <span style="color: var(--m-green-text); font-size: 16px; font-weight: 500;">{{ app('common')->currencyBySymbol($req_param['currency_type']) }} 
                            @if($buyer_total_profit > 1)
                            {{ round(($buyer_total_invested * 100)/ $buyer_total_profit, 2) }} %
                            @else
                            {{ round(($buyer_total_invested * 100)/ 1 , 2) }} %
                            @endif
                        </span>
                    </p>
                    <h6>{{ __('ROI') }}</h6>
                </div>
            </div>
            <!-- Col end -->
        </div>


        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-black); font-size: 16px; font-weight: 500;justify-content: space-between;padding: 0 7px;">
                        {{ __('Offers Sent') }}: {{ $buyer_offer_sent }} &nbsp;
                        <p class="number" style="color: var(--m-green-text); font-size: 16px; font-weight: 500;">{{ __('Effectiveness') }}</p>
                    </span>
                    <span class="number" style="color: var(--m-green-text); font-size: 16px; font-weight: 500; justify-content: space-between;padding: 0 7px;">
                        {{ __('Offers Won') }}: {{ $buyer_offer_won }}  &nbsp; &nbsp;
                        <p class="number" style="color: var(--m-green-text); font-size: 16px; font-weight: 500;">
                            @if($buyer_offer_won > 0)
                            {{
                                round((($buyer_offer_won * 100) / $buyer_offer_sent),2)
                            }}
                            {{ '%' }}
                            @else
                            0%
                            @endif
                        </p>
                    </span>
                    <h6>{!! __('Offers Sent vs. Offers Won') !!}</h6>
                </div>
            </div> 


            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-red-color);">{{ $commissions_pending_qty  }}</span>
                    <h6>{!! __('Pending Commissions') !!}</h6>
                </div>

            </div>

            <!-- Col end -->

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-red-color); font-size: 16px; font-weight: 500;">{{ $commissions_pending_amount  }} </span>
                    <h6>{!! __('Pending Commissions') !!}</h6>
                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-light-grey); font-size: 16px; font-weight: 500;">{{ $commissions_paid  }}</span>
                    <h6>{!! __('Paid Commissions') !!}</h6>
                </div>

            </div>

            

            <!-- Col end -->


            <!-- Col end -->
            {{-- == --}}

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-light-grey);">{{ $total_mipo_qty }}</span>
                    <div class="data-logo"><img src="{{ asset('images/mipo-plus.svg') }}" title="{{ __('mipo')}}" alt="no-image">
                    </div>
                </div>
            </div>
            <!-- Col end -->

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-light-grey);">{{ $mi_coins_available }}</span>
                    <h6>{!! __('Available MICoins') !!}</h6>
                </div>

            </div>

            <!-- Col end -->
            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-light-grey);">{{ $mi_coins_cashed }}</span>
                    <h6>{!! __('Cashed MICoins') !!}</h6>
                </div>
            </div>

            <!-- Col end -->

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">
                    <p>
                        <span style="color: var(--m-text-light-grey); font-size: 16px; font-weight: 500;">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_mipo_deals_amount) }}</span>
                        {{-- <span style="color: var(--mipo-gray);">Gs. 37.146.200</span> --}}
                    </p>
                    <div class="data-logo"><img src="{{ asset('images/mipo-plus.svg') }}" title="{{ __('mipo')}}" alt="no-image">
                    </div>
                </div>
            </div>
            <!-- Col end -->
            {{-- <div class="col-md-6">
                <div class="chart_block">
                    <img src="{{ asset('images/doc-chart.svg') }}" alt="no-image">
                </div>
            </div> --}}
            <!-- Col end -->
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-red-color);">{{ $due_seven_days->count() }}</span>
                    <h6>{!!__('Due &lt; 7 Days') !!}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-text-yellow-color);">{{ $due_fifteen_days->count() }}</span>
                    <h6>{!! __('Due &lt; 15 Days')  !!}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-green-text);">{{ $due_thirty_days->count() }}</span>
                    <h6>{!! __('Due &lt; 30 Days')  !!}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <span class="number" style="color: var(--m-green-text);">{{ $exp_thirty_days->count() }}</span>
                    <h6>{!! __('Due &gt; 30 Days')  !!}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <p>
                        <span style="color: var(--m-text-red-color);">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'],
                        //  $due_seven_days->sum('amount')) 
                            $due_seven_days->pluck('operations')
                            ->flatten()->unique('operation_id')
                            ->filter(function ($model_name) {
                                    return ($model_name->pivot->is_offered == 1);
                            })
                            ->pluck('amount')
                            ->sum()
                        )
                        }}</span>
                    </p>
                    <h6>{!! __('Due &lt; 7 Days') !!}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <p>
                        <span style="color: var(--m-text-yellow-color);">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'],
                        //  $due_fifteen_days->sum('amount')
                        $due_fifteen_days->pluck('operations')
                            ->flatten()->unique('operation_id')
                            ->filter(function ($model_name) {
                                    return ($model_name->pivot->is_offered == 1);
                            })
                            ->pluck('amount')
                            ->sum()
                        ) }}</span>
                    </p>
                    <h6>{!! __('Due &lt; 15 Days') !!}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <p>
                        <span style="color: var(--m-green-text);">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'],
                        //  $due_thirty_days->sum('amount')

                        $due_thirty_days->pluck('operations')
                            ->flatten()->unique('operation_id')
                            ->filter(function ($model_name) {
                                    return ($model_name->pivot->is_offered == 1);
                            })
                            ->pluck('amount')
                            ->sum()
                        ) }}</span>
                        {{-- <span style="color: var(--m-green-text);">Gs. 23.420.000</span> --}}
                    </p>
                    <h6>{!! __('Due &lt; 30 Days') !!}</h6>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <p>
                        <span style="color: var(--m-green-text);">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], 
                        // $exp_thirty_days->sum('amount')

                        $exp_thirty_days->pluck('operations')
                            ->flatten()->unique('operation_id')
                            ->filter(function ($model_name) {
                                    return ($model_name->pivot->is_offered == 1);
                            })
                            ->pluck('amount')
                            ->sum()
                        ) }}</span>
                        {{-- <span style="color: var(--mipo-green);">Gs. 80.966.000</span> --}}
                    </p>
                    <h6>{!! __('Due &gt; 30 Days') !!}</h6>
                </div>
            </div>
            <!-- Col end -->
            {{-- <div class="col-md-6">
                <div class="chart_block">
                    <img src="{{ asset('images/doc-chart.svg') }}" alt="no-image">
                </div>
            </div> --}}
            <!-- Col end -->
        </div>
    </div>
        
    @php
        $user_type = 'buyer';
        if ($req_param['preferred_dashboard'] == 'Borrower') {
            $user_type = 'seller';
        }
    @endphp

    <div class="imp_data_row">
        <div class="main_open_wrapper">
            <div class="row">
                <div class="col-lg-6" id="line-chart">
                    <input type="hidden" name="line_chart_data" id="line_chart_data"
                    data-line-label-first="{{ __('Nominal Value') }}";
                    data-line-label-second="{{ __('Purchase Value') }}";
                    data-line-chart-offer="{{ json_encode($line_chart_offers_data) }}" 
                    data-line-chart-operation="{{ json_encode($line_chart_operation_data) }}"
                    data-line-chart-lable="{{json_encode($line_chart_lable) }}" />
                    <div class="chart_table_wrap">
                        <div class="chart" id="div_line_chart_finalized_operations_borrower">
                            <img src="{{ asset('images/mipo/dashboardchartimg.png') }}" alt="no-image">
                        </div>
                        <div class="table_wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th><img src="{{ asset('images/mipo/dashboardmipoimg.svg') }}" alt="no-image"></th>
                                        <th class="text-14-semibold">{!! __('Nominal Value') !!}</th>
                                        <th class="text-14-semibold">{!! __('Purchase Value') !!}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($dashboard_line_chart_table as $dashboard_line_chart_table_val)
                                        @php
                                            $preferred_currency = $dashboard_line_chart_table_val->operations->first()->preferred_currency
                                        @endphp
                                        <tr>
                                            <td class="text-14-semibold">{{ $dashboard_line_chart_table_val->operations->first()->operation_number }}</td>
                                            <td class="text-14">{{ app('common')->currencyBySymbol($preferred_currency).' '.app('common')->currencyNumberFormat($preferred_currency, $dashboard_line_chart_table_val->operations->first()->amount) }}</td>
                                            <td class="text-14">{{ app('common')->currencyBySymbol($preferred_currency).' '.app('common')->currencyNumberFormat($preferred_currency, $dashboard_line_chart_table_val->amount) }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3"></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="head_table_wrap">
                        <h6 class="text-24-medium">{!! __('OPEN DISPUTES') !!}</h6>
                        <div class="dash_table">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="text-12-medium">{!! __('OPERATION') !!}</th>
                                        <th class="text-12-medium">{!! __('AMOUNT') !!}</th>
                                        <th class="text-12-medium">{!! __('SELLER') !!}</th>
                                        <th class="text-12-medium">{!! __('EXPIRATION') !!}</th>
                                        <th class="text-12-medium">{!! __('DAYS OPEN') !!}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($open_disputes && $open_disputes->where('is_disputed', 'Yes')->count() > 0)
                                        @foreach ($open_disputes->where('is_disputed', 'Yes') as $open_dispute)
                                            <tr class="evt_deals_details"  data-deals-details-link="{{ route('deals.details', [$open_dispute->slug, $user_type]) }}"
                                                role="button" title="Click More Details">
                                                <th class="text-14-medium">{{ $open_dispute->operations->first()->operation_type_number  }}</th>
                                                <td class="text-14-medium">{{ app('common')->currencyBySymbol($req_param['currency_type']) }}{{ app('common')->currencyNumberFormat($req_param['currency_type'], $open_dispute->amount) }}</td>
                                                <td class="text-14-medium">{{ $open_dispute->operations->first()->seller->name }}</td>
                                                <td class="text-14-medium">{{ $open_dispute->offer_expire_date_iso }}</td>
                                                <td class="text-14-medium high_red">{{ $open_dispute->offer_expire_days }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">
                                                <p class="text-center font-weight-bold text-danger mt-3">
                                                    {{ __('No record found') }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mobile_open_wrap">
                        <h5 class="text-20-semibold">{!! __('OPEN DISPUTES') !!}</h5>
                        @if ($open_disputes && $open_disputes->where('is_disputed', 'Yes')->count() > 0)
                            @foreach ($open_disputes->where('is_disputed', 'Yes') as $open_dispute)
                            <div class="open_mobile_content"  data-deals-details-link="{{ route('deals.details', [$open_dispute->slug, $user_type]) }}"
                                role="button" title="Click More Details">
                                <div class="lr_section">
                                    <p class="text-16-medium">{!! __('OPERATION') !!}</p>
                                    <h6 class="text-16-medium">{{ $open_dispute->operations->first()->operation_type_number  }}</h6>
                                </div>
                                <div class="lr_section">
                                    <p class="text-16-medium">{!! __('AMOUNT') !!}</p>
                                    <h6 class="text-16-medium">{{ app('common')->currencyBySymbol($req_param['currency_type']) }}{{ app('common')->currencyNumberFormat($req_param['currency_type'], $open_dispute->amount) }}</h6>
                                </div>
                                <div class="lr_section">
                                    <p class="text-16-medium">{!! __('SELLER') !!}</p>
                                    <h6 class="text-16-medium">{{ $open_dispute->operations->first()->seller->name }}</h6>
                                </div>
                                <div class="lr_section">
                                    <p class="text-16-medium">{!! __('EXPIRATION') !!}</p>
                                    <h6 class="text-16-medium">{{ $open_dispute->offer_expire_date_iso }}</h6>
                                </div>
                                <div class="lr_section">
                                    <p class="text-16-medium">{!! __('DAYS OPEN') !!}</p>
                                    <h6 class="text-16-medium high_red">{{ $open_dispute->offer_expire_days }}</h6>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
