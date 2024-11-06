@props(['operation', 'total_operation_amount', 'currency'])

<div class="table_content total_wrapgrp_oprt_final_total_blk remove_seller_group_{{$operation->seller_id}}" data-currency-type="{{$currency}}" id="remove_seller_group_{{$operation->seller_id}}">
    
    <div class="totalbox">
        <input type="checkbox" data-currency-type="{{$currency}}" data-operation-id="{{$operation->id}}" data-seller-id="{{$operation->seller_id}}" data-offer-type="operation" id="is_group_offer_checkbox_{{$operation->seller_id}}" class="is_group_offer_checkbox_{{$operation->seller_id}} evt_group_offer_checkbox">
    
        <label class="text-14-medium" data-currency-type="{{$currency}}" data-operation-id="{{$operation->id}}" data-seller-id="{{$operation->seller_id}}" data-offer-type="operation" id="seller_group_offer_amount_txt_{{$operation->seller_id}}">
            {!! __('Totals:') !!}
            {{ app('common')->currencyBySymbol($operation->preferred_currency) }}{{ app('common')->currencyNumberFormat($operation->preferred_currency, $total_operation_amount) }} 
        </label>
    </div>

    <div class="input_column">
        <input type="hidden" value="{{$operation->id}}" data-currency-type="{{$currency}}" data-operation-amount="{{$operation->amount}}" data-operation-total-amount="{{$total_operation_amount}}" data-amount-requested="{{$operation->amount_requested}}" data-operation-id="{{$operation->id}}" data-operation-type="{{$operation->operation_type}}" data-operation-number="{{$operation->operation_number}}" data-seller-id="{{$operation->seller_id}}" data-seller-name="{{$operation->seller?->name}}" data-issuer-name="{{ $operation->issuer?->company_name }}" id="group_operation_info_{{$operation->id}}" class="group_operation_info_{{$operation->seller_id}}" name="group_operation_ids[]" />
        <ul>
            {{--   <li>
                <div class="checkimg">
                    <input type="checkbox" name="ofr_type" id="ofrcheck3">
                    <label for="ofrcheck3"><img src="http://localhost:8000/images/mipo/exp_mipo.svg" alt="no-image"></label>
                </div>
            </li> --}}

            @if($operation->operation_type == 'Cheque')
            <li>
                <div class="retention">
                    <input type="text" style="cursor: not-allowed" readonly disabled data-currency-type="{{$currency}}" data-name="seller_group_retention" data-operation-amount="{{$operation->amount}}" data-operation-total-amount="{{$total_operation_amount}}" data-operation-id="{{$operation->id}}"  data-seller-id="{{$operation->seller_id}}" id="seller_group_offer_retention_{{$operation->seller_id}}" class="input_oprt {{ ($operation->preferred_currency == 'USD') ? 'dollar' : 'gs' }} seller_group_retention evt_input_group evt_validate_decimal grp_ret_amount_{{$operation->seller_id}}">
                    <div class="dolr">
                        @if($currency == 'USD')
                            <img src="{{ asset('images/mipo/ofr_dollar.svg') }}" alt="no-image">
                        @else
                            <img src="{{ asset('images/mipo/gs-offer.svg') }}" alt="no-image">
                        @endif
                    </div>
                </div>
            </li>
            @else
            <li>
                <div class="retention">
                    <input type="text" data-currency-type="{{$currency}}" data-name="seller_group_retention" data-operation-amount="{{$operation->amount}}" data-operation-total-amount="{{$total_operation_amount}}" data-operation-id="{{$operation->id}}"  data-seller-id="{{$operation->seller_id}}" id="seller_group_offer_retention_{{$operation->seller_id}}" class="text-12-medium {{ ($operation->preferred_currency == 'USD') ? 'dollar' : 'gs' }} seller_group_retention evt_input_group evt_validate_decimal grp_ret_amount_{{$operation->seller_id}}">
                    <div class="dolr">
                        @if($currency == 'USD')
                            <img src="{{ asset('images/mipo/ofr_dollar.svg') }}" alt="no-image">
                        @else
                            <img src="{{ asset('images/mipo/gs-offer.svg') }}" alt="no-image">
                        @endif
                    </div>
                </div>
            </li>
            @endif

            <li>
                <div class="banktrans">
                    <select data-name="seller_group_payment_method" data-currency-type="{{$currency}}" data-operation-id="{{$operation->id}}"  data-seller-id="{{$operation->seller_id}}" id="seller_group_payment_method_{{$operation->seller_id}}" class="select_transfer text-12-medium seller_group_payment_method evt_change_group grp_payment_{{$operation->seller_id}}">
                        @if (config('constants.PREFERRED_MODE'))
                            @foreach (config('constants.PREFERRED_MODE') as $key => $val)
                                <option {{ $operation->preferred_payment_method == $val ? 'selected' : '' }}
                                    value="{{ $val }}"> {{ __($key) }} </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </li>

            <li>
                <div class="validofr">
                    <input type="text" data-name="seller_group_offer_time" data-currency-type="{{$currency}}" data-operation-id="{{$operation->id}}" data-seller-id="{{$operation->seller_id}}" maxlength="2" id="seller_group_offer_time_{{$operation->seller_id}}"class="text-12-medium seller_group_offer_time evt_input_group grp_time_till_{{$operation->seller_id}}">
                    
                    <select data-name="seller_group_offer_hour_day" data-currency-type="{{$currency}}" data-operation-id="{{$operation->id}}" data-seller-id="{{$operation->seller_id}}" id="seller_group_offer_hour_day_{{$operation->seller_id}}" class="validityofr_select text-12-medium  seller_group_offer_hour_day evt_change_group grp_day_hour_{{$operation->seller_id}}">
                        <option value="hour">{{ __('hour') }}</option>
                        <option value="day">{{ __('day') }}</option>
                    </select>
                </div>
            </li>

            <li>
                <div class="retention ofdlr">
                    <input type="text" data-name="seller_group_offer_amount" data-currency-type="{{$currency}}" data-operation-amount="{{$operation->amount}}" data-operation-total-amount="{{$total_operation_amount}}" data-operation-id="{{$operation->id}}" data-seller-id="{{$operation->seller_id}}" id="seller_group_offer_amount_{{$operation->seller_id}}" class="text-12-medium {{ ($operation->preferred_currency == 'USD') ? 'dollar' : 'gs' }} seller_group_offer_amount evt_input_group evt_validate_decimal grp_offer_amount_{{$operation->seller_id}}">
                    <div class="dolr">
                        @if($currency == 'USD')
                            <img src="{{ asset('images/mipo/ofr_dollar.svg') }}" alt="no-image">
                        @else
                            <img src="{{ asset('images/mipo/gs-offer.svg') }}" alt="no-image">
                        @endif
                    </div>
                    
                    <a href="javascript:void(0)"><img src="{{ asset('images/mipo/ofrcloseicon.svg') }}" alt="no-image"></a>

                </div>
            </li>
        </ul>
            <div class="offerboxlink">
                <a href="javascript:void(0)" disabled data-btn-name="btn_group" data-currency-type="{{$currency}}" data-offer-type="operation" data-operation-amount="{{$operation->amount}}" data-operation-total-amount="{{$total_operation_amount}}" data-operation-id="{{$operation->id}}" data-seller-id="{{$operation->seller_id}}" id="btn_sent_group_offer_{{$operation->seller_id}}" value="Group Offer" class="text-14-medium evt_submit_sent_group_offer grp_offer_btn_{{$operation->seller_id}}">{!! __('OFFER') !!}</a>
            </div>
    </div>
</div>