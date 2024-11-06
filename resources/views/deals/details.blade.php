<x-app-layout>
    @section('pageTitle', 'Deals Details')
    @section('custom_style')
        <link href="{{ asset('plugins/rateit/rateit.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/intl-tel-input-17.0.19/build/css/intlTelInput.min.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('plugins/dropzone/dropzone.min.css') }}">
        <style>
            .multiple_feedbak{
                display: none
            }
        </style>
    @endsection

    <div class="deal_detail_page_wrap">
        <div class="container">
            <div class="dealhead">
                <div class="arobox">
                    <a href="{{ route('deals.index') }}">
                        <i><img src="{{ asset('images/mipo/topleftAro.svg') }}" class="day" alt="no-image"></i>
                        <i><img src="{{ asset('images/mipo/white_lft_aro.svg') }}" class="night"  alt="no-image"></i>
                    </a>
                    <h2 class="text-24-semibold">{!! __('Deals') !!}</h2>
                </div>
            </div>
            @php
                $offer_type = $operation_detail->offer_type;
            @endphp
            {{-- aller payer row:st --}}
            <div class="saller_payer_row">
                <div class="leftbox">
                    @if($offer_type == 'Single')
                        <h3 class="text-16-medium">
                        {{ $operation_detail->operations->first()->operation_type_number }} - {{ __('Offer') }} - {{ __($operation_detail->preferred_payment_method) }}
                        </h3>
                    @endif

                    @if($offer_type == 'Group')
                        <h3 class="text-16-medium">
                            {{ $operation_detail->operations->first()->operation_type_number }} - {{ __('Group Offer') }} - {{ __($operation_detail->preferred_payment_method) }} 
                        </h3>
                    @endif
                    @if($offer_type == 'Single')
                    <p class="text-14-medium">{!! __('Expires on') !!} {{ $operation_detail->operations->first()->expire_date_iso }}</p>
                    @endif
                </div>

                <div class="rightbox">
                    @if ($type == 'Seller')
                        <a href="{{ route('profile.public-seller', $operation_detail->buyer?->slug) }}" class="profilebox">
                            <div class="imgtxtbox">
                                <div class="imgbox"><img src="{{ $operation_detail->buyer?->profile_image_url }}" alt="no-image"></div>
                                <div class="name">
                                    <h3 class="text-16-medium">{!! __($operation_detail->buyer->name) !!}</h3>
                                    <p class="text-14-medium">{!! __('Buyer') !!}</p>
                                </div>
                            </div>
                            <div class="review">
                                <i><img src="{{ asset('images/mipo/singlestr.png') }}" alt="no-image"></i>
                                <span class="text-14-medium">{{ floor($operation_detail->buyer?->ratings_avg_rating_number) }}/5 ({{ floor($operation_detail->buyer?->ratings_count) }})</span>
                            </div>
                        </a>
                    @endif

                    @if ($type == 'Buyer')
                        <a href="{{ route('profile.public-seller', $operation_detail->operations->first()->seller?->slug) }}" class="profilebox">
                            <div class="imgtxtbox">
                                <div class="imgbox"><img src="{{ $operation_detail->operations->first()->seller?->profile_image_url }}" alt="no-image"></div>
                                <div class="name">
                                    <h3 class="text-16-medium">{!! __($operation_detail->operations->first()->seller?->name) !!}</h3>
                                    <p class="text-14-medium">{!! __('Seller') !!}</p>
                                </div>
                            </div>
                            <div class="review">
                                <i><img src="{{ asset('images/mipo/singlestr.png') }}" alt="no-image"></i>
                                <span class="text-14-medium">{{ floor($operation_detail->operations->first()->seller?->ratings_avg_rating_number) }}/5 ({{ floor($operation_detail->operations->first()->seller?->ratings_count) }})</span>
                            </div>
                        </a>
                    @endif

                    @if($offer_type == 'Single')
                        <a href="{{ route('profile.public-payer-profile', $operation_detail->operations->first()->issuer->slug) }}" class="profilebox">
                            <div class="imgtxtbox">
                                <div class="imgbox"><img src="{{ $operation_detail->operations->first()->issuer?->company_image_url }}" alt="no-image"></div>
                                <div class="name">
                                    <h3 class="text-16-medium">{!! __($operation_detail->operations->first()->issuer->company_name) !!}</h3>
                                    <p class="text-14-medium">{!! __('Payer') !!}</p>
                                </div>
                            </div>
                            <div class="review">
                                <i><img src="{{ asset('images/mipo/singlestr.png') }}" alt="no-image"></i>
                                <span class="text-14-medium">{{ floor($operation_detail->operations->first()->issuer?->ratings_avg_rating_number) }}/5 ({{ floor($operation_detail->operations->first()->issuer?->ratings_count) }})</span>
                            </div>
                        </a>
                    @endif
                </div>

            </div>

            @if($operation_detail->is_disputed == 'Yes' && $operation_detail->offer_status != 'Completed')
                {{-- dispute:st --}}
                <div class="disputebox">
                    <div class="attention_wrap warning">
                        <div class="titlebox">
                            <span class="text-16-semibold"><i><img src="{{ asset('images/mipo/warningred.png') }}" alt="no-image"></i>{!! __('Dispute') !!}</span>
                        </div>
                        <div class="attentionbox">
                            <p class="text-16-medium">{{ $operation_detail->deals_disputes->first()->disputes_note }}</p>
                            <div class="preofr"><a href="javascript:;" class="text-16-medium">{!! __('Resolve dispute') !!}</a></div>
                        </div>
                    </div>
                </div> 
            @endif
            
            @if($operation_detail->offer_status == 'Completed')
                {{-- complete deal :st--}}
                <div class="complete_dealbox">
                    <div class="attention_wrap deal_success">
                        <div class="titlebox">
                            <span class="text-16-semibold"><i><img src="{{ asset('images/mipo/rightgreen.svg') }}" alt="no-image"></i>{!! __('Completed Deal') !!}</span>
                        </div>
                        <div class="attentionbox">
                            <p class="text-16-medium">{!! __('The deal was completed successfully.') !!}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            @php
                $preferred_currency = $operation_detail->operations->first()->preferred_currency;
                $document_amount =  $operation_detail->operations?->pluck('amount')->sum();
                $offer_retention = $operation_detail->retention;
                $real_time_offer = $operation_detail->amount;
                $mipo_commison = $operation_detail->mipo_commission;
                $mipo_plus_commission = $operation_detail->mipo_plus_commission;
                $net_profit = $operation_detail->net_profit;
                $preferred_payment_method_deals = $operation_detail->preferred_payment_method;
                $nominal_discount = ($document_amount - $real_time_offer);
                $nominal_discount_pr = (($nominal_discount * 100) / $document_amount);
            @endphp

            {{-- deals detailmulti block:st --}}
            <div class="deals_detailmulti_block">
                <div class="row">
                    @if ($type == 'Buyer')
                        <div class="col-lg-3 col-md-6 col-6">
                            <div class="docinfo_box">
                                <div class="title text-18-medium">
                                    {{ ($offer_type == 'Single') ? '1' : $operation_detail->operations->count() }}
                                </div>
                                <div class="info text-14-medium">{!! __('Documents Bought') !!}</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6">
                            <div class="docinfo_box">
                                <div class="title text-18-medium">{{ app('common')->currencyBySymbol($preferred_currency) . '' . app('common')->currencyNumberFormat($preferred_currency, $document_amount) }}</div>
                                <div class="info text-14-medium">{!! __('Purchased Documents Value') !!}</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6">
                            <div class="docinfo_box">
                                <div class="title text-18-medium">{{ app('common')->currencyBySymbol($preferred_currency) . '' . app('common')->currencyNumberFormat($preferred_currency, $real_time_offer) }}</div>
                                <div class="info text-14-medium">{!! __('Accepted Offer') !!}</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6">
                            <div class="docinfo_box">
                                <div class="title text-18-medium">{{ app('common')->currencyBySymbol($preferred_currency) . '' . app('common')->currencyNumberFormat($preferred_currency, $mipo_commison) }}</div>
                                <div class="info text-14-medium">{!! __('MIPO Commission') !!} </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6">
                            <div class="docinfo_box">
                                <div class="title text-18-medium">{{ app('common')->currencyBySymbol($preferred_currency) . '' . app('common')->currencyNumberFormat($preferred_currency, $offer_retention) }}</div>
                                <div class="info text-14-medium">{!! __('Retention') !!}</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6">
                            <div class="docinfo_box">
                                <div class="title text-18-medium">{{ app('common')->currencyBySymbol($preferred_currency) . '' . app('common')->currencyNumberFormat($preferred_currency, $net_profit) }}</div>
                                <div class="info text-14-medium">{!! __('Net Profit') !!}</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6">
                            <div class="docinfo_box">
                                <div class="title highlight_red text-18-medium">{{ app('common')->currencyBySymbol($preferred_currency) . '' . app('common')->currencyNumberFormat($preferred_currency, $mipo_plus_commission) }}</div>
                                <div class="info text-14-medium">{!! __('MIPO+ Commission') !!}</div>
                            </div>
                        </div>
                    @endif

                    @if ($type == 'Seller')
                    <div class="col-lg-3 col-md-6 col-6">
                        <div class="docinfo_box">
                            <div class="title text-18-medium">
                                {{ ($offer_type == 'Single') ? '1' : $operation_detail->operations->count() }}
                            </div>
                            <div class="info text-14-medium">{!! __('Documents Sold') !!}</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6">
                        <div class="docinfo_box">
                            <div class="title text-18-medium">
                                {{ app('common')->currencyBySymbol($preferred_currency) . '' . app('common')->currencyNumberFormat($preferred_currency, $document_amount) }}
                            </div>
                            <div class="info text-14-medium">{!! __('Value of Documents Sold') !!}</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6">
                        <div class="docinfo_box">
                            <div class="title text-18-medium">
                                {{ app('common')->currencyBySymbol($preferred_currency) . '' . app('common')->currencyNumberFormat($preferred_currency, $real_time_offer) }}
                            </div>
                            <div class="info text-14-medium">{!! __('Accepted Offer') !!}</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6">
                        <div class="docinfo_box">
                            <div class="title text-18-medium">
                                {{ app('common')->currencyBySymbol($preferred_currency) . '' . app('common')->currencyNumberFormat($preferred_currency, $nominal_discount) }}
                            </div>
                            <div class="info text-14-medium">{!! __('Nominal Discount') !!}</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6">
                        <div class="docinfo_box">
                            <div class="title highlight_red text-18-medium">
                                {{  round($nominal_discount_pr, 2) }} %
                            </div>
                            <div class="info text-14-medium">{!! __('Discount  %') !!}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            {{-- sign contract with multistep:st --}}
            {{--class for just blue link->blueLink --}}
            {{-- class for green span-> green_success,greydisable --}}
            {{-- class for green btn->green_download --}}
            {{-- class for grey disable btn-> greybtn--}}
            
            @php
            $is_cashed = $is_rate = false;
            $qr_code_step_id = 0;
            $preferred_payment_method_deals = $operation_detail->preferred_payment_method;
            if ($type == 'Seller') {
                $is_rate = $operation_detail->is_rated_seller;
                $is_cashed = $operation_detail->is_cashed_seller;
                $is_filed = $operation_detail->is_filed_seller;
                $is_qr_code = $operation_detail->is_qr_code_seller;
                $is_deals_contract = $operation_detail->is_seller_deals_contract;
                $offer_status = $operation_detail->offer_status;
                $is_payment = $operation_detail->is_payment_seller;
                $is_cashe_date = $operation_detail->cashed_date_seller;
            } elseif ($type == 'Buyer') {
                $is_rate = $operation_detail->is_rated_buyer;
                $is_cashed = $operation_detail->is_cashed_buyer;
                $is_filed = $operation_detail->is_filed_buyer;
                $is_qr_code = $operation_detail->is_qr_code_buyer;
                $is_deals_contract = $operation_detail->is_buyer_deals_contract;
                $offer_status = $operation_detail->offer_status;
                $is_payment = $operation_detail->is_payment_buyer;
                $is_cashe_date = $operation_detail->cashed_date_buyer;
            }
        @endphp
            <div class="sign_contract_wrap">
                <div class="row">

                    <div class="col-lg-8">
                        <x-deal-step-form :langs="$langs" :operation_detail="$operation_detail" :type="$type" :preferred_payment_method_deals="$preferred_payment_method_deals" :progress="$progress"/>
                    </div>

                    <div class="col-lg-4">
                        <x-deal-step-tracking :langs="$langs" :operation_detail="$operation_detail" :type="$type" :preferred_payment_method_deals="$preferred_payment_method_deals" :progress="$progress"/>
                    </div>
                    
                </div>
            </div>

            @if($operation_detail->operations->count() > 0 && $type == 'Buyer' && $operation_detail->offer_type != 'Group')
                {{-- operation:st --}}
                <div class="operation_table_wrap">
                    <div class="titlebox">
                        <h3 class="text-20-medium">{!! __('Operation') !!}</h3>
                    </div>
                    <table>
                        <thead>
                            <tr class="forbg">
                                <th class="text-14-medium">{!! __('Document Number') !!}</th>
                                <th class="text-14-medium">{!! __('Type of Document') !!}</th>
                                <th class="text-14-medium">{!! __('Document Amount') !!} </th>
                                <th class="text-14-medium">{!! __('Name of Payer') !!}</th>
                                <th class="text-14-medium">{!! __('Expiration Date') !!}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($operation_detail->operations as $key => $operation)
                                <tr>
                                    <td class="text-14-medium">{{  $operation->operation_number }}</td>
                                    <td class="text-14-medium">{{ ($operation->operation_type == 'Cheque') ? __('Check') : __($operation->operation_type) }}</td>
                                    <td class="text-14-medium">{{ app('common')->currencyBySymbol($operation->preferred_currency) . '' . app('common')->currencyNumberFormat($operation->preferred_currency, $operation->amount) }}</td>
                                    <td class="text-14-medium highlight"><a href="{{ route('profile.public-payer-profile', $operation->issuer?->slug) }}">{{ $operation->issuer->company_name }}</a></td>
                                    <td class="text-14-medium">{{ $operation->expire_date_iso }}</td>
                                    <td class="text-14-medium highlight"><a href="{{ route('explore-operations.details', $operation->slug) }}">{!! __('View') !!}</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- operation:nd --}}

                {{-- mb operation_table_wrap:st --}}
                <div class="mbdeal_tabdata">
                    <div class="titlebox">
                        <h3 class="text-20-medium">{!! __('Operation') !!}</h3>
                    </div>
                    @foreach ($operation_detail->operations as $key => $operation)
                        <a class="open_mobile_content" href="{{ route('explore-operations.details', $operation->slug) }}">
                            <div class="mobile_lr">
                                <p class="text-16-medium">{!! __('Document Number') !!}</p>
                                <h6 class="text-16-medium">{{  $operation->operation_number }}</h6>
                            </div>
                            <div class="mobile_lr">
                                <p class="text-16-medium">{!! __('Type of Document') !!}</p>
                                <h6 class="text-16-medium">{{ ($operation->operation_type == 'Cheque') ? __('Check') : __($operation->operation_type) }}</h6>
                            </div>
                            <div class="mobile_lr">
                                <p class="text-16-medium">{!! __('Document Amount') !!} </p>
                                <h6 class="text-16-medium">{{ app('common')->currencyBySymbol($operation->preferred_currency) . '' . app('common')->currencyNumberFormat($operation->preferred_currency, $operation->amount) }}</h6>
                            </div>
                            <div class="mobile_lr">
                                <p class="text-16-medium">{!! __('Name of Payer') !!}</p>
                                <h6 class="text-16-medium">{{ $operation->issuer->company_name }}</h6>
                            </div>
                            <div class="mobile_lr">
                                <p class="text-16-medium">{!! __('Expiration Date') !!}</p>
                                <h6 class="text-16-medium">{{ $operation->expire_date_iso }}</h6>
                            </div>
                            {{-- <div class="mobile_lr">
                                <p class="text-16-medium"></p>
                                <a class="text-16-medium highlight" href="{{ route('explore-operations.details', $operation->slug) }}">{!! __('View') !!}</a>
                            </div> --}}
                        </a>
                    @endforeach
                </div>
            @endif
            {{-- mb operation_table_wrap:nd --}}

            @if ($operation_detail->offer_type == 'Group' && $operation_detail->operations->count() > 0 && $type == 'Buyer')
                @if($operation_detail->is_seller_deals_contract == 'Yes' && $operation_detail->is_buyer_deals_contract == 'Yes')
                {{-- operation cash review:st --}}
                <div class="opCash_review">
                    <div class="operationTopbox">
                        <div class="lft">
                            <div class="title">
                                <h3 class="text-20-semibold">{!! __('Operation') !!}</h3>
                            </div>
                            <div class="checkName">
                                <input type="checkbox" name="deals_chk_all_operation" id="evt_deals_chk_all_operation">
                                <label for="evt_deals_chk_all_operation" class="text-12-medium"> {!! __('Select All Operations') !!}</label>
                            </div>
                        </div>
                        <div class="rght">
                            <div class="cash_reviewbtn" id="evt_cash_review">
                                <a href="javascript:;" class="text-16-medium">{!! __('Cash & Review') !!}</a>
                            </div>
                        </div>
                    </div>
                    <div class="opcash_reviewbox">
                        @foreach ($operation_detail->operations as $key => $operation)
                            <div class="opcash_rep_outer">
                                <div class="operation_box">

                                    <div class="leftpart">
                                        <div class="top_part_cheque_select">
                                            @if($operation->pivot->is_cashed_buyer != 'Yes' && $operation->pivot->is_disputed == 'No')
                                                <input type="checkbox" class="evt_deals_chk_single_operation" name="deals_chk_single_operation" id="deals_chk_single_operation_{{ $key }}" value="{{ $operation->pivot->id }}" data-group-offer-id="{{ $operation->pivot->id }}" data-offer-id="{{ $operation->pivot->offer_id }}">
                                            @endif
                                        </div>
                                        <a href="javascript:;" class="text-16-medium chid">{{ $operation->operation_type }} - {{ $operation->operation_number }}</a>
                                        <div class="company_tab">
                                            <a href="javascript:;" class="text-16-medium">{{ $operation->issuer->company_name }}</a>
                                            <div class="tab text-12-medium">{!! __('Payer') !!}</div>
                                            <div class="striew text-12-medium"><i><img src="{{ asset('images/mipo/singlestr.png') }}" alt="no-image"></i>{{ floor($operation->issuer?->ratings_avg_rating_number)}} /5</div>
                                        </div>

                                        <p class="text-12-medium">{!! __('Document Amount') !!} <span>
                                            {{ app('common')->currencyBySymbol($operation->preferred_currency) . '' . app('common')->currencyNumberFormat($operation->preferred_currency, $operation->amount) }}    
                                        </span></p>

                                        @if($operation->pivot->is_cashed_buyer == 'Yes')
                                        <div class="cashingbox">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="cashingon" checked disabled>
                                                <label class="form-check-label text-12-medium" for="cashingon">{!! __('Cashing') !!}</label>
                                            </div>
                                        </div>
                                        @else
                                            @if($operation->pivot->is_disputed == 'No')
                                                <div class="cashingbox">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input evt_is_cashed_buyer" role="switch" data-data-step-id="0" data-group-offer-id="{{ $operation->pivot->id }}" data-offer-id="{{ $operation->pivot->offer_id }}" type="checkbox" role="switch" id="flexSwitchCheckDefault_{{ $key }}">
                                                        <label class="form-check-label text-12-medium" for="flexSwitchCheckDefault_{{ $key }}">{{ __('Cashing') }}</label>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>

                                    <div class="rightpart">
                                        <p class="text-14-medium">{!! __('Expire in') !!} {{ $operation->expire_at }}</p>
                                        <div class="report_reviewbox">

                                            @if($operation->pivot->is_cashed_buyer != 'Yes')
                                                <a href="javascript:;" class="report text-12-medium evt_is_cashed_dispute_buyer"  data-group-offer-id="{{ $operation->pivot->id }}" data-offer-id="{{ $operation->pivot->offer_id }}"><i><img src="{{ asset('images/mipo/tringle_exlamen.svg') }}" alt="no-image"></i>{!! __('Report Dispute') !!}</a>
                                            @endif

                                            @if($operation->pivot->is_rated_buyer == 'No' && $operation->pivot->is_disputed == 'No')
                                                <a href="javascript:;" class="review text-12-medium evt_is_cashed_feedback_buyer" data-group-offer-id="{{ $operation->pivot->id }}" data-offer-id="{{ $operation->pivot->offer_id }}">{!! __('Give Review') !!}</a>
                                            @endif
                                        </div>

                                        <div class="viewtabox">
                                            <a href="{{ route('explore-operations.details', $operation->slug) }}" class="viewtab text-14-medium">{!! __('View') !!}</a>
                                        </div>

                                        @if($operation->pivot->is_cashed_buyer == 'Yes')
                                        <div class="mbcashingbox">
                                            <div class="form-check form-switch">
                                                <label class="form-check-label text-12-medium" for="cashingon">{!! __('Cashing') !!}</label>
                                                <input class="form-check-input" type="checkbox" role="switch" id="cashingon" checked>
                                            </div>
                                        </div>
                                        @else
                                            @if($operation->pivot->is_disputed == 'No')
                                                <div class="mbcashingbox">
                                                    <div class="form-check form-switch">
                                                        <label class="form-check-label text-12-medium" for="flexSwitchCheckDefault_{{ $key }}">{{ __('Cashing') }}</label>
                                                        <input class="form-check-input evt_is_cashed_buyer" role="switch" data-data-step-id="0" data-group-offer-id="{{ $operation->pivot->id }}" data-offer-id="{{ $operation->pivot->offer_id }}" type="checkbox" role="switch" id="flexSwitchCheckDefault_{{ $key }}">
                                                    </div>
                                                </div>
                                            @endif
                                        @endif

                                    </div>

                                    <a href="javascript:;" class="full_link"></a>
                                </div>

                                <div class="cashmobile_show">
                                    <div class="report_reviewbox">

                                        @if($operation->pivot->is_cashed_buyer != 'Yes')
                                        <a href="javascript:;" class="report text-12-medium evt_is_cashed_dispute_buyer"  data-group-offer-id="{{ $operation->pivot->id }}" data-offer-id="{{ $operation->pivot->offer_id }}"><i><img src="{{ asset('images/mipo/tringle_exlamen.svg') }}" alt="no-image"></i>{!! __('Report Dispute') !!}</a>
                                    @endif

                                    @if($operation->pivot->is_rated_buyer == 'No' && $operation->pivot->is_disputed == 'No')
                                        <a href="javascript:;" class="review text-12-medium evt_is_cashed_feedback_buyer" data-group-offer-id="{{ $operation->pivot->id }}" data-offer-id="{{ $operation->pivot->offer_id }}">{!! __('Give Review') !!}</a>
                                    @endif
                                        {{--  <a href="javascript:;" class="report text-12-medium"><i><img src="{{ asset('images/mipo/tringle_exlamen.svg') }}" alt="no-image"></i>{!! __('Report Dispute') !!}</a>
                                        <a href="javascript:;" class="review text-12-medium">{!! __('Give Review') !!}</a> --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endif

        </div>
    </div>
{{--  --}}
  {{-- sign contract model:st --}}
  
<!-- Modal -->
<div class="sign_contract_model">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-20-medium">Contrato de cesión de crédito</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="multi_info">
                        <h3 class="text-16-medium"><span>Lorem ipsum</span> dolor sit amet, consectetur adipiscing elit. In et ante at arcu pellentesque laoreet ac eu erat. Maecenas scelerisque feugiat enim. Aliquam quis molestie libero. Mauris quis felis in massa interdum posuere et a odio. Cras mauris nunc, facilisis eu tortor at, eleifend iaculis mauris. In aliquam augue et lobortis elementum. Donec dapibus fringilla turpis, ac faucibus orci luctus vel. Integer nec lorem eu ipsum fermentum finibus. Fusce molestie vestibulum velit, in ultricies nibh rutrum eu. Praesent condimentum fermentum turpis at vehicula. Pellentesque ullamcorper ipsum et mauris vestibulum, vulputate sodales arcu auctor. Vestibulum orci nibh, consequat quis rhoncus id, tincidunt sit amet lacus.</h3>
                        <h3 class="text-16-medium">Vestibulum non feugiat erat. <span>Mauris laoreet</span> luctus porttitor. Nunc imperdiet, arcu eget lacinia molestie, massa lorem sagittis nibh, sed tristique dui ex nec nisi. Suspendisse nec rutrum urna. Sed in elementum lectus. Maecenas iaculis, lorem nec hendrerit interdum, est purus dignissim velit, eu tristique turpis odio a eros. Vivamus quis sapien augue. Maecenas id tincidunt velit, a elementum libero. Pellentesque vitae dolor a nunc bibendum auctor ac non mauris. Vestibulum efficitur, nisi sed ultricies ultricies, metus ligula elementum tellus, in iaculis ligula dui quis erat. In sed sollicitudin eros, sit amet auctor diam. Aenean vehicula, nisi at porta bibendum, magna ipsum lacinia nisi, ut maximus leo nulla eu est. Donec sagittis mi non mattis ultricies. Donec tincidunt velit velit, sed euismod magna rutrum eget. Cras a justo tincidunt, ullamcorper erat eu, lacinia turpis. Aliquam erat volutpat.</h3>
                        <h3 class="text-16-medium">Ut faucibus at sapien sit amet aliquet. Curabitur finibus laoreet bibendum. In eget ipsum libero. Sed vitae purus nec turpis feugiat lobortis quis ac elit. Vivamus sem lectus, posuere eget vehicula vel, cursus a arcu. Cras ultricies, nunc eu congue egestas, sem sapien ornare leo, eu tristique tellus justo a lorem. <span>Cras pellentesque </span>dui at maximus sollicitudin, nunc purus semper eros, sit amet malesuada magna mi sit amet tortor.</h3>

                        <div class="operation_table_wrap">
                            <table>
                                <thead>
                                    <tr class="forbg">
                                        <th class="text-14-medium">No Operacion</th>
                                        <th class="text-14-medium">Fecha de emision</th>
                                        <th class="text-14-medium">Monto nominal</th>
                                        <th class="text-14-medium">Vencimieento/pago</th>
                                        <th class="text-14-medium">Cliente/credido</th>
                                    </tr>
                               </thead>
                               <tbody>
                                        <tr>
                                            <td class="text-14-medium">N/A</td>
                                            <td class="text-14-medium">N/A</td>
                                            <td class="text-14-medium">N/A</td>
                                            <td class="text-14-medium">N/A</td>
                                            <td class="text-14-medium">N/A</td>
                                            <td class="text-14-medium">N/A</td>
                                        </tr>
                               </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- old all modal --}}


