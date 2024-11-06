@if(isset($offers) && $offers->count() > 0)
@foreach ($offers as $key => $offer)
    @php
    $operation_amount = $offer->operations_group_amount_sum;
    @endphp
    @if($offer->offer_type == 'Group')
    @php
    $operation_amounts = $offer->operations_group_amount_sum;
    @endphp
    <a href="javascript:;" class="group_offers evt_operation_by_offer mobile_group_offer_part" data-operation-details-link="{{ Route('operations.details', $offer->operation_slug) }}" data-offer-amount="{{ app('common')->currencyBySymbol($offer->preferred_currency) }}{{ app('common')->currencyNumberFormat($offer->preferred_currency, $operation_amounts)}}" data-issuer-name="{{$offer->issuer_name}}" data-operation-type-number="{{ $offer->operation_type_number }}" data-offer-id="{{$offer->id}}" data-offer-type="{{$offer->offer_type}}" data-operation-id="{{ $offer->operations_ids }}">
        <div class="list_opera_left_part">
            <h6 class="text-14-medium">
                {!! __('GROUP OFFER') !!}
                {{  ($offer->operation_type == 'Cheque') ? __('Check') : __($offer->operation_type) }} {{ $offer->operation_number }}
            </h6>
            <p class="text-14-medium">{{ __($offer->operation_preferred_payment_method) }}</p>
            <div class="list_opera_imgtext">
                @if($offer->preferred_currency == 'USD')
                    <i class="light"><img src="{{ asset('images/mipo/offerlightdollar.svg') }}" alt="no-image"></i>
                    <i class="dark"><img src="{{ asset('images/mipo/offerdarkmodedollar.svg') }}" alt="no-image"></i>
                @else
                    <i class="light"><img src="{{ asset('images/mipo/guarani-light-20-by-20.svg') }}" alt="no-image"></i>
                    <i class="dark"><img src="{{ asset('images/mipo/guarani-dark-20-by-20.svg') }}" alt="no-image"></i>
                @endif
                <span class="text-14-medium">{{ app('common')->currencyNumberFormat($offer->preferred_currency, $operation_amounts)}}</span>

            </div>
            <div class="list_opera_imgtext">
                <i class="light"><img src="{{ asset('images/mipo/offlightgr.svg') }}" alt="no-image"></i>
                <i class="dark"><img src="{{ asset('images/mipo/offdarkmodegr.svg') }}" alt="no-image"></i>
                <span class="text-14-medium">{!! __('Group') !!}</span>
            </div>
        </div>
        <div class="list_opera_right_part">
            <div class="list_p">
                <p class="text-14-medium">  
                    {{ app('common')->diffForHumans($offer->expires_at) }}
                     {{-- {{ __('Expire in') }} {{str_replace('from now', '',  \Carbon\Carbon::createFromDate($offer->expires_at)->diffForHumans())}} --}}
                    </p>
            </div>
            <div class="list_i">
                <i class="light"><img src="{{ asset('images/mipo/offerlightright.svg') }}" alt="no-image"></i>
                <i class="dark"><img src="{{ asset('images/mipo/offerdarkmoderight.svg') }}" alt="no-image"></i>
            </div>
        </div>
    </a>

    @elseif($offer->offer_type == 'Single')
    <a href="javascript:;" class="list_opera evt_operation_by_offer mobile_single_offer_part" data-operation-details-link="{{ Route('operations.details', $offer->operation_slug) }}" data-offer-amount="{{ app('common')->currencyBySymbol($offer->preferred_currency) }}{{ app('common')->currencyNumberFormat($offer->preferred_currency, $operation_amount)}}" data-issuer-name="{{$offer->issuer_name}}" data-operation-type-number="{{ $offer->operation_type_number }}" data-offer-id="{{$offer->id}}" data-offer-type="{{$offer->offer_type}}" data-operation-id="{{$offer->operations_ids}}">
        <div class="list_opera_left_part">
            <div class="list_opera_checkbox">
                <h6 class="text-14-medium">
                    {{  ($offer->operation_type == 'Cheque') ? __('Check') : __($offer->operation_type) }} {{ $offer->operation_number }}
                </h6>
                <p class="text-14-medium">{{ __($offer->operation_preferred_payment_method) }}</p>
            </div>
            <div class="list_opera_company text-14-medium">{!! __($offer->issuer_name) !!}</div>
            <div class="list_opera_imgtext">
                <i class="light"><img src="{{ asset('images/mipo/offerframe9.svg') }}" alt="no-image"></i>
                <i class="dark"><img src="{{ asset('images/mipo/offerdarkframe9.svg') }}" alt="no-image"></i>
                <span class="text-14-medium">
                    {{ app('common')->responsibility($offer->responsibility) }}
                </span>
            </div>
            <div class="list_opera_imgtext">
                @if($offer->preferred_currency == 'USD')
                    <i class="light"><img src="{{ asset('images/mipo/offerlightdollar.svg') }}" alt="no-image"></i>
                    <i class="dark"><img src="{{ asset('images/mipo/offerdarkmodedollar.svg') }}" alt="no-image"></i>
                @else
                    <i class="light"><img src="{{ asset('images/mipo/guarani-light-20-by-20.svg') }}" alt="no-image"></i>
                    <i class="dark"><img src="{{ asset('images/mipo/guarani-dark-20-by-20.svg') }}" alt="no-image"></i>
                @endif
            
                <span class="text-14-medium">{{ app('common')->currencyNumberFormat($offer->preferred_currency, $operation_amount)}}</span>
            </div>
        </div>
        <div class="list_opera_right_part">
            <div class="list_p">
                <p class="text-14-medium">
                    {{ app('common')->diffForHumans($offer->expires_at) }}
                    {{-- {{ __('Expire in') }} {{ str_replace('from now', '',  \Carbon\Carbon::createFromDate($offer->expires_at)->diffForHumans()) }} --}}
                </p>
            </div>
            <div class="list_i">
                <i class="light"><img src="{{ asset('images/mipo/offerlightright.svg') }}" alt="no-image"></i>
                <i class="dark"><img src="{{ asset('images/mipo/offerdarkmoderight.svg') }}" alt="no-image"></i>
            </div>
        </div>
    </a>
