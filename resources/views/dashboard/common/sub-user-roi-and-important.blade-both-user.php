@php
    $me_document_sold =  $me_document_cashed = $me_on_going_deals = $me_pending_action = $me_counter_offered = $me_documents_purchased = 0;
    $total_sold_amount = $total_cashed_amount = $total_overall_discount = 0;
    $total_doc_sold_with_resources = $total_doc_sold_without_resources = 0;

    $total_invested_amount = $total_profit_amount = 0;

    $total_mipo_deals = 0;
    $total_mipo_deals_amount = 0;

    if(isset($update_deals_me)) {
        $me_document_sold = $update_deals_me->where('offer_status', 'Approved')->count();
        $me_document_cashed = $update_deals_me->where('is_cashed_buyer', 'Yes')->count();
        $me_on_going_deals = $update_deals_me->where('offer_status', '!=', 'Completed')->count();
        $me_pending_action = $update_deals_me->where('offer_status', 'Pending')->count();
        $me_counter_offered = $update_deals_me->where('offer_status', 'Counter')->count();
        $me_documents_purchased = $update_deals_me->where('offer_status', 'Completed')->count();

        $total_sold_amount += $update_deals_me->where('offer_status', 'Approved')->sum('amount');
        $total_cashed_amount += $update_deals_me->where('is_cashed_buyer', 'Yes')->sum('amount');
        $total_overall_discount += 0;

        $total_doc_sold_with_resources += $update_deals_me->pluck('operations')->flatten()->where('responsibility', 'With')->count();
        $total_doc_sold_without_resources += $update_deals_me->pluck('operations')->flatten()->where('responsibility', 'Without')->count();

        $total_invested_amount += $update_deals_me->pluck('operations')->flatten()->sum('amount');

        $total_mipo_deals = $update_deals_me->where('is_mipo_plus', 'Yes')->count();
        $total_mipo_deals_amount = $update_deals_me->where('is_mipo_plus', 'Yes')->sum('amount');
    }