{{-- new rating --}}
<div class="view_review_modal">
    <div class="modal fade" id="rating-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-20-semibold">{!! __('Deal Actions') !!}</h5>
                </div>
                <form name="frm_deals_rating" action="{{ route('rating.store') }}" id="frm_deals_rating"
                method="post">
                <input type="hidden" name="rate_issuer_id" id="rate_issuer_id"
                value="{{ $operation_detail->operations->first()->issuer_id ?? '' }}" />
                @if ($type == 'Buyer')
                    <input type="hidden" name="rate_user_id" data-type-name="{{ $type }}"
                        id="rate_user_id"
                        value="{{ $operation_detail->operations->first()->seller_id ?? '' }}" />
                @elseif($type == 'Seller')
                    <input type="hidden" name="rate_user_id" data-type-name="{{ $type }}"
                        id="rate_user_id" value="{{ $operation_detail->buyer->id ?? '' }}" />
                @endif
                <input type="hidden" name="offer_slug" id="offer_slug"
                value="{{ $operation_detail->slug }}" />
                <div class="modal-body">
                    <div class="detail_wrapper">
                        <div class="saller_payer_wrapper">
                            <h3 class="text-18-medium">{!! __('Give review to Seller & Payer') !!}</h3>
                            <div class="saller_payer_wrap">
                                <div class="reviewbox">
                                    <a href="javascript:;" class="profilebox">
                                        <div class="imgtxtbox">
                                            <div class="imgbox"><img src="{{ $operation_detail->operations->first()->seller->profile_image_url }}" alt="no-image"></div>
                                            <div class="name">
                                                <h3 class="text-16-medium">{{ $operation_detail->operations->first()->seller?->name ?? '-' }}</h3>
                                                <p class="text-14-medium">{!! __('Seller') !!}</p>
                                            </div>
                                        </div>
                                    </a>
                                        <div class="reviewinbox">
                                            <p class="text-16-medium">{!! __('How many stars?') !!}</p>
                                            <div class="rating">
                                                <div class="feedback_rateit"
                                                data-rateit-value="{{ config('constants.DEFAULT_FEEDBACK_RATE') }}"></div>
                                            <input type="hidden" name="sell_feedback_rate" id="sell_feedback_rate"
                                                value="{{ config('constants.DEFAULT_FEEDBACK_RATE') }}" />
                                            </div>
                                        </div>
                                        <div class="reviewinbox">
                                            <p class="text-16-medium">{!! __('How easy was the transaction?') !!}</p>
                                            <div class="pexp_ope">
                                                <label class="btn active" for="sell-trans1"><input type="radio"
                                                    class="btn-check evt_frm_one_transaction" name="sell_trans_doctype"
                                                    value="Easy" id="sell-trans1" checked> {{ __('Easy') }}</label>
                                            <label class="btn" for="sell-trans2"><input type="radio"
                                                    class="btn-check evt_frm_one_transaction" name="sell_trans_doctype"
                                                    value="Medium" id="sell-trans2">{{ __('Medium') }}</label>
                                            <label class="btn" for="sell-trans3"><input type="radio"
                                                    class="btn-check evt_frm_one_transaction" name="sell_trans_doctype"
                                                    value="Hard" id="sell-trans3">{{ __('Hard') }}</label>
                                            </div>
                                        </div>
                                        <div class="reviewinbox">
                                            <p class="text-16-medium">{!! __('How Easy was cashing the document?') !!}</p>
                                            <div class="pexp_ope">
                                                <label class="btn active" for="sell-cash1"><input type="radio"
                                                    class="btn-check evt_frm_one_document" name="sell_doc_doctype"
                                                    value="Easy" id="sell-cash1" checked>{{ __('Easy') }}</label>
                                            <label class="btn" for="sell-cash2"><input type="radio"
                                                    class="btn-check evt_frm_one_document" name="sell_doc_doctype"
                                                    value="Medium" id="sell-cash2">{{ __('Medium') }}</label>
                                            <label class="btn" for="sell-cash3"><input type="radio"
                                                    class="btn-check evt_frm_one_document" name="sell_doc_doctype"
                                                    value="Hard" id="sell-cash3">{{ __('Hard') }}</label>
                                            <label class="btn" for="sell-cash4"><input type="radio"
                                                    class="btn-check evt_frm_one_document" name="sell_doc_doctype"
                                                    value="Unable" id="sell-cash4">{{ __('Unable') }}</label>
                                            </div>
                                        </div>
                                        <div class="reviewinbox">
                                            <div class="description">
                                                <label class="text-14-medium" for="frm_one_days_desc">{!! __('Description') !!}</label>
                                                <textarea name="sell_description" id="frm_one_days_desc"></textarea>
                                            </div>
                                        </div>
                                </div>
                                <div class="reviewbox">
                                    <a href="javascript:;" class="profilebox">
                                        <div class="imgtxtbox">
                                            <div class="imgbox"><img src="{{ $operation_detail->operations->first()->issuer->company_image_url }}" alt="no-image"></div>
                                            <div class="name">
                                                <h3 class="text-16-medium">  {{ $operation_detail->operations->first()->issuer->company_name ?? '' }}</h3>
                                                <p class="text-14-medium">{!! __('Payer') !!}</p>
                                            </div>
                                        </div>
                                    </a>
                                        <div class="reviewinbox">
                                            <p class="text-16-medium">{!! __('How many stars?') !!}</p>
                                            <div class="rating">
                                                <div class="issuer_rateit"
                                                data-rateit-value="{{ config('constants.DEFAULT_ISSUERS_RATE') }}"></div>
                                            <input type="hidden" name="pay_issuer_rate" id="pay_issuer_rate"
                                                value="{{ config('constants.DEFAULT_ISSUERS_RATE') }}" />
                                            </div>
                                        </div>
                                        <div class="reviewinbox">
                                            <p class="text-16-medium">{!! __('How easy was the transaction?') !!}</p>
                                            <div class="pexp_ope">
                                                <label class="btn active" for="pay-trans1"><input type="radio"
                                                    class="btn-check evt_frm_two_transaction" name="pay_trans_doctype"
                                                    id="pay-trans1" value="Easy" checked>{{ __('Easy') }}</label>
                                            <label class="btn" for="pay-trans2"><input type="radio"
                                                    class="btn-check evt_frm_two_transaction" name="pay_trans_doctype"
                                                    id="pay-trans2" value="Medium">{{ __('Medium') }}</label>
                                            <label class="btn" for="pay-trans3"><input type="radio"
                                                    class="btn-check evt_frm_two_transaction" name="pay_trans_doctype"
                                                    id="pay-trans3" value="Hard">{{ __('Hard') }}</label>
                                            </div>
                                        </div>
                                        <div class="reviewinbox">
                                            <p class="text-16-medium">{!! __('How Easy was cashing the document?') !!}</p>
                                            <div class="pexp_ope">
                                                <label class="btn active" for="pay-cash1"><input type="radio"
                                                    class="btn-check evt_frm_two_document" name="pay_doc_doctype"
                                                    id="pay-cash1" value="Easy" checked>{{ __('Easy') }}</label>
                                            <label class="btn" for="pay-cash2"><input type="radio"
                                                    class="btn-check evt_frm_two_document" name="pay_doc_doctype"
                                                    id="pay-cash2" value="Medium">{{ __('Medium') }}</label>
                                            <label class="btn" for="pay-cash3"><input type="radio"
                                                    class="btn-check evt_frm_two_document" name="pay_doc_doctype"
                                                    id="pay-cash3" value="Hard">{{ __('Hard') }}</label>
                                            <label class="btn" for="pay-cash4"><input type="radio"
                                                    class="btn-check evt_frm_two_document" name="pay_doc_doctype"
                                                    id="pay-cash4" value="Unable">{{ __('Unable') }}</label>
                                            </div>
                                        </div>
                                        <div class="reviewinbox">
                                            <div class="description">
                                                <label class="text-14-medium" for="description">{!! __('Description') !!}</label>
                                                <textarea id="frm_two_days_desc" name="pay_description"></textarea>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="offer_id" id="offer_id"
                value="{{ $operation_detail->id }}" />
                <input type="hidden" name="user_rating_by" id="user_rating_by"
                value="{{ $type }}" />
                <div class="modal-footer">
                    <a href="javascript:;" class="text-16-medium evt_rating_modal_skip">{!! __('Skip') !!}</a>
                    <button type="submit" class="btn btn-primary text-16-medium">{!! __('Next') !!}</button>
                </div>
            </form>

            </div>
        </div>
    </div>
  </div>
{{-- new rating --}}


