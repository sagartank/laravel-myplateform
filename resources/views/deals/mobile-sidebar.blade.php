<div class="mobile_filter">
    <div class="adv-filter text-20-semibold">
        <a href="javascript:void(0)" class="light"><img src="{{ asset('images/mipo/mobilelightleftarrow.svg') }}" alt="no-image"></a>
        <a href="javascript:void(0)" class="dark"><img src="{{ asset('images/mipo/mobiledarkleftarrow.svg') }}" alt="no-image"></a>
        {!! __('Advance Filters') !!}
    </div>
    <form name="deal_form_filter_mob" id="deal_form_filter_mob" class="deal_form_filter_mob" method="post">
        <div class="filter_modal_wrap">
            <div class="filter_modal_top">
                <div class="filter_modal_toprow">
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)" class="text-18-semibold">{!! __('CATEGORY') !!}<i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            @if (config('constants.TYPE_OF_DOCUMENT'))
                                @foreach (config('constants.TYPE_OF_DOCUMENT') as $key => $val)
                                    <div class="filter_checkbox_wrap">
                                        <input class="form-check-input" type="checkbox" name="operation_type[]" value="{{ $val }}" id="catagory_contracts_{{ $key }}">
                                        <label for="catagory_contracts_{{ $key }}" class="text-18-medium">{!! __($val) !!}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)" class="text-18-semibold">{!! __('OPERATION CURRENCY') !!}<i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            @if (config('constants.CURRENCY_TYPE'))
                                @foreach (config('constants.CURRENCY_TYPE') as $key => $val)
                                    <div class="filter_checkbox_wrap">
                                        <input type="radio" {{ $currency_type == $val ? 'checked' : '' }} name="preferred_currency[]" value="{{ $val }}" id="preferred_currency{{ $key }}">
                                        <label class="cus_radio" for="preferred_currency{{ $key }}" class="text-18-medium">{{ $val }} </label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)" class="text-18-semibold"> {!! __('PAYMENT METHOD') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                              @if (config('constants.PREFERRED_MODE'))
                                @foreach (config('constants.PREFERRED_MODE') as $key => $val)
                                    <div class="filter_checkbox_wrap">
                                        <input class="form-check-input" type="checkbox" name="preferred_payment_method[]" value="{{ $val }}"  id="transaction_cash_{{ $key }}">
                                        <label for="transaction_cash_{{ $key }}"  class="text-18-medium">{!! __($key) !!}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="filter_modal_morerow">
                        <div class="filter_modal_morecol">
                            <div class="filter_modal_cattitle"><a href="javascript:void(0)" class="text-18-semibold">{!! __('Status') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                            <div class="filter_modal_select modal_form_wrp">
                                <div class="modal-wrap">
                                    <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-6-u5l6" style="width: 100%;">
                                        <span class="selection">
                                        <select name="deals_status" id="deals_status" class="form-select selectbox text-12-semibold">
                                            @if (config('constants.DEALS_STATUS'))
                                                <option value=""> {{ __('Select Status') }}</option>
                                                    @foreach (config('constants.DEALS_STATUS') as $key => $val)
                                                        <option value="{{ $val }}">{{ __($val) }}</option>
                                                    @endforeach
                                                <option value="mipo_deals">{{ __('MIPO+ Deals')}}</option>
                                            @endif
                                        </select>
                                        </span>
                                        <span class="dropdown-wrapper" aria-hidden="true"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_topcol filter_modal_topcol_duration">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)" class="text-18-semibold">{!! __('DATE RANGE') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="calender_wrap">
                            <input type="text" name="duration_date_range" class="form-control" id="duration_date_range" readonly>
                            <div class="img">
                                <img src="{{ asset('images/mipo/calender.svg') }}" alt="no-image">
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_morerow">
                        <div class="filter_modal_morecol">
                            <div class="filter_modal_cattitle"><a href="javascript:void(0)" class="text-18-semibold">{!! __('SELLER') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                            <div class="filter_modal_select modal_form_wrp">
                                <div class="modal-wrap">
                                    <select class="js-example-basic-multiple evt_get_seller" name="seller_ids[]" multiple="multiple" style="width: 100%;">
                                    </select>
                                    {{-- <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-6-u5l6" style="width: 100%;">
                                        <span class="selection">
                                            <input type="text" name="search_seller" id="search_seller" placeholder="Search Saller">
                                            <div class="search">
                                                <img src="{{ asset('images/mipo/exp_search.svg') }}" alt="no-image">
                                            </div>
                                        </span>
                                        <span class="dropdown-wrapper" aria-hidden="true"></span>
                                    </span> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_morerow">
                        <div class="filter_modal_morecol">
                            <div class="filter_modal_cattitle"><a href="javascript:void(0)" class="text-18-semibold">{!! __('PAYERS') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                            <div class="filter_modal_select modal_form_wrp">
                                <div class="modal-wrap">
                                    <select class="js-example-basic-multiple evt_get_issuer" name="issuer_ids[]" multiple="multiple" style="width: 100%;">
                                    </select>  
                                    {{--  <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-6-u5l6" style="width: 100%;">
                                        <span class="selection">
                                            <input type="text" id="search_payer" name="search_payer" placeholder="Search Payer">
                                            <div class="search">
                                                <img src="{{ asset('images/mipo/exp_search.svg') }}" alt="no-image">
                                            </div>
                                        </span>
                                        <span class="dropdown-wrapper" aria-hidden="true"></span>
                                    </span> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)" class="text-18-semibold"> {!! __('FAVORITES') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            <div class="filter_checkbox_wrap expmipo">
                                <input class="form-check-input" type="checkbox" name="mipo_verified" value="Yes" id="mipo_verified_image">
                                <label for="mipo_verified_image"><img src="{{ asset('images/mipo/exp_mipo.svg') }}" alt="no-image"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="filter_modal_bottom">
                <div class="filter_modal_bottom_left">
                    <input type="reset" value="{!! __('Reset') !!}" id="btn_reset_advance_filter_modal" data-device-type="mob" class="simpalbtn resetbtn text-18-medium evt_deal_form_filter_reset">
                    <input type="submit" value="{!! __('Apply Filter') !!}" id="btn_advance_filter_modal_form" data-device-type="mob" class="btn btn-primary text-18-medium evt_deal_form_filter_apply">
                </div>
            </div>
        </div>
    </form>
</div>