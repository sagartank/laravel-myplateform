
<div class="advance_filter_btn">
    <form name="eop_form_filter_dst" id="eop_form_filter_dst" class="eop_form_filter_dst" method="post" action="{{ route('explore-operations.ajax-load-more-explore-operations') }}">
        <div class="filter_modal_wrap">
            <div class="filter_modal_top">
                <div class="filter_modal_toprow">
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)"> {!! __('FAVORITES') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            <div class="filter_checkbox_wrap">
                                <input type="checkbox" class="form-check-input" name="favourites" value="1" id="favrt_favourites">
                                <label for="favrt_favourites">{!! __('Favorites') !!}</label>
                            </div>
                            <div class="filter_checkbox_wrap expmipo">
                                <input type="checkbox" class="form-check-input" name="mipo_verified" value="Yes" id="mipo_verified">
                                <label for="mipo_verified"><img src="{{ asset('images/mipo/exp_mipo.svg') }}" alt="no-image"></label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="checkbox" class="form-check-input" name="offered" value="1" id="offered">
                                <label for="offered">{!! __('Offered') !!}</label>
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)"> {!! __('SELLERS STATUS') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                            <div class="filter_catlist">
                                @if (config('constants.USER_LEVEL'))
                                    @foreach (config('constants.USER_LEVEL') as $key => $val)
                                        <div class="filter_checkbox_wrap">
                                            <input type="checkbox" class="form-check-input" name="user_level[]"  value="{{ $val }}"  id="user_level_{{ $key }}">
                                            <label  for="user_level_{{ $key }}">{{ __($val) }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                    </div>
                    <div class="filter_modal_topcol starimg">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('SELLERS REVIEW') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            <div class="filter_checkbox_wrap">
                                <input type="radio" name="ratting" value="1" id="ratting_star1">
                                <label class="cus_radio" for="ratting_star1"><img src="{{ asset('images/mipo/rate1.svg') }}" alt="no-image"></label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="radio"  name="ratting" value="2" id="ratting_star2">
                                <label class="cus_radio" for="ratting_star2"><img src="{{ asset('images/mipo/rate2.svg') }}" alt="no-image"></label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="radio"  name="ratting" value="3" id="ratting_star3">
                                <label class="cus_radio" for="ratting_star3"> <img src="{{ asset('images/mipo/rate3.svg') }}" alt="no-image"></label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="radio"  name="ratting" value="4" id="ratting_star4">
                                <label class="cus_radio" for="ratting_star4"> <img src="{{ asset('images/mipo/rate4.svg') }}" alt="no-image"></label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="radio"  name="ratting" value="5" id="ratting_star5">
                                <label class="cus_radio" for="ratting_star5"><img src="{{ asset('images/mipo/rate5.svg') }}" alt="no-image"></label>
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_topcol starimg">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('PAYERS REVIEW') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            <div class="filter_checkbox_wrap">
                                <input type="radio" name="ratting_payer" value="1" id="_ratting_star1">
                                <label class="cus_radio" for="_ratting_star1"> <img src="{{ asset('images/mipo/rate1.svg') }}" alt="no-image"></label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="radio" name="ratting_payer" value="2" id="_ratting_star2">
                                <label class="cus_radio" for="_ratting_star2"><img src="{{ asset('images/mipo/rate2.svg') }}" alt="no-image"></label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="radio" name="ratting_payer" value="3" id="_ratting_star3">
                                <label class="cus_radio" for="_ratting_star3"><img src="{{ asset('images/mipo/rate3.svg') }}" alt="no-image"></label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="radio" name="ratting_payer" value="4" id="_ratting_star4">
                                <label class="cus_radio" for="_ratting_star4"> <img src="{{ asset('images/mipo/rate4.svg') }}" alt="no-image"></label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="radio" name="ratting_payer" value="5" id="_ratting_star5">
                                <label class="cus_radio" for="_ratting_star5"> <img src="{{ asset('images/mipo/rate5.svg') }}" alt="no-image"></label>
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)"> {!! __('PAYMENT METHOD') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            @if (config('constants.PREFERRED_MODE'))
                                @foreach (config('constants.PREFERRED_MODE') as $key => $val)
                                    <div class="filter_checkbox_wrap">
                                        <input type="checkbox" class="form-check-input" name="preferred_payment_method[]" value="{{ $val }}"  id="transaction_cash_{{ $key }}">
                                        <label for="transaction_cash_{{ $key }}">{{ __($key) }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)"> {!! __('SELLERS ANALYSIS') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            <div class="filter_checkbox_wrap">
                                <input type="checkbox" class="form-check-input" name="bcp" value="1" id="bcp">
                                <label for="bcp">{!! __('BCP') !!}</label>
                            </div>
                            <div class="filter_checkbox_wrap expmipo">
                                <input type="checkbox" class="form-check-input" name="inforconf" value="1" id="inforconf">
                                <label for="inforconf">{!! __('INFORCONF') !!}</label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="checkbox" class="form-check-input" name="infocheck" value="1" id="infocheck">
                                    <label for="infocheck">{!! __('INFOCHECK') !!}</label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="checkbox" class="form-check-input" name="criterium" value="1" id="criterium">
                                    <label for="criterium">{!! __('CRITERIUM') !!}</label>
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)"> {!! __('Recurso') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            <div class="filter_checkbox_wrap">
                                <input type="checkbox" class="form-check-input" name="responsibility[]" value="With" id="With">
                                <label for="With">{!! __('With Recurso') !!}</label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="checkbox" class="form-check-input" name="responsibility[]" value="Without" id="Without">
                                <label for="Without">{!! __('Without Recurso') !!}</label>
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_topcol filter_modal_topcol_duration">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('DATE RANGE') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="calender_wrap">
                            <input type="text" name="duration_date_range" class="form-control" id="duration_date_range">
                            <div class="img">
                                <img src="{{ asset('images/mipo/calender.svg') }}" alt="no-image">
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_morerow">
                        <div class="filter_modal_morecol">
                            <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('SELLER') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                            <div class="filter_modal_select modal_form_wrp">
                                <div class="modal-wrap">
                                    {{-- <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-6-u5l6" style="width: 100%;">
                                        <span class="selection"> --}}
                                            <select name="search_seller[]" id="search_seller_dst" class="form-select text-12-semibold" multiple>
                                            </select>
                                            {{-- <input type="text" name="search_seller" id="search_seller" placeholder="{!! __('Search Seller') !!}"> --}}
                                            {{--   <div class="search">
                                                <img src="{{ asset('images/mipo/exp_search.svg') }}" alt="no-image">
                                            </div> --}}
                                        {{-- </span>
                                        <span class="dropdown-wrapper" aria-hidden="true"></span> --}}
                                    {{-- </span> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_morerow">
                        <div class="filter_modal_morecol">
                            <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('PAYERS') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                            <div class="filter_modal_select modal_form_wrp">
                                <div class="modal-wrap">
                                    {{-- <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-6-u5l6" style="width: 100%;">
                                        <span class="selection">
                                            <input type="text" id="search_payer" name="search_payer" placeholder="{!! __('Search Payer') !!}">
                                            <div class="search">
                                                <img src="{{ asset('images/mipo/exp_search.svg') }}" alt="no-image">
                                            </div>
                                        </span>
                                        <span class="dropdown-wrapper" aria-hidden="true"></span>
                                    </span> --}}
                                    <select name="search_payer[]" id="search_payer_dst" class="form-select text-12-semibold" multiple="multiple">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_morerow">
                        <div class="filter_modal_morecol">
                            <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('BANK') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                            <div class="filter_modal_select modal_form_wrp">
                                <div class="modal-wrap">
                                    {{--  <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-6-u5l6" style="width: 100%;">
                                        <span class="selection">
                                            <input type="text" name="search_bank" id="search_bank" placeholder="{!! __('Search Bank') !!}">
                                            <div class="search">
                                                <img src="{{ asset('images/mipo/exp_search.svg') }}" alt="no-image">
                                            </div>
                                        </span>
                                        <span class="dropdown-wrapper" aria-hidden="true"></span>
                                    </span> --}}
                                    <select name="search_bank[]" id="search_bank_dst" class="form-select text-12-semibold" multiple="multiple">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_morerow">
                        <div class="filter_modal_morecol">
                            <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('OPERATION TAGS') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                            <div class="filter_modal_select modal_form_wrp">
                                <div class="modal-wrap">
                                    <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-6-u5l6" style="width: 100%;">
                                        <span class="selection">
                                            <input type="text" name="add_tags[]" id="add_tags" placeholder="{!! __('Search Tags') !!}">
                                            <div class="search">
                                                <img src="{{ asset('images/mipo/exp_tag.svg') }}" alt="no-image">
                                            </div>
                                        </span>
                                        <span class="dropdown-wrapper" aria-hidden="true"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="filter_modal_topcol filter_modal_topcol_operation_range">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('OPERATION BUDGET') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="expbudget">
                            <div class="sepratbox">
                            <div class="opradio">
                                <input type="radio" id="chk_usd" name="op_budget" value="USD" class="custom-control-input">
                                <label class="custom-control-label cus_radio" for="chk_usd">{!! __('USD') !!}</label>
                            </div>
                            <div class="filter_modal_selectprice">
                                <div class="filter_selectprice active_payment_1">
                                    <div class="selectprice_duration_row">
                                        <div class="selectprice_duration_col modal_form_wrp">
                                            <label for="usd_min">{!! __('Minimum') !!}</label>
                                            <input type="number" name="usd_min" id="usd_min" value="" class="dollar gs">
                                        </div>
                                        <div class="selectprice_duration_col modal_form_wrp">
                                            <label for="usd_max">{!! __('Maximum') !!}</label>
                                            <input type="number" name="usd_max" id="usd_max" value="" class="dollar gs">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                            <div class="sepratbox">
                            <div class="opradio">
                                <input type="radio" id="chk_gs" name="op_budget" value="Gs." class="custom-control-input">
                                <label class="custom-control-label cus_radio" for="chk_gs">{!! __('Gs.') !!}</label>
                            </div>
                            <div class="filter_modal_selectprice">
                                <div class="filter_selectprice active_payment_1">
                                    <div class="selectprice_duration_row">
                                        <div class="selectprice_duration_col modal_form_wrp">
                                            <label for="gs_min">{!! __('Minimum') !!}</label>
                                            <input type="number" name="gs_min" id="gs_min" value="" class="dollar gs">
                                        </div>
                                        <div class="selectprice_duration_col modal_form_wrp">
                                            <label for="gs_max">{!! __('Maximum') !!}</label>
                                            <input type="number" name="gs_max" id="gs_max" value="" class="dollar gs">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="filter_modal_bottom">
                <div class="filter_modal_bottom_left">
                    <input type="reset" value="{!! __('Reset') !!}" data-device-type="dst" id="btn_reset_advance_filter_modal" class="simpalbtn resetbtn evt_eop_form_filter_reset">
                    <input type="submit" value="{!! __('Apply Filter') !!}" data-device-type="dst" id="btn_advance_filter_modal_form" class="btn btn-primary evt_eop_form_filter_apply">
                </div>
            </div>
        </div>
    </form>
</div>