{{-- report inconvin modal:st --}}
<div class="report_incon_modal">
    <div class="modal fade" id="dispute_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-20-medium" id="exampleModalLabel">{{ __('Report Inconvenience') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form name="disputes_form" id="disputes_form" method="post"
                    action="{{ route('deals.ajax-create-disputes', $operation_detail->slug) }}"
                    novalidate="novalidate" enctype="multipart/form-data">
                    <input type="hidden" name="is_dispute_type" id="is_dispute_type" value="offer"/>
                    <div class="modal-body">
                        <div class="reportdetail">
                            {{-- <label for="disputes_note" class="col-form-label text-16-medium">{{ __('Dispute Note') }}</label> --}}
                            <textarea class="form-control" style="height: 66px" required data-msg-required="{{ __('The dispute note is required') }}" minlength="5" name="disputes_note" id="disputes_note"></textarea>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="disputes_file" class="form-label text-16-medium">{{ __('File') }}</label>
                            <input class="form-control" type="file" name="disputes_file" id="disputes_file">
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="text-16-medium" data-bs-dismiss="modal">{{ __('Cancel') }}</a>
                        <button type="submit" class="btn btn-primary text-16-medium">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- report inconvin modal:nd --}}



<div class="modal fade" id="deals_private_note_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deals_modal_heading">{{ __('Add Private Note') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form name="deals_private_note_form" id="deals_private_note_form" class="form-validation"
                method="post" action="{{ route('deals.ajax-private-note-crud') }}" novalidate="novalidate"
                enctype="multipart/form-data">
                <input type="hidden" name="deals_id" value="{{ $operation_detail->id }}" id="deals_id">
                <input type="hidden" name="deals_private_note_id" value="" id="deals_private_note_id">
                <input type="hidden" name="deals_private_note_action" value="add"
                    id="deals_private_note_action">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="deals_private_not" class="col-form-label">{{ __('Note:') }}</label>
                        <textarea class="form-control" required rows="6" cols="6" name="deals_private_note" id="deals_private_note"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="deals_btn_name">{{ __('Add')}}</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="show_attachments_modal" aria-labelledby="exampleModalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">{{ __('All Attachments')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="ajax_offered_history_list">
                <div class="table_box">
                    <table class="data_table table responsive nowrap" id="ajax_deals_documents_list">
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="payment-data-modal" aria-labelledby="exampleModalToggleLabel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-20-medium" id="exampleModalToggleLabel">{{ __('See Payment Data')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="ajax_offered_history_list">
                <div class="table_box">
                    <table class="data_table table responsive nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('payment options') }}</th>
                                <th>{{ __('bank name') }}</th>
                                <th>{{ __('account number') }}</th>
                                <th>{{ __('phone company') }}</th>
                                <th>{{ __('phone number') }}</th>
                                <th>{{ __('identification id') }}</th>
                                <th>{{ __('payment note') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bank_details as $bank)
                                <tr>
                                    <td>{{ $bank->payment_options }}</td>
                                    <td>{{ $bank->issuer_bank?->name }}</td>
                                    <td>{{ $bank->account_number }}</td>
                                    <td>{{ $bank->phone_company }}</td>
                                    <td>{{ $bank->phone_number }}</td>
                                    <td>{{ $bank->identification_id }}</td>
                                    <td>{{ $bank->payment_note }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <p class="text-center font-weight-bold text-danger mt-3">
                                            {{ __('No Record Found.') }}
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <div class="sellermobile_detail">
                        @forelse ($bank_details as $bank)
                        <div class="open_mobile_content">
                            <div class="mobile_lr">
                                <p class="text-14-medium">{{ __('payment options') }}</p>
                                <h6 class="text-14-medium">{{ $bank->payment_options }}</h6>
                            </div>
                            <div class="mobile_lr">
                                <p class="text-14-medium">{{ __('bank name') }}</p>
                                <h6 class="text-14-medium">{{ $bank->issuer_bank?->name }}</h6>
                            </div>
                            <div class="mobile_lr">
                                <p class="text-14-medium">{{ __('account number') }}</p>
                                <h6 class="text-14-medium">{{ $bank->account_number }}</h6>
                            </div>
                            <div class="mobile_lr">
                                <p class="text-14-medium">{{ __('phone company') }}</p>
                                <h6 class="text-14-medium">{{ $bank->phone_company }}</h6>
                            </div>
                            <div class="mobile_lr">
                                <p class="text-14-medium">{{ __('phone number') }}</p>
                                <h6 class="text-14-medium">{{ $bank->phone_number }}</h6>
                            </div>
                            <div class="mobile_lr">
                                <p class="text-14-medium">{{ __('identification id') }}</p>
                                <h6 class="text-14-medium">{{ $bank->identification_id }}</h6>
                            </div>
                            <div class="mobile_lr">
                                <p class="text-14-medium">{{ __('payment note') }}</p>
                                <h6 class="text-14-medium">{{ $bank->payment_note }}</h6>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7">
                                <p class="text-center font-weight-bold text-danger mt-3">
                                    {{ __('No Record Found.') }}
                                </p>
                            </td>
                        </tr>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- pay commision :st--}}
<div class="pay_commisionModal">
    <div class="modal fade" id="btn_payment_mipo_commission_modal" aria-labelledby="exampleModalToggleLabel" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-20-medium" id="exampleModalToggleLabel">{{ __('Pago de Comisiones')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="paycommision_Table">
                        <table>
                            <thead>
                                <tr class="forbg">
                                    <th class="text-12-medium">{!! __('Details') !!}</th>
                                    <th class="text-12-medium">{!! __('Sub Total') !!}</th>
                                    <th class="text-12-medium">{!! __('Total') !!}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-12-medium">{!! __('Commission') !!}</td>
                                    <td class="text-12-medium">{{ app('common')->currencyBySymbol($preferred_currency) . '' . app('common')->currencyNumberFormat($preferred_currency, $mipo_commison) }}</td>
                                    <td class="text-12-medium">{{ app('common')->currencyBySymbol($preferred_currency) . '' . app('common')->currencyNumberFormat($preferred_currency, $mipo_commison) }}</td>
                                    {{-- <td><a href="javascript:;" class="text-14-medium">{!! __('View') !!}</a></td> --}}
                                </tr>
                                <tr>
                                    <td class="text-12-medium">{!! __('MIPO+') !!}</td>
                                    <td class="text-12-medium">{{ app('common')->currencyBySymbol($preferred_currency) . '' . app('common')->currencyNumberFormat($preferred_currency, $mipo_plus_commission) }}</td>
                                    <td class="text-12-medium">{{ app('common')->currencyBySymbol($preferred_currency) . '' . app('common')->currencyNumberFormat($preferred_currency, $mipo_plus_commission) }}</td>
                                    {{-- <td><a href="javascript:;" class="text-14-medium">{!! __('View') !!}</a></td> --}}
                                </tr>
                            </tbody>  
                        </table>
                        @php
                            if(isset($mipo_plus_commission) && $mipo_plus_commission > 0)
                            {
                                $total = ($mipo_commison + $mipo_plus_commission);
                            } else {
                                $total = ($mipo_commison);
                            }
                        @endphp
                        <div class="total">
                            <p class="text-12-medium">{{ app('common')->currencyBySymbol($preferred_currency) . '' . app('common')->currencyNumberFormat($preferred_currency, $total) }}</p>
                        </div>
                    </div>
                    <div class="detail">
                        <p class="text-12-medium">{!! __('Tener en cuenta al momento de pagar las') !!} <span class="text-12-medium">{{ __('comisiones a MIPO')}},</span>{{ __('que el') }}<span class="text-12-medium">{{ __('pago es realizado en Guaranies')}}</span>,{{ __('por ende el monto en dolares mencionado arriba sera convertido') }}.</p>
                        <p class="text-12-medium">{!! __('Tipo de Cambio Actual') !!}: 1 USD a <strong class="text-12-semibold">7.300 Gs.</strong></p>
                    </div>

                    <div class="formdetail_wrap">
                        <h3 class="text-20-medium">{!! __('Formas de pago') !!}</h3>
                        <div class="titlerow fdata">
                            <div class="lft"><p class="text-14-medium">{!! __('Transferencia Bancaria') !!}</p></div>
                            <div class="right"><p class="text-14-medium">{!! __('Tarjeta de Credito/Debito') !!}</p></div>
                        </div>
                        <div class="fdata">
                            <div class="lft">
                                {!! app('common')->getSettingsVal()->bank_details !!}
                                {{-- <p class="text-12-medium"> {!! app('common')->getSettingsVal()->bank_details !!} </p> --}}
                            {{--     <p class="text-12-medium">{!! __('Titular') !!}:<span class="text-12-medium">{!! __('Blufish S.A.') !!}</span></p>
                                <p class="text-12-medium">{!! __('RUC') !!}:<span class="text-12-medium">80073934-5</span></p>
                                <p class="text-12-medium">{!! __('Nro de Cuenta') !!}:<span class="text-12-medium">14559514</span></p>
                                <p class="text-12-medium">{!! __('Banco') !!}:<span class="text-12-medium">{!! __('Visión Banco') !!}</span></p> --}}
                            </div>
                            <div class="right">
                                <div class="imgbox">
                                <a href="javascript:;" id="evt_btn_payment_now" role="button"><i><img src="{{ asset('images/mipo/vpos.svg') }}" alt="no-image"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- pay commision :st--}}

<div class="cashed_modal">
    <div class="modal fade" id="is_cashed_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-20-medium" id="deals_modal_heading">{{ __('Document’s Cashing Date') }}</h5>
                    <button type="button" class="btn-close is_cashed_date_modal_close"aria-label="Close"></button>
                </div>
                <form name="create_is_cashed_form" id="create_is_cashed_form" class="form-validation"
                    method="post" action="javascript:;" novalidate="novalidate"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="profile_inputbox">
                            <label class="text-14-medium">{{ __('Date of Cashing') }}</label>
                            <input type="text" id="is_cashed_date" name="is_cashed_date" value="{{ date('d/m/Y') }}" class="form-control evt_cashed_date" readonly/>
                            <div class="imgbox"><img src="{{ asset('images/mipo/cash_calendar.svg') }}" alt="no-image"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="create_is_cashed_btn">{{ __('Submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->
<!-- Modal -->
<div class="view_review_modal">
    <div class="modal fade deals_feedback_modal" id="evt_deals_feedback_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-20-semibold">{!! __('Deal Actions') !!}</h5>
                </div>
                <div id="ajax_deals_feedback_modal">
            
                </div>
            </div>
        </div>
    </div>
</div>


{{--buyer-to-seller-payment-modal --}}
<div class="pay_commisionModal qrmodal">
    <div class="modal fade" id="buyer-to-seller-payment-modal" aria-labelledby="exampleModalToggleLabel" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-20-medium" id="exampleModalToggleLabel">{{ __('Seller Payment Details')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="paycommision_Table">
                        <table>
                            <thead>
                                <tr class="forbg">
                                    <th class="text-14-semibold" style="width: 60%">{!! __('Details') !!}</th>
                                    <th class="text-14-semibold">{!! __('Total') !!}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($operation_detail->operations as $key => $operation)
                                <tr>
                                    <td class="text-14-medium"  style="width: 60%">{{  $operation->operation_number }} - {{ ($operation->operation_type == 'Cheque') ? __('Check') : __($operation->operation_type) }}</td>
                                    {{-- <td class="text-14-medium">{{ app('common')->currencyBySymbol($operation->preferred_currency) . '' . app('common')->currencyNumberFormat($operation->preferred_currency, $operation->amount) }}</td> --}}
                                    <td class="text-14-medium">{{ app('common')->currencyBySymbol($operation->preferred_currency) . '' . app('common')->currencyNumberFormat($operation->preferred_currency, $real_time_offer) }}</td>
                                </tr>
                                @endforeach
                            </tbody>  
                        </table>
                        @php
                            $total = 0;
                        @endphp
                        <div class="total">
                            <p class="text-12-medium">{{ app('common')->currencyBySymbol($preferred_currency) . '' . app('common')->currencyNumberFormat($preferred_currency, $real_time_offer) }}</p>
                        </div>
                    </div>
                    {{-- <div class="detail">
                        <p class="text-12-medium">{!! __('Tener en cuenta al momento de pagar las') !!} <span class="text-12-medium">{{ __('comisiones a MIPO')}},</span>{{ __('que el') }}<span class="text-12-medium">{{ __('pago es realizado en Guaranies')}}</span>,{{ __('por ende el monto en dolares mencionado arriba sera convertido') }}.</p>
                        <p class="text-12-medium">{!! __('Tipo de Cambio Actual') !!}: 1 USD a <strong class="text-12-semibold">7.300 Gs.</strong></p>
                    </div> --}}

                    <div class="formdetail_wrap">
                        <h3 class="text-20-medium">{!! __('Formas de pago') !!}</h3>
                        <div class="titlerow fdata">
                            <div class="lft"><p class="text-12-semibold">{!! __('Transferencia Bancaria') !!}</p></div>
                            <div class="right"><p class="text-12-semibold">{!! __('Billetera Electronica') !!}</p></div>
                            

                        </div>
                        <div class="fdata">
                            <div class="lft lft_detail">
                                {{-- {!! app('common')->getSettingsVal()->bank_details !!} --}}

                                <p class="text-12-medium"><span>{!! __('Titular') !!}: </span>Roberto Perez</p>
                                <p class="text-12-medium"><span>{!! __('RUC') !!}: </span>80073934-5</p>
                                <p class="text-12-medium"><span>{!! __('Nro de Cuenta') !!}: </span>14559514</p>
                                <p class="text-12-medium"><span>{!! __('Banco') !!}: </span>Visión Banco</p>
                            </div>
                            <div class="center lft_detail">
                                <p class="text-12-medium"><span>{!! __('Titular') !!}: </span>Roberto Perez</p>
                                <p class="text-12-medium"><span>{!! __('RUC') !!}: </span>80073934-5</p>
                                <p class="text-12-medium"><span>{!! __('Nro de Cuenta') !!}: </span>14559514</p>
                                <p class="text-12-medium"><span>{!! __('Banco') !!}: </span>Visión Banco</p>
                            </div>
                        </div>
                        <div class="bottom">
                            
                            <div class="imgbox">
                             {{-- <a href="javascript:;"><i><img src="{{ asset('images/mipo/qrmodal_scan.svg') }}" alt="no-image"></i></a> --}}
                             
                            <a href="javascript:;" id="cameraLink">
                                <p class="text-14-semibold">{!! __('Click here to open camera to Scan QR') !!}</p>
                                <i><img src="{{ asset('images/new_qr.svg') }}" alt="no-image"></i>
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-confrim-offer-contract-modal></x-confrim-offer-contract-modal>

<x-deal-cashed-multiple-modal></x-deal-cashed-multiple-modal>

<x-deal-cashed-dispute-multiple-modal></x-deal-cashed-dispute-multiple-modal>

{{-- camera modal --}}

<div class="modal fade" id="scan_qr_modal" aria-labelledby="exampleModalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">{{ __('Scan Qrcode')}}</h5>
                <button type="button" class="btn-close scan_qr_modal_close"></button>
            </div>
            <div class="modal-body" id="my-qr-reader">
            
            </div>
        </div>
    </div>
</div>
{{-- <div class="modal fade deals_feedback_modal" id="evt_deals_feedback_modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body" id="ajax_deals_feedback_modal 1">

            </div>
        </div>
    </div>
</div> --}}

    @section('custom_script')
        <script>
            const ajax_url_resend_otp_url = "{{ route('counter-offer.ajax-confirm-offer-pdf') }}";
            const DEFAULT_FEEDBACK_RATE = "{{ config('constants.DEFAULT_FEEDBACK_RATE') }}";
            const DEFAULT_ISSUERS_RATE = "{{ config('constants.DEFAULT_ISSUERS_RATE') }}";
            const OFFER_SLUG = "{{ $operation_detail->slug }}";
            const OFFER_id = "{{ $operation_detail->id }}";
            const OFFER_STATUS = "{{ $operation_detail->offer_status }}";
            const URL_IS_CASHED = "{{ route('deals.ajax-create-cashed', '') }}";
            const URL_IS_DISPUTE = "{{ route('deals.ajax-create-disputes', '') }}";
            const USER_TYPE = "{{ $type }}";
            var frm_one_auto_expire = $('#frm_one_auto_expire');
            var frm_one_days_txt = $('#frm_one_days_txt');
            var frm_one_days_desc = $('#frm_one_days_desc');
            
            var frm_two_auto_expire = $('#frm_two_auto_expire');
            var frm_two_days_txt = $('#frm_two_days_txt');
            var frm_two_days_desc = $('#frm_two_days_desc');
            var cashed_modal = $('#is_cashed_modal');
            const URL_MULTIPLE_FEEDBACK = "{{ route('deals.ajax-multiple-feedback', '') }}";
            const pdf_img = "{{ asset('images/mipo/pdf.png') }}";
    </script>
        <script src="{{ asset('plugins/dropzone/dropzone.min.js') }}"></script>
        <script src="{{ asset('js/file-upload.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/deals-contracts.js') }}"></script>
        <script src="{{ asset('js/deals-cashed-multiple.js') }}"></script>
        <script src="{{ asset('plugins/rateit/jquery.rateit.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/intl-tel-input-17.0.19/build/js/intlTelInput-jquery.min.js') }}"></script>
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
        <script src="{{ asset('js/deals-scan-qr.js') }}"></script>
        <script>
        
            $(document).ready(function() {

                if(OFFER_STATUS == 'Completed') {
                    $('.stepbox').removeClass('current_progress');
                    $('.stepbox').addClass('green');
                }
                
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1;
                var yyyy = today.getFullYear();
                if(dd < 10)
                {
                    dd='0'+dd
                }
                if(mm < 10){
                    mm='0'+mm
                } 

                today = yyyy+'-'+mm+'-'+dd;
                document.getElementById("is_cashed_date").setAttribute("max", today);

                // loadMoreDealsPrivateNoteData();
                dealsPhoneNumber();

                var dispute_modal = $('#dispute_modal');

                $('div.feedback_rateit, span.rateit').rateit({
                    resetable: false,
                });

                $('.feedback_rateit').on('beforerated', function(e, value) {
                    $(this).attr('data-rateit-value', value);
                    $('#sell_feedback_rate').val(value);
                    /*if (!confirm('Are you sure you want to rate this item: ' +  value + ' stars?')) {
                        e.preventDefault();
                    }*/
                });

                $('div.issuer_rateit, span.rateit').rateit({
                    resetable: false,
                });

                $('.issuer_rateit').on('beforerated', function(e, value) {
                    $(this).attr('data-rateit-value', value);
                    $('#pay_issuer_rate').val(value);
                });

                $('.evt_qr_code_modal').on('click', function(e) {
                    var self = $(this);
                    var setp_id = self.attr('data-step-id');
                    var user_type = USER_TYPE;
                    var slug = OFFER_SLUG;
                    $('#evt_qr_code_modal_open').modal('show');
                });

                $('#same-rating').on('click', function(e) {
                    var self = $(this);
                    if (self.is(':checked')) {
                        var feedback_rateit_val = $('.feedback_rateit').attr('data-rateit-value');
                        $('.issuer_rateit').attr('data-rateit-value', feedback_rateit_val);

                        $('div.issuer_rateit').rateit('value', feedback_rateit_val);

                        flag_auto_expire = frm_one_auto_expire.is(':checked') ? true : false;
                        frm_two_auto_expire.prop('checked', flag_auto_expire);

                        $(`.evt_frm_two_transaction`).prop('checked', false);
                        $(`.evt_frm_two_transaction`).parent('.btn').removeClass('active');

                        $(`.evt_frm_two_document`).prop('checked', false);
                        $(`.evt_frm_two_document`).parent('.btn').removeClass('active');

                        var sell_trans_doctype = $('input[name=sell_trans_doctype]:checked').val();
                        $(`.evt_frm_two_transaction[value|='${sell_trans_doctype}']`).prop('checked', true);
                        $(`.evt_frm_two_transaction[value|='${sell_trans_doctype}']`).parent('.btn').addClass(
                            'active');

                        var sell_doc_doctype = $('input[name=sell_doc_doctype]:checked').val();
                        $(`.evt_frm_two_document[value|='${sell_doc_doctype}']`).prop('checked', true);
                        $(`.evt_frm_two_document[value|='${sell_doc_doctype}']`).parent('.btn').addClass(
                            'active');

                        frm_two_days_txt.val(frm_one_days_txt.val());
                        frm_two_days_desc.val(frm_one_days_desc.val());
                    } else {
                        resetRatingForm();
                    }
                });

                $('.evt_rating_modal_skip').click(function(e) {
                    e.preventDefault();
                    resetRatingForm();
                    $('#rating-modal').modal('hide');
                });

                $("#frm_deals_rating").on("submit", function(event) {
                    event.preventDefault();
                    let form = $(this);
                    let form_valid = form.valid();
                    if (form_valid) {
                        setLoadin();
                        let action_url = form.attr('action');
                        $.ajax({
                            type: "POST",
                            url: action_url,
                            data: form.serialize(),
                            dataType: 'json',
                            success: function(res) {
                                unsetLoadin();
                                resetRatingForm();
                                $('#rating-modal').modal('hide');
                                if (res.status == true) {
                                    $('.is_rate_div').hide();
                                    toastr.success(res.message);
                                } else {
                                    toastr.error(res.message);
                                }
                            },
                            error: function(xhr) {
                                unsetLoadin();
                                ajaxErrorMsg(xhr);
                            }
                        });
                    }
                });

                $('.evt_report_dispute').click(function() {
                    var self = $(this);
                    var offer_id = self.attr('data-offer-id');
                    dispute_modal.modal('show');
                });

                $("#disputes_form").submit(function(e) {
                    e.preventDefault();
                    let form = $(this);
                    let form_valid = form.valid();
                    if (form_valid) {
                        setLoadin();
                        let formData = new FormData($('#disputes_form')[0]);
                        let actionUrl = form.attr('action');
                        $.ajax({
                            type: "POST",
                            url: actionUrl,
                            data: formData,
                            dataType: 'json',
                            cache: false,
                            processData: false,
                            contentType: false,
                            success: function(res) {
                                $("#disputes_note").val('');
                                $("#disputes_file").val('');
                                unsetLoadin();
                                if (res.status == true) {
                                    $('.evt_report_dispute').hide();
                                    $('#show_disputes_note').text(res.data.disputes_note);
                                    $('.is_rate_div').hide();
                                    $('.is_cashed_div').hide();
                                    $('.is_rate_cashed_div').hide();
                                    dispute_modal.modal('hide');
                                    toastr.success(res.message);
                                } else {
                                    toastr.error(res.message);
                                }
                            },
                            error: function(xhr) {
                                unsetLoadin();
                                ajaxErrorMsg(xhr);
                            }
                        });
                    }
                });

                // $('.evt_is_cashed_switch').change(function(e) {
                $('.evt_is_cashed_switch').click(function(e) {
                    e.preventDefault();
                    var self = $(this);
                    Swal.fire({
                        title: ays_en_msg,
                        text: ays_cashed_en_msg,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#198754',
                        cancelButtonColor: '#13153B',
                        confirmButtonText: yes_en_msg,
                        cancelButtonText:cancle_en_msg
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var is_cashed = 'No';
                            var offer_slug = self.attr('data-offer-slug');
                            var data_step_id = self.attr('data-step-id');
                            cashed_modal.modal('show');
                        } else {
                            // self.prop('checked', false);
                            cashed_modal.modal('hide');
                        }
                    });
                });

                $(document).on('click', '.is_cashed_date_modal_close', function(e) {
                    e.preventDefault();
                    cashed_modal.modal('hide');
                    $('body .evt_is_cashed_switch').prop('checked', false);
                });

                $(document).on('click', '#create_is_cashed_btn', function(e) {
                    e.preventDefault();
                    var obj_chk = $('.evt_is_cashed_switch');
                    var data_step_id = obj_chk.attr('data-step-id');

                    if(data_step_id) 
                    {
                        $.ajax({
                            type: "POST",
                            url: URL_IS_CASHED + '/' + OFFER_SLUG,
                            data: {
                                'is_cashed': 'Yes',
                                'user_type': USER_TYPE,
                                'data_step_id': data_step_id,
                                'cashed_date' : $('#is_cashed_date').val()
                            },
                            dataType: 'json',
                            success: function (res) {
                                unsetLoadin();
                                if (res.status == true) {
                                    location.reload();
                                    // $('.is_cashed_div').hide();
                                    cashed_modal.modal('hide');
                                    toastr.success(res.message);
                                } else {
                                    toastr.error(res.message);
                                }
                            },
                            error: function (xhr) {
                                unsetLoadin();
                                ajaxErrorMsg(xhr);
                            }
                        });
                    }
                });
                
                $('.evt_is_filed').on('change', function(e) {
                    e.preventDefault();
                    var self = $(this);
                    Swal.fire({
                        title: ays_en_msg,
                        text: ays_file_upload_en_msg,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#198754',
                        cancelButtonColor: '#13153B',
                        confirmButtonText: yes_en_msg,
                        cancelButtonText: cancle_en_msg
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var user_type = $(this).attr('data-type');
                            var formData = new FormData();
                            formData.append('deals_file', $(this)[0].files[0]);
                            formData.append('deals_slug', OFFER_SLUG);
                            formData.append('deals_user_type', user_type);
                            formData.append('data_step_id', self.attr('data-step-id'));
                            formData.append('upload_type', 'deals');
                            setLoadin();
                            $.ajax({
                                type: "POST",
                                url: "{{ route('deals.ajax-file-upload') }}",
                                data: formData,
                                dataType: 'json',
                                cache: false,
                                processData: false,
                                contentType: false,
                                success: function(res) {
                                    unsetLoadin();
                                    $("input[type='file']").val('');
                                    if (res.status == true) {
                                        /* 
                                            $('.is_filed_div').remove();
                                            self.remove(); 
                                        */
                                        $('.kwt-file__delete').remove();
                                        $('.kwt-file__msg').text('or drop files here');
                                        toastr.success(res.message);
                                    } else {
                                        toastr.error(res.message);
                                    }
                                },
                                error: function(xhr) {
                                    $("input[type='file']").val('');
                                    unsetLoadin();
                                    ajaxErrorMsg(xhr);
                                }
                            });
                        } else {
                            $('.kwt-file__delete').trigger('click');
                            $("input[type='file']").val('');
                        }
                    });
                });
                
                $('.evt_extra_file_doc').on('change', function(e) {
                    e.preventDefault();
                    var self = $(this);
                    Swal.fire({
                        title: ays_en_msg,
                        text: ays_file_upload_en_msg,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#198754',
                        cancelButtonColor: '#13153B',
                        confirmButtonText: yes_en_msg,
                        cancelButtonText: cancle_en_msg
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var user_type = $(this).attr('data-type');
                            var formData = new FormData();
                            formData.append('deals_file', $(this)[0].files[0]);
                            formData.append('deals_slug', OFFER_SLUG);
                            formData.append('deals_user_type', user_type);
                            formData.append('data_step_id', '0');
                            formData.append('upload_type', 'deals_attached_file');
                            setLoadin();
                            $.ajax({
                                type: "POST",
                                url: "{{ route('deals.ajax-file-upload') }}",
                                data: formData,
                                dataType: 'json',
                                cache: false,
                                processData: false,
                                contentType: false,
                                success: function(res) {
                                    unsetLoadin();
                                    $("#evt_extra_file_doc input[type='file']").val('');
                                    if (res.status == true) {
                                        $('.kwt-file__delete').remove();
                                        $('.kwt-file__msg').text('or drop files here');
                                        toastr.success(res.message);
                                    } else {
                                        toastr.error(res.message);
                                    }
                                },
                                error: function(xhr) {
                                    $("#evt_extra_file_doc input[type='file']").val('');
                                    unsetLoadin();
                                    ajaxErrorMsg(xhr);
                                }
                            });
                        } else {
                            $('.kwt-file__delete').trigger('click');
                            $("#evt_extra_file_doc input[type='file']").val('');
                        }
                    });
                });
                
                if($(".deal_stap_row").last().hasClass("waiting_progess"))
                {
                    $(".deal_stap_row").last().removeClass('waiting_progess');
                }
            });

            $(document).on('click', '.evt_operations_details', function(e) {
                e.preventDefault();
                var details_link = $(this).attr('data-operations-details-link');
                window.location.href = details_link;
            });

            function resetRatingForm() {
                $('div.issuer_rateit').rateit('value', DEFAULT_ISSUERS_RATE);
                $('#pay_issuer_rate').val(DEFAULT_ISSUERS_RATE);
                $('.issuer_rateit').attr('data-rateit-value', DEFAULT_ISSUERS_RATE);

                $('div.feedback_rateit').rateit('value', DEFAULT_FEEDBACK_RATE);
                $('#sell_feedback_rate').val(DEFAULT_FEEDBACK_RATE);
                $('.feedback_rateit').attr('data-rateit-value', DEFAULT_FEEDBACK_RATE);

                $(`.evt_frm_two_transaction`).prop('checked', false);
                $(`.evt_frm_two_transaction`).parent('.btn').removeClass('active');

                $(`.evt_frm_two_document`).prop('checked', false);
                $(`.evt_frm_two_document`).parent('.btn').removeClass('active');
                frm_two_auto_expire.prop('checked', false);

                $(`.evt_use_same_rate_seller`).prop('checked', false);

                frm_one_auto_expire.prop('checked', false);
                frm_one_days_txt.val('');
                frm_one_days_desc.val('');

                frm_two_days_txt.val('');
                frm_two_days_desc.val('');
            }

            $(document).on('click', '#add_private_note', function(e) {
                e.preventDefault();
                $('#deals_private_note_id').val('');
                $('#deals_private_note').val('');
                $('#deals_btn_name').text('Add');
                $('#deals_modal_heading').text('Add Private Note');
                $('#deals_private_note_action').val('add');
                
                $('#deals_private_note_modal').modal('show');
            });

            $(document).on('click', '.evt_deal_note_edit', function(e) {
                var self = $(this);
                var note = self.attr('data-note');
                var note_id= self.attr('data-id');
                var note_action = self.attr('data-action');
                $('#deals_modal_heading').text('Edit Private Note');
                $('#deals_btn_name').text('Update');
                $('#deals_private_note').val(note);
                $('#deals_private_note_id').val(note_id);
                $('#deals_private_note_action').val('update');
                $('#deals_private_note_modal').modal('show');
            });

            $(document).on('click', '.evt_deal_note_delete', function(e) {
                var self = $(this);
                var note_id= self.attr('data-id');
                var note_action = 'delete';
                Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure, you want to permanent delete this?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#13153B',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // second
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Are you sure, you want to permanent delete this?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#13153B',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('deals.ajax-private-note-crud') }}",
                                data : {
                                    'deals_private_note_action' : 'delete',
                                    'deals_id' : OFFER_id,
                                    'deals_private_note_id' : note_id
                                },
                                dataType: 'json',
                                success: function (res) {
                                    if (res.status == true) {
                                        toastr.success(res.message);
                                        loadMoreDealsPrivateNoteData();
                                        Swal.fire(
                                            'Deleted!',
                                            'Your record has been deleted.',
                                            'success'
                                            )
                                        } else {
                                        toastr.error(res.message);
                                    }
                                },
                                error: function (xhr) {
                                    unsetLoadin();
                                    ajaxErrorMsg(xhr);
                                }
                            });
                        }
                    });
                }
            });
            });

            function loadMoreDealsPrivateNoteData() {
                $.ajax({
                    type: "POST",
                    url: "{{ route('deals.ajax-private-note-list')}}",
                    data : {
                        'deals_id' : OFFER_id
                    },
                    dataType: 'json',
                    success: function(res) {
                        unsetLoadin();
                        if (res.status == true) {
                            $('#ajax_deals_privte_note_list').html(res.data.dhtml);
                            toastr.success(res.message);
                        } else {
                            toastr.error(res.message);
                        }
                    },
                    error: function(xhr) {
                        unsetLoadin();
                        ajaxErrorMsg(xhr);
                    }
                });
            }

            $("#deals_private_note_form").submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let form_valid = form.valid();
                if (form_valid) {
                    setLoadin();
                    let formData = new FormData($('#deals_private_note_form')[0]);
                    let actionUrl = form.attr('action');
                    $.ajax({
                        type: "POST",
                        url: actionUrl,
                        data: formData,
                        dataType: 'json',
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            unsetLoadin();
                            if (res.status == true) {
                                $("#deals_private_note").val('');
                                loadMoreDealsPrivateNoteData();
                                $('#deals_private_note_modal').modal('hide');
                                toastr.success(res.message);
                            } else {
                                toastr.error(res.message);
                            }
                        },
                        error: function(xhr) {
                            unsetLoadin();
                            ajaxErrorMsg(xhr);
                        }
                    });
                }
            });

            $(document).on('click', '#btn_sign_contract', function() {
                    var self = $(this);
                    var offer_id = self.attr('data-offer-id');
                    var offer_status = self.attr('data-status');
                    var form_data = {
                        'offer_id': offer_id,
                        'otp_resend': false,
                        'offer_status': offer_status,
                    }

                    if (offer_id != '' && offer_status != '') {
                        Swal.fire({
                            title: ays_en_msg,
                            text: ays_sing_en_msg,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#0D6EFD',
                            cancelButtonColor: '#2E365A',
                            confirmButtonText: yes_en_msg,
                            cancelButtonText: cancle_en_msg
                        }).then((result) => {
                            if (result.isConfirmed) {
                                setLoadin();
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('counter-offer.ajax-confirm-offer-pdf') }}",
                                    data: form_data,
                                    dataType: 'json',
                                    success: function(res) {
                                        unsetLoadin();
                                        if (res.status == true) {
                                            $('#ajax_confrim_offer_contract').html(res.data.dhtml);
                                            $('#deals_contract_form')[0].reset();
                                            $('#confrim_offer_contract_modal').modal('show');
                                            /*  var select_box = $('.evt_div_select_option_box');
                                            
                                            var select_box_operation = "";
                                            if(res.data.is_user_company == 1 && res.data.user_contract_sing.length > 0)
                                            {
                                                $('#evt_div_select_box_deals_contract_name').show();
                                                $('#evt_div_text_box_deals_contract_name').remove();
                                                
                                                select_box_operation +=`<option value="">Select Contract User</option>`;
                                                res.data.user_contract_sing.forEach(user_name => {
                                                    select_box_operation +=`<option value="${user_name}">${user_name}</option>`;
                                                });
                                                select_box.html(select_box_operation);
                                            } else {
                                                $('#evt_div_text_box_deals_contract_name').show();
                                                $('#evt_div_select_box_deals_contract_name').remove();
                                            } */
                                            
                                            $('body #deal_otp').text(res.data.otp);
                                            dealsPhoneNumber();
                                        } else {
                                            toastr.error(res.message);
                                        }
                                    },
                                    error: function(xhr) {
                                        unsetLoadin();
                                        ajaxErrorMsg(xhr);
                                    }
                                });
                            }
                        })
                    } else {
                        toastr.error(please_sel_ofr_en_msg);
                    }
            });

            $(document).on('click', '.evt_show_attachments_modal', function() {
                var self = $(this);
                var form_data = {
                    'deals_id': OFFER_id,
                    'deals_user_type': USER_TYPE,
                    'upload_type': $(this).attr('data-file-show'),
                }

                if (OFFER_id != '' && USER_TYPE) {
                    $.ajax({
                            type: "POST",
                            url: "{{ route('deals.ajax-user-document-list') }}",
                            data: form_data,
                            dataType: 'json',
                            success: function(res) {
                                unsetLoadin();
                                if (res.status == true) {
                                    toastr.success(res.message);
                                    $('#ajax_deals_documents_list').html(res.data.dhtml);
                                    $('#show_attachments_modal').modal('show');
                                } else {
                                    toastr.error(res.message);
                                }
                            },
                            error: function(xhr) {
                                unsetLoadin();
                                ajaxErrorMsg(xhr);
                            }
                    });
                } else {
                    toastr.error(please_sel_ofr_en_msg);
                }
            });

            function dealsPhoneNumber()
            {
                $("#deals_contract_phone").intlTelInput({
                    initialCountry: "py",
                    separateDialCode: true,
                    utilsScript: "{{ asset('plugins/intl-tel-input-17.0.19/build/js/utils.js') }}",
                    hiddenInput: "phone_number",
                });
            }

            $(document).on('click', '.btn_payment_mipo_commission_modal', function(e) {
                $('#btn_payment_mipo_commission_modal').modal('show');
            });

            $(document).on('click', '#evt_btn_payment_now', function(e) {
                var pay_now_url =  $('.btn_payment_mipo_commission_modal').attr('data-pay-now-url');
                if(pay_now_url!=''){
                    window.location.href = pay_now_url;
                }
            });

            $(document).on('click', '.evt_sign_contract_btn', function(e) {
                $('#confrim_offer_contract_modal').modal('hide');
            });
            
        </script>
    @endsection
</x-app-layout>
