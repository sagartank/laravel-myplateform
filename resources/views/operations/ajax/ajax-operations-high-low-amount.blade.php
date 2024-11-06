<div class="my_secondopera">
    <div class="heading">
        <a href="javascript:;"><img src="{{ asset('images/mipo/dashboardsubpageleft.svg') }}" alt="no-image"></a>
        <h3 class="text-20-semibold">{!! __('My Operations') !!}</h3>
    </div>
    @if ($offers && $offers->count() > 0)
        @php
            $high_amount = $offers->max('amount');
            $currency = app('common')->currencyBySymbol($offers->first()->preferred_currency);
            $high = app('common')->currencyNumberFormat($offers->first()->preferred_currency, $offers->max('amount'));
            $min = app('common')->currencyNumberFormat($offers->first()->preferred_currency, $offers->min('amount'));
            $avg = app('common')->currencyNumberFormat($offers->first()->preferred_currency, $offers->avg('amount'));
        @endphp
        <input type="hidden" name="offer_high_value" value="{{ $currency }}{{ $high }}" id="offer_high_value">
        <input type="hidden" name="offer_low_value" value="{{ $currency }}{{ $min }}" id="offer_low_value">
        <input type="hidden" name="offer_avg_value" value="{{ $currency }}{{ $avg }}" id="offer_avg_value">
        <div class="lishow_wrap">
            <a href="javascript:;" class="list_opera">
                <div class="list_opera_left_part">
                    <div class="list_opera_checkbox">
                        <h6 class="text-14-medium">{{ $operation->operation_type_number }}</h6>
                        <p class="text-14-medium">{{ __($operation->preferred_payment_method) }}</p>
                    </div>
                    <div class="list_opera_company text-14-medium">{{ $operation->issuer?->company_name ?? __('N/A') }}</div>
                    <div class="list_imgbox">
                        <div class="list_opera_imgtext">
                            <i class="light"><img src="{{ asset('images/mipo/offerframe9.svg') }}" alt="no-image"></i>
                            <i class="dark"><img src="{{ asset('images/mipo/offerdarkframe9.svg') }}" alt="no-image"></i>
                            <span class="text-14-medium">
                                {!! app('common')->responsibility($operation->responsibility) !!}
                            </span>
                        </div>
                        <div class="list_opera_imgtext">
                            @if($operation->preferred_currency == 'USD')
                                    <i class="light"><img src="{{ asset('images/mipo/offerlightdollar.svg') }}" alt="no-image"></i>
                                    <i class="dark"><img src="{{ asset('images/mipo/offerdarkmodedollar.svg') }}" alt="no-image"></i>
                                @else
                                    <i class="light"><img src="{{ asset('images/mipo/guarani-light-20-by-20.svg') }}" alt="no-image"></i>
                                    <i class="dark"><img src="{{ asset('images/mipo/guarani-dark-20-by-20.svg') }}" alt="no-image"></i>
                                @endif
                            <span class="text-14-medium">
                                {{-- {{ app('common')->currencyBySymbol($operation->preferred_currency) }} --}}
                                {{ app('common')->currencyNumberFormat($operation->preferred_currency, $operation->amount) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="list_opera_right_part">
                    <p class="text-14-medium" data-info="operation expiration date">
                        {{ app('common')->diffForHumans($operation->expiration_date) }}
                        {{-- {!! __('Expires in') !!} {{  $operation->expire_at }} --}}
                    </p>
                    <div class="list-opera-ul">
                        <ul>
                            <li>
                                <svg width="14" height="14" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="Group 48095939">
                                        <path id="Vector" d="M6.48935 9.99993H1.8734C1.3924 9.99993 1 9.60753 1 9.12653V3.45153C1 2.97052 1.3924 2.57812 1.8734 2.57812H9.16862C9.64963 2.57812 10.042 2.97052 10.042 3.45153V7.19407" stroke="#939393" stroke-width="0.8" stroke-miterlimit="10"/>
                                        <path id="Vector_2" d="M7.96484 1V2.57803" stroke="#939393" stroke-width="0.8" stroke-miterlimit="10" stroke-linecap="round"/>
                                        <path id="Vector_3" d="M3.08594 1V2.57803" stroke="#939393" stroke-width="0.8" stroke-miterlimit="10" stroke-linecap="round"/>
                                        <path id="Vector_4" d="M1 4.55664H10.0462" stroke="#939393" stroke-width="0.8" stroke-miterlimit="10"/>
                                        <path id="Vector_5" fill-rule="evenodd" clip-rule="evenodd" d="M10.6416 8.73094C10.6416 9.98408 9.6247 11.0009 8.37156 11.0009C7.11842 11.0009 6.10578 9.98408 6.10156 8.73094C6.10156 7.4778 7.11842 6.46094 8.37156 6.46094C9.6247 6.46094 10.6416 7.4778 10.6416 8.73094Z" stroke="#939393" stroke-width="0.8" stroke-miterlimit="10"/>
                                        <path id="Vector_6" d="M7.12891 8.6504L7.93058 9.41832C8.00231 9.48583 8.11623 9.48583 8.18374 9.41832L9.60987 7.99219" stroke="#939393" stroke-width="0.8" stroke-miterlimit="10" stroke-linecap="round"/>
                                    </g>
                                </svg>
                            </li>
                            <li>
                                <svg width="14" height="14" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="Group 48095941">
                                        <path id="path1272" d="M6.52775 2.91211C5.24126 2.91211 4.19922 3.95515 4.19922 5.23997C4.19922 6.52479 5.24126 7.56916 6.52775 7.56916C7.81423 7.56916 8.85627 6.52612 8.85627 5.23997C8.85627 3.95382 7.81423 2.91211 6.52775 2.91211Z" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path id="path1276" d="M8.822 5.65572H8.85863C10.1451 5.65572 11.1872 4.61368 11.1872 3.32786C11.1872 2.04204 10.1451 1 8.85863 1C7.71435 1 6.76289 1.82557 6.56641 2.91391" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path id="path1280" d="M6.48794 2.91391C6.29279 1.82557 5.34 1 4.19571 1C2.90923 1 1.86719 2.04204 1.86719 3.32786C1.86719 4.61368 2.90923 5.65572 4.19571 5.65572H4.23235" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path id="path1284" d="M5.06715 7.05469C3.83229 7.61451 2.96875 8.85903 2.96875 10.2974V10.9994H10.0855V10.2974C10.0855 8.85903 9.222 7.61451 7.98714 7.05469" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path id="path1288" d="M9.87109 9.08533H12.4138V8.38331C12.4138 6.9463 11.5489 5.70044 10.3144 5.14062" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path id="path1292" d="M2.7387 5.14062C1.50383 5.70044 0.640625 6.9463 0.640625 8.38331V9.08533H3.18196" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                </svg>
                            </li>
                            <li>
                                <svg width="14" height="14" viewBox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="Group 48095943">
                                        <path id="path1017" d="M7.8829 3.66155V10.585C7.8829 10.8142 7.69712 11 7.46792 11H0.82905C0.59985 11 0.414062 10.8142 0.414062 10.585V1.41499C0.414062 1.18579 0.59985 1 0.82905 1H5.22151C5.33152 1 5.43701 1.04372 5.51481 1.12152L7.76138 3.36809C7.83918 3.44589 7.8829 3.55139 7.8829 3.66155Z" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path id="path1021" d="M7.818 3.48871H5.80561C5.57641 3.48871 5.39062 3.30292 5.39062 3.07372V1.08203" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path id="path1025" d="M4.48438 5.12891H6.4672" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path id="path1029" d="M4.48438 7.20312H6.4672" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path id="path1033" d="M4.48438 9.27734H6.47607" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path id="path1037" d="M1.82422 5.04849L2.21353 5.43781L3.15118 4.5" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path id="path1041" d="M1.82422 7.28271L2.21353 7.67203L3.15118 6.73438" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path id="path1045" d="M1.82422 9.35693L2.21353 9.74624L3.15118 8.80859" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                </svg>
                            </li>
                            <li>
                                <svg width="14" height="14" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="Group 48095935">
                                        <path id="Vector" d="M1.73828 11.0004C3.6429 9.85751 4.59549 8.71463 4.59549 7.57175C4.59549 5.85742 4.02405 5.85742 3.45261 5.85742C2.88116 5.85742 2.29144 6.47744 2.30972 7.57175C2.32915 8.74206 3.25717 9.21578 3.73833 9.85751C4.59549 11.0004 5.16693 11.2861 5.73837 10.429C6.11952 9.85751 6.40525 9.3815 6.59554 9.00035C7.16698 10.3335 7.92871 11.0004 8.8813 11.0004H10.3099" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path id="Vector_2" d="M11.4537 9.8576V3.00031C11.4537 2.35972 10.9514 1.85742 10.3109 1.85742C9.67027 1.85742 9.16797 2.35972 9.16797 3.00031V9.8576L10.3109 11.0005L11.4537 9.8576Z" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path id="Vector_3" d="M9.16797 4.14258H11.4537" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path id="Vector_4" d="M2.81151 1.65936C2.81151 1.83423 2.74377 2.00194 2.6232 2.12559C2.50262 2.24924 2.33908 2.31871 2.16856 2.31871C1.99803 2.31871 1.83449 2.24924 1.71392 2.12559C1.59334 2.00194 1.5256 1.83423 1.5256 1.65936C1.5256 1.48448 1.59334 1.31677 1.71392 1.19312C1.83449 1.06947 1.99803 1 2.16856 1C2.33908 1 2.50262 1.06947 2.6232 1.19312C2.74377 1.31677 2.81151 1.48448 2.81151 1.65936V1.65936ZM0.882812 4.1417C0.888322 3.79573 1.02621 3.46584 1.26673 3.22318C1.50726 2.98051 1.83115 2.84452 2.16856 2.84452C2.50596 2.84452 2.82986 2.98051 3.07038 3.22318C3.3109 3.46584 3.44879 3.79573 3.4543 4.1417C3.05093 4.33137 2.61231 4.42926 2.16856 4.42865C1.70974 4.42865 1.27425 4.32596 0.882812 4.1417Z" stroke="#939393" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                </svg>
                            </li>
                        </ul>
                        <ul>
                            <li><img src="{{ asset('images/mipo/offsecuritylevelsecure.svg') }}" alt="no-image"></li>
                            <li><img src="{{ asset('images/mipo/offgold.svg') }}" alt="no-image"></li>
                        </ul>
                    </div>
                </div>
            </a>
            <div class="show_wrapper_btn" id="evt_cmd_single_offer_show_line_chart">
                <a href="javascript:;" class="text-12-medium">{{ __('Show more') }}<i><img src="{{ asset('images/mipo/blue-right.svg') }}" alt="no-image"></i></a>
            </div>
            <div class="opera_wrapper">
                <div class="my_operations_title text-14-medium">{!! __('Received Offers') !!}</div>
                <input type="hidden" value="" id="add_select_operation_id" />
                <div class="select-dd">
                    <span class="label text-14-medium">{!! __('Sort by:') !!}</span>
                    <select name="high_to_low_amount" id="high_to_low_amount" class="form-select text-14-semibold selectbox init_nice_select_high_low evt_offer_high_to_low_amount">
                        <option value="DESC">{!! __('Highest') !!}</option>
                        <option value="ASC">{!! __('Lowest') !!}</option>
                    </select>
                </div>
            </div>
            <div id="ajax_high_low_amount_list_sort_by">
                @foreach ($offers as $key => $offer)
                    <a href="javascript:;" id="row_offer_remove_{{ $offer->id }}" data-offer-id="{{ $offer->id }}" data-operation-id="{{ $offer->operations->first()->id }}" class="opera_oction evt_send_offer_single {{ $high_amount <= $offer->amount ? 'high_price' : '' }}">
                        <div class="opera_leftpart">
                            <div class="oction_head">
                                <h6 class="text-14-medium"> {{ app('common')->lockOfferDetail($offer, ['buyer_name']) }}</h6>
                                @if($offer->offer_status == 'Counter')
                                <div class="tag text-12-medium">{!! __('Counter offer') !!}</div>
                                @endif
                            </div>
                            <p class="text-14-medium"> 
                                {{ app('common')->diffForHumans($offer->expires_at) }}
                                {{-- {{ __('Expire in') }} {{ $offer->offer_expire_hour }} {{ __('hour') }} --}}
                            </p>
                        </div>
                        <div class="opera_rightpart">
                            <h6 class="text-14-medium">
                                {{ app('common')->currencyBySymbol($offer->preferred_currency) }}{{ app('common')->currencyNumberFormat($offer->preferred_currency, $offer->amount) }}
                            </h6>
                            <p class="text-14-medium">
                                {{ __($offer->preferred_payment_method) }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
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
</div>


<div class="drafts_wrap_map_popup">
    <div class="modal fade" id="single_offer_show_line_chart_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-20-medium" id="exampleModalLabel">{!! __('Offers Received') !!}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="div_line_chart">
                    <canvas id="line_chart_"></canvas>
                    {{-- <img src="{{ asset('images/mipo/graphpop.png') }}" alt="no-image"> --}}
                </div>
                <div class="modal-footer">
                    <div class="high_pop">
                        <div class="hii">
                            <p class="text-12-semibold">{!! __('Highest') !!}</p>
                        </div>
                        <div class="high-price">
                            <p class="text-12-semibold" id="add_high_value">0</p>
                        </div>
                    </div>
                    <div class="av_pop">
                        <div class="ave">
                            <p class="text-12-semibold">{!! __('Average') !!}</p>
                        </div>
                        <div class="av-price">
                            <p class="text-12-semibold" id="add_avg_value">0</p>
                        </div>
                    </div>
                    <div class="lo_pop">
                        <div class="low">
                            <p class="text-12-semibold">{!! __('Lowest') !!}</p>
                        </div>
                        <div class="low-price">
                            <p class="text-12-semibold" id="add_low_value">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- offers tab pop up by k --}}

<div class="view-his-popup">
    <div class="modal fade" id="view_histo_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-20-medium">{!! __('Offer History') !!}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table>
                        <tbody>
                            <tr class="forbg">
                                <th class="text-14-medium">{!! __('Offered By') !!}</th>
                                <th class="text-14-medium">{!! __('Offer Amount') !!}</th>
                                <th class="text-14-medium">{!! __('Retention') !!}</th>
                                <th class="text-14-medium">{!! __('Payment Method') !!}</th>
                                <th class="text-14-medium">{!! __('MIPO+') !!}</th>
                                <th class="text-14-medium">{!! __('Date and Time of Offer') !!}</th>
                            </tr>
                            <tr>
                                <td class="text-12-medium">{!! __('R*****') !!}</td>
                                <td class="text-12-medium">{!! __('$00.000') !!}</td>
                                <td class="text-12-medium">{!! __('$00.000') !!}</td>
                                <td class="text-12-medium highlight">{!! __('Cash') !!}</td>
                                <td class="text-12-medium">{!! __('NO') !!}</td>
                                <td class="text-12-medium">{!! __('May 29, 2023 01:15 AM') !!}</td>
                            </tr>
                            <tr>
                                <td class="text-12-medium">{!! __('You') !!}</td>
                                <td class="text-12-medium">{!! __('$00.000') !!}</td>
                                <td class="text-12-medium">{!! __('$00.000') !!}</td>
                                <td class="text-12-medium highlight">{!! __('Cash') !!}</td>
                                <td class="text-12-medium">{!! __('YES') !!}</td>
                                <td class="text-12-medium">{!! __('May 26, 2023 06:45 PM') !!}</td>
                            </tr>
                            <tr>
                                <td class="text-12-medium">{!! __('R*****') !!}</td>
                                <td class="text-12-medium">{!! __('$00.000') !!}</td>
                                <td class="text-12-medium">{!! __('$00.000') !!}</td>
                                <td class="text-12-medium highlight">{!! __('Cash') !!}</td>
                                <td class="text-12-medium">{!! __('NO') !!}</td>
                                <td class="text-12-medium">{!! __('May 23, 2023 02:30 AM') !!}</td>
                            </tr>
                            <tr>
                                <td class="text-12-medium">{!! __('You') !!}</td>
                                <td class="text-12-medium">{!! __('$00.000') !!}</td>
                                <td class="text-12-medium">{!! __('$00.000') !!}</td>
                                <td class="text-12-medium highlight">{!! __('Cash') !!}</td>
                                <td class="text-12-medium">{!! __('YES') !!}</td>
                                <td class="text-12-medium">{!! __('May 18, 2023 08:45 PM') !!}</td>
                            </tr>
                            <tr>
                                <td class="text-12-medium">{!! __('R*****') !!}</td>
                                <td class="text-12-medium">{!! __('$00.000') !!}</td>
                                <td class="text-12-medium">{!! __('$00.000') !!}</td>
                                <td class="text-12-medium highlight">{!! __('Cash') !!}</td>
                                <td class="text-12-medium">{!! __('NO') !!}</td>
                                <td class="text-12-medium">{!! __('May 15, 2023 10:00 AM') !!}</td>
                            </tr>
                            <tr>
                                <td class="text-12-medium">{!! __('You') !!}</td>
                                <td class="text-12-medium">{!! __('$00.000') !!}</td>
                                <td class="text-12-medium">{!! __('$00.000') !!}</td>
                                <td class="text-12-medium highlight">{!! __('Cash') !!}</td>
                                <td class="text-12-medium">{!! __('YES') !!}</td>
                                <td class="text-12-medium">{!! __('May 12, 2023 12:30 PM') !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="drafts_wrap_delete_popup">
    <div class="modal fade" id="exampleModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-20-medium" id="exampleModalLabel">{!! __('Reject Offer') !!}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-14-medium">
                    {!! __('Are you sure you wish to reject offer?') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary text-16-medium" data-bs-dismiss="modal">{!! __('Close') !!}</button>
                    <button type="button" class="btn-primary text-16-medium">{!! __('Reject') !!}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="drafts_wrap_approve_popup">
    <div class="modal fade" id="exampleModal6" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-20-medium" id="exampleModalLabel">{!! __('Accept Offer') !!}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-14-medium">
                    {!! __('Are you sure you wish to accept the offer?') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary text-16-medium" data-bs-dismiss="modal">{!! __('Close') !!}</button>
                    <button type="button" class="btn-primary text-16-medium">{!! __('Accept') !!}</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- offers tab pop up by k --}}