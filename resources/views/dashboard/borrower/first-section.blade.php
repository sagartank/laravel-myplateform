@php
    $current_date = date('Y-m-d 11:00:00');

    /* Finalized deals */
    $total_finalized_deals = 0;

    $total_finalized_deals = $borrower_deals->whereIn('offer_status', ['Approved','Completed'])->where('is_disputed', 'No')->pluck('operations')->flatten()->pluck('amount')->sum();
    
    /*deals in progress*/
    $total_deals_etd_income = $total_deals_diff_pr = 0 ;
    
    $total_deals_in_progress_operations = $total_deals_in_progress_operations_offer = 0;

    $total_deals_in_progress_operations = $borrower_deals
        ->whereIn('offer_status', ['Pending','Counter'])
        ->pluck('operations')
        ->flatten()->unique('operation_id')
        ->filter(function ($model_name) {
                return ($model_name->pivot->is_offered == 0);
        })
        ->pluck('amount')
        ->sum();

        $total_deals_in_progress_operations_offer = 0;
        $total_deals_in_progress_operations_offer_arr = [];
        $total_offers_send = $borrower_deals->whereIn('offer_status', ['Pending','Counter'])->all();
        foreach ($total_offers_send as $parent_key => $total_offer) {
            foreach ($total_offer->operations as $child_key => $total_operations) {
                if($total_operations->pivot->is_offered == 0) {
                    $total_deals_in_progress_operations_offer_arr[$total_operations->pivot->operation_id] = $total_offer->amount;
                    // $total_deals_in_progress_operations_offer_arr[] =$total_offer->amount;
                }
            }
        }
    
    $total_deals_in_progress_operations_offer = array_sum($total_deals_in_progress_operations_offer_arr);
    
    $total_deals_diff = ($total_deals_in_progress_operations - $total_deals_in_progress_operations_offer);

    if($total_deals_in_progress_operations > 0 ) {
        $total_deals_diff_pr = (($total_deals_diff * 100) / $total_deals_in_progress_operations);
    }

    /* finalized operations */
    $total_finalized_doc_sold = $total_finalized_doc_accepted = 0;
    
    $total_finalized_doc_sold = $borrower_deals
        ->whereIn('offer_status', ['Approved','Completed'])
        ->where('is_disputed', 'No')
        ->pluck('operations')
        ->flatten()
        ->pluck('amount')
        ->sum();
    
    $total_finalized_doc_accepted = $borrower_deals
        ->whereIn('offer_status', ['Approved','Completed'])
        ->where('is_disputed', 'No')
        ->pluck('amount')
        ->sum();
    
    $total_finalized_doc_sold_discount =  $total_finalized_doc_sold_discount_pr = 0;

    $total_finalized_doc_sold_discount = ($total_finalized_doc_sold - $total_finalized_doc_accepted); 

    if($total_finalized_doc_sold_discount > 0 ) {
        $total_finalized_doc_sold_discount_pr = (($total_finalized_doc_sold_discount * 100) / $total_finalized_doc_sold);
    }
    /*currenct date range*/
        $current_offer_accepted = $total_finalized_doc_accepted;
    /*last month*/
    $dashboard_deals_last_month_accepted = $dashboard_deals_last_month
        ->whereIn('offer_status', ['Approved','Completed'])
        ->where('is_disputed', 'No')
        ->pluck('amount')
        ->sum();
    
    $last_month_pr = 0;
    if($dashboard_deals_last_month_accepted > 0 && $current_offer_accepted) {
        $last_month_pr = (($current_offer_accepted - $dashboard_deals_last_month_accepted) / 100);
    }
