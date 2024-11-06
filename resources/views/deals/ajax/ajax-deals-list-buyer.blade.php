@if(isset($deals_record) && $deals_record->count() > 0)
    <div class="deals_section_wrapper">
        @foreach ($deals_record as $key => $deals)
        
            <div class="deals_bought_caption">
                <div class="left_part">
                    <div class="cap_box">
                        <a href="{{ route('deals.details', [$deals->slug, 'buyer']) }}" class="name text-14-medium">{!! __($deals->operations->first()?->operation_type_number) !!}</a>
                        <span class="cash text-14-medium">{!! __($deals->preferred_payment_method) !!}</span>
                        <a href="javascript:;" class="seller_name text-14-medium">{!! __($deals->operations->first()?->seller->name) !!}</a>
                        <span class="seller_btn text-12-medium">{!! __('Seller') !!}</span>
                        <i><img src="{{ asset('images/mipo/deals-img2.svg') }}" alt="no-image"></i>
                        <a href="javascript:;" class="payer_name text-14-medium">{!! __($deals->buyer?->name) !!}</a>
                    </div>
                    <a href="{{ route('deals.details', [$deals->slug, 'buyer']) }}" class="company_name text-14-medium">{!! __($deals->operations->first()?->issuer->company_name) !!}</a>
                    <div class="imagesbox">
                        <ul class="first">
                            <li class="text-14-medium">
                                <i class="light"><img src="{{ asset('images/mipo/deals-img3.svg') }}" alt="no-image"></i>
                                <i class="dark"><img src="{{ asset('images/mipo/deals-img13.svg') }}" alt="no-image"></i>
                                {!! app('common')->responsibility($deals->operations->first()?->responsibility) !!}</li>
                            <li class="text-14-medium">
                                @if($deals->operations->first()?->preferred_currency == 'USD')
                                <i class="light"><img src="{{ asset('images/mipo/dollar_light_18_18.svg') }}" alt="no-image"></i>
                                <i class="dark"><img src="{{ asset('images/mipo/dollar_dark_18_18.svg') }}" alt="no-image"></i>
                                @else
                                <i class="light"><img src="{{ asset('images/mipo/deals-img4.svg') }}" alt="no-image"></i>
                                <i class="dark"><img src="{{ asset('images/mipo/deals-img14.svg') }}" alt="no-image"></i>
                                @endif
                                @if($deals->offer_type == 'Group')
                                    {!!  app('common')->currencyNumberFormat($deals->operations->first()?->preferred_currency, $deals->operations->first()?->amount) !!} 
                                @endif
                                @if($deals->offer_type == 'Single')
                                    {!!  app('common')->currencyNumberFormat($deals->operations->first()?->preferred_currency, $deals->operations->first()?->amount) !!}
                                @endif
                            </li>
                        </ul>
                        @if($deals->operations->first()?->cheque_status!='' || $deals->operations->first()?->cheque_type!='' ||  $deals->operations->first()?->cheque_payee_type!='' || $deals->operations->first()?->seller->account_type!='')
                        <ul class="second">
                            @if(!is_null($deals->operations->first()?->cheque_status) && $deals->operations->first()?->cheque_status!='')
                                <li><i><img src="{{ app('common')->operationChequeStatus($deals->operations->first()->cheque_status) }}" title="{{ $deals->operations->first()->cheque_status }}" alt="{{ $deals->operations->first()->cheque_status }}"></i></li>
                            @endif

                            @if(!is_null($deals->operations->first()?->cheque_type) && $deals->operations->first()?->cheque_type!='')
                                <li><i><img src="{{ app('common')->operationChequeType($deals->operations->first()->cheque_type) }}" title="{{ $deals->operations->first()->cheque_type }}" alt="{{ $deals->operations->first()->cheque_type }}"></i></li>
                            @endif

                            @if(!is_null($deals->operations->first()?->cheque_payee_type) && $deals->operations->first()?->cheque_payee_type!='')
                                <li><i><img src="{{ app('common')->operationChequePayeeType($deals->operations->first()->cheque_payee_type) }}" title="{{ $deals->operations->first()->cheque_payee_type }}" alt="{{ $deals->operations->first()->cheque_payee_type }}"></i></li>
                            @endif

                            @if(!is_null($deals->operations->first()?->seller->account_type) && $deals->operations->first()?->seller->account_type!='')
                                <li><i><img src="{{ app('common')->userAccountType($deals->operations->first()->seller->account_type) }}" title="{{ $deals->operations->first()->seller->account_type }}"  alt="{{ $deals->operations->first()->seller->account_type }}"></i></li>
                            @endif
                        </ul>
                        @endif
                    </div>
                </div>
                <div class="right_part">
                    <div class="first_right">
                        <div class="first">
                            @if($deals->is_mipo_plus == 'Yes')
                            <i><img src="{{ asset('images/mipo/deals-img9.svg') }}" alt="no-image"></i>
                            @endif
                            <ul>
                                <li><img src="{{ asset('images/mipo/deals-img10.svg') }}" alt="no-image"></li>
                                <li><img src="{{ asset('images/mipo/deals-img11.svg') }}" alt="no-image"></li>
                            </ul>
                            <p class="text-14-medium">{!! __($deals->buyer?->city?->name ?? 'Unknown City') !!}</p>
                        </div>
                        <span class="ex_wrap text-14-medium">{!! __($deals->operations->first()?->expire_date_iso) !!}</span>
                    </div>
                    <div class="second_right">
                        <p class="text-14-medium">
                            @if(app()->getLocale() == 'es')
                            {{ ($deals->offers_logs->count() > 0) ? $buyer_steps[$deals->offers_logs->first()?->title] : '-' }}
                            @else
                            {{ ($deals->offers_logs->count() > 0) ? $deals->offers_logs->first()?->title : '-' }}
                            @endif
                        </p>
                        <span class="text-14-semibold">
                            {!! __($deals->operations->first()?->preferred_currency) !!}
                            {!!  app('common')->currencyNumberFormat($deals->operations->first()?->preferred_currency, $deals->amount) !!}
                        </span>
                    </div>
                </div>
                <a href="{{ route('deals.details', [$deals->slug, 'buyer']) }}" class="full_link"></a>
            </div>

            {{-- mobile screen --}}
            <div class="deals_mobile_bought_caption">
                <div class="left_part">
                    <div class="cap_box">
                        <div class="first_bought">
                            <a href="{{ route('deals.details', [$deals->slug, 'buyer']) }}" class="name text-14-medium">{!! __($deals->operations->first()?->operation_type_number) !!}</a>
                            <span class="cash text-14-medium">{!! __($deals->preferred_payment_method) !!}</span>
                        </div>
                        <div class="second_bought">
                            <a href="javascript:;" class="seller_name text-12-medium">{!! __($deals->operations->first()?->seller->name) !!}</a>
                            <span class="seller_btn text-12-medium">{!! __('Seller') !!}</span>
                            <i><img src="{{ asset('images/mipo/deals-img2.svg') }}" alt="no-image"></i>
                            <a href="javascript:;" class="payer_name text-12-medium">{!! __($deals->buyer?->name) !!}</a>
                        </div>
                        <a href="{{ route('deals.details', [$deals->slug, 'buyer']) }}" class="company_name text-14-medium">{!! __($deals->operations->first()?->issuer->company_name) !!}</a>
                    </div>
                    <div class="imagesbox">
                        <ul class="first">
                            <li class="text-14-medium">
                                <i class="light"><img src="{{ asset('images/mipo/deals-img3.svg') }}" alt="no-image"></i>
                                <i class="dark"><img src="{{ asset('images/mipo/deals-img13.svg') }}" alt="no-image"></i>
                                {!! app('common')->responsibility($deals->operations->first()?->responsibility) !!}
                            </li>
                            <li class="text-14-medium">
                                @if($deals->operations->first()?->preferred_currency == 'USD')
                                <i class="light"><img src="{{ asset('images/mipo/dollar_light_18_18.svg') }}" alt="no-image"></i>
                                <i class="dark"><img src="{{ asset('images/mipo/dollar_dark_18_18.svg') }}" alt="no-image"></i>
                                @else
                                <i class="light"><img src="{{ asset('images/mipo/deals-img4.svg') }}" alt="no-image"></i>
                                <i class="dark"><img src="{{ asset('images/mipo/deals-img14.svg') }}" alt="no-image"></i>
                                @endif
                                @if($deals->offer_type == 'Group')
                                    {!!  app('common')->currencyNumberFormat($deals->operations->first()?->preferred_currency, $deals->operations->first()?->amount) !!}    
                                @endif
                                @if($deals->offer_type == 'Single')
                                    {!!  app('common')->currencyNumberFormat($deals->operations->first()?->preferred_currency, $deals->operations->first()?->amount) !!}
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="right_part">
                    <div class="first_right">
                        <p class="text-14-medium">
                            @if(app()->getLocale() == 'es')
                            {{ ($deals->offers_logs->count() > 0) ? $buyer_steps[$deals->offers_logs->first()?->title] : '-' }}
                            @else
                            {{ ($deals->offers_logs->count() > 0) ? $deals->offers_logs->first()?->title : '-' }}
                            @endif
                        </p>
                        <span class="text-14-semibold">
                            {!! __($deals->operations->first()?->preferred_currency) !!}
                            {!!  app('common')->currencyNumberFormat($deals->operations->first()?->preferred_currency, $deals->amount) !!}
                        </span>
                    </div>
                    <div class="second_right">
                        <span class="ex_wrap text-12-medium">{!! __($deals->operations->first()?->expire_date_iso) !!}</span>
                        @if($deals->is_mipo_plus == 'Yes')
                            <i><img src="{{ asset('images/mipo/deals-img9.svg') }}" alt="no-image"></i>
                        @endif
                    </div>
                </div>
                <a href="{{ route('deals.details', [$deals->slug, 'buyer']) }}" class="full_link"></a>
            </div>
            {{-- end mobile screen --}}
        
        
        @endforeach
    </div>
    @if ($last_page > 1)
        <div class="bottom_pageSec">
            <div class="expdoc_pager paginate_buyer">
                {!! $deals_record->links() !!}
            </div>
            @if ($last_page > 1)
                <div class="exp_sortwrp paginate_buyer">
                    <span>{!! __('Go to Page') !!}</span>
                    <input type="number" name="offer_page_no" id="got_to_page_buyer">
                    <a href="javascript:void(0)" class="evt_btn_go_page_no" data-active-name="buyer" data-last-page="{{ $last_page }}">{!! __('Go') !!} <i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <g clip-path="url(#clip0_3013_38074)">
                        <rect width="16" height="16" rx="8" transform="matrix(1.19249e-08 -1 -1 -1.19249e-08 16 16)" fill="white"/>
                        <path d="M6 12L10 8L6 4" stroke="black" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_3013_38074">
                            <rect width="16" height="16" rx="8" transform="matrix(1.19249e-08 -1 -1 -1.19249e-08 16 16)" fill="white"/>
                        </clipPath>
                        </defs>
                    </svg></i>
                    </a>
                </div>
            @endif
        </div>
    @endif
    @else
    <div class="op_empty deals_op_empty">
        <div class="ope_notfoundWrap">
            <div class="imgbox">
                <i class="day"><img src="{{ asset('images/mipo/deals-img16.svg') }}" alt="no-image"></i>
                <i class="night"><img src="{{ asset('images/mipo/deals-img17.svg') }}" alt="no-image"></i>
                <strong class="text-20-semibold">{{ __('No operation has been closed yet')}}</strong>
                <p class="text-16-medium">{{ __('Start sending offers and start closing deals')}}</p>
                <div class="newoprationBtn">
                    <a href="{{ route('explore-operations.index') }}" class="text-16-medium"><i><img src="{{ asset("images/mipo/deals-img12.svg") }}" alt="no-image"></i>{{ __('Explore Operations') }}</a>
                </div>
            </div>
        </div>
    </div>
@endif