@endphp
@if ($req_param['preferred_dashboard'] == 'Borrower')
    @if($req_param['user_account_type'] == 'Enterprise' && isset($enterprises_data)  &&  $enterprises_data->count() > 0)
        <div class="sub_user_row">
            <div class="row_title">
                <h3>{{ __('Sub User ROI') }}</h3>
            </div>
            <div class="row five-cols">
                @forelse ($enterprises_data as $index => $enterprise_user)
                @php
                    $total_sold = $enterprise_user->operations->flatten()->pluck('offers')->flatten()->where('offer_status', 'Approved')->sum('amount');
                    $total_cashed = $enterprise_user->operations->flatten()->pluck('offers')->flatten()->where('is_cashed_buyer', 'Yes')->sum('amount');
                    $total_disputes = $enterprise_user->operations->flatten()->pluck('offers')->flatten()->where('is_disputed', 'Yes')->sum('amount');

                    $total_sold_amount += $total_sold;
                    $total_cashed_amount += $total_cashed;

                    $total_doc_sold_with_resources += $enterprise_user->operations->flatten()->where('responsibility', 'With')->count();
                    $total_doc_sold_without_resources += $enterprise_user->operations->flatten()->where('responsibility', 'Without')->count();

                @endphp
                <div class="col">
                    <div class="sub_user_block">
                        <div class="top_text">
                            <div class="left_box">
                                <p>{{  $enterprise_user->name }} {{ ($index +1)}}</p>
                                <span>{{ __('Profit/Loss') }}</span>
                            </div>
                            <div class="right_box">17.2%
                                {{-- <p>{{ __('Avg. Discount') }}</p> --}}
                            </div>
                        </div>
                        <div class="body_text">
                            <ul>
                                <li>
                                    <span style="color: var(--mipo-gray);">
                                        {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_sold) }}
                                    </span>
                                    <span>{{ __('Total Sold') }}</span>
                                </li>
                                <li>
                                    <span style="color: var(--mipo-green);">
                                        {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_cashed) }}
                                    </span>
                                    <span>{{ __('Total Cashed') }}</span>
                                </li>
                                <li>
                                    <span style="color: var(--mipo-red);">
                                        {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_disputes) }}
                                    </span>
                                    <span>{{ __('Disputes') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @empty
                {{ __(' No Record Found.')}}
                @endforelse
            </div>
        </div>
    @endif

    <div class="imp_data_row">
        <div class="row_title">
            <h3>{{ __('Important Data') }}</h3>
            @php
                $document_sold = $document_cashed = $on_going_deals = $pending_action = $counter_offered = 0;
                
                if(isset($enterprises_data) && $enterprises_data->count() > 0) {
/*                     $document_sold = $enterprises_data->operations->flatten()->pluck('offers')->flatten()->where('offer_status', 'Approved')->count();
                    $document_cashed = $enterprises_data->operations->flatten()->pluck('offers')->flatten()->where('is_cashed_buyer', 'Yes')->count();
                    $on_going_deals = $enterprises_data->operations->flatten()->pluck('offers')->flatten()->where('offer_status', '!=', 'Completed')->count();
                    $pending_action = $enterprises_data->operations->flatten()->pluck('offers')->flatten()->where('offer_status', 'Pending')->count();
                    $counter_offered = $enterprises_data->operations->flatten()->pluck('offers')->flatten()->where('offer_status', 'Counter')->count(); */
                }
            @endphp
        </div>
        <div class="row five-cols">
            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Documents Sold') }}</h6>
                    <span class="number" style="color: var(--mipo-gray);">{{ ($document_sold  + $me_document_sold) }}</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Documents Cashed') }}</h6>
                    <span class="number" style="color: var(--mipo-gray);">{{ ($document_cashed + $me_document_cashed) }}</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('On-Going Deals') }}</h6>
                    <span class="number" style="color: var(--mipo-gray);">{{ ($on_going_deals + $me_on_going_deals) }}</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Pending Actions') }}</h6>
                    <span class="number" style="color: var(--mipo-gray);">{{ ($pending_action + $me_pending_action) }}</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Counter Offered') }}</h6>
                    <span class="number" style="color: var(--mipo-gray);">{{ ($counter_offered + $counter_offered) }}</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Total Sold')}}</h6>
                    <p>
                        <span style="color: var(--mipo-green);"> {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_sold_amount) }}</span>
                    </p>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Total Cashed') }}</h6>
                    <p>
                        <span style="color: var(--mipo-green);">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_cashed_amount) }}</span>
                    </p>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Overall Discount') }}</h6>
                    <p>
                        <span style="color: var(--mipo-green);">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_overall_discount) }}</span>
                    </p>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Pending Actions') }}</h6>
                    <span class="number" style="color: var(--mipo-red);">0</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Rejected Offers') }}</h6>
                    <span class="number" style="color: var(--mipo-red);">0</span>
                </div>
            </div>
            <!-- Col end -->
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>{{ __('Document Sold With Resources') }}</h6>
                    <span class="number" style="color: var(--mipo-gray);">{{ $total_doc_sold_with_resources }}</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>{{ __('Document Sold Without Resources') }}</h6>
                    <span class="number" style="color: var(--mipo-gray);">{{ $total_doc_sold_without_resources }}</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Best Seller</h6>
                    <span class="number" style="color: var(--mipo-gray);">Biggie S.A.</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Sales Success Rate</h6>
                    <span class="number" style="color: var(--mipo-green);">85%</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Document Due &lt; 7 Days</h6>
                    <p>
                        <span style="color: var(--mipo-red);">{{ app('common')->currencyBySymbol($req_param['currency_type']) }} 1.322</span>
                    </p>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Document Due &lt; 15 Days</h6>
                    <p>
                        <span style="color: var(--mipo-orange);">{{ app('common')->currencyBySymbol($req_param['currency_type']) }} 0</span>
                    </p>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Document Due &lt; 30 Days</h6>
                    <p>
                        <span style="color: var(--mipo-green);">{{ app('common')->currencyBySymbol($req_param['currency_type']) }} 0</span>
                        {{-- <span style="color: var(--mipo-green);">Gs. 23.420.000</span> --}}
                    </p>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Document Due &lt; 30 Days</h6>
                    <p>
                        <span style="color: var(--mipo-green);">{{ app('common')->currencyBySymbol($req_param['currency_type']) }} 0</span>
                        {{-- <span style="color: var(--mipo-green);">Gs. 80.966.000</span> --}}
                    </p>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Document Due &lt; 7 Days</h6>
                    <span class="number" style="color: var(--mipo-red);">3</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Document Due &lt; 15 Days</h6>
                    <span class="number" style="color: var(--mipo-orange);">15</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Document Due &lt; 30 Days</h6>
                    <span class="number" style="color: var(--mipo-green);">6</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Document Due &lt; 30 Days</h6>
                    <span class="number" style="color: var(--mipo-green);">4</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-md-6">
                <div class="chart_block">
                    <img src="{{ asset('images/doc-chart.svg') }}" alt="no-image">
                </div>
            </div>
            <!-- Col end -->
        </div>
    </div>