@endphp
<div class="main_rev_section">
    <div class="row">
        @permission('borrower-finalized-deals')
        <div class="col-lg-4 col-md-6">
            <div class="rev_block bor_tur_first evt_click_dashboard_details" role="button" title="click for more details"
                data-href="{{ route('dashboard.borrower.finalized-deals', ['date_range' => $req_param['duration_date_range'], 'currency_type' => $req_param['currency_type']]) }}">
                <span class="dot" style="background-color: var(--mipo-green);"></span>
                <div class="rev_heading">
                    <i>
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="layer 1">
                                <g id="Group 48096166">
                                    <path id="Vector-11" d="M1 2V32.4118C1 32.964 1.44772 33.4118 2 33.4118H2.23529C2.78758 33.4118 3.23529 32.964 3.23529 32.4118V12.5907C3.23529 12.3255 3.34065 12.0711 3.52819 11.8836L11.8836 3.52819C12.0711 3.34065 12.3255 3.23529 12.5907 3.23529H24.5882C25.1405 3.23529 25.5882 2.78758 25.5882 2.23529V2C25.5882 1.44772 25.1405 1 24.5882 1H2C1.44772 1 1 1.44772 1 2Z" fill="#11295A"/>
                                    <path id="Vector-12" d="M7.70605 12.1757L12.1766 7.70508V12.1757H7.70605Z" fill="#11295A"/>
                                    <path id="Vector-13" d="M39.0001 30.0547C39.0001 31.5492 38.5822 32.9486 37.8539 34.1327C36.4798 36.3807 34.0039 37.8814 31.1797 37.8814C30.3819 37.8814 29.6156 37.7611 28.8938 37.5458C26.4685 36.8049 24.5435 34.9179 23.7456 32.518C23.5493 31.9164 23.4227 31.2769 23.3784 30.6183C23.3594 30.4347 23.353 30.2447 23.353 30.0547C23.353 28.3893 23.8723 26.8506 24.7588 25.5841C25.392 24.6786 26.2026 23.9188 27.1524 23.3489C28.3302 22.6396 29.7043 22.2344 31.1797 22.2344H31.2177C32.0662 22.2407 32.8831 22.38 33.6493 22.6333C36.7585 23.6655 39.0001 26.5973 39.0001 30.0547Z" fill="#199CD8"/>
                                    <path id="Vector-14" d="M26.7061 30.0595L29.3139 32.2948L34.5296 27.8242" stroke="#EEF8FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <g>
                                        <path id="Vector-15" d="M28.9413 7.58789C28.9413 7.03561 28.4936 6.58789 27.9413 6.58789H15.4119C14.8596 6.58789 14.4119 7.03561 14.4119 7.58789V13.4114C14.4119 13.9637 13.9642 14.4114 13.4119 14.4114H7.58838C7.03609 14.4114 6.58838 14.8591 6.58838 15.4114V37.9997C6.58838 38.5519 7.03609 38.9997 7.58838 38.9997H23.3531L20.0001 34.5291H8.82367V32.2938H20.0001V28.9408H8.82367V26.7055H18.8825V24.4702H8.82367V22.2349H22.7943C23.1668 21.4899 25.5884 18.882 28.9413 18.882V7.58789Z" fill="#11295A"/>
                                        <path id="Vector-16" d="M23.3497 38.998H16.6464C15.4123 38.998 14.4119 37.9976 14.4119 36.7635C14.4119 35.5295 15.4123 34.5291 16.6464 34.5291H20.7944C21.2109 36.257 22.1115 37.7991 23.3497 38.998Z" fill="#11295A"/>
                                        <path id="Vector-17" d="M8.82367 28.9408H20.0001V32.2938H8.82367V28.9408Z" fill="#11295A"/>
                                        <path id="Vector-18" d="M8.82367 23.3526H22.2354C20.8943 24.2467 20.559 25.5879 20.0001 26.7055H8.82367V23.3526Z" fill="#11295A"/>
                                        <path id="Vector-19" d="M8.82367 18.882H28.9413C26.706 19.4408 23.617 21.4899 23.3531 22.2349H8.82367V18.882Z" fill="#11295A"/>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </i>
                    <div class="head_txt">
                        <h3>{!! __('Sold Documents') !!}</h3>
                        <p>{!! __('Status of Closed Deals') !!}</p>
                    </div>
                </div>
                <div class="rev_content">
                    <div class="cont_wrap">
                        <div class="left_txt">
                            <h5> {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_finalized_deals) }}</h5>
                            <h6><span>{{ round($last_month_pr, 2) }}%</span> {{ __('Previous period') }}</h6>
                            {{-- <h6><span>{{ round($last_month_pr, 2) }}%</span> {{ __('from last month') }}</h6> --}}
                        </div>
                        {{-- <div class="chart_box">
                            <div class="bars">
                                <svg width="90" height="50" viewBox="0 0 90 50" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect y="22" width="18" height="28" rx="2" fill="#198754"
                                        fill-opacity="0.4" />
                                    <rect x="24" y="30" width="18" height="20" rx="2"
                                        fill="#198754" fill-opacity="0.4" />
                                    <rect x="48" y="20" width="18"$ height="30" rx="2"
                                        fill="#198754" fill-opacity="0.4" />
                                    <rect x="72" width="18" height="50" rx="2" fill="#198754" />
                                </svg>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div id="barchart_finalized_deals_borrow"></div>
            </div>
        </div>
        @endpermission
        <!-- Col end -->
        @permission('borrower-deals')
        <div class="col-lg-4 col-md-6">
            <div class="rev_block bor_tur_second evt_click_dashboard_details" role="button" title="click for more details"
                data-href="{{ route('operations.index') }}">
                <span class="dot" style="background-color: var(--mipo-primary-color);"></span>
                <div class="rev_heading">
                    <i>
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="Layer_1" clip-path="url(#clip0_1983_74624)">
                                <path id="Vector-157" d="M31.7754 36.01L28.3096 23.2882C28.1343 22.6445 27.3892 22.3506 26.8194 22.6977C22.1938 25.5161 18.5703 27.497 13.1671 28.6405C12.4402 28.7943 12.1979 29.5729 12.8739 29.8812C15.3144 30.9943 19.9468 31.2663 21.9453 31.5799C22.4816 31.6641 22.5635 32.1489 22.0775 32.391C19.7227 33.5641 14.5581 33.5028 11.5776 32.9939C3.90406 30.8586 1.49362 30.349 0.559652 30.9545C-0.000579834 31.3177 0.252298 32.1537 0.6978 32.6509C9.88137 42.9019 23.5122 40.4111 31.2171 37.1747C31.6708 36.9841 31.9047 36.4847 31.7754 36.01Z" fill="#11295A"/>
                                <path id="Vector-156" d="M40 37.1658V19C40 18.4477 39.5539 18 39.0016 18H31.4995C30.9472 18 30.4991 18.4484 30.5092 19.0006C30.6509 26.7159 32.4066 33.5138 34.2362 37.5969C34.3935 37.9478 34.7446 38.1658 35.1292 38.1658H39C39.5523 38.1658 40 37.7181 40 37.1658Z" fill="#11295A"/>
                                <path id="Rectangle-1534" d="M28 1.77778C28 0.795939 27.2041 0 26.2222 0H1.77778C0.79594 0 0 0.795938 0 1.77778V16.2222C0 17.2041 0.795938 18 1.77778 18H26.2222C27.2041 18 28 17.2041 28 16.2222V1.77778Z" fill="#199CD8"/>
                                <rect id="Rectangle-1536" width="1.92192" height="1.92192" rx="0.960961" transform="matrix(-1 0 0 1 23 8)" fill="#EEF8FF"/>
                                <rect id="Rectangle-1535" width="1.92192" height="1.92192" rx="0.960961" transform="matrix(-1 0 0 1 7 8)" fill="#EEF8FF"/>
                                <g id="Group 48096164">
                                    <circle id="Ellipse-95" cx="5" cy="5" r="5" transform="matrix(-1 0 0 1 19 4)" fill="#EEF8FF"/>
                                    <path id="Vector-158" d="M14.1728 6.13124C14.5631 7.42037 15.5796 8.43695 16.8688 8.82721C17.0437 8.88009 17.0437 9.11991 16.8688 9.17279C15.5796 9.56305 14.5631 10.5796 14.1728 11.8688C14.1199 12.0437 13.8801 12.0437 13.8272 11.8688C13.437 10.5796 12.4204 9.56305 11.1312 9.17279C10.9563 9.11991 10.9563 8.88009 11.1312 8.82721C12.4204 8.43695 13.437 7.42037 13.8272 6.13124C13.8801 5.95625 14.1193 5.95625 14.1728 6.13124Z" fill="#199CD8"/>
                                </g>
                            </g>
                            <defs>
                                <clipPath id="clip0_1983_74624">
                                    <rect width="40" height="40" fill="white" transform="matrix(-1 0 0 1 40 0)"/>
                                </clipPath>
                            </defs>
                        </svg>
                    </i>
                    <div class="head_txt">
                        <h3>{!! __('Received Offers') !!}</h3>
                        <p>{!! __('Received Offers and In-Process') !!}</p>
                    </div>
                </div>
                <div class="rev_content">
                    <div class="cont_wrap">
                        <div class="left_txt">
                            <div class="green-name">
                                <h5>
                                    {!!
                                        app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_deals_in_progress_operations_offer) .' / <span>'. 
                                        app('common')->currencyNumberFormat($req_param['currency_type'], $total_deals_in_progress_operations).'</span>' 
                                    !!}
                                </h5>
                                <h6>{{ __('Discount') }}: <span>{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_deals_diff) }}</span></h6>
                                <h6>{{ __('% Discount') }}: <span style="color: var(--m-text-red-color)">{{ app('common')->currencyNumberFormat($req_param['currency_type'], floor($total_deals_diff_pr)) }}% </span> </h6>
                            </div>
                        </div>
                        {{-- <div class="chart_box">
                            <div class="bars">
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
                        </div> --}}
                    </div>
                </div>
                <div id="barchart_deals_borrow"></div>
            </div>
        </div>
        @endpermission
        <!-- Col end -->
        @permission('borrower-finalized-operations')
        <div class="col-lg-4 col-md-6">
            <div class="rev_block bor_tur_third evt_click_dashboard_details" role="button" title="click for more details"
                data-href="{{ route('dashboard.borrower.finalized-operations', ['date_range' => $req_param['duration_date_range'], 'currency_type' => $req_param['currency_type']]) }}">
                <span class="dot" style="background-color: var(--mipo-red);"></span>
                <div class="rev_heading">
                    <i>
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="Frame 48096907" clip-path="url(#clip0_1983_74647)">
                                <g id="Group 48096167">
                                    <path id="Vector-167" d="M8 18.8095V3.80946C13.0943 1.00761 15.8907 0.653763 17.1641 1.23974C18.3078 1.76609 17.3073 3.17266 16.2943 3.92028C13.4458 6.02251 12.4845 8.87541 12.1476 10.7257C12.0423 11.3042 12.5061 11.8095 13.0941 11.8095H17.8908C18.6069 11.8095 19.3335 12.0417 19.7604 12.6167C21.0391 14.3394 20.544 16.318 19.7767 17.6945C19.3555 18.4501 18.5038 18.8095 17.6387 18.8095H8Z" fill="#11295A"/>
                                    <path id="Vector-169" d="M32.0039 23.9989V35.9989C19.501 37.9989 6.73822 28.7612 7.00391 27.4989C9.40179 20.3053 27.6089 37.1972 28.9261 30.4882C29.031 29.9541 28.5627 29.4832 28.0313 29.3654C27.1961 29.1804 26.1846 28.8498 25.266 28.6802C24.0357 28.4532 22.3318 28.3783 22.0608 27.1569C21.8883 26.3799 22.1302 25.6037 22.4908 24.9741C22.8829 24.2895 23.6786 23.9989 24.4675 23.9989H32.0039Z" fill="#11295A"/>
                                    <g id="Group 48096164">
                                        <path id="Ellipse-9" d="M16.2886 7.91617C16.1072 8.43597 16.5073 8.9512 17.0541 9.01557C24.7362 9.91999 23.8029 16.1769 21.1836 19.6521C20.7464 20.2321 20.9969 21.1555 21.7148 21.2662C31.0451 22.7051 35.5 16.6416 35.5 11.4285C35.5 5.90564 31.0228 1.42849 25.5 1.42849C21.8055 0.966685 17.6845 3.91723 16.2886 7.91617Z" fill="#199CD8"/>
                                        <path id="Vector-170" d="M25.8456 5.26248C26.6261 7.84075 28.6593 9.8739 31.2375 10.6544C31.5875 10.7602 31.5875 11.2398 31.2375 11.3456C28.6593 12.1261 26.6261 14.1593 25.8456 16.7375C25.7398 17.0875 25.2602 17.0875 25.1544 16.7375C24.3739 14.1593 22.3407 12.1261 19.7625 11.3456C19.4125 11.2398 19.4125 10.7602 19.7625 10.6544C22.3407 9.8739 24.3739 7.84075 25.1544 5.26248C25.2602 4.91251 25.7386 4.91251 25.8456 5.26248Z" fill="#EEF8FF"/>
                                    </g>
                                    <path id="Vector-166" d="M0 20.8086V3.80859H6V20.8086H0Z" fill="#199CD8"/>
                                    <path id="Vector-168" d="M34.001 39V21H40.001V39H34.001Z" fill="#199CD8"/>
                                </g>
                            </g>
                            <defs>
                                <clipPath id="clip0_1983_74647">
                                    <rect width="40" height="40" fill="white"/>
                                </clipPath>
                            </defs>
                        </svg>
                    </i>
                    <div class="head_txt">
                        <h3>{!! __('Finalized Deals') !!}</h3>
                        <p>{!! __('Total Sold vs. Total Perceived') !!}</p>
                    </div>
                </div>
                <div class="rev_content">
                    <div class="manage_wrap">
                        <div class="left_txt">
                            <div class="flxrow doc-currency">
                                <div class="flxcol">
                                    <p>{!! __('Sold Documents') !!}</p>
                                    <h6 style="color: var(--m-green-text);font-size: 18px;"> {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_finalized_doc_sold) }}</h6>
                                    <h6 style="font-size: 14px;font-weight: 500;">{{ __('Discount') }}: <span style="color: var(--m-text-light-grey);font-size: 14px;font-weight: 500;"> {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_finalized_doc_sold_discount) }}</span></h6>
                                </div>
                                <div class="flxcol" style="text-align: right;">
                                    <p>{!! __('Total Perceived') !!}</p>
                                    <h6 style="color: var(--m-green-text);font-size: 18px;">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_finalized_doc_accepted) }}</h6>
                                    <h6 style="font-size: 14px;font-weight: 500;">{{ __('% Discount')}}: <span style="color: var(--m-text-red-color);font-size: 14px;font-weight: 500;">{{ round($total_finalized_doc_sold_discount_pr, 2) }}%</span></h6>
                                </div>
                            </div>
                        </div>
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
    <div class="rev_block evt_click_dashboard_details mobile_bor_tur_first" role="button" title="click for more details" data-href="{{ route('dashboard.borrower.finalized-deals', ['date_range' => $req_param['duration_date_range'], 'currency_type' => $req_param['currency_type']]) }}">
        <span class="dot" style="background-color: var(--mipo-green);"></span>
        <div class="rev_heading">
            <i>
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="layer 1">
                        <g id="Group 48096166">
                            <path id="Vector-11" d="M1 2V32.4118C1 32.964 1.44772 33.4118 2 33.4118H2.23529C2.78758 33.4118 3.23529 32.964 3.23529 32.4118V12.5907C3.23529 12.3255 3.34065 12.0711 3.52819 11.8836L11.8836 3.52819C12.0711 3.34065 12.3255 3.23529 12.5907 3.23529H24.5882C25.1405 3.23529 25.5882 2.78758 25.5882 2.23529V2C25.5882 1.44772 25.1405 1 24.5882 1H2C1.44772 1 1 1.44772 1 2Z" fill="#11295A"/>
                            <path id="Vector-12" d="M7.70605 12.1757L12.1766 7.70508V12.1757H7.70605Z" fill="#11295A"/>
                            <path id="Vector-13" d="M39.0001 30.0547C39.0001 31.5492 38.5822 32.9486 37.8539 34.1327C36.4798 36.3807 34.0039 37.8814 31.1797 37.8814C30.3819 37.8814 29.6156 37.7611 28.8938 37.5458C26.4685 36.8049 24.5435 34.9179 23.7456 32.518C23.5493 31.9164 23.4227 31.2769 23.3784 30.6183C23.3594 30.4347 23.353 30.2447 23.353 30.0547C23.353 28.3893 23.8723 26.8506 24.7588 25.5841C25.392 24.6786 26.2026 23.9188 27.1524 23.3489C28.3302 22.6396 29.7043 22.2344 31.1797 22.2344H31.2177C32.0662 22.2407 32.8831 22.38 33.6493 22.6333C36.7585 23.6655 39.0001 26.5973 39.0001 30.0547Z" fill="#199CD8"/>
                            <path id="Vector-14" d="M26.7061 30.0595L29.3139 32.2948L34.5296 27.8242" stroke="#EEF8FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <g>
                                <path id="Vector-15" d="M28.9413 7.58789C28.9413 7.03561 28.4936 6.58789 27.9413 6.58789H15.4119C14.8596 6.58789 14.4119 7.03561 14.4119 7.58789V13.4114C14.4119 13.9637 13.9642 14.4114 13.4119 14.4114H7.58838C7.03609 14.4114 6.58838 14.8591 6.58838 15.4114V37.9997C6.58838 38.5519 7.03609 38.9997 7.58838 38.9997H23.3531L20.0001 34.5291H8.82367V32.2938H20.0001V28.9408H8.82367V26.7055H18.8825V24.4702H8.82367V22.2349H22.7943C23.1668 21.4899 25.5884 18.882 28.9413 18.882V7.58789Z" fill="#11295A"/>
                                <path id="Vector-16" d="M23.3497 38.998H16.6464C15.4123 38.998 14.4119 37.9976 14.4119 36.7635C14.4119 35.5295 15.4123 34.5291 16.6464 34.5291H20.7944C21.2109 36.257 22.1115 37.7991 23.3497 38.998Z" fill="#11295A"/>
                                <path id="Vector-17" d="M8.82367 28.9408H20.0001V32.2938H8.82367V28.9408Z" fill="#11295A"/>
                                <path id="Vector-18" d="M8.82367 23.3526H22.2354C20.8943 24.2467 20.559 25.5879 20.0001 26.7055H8.82367V23.3526Z" fill="#11295A"/>
                                <path id="Vector-19" d="M8.82367 18.882H28.9413C26.706 19.4408 23.617 21.4899 23.3531 22.2349H8.82367V18.882Z" fill="#11295A"/>
                            </g>
                        </g>
                    </g>
                </svg>
            </i>
            <div class="head_txt">
                <h3>{!! __('Sold Documents') !!}</h3>
                <p>{!! __('Status of Closed Deals') !!}</p>
            </div>
        </div>
        <div class="rev_content">
            <div class="cont_wrap">
                <div class="left_txt">
                    <h5> {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_finalized_deals) }}</h5>
                    <h6><span>{{ round($last_month_pr, 2) }}%</span> {{ __('from last month') }}</h6>
                </div>
            </div>
        </div>
        <div id="barchart_finalized_deals_borrow"></div>
    </div>
    <div class="rev_block evt_click_dashboard_details mobile_bor_tur_second" role="button" title="click for more details" data-href="{{ route('operations.index') }}">
        <span class="dot" style="background-color: var(--mipo-primary-color);"></span>
        <div class="rev_heading">
            <i>
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="Layer_1" clip-path="url(#clip0_1983_74624)">
                        <path id="Vector-157" d="M31.7754 36.01L28.3096 23.2882C28.1343 22.6445 27.3892 22.3506 26.8194 22.6977C22.1938 25.5161 18.5703 27.497 13.1671 28.6405C12.4402 28.7943 12.1979 29.5729 12.8739 29.8812C15.3144 30.9943 19.9468 31.2663 21.9453 31.5799C22.4816 31.6641 22.5635 32.1489 22.0775 32.391C19.7227 33.5641 14.5581 33.5028 11.5776 32.9939C3.90406 30.8586 1.49362 30.349 0.559652 30.9545C-0.000579834 31.3177 0.252298 32.1537 0.6978 32.6509C9.88137 42.9019 23.5122 40.4111 31.2171 37.1747C31.6708 36.9841 31.9047 36.4847 31.7754 36.01Z" fill="#11295A"/>
                        <path id="Vector-156" d="M40 37.1658V19C40 18.4477 39.5539 18 39.0016 18H31.4995C30.9472 18 30.4991 18.4484 30.5092 19.0006C30.6509 26.7159 32.4066 33.5138 34.2362 37.5969C34.3935 37.9478 34.7446 38.1658 35.1292 38.1658H39C39.5523 38.1658 40 37.7181 40 37.1658Z" fill="#11295A"/>
                        <path id="Rectangle-1534" d="M28 1.77778C28 0.795939 27.2041 0 26.2222 0H1.77778C0.79594 0 0 0.795938 0 1.77778V16.2222C0 17.2041 0.795938 18 1.77778 18H26.2222C27.2041 18 28 17.2041 28 16.2222V1.77778Z" fill="#199CD8"/>
                        <rect id="Rectangle-1536" width="1.92192" height="1.92192" rx="0.960961" transform="matrix(-1 0 0 1 23 8)" fill="#EEF8FF"/>
                        <rect id="Rectangle-1535" width="1.92192" height="1.92192" rx="0.960961" transform="matrix(-1 0 0 1 7 8)" fill="#EEF8FF"/>
                        <g id="Group 48096164">
                            <circle id="Ellipse-95" cx="5" cy="5" r="5" transform="matrix(-1 0 0 1 19 4)" fill="#EEF8FF"/>
                            <path id="Vector-158" d="M14.1728 6.13124C14.5631 7.42037 15.5796 8.43695 16.8688 8.82721C17.0437 8.88009 17.0437 9.11991 16.8688 9.17279C15.5796 9.56305 14.5631 10.5796 14.1728 11.8688C14.1199 12.0437 13.8801 12.0437 13.8272 11.8688C13.437 10.5796 12.4204 9.56305 11.1312 9.17279C10.9563 9.11991 10.9563 8.88009 11.1312 8.82721C12.4204 8.43695 13.437 7.42037 13.8272 6.13124C13.8801 5.95625 14.1193 5.95625 14.1728 6.13124Z" fill="#199CD8"/>
                        </g>
                    </g>
                    <defs>
                        <clipPath id="clip0_1983_74624">
                            <rect width="40" height="40" fill="white" transform="matrix(-1 0 0 1 40 0)"/>
                        </clipPath>
                    </defs>
                </svg>
            </i>
            <div class="head_txt">
                <h3>{!! __('Received Offers') !!}</h3>
                <p>{!! __('Received Offers and In-Process') !!}</p>
            </div>
        </div>
        <div class="rev_content">
            <div class="cont_wrap">
                <div class="left_txt">
                    <div class="green-name">
                        <h5>
                            {!!
                                app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_deals_in_progress_operations_offer) .' / <span>'. 
                                app('common')->currencyNumberFormat($req_param['currency_type'], $total_deals_in_progress_operations).'</span>' 
                            !!}
                        </h5>
                        <h6>{{ __('Discount') }}: <span>{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_deals_diff) }}</span></h6>
                        <h6>{{ __('% Discount') }}: <span style="color: var(--m-text-red-color)">{{ app('common')->currencyNumberFormat($req_param['currency_type'], round($total_deals_diff_pr, 2)) }}% </span> </h6>
                    </div>
                </div>
            </div>
        </div>
        <div id="barchart_deals_borrow"></div>
    </div>
    <div class="rev_block evt_click_dashboard_details mobile_bor_tur_third" role="button" title="click for more details" data-href="{{ route('dashboard.borrower.finalized-operations', ['date_range' => $req_param['duration_date_range'], 'currency_type' => $req_param['currency_type']]) }}">
        <span class="dot" style="background-color: var(--mipo-red);"></span>
        <div class="rev_heading">
            <i>
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="Frame 48096907" clip-path="url(#clip0_1983_74647)">
                        <g id="Group 48096167">
                            <path id="Vector-167" d="M8 18.8095V3.80946C13.0943 1.00761 15.8907 0.653763 17.1641 1.23974C18.3078 1.76609 17.3073 3.17266 16.2943 3.92028C13.4458 6.02251 12.4845 8.87541 12.1476 10.7257C12.0423 11.3042 12.5061 11.8095 13.0941 11.8095H17.8908C18.6069 11.8095 19.3335 12.0417 19.7604 12.6167C21.0391 14.3394 20.544 16.318 19.7767 17.6945C19.3555 18.4501 18.5038 18.8095 17.6387 18.8095H8Z" fill="#11295A"/>
                            <path id="Vector-169" d="M32.0039 23.9989V35.9989C19.501 37.9989 6.73822 28.7612 7.00391 27.4989C9.40179 20.3053 27.6089 37.1972 28.9261 30.4882C29.031 29.9541 28.5627 29.4832 28.0313 29.3654C27.1961 29.1804 26.1846 28.8498 25.266 28.6802C24.0357 28.4532 22.3318 28.3783 22.0608 27.1569C21.8883 26.3799 22.1302 25.6037 22.4908 24.9741C22.8829 24.2895 23.6786 23.9989 24.4675 23.9989H32.0039Z" fill="#11295A"/>
                            <g id="Group 48096164">
                                <path id="Ellipse-9" d="M16.2886 7.91617C16.1072 8.43597 16.5073 8.9512 17.0541 9.01557C24.7362 9.91999 23.8029 16.1769 21.1836 19.6521C20.7464 20.2321 20.9969 21.1555 21.7148 21.2662C31.0451 22.7051 35.5 16.6416 35.5 11.4285C35.5 5.90564 31.0228 1.42849 25.5 1.42849C21.8055 0.966685 17.6845 3.91723 16.2886 7.91617Z" fill="#199CD8"/>
                                <path id="Vector-170" d="M25.8456 5.26248C26.6261 7.84075 28.6593 9.8739 31.2375 10.6544C31.5875 10.7602 31.5875 11.2398 31.2375 11.3456C28.6593 12.1261 26.6261 14.1593 25.8456 16.7375C25.7398 17.0875 25.2602 17.0875 25.1544 16.7375C24.3739 14.1593 22.3407 12.1261 19.7625 11.3456C19.4125 11.2398 19.4125 10.7602 19.7625 10.6544C22.3407 9.8739 24.3739 7.84075 25.1544 5.26248C25.2602 4.91251 25.7386 4.91251 25.8456 5.26248Z" fill="#EEF8FF"/>
                            </g>
                            <path id="Vector-166" d="M0 20.8086V3.80859H6V20.8086H0Z" fill="#199CD8"/>
                            <path id="Vector-168" d="M34.001 39V21H40.001V39H34.001Z" fill="#199CD8"/>
                        </g>
                    </g>
                    <defs>
                        <clipPath id="clip0_1983_74647">
                            <rect width="40" height="40" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
            </i>
            <div class="head_txt">
                <h3>{!! __('Finalized Deals') !!}</h3>
                <p>{!! __('Total Sold vs. Total Perceived') !!}</p>
            </div>
        </div>
        <div class="rev_content">
            <div class="manage_wrap">
                <div class="left_txt">
                    <div class="flxrow doc-currency">
                        <div class="flxcol">
                            <p>{!! __('Sold Documents') !!}</p>
                            <h6 style="color: var(--m-green-text);font-size: 18px;"> {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_finalized_doc_sold) }}</h6>
                            <h6 style="font-size: 14px;font-weight: 500;">{{ __('Discount') }}: <span style="color: var(--m-text-light-grey);font-size: 14px;font-weight: 500;"> {{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_finalized_doc_sold_discount) }}</span></h6>
                        </div>
                        <div class="flxcol" style="text-align: right;">
                            <p>{!! __('Total Perceived') !!}</p>
                            <h6 style="color: var(--m-green-text);font-size: 18px;">{{ app('common')->currencyBySymbol($req_param['currency_type']).' '.app('common')->currencyNumberFormat($req_param['currency_type'], $total_finalized_doc_accepted) }}</h6>
                            <h6 style="font-size: 14px;font-weight: 500;">{{ __('% Discount')}}: <span style="color: var(--m-text-red-color);font-size: 14px;font-weight: 500;">{{ round($total_finalized_doc_sold_discount_pr, 2) }}%</span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- mobile slider by k --}}