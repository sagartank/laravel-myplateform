@if($deals_multiple_feedback_offers)
    @php
        $i = 0;
    @endphp
    @foreach ($deals_multiple_feedback_offers->operations as $key => $operation_detail)
        @php
            $i++;
        @endphp
        <div class="row common_hide_show {{ ($i == '1')? '' : 'multiple_feedbak' }}" id="hide_show_{{$i}}">
            <form name="frm_deals_rating" action="{{ route('deals.ajax-create-multiple-feedback', $deals_multiple_feedback_offers->slug) }}" id="frm_deals_rating_{{$i}}" method="post">
                <input type="hidden" name="rate_issuer_id" value="{{ $operation_detail->issuer_id ?? '' }}" />
                <input type="hidden" name="offer_operation_id" value="{{ $operation_detail->pivot->id }}" />
                <input type="hidden" name="offer_id" id="offer_id_{{$i}}" value="{{ $deals_multiple_feedback_offers->id }}" />
                <input type="hidden" name="rate_user_id" id="rate_user_id_{{$i}}" value="{{ $operation_detail->seller_id }}" />
                <input type="hidden" name="type" value="{{ $type }}" />
                <div class="modal-body">
                    <div class="detail_wrapper">

                        <div class="doc_cashedbox">
                            @if($type == "cash_feedback")
                            <h3 class="text-18-medium">{!! __('Document Cashed') !!}</h3>


                            <div class="profile_inputbox">
                                <label class="text-14-medium">{{ __('Date of Cashing') }}</label>
                                @if($operation_detail->pivot->is_cashed_buyer == 'No')
                                <input type="text" id="is_cashed_date_{{$i}}" name="is_cashed_date" value="{{ date('d/m/Y') }}" class="form-control evt_cashed_date" readonly/>
                                <input type="hidden" name="extis_date" value="no"/>
                                @else
                                    <input type="text" id="is_cashed_date_{{$i}}" name="is_cashed_date" value="{{ $operation_detail->pivot->is_cashed_buyer_date }}" class="form-control" disabled readonly/>
                                    <input type="hidden" name="extis_date" value="yes"/>
                                @endif
                                <div class="imgbox"><img src="{{ asset('images/mipo/cash_calendar.svg') }}" alt="no-image"></div>
                            </div>

                            @else
                            <input type="hidden" name="extis_date" value="yes"/>
                            @endif
                        </div>

                        <div class="saller_payer_wrapper">
                            <h3 class="text-18-medium">{!! __('Give review to Seller & Payer') !!}</h3>
                            <div class="saller_payer_wrap">
                                <div class="reviewbox">
                                    <a href="javascript:;" class="profilebox">
                                        <div class="imgtxtbox">
                                            <div class="imgbox"><img src="{{ $operation_detail->seller->profile_image_url }}" alt="no-image"></div>
                                            <div class="name">
                                                <h3 class="text-16-medium">{{ $operation_detail->seller?->name ?? '-' }}</h3>
                                                <p class="text-14-medium">{!! __('Seller') !!}</p>
                                            </div>
                                        </div>
                                    </a>
                                
                                        <div class="reviewinbox">
                                            <p class="text-16-medium">{!! __('How many stars?') !!}</p>
                                            <div class="rating">
                                            {{--  <ul>
                                                    <li><img src="{{ asset('images/mipo/public-img6.svg') }}" alt="no-image"></li>
                                                    <li><img src="{{ asset('images/mipo/public-img6.svg') }}" alt="no-image"></li>
                                                    <li><img src="{{ asset('images/mipo/public-img8.svg') }}" alt="no-image"></li>
                                                    <li><img src="{{ asset('images/mipo/public-img7.svg') }}" alt="no-image"></li>
                                                    <li><img src="{{ asset('images/mipo/public-img7.svg') }}" alt="no-image"></li>
                                                </ul> --}}
                                                <div class="evt_feedback_rateit" data-index="{{$i}}" data-rateit-value="{{ config('constants.DEFAULT_FEEDBACK_RATE') }}"></div>
                                                <input type="hidden" name="sell_feedback_rate" id="sell_feedback_rate_{{$i}}"
                                                    value="{{ config('constants.DEFAULT_FEEDBACK_RATE') }}" />
                                            </div>
                                        </div>
                                        <div class="reviewinbox">
                                            <p class="text-16-medium">{!! __('How easy was the transaction?') !!}</p>
                                            <div class="pexp_ope">
                                                <label class="btn active">
                                                    <input type="radio"
                                                        class="btn-check evt_frm_one_tras" data-form-name="#frm_deals_rating_{{$i}}" name="sell_trans_doctype" value="Easy" checked> {{ __('Easy') }}
                                                </label>
                                                <label class="btn">
                                                    <input type="radio"
                                                        class="btn-check evt_frm_one_tras" data-form-name="#frm_deals_rating_{{$i}}" name="sell_trans_doctype" value="Medium">{{ __('Medium') }}
                                                        
                                                </label>
                                                <label class="btn">
                                                    <input type="radio"
                                                        class="btn-check evt_frm_one_tras" data-form-name="#frm_deals_rating_{{$i}}" name="sell_trans_doctype" value="Hard">{{ __('Hard') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="reviewinbox">
                                            <p class="text-16-medium">{!! __('How Easy was cashing the document?') !!}</p>
                                            <div class="pexp_ope">
                                                <label class="btn active">
                                                    <input type="radio"
                                                        class="btn-check evt_frm_one_doc" data-form-name="#frm_deals_rating_{{$i}}" name="sell_doc_doctype" value="Easy"
                                                        checked>{{ __('Easy') }}
                                                    </label>
                                                <label class="btn">
                                                    <input type="radio" class="btn-check evt_frm_one_doc" data-form-name="#frm_deals_rating_{{$i}}"
                                                        name="sell_doc_doctype" value="Medium">{{ __('Medium') }}
                                                    </label>
                                                <label class="btn">
                                                    <input type="radio" class="btn-check evt_frm_one_doc" data-form-name="#frm_deals_rating_{{$i}}"
                                                        name="sell_doc_doctype" value="Hard">{{ __('Hard') }}
                                                    </label>
                                                <label class="btn">
                                                    <input type="radio" class="btn-check evt_frm_one_doc" data-form-name="#frm_deals_rating_{{$i}}"
                                                        name="sell_doc_doctype" value="Unable">{{ __('Unable') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="reviewinbox">
                                            <div class="description">
                                                <label class="text-14-medium" for="description">{!! __('Description') !!}</label>
                                                <textarea name="sell_description" id="frm_one_days_desc_{{$i}}"></textarea>
                                            </div>
                                        </div>
                                
                                </div>
                                <div class="reviewbox">
                                    <a href="javascript:;" class="profilebox">
                                        <div class="imgtxtbox">
                                            <div class="imgbox"><img src="{{ $operation_detail->issuer->company_image_url }}" alt="no-image"></div>
                                            <div class="name">
                                                <h3 class="text-16-medium">{{ $operation_detail->issuer->company_name ?? '' }}</h3>
                                                <p class="text-14-medium">{!! __('Payer') !!}</p>
                                            </div>
                                        </div>
                                    </a>
                                
                                        <div class="reviewinbox">
                                            <p class="text-16-medium">{!! __('How many stars?') !!}</p>
                                            <div class="rating">
                                            {{--   <ul>
                                                    <li><img src="{{ asset('images/mipo/public-img6.svg') }}" alt="no-image"></li>
                                                    <li><img src="{{ asset('images/mipo/public-img6.svg') }}" alt="no-image"></li>
                                                    <li><img src="{{ asset('images/mipo/public-img8.svg') }}" alt="no-image"></li>
                                                    <li><img src="{{ asset('images/mipo/public-img7.svg') }}" alt="no-image"></li>
                                                    <li><img src="{{ asset('images/mipo/public-img7.svg') }}" alt="no-image"></li>
                                                </ul> --}}
                                                <div class="evt_issuer_rateit" data-index="{{$i}}" data-rateit-value="{{ config('constants.DEFAULT_ISSUERS_RATE') }}"></div>
                                                <input type="hidden" name="pay_issuer_rate" id="pay_issuer_rate_{{$i}}"
                                                    value="{{ config('constants.DEFAULT_ISSUERS_RATE') }}" />
                                            </div>
                                        </div>
                                        <div class="reviewinbox">
                                            <p class="text-16-medium">{!! __('How easy was the transaction?') !!}</p>
                                            <div class="pexp_ope">
                                                <label class="btn active"><input type="radio"
                                                    class="btn-check evt_frm_one_pay" name="pay_trans_doctype"
                                                    value="Easy" checked>{{ __('Easy') }}</label>
                                            <label class="btn"><input type="radio"
                                                    class="btn-check evt_frm_one_pay" name="pay_trans_doctype"
                                                    value="Medium">{{ __('Medium') }}</label>
                                            <label class="btn"><input type="radio"
                                                    class="btn-check evt_frm_one_pay" name="pay_trans_doctype"
                                                    value="Hard">{{ __('Hard') }}</label>
                                            </div>
                                        </div>
                                        <div class="reviewinbox">
                                            <p class="text-16-medium">{!! __('How Easy was cashing the document?') !!}</p>
                                            <div class="pexp_ope">
                                                <label class="btn active"><input type="radio"
                                                    class="btn-check evt_frm_one_cash" name="pay_doc_doctype"
                                                    value="Easy" checked>{{ __('Easy') }}</label>
                                            <label class="btn"><input type="radio"
                                                    class="btn-check evt_frm_one_cash" name="pay_doc_doctype"
                                                    value="Medium">{{ __('Medium') }}</label>
                                            <label class="btn"><input type="radio"
                                                    class="btn-check evt_frm_one_cash" name="pay_doc_doctype"
                                                    value="Hard">{{ __('Hard') }}</label>
                                            <label class="btn"><input type="radio"
                                                    class="btn-check evt_frm_one_cash" name="pay_doc_doctype"
                                                    value="Unable">{{ __('Unable') }}</label>
                                            </div>
                                        </div>
                                        <div class="reviewinbox">
                                            <div class="description">
                                                <label class="text-14-medium" for="description">{!! __('Description') !!}</label>
                                                <textarea id="frm_two_days_desc_{{$i}}" name="pay_description"></textarea>
                                            </div>
                                        </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="javascript:;" class="text-16-medium  evt_rating_modal_skip evt_prev_btn"   data-total-form="{{ $deals_multiple_feedback_offers->operations->count() }}" data-form-name="#frm_deals_rating_{{$i}}" data-next-id="{{ ($i+1) }}">{!! __('Skip') !!}</a>
                    <input type="button" class="btn btn-primary text-16-medium evt_next_btn" data-total-form="{{ $deals_multiple_feedback_offers->operations->count() }}" data-form-name="#frm_deals_rating_{{$i}}" data-next-id="{{ ($i+1) }}" value="Next">
                </div>
            </form>
        </div>
    @endforeach
    @endif
        