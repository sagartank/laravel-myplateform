@php
    $current_date = date('Y-m-d 11:00:00');
    
    /*1 Incomes */

    $total_invested = $total_invested_profit = $total_invested_net_profit = $total_invested_roi = 0;

    $total_invested_profit = $investor_deals->whereIn('offer_status', ['Approved','Completed'])->where('is_disputed', 'No')->sum('amount');

    $total_invested_net_profit = $investor_deals->whereIn('offer_status', ['Approved','Completed'])->where('is_disputed', 'No')->sum('net_profit');
    
    $total_invested = $investor_deals->whereIn('offer_status', ['Approved','Completed'])->where('is_disputed', 'No')->pluck('operations')->flatten()->pluck('amount') ->sum();

    $total_profit = ($total_invested - $total_invested_profit);

    if ($total_invested > 0 && $total_invested_profit > 0) {
        $total_invested_roi = (($total_profit * 100) / $total_invested_profit);
    }
    
    /*2 Offers Sent */
    $total_offer_sent = $total_offer_sent_operation = $total_offer_sent_operation_diff = 0;
    
    $total_offer_sent_arr = [];

    $total_offer_sents = $investor_deals->whereIn('offer_status', ['Pending','Counter'])->all();

    foreach ($total_offer_sents as $parent_key => $total_offer) {
        foreach ($total_offer->operations as $child_key => $total_operations) {
            if($total_operations->pivot->is_offered == 0) {
                $total_offer_sent_arr[] =$total_offer->amount;
            }
        }
    }
    
    $total_offer_sent = array_sum($total_offer_sent_arr);

    $total_offer_sent_operation = $investor_deals->whereIn('offer_status', ['Pending', 'Counter'])
        ->pluck('operations')
        ->flatten()
        ->filter(function ($model_name) {
                return ($model_name->pivot->is_offered == 0);
        })
        ->pluck('amount')
        ->sum();

    $total_offer_sent_operation_diff = ($total_offer_sent_operation - $total_offer_sent);

    $total_offer_sent_roi = 0;
    if($total_offer_sent_operation_diff > 1) {
        $total_offer_sent_roi = (($total_offer_sent_operation_diff * 100) / $total_offer_sent_operation);
    }
   
    /* 3 Risk Managment */
    $self_risk_amount = $gauranteed_risk_amount = $mipo_plus_pr = 0;
    
    $self_risk_amount = $investor_deals->whereIn('offer_status', ['Approved','Completed'])->where('is_disputed', 'No')->where('is_mipo_plus', 'No')->sum('amount');
    
    $gauranteed_risk_amount = $investor_deals->whereIn('offer_status', ['Approved','Completed'])->where('is_disputed', 'No')->where('is_mipo_plus', 'Yes')->sum('amount');

    $total_regular_and_mipo_plus = ($self_risk_amount + $gauranteed_risk_amount);

    if($self_risk_amount > 1 && $gauranteed_risk_amount > 1) {
        $mipo_plus_pr = (($gauranteed_risk_amount * 100) / $total_regular_and_mipo_plus);
    }