@elseif ($req_param['preferred_dashboard'] == 'Investor')
    @if($req_param['user_account_type'] == 'Enterprise' && $investor_data->count() > 0)
        <div class="sub_user_row">
                <div class="row_title">
                    <h3>{{ __('Sub User ROI')}}</h3>
                </div>
                <div class="row five-cols">
                    @forelse ($investor_data as $index => $enterprise_investor_user)
                    @php
                        $total_invested = $enterprise_investor_user->operations->flatten()->sum('amount');
                        $total_profit = $enterprise_investor_user->operations->flatten()->pluck('offers')->flatten()->where('offer_status', 'Approved')->sum('amount');
                        $total_disputes = $enterprise_investor_user->operations->flatten()->pluck('offers')->flatten()->where('is_disputed', 'Yes')->sum('amount');

                        $total_invested_amount += $total_invested;
                        $total_profit_amount += $total_profit;
                    @endphp
                    <div class="col">
                        <div class="sub_user_block">
                            <div class="top_text">
                                <div class="left_box">
                                    <p>{{  $enterprise_investor_user->name }} {{ ($index +1)}}</p>
                                    <span>{{ __('Profit/Loss') }}</span>
                                </div>
                                <div class="right_box">17.2%
                                    {{-- <p>{{ __('Avg. Discount') }}</p> --}}
                                </div>
                            </div>
                            <div class="body_text">
                                <ul>
                                    <li>
                                        <span style="color: var(--mipo-gray);">
                                            {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_invested) }}
                                        </span>
                                        <span>{{ __('Total Invested') }}</span>
                                    </li>
                                    <li>
                                        <span style="color: var(--mipo-green);">
                                            {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_profit) }}
                                        </span>
                                        <span>{{ __('Total Profit') }}</span>
                                    </li>
                                    <li>
                                        <span style="color: var(--mipo-red);">
                                            {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_disputes) }}
                                        </span>
                                        <span>{{ __('Disputes') }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @empty
                    {{ __(' No Record Found.')}}
                    @endforelse
                </div>
            </div>
        @endif
    
    <div class="imp_data_row">
        <div class="row_title">
            <h3>{{ __('Important Data') }} </h3>
        </div>
        <div class="row five-cols">

            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Documents Purchased') }}</h6>
                    <span class="number" style="color: var(--mipo-gray);">{{ $me_documents_purchased }} </span>
                </div>
            </div>
            <!-- Col end -->

            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Documents Cashed') }}</h6>
                    <span class="number" style="color: var(--mipo-gray);"> {{ $me_document_cashed }}</span>
                </div>
            </div>
            <!-- Col end -->

            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('On-Going Deals') }}</h6>
                    <span class="number" style="color: var(--mipo-gray);">{{ $me_on_going_deals }}</span>
                </div>
            </div>

            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Pending Actions') }}</h6>
                    <span class="number" style="color: var(--mipo-gray);">{{ $me_pending_action }}</span>
                </div>
            </div>
            <!-- Col end -->

            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Outmatched Offers') }}</h6>
                    <span class="number" style="color: var(--mipo-gray);">23</span>
                </div>
            </div>
            <!-- Col end -->

            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Total Profits') }}</h6>
                    <span style="color: var(--mipo-green);">  {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_profit_amount) }}</span>
                    {{-- <span style="color: var(--mipo-green);">Gs. 37.146.200</span> --}}
                    </p>
                </div>
            </div>
            <!-- Col end -->

            <div class="col">

                <div class="user_data_block">
                    <h6>{{ __('Total Invested') }}</h6>
                    <p>
                        <span style="color: var(--mipo-green);">  {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_invested_amount) }}</span>
                        {{-- <span style="color: var(--mipo-green);">Gs. 37.146.200</span> --}}
                    </p>
                </div>
            </div>

            <!-- Col end -->

            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Overall ROI') }}</h6>
                    <p>
                        <span style="color: var(--mipo-green);">{{ app('common')->currencyBySymbol($req_param['currency_type']) }} 0</span>
                        {{-- <span style="color: var(--mipo-green);">Gs. 37.146.200</span> --}}
                    </p>
                </div>
            </div>
            <!-- Col end -->

            <div class="col">

                <div class="user_data_block">

                    <h6>Pending Actions</h6>

                    <span class="number" style="color: var(--mipo-red);">0</span>

                </div>

            </div>

            <!-- Col end -->

            <div class="col">

                <div class="user_data_block">

                    <h6>Unclosed Deals</h6>

                    <span class="number" style="color: var(--mipo-red);">0</span>

                </div>

            </div>

            <!-- Col end -->

        </div>


        <div class="row">
            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6>Commissions Pending</h6>

                    <span class="number" style="color: var(--mipo-gray);">1.335.000 MI</span>

                </div>

            </div>

            <!-- Col end -->

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6>Commissions Pending</h6>

                    <span class="number" style="color: var(--mipo-gray);">0 MI</span>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6> Commission Paid</h6>

                    <span class="number" style="color: var(--mipo-gray);">0 MI</span>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6>Total Saved Vs Regular Ac.</h6>

                    <span class="number" style="color: var(--mipo-gray);">0 MI</span>

                </div>

            </div>

            <!-- Col end -->


            <!-- Col end -->
            {{-- == --}}
            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6>MICoins Available</h6>

                    <span class="number" style="color: var(--mipo-gray);">1.335.000 MI</span>

                </div>

            </div>

            <!-- Col end -->
            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6>MICoins Cashed</h6>

                    <span class="number" style="color: var(--mipo-gray);">0 MI</span>

                </div>
            </div>

            <!-- Col end -->

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">
                    <div class="data-logo"><img src="{{ asset('images/mipo-plus.svg') }}" title="{{ __('mipo')}}" alt="no-image">
                    </div>
                    <span class="number" style="color: var(--mipo-gray);">{{ $total_mipo_deals }}</span>
                </div>
            </div>
            <!-- Col end -->

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <div class="data-logo"><img src="{{ asset('images/mipo-plus.svg') }}" title="{{ __('mipo')}}" alt="no-image">
                    </div>
                    <p>
                        <span style="color: var(--mipo-gray);">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_mipo_deals_amount) }}</span>
                        {{-- <span style="color: var(--mipo-gray);">Gs. 37.146.200</span> --}}
                    </p>

                </div>

            </div>

            <!-- Col end -->
            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6>Document Due < 7 Days</h6>
                        <span class="number" style="color: var(--mipo-red);">3</span>
                </div>

            </div>

            <!-- Col end -->
            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6>Document Due < 15 Days</h6>
                        <span class="number" style="color: var(--mipo-orange);">15</span>
                </div>

            </div>

            <!-- Col end -->
            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6>Document Due < 30 Days</h6>
                        <span class="number" style="color: var(--mipo-green);">6</span>
                </div>

            </div>
            <!-- Col end -->

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6>Document Due < 30 Days</h6>
                        <span class="number" style="color: var(--mipo-green);">4</span>
                </div>
            </div>
            <!-- Col end -->

            <div class="col-md-6">
                <div class="chart_block">
                    <img src="{{ asset('images/doc-chart.svg') }}" alt="no-image">
                </div>
            </div>
            <!-- Col end -->
        </div>
    </div>
@endif
