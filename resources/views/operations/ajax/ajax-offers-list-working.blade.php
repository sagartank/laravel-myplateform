@if(isset($offers) && $offers->count() > 0)
@foreach ($offers as $key => $offer)
    @php
    $operation_amount = $offer->operations->first()->amount;
    @endphp
    @if($offer->offer_type == 'Group')
    @php
    $operation_amounts = $offer->operations->pluck('amount')->sum();
    @endphp
    <div class="list_operations list_operations_group evt_operation_by_offer" role="button" data-operation-details-link="{{ Route('operations.details', $offer->operations->first()->slug) }}" data-offer-amount="{{ app('common')->currencyBySymbol($offer->operations->first()->preferred_currency) }}{{ app('common')->currencyNumberFormat($offer->operations->first()->preferred_currency, $operation_amounts)}}" data-issuer-name="{{$offer->operations->first()->issuer->name}}" data-operation-type-number="{{ $offer->operations->first()->operation_type_number }}" data-offer-id="{{$offer->id}}" data-offer-type="{{$offer->offer_type}}" data-operation-id="{{ $offer->operations->pluck('id')->implode(',') }}">
        <div class="cheque_left_top list_operations_top">
            <label for="cheque_operations_{{$offer->id}}">{{__('GROUP OFFER ')}} {{ $offer->operations->first()->operation_type_number }}
                -
                {{-- {{$offer->buyer->name  }} --}}
                {{ app('common')->lockOfferDetail($offer, ['buyer_name']) }}
            </label>
            <div class="operations_group_icon">
                <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.25 7.5L5.05933 8.79467C5.19413 9.01047 5.38161 9.18843 5.60412 9.31182C5.82664 9.43521 6.07689 9.49997 6.33133 9.5H7.66867C8.186 9.5 8.66667 9.23333 8.94067 8.79467L9.75 7.5M0.606667 4H3.69733C3.94427 4.00002 4.18738 4.061 4.40509 4.17753C4.62279 4.29406 4.80837 4.46253 4.94533 4.668L5.05467 4.832C5.19163 5.03747 5.37721 5.20594 5.59491 5.32247C5.81262 5.439 6.05573 5.49998 6.30267 5.5H7.69733C7.94427 5.49998 8.18738 5.439 8.40509 5.32247C8.62279 5.20594 8.80837 5.03747 8.94533 4.832L9.05467 4.668C9.19163 4.46253 9.37721 4.29406 9.59491 4.17753C9.81262 4.061 10.0557 4.00002 10.3027 4H13.3933M0.606667 4C0.536308 4.17647 0.50011 4.36469 0.5 4.55467V6C0.5 6.39782 0.658035 6.77936 0.93934 7.06066C1.22064 7.34196 1.60218 7.5 2 7.5H12C12.3978 7.5 12.7794 7.34196 13.0607 7.06066C13.342 6.77936 13.5 6.39782 13.5 6V4.55467C13.5 4.36333 13.4633 4.17467 13.3933 4M0.606667 4C0.667771 3.84649 0.753819 3.70413 0.861333 3.57867L3.05133 1.024C3.19211 0.859705 3.36676 0.727809 3.56331 0.637361C3.75986 0.546913 3.97364 0.500055 4.19 0.5H9.81C10.248 0.5 10.664 0.691333 10.9493 1.024L13.1387 3.57867C13.2473 3.70533 13.3327 3.848 13.3933 4M2 11.5H12C12.3978 11.5 12.7794 11.342 13.0607 11.0607C13.342 10.7794 13.5 10.3978 13.5 10V8.25C13.5 7.836 13.164 7.5 12.75 7.5H1.25C0.836 7.5 0.5 7.836 0.5 8.25V10C0.5 10.3978 0.658035 10.7794 0.93934 11.0607C1.22064 11.342 1.60218 11.5 2 11.5Z" stroke="#ADADAD" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
        <div class="list_operations_bottom">
            <div class="list_operations_bottom_left">
                <div class="cheque_amount">
                    <span>{{ ($currency_symblos[$offer->operations->first()->preferred_currency]) }}</span> {{ app('common')->currencyNumberFormat($offer->operations->first()->preferred_currency, $operation_amounts)}}
                </div>
            </div>
            <div class="list_operations_bottom_right">
                <div class="expire_list_operations_day">
                    {{ __('Expire in') }} {{$offer->offer_expire_at}}
                </div>
            </div>
        </div>
    </div>
    @elseif($offer->offer_type == 'Single')
    <div class="list_operations evt_operation_by_offer" role="button" data-operation-details-link="{{ Route('operations.details', $offer->operations->first()->slug) }}" data-offer-amount="{{ app('common')->currencyBySymbol($offer->operations->first()->preferred_currency) }}{{ app('common')->currencyNumberFormat($offer->operations->first()->preferred_currency, $operation_amount)}}" data-issuer-name="{{$offer->operations->first()->issuer->name}}" data-operation-type-number="{{ $offer->operations->first()->operation_type_number }}" data-offer-id="{{$offer->id}}" data-offer-type="{{$offer->offer_type}}" data-operation-id="{{$offer->operations->first()->id}}">
        <div class="cheque_left_top list_operations_top">
            <label for="cheque_operations_{{$key}}">{{$offer->operations->first()->operation_type_number}}</span>
            </label>
            <div class="case_star">
                <span>{{ $offer->operations->first()->preferred_payment_method}}</span>
            </div>
            <div class="cheque_attach_file">
                <i>
                    <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.25 7.99284L6.12135 13.1215C5.55874 13.6841 4.79567 14.0002 4.00002 14.0002C3.20436 14.0002 2.4413 13.6841 1.87868 13.1215C1.31607 12.5589 1 11.7958 1 11.0002C1 10.2045 1.31607 9.44145 1.87868 8.87884L9.17202 1.5855C9.3578 1.39981 9.57833 1.25253 9.82102 1.15207C10.0637 1.05161 10.3238 0.999938 10.5865 1C10.8492 1.00006 11.1092 1.05186 11.3519 1.15243C11.5945 1.25301 11.815 1.40039 12.0007 1.58617C12.1864 1.77195 12.3337 1.99248 12.4341 2.23517C12.5346 2.47787 12.5862 2.73797 12.5862 3.00064C12.5861 3.26331 12.5343 3.52339 12.4338 3.76604C12.3332 4.00868 12.1858 4.22915 12 4.41484L4.70135 11.7135M4.70135 11.7135L4.70735 11.7068M4.70135 11.7135C4.51201 11.895 4.25893 11.9942 3.99665 11.9909C3.73437 11.9876 3.4839 11.8813 3.29922 11.6951C3.11453 11.5088 3.01042 11.2574 3.00933 10.9952C3.00823 10.7329 3.11023 10.4806 3.29335 10.2928L8.50002 5.08617" stroke="#ADADAD" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </i>
                <span>{{ $offer->operations->first()->supportingAttachments->count() + $offer->operations->first()->documents->count()}}</span>
                {{ __('Attachments') }}
            </div>

            <div class="cheque_with_resource">
                <i><img src="{{ asset('images/setting_gray.svg')}}" alt="image"></i> {{$offer->operations->first()->responsibility}} {{ __('Resources') }}
            </div>
        </div>

        <div class="cheque_compnyname">{{$offer->operations->first()->issuer->name}}</div>
        
        <div class="list_operations_bottom">
            <div class="list_operations_bottom_left">
                <div class="cheque_amount">
                    <span>{{ ($currency_symblos[$offer->operations->first()->preferred_currency]) }}</span> {{ app('common')->currencyNumberFormat($offer->operations->first()->preferred_currency, $operation_amount)}}
                </div>
            </div>

            <div class="list_operations_bottom_right">
                <div class="expire_list_operations_day">
                    {{ __('Expire in') }} {{$offer->offer_expire_at}}
                </div>

                <div class="expire_list_operations_date">
                    {{ __(' Expire on') }} {{$offer->offer_expire_date_iso}}
                </div>

                <a href="#" class="submit_operations_action">
                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 1L13 6M13 6L8 11M13 6H1" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
@endif
@endforeach
<div class="more_document_btn px-3">
    <div class="row">
        <div class="col-md-6 evt_paginate_offers">
            {!! $offers->links() !!}
        </div>
        @if($last_page > 1)
        <div class="col-md-6">
            <div class="sortwrp justify-content-end">
                <input type="text" name="offer_page_no" id="offer_page_no" value="">
                <button class="btn btn-primary evt_offers_got_to_page" data-last-page="{{$last_page}}">Go</button>
            </div>
        </div>
        @endif
    </div>
</div>
@else
<div class="more_document_btn px-3">
    <div class="row">
        <p class="text-center font-weight-bold text-danger mt-3">
            {{ __(' No Record Found.')}}
        </p>
    </div>
</div>
@endif