@endif
@endforeach
@if ($last_page > 1)
    <div class="bottom_pageSec">
        <div class="expdoc_pager evt_paginate_offers">
            {!! $offers->links() !!}
        </div>
        @if ($last_page > 1)
            <div class="exp_sortwrp">
                <span>{!! __('Go to Page') !!}</span>
                <input type="number" name="offer_page_no" id="offer_page_no" placeholder="" value="">
                <a href="javascript:void(0)" class="evt_offers_got_to_page" data-last-page="{{ $last_page }}">{!! __('Go') !!} <i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <g clip-path="url(#clip0_3013_38074)">
                    <rect width="16" height="16" rx="8" transform="matrix(1.19249e-08 -1 -1 -1.19249e-08 16 16)" fill="white"/>
                    <path d="M6 12L10 8L6 4" stroke="black" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_3013_38074">
                        <rect width="16" height="16" rx="8" transform="matrix(1.19249e-08 -1 -1 -1.19249e-08 16 16)" fill="white"/>
                    </clipPath>
                    </defs>
                </svg></i></a>
            </div>
        @endif
    </div>
@endif
@else
<div class="op_empty">
    <div class="ope_notfoundWrap">
        <div class="imgbox">
            <i class="day"><img src="{{ asset('images/mipo/offempty.svg') }}" alt="no-image"></i>
            <i class="night"><img src="{{ asset('images/mipo/nightempty.svg') }}" alt="no-image"></i>
            <strong class="text-20-semibold">{!! __('No offers available') !!}</strong>
            <p class="text-16-medium">{!! __('Upload more operations with relevant information to be able to receive more and better offers') !!}</p>
            <div class="newoprationBtn">
                <a href="{{ route('explore-operations.index')}}" class="text-16-medium"><i><img src="{{ asset('images/mipo/offwhitesearch.svg') }}" alt="no-image"></i> {!! __('Explore Operations') !!}</a>
            </div>
        </div>
    </div>
</div>
@endif