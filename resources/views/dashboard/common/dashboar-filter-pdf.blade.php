<div class="title_bar">
    <div class="title_bar_left">
        <h3>
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('images/mipo/dashboardsubpageleft.svg') }}" class="day" alt="no-image">
                <img src="{{ asset('images/mipo/white_lft_aro.svg') }}" class="night" alt="no-image">
            </a>{{ __($h3) }}</h3>
        <div class="sub_head">{{ __($title) }}</div>
    </div>
    <div class="title_right_bar">
        @permission('export-filter')
        <div class="export_blk">
            <span>{{ __('Export to:') }}</span>
            {{-- <a id="{{$pdf}}" data-user-type="{{$title}}"  data-action-name="{{$excel}}" href="javascript:void(0)">{!! __('CSV') !!}</a> --}}
            <a id="{{$pdf}}" data-user-type="{{$title}}"  data-action-name="{{$excel}}" href="javascript:void(0)">{!! __('PDF') !!}</a>
        </div>
        <div class="mobile_export_blk">
            <a href="javascript:;" class="text-14-semibold filter_btn_wrap">
                <i><img src="{{ asset('images/mipo/mobilefiltericon.svg') }}" alt="no-image"></i>
                {!! __('Filtros Avanzados') !!}
            </a>
            <div class="mobile_adv_filter">
                <a href="javascript:void(0)" class="text-20-semibold">
                    <i class="light"><img src="{{ asset('images/mipo/mobilelightleftarrow.svg')}}" alt="no-image"></i>
                    <i class="dark"><img src="{{ asset('images/mipo/mobiledarkleftarrow.svg')}}" alt="no-image"></i>
                    {!! __('Filtros Avanzados') !!}
                </a>
                <form name="advance_filter_modal_form" id="advance_filter_modal_form_mob" method="post">
                    <div class="filter_modal_wrap">
                        <div class="filter_modal_top">
                            <div class="filter_modal_toprow">
                                <div class="filter_modal_topcol">
                                    <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('CATEGORY') !!}<i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                                    <div class="filter_catlist">
                                        <div class="filter_checkbox_wrap">
                                            <input type="checkbox" class="form-check-input" name="operation_type[]" value="Cheque" id="catagory_contracts_0_mob">
                                            <label for="catagory_contracts_0_mob">{!! __('Check') !!}</label>
                                        </div>
                                        <div class="filter_checkbox_wrap">
                                            <input type="checkbox" class="form-check-input" name="operation_type[]" value="Invoice" id="catagory_contracts_1_mob">
                                            <label for="catagory_contracts_1_mob">{!! __('Invoice') !!}</label>
                                        </div>
                                        <div class="filter_checkbox_wrap">
                                            <input type="checkbox" class="form-check-input" name="operation_type[]" value="Contract" id="catagory_contracts_2_mob">
                                                <label for="catagory_contracts_2_mob">{!! __('Contract') !!}</label>
                                        </div>
                                        <div class="filter_checkbox_wrap">
                                            <input type="checkbox" class="form-check-input" name="operation_type[]" value="Other" id="catagory_contracts_3_mob">
                                            <label for="catagory_contracts_3_mob">{!! __('Other') !!}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter_modal_topcol">
                                    <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('CURRENCY') !!}<i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                                    <div class="filter_catlist">
                                        @if (config('constants.CURRENCY_TYPE'))
                                            @foreach (config('constants.CURRENCY_TYPE') as $key => $val)
                                                <div class="filter_checkbox_wrap">
                                                    <input type="radio" name="currency_type"  {{ $currency_type == $val ? 'checked' : '' }} value="{{ $val }}" id="opert_curr_usd_{{ $key }}_mob">
                                                    <label class="cus_radio" for="opert_curr_usd_{{ $key }}_mob">{{ $val }}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="filter_modal_topcol filter_modal_topcol_operation_range">
                                    <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('RANGE') !!}<i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                                    <div class="filter_modal_selectprice">
                                        <div class="filter_selectprice active_payment">
                                            <div class="selectprice_duration_row">
                                                <div class="selectprice_duration_col modal_form_wrp">
                                                    <label for="min_mob">{{ __('Min') }}</label>
                                                    <input type="number" name="min" id="min_mob" value="" class="dollar gs">
                                                </div>
                                                <div class="selectprice_duration_col modal_form_wrp">
                                                    <label for="max_mob">{{ __('Max') }}</label>
                                                    <input type="number" name="max" id="max_mob" value="" class="dollar gs">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="filter_modal_topcol filter_modal_topcol_duration">
                                    <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('DATE RANGE') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                                    <div class="calender_wrap">
                                        <input type="text" name="duration_date_range" class="form-control" id="duration_date_range_mob" readonly value="{{ $date_range }}">
                                        <div class="img">
                                            <img src="{{ asset('images/mipo/calender.svg') }}" alt="no-image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="filter_modal_morerow">
                                <div class="filter_modal_morecol">
                                    <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('PAYER AND SELLER') !!}<i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                                    <div class="filter_modal_select modal_form_wrp">
                                        <div class="modal-wrap">
                                            <p>{!! __('Payer') !!}</p>
                                            <select style="width: 100% !important" class="js-example-basic-multiple evt_get_issuer" name="issuer_ids[]"  multiple="multiple">
                                            </select>
                                        </div>
                                        <div class="modal-wrap">
                                            <p>{!! __('Seller') !!}</p>
                                            <select style="width: 100% !important;" class="js-example-basic-multiple evt_get_seller" id="evt_get_seller_mob" name="seller_ids[]" multiple="multiple" placeholder="{!! __('Search Seller') !!}">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter_modal_bottom">
                            <div class="filter_modal_bottom_left">
                                <input type="reset" value="{!! __('Reset') !!}" id="btn_reset_advance_filter_modal_mob" class="simpalbtn resetbtn">
                                <input type="submit" value="{!! __('Apply Filter') !!}" id="btn_advance_filter_modal_form_mob" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <a href="javascript:;" class="text-14-semibold export_btn_wrap" data-bs-toggle="modal" data-bs-target="#exportexampleModal">
                <i><img src="{{ asset('images/mipo/mobilexporticon.svg') }}" alt="no-image"></i>
                {!! __('Export') !!}
            </a>
        </div>
        @endpermission
    </div>
