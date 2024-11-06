<x-app-layout>
    @section('pageTitle', 'Explore Operations Details')
    @section('custom_style')
        <link href="{{ asset('plugins/fancybox/fancybox.css') }}" rel="stylesheet">
        <style>
            .offer_error {
                border: 1px solid red !important;
            }
            .cta_block .check_inputbox{display:flex;align-items: center;}
            .cta_block label{padding:0 0 0 5px;}
        </style>
    @endsection

    {{-- operation detail:st --}}
        <div class="public_profile_main">
            <div class="container">
                <div class="public_pro_head">
                    <div class="opt_title">
                        <a href="{{ route('explore-operations.index') }}" class="leftimg">
                            <img src="{{ asset('images/mipo/topleftAro.svg') }}" class="day"  alt="no-image">
                            <img src="{{ asset('images/mipo/white_lft_aro.svg') }}" class="night"  alt="no-image">
                        </a>
                        <div class="textbox">
                            <h3 class="text-24-semibold">{!! __('Operation') !!}</h3>
                            <h4 class="text-14-medium">
                                {{ ($result->operation_type == 'Cheque') ? __('Check') : __($result->operation_type) }} {!! __($result->operation_number) !!}
                            </h4>
                        </div>
                    </div>
                    <div class="rightblock">
                        @if(!in_array($result->offers()->where('buyer_id', $buyer_id)->first()?->offer_status, ['Approved', 'Completed']))
                            <input type="hidden" data-currency-type="{{ $result->preferred_currency }}"
                            data-offer-type="{{ $result->mipo_verified == 'Yes' ? 'mipo' : 'operation' }}"
                            data-accept-below-requested="{{ $result->accept_below_requested }}"
                            value="{{ $result->id }}" data-operation-amount="{{ $result->amount }}"
                            data-amount-requested="{{ $result->amount_requested }}"
                            data-operation-id="{{ $result->id }}" data-operation-type="{{ $result->operation_type }}"
                            data-operation-number="{{ $result->operation_number }}"
                            data-seller-id="{{ $result->seller_id }}" data-seller-name="{{ $result->seller?->company_name }}"
                            data-issuer-name="{{ $result->issuer?->company_name }}"
                            id="single_operation_info_{{ $result->id }}"
                            class="group_operation_ids_{{ $result->seller_id }}" />
                        
                            <div class="cta_block">
                                @if ($result->mipo_verified == 'Yes')
                                <div class="select-dd">
                                    <div class="check_inputbox">
                                        <input type="checkbox" {{ $result->mipo_verified == 'Yes' ? 'checked' : '' }}
                                        id="is_mipo_cbox_{{ $result->id }}_dst"
                                        class="evt_is_mipo_plus"
                                        data-operation-id="{{ $result->id }}" data-seller-id="{{ $result->seller_id }}"
                                        name="is_mipo_plus"
                                        value="{{ $result->id }}"
                                        data-operation-id="{{ $result->id }}"
                                        data-screen-name="_dst"
                                        data-seller-id="{{ $result->seller_id }}">
                                        <label for="is_mipo_cbox_{{ $result->id }}_dst"><img src="{{ asset('images/mipo/bigplusmipo.png') }}" alt="no-image"></label>
                                    </div>
                                </div>
                                @endif

                                <div class="select-dd prize">
                                    <input type="text" {{ $result->operation_type == 'Cheque' ? 'disabled' : '' }}
                                    name="group_offer_retention"
                                    data-operation-amount="{{ $result->amount }}" placeholder="{!! __('Retention') !!}"
                                    id="offer_retention_{{ $result->id }}_dst"
                                    data-screen-name="_dst"
                                    class="text-16-medium explore_offer_input evt_validate_decimal evt_input" data-operation-id="{{ $result->id }}"
                                    data-seller-id="{{ $result->seller_id }}"
                                    data-currency-type="{{ $result->preferred_currency }}"
                                    >
                                    @if($result->preferred_currency == 'USD')
                                        <div class="imgbox"><img src="{{ asset('images/mipo/dlrpure.svg') }}" alt="no-image"></div>
                                    @else
                                        <div class="imgbox"><img src="{{ asset('images/mipo/sixteengurani.svg') }}" alt="no-image"></div>
                                    @endif
                                </div>

                                <div class="select-dd cash">
                                    <select
                                    name="counter_offer_payment_method"
                                    id="payment_method_{{ $result->id }}_dst"
                                    data-screen-name="_dst"
                                    class="form-select nice_selectbox selectbox text-16-medium dealmode_{{ $result->seller_id }} evt_change"
                                    data-operation-id="{{ $result->id }}"
                                    data-seller-id="{{ $result->seller_id }}">
                                        @if (config('constants.PREFERRED_MODE'))
                                            @foreach (config('constants.PREFERRED_MODE') as $key => $val)
                                                <option {{ $result->preferred_payment_method == $val ? 'selected' : '' }} value="{{ $val }}"> {{ __($key) }} </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="select-dd no">
                                    <input type="text" name="group_offer_day_hour" data-currency-type="{{ $result->preferred_currency }}" placeholder="{{ __('No.')}}" maxlength="2"
                                    id="day_hour_no_{{ $result->id }}_dst"
                                    data-screen-name="_dst"
                                    class="text-16-medium evt_validate_decimal day_hour_{{ $result->seller_id }} evt_input"  data-operation-id="{{ $result->id }}"
                                    data-seller-id="{{ $result->seller_id }}">
                                </div>

                                <div class="select-dd duration">
                                    <select name="hour" name="group_offer_hour" data-currency-type="{{ $result->preferred_currency }}" data-operation-id="{{ $result->id }}"
                                        data-seller-id="{{ $result->seller_id }}" id="sel_day_hour_{{ $result->id }}_dst"
                                        data-screen-name="_dst"
                                        class="form-select nice_selectbox selectbox text-16-medium hour_{{ $result->seller_id }} evt_change">
                                        <option value="hour">{{ __('Hours') }}</option>
                                        <option value="day">{{ __('Day') }}</option>
                                    </select>
                                </div>

                                <div class="select-dd prize">
                                    <input type="text" placeholder="{!! __('Offer') !!}" onkeyup="offerSummary(this)"
                                    data-screen-name="_dst"
                                    name="group_offer_amount" id="offer_amount_{{ $result->id }}_dst"
                                    data-operation-id="{{ $result->id }}" data-seller-id="{{ $result->seller_id }}"
                                    data-currency-type="{{ $result->preferred_currency }}"
                                    class="text-16-medium explore_offer_input evt_validate_decimal evt_input">
                                
                                    @if($result->preferred_currency == 'USD')
                                        <div class="imgbox"><img src="{{ asset('images/mipo/dlrpure.svg') }}" alt="no-image"></div>
                                    @else
                                        <div class="imgbox"><img src="{{ asset('images/mipo/sixteengurani.svg') }}" alt="no-image"></div>
                                    @endif

                                </div>

                                <div class="select-dd btnbox">
                                    <a href="javascript:;" class="text-16-medium" data-operation-id="{{ $result->id }}" data-seller-id="{{ $result->seller_id }}" onclick="sentOffer(this, {{ $result->id }}, '_dst')">{!! __('Offer') !!}</a>
                                </div>
                            </div>
                        @endif

                        <div class="share_export">
                            <a href="javascript:;" class="text-12-medium evt_share_btn" data-share-val="{{ route('explore-operations.details', $result->slug) }}"><i><img src="{{ asset('images/mipo/blueshare.svg') }}" alt="no-image"></i>{!! __('Share') !!}</a>
                            <a href="javascript:;" class="text-12-medium" data-bs-toggle="modal" data-bs-target="#exampleModal"><i><img src="{{ asset('images/mipo/blueexport.svg') }}" alt="no-image"></i>{!! __('Export') !!}</a>
                        </div>
                    </div>
                    
                    <div class="mobile_sharebox">
                        <div class="sharebox">
                            <img src="{{ asset('images/mipo/mobile_share.svg') }}" alt="no-image" class="evt_share_btn" data-share-val="{{ route('explore-operations.details', $result->slug) }}">
                        </div>
                    </div>
                </div>

                {{-- modal export :st--}}
                <div class="export_modal">
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title text-20-medium" id="exampleModalLabel">{!! __('Export Operation') !!}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="export_container">
                                       {{--  <div class="exportbox">
                                            <input class="hidden radio-label" type="radio" name="accept-offers" id="pdf" checked="checked">
                                            <label class="button-label" for="pdf">
                                                <div class="imgbox">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                                        <mask id="mask0_1368_40521" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="40" height="40">
                                                            <path d="M0 3.8147e-06H40V40H0V3.8147e-06Z" fill="white"/>
                                                        </mask>
                                                        <g mask="url(#mask0_1368_40521)">
                                                            <path d="M26.2503 1.17188H8.28125C6.98687 1.17188 5.9375 2.22125 5.9375 3.51563V36.4844C5.9375 37.7788 6.98687 38.8281 8.28125 38.8281H31.7188C33.0131 38.8281 34.0625 37.7788 34.0625 36.4844V8.98461L26.2503 1.17188Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M26.25 1.17188V8.98438H34.0625L26.25 1.17188Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M20.0002 19.6055L16.2148 26.1621H23.7856L20.0002 19.6055Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M20.0009 19.6055L21.748 16.5794C22.5246 15.2344 21.554 13.5532 20.0009 13.5532C18.4479 13.5532 17.4772 15.2344 18.2538 16.5794L20.0009 19.6055Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M23.7852 26.1625L25.5323 29.1886C26.3088 30.5335 28.25 30.5335 29.0265 29.1886C29.803 27.8437 28.8323 26.1625 27.2795 26.1625H23.7852Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M16.2138 26.1625L14.4667 29.1886C13.6902 30.5335 11.749 30.5335 10.9725 29.1886C10.196 27.8437 11.1666 26.1625 12.7195 26.1625H16.2138Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </g>
                                                    </svg>
                                                </div>
                                                <span class="text-18-medium">{!! __('XLS') !!}</span>
                                            </label>
                                        </div>
                                        <div class="exportbox">
                                            <input class="hidden radio-label" type="radio" name="accept-offers" id="xls">
                                            <label class="button-label" for="xls">
                                                <div class="imgbox">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                                        <mask id="mask0_1368_40543" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="40" height="40">
                                                            <path d="M0 3.8147e-06H40V40H0V3.8147e-06Z" fill="white"/>
                                                        </mask>
                                                        <g mask="url(#mask0_1368_40543)">
                                                            <path d="M26.2503 1.17188H8.28125C6.98687 1.17188 5.9375 2.22125 5.9375 3.51563V36.4844C5.9375 37.7788 6.98687 38.8281 8.28125 38.8281H31.7188C33.0131 38.8281 34.0625 37.7788 34.0625 36.4844V8.98461L26.2503 1.17188Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M26.0387 20L14 32.0387" stroke="#939393" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M14 20L26.0387 32.0387" stroke="#939393" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M26.25 1.17188V8.98438H34.0625L26.25 1.17188Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </g>
                                                        </svg>
                                                </div>
                                                <span class="text-18-medium">{!! __('XLS') !!}</span>
                                            </label>
                                        </div> --}}
                                        <div class="exportbox">
                                            <input class="hidden radio-label" type="radio" name="accept-offers" id="pdf_attach" checked="checked">
                                            <label class="button-label" for="pdf_attach">
                                                <div class="imgbox">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                                        <mask id="mask0_1368_40521" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="40" height="40">
                                                            <path d="M0 3.8147e-06H40V40H0V3.8147e-06Z" fill="white"/>
                                                        </mask>
                                                        <g mask="url(#mask0_1368_40521)">
                                                            <path d="M26.2503 1.17188H8.28125C6.98687 1.17188 5.9375 2.22125 5.9375 3.51563V36.4844C5.9375 37.7788 6.98687 38.8281 8.28125 38.8281H31.7188C33.0131 38.8281 34.0625 37.7788 34.0625 36.4844V8.98461L26.2503 1.17188Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M26.25 1.17188V8.98438H34.0625L26.25 1.17188Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M20.0002 19.6055L16.2148 26.1621H23.7856L20.0002 19.6055Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M20.0009 19.6055L21.748 16.5794C22.5246 15.2344 21.554 13.5532 20.0009 13.5532C18.4479 13.5532 17.4772 15.2344 18.2538 16.5794L20.0009 19.6055Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M23.7852 26.1625L25.5323 29.1886C26.3088 30.5335 28.25 30.5335 29.0265 29.1886C29.803 27.8437 28.8323 26.1625 27.2795 26.1625H23.7852Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M16.2138 26.1625L14.4667 29.1886C13.6902 30.5335 11.749 30.5335 10.9725 29.1886C10.196 27.8437 11.1666 26.1625 12.7195 26.1625H16.2138Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </g>
                                                    </svg>
                                                </div>
                                                <span class="text-18-medium">{!! __('PDF + Attachments') !!}</span>
                                            </label>
                                        </div>
                                       {{--  <div class="exportbox">
                                            <input class="hidden radio-label" type="radio" name="accept-offers" id="xls_attach">
                                            <label class="button-label" for="xls_attach">
                                                <div class="imgbox">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                                        <mask id="mask0_1368_40543" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="40" height="40">
                                                            <path d="M0 3.8147e-06H40V40H0V3.8147e-06Z" fill="white"/>
                                                        </mask>
                                                        <g mask="url(#mask0_1368_40543)">
                                                            <path d="M26.2503 1.17188H8.28125C6.98687 1.17188 5.9375 2.22125 5.9375 3.51563V36.4844C5.9375 37.7788 6.98687 38.8281 8.28125 38.8281H31.7188C33.0131 38.8281 34.0625 37.7788 34.0625 36.4844V8.98461L26.2503 1.17188Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M26.0387 20L14 32.0387" stroke="#939393" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M14 20L26.0387 32.0387" stroke="#939393" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M26.25 1.17188V8.98438H34.0625L26.25 1.17188Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </g>
                                                    </svg>
                                                </div>
                                                <span class="text-18-medium">{!! __('XLS + Attachments') !!}</span>
                                            </label>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="modal-footer ftrbn">
                                    <a href="javascript:;" class="cancel text-16-medium" data-bs-dismiss="modal" aria-label="Close">{!! __('Cancel') !!}</a>
                                    <a href="javascript:;" class="export text-16-medium evt_download_pdf_btn" data-href="{{ route('export.explore-operation-detail', $result->slug) }}"
                                        data-file-name="{{ $result->operation_number }}"
                                        >{!! __('Export') !!}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- modal export :st--}}
            
                @if(in_array($result->offers()->where('buyer_id', $buyer_id)->first()?->offer_status, ['Counter']) && $result->offers()->where('buyer_id', $buyer_id)->first()?->pivot->is_offered == 0)
                    {{-- counter offer accept reject :st --}}
                    @php
                        $offer = $result->offers()->where('buyer_id', $buyer_id)->first();
                        $counter_offers = $result->offers->first()->counter_offers->first();
                    @endphp
                    <div class="counterofr_acc_rej_wrap">
                        <div class="titlebox">
                            <span class="text-16-semibold"><i><img src="{{ asset('images/mipo/exclamation_circle.svg') }}" alt="no-image"></i>{!! __('Counter Offer') !!}</span>
                        </div>
                        <div class="counterofr_acc_rej">
                            <div class="sumry_item">
                                <div class="lft text-14-medium">{!! __('Retention') !!}</div>
                                <div class="rght text-14-medium"><span>{{ ($result->preferred_currency == 'USD') ?  $currency_type[0] :  $currency_type[1]  }} </span> 0.000</div>
                            </div>
                            <div class="sumry_item">
                                <div class="lft text-14-medium">{!! __('Payment Method') !!}</div>
                                <div class="rght text-14-medium"><span>{!! __($counter_offers->preferred_payment_method ?? '') !!}</div>
                            </div>
                            <div class="sumry_item">
                                <div class="lft text-14-medium">{!! __('Offer Period') !!}</div>
                                <div class="rght text-14-medium"><span>{!! __('Expires in') !!} {{ __($counter_offers->counter_offer_expire_hour ?? 'N/A') }} {{ __('Hours') }}</div>
                            </div>
                            <div class="sumry_item">
                                <div class="lft text-14-medium">{!! __('Offer Ammount') !!}</div>
                                <div class="rght text-14-medium"><span>{{ ($result->preferred_currency == 'USD') ? $currency_type[0] :  $currency_type[1]  }}</span>
                                    {{ app('common')->currencyNumberFormat($result->preferred_currency, $counter_offers->amount ?? '0') }}
                                </div> 
                            </div>
                            <div class="sumry_item">
                                <div class="lft text-16-medium">{!! __('Mipo') !!}+</div>
                                <div class="rght text-16-medium"><span>{{ __($result->offers()->where('buyer_id', $buyer_id)->first()?->is_mipo_plus ?? 'No') }}</div>
                            </div>
                            <div class="accept_rejectbox">
                                <a href="javascript:;" class="text-16-medium accept evt_change_status" data-offer-id="{{ $offer->id }}" data-status="Approved">{!! __('Accept') !!}</a>
                                <a href="javascript:;" class="text-16-medium reject evt_change_status" data-offer-id="{{ $offer->id }}" data-status="Rejected">{!! __('Reject') !!}</a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- involed parties:st --}}
                <div class="involved_parties_wrap">
                    <div class="titlebox">
                        <h3 class="text-20-medium">{!! __('Involved Parties') !!}</h3>
                    </div>
                
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="partibox">
                                <div class="parti_inner">
                                    <div class="leftpart">
                                        <div class="imgwith_txt">
                                            <div class="imgbox"><img src="{{ $result->seller->profile_image_url }}" alt="no-image"></div>
                                            <div class="info">
                                                <h3 class="text-18-medium">{{ app('common')->lockOperationDetail($result, ['seller_name']) }}</h3>
                                                <a href="{{ route('profile.public-seller', $result->seller?->slug) }}" class="text-14-medium">{!! __('Seller of Document') !!}</a>
                                                <span class="text-12-medium">
                                                    {{ app('common')->lockOperationDetail($result, ['seller_ruc']) }}
                                                    {{-- {{ $result->seller?->issuer?->ruc_code ?? 'N/A' }} --}}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rightpart">
                                        <ul>
                                            <li><i><img src="{{ app('common')->userLevelImage($result->seller->user_level) }}" alt="no-image"></i></li>

                                            @if ($result->seller->address_verify == 'Yes')
                                                <li><i><img src="{{ asset('images/mipo/address-verified.svg') }}" alt="no-image"></i></li>
                                            @endif

                                            <li><i>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20" fill="none">
                                                    <path d="M14.9993 11.875H15.6243V16.5625C15.6243 16.8369 15.5522 17.1064 15.415 17.344L14.874 17.031C14.9562 16.8885 14.9994 16.727 14.9993 16.5625V11.875ZM15.6243 7.1875V2.8125C15.6236 2.23254 15.3929 1.67652 14.9828 1.26642C14.5727 0.856329 14.0167 0.625651 13.4368 0.625H4.68677C4.30617 0.624843 3.93863 0.763762 3.65329 1.01563L4.06681 1.48438C4.23797 1.33327 4.45845 1.24992 4.68677 1.25H13.4368C13.851 1.25047 14.2482 1.41523 14.5411 1.70816C14.834 2.00108 14.9988 2.39824 14.9993 2.8125V7.1875H15.6243ZM13.7493 6.875V5.625H11.8743C11.46 5.62453 11.0629 5.45977 10.7699 5.16684C10.477 4.87392 10.3122 4.47676 10.3118 4.0625V2.5H3.43677C3.18822 2.50029 2.94993 2.59915 2.77417 2.77491C2.59842 2.95066 2.49956 3.18895 2.49927 3.4375V11.875H1.87427V3.4375C1.87473 3.02324 2.0395 2.62608 2.33243 2.33316C2.62535 2.04023 3.02251 1.87547 3.43677 1.875H10.6243C10.702 1.87501 10.777 1.90398 10.8345 1.95625L14.272 5.08125C14.3042 5.11054 14.33 5.14625 14.3476 5.18607C14.3652 5.22589 14.3743 5.26896 14.3743 5.3125V6.875H13.7493ZM13.2534 5L10.9368 2.89391V4.0625C10.9371 4.31105 11.0359 4.54934 11.2117 4.72509C11.3874 4.90085 11.6257 4.99971 11.8743 5H13.2534ZM13.7493 17.8125C13.749 18.0611 13.6501 18.2993 13.4744 18.4751C13.2986 18.6508 13.0603 18.7497 12.8118 18.75H3.43677C3.18822 18.7497 2.94993 18.6508 2.77417 18.4751C2.59842 18.2993 2.49956 18.0611 2.49927 17.8125V16.25H1.87427V17.8125C1.87473 18.2268 2.0395 18.6239 2.33243 18.9168C2.62535 19.2098 3.02251 19.3745 3.43677 19.375H12.8118C13.226 19.3745 13.6232 19.2098 13.9161 18.9168C14.209 18.6239 14.3738 18.2268 14.3743 17.8125V11.5625H13.7493V17.8125ZM4.68677 8.4375V9.0625H6.24927V8.4375H4.68677ZM4.06177 8.4375H3.43677V9.0625H4.06177V8.4375ZM4.68677 10.3125H6.56177V9.6875H4.68677V10.3125ZM4.06177 9.6875H3.43677V10.3125H4.06177V9.6875ZM4.68677 11.5625H6.87427V10.9375H4.68677V11.5625ZM3.43677 11.5625H4.06177V10.9375H3.43677V11.5625ZM10.3118 12.8125H10.9368V12.1875H10.3118V12.8125ZM13.1243 12.1875H11.5618V12.8125H13.1243V12.1875ZM10.3118 14.0625H10.9368V13.4375H10.3118V14.0625ZM11.5618 14.0625H13.1243V13.4375H11.5618V14.0625ZM11.5618 15.3125H13.1243V14.6875H11.5618V15.3125ZM10.3118 15.9375V16.5625H10.9368V15.9375H10.3118ZM11.5618 16.5625H13.1243V15.9375H11.5618V16.5625ZM7.18677 7.1875H3.43677V7.8125H7.18677V7.1875ZM9.06177 17.8125H13.1243V17.1875H9.06177V17.8125ZM3.43677 17.8125H6.87427V17.1875H3.43677V17.8125ZM7.18677 6.5625H8.43677V5.9375H7.18677V6.5625ZM9.99927 4.6875H7.18677V5.3125H9.99927V4.6875ZM3.59302 6.5625C3.55158 6.5625 3.51183 6.54604 3.48253 6.51674C3.45323 6.48743 3.43677 6.44769 3.43677 6.40625V4.375C3.43677 4.31697 3.45293 4.26008 3.48344 4.21072C3.51395 4.16136 3.5576 4.12146 3.6095 4.09551L4.8595 3.47051C4.9029 3.44881 4.95075 3.43751 4.99927 3.43751C5.04779 3.43751 5.09564 3.44881 5.13903 3.47051L6.38903 4.09551C6.44094 4.12146 6.48459 4.16136 6.5151 4.21072C6.54561 4.26008 6.56177 4.31697 6.56177 4.375V6.40625C6.56177 6.44769 6.54531 6.48743 6.516 6.51674C6.4867 6.54604 6.44696 6.5625 6.40552 6.5625H3.59302ZM5.93677 5.3125H5.31177V5.9375H5.93677V5.3125ZM4.06177 4.6875H5.93677V4.56813L4.99927 4.09938L4.06177 4.56813V4.6875ZM4.06177 5.9375H4.68677V5.3125H4.06177V5.9375ZM17.4993 12.1875C17.4993 12.4638 17.1553 12.598 16.9658 12.4085C16.5005 11.9407 15.9471 11.5698 15.3375 11.3173C14.728 11.0648 14.0744 10.9357 13.4146 10.9375H9.99927V11.875C9.99926 11.9384 9.97999 12.0002 9.94401 12.0524C9.90803 12.1046 9.85704 12.1445 9.79781 12.1671C9.73858 12.1896 9.6739 12.1936 9.61236 12.1785C9.55082 12.1634 9.49531 12.1299 9.45321 12.0826L6.95321 9.27008C6.90238 9.21288 6.87431 9.13902 6.87431 9.0625C6.87431 8.98598 6.90238 8.91212 6.95321 8.85492L9.45321 6.04242C9.49531 5.99506 9.55082 5.96162 9.61236 5.94654C9.6739 5.93145 9.73858 5.93543 9.79781 5.95794C9.85704 5.98046 9.90803 6.02045 9.94401 6.07261C9.97999 6.12477 9.99926 6.18663 9.99927 6.25V7.1875H12.4993C13.8249 7.18901 15.0958 7.71628 16.0331 8.65363C16.9705 9.59099 17.4978 10.8619 17.4993 12.1875ZM16.8118 11.4472C16.6358 10.4306 16.1068 9.50873 15.318 8.84385C14.5291 8.17898 13.5309 7.81376 12.4993 7.8125H9.68677C9.60389 7.8125 9.5244 7.77958 9.4658 7.72097C9.40719 7.66237 9.37427 7.58288 9.37427 7.5V7.07195L7.60474 9.0625L9.37427 11.053V10.625C9.37427 10.5421 9.40719 10.4626 9.4658 10.404C9.5244 10.3454 9.60389 10.3125 9.68677 10.3125H13.4146C14.6406 10.309 15.834 10.7076 16.8118 11.4472ZM4.99927 16.5625C3.67365 16.561 2.40276 16.0337 1.4654 15.0964C0.528046 14.159 0.000777031 12.8881 -0.000732422 11.5625C-0.000734674 11.5007 0.017592 11.4403 0.0519298 11.3889C0.0862676 11.3375 0.135074 11.2974 0.192177 11.2738C0.249281 11.2501 0.312116 11.2439 0.372736 11.256C0.433357 11.2681 0.48904 11.2978 0.532744 11.3415C0.998006 11.8093 1.55144 12.1802 2.161 12.4327C2.77057 12.6852 3.42417 12.8143 4.08395 12.8125H7.49927V11.875C7.49928 11.8116 7.51855 11.7498 7.55453 11.6976C7.59051 11.6454 7.6415 11.6055 7.70073 11.5829C7.75996 11.5604 7.82463 11.5564 7.88618 11.5715C7.94772 11.5866 8.00322 11.6201 8.04532 11.6674L10.5453 14.4799C10.5962 14.5371 10.6242 14.611 10.6242 14.6875C10.6242 14.764 10.5962 14.8379 10.5453 14.8951L8.04532 17.7076C8.00322 17.7549 7.94772 17.7884 7.88618 17.8035C7.82463 17.8186 7.75996 17.8146 7.70073 17.7921C7.6415 17.7695 7.59051 17.7296 7.55453 17.6774C7.51855 17.6252 7.49928 17.5634 7.49927 17.5V16.5625H4.99927ZM4.99927 15.9375H7.81177C7.89465 15.9375 7.97413 15.9704 8.03274 16.029C8.09134 16.0876 8.12427 16.1671 8.12427 16.25V16.678L9.8938 14.6875L8.12427 12.697V13.125C8.12427 13.2079 8.09134 13.2874 8.03274 13.346C7.97413 13.4046 7.89465 13.4375 7.81177 13.4375H4.08395C2.85793 13.441 1.66457 13.0424 0.686768 12.3028C0.862717 13.3194 1.3917 14.2413 2.18056 14.9061C2.96943 15.571 3.96759 15.9362 4.99927 15.9375Z" fill="#000"/>
                                                </svg>
                                            </i>
                                                <div class="upnumbox">
                                                    <div class="num">{{ $result->supportingAttachments->count() + $result->documents->count() }}</div>
                                                </div>
                                            </li>

                                            @if($result->mipo_verified == 'Yes')
                                            <li><img src="{{ asset('images/mipo/opdetail_mplus.png') }}" alt="no-image"></li>
                                            @endif
                                        </ul>
                                        <div class="str_rating">
                                            <div class="imgbox"><img src="{{ asset('images/mipo/singleOnestar.png') }}" alt="no-image"></div>
                                            <span class="text-12-medium">{{ floor($result->seller?->ratings_avg_rating_number) }}/5 ({{ ($result->seller?->ratings_count) }})</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="whattakes">
                                    <ul>
                                        @if ($result->bcp != '0' && !is_null($result->bcp))
                                        <li>
                                            <div class="pcap {{ $result->bcp == '2' ? 'redwarning' : '' }}">
                                                @if(($result->bcp == '2'))
                                                    <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                                @else
                                                    <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                                @endif
                                                <span class="text-12-medium">{!! __('BCP') !!}</span>
                                            </div>
                                        </li>
                                        @endif
                                        @if ($result->inforconf != '0' && !is_null($result->inforconf))
                                        <li>
                                            <div class="pcap {{ $result->inforconf == '2' ? 'redwarning' : '' }}">
                                                @if(($result->inforconf == '2'))
                                                    <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                                @else
                                                    <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                                @endif
                                                <span class="text-12-medium">{!! __('Inforconf') !!}</span>
                                            </div>
                                        </li>
                                        @endif
                                        @if ($result->infocheck != '0' && !is_null($result->infocheck))
                                        <li>
                                            <div class="pcap {{ $result->infocheck == '2' ? 'redwarning' : '' }}">
                                                @if(($result->infocheck == '2'))
                                                    <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                                @else
                                                    <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                                @endif
                                                <span class="text-12-medium">{!! __('Infocheck') !!}</span>
                                            </div>
                                        </li>
                                        @endif
                                        @if ($result->criterium != '0' && !is_null($result->criterium))
                                        <li>
                                            <div class="pcap {{ $result->criterium == '2' ? 'redwarning' : '' }}">
                                                @if(($result->criterium == '2'))
                                                    <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                                @else
                                                    <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                                @endif
                                                <span class="text-12-medium">{!! __('Criterium') !!}</span>
                                            </div>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                                <a href="{{ route('profile.public-seller', $result->seller?->slug) }}" class="full_link"></a>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="partibox">
                                <div class="parti_inner">
                                    <div class="leftpart">
                                        <div class="imgwith_txt">
                                            <div class="imgbox"><img src="{{ $result->issuer->company_image_url }}" alt="no-image"></div>
                                            <div class="info">
                                                <h3 class="text-18-medium">{!! __($result->issuer?->company_name) !!}</h3>
                                                <a href="{{ route('profile.public-payer-profile', $result->issuer?->slug) }}" class="text-14-medium">{!! __('Payer of Document') !!}</a>
                                                <span class="text-12-medium">
                                                    {!! __($result->issuer?->ruc_code) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rightpart">
                                        <div class="rightpart">
                                            <ul>
                                                {{-- <li><i><img src="{{ asset('images/mipo/gold.svg') }}" alt="no-image"></i></li> --}}
                                                @if($result->issuer->verified_address == 'Yes')
                                                <li><i><img src="{{ asset('images/mipo/address-verified.svg') }}" alt="no-image"></i></li>
                                                @endif
                                                {{-- <li><i>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20" fill="none">
                                                        <path d="M14.9993 11.875H15.6243V16.5625C15.6243 16.8369 15.5522 17.1064 15.415 17.344L14.874 17.031C14.9562 16.8885 14.9994 16.727 14.9993 16.5625V11.875ZM15.6243 7.1875V2.8125C15.6236 2.23254 15.3929 1.67652 14.9828 1.26642C14.5727 0.856329 14.0167 0.625651 13.4368 0.625H4.68677C4.30617 0.624843 3.93863 0.763762 3.65329 1.01563L4.06681 1.48438C4.23797 1.33327 4.45845 1.24992 4.68677 1.25H13.4368C13.851 1.25047 14.2482 1.41523 14.5411 1.70816C14.834 2.00108 14.9988 2.39824 14.9993 2.8125V7.1875H15.6243ZM13.7493 6.875V5.625H11.8743C11.46 5.62453 11.0629 5.45977 10.7699 5.16684C10.477 4.87392 10.3122 4.47676 10.3118 4.0625V2.5H3.43677C3.18822 2.50029 2.94993 2.59915 2.77417 2.77491C2.59842 2.95066 2.49956 3.18895 2.49927 3.4375V11.875H1.87427V3.4375C1.87473 3.02324 2.0395 2.62608 2.33243 2.33316C2.62535 2.04023 3.02251 1.87547 3.43677 1.875H10.6243C10.702 1.87501 10.777 1.90398 10.8345 1.95625L14.272 5.08125C14.3042 5.11054 14.33 5.14625 14.3476 5.18607C14.3652 5.22589 14.3743 5.26896 14.3743 5.3125V6.875H13.7493ZM13.2534 5L10.9368 2.89391V4.0625C10.9371 4.31105 11.0359 4.54934 11.2117 4.72509C11.3874 4.90085 11.6257 4.99971 11.8743 5H13.2534ZM13.7493 17.8125C13.749 18.0611 13.6501 18.2993 13.4744 18.4751C13.2986 18.6508 13.0603 18.7497 12.8118 18.75H3.43677C3.18822 18.7497 2.94993 18.6508 2.77417 18.4751C2.59842 18.2993 2.49956 18.0611 2.49927 17.8125V16.25H1.87427V17.8125C1.87473 18.2268 2.0395 18.6239 2.33243 18.9168C2.62535 19.2098 3.02251 19.3745 3.43677 19.375H12.8118C13.226 19.3745 13.6232 19.2098 13.9161 18.9168C14.209 18.6239 14.3738 18.2268 14.3743 17.8125V11.5625H13.7493V17.8125ZM4.68677 8.4375V9.0625H6.24927V8.4375H4.68677ZM4.06177 8.4375H3.43677V9.0625H4.06177V8.4375ZM4.68677 10.3125H6.56177V9.6875H4.68677V10.3125ZM4.06177 9.6875H3.43677V10.3125H4.06177V9.6875ZM4.68677 11.5625H6.87427V10.9375H4.68677V11.5625ZM3.43677 11.5625H4.06177V10.9375H3.43677V11.5625ZM10.3118 12.8125H10.9368V12.1875H10.3118V12.8125ZM13.1243 12.1875H11.5618V12.8125H13.1243V12.1875ZM10.3118 14.0625H10.9368V13.4375H10.3118V14.0625ZM11.5618 14.0625H13.1243V13.4375H11.5618V14.0625ZM11.5618 15.3125H13.1243V14.6875H11.5618V15.3125ZM10.3118 15.9375V16.5625H10.9368V15.9375H10.3118ZM11.5618 16.5625H13.1243V15.9375H11.5618V16.5625ZM7.18677 7.1875H3.43677V7.8125H7.18677V7.1875ZM9.06177 17.8125H13.1243V17.1875H9.06177V17.8125ZM3.43677 17.8125H6.87427V17.1875H3.43677V17.8125ZM7.18677 6.5625H8.43677V5.9375H7.18677V6.5625ZM9.99927 4.6875H7.18677V5.3125H9.99927V4.6875ZM3.59302 6.5625C3.55158 6.5625 3.51183 6.54604 3.48253 6.51674C3.45323 6.48743 3.43677 6.44769 3.43677 6.40625V4.375C3.43677 4.31697 3.45293 4.26008 3.48344 4.21072C3.51395 4.16136 3.5576 4.12146 3.6095 4.09551L4.8595 3.47051C4.9029 3.44881 4.95075 3.43751 4.99927 3.43751C5.04779 3.43751 5.09564 3.44881 5.13903 3.47051L6.38903 4.09551C6.44094 4.12146 6.48459 4.16136 6.5151 4.21072C6.54561 4.26008 6.56177 4.31697 6.56177 4.375V6.40625C6.56177 6.44769 6.54531 6.48743 6.516 6.51674C6.4867 6.54604 6.44696 6.5625 6.40552 6.5625H3.59302ZM5.93677 5.3125H5.31177V5.9375H5.93677V5.3125ZM4.06177 4.6875H5.93677V4.56813L4.99927 4.09938L4.06177 4.56813V4.6875ZM4.06177 5.9375H4.68677V5.3125H4.06177V5.9375ZM17.4993 12.1875C17.4993 12.4638 17.1553 12.598 16.9658 12.4085C16.5005 11.9407 15.9471 11.5698 15.3375 11.3173C14.728 11.0648 14.0744 10.9357 13.4146 10.9375H9.99927V11.875C9.99926 11.9384 9.97999 12.0002 9.94401 12.0524C9.90803 12.1046 9.85704 12.1445 9.79781 12.1671C9.73858 12.1896 9.6739 12.1936 9.61236 12.1785C9.55082 12.1634 9.49531 12.1299 9.45321 12.0826L6.95321 9.27008C6.90238 9.21288 6.87431 9.13902 6.87431 9.0625C6.87431 8.98598 6.90238 8.91212 6.95321 8.85492L9.45321 6.04242C9.49531 5.99506 9.55082 5.96162 9.61236 5.94654C9.6739 5.93145 9.73858 5.93543 9.79781 5.95794C9.85704 5.98046 9.90803 6.02045 9.94401 6.07261C9.97999 6.12477 9.99926 6.18663 9.99927 6.25V7.1875H12.4993C13.8249 7.18901 15.0958 7.71628 16.0331 8.65363C16.9705 9.59099 17.4978 10.8619 17.4993 12.1875ZM16.8118 11.4472C16.6358 10.4306 16.1068 9.50873 15.318 8.84385C14.5291 8.17898 13.5309 7.81376 12.4993 7.8125H9.68677C9.60389 7.8125 9.5244 7.77958 9.4658 7.72097C9.40719 7.66237 9.37427 7.58288 9.37427 7.5V7.07195L7.60474 9.0625L9.37427 11.053V10.625C9.37427 10.5421 9.40719 10.4626 9.4658 10.404C9.5244 10.3454 9.60389 10.3125 9.68677 10.3125H13.4146C14.6406 10.309 15.834 10.7076 16.8118 11.4472ZM4.99927 16.5625C3.67365 16.561 2.40276 16.0337 1.4654 15.0964C0.528046 14.159 0.000777031 12.8881 -0.000732422 11.5625C-0.000734674 11.5007 0.017592 11.4403 0.0519298 11.3889C0.0862676 11.3375 0.135074 11.2974 0.192177 11.2738C0.249281 11.2501 0.312116 11.2439 0.372736 11.256C0.433357 11.2681 0.48904 11.2978 0.532744 11.3415C0.998006 11.8093 1.55144 12.1802 2.161 12.4327C2.77057 12.6852 3.42417 12.8143 4.08395 12.8125H7.49927V11.875C7.49928 11.8116 7.51855 11.7498 7.55453 11.6976C7.59051 11.6454 7.6415 11.6055 7.70073 11.5829C7.75996 11.5604 7.82463 11.5564 7.88618 11.5715C7.94772 11.5866 8.00322 11.6201 8.04532 11.6674L10.5453 14.4799C10.5962 14.5371 10.6242 14.611 10.6242 14.6875C10.6242 14.764 10.5962 14.8379 10.5453 14.8951L8.04532 17.7076C8.00322 17.7549 7.94772 17.7884 7.88618 17.8035C7.82463 17.8186 7.75996 17.8146 7.70073 17.7921C7.6415 17.7695 7.59051 17.7296 7.55453 17.6774C7.51855 17.6252 7.49928 17.5634 7.49927 17.5V16.5625H4.99927ZM4.99927 15.9375H7.81177C7.89465 15.9375 7.97413 15.9704 8.03274 16.029C8.09134 16.0876 8.12427 16.1671 8.12427 16.25V16.678L9.8938 14.6875L8.12427 12.697V13.125C8.12427 13.2079 8.09134 13.2874 8.03274 13.346C7.97413 13.4046 7.89465 13.4375 7.81177 13.4375H4.08395C2.85793 13.441 1.66457 13.0424 0.686768 12.3028C0.862717 13.3194 1.3917 14.2413 2.18056 14.9061C2.96943 15.571 3.96759 15.9362 4.99927 15.9375Z" fill="#000"/>
                                                    </svg>
                                                </i>
                                                    <div class="upnumbox">
                                                        <div class="num">2</div>
                                                    </div>
                                                </li> --}}
                                                @if($result->issuer->registry_in_mipo == 'Yes')
                                                <li><img src="{{ asset('images/mipo/opdetail_mplus.png') }}" alt="no-image"></li>
                                                @endif
                                            </ul>
                                            <div class="str_rating">
                                                <div class="imgbox"><img src="{{ asset('images/mipo/singleOnestar.png') }}" alt="no-image"></div>
                                                <span class="text-12-medium">{{ floor($result->issuer?->ratings_avg_rating_number) }}/5 ({{ ($result->issuer?->ratings_count) }})</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="whattakes">
                                    <ul>
                                        @if ($result->issuer->bcp != '0' && !is_null($result->issuer->bcp))
                                        <li>
                                            <div class="pcap {{ $result->issuer->bcp == '2' ? 'redwarning' : '' }}">
                                                @if(($result->issuer->bcp == '2'))
                                                    <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                                @else
                                                    <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                                @endif
                                                <span class="text-12-medium">{!! __('BCP') !!}</span>
                                            </div>
                                        </li>
                                        @endif
                                        @if ($result->issuer->inforconf != '0' && !is_null($result->issuer->inforconf))
                                        <li>
                                            <div class="pcap {{ $result->issuer->inforconf == '2' ? 'redwarning' : '' }}">
                                                @if(($result->issuer->inforconf == '2'))
                                                    <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                                @else
                                                    <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                                @endif
                                                <span class="text-12-medium">{!! __('Inforconf') !!}</span>
                                            </div>
                                        </li>
                                        @endif
                                        @if ($result->issuer->infocheck != '0' && !is_null($result->issuer->infocheck))
                                        <li>
                                            <div class="pcap {{ $result->issuer->infocheck == '2' ? 'redwarning' : '' }}">
                                                @if(($result->issuer->infocheck == '2'))
                                                <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                                @else
                                                    <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                                @endif
                                                <span class="text-12-medium">{!! __('Infocheck') !!}</span>
                                            </div>
                                        </li>
                                        @endif
                                        @if ($result->issuer->criterium != '0' && !is_null($result->issuer->criterium))
                                        <li>
                                            <div class="pcap {{ $result->issuer->criterium == '2' ? 'redwarning' : '' }}">
                                                @if(($result->issuer->criterium == '2'))
                                                <i><img  src="{{ asset('images/mipo/redclose.png') }}" alt="no-image"></i>
                                                @else
                                                    <i><img src="{{ asset('images/mipo/greencheck.png') }}" alt="no-image"></i>
                                                @endif
                                                <span class="text-12-medium">{!! __('Criterium') !!}</span>
                                            </div>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                                <a href="{{ route('profile.public-payer-profile', $result->issuer?->slug) }}" class="full_link"></a>
                            </div>
                        </div>
                    </div>
                </div>
                @if(!in_array($result->offers()->where('buyer_id', $buyer_id)->first()?->offer_status, ['Approved', 'Completed', null]))
                    @if($result->offers()->where('buyer_id', $buyer_id)->first()->offer_type == 'Group' && $result->offers()->where('buyer_id', $buyer_id)->first()->offer_status == 'Counter')
                        <div class="attention_wrap">
                            <div class="titlebox">
                                <span class="text-16-semibold"><i><img src="{{ asset('images/mipo/exclamation_circle.svg') }}" alt="no-image"></i>{!! __('Counter Offer') !!}</span>
                            </div>
                            <div class="attentionbox">
                                <p class="text-16-medium">{!! __('This offer is included in a group offer. If you wish to send a single offer to the seller, you’ll need to revert te group offer and send a single offer to this operation.') !!}</p>
                                <div class="preofr"><a href="#prev_offer_target" class="text-16-medium">{!! __('Previous Offers') !!}</a></div>
                            </div>
                        </div>
                    @endif
                @endif

                {{-- document information :st --}}
                <div class="documentinfo_wrap">
                    <div class="titlebox">
                        <h3 class="text-20-medium">{!! __('Document Information') !!}</h3>
                    </div>
                    <div class="row">
                        @if(!empty($result->operation_type))
                        <div class="col-lg-3 col-md-6">
                            <div class="docinfo_box">
                                <div class="title">
                                    <p class="text-14-medium">{{ ($result->operation_type == 'Cheque') ? __('Check') : __($result->operation_type) }}</p>
                                </div>
                                <div class="info text-14-medium">{!! __('Type of Document') !!}</div>
                            </div>
                        </div>
                        @endif
                        @if(!empty($result->responsibility))
                        <div class="col-lg-3 col-md-6">
                            <div class="docinfo_box">
                                <div class="title">
                                    <p class="text-14-medium">{!! app('common')->responsibility($result->responsibility) !!}</p>
                                </div>
                                <div class="info text-14-medium">{!! __('With or Without Recurso') !!}</div>
                            </div>
                        </div>
                        @endif
                        @if(!empty($result->preferred_payment_method))
                        <div class="col-lg-3 col-md-6">
                            <div class="docinfo_box">
                                <div class="title"><p class="text-14-medium">{!! __($result->preferred_payment_method) !!}</p></div>
                                <div class="info text-14-medium">{!! __('Payment Preferences') !!}</div>
                            </div>
                        </div>
                        @endif
                        @if ($result->operation_type == 'Invoice')
                            @if(!empty($result->invoice_type))
                                <div class="col-lg-3 col-md-6">
                                    <div class="docinfo_box">
                                        <div class="title"><p class="text-14-medium">{!! __($result->invoice_type) !!}</p></div>
                                        <div class="info text-14-medium">{!! __('Type of Invoice') !!}</div>
                                    </div>
                                </div>
                            @endif
                        @endif

                        @if ($result->operation_type == 'Contract' || $result->operation_type == 'Other')
                            @if(!empty($result->is_government_contract))
                                <div class="col-lg-3 col-md-6">
                                    <div class="docinfo_box">
                                        <div class="title"><p class="text-14-medium">{!! __($result->is_government_contract) !!}</p></div>
                                        <div class="info text-14-medium">{!! __('Comercial or State Type') !!}</div>
                                    </div>
                                </div>
                            @endif
                        @endif

                        @if ($result->operation_type == 'Cheque')
                            @if($result->cheque_status != '' || $result->cheque_type != '' || $result->cheque_payee_type != '')
                                <div class="col-lg-3 col-md-6">
                                    <div class="docinfo_box mobile_hide_doc">
                                        <div class="iconwrap">
                                            @if (!is_null($result->cheque_status) && $result->cheque_status != '')
                                            <div class="insubox">
                                                <i>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                        <rect width="18" height="18" fill="white"/>
                                                        <path d="M8.88861 14.4304H3.16977C2.49974 14.4304 1.95312 13.8838 1.95312 13.2137V5.30845C1.95312 4.63841 2.49974 4.0918 3.16977 4.0918H13.332C14.0021 4.0918 14.5487 4.63841 14.5487 5.30845V10.0722" stroke="black" stroke-miterlimit="10" stroke-linecap="round"/>
                                                        <path d="M11.6562 1.89453V4.09273" stroke="black" stroke-miterlimit="10" stroke-linecap="round"/>
                                                        <path d="M4.85938 1.89453V4.09273" stroke="black" stroke-miterlimit="10" stroke-linecap="round"/>
                                                        <path d="M1.95312 6.84961H14.5546" stroke="black" stroke-miterlimit="10"/>
                                                        <path d="M13.0486 16.212C13.321 16.1664 13.5048 15.9086 13.4592 15.6363C13.4135 15.3639 13.1558 15.1801 12.8834 15.2257L13.0486 16.212ZM12.8834 15.2257C11.8787 15.394 10.9279 14.7159 10.7596 13.7112L9.77336 13.8764C10.0329 15.4258 11.4992 16.4715 13.0486 16.212L12.8834 15.2257ZM10.7596 13.7112C10.5914 12.7066 11.2694 11.7557 12.2741 11.5874L12.1089 10.6012C10.5595 10.8607 9.51387 12.327 9.77336 13.8764L10.7596 13.7112ZM12.2741 11.5874C13.2788 11.4192 14.2296 12.0972 14.3979 13.1019L15.3842 12.9367C15.1247 11.3874 13.6583 10.3417 12.1089 10.6012L12.2741 11.5874ZM14.3979 13.1019C14.3992 13.1095 14.4091 13.1686 14.4188 13.2259C14.4236 13.2548 14.4285 13.2836 14.4322 13.3061C14.4366 13.3323 14.4382 13.342 14.4378 13.3398L15.4271 13.1934C15.4239 13.1721 15.3855 12.9447 15.3842 12.9367L14.3979 13.1019Z" fill="black"/>
                                                        <path d="M13.1565 13.0994L14.9358 13.2659L16.0508 11.5879" stroke="black" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </i>
                                                <span class="text-12-medium">{!! __('Difered') !!}</span>
                                            </div>
                                            @endif
                                            @if (!is_null($result->cheque_type) && $result->cheque_type != '')
                                            <div class="insubox">
                                                <i>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                        <rect width="16" height="16" fill="white"/>
                                                        <path d="M0.625 14.332C3.4025 12.6654 4.79167 10.9987 4.79167 9.33203C4.79167 6.83203 3.95833 6.83203 3.125 6.83203C2.29167 6.83203 1.43167 7.7362 1.45833 9.33203C1.48667 11.0387 2.84 11.7295 3.54167 12.6654C4.79167 14.332 5.625 14.7487 6.45833 13.4987C7.01417 12.6654 7.43084 11.9712 7.70834 11.4154C8.54167 13.3595 9.6525 14.332 11.0417 14.332H13.125" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M14.7904 12.6667V2.66667C14.7904 1.7325 14.0579 1 13.1237 1C12.1895 1 11.457 1.7325 11.457 2.66667V12.6667L13.1237 14.3333L14.7904 12.6667Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M11.457 4.33203H14.7904" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </i>
                                                <span class="text-12-medium">{!! __('Crossed') !!}</span>
                                            </div>
                                            @endif
                                            @if (!is_null($result->cheque_payee_type) && $result->cheque_payee_type != '')
                                            <div class="insubox">
                                                <i>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                        <rect width="18" height="18" fill="white"/>
                                                        <path d="M10.625 2V5.11111C10.625 5.31739 10.7069 5.51522 10.8528 5.66108C10.9987 5.80694 11.1965 5.88889 11.4028 5.88889H14.5139" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M12.9583 16H5.18056C4.768 16 4.37233 15.8361 4.08061 15.5444C3.78889 15.2527 3.625 14.857 3.625 14.4444V3.55556C3.625 3.143 3.78889 2.74733 4.08061 2.45561C4.37233 2.16389 4.768 2 5.18056 2H10.625L14.5139 5.88889V14.4444C14.5139 14.857 14.35 15.2527 14.0583 15.5444C13.7666 15.8361 13.3709 16 12.9583 16Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </i>
                                                <span class="text-12-medium">{!! __('To The Carrier') !!}</span>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="info text-14-medium">{!! __('Check Details') !!}</div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        
                        @if(!empty($result->amount))
                        <div class="col-lg-3 col-md-6">    
                            <div class="docinfo_box">
                                <div class="title">
                                    <p class="text-14-medium">{!! __($result->preferred_currency) !!}
                                    {{ app('common')->currencyNumberFormat($result->preferred_currency, $result->amount) }}</p>
                                </div>
                                <div class="info text-14-medium">
                                    @if ($result->operation_type == 'Cheque')
                                        {!! __('Nominal Value of Check') !!}
                                    @else
                                        {!! __('Document’s Nominal Value') !!}
                                    @endif
                                </div>
                            </div>
                        </div> 
                        @endif 
                        @if(!empty($result->issuance_date_iso))
                        <div class="col-lg-3 col-md-6">  
                            <div class="docinfo_box">
                                <div class="title"><p class="text-14-medium">{!! __($result->issuance_date_iso) !!}</p></div>
                                <div class="info text-14-medium">{!! __('Date of Emission') !!}</div>
                            </div>
                        </div>
                        @endif
                        @if(!empty($result->expire_date_iso))
                        <div class="col-lg-3 col-md-6">  
                            <div class="docinfo_box">
                                <div class="title"><p class="text-14-medium">{!! __($result->expire_date_iso) !!}</p></div>
                                <div class="info text-14-medium">{!! __('Expiration Date') !!}</div>
                            </div>
                        </div>
                        @endif

                        @if($result->extra_expiration_days != 'Cheque' && $result->extra_expiration_days != '')
                            <div class="col-lg-3 col-md-6">  
                                <div class="docinfo_box">
                                    <div class="title"><p class="text-14-medium"> {!! app('common')->diffForHumans($result->expiration_date) !!}</p></div>
                                    <div class="info text-14-medium">{!! __('Days for Expiration') !!}</div>
                                </div>
                            </div>
                        @endif

                        @if($result->operation_type == 'Invoice')
                            <div class="col-lg-3 col-md-6">  
                                <div class="docinfo_box">
                                    <div class="title"><p class="text-14-medium">{!! __($result->invoice_number) !!}</p></div>
                                    <div class="info text-14-medium">{!! __('Invoice Number') !!}</div>
                                </div>
                            </div>
                            
                            @if($result->stamp_expiration!='')
                                <div class="col-lg-3 col-md-6">  
                                    <div class="docinfo_box">
                                        <div class="title">
                                            @if($result->stamp_expiration!='')
                                                <p class="text-14-medium">{{ __('Expires') }} : {{ $result->stamp_expiration }}</p>
                                            @endif
                                        </div>
                                        <div class="info text-14-medium">{!! __('Stamped') !!}</div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    
                        @if($result->operation_type == 'Cheque')
                            <div class="col-lg-3 col-md-6">  
                                <div class="docinfo_box">
                                    <div class="title"><p class="text-14-medium">{!! __($result->check_number ?? 'N/A') !!}</p></div>
                                    <div class="info text-14-medium">{!! __('Check Number') !!}</div>
                                </div>
                            </div>
                        @endif

                        @if($result->operation_type == 'Contract' || $result->operation_type == 'Other')
                        <div class="col-lg-3 col-md-6">  
                            <div class="docinfo_box">
                                <div class="title"><p class="text-14-medium">{!! __($result->contract_number) !!}</p></div>
                                <div class="info text-14-medium">{!! __('Contract Number') !!}</div>
                            </div>
                        </div>
                        @endif
                        @if(isset($result->issuer_bank?->name) && !empty($result->issuer_bank?->name))
                        <div class="col-lg-3 col-md-6">  
                            <div class="docinfo_box">
                                <div class="title"><p class="text-14-medium">{!! __($result->issuer_bank?->name) !!}</p></div>
                                <div class="info text-14-medium">{!! __('Payer’s Bank') !!}</div>
                            </div>
                            
                        </div>
                        @endif
                        @if(isset($result->legal_direction) && !empty($result->legal_direction))
                            <div class="col-lg-3 col-md-6">  
                                <div class="docinfo_box">
                                    <div class="title"><p class="text-14-medium">{!! __($result->legal_direction) !!}</p></div>
                                    <div class="info text-14-medium">{!! __('Legal Address') !!}</div>
                                </div>
                            </div>
                        @endif

                        @if(isset($result->legal_telephone) && !empty($result->legal_telephone))
                            <div class="col-lg-3 col-md-6">  
                                <div class="docinfo_box">
                                    <div class="title"><p class="text-14-medium">{!! __($result->legal_telephone) !!}</p></div>
                                    <div class="info text-14-medium">{!! __('Declared Phone') !!}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- commercial reference :st --}}
                @if ($result->references->count() > 0 && $result->references->first()->name !='')
                    <div class="commercialRef_wrap">
                        <div class="titlebox">
                            <h3 class="text-20-medium">{!! __('Commercial Reference') !!}</h3>
                        </div>

                        <div class="comref_table">    
                            <div class="view-history-popup">
                                <table>
                                    <thead>
                                        <tr class="forbg">
                                            <th class="text-14-medium">{!! __('Name & Last Name / Business') !!}</th>
                                            <th class="text-14-medium">{!! __('Email') !!}</th>
                                            <th class="text-14-medium">{!! __('Phone') !!}</th>
                                            <th class="text-14-medium">{!! __('Observation') !!}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($result->references as $reference)
                                            <tr>
                                                <td class="text-14-medium">{!! __($reference->name) !!}</td>
                                                <td class="text-14-medium">{!! __($reference->email) !!}</td>
                                                <td class="text-14-medium">
                                                    {!! ($reference->phone_number) !!}
                                                </td>
                                                <td class="text-14-medium">{!! __($reference->company_name) !!}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{--Mobile commercial reference:st --}}
                    <div class="mobile_comref_wrap" data-info="mobile-scree">
                        @foreach ($result->references as $reference)
                            <div class="mb_comrefBox">
                                <div class="mb_comrefrow">
                                    <div class="left text-16-medium">{!! __('Name & Last Name / Business') !!}</div>
                                    <div class="right text-16-medium">{!! __($reference->name) !!}</div>
                                </div>
                                <div class="mb_comrefrow">
                                    <div class="left text-16-medium">{!! __('Email') !!}</div>
                                    <div class="right text-16-medium">{!! __($reference->email) !!}</div>
                                </div>
                                <div class="mb_comrefrow">
                                    <div class="left text-16-medium">{!! __('Phone') !!}</div>
                                    <div class="right text-16-medium">
                                        {!! ($reference->phone_number) !!}
                                    </div>
                                </div>
                                <div class="mb_comrefrow">
                                    <div class="left text-16-medium">{!! __('Observation') !!}</div>
                                    <div class="right text-16-medium">{!! __($reference->company_name) !!}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- main document :st --}}
                @if ($result->documents && $result->documents->count() > 0)
                <div class="main_docwrap">
                    <div class="titlebox">
                        <h3 class="text-20-medium">{!! __('Main Documents') !!}</h3>
                    </div>
                    <div class="docbox_inner">
                        @foreach ($result->documents as $document)
                            @if ($document->path != '')
                                @php
                                    $file_ext = strtolower(pathinfo($document->path, PATHINFO_EXTENSION));
                                @endphp
                                @if ($file_ext == 'pdf' && $document->path != '')
                                    <div class="maindoc_box">
                                        <div class="imgbox">
                                            <img src="{{ asset('images/mipo/pdf.png') }}" alt="no-image">
                                        </div>
                                        {{-- <div class="doc_title text-12-medium">{!! __('Insert Document Title') !!}</div> --}}
                                    </div>
                                @else
                                <div class="maindoc_box">
                                    <div class="imgbox">
                                        <img src="{{ $document->document_url }}" alt="no-image" data-fancybox>
                                    </div>
                                    {{-- <div class="doc_title text-12-medium">{!! __('Insert Document Title') !!}</div> --}}
                                </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- additional document :st --}}
                @if ($result->supportingAttachments && $result->supportingAttachments->count() > 0)
                    <div class="additional_docwrap">
                        <div class="titlebox">
                            <h3 class="text-20-medium">{!! __('Additional Attachments') !!}</h3>
                        </div>
                        <div class="docbox_inner">
                            @foreach ($result->supportingAttachments as $supporting_attachment)
                                @if ($supporting_attachment->path != '')
                                    @php
                                        $file_ext = strtolower(pathinfo($supporting_attachment->path, PATHINFO_EXTENSION));
                                    @endphp
                                    @if ($file_ext == 'pdf' && $supporting_attachment->path != '')
                                    <div class="maindoc_box">
                                        <div class="imgbox">
                                            <img src="{{ asset('images/mipo/pdf.png') }}" alt="no-image">
                                        </div>
                                        {{-- <div class="doc_title text-12-medium">{!! __('Insert Document Title') !!}</div> --}}
                                    </div>
                                    @else
                                    <div class="maindoc_box">
                                        <div class="imgbox">
                                            <img src="{{ $supporting_attachment->attachment_url }}" alt="no-image" data-fancybox>
                                        </div>
                                        {{-- <div class="doc_title text-12-medium">{!! __('Insert Document Title') !!}</div> --}}
                                    </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            

                    {{-- multi offers:st --}}
                    <div class="multi_offer_wrap">
                        <div class="row" id="prev_offer_target">
                            @if(!in_array($result->offers()->where('buyer_id', $buyer_id)->first()?->offer_status, ['Approved', 'Completed', null]))
                                @php
                                    $offer = $result->offers()->where('buyer_id', $buyer_id)?->first();
                                @endphp
                                <div class="col-lg-6">
                                    <div class="ofrperfective_box">
                                        <div class="titlebox"><h3 class="text-20-medium">{!! __('Offer’s Perspective') !!}</h3></div>
                                        <div class="opdtl_best_ofrBox">
                                            <div class="operation_summary">
                                                <div class="sumry_item bestofr_heading">
                                                    <div class="lft text-18-medium">{!! __('Best Offer') !!}</div>
                                                    <div class="rght text-18-medium">
                                                        <span>{{ app('common')->currencyNumberFormat($result->preferred_currency, $offer->amount ?? '0') }} </span>
                                                        {{ ($result->preferred_currency == 'USD') ? $currency_type[0] :  $currency_type[1]  }}</div>
                                                </div>
                                                <div class="current_offr text-14-semibold">{!! __('Your Current Offer') !!}</div>
                                                <div class="sumry_item">
                                                    <div class="lft text-14-medium">{!! __('Retention') !!}</div>
                                                    <div class="rght text-14-medium">
                                                        <span>{{ app('common')->currencyNumberFormat($result->preferred_currency, $offer->retention ?? '0') }}</span>
                                                        {{ ($result->preferred_currency == 'USD') ?  $currency_type[0] :  $currency_type[1]  }}</div>
                                                </div>
                                                <div class="sumry_item">
                                                    <div class="lft text-14-medium">{!! __('Payment Method') !!}</div>
                                                    <div class="rght text-14-medium"><span>{!! __($offer->preferred_payment_method ?? 'N/A') !!}</span></div>
                                                </div>
                                                <div class="sumry_item">
                                                    <div class="lft text-14-medium">{!! __('Offer Period') !!}</div>
                                                    <div class="rght text-14-medium"><span>{!! __('Expires in') !!} {{ __($offer->offer_expire_hour ?? 'N/A') }} {{ __('Hours') }}</span></div>
                                                </div>
                                                <div class="sumry_item">
                                                    <div class="lft text-14-medium">{!! __('Offer Amount') !!}</div>
                                                    <div class="rght text-14-medium">
                                                    <span> {{ app('common')->currencyNumberFormat($result->preferred_currency, $offer->amount ?? '0') }}</span>
                                                    {{ ($result->preferred_currency == 'USD') ?  $currency_type[0] :  $currency_type[1]  }}</div>
                                                </div>
                                                <div class="sumry_item">
                                                    <div class="lft text-14-medium">{!! __('Mipo+') !!}</div>
                                                    <div class="rght text-14-medium"><span>{!! __($offer->is_mipo_plus ?? 'No') !!}</span></div>
                                                </div>
                                                @if($result->offers()->where('buyer_id', $buyer_id)->first()->offer_type == 'Group' && $result->offers()->where('buyer_id', $buyer_id)->first()->offer_status == 'Counter')
                                                    <div class="op_revertbtn">
                                                        <a href="javacript:;" class="op_revert_ofr text-14-medium evt_change_status" data-offer-id="{{ $result->offers()->where('buyer_id', $buyer_id)?->first()?->id }}" data-status="Revert">{!! __('Revert Offer') !!}</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @if(!in_array($result->offers()->where('buyer_id', $buyer_id)->first()?->offer_status, ['Approved', 'Completed']))
                            <div class="col-lg-6">
                                <div class="offerbox_opdtl_wrap">
                                    <div class="titlebox"><h3 class="text-20-medium">{!! __('Offer') !!}</h3></div>
                                </div>
                                <div class="offerbox_opdtl">
                                    <div class="offer_field">
                                        <div class="title text-14-medium">{!! __('Retention') !!}</div>
                                        <div class="inputfield">
                                            <input type="text" {{ $result->operation_type == 'Cheque' ? 'disabled' : '' }}
                                                value="" name="group_offer_retention"
                                                data-operation-amount="{{ $result->amount }}"
                                                placeholder="{{ __('Retention') }}"
                                                id="offer_retention_{{ $result->id }}_mob"
                                                data-screen-name="_mob"
                                                class="evt_validate_decimal evt_input explore_offer_input"
                                                data-operation-id="{{ $result->id }}"
                                                data-seller-id="{{ $result->seller_id }}"
                                                data-currency-type="{{ $result->preferred_currency }}"
                                                >
                                                @if($result->preferred_currency == 'USD')
                                                    <div class="ofr"><img src="{{ asset('images/mipo/dlrpure.svg') }}" alt="no-image"></div>
                                                @else
                                                    <div class="ofr"><img src="{{ asset('images/mipo/sixteengurani.svg') }}" alt="no-image"></div>
                                                @endif
                                        </div>
                                    </div>
                                
                                    <div class="offer_field">
                                        <div class="title text-14-medium">{!! __('Payment Method') !!}</div>
                                        <div class="inputfield payMethod">
                                            <div class="select-dd">
                                                <select
                                                    name="counter_offer_payment_method"
                                                    id="payment_method_{{ $result->id }}_mob"
                                                    data-screen-name="_mob"
                                                    class="form-select nice_selectbox selectbox text-16-medium evt_change" data-operation-id="{{ $result->id }}"
                                                    data-seller-id="{{ $result->seller_id }}">
                                                    @if (config('constants.PREFERRED_MODE'))
                                                        @foreach (config('constants.PREFERRED_MODE') as $key => $val)
                                                            <option {{ $result->preferred_payment_method == $val ? 'selected' : '' }} value="{{ $val }}"> {{ __($key) }} </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="offer_field">
                                        <div class="title text-14-medium">{!! __('Offer Period') !!}</div>
                                        <div class="inputfield">
                                            <div class="multifield">
                                                <div class="ofrtime">
                                                    <input type="number" name="group_offer_day_hour" data-currency-type="{{ $result->preferred_currency }}" placeholder="{{ __('No.')}}"
                                                    maxlength="2" 
                                                    id="day_hour_no_{{ $result->id }}_mob"
                                                    data-screen-name="_mob"
                                                    class="evt_validate_decimal evt_input" data-operation-id="{{ $result->id }}"
                                                    data-seller-id="{{ $result->seller_id }}">
                                                </div>
                                                <div class="timeoption">
                                                    <div class="select-dd">
                                                        <select name="hour" name="group_offer_hour" data-currency-type="{{ $result->preferred_currency }}" data-operation-id="{{ $result->id }}"
                                                            data-seller-id="{{ $result->seller_id }}" 
                                                            id="sel_day_hour_{{ $result->id }}_mob"
                                                            data-screen-name="_mob"
                                                            class="form-select nice_selectbox selectbox text-16-medium evt_change">
                                                            <option value="hour">{{ __('Hours') }}</option>
                                                            <option value="day">{{ __('Day') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="offer_field">
                                        <div class="title text-14-medium">{!! __('Offer Amount') !!}</div>
                                        <div class="inputfield">
                                            <input type="text" placeholder="{{ __('Offer') }}" onkeyup="offerSummary(this)"
                                            name="group_offer_amount"
                                            data-screen-name="_mob"
                                            id="offer_amount_{{ $result->id }}_mob"
                                            data-screen-name="_mob"
                                            data-operation-id="{{ $result->id }}" data-seller-id="{{ $result->seller_id }}"
                                            data-currency-type="{{ $result->preferred_currency }}" value=""
                                            class="evt_validate_decimal evt_input explore_offer_input">

                                            @if($result->preferred_currency == 'USD')
                                                <div class="ofr"><img src="{{ asset('images/mipo/dlrpure.svg') }}" alt="no-image"></div>
                                            @else
                                                <div class="ofr"><img src="{{ asset('images/mipo/sixteengurani.svg') }}" alt="no-image"></div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mplus_ofr">
                                        @if ($result->mipo_verified == 'Yes')
                                        <div class="mplus">
                                            <div class="inputbox">
                                                <input type="checkbox" id="is_mipo_cbox_{{ $result->id }}_mob" class="evt_is_mipo_plus form-check-input" data-operation-id="{{ $result->id }}" data-seller-id="{{ $result->seller_id }}" data-screen-name="_mob">
                                                <label for="is_mipo_cbox_{{ $result->id }}_mob"><img src="{{ asset('images/mipo/bigplusmipo.png') }}" alt="no-image"></label>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="ofrbtn">
                                            <a href="javascript:;" data-operation-id="{{ $result->id }}" data-seller-id="{{ $result->seller_id }}" onclick="sentOffer(this, {{ $result->id }}, '_mob')">{!! __('Offer') !!}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @if(!in_array($result->offers()->where('buyer_id', $buyer_id)->first()?->offer_status, ['Approved', 'Completed']))
                        {{-- operation summary:st --}}
                        <div class="expdetail_summary_wrap">
                            <div class="titlebox">
                                <h3 class="text-20-medium">{!! __('Operation Summary') !!}</h3>
                            </div>
                            <div class="expdetail_summary">
                                <div class="sumry_item">
                                    <div class="lft invoiceName text-16-medium">
                                        <a href="javascript:;" class="invid">
                                            {{ ($result->operation_type == 'Cheque') ? __('Check') : __($result->operation_type) }}
                                            {!! __($result->operation_number) !!}
                                        </a>
                                        <p>{!! __($result->preferred_payment_method) !!}</p>
                                        <a href="javascript:;" class="ez">{!! __($result->issuer?->company_name) !!}</a>
                                    </div>
                                    <div class="rght text-16-medium">
                                        {{ app('common')->currencyNumberFormat($result->preferred_currency, $result->amount) }}
                                        {{ ($result->preferred_currency == 'USD') ? $currency_type[0] :  $currency_type[1]  }}
                                    </div>
                                </div>
                                <div class="sumry_item">
                                    <div class="lft text-14-medium">{!! __('Retention') !!}</div>
                                    <div class="rght text-14-medium"><span id="current_rentention_amount">0</span>
                                        {{ ($result->preferred_currency == 'USD') ? $currency_type[0] :  $currency_type[1]  }}
                                    </div>
                                </div>
                                <div class="sumry_item">
                                    <div class="lft text-14-medium">{!! __('Real Time Offer') !!}</div>
                                    <div class="rght text-14-medium"><span id="current_real_time_offer">0</span>
                                        {{ ($result->preferred_currency == 'USD') ? $currency_type[0] :  $currency_type[1]  }}
                                    </div>
                                </div>

                                <div class="sumry_item">
                                    <div class="lft text-14-medium">{!! __('MIPO Commission') !!} {{ $investor_commission }}%</div>
                                    <div class="rght text-14-medium"><span id="current_mipo_commission">0</span>
                                        {{ ($result->preferred_currency == 'USD') ?  $currency_type[0] :  $currency_type[1]  }}
                                    </div>
                                </div>

                                @if($result->mipo_verified == 'Yes')
                                    <div class="sumry_item">
                                        <div class="lft text-14-medium">{!! __('MIPO+ Guaranteed Repurchase') !!} {{ $mipo_commission }}%</div>
                                        <div class="rght text-14-medium"><span id="current_add_mipo_commission">0</span>
                                            {{ ($result->preferred_currency == 'USD') ? $currency_type[0] :  $currency_type[1]  }}
                                        </div>
                                    </div>
                                @endif

                                <div class="sumry_item net">
                                    <div class="lft text-16-medium">{!! __('Net Profit') !!}</div>
                                    <div class="rght text-16-medium"><span id="current_net_profit">0</span>
                                        {{ ($result->preferred_currency == 'USD') ? $currency_type[0] :  $currency_type[1]  }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif
            </div>
        </div>
    {{-- operation detail:nd --}}


    @section('custom_script')
        <script>
            var deal_action = "add";
            var offer_id = 0;
            
            @if($result->offers()->where('buyer_id', $buyer_id)->count() > 0)
                offer_id = "{{ $result->offers()->where('buyer_id', $buyer_id)?->first()?->id }}";
                deal_action = "update";
                const url_offered_operations_update = "{{ route('offered-operations.ajax-update-offer') }}";
            @endif

            const MIPO_COMMISSION = "{{ $investor_commission }}";
            const MIPO_ADD_COMMISSION = "{{ $mipo_commission }}";
            const accept_below_document_amount_requested = "{{ $result->accept_below_requested }}";
            const document_amount = "{{ $result->amount_requested }}";
            const current_operation_amount = "{{ $result->amount }}";
            const operation_type = "{{ $result->operation_type }}";
            const currency_type = "{{ $result->preferred_currency  }}";
            const url_save_group_offer = "{{ route('explore-operations.ajax-save-group-offer') }}";
            const url_offered_counter_update_status = "{{ route('counter-offer.ajax-save-offer-status') }}";
        </script>

        <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
        <script src="{{ asset('plugins/fancybox/fancybox.umd.js') }}"></script>
        <script src="{{ asset('js/jquery.formatCurrency-1.4.0.js') }}"></script>
        <script src="{{ asset('js/jquery.formatCurrency.all.js') }}"></script>
        <script src="{{ asset('js/custom-number-format.js') }}"></script>
        <script src="{{ asset('js/explore-operations-detail.js') }}"></script>
    @endsection
</x-app-layout>
