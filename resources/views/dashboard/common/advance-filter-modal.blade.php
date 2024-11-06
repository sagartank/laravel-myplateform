<div class="modal fade advance_filter_modal" id="advance_filter_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form name="advance_filter_modal_form" id="advance_filter_modal_form" method="post">
                    <div class="filter_modal_wrap">
                        <div class="filter_modal_top">
                            <div class="filter_modal_toprow">
                                <div class="filter_modal_topcol">
                                    <div class="filter_modal_cattitle">{{ __('CATEGORY') }}</div>
                                    <div class="filter_catlist">
                                        @if (config('constants.TYPE_OF_DOCUMENT'))
                                            @foreach (config('constants.TYPE_OF_DOCUMENT') as $key => $val)
                                                <div class="filter_checkbox_wrap">
                                                    <input type="checkbox" name="operation_type[]"
                                                        value="{{ $val }}"
                                                        id="catagory_contracts_{{ $key }}">
                                                    <label
                                                        for="catagory_contracts_{{ $key }}">{{ $val }}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="filter_modal_topcol">
                                    <div class="filter_modal_cattitle">{{ __('OPERATION CURRENCY') }}</div>
                                    <div class="filter_catlist">
                                        @if (config('constants.CURRENCY_TYPE'))
                                            @foreach (config('constants.CURRENCY_TYPE') as $key => $val)
                                                <div class="filter_checkbox_wrap">
                                                    <input type="radio" {{ $currency_type == $val ? 'checked' : '' }}
                                                        name="currency_type" value="{{ $val }}"
                                                        id="opert_curr_usd_{{ $key }}">
                                                    <label
                                                        for="opert_curr_usd_{{ $key }}">{{ $val }}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="filter_modal_topcol filter_modal_topcol_duration">
                                    <div class="filter_modal_cattitle">{{ __('DURATION') }}</div>
                                    <input type="text" name="duration_date_range" class="form-control"
                                        id="duration_date_range" readonly value="{{ $date_range }}" />
                                </div>
                                <div class="filter_modal_topcol filter_modal_topcol_operation_range">
                                    <div class="filter_modal_cattitle">{{ __('OPERATION RANGE') }}</div>
                                    <div class="filter_modal_selectprice">
                                        <div class="filter_selectprice active_payment">
                                            <div class="selectprice_duration_row">
                                                <div class="selectprice_duration_col modal_form_wrp">
                                                    <label for="min">{{ __('Min') }}</label>
                                                    <input type="number" name="min" id="min" value="">
                                                </div>
                                                <div class="selectprice_duration_col modal_form_wrp">
                                                    <label for="">{{ __('Max') }}</label>
                                                    <input type="number" name="max" id="max" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="filter_modal_morerow">
                                <div class="filter_modal_morecol">
                                    <div class="filter_modal_cattitle">
                                        PAYER
                                    </div>
                                    <div class="filter_modal_select modal_form_wrp">
                                        <!-- <label for="">Add Tags</label> -->
                                        <select class="js-example-basic-multiple evt_get_issuer" name="issuer_ids[]"
                                            multiple="multiple">
                                        </select>
                                    </div>
                                </div>
                                <div class="filter_modal_morecol">
                                    <div class="filter_modal_cattitle">
                                        SELLER
                                    </div>
                                    <div class="filter_modal_select modal_form_wrp">
                                        <!-- <label for="">Add Tags</label> -->
                                        <select class="js-example-basic-multiple evt_get_seller" id="evt_get_seller"
                                            name="seller_ids[]" multiple="multiple">

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter_modal_bottom">
                            <div class="filter_modal_bottom_left">
                                <input type="submit" value="Apply Filter" id="btn_advance_filter_modal_form"
                                    class="btn btn-primary">
                                <input type="reset" value="Reset" id="btn_reset_advance_filter_modal"
                                    class="simpalbtn resetbtn">
                            </div>
                            <div class="filter_modal_bottom_right">
                                <button type="button" class="simpalbtn" data-bs-dismiss="modal">{{ __('Close') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
