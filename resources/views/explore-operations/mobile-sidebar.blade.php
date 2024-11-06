<div class="mobile_filter">
    <div class="adv-filter text-20-semibold">
        <a href="javascript:void(0)" class="light"><img src="{{ asset('images/mipo/mobilelightleftarrow.svg') }}" alt="no-image"></a>
        <a href="javascript:void(0)" class="dark"><img src="{{ asset('images/mipo/mobiledarkleftarrow.svg') }}" alt="no-image"></a>
        {!! __('Advance Filters') !!}
    </div>
    <form name="eop_form_filter_mob" id="eop_form_filter_mob" class="eop_form_filter_mob" method="post" action="{{ route('explore-operations.ajax-load-more-explore-operations') }}">
        <div class="filter_modal_wrap">
            <div class="filter_modal_top">
                <div class="filter_modal_toprow">
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)" class="text-18-semibold"> {!! __('FAVORITES') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            <div class="filter_checkbox_wrap">
                                <input type="checkbox" class="form-check-input" name="favourites" value="1" id="favrt_favourites">
                                <label for="favrt_favourites" class="text-18-medium">{!! __('Favorites') !!}</label>
                            </div>
                            <div class="filter_checkbox_wrap expmipo">
                                <input type="checkbox" class="form-check-input" name="mipo_verified" value="Yes" id="mipo_verified">
                                <label for="mipo_verified"><img src="{{ asset('images/mipo/exp_mipo.svg') }}" alt="no-image"></label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="checkbox" class="form-check-input" name="offered" value="1" id="offered">
                                <label for="offered" class="text-18-medium">{!! __('Offered') !!}</label>
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)" class="text-18-semibold">{!! __('SELLERS REVIEW') !!}<i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist rate">
                            <div class="filter_checkbox_wrap">
                                <input type="radio" name="ratting" value="1" id="strone">
                                <label class="cus_radio" for="strone"><img src="{{ asset('images/mipo/rate1.svg') }}" alt="no-image"></label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="radio" name="ratting" value="2" id="strtwo">
                                <label class="cus_radio" for="strtwo"><img src="{{ asset('images/mipo/rate2.svg') }}" alt="no-image"></label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="radio" name="ratting" value="3" id="strthree">
                                <label class="cus_radio" for="strthree"><img src="{{ asset('images/mipo/rate3.svg') }}" alt="no-image"></label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="radio" name="ratting" value="4" id="strfour">
                                <label class="cus_radio" for="strfour"><img src="{{ asset('images/mipo/rate4.svg') }}" alt="no-image"></label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="radio" name="ratting" value="5" id="strfive">
                                <label class="cus_radio" for="strfive"><img src="{{ asset('images/mipo/rate5.svg') }}" alt="no-image"></label>
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)" class="text-18-semibold">{!! __('PAYERS REVIEW') !!}<i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist rate">
                            <div class="filter_checkbox_wrap">
                                <input type="radio" name="ratting_payer" value="1" id="prstrone">
                                <label class="cus_radio" for="prstrone"><img src="{{ asset('images/mipo/rate1.svg') }}" alt="no-image"></label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="radio" name="ratting_payer" value="2" id="prstrtwo">
                                <label class="cus_radio" for="prstrtwo"><img src="{{ asset('images/mipo/rate2.svg') }}" alt="no-image"></label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="radio" name="ratting_payer" value="3" id="prstrthree">
                                <label class="cus_radio" for="prstrthree"><img src="{{ asset('images/mipo/rate3.svg') }}" alt="no-image"></label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="radio" name="ratting_payer" value="4" id="prstrfour">
                                <label class="cus_radio" for="prstrfour"><img src="{{ asset('images/mipo/rate4.svg') }}" alt="no-image"></label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input type="radio" name="ratting_payer" value="5" id="prstrfive">
                                <label class="cus_radio" for="prstrfive"><img src="{{ asset('images/mipo/rate5.svg') }}" alt="no-image"></label>
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)" class="text-18-semibold"> {!! __('PAYMENT METHOD') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            @if (config('constants.PREFERRED_MODE'))
                                @foreach (config('constants.PREFERRED_MODE') as $key => $val)
                                <div class="filter_checkbox_wrap">
                                        <input class="form-check-input" type="checkbox" name="preferred_payment_method[]" value="{{ $val }}"  id="transaction_cash_{{ $key }}">
                                        <label for="transaction_cash_{{ $key }}" class="text-18-medium">{{ __($key) }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)" class="text-18-semibold"> {!! __('SELLER ANALYSIS') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            <div class="filter_checkbox_wrap">
                                <input class="form-check-input" type="checkbox" name="bcp" value="1" id="bcp">
                                <label for="bcp" class="text-18-medium">{!! __('BCP') !!}</label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input class="form-check-input" type="checkbox" name="inforconf" value="1" id="inforconf">
                                <label for="inforconf" class="text-18-medium">{!! __('INFORCONF') !!}</label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input class="form-check-input" type="checkbox" name="infocheck" value="1" id="infocheck">
                                <label for="infocheck" class="text-18-medium">{!! __('INFORCONF') !!}</label>
                            </div>
                            <div class="filter_checkbox_wrap">
                                <input class="form-check-input" type="checkbox" name="criterium" value="1" id="criterium">
                                <label for="criterium" class="text-18-medium">{!! __('CRITERIUM') !!}</label>
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_topcol filter_modal_topcol_duration">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)" class="text-18-semibold">{!! __('DATE RANGE') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="calender_wrap">
                            <input type="text" name="duration_date_range" class="form-control" id="duration_date_range" style="height: 48px;">
                            <div class="img">
                                <img src="{{ asset('images/mipo/calender.svg') }}" alt="no-image">
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)" class="text-18-semibold"> {!! __('Seller') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            <div class="filter_intext">
                                <select name="search_seller[]" id="search_seller_mob" class="form-select text-12-semibold" multiple="multiple">
                                </select>
                               {{--  <input type="text" name="search_seller" id="search_seller" class="text-16-medium" placeholder="{{ __('Search Seller') }}">
                                <div class="mbtagicon"><img src="{{ asset('images/mipo/mbsearch.svg') }}" alt="no-image"></div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)" class="text-18-semibold"> {!! __('Payer') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            <div class="filter_intext">
                                <select name="search_payer[]" id="search_payer_mob" class="form-select text-12-semibold" multiple="multiple">
                                </select>
                              {{--   <input type="text" name="search_payer" id="search_payer" class="text-16-medium" placeholder="{{ __('Search Payer') }}">
                                <div class="mbtagicon"><img src="{{ asset('images/mipo/mbsearch.svg') }}" alt="no-image"></div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)" class="text-18-semibold"> {!! __('BANK') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            <div class="filter_intext">
                                <select name="search_bank[]" id="search_bank_mob" class="form-select text-12-semibold" multiple="multiple">
                                </select>
                                {{-- <input type="text" name="search_bank" id="search_bank" class="text-16-medium" placeholder="{{ __('Search Bank') }}">
                                <div class="mbtagicon"><img src="{{ asset('images/mipo/mbsearch.svg') }}" alt="no-image"></div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)" class="text-18-semibold"> {!! __('OPERATION TAGS') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            <div class="filter_intext">
                                <select name="add_tags[]" id="add_tags" class="form-select text-12-semibold evt_get_bank_mob" multiple="multiple">
                                </select>
                                {{-- <input type="text" name="add_tags[]" id="add_tags" class="text-16-medium" placeholder="{{ __('Search Tags') }}">
                                <div class="mbtagicon"><img src="{{ asset('images/mipo/mbtag.svg') }}" alt="no-image"></div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="innerdata">
                            <div class="filter_modal_cattitle"><a href="javascript:void(0)" class="text-18-semibold"> {!! __('OPERATION BUDGET') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                            <div class="mbexpbudget">
                                <div class="sepratbox">
                                    <div class="opradio">
                                        <input type="radio" name="op_budget" value="USD" id="chk_dl">
                                        <label for="chk_dl" class="text-14-medium cus_radio">{!! __('USD') !!}</label>
                                    </div>
                                    <div class="filter_modal_selectprice">
                                        <div class="filter_selectprice ">
                                            <div class="selectprice_duration_row">
                                                <div class="selectprice_duration_col">
                                                    <label for="usd_min" class="text-14-medium">{!! __('Minimum') !!}</label>
                                                    <input type="number" name="usd_min" id="usd_min">
                                                    <div class="mbicon"><img src="{{ asset('images/mipo/mbdlr.svg') }}" alt="no-image"></div>
                                                </div>
                                                <div class="selectprice_duration_col">
                                                    <label for="usd_max" class="text-14-medium">{!! __('Maximum') !!}</label>
                                                    <input type="number" name="usd_max" id="usd_max">
                                                    <div class="mbicon"><img src="{{ asset('images/mipo/mbdlr.svg') }}" alt="no-image"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                                <div class="sepratbox">
                                    <div class="opradio">
                                        <input type="radio" name="op_budget" value="Gs." id="chk_gs">
                                        <label for="chk_gs" class="text-14-medium cus_radio">{!! __('Gs.') !!}</label>
                                    </div>
                                    <div class="filter_modal_selectprice">
                                        <div class="filter_selectprice ">
                                            <div class="selectprice_duration_row">
                                                <div class="selectprice_duration_col">
                                                    <label for="gs_min" class="text-14-medium">{!! __('Minimum') !!}</label>
                                                    <input type="number" name="gs_min" id="gs_min">
                                                    <div class="mbicon"><img src="{{ asset('images/mipo/mbgs.svg') }}" alt="no-image"></div>
                                                </div>
                                                <div class="selectprice_duration_col">
                                                    <label for="gs_max" class="text-14-medium">{!! __('Maximum') !!}</label>
                                                    <input type="number" name="gs_max" id="gs_max">
                                                    <div class="mbicon"><img src="{{ asset('images/mipo/mbgs.svg') }}" alt="no-image"></div>
                                                </div>
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
                    <input type="reset" value="{!! __('Reset') !!}" id="btn_reset_advance_filter_modal" data-device-type="mob" class="simpalbtn resetbtn text-18-medium evt_eop_form_filter_reset">
                    <input type="submit" value="{!! __('Apply Filter') !!}" id="btn_advance_filter_modal_form" data-device-type="mob" class="btn btn-primary text-18-medium evt_eop_form_filter_apply">
                </div>
            </div>
        </div>
    </form>
</div>