@endphp
<div class="main_rev_section">
    <div class="row">
        @permission('investor_incomes')
        <div class="col-lg-4 col-md-6">
            <div class="rev_block rev_tur_first evt_click_dashboard_details" role="button" title="click for more details"
                data-href="{{ route('dashboard.investor.incomes-profit-loss', ['date_range' => $req_param['duration_date_range'], 'currency_type' => $req_param['currency_type']]) }}">
                <span class="dot" style="background-color: var(--mipo-green);"></span>
                <div class="rev_heading">
                    <i>
                        <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="Layer_1">
                                <path id="Vector" d="M26.7711 10.4492H16.9482C15.6366 10.4492 14.5732 11.5125 14.5732 12.8242C14.5732 14.1359 15.6366 15.1992 16.9482 15.1992H26.7711C28.0828 15.1992 29.1461 14.1359 29.1461 12.8242C29.1461 11.5125 28.0828 10.4492 26.7711 10.4492Z" fill="#11295A"/>
                                <path id="Vector_2" d="M11.7997 17.5664H1.89928C0.850337 17.5664 0 18.4167 0 19.4657C0 20.5146 0.850338 21.365 1.89928 21.365H11.7997C12.8486 21.365 13.699 20.5146 13.699 19.4657C13.699 18.4167 12.8486 17.5664 11.7997 17.5664Z" fill="#199CD8"/>
                                <path id="Vector_3" d="M12.6789 23.2227C13.2156 23.2227 13.6483 23.662 13.6403 24.1986C13.5571 24.1938 13.4788 24.1938 13.3956 24.1938C10.8956 24.1938 8.65971 25.3037 7.18218 27.0451L1.89611 27.0275C0.847897 27.024 0 26.1733 0 25.1251C0 24.0744 0.851753 23.2227 1.90244 23.2227H12.6789Z" fill="#199CD8"/>
                                <path id="Vector_4" d="M5.32303 32.0866C5.32303 32.2301 5.32793 32.3736 5.33282 32.5123H1.90167C0.851408 32.5123 0 31.6609 0 30.6107C0 29.5604 0.851409 28.709 1.90168 28.709H6.09605C5.60191 29.7328 5.32303 30.881 5.32303 32.0866Z" fill="#199CD8"/>
                                <path id="Vector_5" d="M7.76928 37.7458H1.89928C0.850337 37.7458 0 36.8955 0 35.8465C0 34.7976 0.850338 33.9473 1.89928 33.9473H5.54809C5.91013 35.416 6.69293 36.7268 7.76928 37.7458Z" fill="#199CD8"/>
                                <path id="Subtract" d="M33.1218 37.1536H19.5843C20.7585 35.7854 21.4679 34.0153 21.4679 32.0873C21.4679 28.2648 18.6889 25.0786 15 24.3514V16.1504H28.6597C28.6597 16.1504 43.7185 29.292 33.1218 37.1536Z" fill="#11295A"/>
                                <path id="Vector_6" d="M19.7114 32.0861C19.7114 33.2151 19.3885 34.2724 18.8259 35.167C17.7642 36.8654 15.8512 37.9992 13.6692 37.9992C13.0527 37.9992 12.4607 37.9083 11.903 37.7457C10.0292 37.1859 8.54186 35.7603 7.92541 33.9471C7.77374 33.4926 7.67589 33.0094 7.64164 32.5119C7.62696 32.3731 7.62207 32.2296 7.62207 32.0861C7.62207 30.8279 8.02325 29.6653 8.7082 28.7085C9.19745 28.0244 9.82369 27.4503 10.5576 27.0197C11.4676 26.4839 12.5292 26.1777 13.6692 26.1777H13.6985C14.3541 26.1825 14.9853 26.2878 15.5773 26.4791C17.9795 27.2589 19.7114 29.474 19.7114 32.0861Z" fill="#199CD8"/>
                                <path id="Vector_7" d="M13.3771 28.6662C12.8716 30.2991 11.5548 31.5868 9.88485 32.0811C9.65817 32.1481 9.65817 32.4519 9.88485 32.5189C11.5548 33.0132 12.8716 34.3009 13.3771 35.9338C13.4456 36.1554 13.7563 36.1554 13.8248 35.9338C14.3303 34.3009 15.6472 33.0132 17.3171 32.5189C17.5437 32.4519 17.5437 32.1481 17.3171 32.0811C15.6472 31.5868 14.3303 30.2991 13.8248 28.6662C13.7563 28.4446 13.4464 28.4446 13.3771 28.6662Z" fill="#EEF8FF"/>
                                <path id="Union" d="M32.0601 4.24201C32.065 4.18938 32.065 4.14154 32.065 4.08892L32.0601 3.8C32.0601 2.10021 31.7125 1.40403 30.9267 0.791667C30.9267 0.791667 30.7409 0.693693 30.7115 0.65542C30.1586 0.248773 29.4786 0.00478409 28.73 0.00478409C27.6194 0.00478409 26.6361 0.545386 26.0441 1.37303H26.0392C25.8484 1.57396 25.6673 1.81795 25.4961 2.10021H24.454C24.1604 1.30606 23.5489 0.65542 22.7661 0.301397C22.3453 0.110034 21.8903 0 21.3766 0C20.8629 0 20.3786 0.114818 19.948 0.320534C19.1897 0.67934 18.5928 1.32041 18.3041 2.10021H17.0419C16.5869 0.875488 15.3833 0 13.9694 0C13.2257 0 12.5359 0.243988 11.983 0.65542C11.0984 1.37303 10.6866 1.9 10.6866 3.8C10.6866 3.8 10.6914 3.85119 10.6865 3.97558V4.09996C10.6865 4.16694 10.6865 4.23392 10.6963 4.29611L12.1438 6.175L14.5173 9.5H29.1455L29.6313 8.55L32.0601 4.24201Z" fill="#11295A"/>
                            </g>
                        </svg>
                    </i>
                    <div class="head_txt">
                        <h3>{{ __('Total Investments') }}</h3>
                        <p>{{ __('Details of Investments Made') }}</p>
                    </div>
                </div>
                <div class="rev_content">
                    <div class="cont_wrap">
                        <div class="left_txt">
                            <h5>
                                {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_profit) }} / <span> {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_invested_profit ) }}</span>
                            </h5>
                            <h6><span>+0%</span>{{ __('vs. Previous period')}}</h6>
                            <p>{{ __('ROI') }} <span>{{ round($total_invested_roi, 2) }}%</span></p>
                        </div>
                        <!-- <div class="chart_box">
                            <div class="bars" id="incomes_chart">
                                <svg width="90" height="50" viewBox="0 0 90 50" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect y="22" width="18" height="28" rx="2" fill="#198754"
                                        fill-opacity="0.4" />
                                    <rect x="24" y="30" width="18" height="20" rx="2"
                                        fill="#198754" fill-opacity="0.4" />
                                    <rect x="48" y="20" width="18" height="30" rx="2"
                                        fill="#198754" fill-opacity="0.4" />
                                    <rect x="72" width="18" height="50" rx="2" fill="#198754" />
                                </svg>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div id="barchart_incomes_investor"></div>
            </div>
        </div>
        @endpermission
        <!-- Col end -->
        @permission('investor_deal')
        <div class="col-lg-4 col-md-6">
            <div class="rev_block rev_tur_second evt_click_dashboard_details" role="button" title="click for more details" data-href="{{ route('offered-operations.index') }}">
                <span class="dot" style="background-color: var(--mipo-primary-color);"></span>

                <div class="rev_heading">
                    <i>
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="Frame 48096455">
                                <g id="Group 48096165">
                                    <path id="Vector-162" d="M32.6475 17.7653L37.9416 19.3535" stroke="#199CD8" stroke-width="1.5" stroke-linecap="round"/>
                                    <path id="Vector-164" d="M8.29395 13.0003L2.99983 11.4121" stroke="#199CD8" stroke-width="1.5" stroke-linecap="round"/>
                                    <path id="Vector-163" d="M37.9414 11.9411L32.6473 13.5293" stroke="#199CD8" stroke-width="1.5" stroke-linecap="round"/>
                                    <path id="Vector-165" d="M3 18.8226L8.29412 17.2344" stroke="#199CD8" stroke-width="1.5" stroke-linecap="round"/>
                                    <path id="Vector-161" d="M28.9225 28.9993H15.046C15.0168 28.9993 14.9889 28.9872 14.9689 28.9659L10.4408 24.1474C10.4224 24.1278 10.4121 24.1018 10.4121 24.0749V16.811C10.4121 16.7525 10.4595 16.7051 10.518 16.7051H20.2731C20.3577 16.7051 20.4081 16.7993 20.3612 16.8697L18.6502 19.4362C18.4647 19.7144 18.1525 19.8815 17.8181 19.8815H15.6474C15.0951 19.8815 14.6474 20.3293 14.6474 20.8815V21.5286C14.6474 22.0809 15.0951 22.5286 15.6474 22.5286H18.7941C19.1728 22.5286 19.5191 22.7426 19.6885 23.0814L20.1945 24.0935C20.3639 24.4323 20.7102 24.6463 21.089 24.6463H22.118C22.6703 24.6463 23.118 24.1985 23.118 23.6463V22.9428C23.118 22.6776 23.0126 22.4233 22.8251 22.2357L22.2369 21.6475C21.8463 21.257 21.8463 20.6238 22.2369 20.2333L22.8251 19.645C23.0126 19.4575 23.118 19.2031 23.118 18.9379V16.811C23.118 16.7525 23.1654 16.7051 23.2239 16.7051H30.4239C30.4824 16.7051 30.5298 16.7525 30.5298 16.811V24.1006C30.5298 24.1114 30.5281 24.1221 30.5249 24.1323L29.0235 28.925C29.0097 28.9692 28.9687 28.9993 28.9225 28.9993Z" fill="#11295A"/>
                                    <rect id="Rectangle-1537" x="15" y="31" width="14" height="8" fill="#11295A"/>
                                    <path id="Rectangle-1538" d="M11.4707 5.08823C11.4707 4.21108 12.1818 3.5 13.0589 3.5C13.9361 3.5 14.6472 4.21108 14.6472 5.08824V14.588H11.4707V5.08823Z" fill="#11295A"/>
                                    <path id="Rectangle-1539" d="M16.7646 3.58824C16.7646 2.71108 17.4757 2 18.3529 2C19.23 2 19.9411 2.71108 19.9411 3.58823V14.5882H16.7646V3.58824Z" fill="#11295A"/>
                                    <path id="Rectangle-1540" d="M22.0586 5.58824C22.0586 4.71108 22.7697 4 23.6468 4C24.524 4 25.2351 4.71108 25.2351 5.58824V14.5878H22.0586V5.58824Z" fill="#11295A"/>
                                    <path id="Rectangle-1541" d="M27.3525 7.08824C27.3525 6.21108 28.0636 5.5 28.9408 5.5C29.8179 5.5 30.529 6.21108 30.529 7.08823V14.5883H27.3525V7.08824Z" fill="#11295A"/>
                                </g>
                            </g>
                        </svg>
                    </i>
                    <div class="head_txt">
                        <h3>{{ __('Sent Offers') }}</h3>
                        <p>{{ __('Current Offers Pending Acceptance') }}</p>
                    </div>
                </div>

                <div class="rev_content">
                    <div class="cont_wrap">
                        <div class="left_txt cole-text">
                            <h5>
                                {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_offer_sent) }} / <span> {{ app('common')->currencyNumberFormat($req_param['currency_type'], $total_offer_sent_operation) }} </span>
                            </h5>
                            <h6>{!! __('Est. Profit:') !!} <span>
                                {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_offer_sent_operation_diff) }} </span>
                            </h6>
                            <p>{{ __('ROI') }} <span>{{ round($total_offer_sent_roi, 2) }}%</span></p>
                        </div>
                        <!-- <div class="chart_box">
                            <div class="bars" id="deals_chart">
                                <svg width="90" height="42" viewBox="0 0 90 42" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect y="14" width="18" height="28" rx="2" fill="#0D6EFD"
                                        fill-opacity="0.4" />
                                    <rect x="24" y="22" width="18" height="20" rx="2"
                                        fill="#0D6EFD" fill-opacity="0.4" />
                                    <rect x="48" width="18" height="42" rx="2" fill="#0D6EFD"
                                        fill-opacity="0.4" />
                                    <rect x="72" y="22" width="18" height="20" rx="2"
                                        fill="#0D6EFD" />
                                </svg>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div id="barchart_deals_investor"></div>
            </div>
        </div>
        @endpermission
        <!-- Col end -->
        @permission('investor-risk-management')
        <div class="col-lg-4 col-md-6">
            <div class="rev_block rev_tur_third evt_click_dashboard_details" role="button" title="click for more details"
                data-href="{{ route('dashboard.investor.risk-managment', ['date_range' => $req_param['duration_date_range'], 'currency_type' => $req_param['currency_type']]) }}">

                <span class="dot" style="background-color: var(--mipo-red);"></span>

                <div class="rev_heading">

                    <i><img src="{{ asset('images/mipo/guaranteed.svg') }}" alt="no-image"></i>

                    <div class="head_txt">

                        <h3 data-info="Risk Managment ">{{ __('Guaranteed Repurchase') }}</h3>

                        <p>{{ __('Regular Operations vs. MIPO+') }}</p>

                    </div>

                </div>

                <div class="rev_content">
                    <div class="manage_wrap">

                        <div class="left_txt">

                            <div class="flxrow">

                                <div class="flxcol">

                                    <p>{{ __('Investments') }}</p>

                                    <h6>
                                        <span>{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $self_risk_amount) }}</span>
                                    </h6>

                                </div>

                                <div class="flxcol">

                                    <p>{{ __('MIPO+ investments') }} </p>

                                    <h6>
                                        <span>{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $gauranteed_risk_amount) }}</span>
                                    </h6>

                                </div>

                                {{-- <div class="flxcol">

                                    <p>{{ __('Investments') }} </p>

                                    <h6>
                                        <span>{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_invested) }}</span>
                                    </h6>

                                </div> --}}

                            </div>

                            <h6> {!! __('MIPO+') !!}: <span class="mi-wrap">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], round($mipo_plus_pr, 2))  }} </span></h6>

                        </div>

                        <!-- <div class="chart_box" id="gauge_chart_data" data-currency-symbol="{{app('common')->currencyBySymbol($req_param['currency_type'])}}" data-selfrisk-amount="{{$self_risk_amount}}" data-gauranteed-amount="{{$gauranteed_risk_amount}}" data-total-invested-amount="{{$total_invested}}">
                            <div class="bars" id="div_gauge_chart_risk_managment">
                                <img src="{{ asset('images/gauge-chart.svg') }}" alt="no-image">
                            </div>
                        </div> -->

                    </div>
                </div>
            </div>
        </div>
        @endpermission
        <!-- Col end -->
    </div>
