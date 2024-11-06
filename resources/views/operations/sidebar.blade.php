<div class="advance_filter_btn lftrightno_scrollbar">
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
        {!! __('Advance Filters') !!}
    </a>           
    <form name="op_form_filter_dst" id="op_form_filter_dst" class="op_form_filter_dst" action="{{ route('operations.ajax-load-more-operations') }}" method="post">
        <div class="filter_modal_wrap">
            <div class="filter_modal_top">
                <div class="filter_modal_toprow">
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('CATEGORY') !!}<i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            @if (config('constants.TYPE_OF_DOCUMENT'))
                                @foreach (config('constants.TYPE_OF_DOCUMENT') as $key => $val)
                                    <div class="filter_checkbox_wrap">
                                        <input type="checkbox" class="form-check-input" name="operation_type[]" value="{{ $val }}" id="_catagory_contracts_{{ $key }}">
                                        <label for="_catagory_contracts_{{ $key }}">{!! __($val) !!}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('OPERATION CURRENCY') !!}<i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            @if (config('constants.CURRENCY_TYPE'))
                                @foreach (config('constants.CURRENCY_TYPE') as $key => $val)
                                    <div class="filter_checkbox_wrap">
                                        <input type="radio" name="preferred_currency[]" value="{{ $val }}" id="_opert_curr_usd_{{ $key }}">
                                        <label class="cus_radio" for="_opert_curr_usd_{{ $key }}">{{ $val }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)"> {!! __('Recurso') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            @if (config('constants.RESPONSIBILITY'))
                                @foreach (config('constants.RESPONSIBILITY') as $key => $val)
                                    <div class="filter_checkbox_wrap">
                                        <input class="form-check-input" type="checkbox" name="responsibility[]" value="{{ $val }}"  id="_with-resource_check_{{ $key }}">
                                        <label for="_with-resource_check_{{ $key }}">{{ __($val) }}  {{ __('Recurso') }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)"> {!! __('PAYMENT METHOD') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            @if (config('constants.PREFERRED_MODE'))
                                @foreach (config('constants.PREFERRED_MODE') as $key => $val)
                                    <div class="filter_checkbox_wrap">
                                        <input class="form-check-input" type="checkbox" name="preferred_payment_method[]" value="{{ $val }}"  id="_transaction_cash_{{ $key }}">
                                        <label for="_transaction_cash_{{ $key }}">{{ __($key) }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="filter_modal_morerow">
                        <div class="filter_modal_morecol">
                            <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('Status') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                            <div class="filter_modal_select modal_form_wrp">
                                <div class="modal-wrap">
                                    <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-6-u5l6" style="width: 100%;">
                                        <span class="selection">
                                            <select name="operation_status" id="operation_status" class="form-select selectbox text-12-semibold">
                                                @if (config('constants.OPERATION_STATUS'))
                                                    <option value="">{{ __('Select Status') }}</option>
                                                    @foreach (config('constants.OPERATION_STATUS') as $key => $val)
                                                    <option value="{{ $val }}">{!! __($val) !!}</option>
                                                    @endforeach
                                                    <option value="Unsold">{{ __('Unsold')}}</option>
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
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)">{!! __('DATE RANGE') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="calender_wrap">
                            <input type="text" name="duration_date_range" class="form-control" id="duration_date_range"  style="height: 36px;">
                            <div class="img" style="bottom: 10px;right: 12px;">
                                <img src="{{ asset('images/mipo/calender.svg') }}" alt="no-image" class="evt_cal_open">
                            </div>
                        </div>
                    </div>
                    <div class="filter_modal_topcol">
                        <div class="filter_modal_cattitle"><a href="javascript:void(0)"> {!! __('FAVORITES') !!} <i><img src="{{ asset('images/mipo/filtercheveron-down.svg') }}" alt="no-image"></i></a></div>
                        <div class="filter_catlist">
                            <div class="filter_checkbox_wrap expmipo">
                                <input class="form-check-input" type="checkbox" name="mipo_verified" value="Yes" id="_mipo_verified">
                                <label for="_mipo_verified"><img src="{{ asset('images/mipo/exp_mipo.svg') }}" alt="no-image"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="filter_modal_bottom">
                <div class="filter_modal_bottom_left">
                    <input type="reset" value="{!! __('Reset') !!}" id="btn_reset_advance_filter_modal" data-device-type="dst" class="simpalbtn resetbtn evt_op_form_filter_reset">
                    <input type="submit" value="{!! __('Apply Filter') !!}" id="btn_advance_filter_modal_form" data-device-type="dst" class="btn btn-primary evt_op_form_filter_apply">
                </div>
            </div>
        </div>
    </form>
</div>