</div>
<div class="main_wrap">
@permission('filter-incomes')
    <div class="advance_filter_btn">
        <a href="javascript:void(0)">
            <i>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="sort 1">
                        <g id="Group">
                            <path id="Vector" d="M15.0013 10.8327H5.0013C4.5013 10.8327 4.16797 10.4993 4.16797 9.99935C4.16797 9.49935 4.5013 9.16602 5.0013 9.16602H15.0013C15.5013 9.16602 15.8346 9.49935 15.8346 9.99935C15.8346 10.4993 15.5013 10.8327 15.0013 10.8327Z" fill="#0D6EFD"/>
                        </g>
                        <g id="Group_2">
                            <path id="Vector_2" d="M12.5013 15.8327H7.5013C7.0013 15.8327 6.66797 15.4993 6.66797 14.9993C6.66797 14.4993 7.0013 14.166 7.5013 14.166H12.5013C13.0013 14.166 13.3346 14.4993 13.3346 14.9993C13.3346 15.4993 13.0013 15.8327 12.5013 15.8327Z" fill="#0D6EFD"/>
                        </g>
                        <g id="Group_3">
                            <path id="Vector_3" d="M17.5013 5.83268H2.5013C2.0013 5.83268 1.66797 5.49935 1.66797 4.99935C1.66797 4.49935 2.0013 4.16602 2.5013 4.16602H17.5013C18.0013 4.16602 18.3346 4.49935 18.3346 4.99935C18.3346 5.49935 18.0013 5.83268 17.5013 5.83268Z" fill="#0D6EFD"/>
                        </g>
                    </g>
                </svg>
            </i>
            {!! __('Advanced Filters') !!}
        </a>
        <form name="advance_filter_modal_form" id="advance_filter_modal_form" method="post">
            <div class="filter_modal_wrap">
                <div class="filter_modal_top">
                    <div class="filter_modal_toprow">
                        <div class="filter_modal_topcol">
                            <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('CATEGORY') !!}<i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                            <div class="filter_catlist">
                                <div class="filter_checkbox_wrap">
                                    <input type="checkbox" class="form-check-input" name="operation_type[]" value="Cheque" id="catagory_contracts_0">
                                    <label for="catagory_contracts_0">{!! __('Check') !!}</label>
                                </div>
                                <div class="filter_checkbox_wrap">
                                    <input type="checkbox" class="form-check-input" name="operation_type[]" value="Invoice" id="catagory_contracts_1">
                                    <label for="catagory_contracts_1">{!! __('Invoice') !!}</label>
                                </div>
                                <div class="filter_checkbox_wrap">
                                    <input type="checkbox" class="form-check-input" name="operation_type[]" value="Contract" id="catagory_contracts_2">
                                        <label for="catagory_contracts_2">{!! __('Contract') !!}</label>
                                </div>
                                <div class="filter_checkbox_wrap">
                                    <input type="checkbox" class="form-check-input" name="operation_type[]" value="Other" id="catagory_contracts_3">
                                    <label for="catagory_contracts_3">{!! __('Other') !!}</label>
                                </div>
                            </div>
                        </div>
                        <div class="filter_modal_topcol">
                            <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('CURRENCY') !!}<i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                            <div class="filter_catlist">
                                @if (config('constants.CURRENCY_TYPE'))
                                    @foreach (config('constants.CURRENCY_TYPE') as $key => $val)
                                        <div class="filter_checkbox_wrap">
                                            <input type="radio" name="currency_type"  {{ $currency_type == $val ? 'checked' : '' }} value="{{ $val }}" id="opert_curr_usd_{{ $key }}">
                                            <label for="opert_curr_usd_{{ $key }}" class="cus_radio">{{ $val }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="filter_modal_topcol filter_modal_topcol_operation_range">
                            <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('RANGE') !!}<i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                            <div class="filter_modal_selectprice">
                                <div class="filter_selectprice active_payment">
                                    <div class="selectprice_duration_row">
                                        <div class="selectprice_duration_col modal_form_wrp">
                                            <label for="min">{{ __('Min') }}</label>
                                            <input type="number" name="min" id="min" value="" class="dollar gs">
                                        </div>
                                        <div class="selectprice_duration_col modal_form_wrp">
                                            <label for="">{{ __('Max') }}</label>
                                            <input type="number" name="max" id="max" value="" class="dollar gs">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter_modal_topcol filter_modal_topcol_duration">
                            <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('DATE RANGE') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                            <div class="calender_wrap">
                                <input type="text" name="duration_date_range" class="form-control" id="duration_date_range" readonly value="{{ $date_range }}">
                                <div class="img">
                                    <img src="{{ asset('images/mipo/calender.svg') }}" alt="no-image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_morerow">
                        <div class="filter_modal_morecol">
                            <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('PAYER AND SELLER') !!}<i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                            <div class="filter_modal_select modal_form_wrp">
                                <div class="modal-wrap">
                                    <p>{!! __('Payer') !!}</p>
                                    <select style="width: 100% !important" class="js-example-basic-multiple evt_get_issuer" name="issuer_ids[]"  multiple="multiple">
                                    </select>
                                {{--  <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-6-u5l6" style="width: 100%;">
                                        <span class="selection">
                                            <input type="text" placeholder="{!! __('Search Payer') !!}">
                                            <div class="search">
                                                <img src="{{ asset('images/mipo/inv-search.svg') }}" alt="no-image">
                                            </div>
                                        </span>
                                        <span class="dropdown-wrapper" aria-hidden="true"></span>
                                    </span> --}}
                                </div>
                                <div class="modal-wrap">
                                    <p>{!! __('Seller') !!}</p>
                                    <select style="width: 100% !important;" class="js-example-basic-multiple evt_get_seller" id="evt_get_seller" name="seller_ids[]" multiple="multiple" placeholder="{!! __('Search Seller') !!}">
                                    </select>
                                   {{--  <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-4-pu0h" style="width: 100%;">
                                        <span class="selection">
                                            <input type="text" >
                                            <div class="search">
                                                <img src="{{ asset('images/mipo/inv-search.svg') }}" alt="no-image">
                                            </div>
                                        </span>
                                        <span class="dropdown-wrapper" aria-hidden="true"></span>
                                    </span> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter_modal_bottom">
                    <div class="filter_modal_bottom_left">
                        <input type="reset" value="{!! __('Reset') !!}" id="btn_reset_advance_filter_modal" class="simpalbtn resetbtn">
                        <input type="submit" value="{!! __('Apply Filter') !!}" id="btn_advance_filter_modal_form" class="btn btn-primary">
                    </div>
                </div>
            </div>
        </form>
    </div>
    
@endpermission

{{-- export popup by k --}}

<div class="export_wrap_popup">
    <div class="modal fade" id="exportexampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title text-20-semibold" id="exampleModalLabel">
                        <i><img src="{{ asset('images/mipo/mobilexporticon.svg') }}" alt="no-image"></i>
                        {!! __('Export to') !!}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-14-medium">
                    <div class="export_container">
                        <div class="exportbox">
                            <input class="hidden radio-label" type="radio" name="accept-offers" id="pdf">
                            <label class="button-label" for="pdf">
                                <div class="imgbox">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                        <mask id="mask0_1368_40521" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="40" height="40">
                                          <path d="M0 3.8147e-06H40V40H0V3.8147e-06Z" fill="white"></path>
                                        </mask>
                                        <g mask="url(#mask0_1368_40521)">
                                          <path d="M26.2503 1.17188H8.28125C6.98687 1.17188 5.9375 2.22125 5.9375 3.51563V36.4844C5.9375 37.7788 6.98687 38.8281 8.28125 38.8281H31.7188C33.0131 38.8281 34.0625 37.7788 34.0625 36.4844V8.98461L26.2503 1.17188Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path d="M26.25 1.17188V8.98438H34.0625L26.25 1.17188Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path d="M20.0002 19.6055L16.2148 26.1621H23.7856L20.0002 19.6055Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path d="M20.0009 19.6055L21.748 16.5794C22.5246 15.2344 21.554 13.5532 20.0009 13.5532C18.4479 13.5532 17.4772 15.2344 18.2538 16.5794L20.0009 19.6055Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path d="M23.7852 26.1625L25.5323 29.1886C26.3088 30.5335 28.25 30.5335 29.0265 29.1886C29.803 27.8437 28.8323 26.1625 27.2795 26.1625H23.7852Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path d="M16.2138 26.1625L14.4667 29.1886C13.6902 30.5335 11.749 30.5335 10.9725 29.1886C10.196 27.8437 11.1666 26.1625 12.7195 26.1625H16.2138Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                </div>
                                <span class="text-18-medium" data-user-type="{{$title}}"  data-action-name="{{$excel}}" >{!! __('PDF') !!}</span>
                            </label>
                        </div>
                       {{--  <div class="exportbox">
                            <input class="hidden radio-label" type="radio" name="accept-offers" id="xls">
                            <label class="button-label" for="xls">
                                <div class="imgbox">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                        <mask id="mask0_1368_40543" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="40" height="40">
                                          <path d="M0 3.8147e-06H40V40H0V3.8147e-06Z" fill="white"></path>
                                        </mask>
                                        <g mask="url(#mask0_1368_40543)">
                                          <path d="M26.2503 1.17188H8.28125C6.98687 1.17188 5.9375 2.22125 5.9375 3.51563V36.4844C5.9375 37.7788 6.98687 38.8281 8.28125 38.8281H31.7188C33.0131 38.8281 34.0625 37.7788 34.0625 36.4844V8.98461L26.2503 1.17188Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path d="M26.0387 20L14 32.0387" stroke="#939393" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path d="M14 20L26.0387 32.0387" stroke="#939393" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path d="M26.25 1.17188V8.98438H34.0625L26.25 1.17188Z" stroke="#939393" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                </div>
                                <span class="text-18-medium">{!! __('CSV') !!}</span>
                            </label>
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel text-16-medium" data-bs-dismiss="modal">{!! __('Cancel') !!}</button>
                    <button type="button" class="btn-export text-16-medium evt_download_pdf_mob" data-user-type="{{$title}}"  data-action-name="{{$excel}}">{!! __('Export') !!}</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- export popup by k --}}