</div>

{{-- mobile slider by k --}}

<div class="mobile_slider_section owl-carousel">
    <div class="rev_block evt_click_dashboard_details mobile_rev_tur_first" role="button" title="click for more details" data-href="{{ route('dashboard.investor.incomes-profit-loss', ['date_range' => $req_param['duration_date_range'], 'currency_type' => $req_param['currency_type']]) }}">
        <span class="dot" style="background-color: var(--mipo-green);"></span>
        <div class="rev_heading">
            <i>
                <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="Layer_1">
                        <path id="Vector" d="M26.7711 10.4492H16.9482C15.6366 10.4492 14.5732 11.5125 14.5732 12.8242C14.5732 14.1359 15.6366 15.1992 16.9482 15.1992H26.7711C28.0828 15.1992 29.1461 14.1359 29.1461 12.8242C29.1461 11.5125 28.0828 10.4492 26.7711 10.4492Z" fill="#11295A"/>
                        <path id="Vector_2" d="M11.7997 17.5664H1.89928C0.850337 17.5664 0 18.4167 0 19.4657C0 20.5146 0.850338 21.365 1.89928 21.365H11.7997C12.8486 21.365 13.699 20.5146 13.699 19.4657C13.699 18.4167 12.8486 17.5664 11.7997 17.5664Z" fill="#199CD8"/>
                        <path id="Vector_3" d="M12.6789 23.2227C13.2156 23.2227 13.6483 23.662 13.6403 24.1986C13.5571 24.1938 13.4788 24.1938 13.3956 24.1938C10.8956 24.1938 8.65971 25.3037 7.18218 27.0451L1.89611 27.0275C0.847897 27.024 0 26.1733 0 25.1251C0 24.0744 0.851753 23.2227 1.90244 23.2227H12.6789Z" fill="#199CD8"/>
                        <path id="Vector_4" d="M5.32303 32.0866C5.32303 32.2301 5.32793 32.3736 5.33282 32.5123H1.90167C0.851408 32.5123 0 31.6609 0 30.6107C0 29.5604 0.851409 28.709 1.90168 28.709H6.09605C5.60191 29.7328 5.32303 30.881 5.32303 32.0866Z" fill="#199CD8"/>
                        <path id="Vector_5" d="M7.76928 37.7458H1.89928C0.850337 37.7458 0 36.8955 0 35.8465C0 34.7976 0.850338 33.9473 1.89928 33.9473H5.54809C5.91013 35.416 6.69293 36.7268 7.76928 37.7458Z" fill="#199CD8"/>
                        <path id="Subtract" d="M33.1218 37.1536H19.5843C20.7585 35.7854 21.4679 34.0153 21.4679 32.0873C21.4679 28.2648 18.6889 25.0786 15 24.3514V16.1504H28.6597C28.6597 16.1504 43.7185 29.292 33.1218 37.1536Z" fill="#11295A"/>
                        <path id="Vector_6" d="M19.7114 32.0861C19.7114 33.2151 19.3885 34.2724 18.8259 35.167C17.7642 36.8654 15.8512 37.9992 13.6692 37.9992C13.0527 37.9992 12.4607 37.9083 11.903 37.7457C10.0292 37.1859 8.54186 35.7603 7.92541 33.9471C7.77374 33.4926 7.67589 33.0094 7.64164 32.5119C7.62696 32.3731 7.62207 32.2296 7.62207 32.0861C7.62207 30.8279 8.02325 29.6653 8.7082 28.7085C9.19745 28.0244 9.82369 27.4503 10.5576 27.0197C11.4676 26.4839 12.5292 26.1777 13.6692 26.1777H13.6985C14.3541 26.1825 14.9853 26.2878 15.5773 26.4791C17.9795 27.2589 19.7114 29.474 19.7114 32.0861Z" fill="#199CD8"/>
                        <path id="Vector_7" d="M13.3771 28.6662C12.8716 30.2991 11.5548 31.5868 9.88485 32.0811C9.65817 32.1481 9.65817 32.4519 9.88485 32.5189C11.5548 33.0132 12.8716 34.3009 13.3771 35.9338C13.4456 36.1554 13.7563 36.1554 13.8248 35.9338C14.3303 34.3009 15.6472 33.0132 17.3171 32.5189C17.5437 32.4519 17.5437 32.1481 17.3171 32.0811C15.6472 31.5868 14.3303 30.2991 13.8248 28.6662C13.7563 28.4446 13.4464 28.4446 13.3771 28.6662Z" fill="#EEF8FF"/>
                        <path id="Union" d="M32.0601 4.24201C32.065 4.18938 32.065 4.14154 32.065 4.08892L32.0601 3.8C32.0601 2.10021 31.7125 1.40403 30.9267 0.791667C30.9267 0.791667 30.7409 0.693693 30.7115 0.65542C30.1586 0.248773 29.4786 0.00478409 28.73 0.00478409C27.6194 0.00478409 26.6361 0.545386 26.0441 1.37303H26.0392C25.8484 1.57396 25.6673 1.81795 25.4961 2.10021H24.454C24.1604 1.30606 23.5489 0.65542 22.7661 0.301397C22.3453 0.110034 21.8903 0 21.3766 0C20.8629 0 20.3786 0.114818 19.948 0.320534C19.1897 0.67934 18.5928 1.32041 18.3041 2.10021H17.0419C16.5869 0.875488 15.3833 0 13.9694 0C13.2257 0 12.5359 0.243988 11.983 0.65542C11.0984 1.37303 10.6866 1.9 10.6866 3.8C10.6866 3.8 10.6914 3.85119 10.6865 3.97558V4.09996C10.6865 4.16694 10.6865 4.23392 10.6963 4.29611L12.1438 6.175L14.5173 9.5H29.1455L29.6313 8.55L32.0601 4.24201Z" fill="#11295A"/>
                    </g>
                </svg>
            </i>
            <div class="head_txt">
                <h3>{{ __('Total Investments') }}</h3>
                <p>{{ __('Details of Investments Made') }}</p>
            </div>
        </div>
        <div class="rev_content">
            <div class="cont_wrap">
                <div class="left_txt">
                    <h5>
                        {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_invested_profit) }} / <span> {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_invested ) }}</span>
                    </h5>
                    <h6><span>+0%</span>{{ __('vs. Previous period')}}</h6>
                    <p>{{ __('ROI') }} <span>{{ round($total_invested_roi, 2) }}%</span></p>
                </div>
            </div>
        </div>
        <div id="barchart_incomes_investor"></div>
    </div>
    <div class="rev_block evt_click_dashboard_details mobile_rev_tur_second" role="button" title="click for more details" data-href="{{ route('offered-operations.index') }}">
        <span class="dot" style="background-color: var(--mipo-primary-color);"></span>
        <div class="rev_heading">
            <i>
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="Frame 48096455">
                        <g id="Group 48096165">
                            <path id="Vector-162" d="M32.6475 17.7653L37.9416 19.3535" stroke="#199CD8" stroke-width="1.5" stroke-linecap="round"/>
                            <path id="Vector-164" d="M8.29395 13.0003L2.99983 11.4121" stroke="#199CD8" stroke-width="1.5" stroke-linecap="round"/>
                            <path id="Vector-163" d="M37.9414 11.9411L32.6473 13.5293" stroke="#199CD8" stroke-width="1.5" stroke-linecap="round"/>
                            <path id="Vector-165" d="M3 18.8226L8.29412 17.2344" stroke="#199CD8" stroke-width="1.5" stroke-linecap="round"/>
                            <path id="Vector-161" d="M28.9225 28.9993H15.046C15.0168 28.9993 14.9889 28.9872 14.9689 28.9659L10.4408 24.1474C10.4224 24.1278 10.4121 24.1018 10.4121 24.0749V16.811C10.4121 16.7525 10.4595 16.7051 10.518 16.7051H20.2731C20.3577 16.7051 20.4081 16.7993 20.3612 16.8697L18.6502 19.4362C18.4647 19.7144 18.1525 19.8815 17.8181 19.8815H15.6474C15.0951 19.8815 14.6474 20.3293 14.6474 20.8815V21.5286C14.6474 22.0809 15.0951 22.5286 15.6474 22.5286H18.7941C19.1728 22.5286 19.5191 22.7426 19.6885 23.0814L20.1945 24.0935C20.3639 24.4323 20.7102 24.6463 21.089 24.6463H22.118C22.6703 24.6463 23.118 24.1985 23.118 23.6463V22.9428C23.118 22.6776 23.0126 22.4233 22.8251 22.2357L22.2369 21.6475C21.8463 21.257 21.8463 20.6238 22.2369 20.2333L22.8251 19.645C23.0126 19.4575 23.118 19.2031 23.118 18.9379V16.811C23.118 16.7525 23.1654 16.7051 23.2239 16.7051H30.4239C30.4824 16.7051 30.5298 16.7525 30.5298 16.811V24.1006C30.5298 24.1114 30.5281 24.1221 30.5249 24.1323L29.0235 28.925C29.0097 28.9692 28.9687 28.9993 28.9225 28.9993Z" fill="#11295A"/>
                            <rect id="Rectangle-1537" x="15" y="31" width="14" height="8" fill="#11295A"/>
                            <path id="Rectangle-1538" d="M11.4707 5.08823C11.4707 4.21108 12.1818 3.5 13.0589 3.5C13.9361 3.5 14.6472 4.21108 14.6472 5.08824V14.588H11.4707V5.08823Z" fill="#11295A"/>
                            <path id="Rectangle-1539" d="M16.7646 3.58824C16.7646 2.71108 17.4757 2 18.3529 2C19.23 2 19.9411 2.71108 19.9411 3.58823V14.5882H16.7646V3.58824Z" fill="#11295A"/>
                            <path id="Rectangle-1540" d="M22.0586 5.58824C22.0586 4.71108 22.7697 4 23.6468 4C24.524 4 25.2351 4.71108 25.2351 5.58824V14.5878H22.0586V5.58824Z" fill="#11295A"/>
                            <path id="Rectangle-1541" d="M27.3525 7.08824C27.3525 6.21108 28.0636 5.5 28.9408 5.5C29.8179 5.5 30.529 6.21108 30.529 7.08823V14.5883H27.3525V7.08824Z" fill="#11295A"/>
                        </g>
                    </g>
                </svg>
            </i>
            <div class="head_txt">
                <h3>{{ __('Sent Offers') }}</h3>
                <p>{{ __('Current Offers Pending Acceptance') }}</p>
            </div>
        </div>
        <div class="rev_content">
            <div class="cont_wrap">
                <div class="left_txt cole-text">
                    <h5>
                        {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_offer_sent) }} / <span> {{ app('common')->currencyNumberFormat($req_param['currency_type'], $total_offer_sent_operation) }} </span>
                    </h5>
                    <h6>{!! __('Est. Profit:') !!} <span>
                        {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_offer_sent_operation_diff) }} </span>
                    </h6>
                    <p>{{ __('ROI') }} <span>{{ round($total_offer_sent_roi, 2) }}%</span></p>
                </div>
            </div>
        </div>
        <div id="barchart_deals_investor"></div>
    </div>
    <div class="rev_block evt_click_dashboard_details mobile_rev_tur_third" role="button" title="click for more details" data-href="{{ route('dashboard.investor.risk-managment', ['date_range' => $req_param['duration_date_range'], 'currency_type' => $req_param['currency_type']]) }}">
        <span class="dot" style="background-color: var(--mipo-red);"></span>
        <div class="rev_heading">
            <i><img src="{{ asset('images/mipo/guaranteed.svg') }}" alt="no-image"></i>
            <div class="head_txt">
                <h3 data-info="Risk Managment ">{{ __('Guaranteed Repurchase') }}</h3>
                <p>{{ __('Regular Operations vs. MIPO+') }}</p>
            </div>
        </div>
        <div class="rev_content">
            <div class="manage_wrap">
                <div class="left_txt">
                    <div class="flxrow">
                        <div class="flxcol">
                            <p>{{ __('Investments') }}</p>
                            <h6><span>{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $self_risk_amount) }}</span></h6>
                        </div>
                        <div class="flxcol">
                            <p>{{ __('MIPO+ investments') }} </p>
                            <h6><span>{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $gauranteed_risk_amount) }}</span></h6>
                        </div>
                    </div>
                    <h6> {!! __('MIPO+') !!} <span class="mi-wrap"> {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], round($mipo_plus_pr, 2))  }} </span></h6>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- mobile slider by k --}}