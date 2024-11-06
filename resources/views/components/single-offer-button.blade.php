@props(['operation', 'currency'])
<div class="table_content remove_operation_group_by_seller_{{$operation->seller_id}}" data-currency-type="{{$currency}}" id="row_offer_remove_{{$operation->id}}">
    <div class="infobox">
        <div class="cheque">
            <p class="text-12-medium">{{ $operation->operation_type_number }} <span>{{ __($operation->preferred_payment_method)}}</span></p>
        </div>
        <div class="company text-12-medium">
            <a href="javascript:void(0)">{{ $operation->issuer?->company_name ?? 'N/A' }}</a>
            <span>
                {{-- {!! __('Expires in 1 hour') !!} --}}
                {{ $operation->expire_at }}
            </span>
            <p>
                {{ app('common')->currencyBySymbol($operation->preferred_currency) }}{{ app('common')->currencyNumberFormat($operation->preferred_currency, $operation->amount) }}
            </p>
        </div>
    </div>
    <div class="input_column">
        <input type="hidden" data-currency-type="{{$currency}}" data-offer-type="operation" data-accept-below-requested="{{$operation->accept_below_requested}}" value="{{$operation->id}}" data-operation-amount="{{$operation->amount}}" data-amount-requested="{{$operation->amount_requested}}" data-operation-id="{{$operation->id}}" data-operation-type="{{$operation->operation_type}}" data-operation-number="{{$operation->operation_number}}" data-seller-id="{{$operation->seller_id}}" data-seller-name="{{$operation->seller?->name}}" data-issuer-name="{{ $operation->issuer?->company_name }}" id="single_operation_info_{{$operation->id}}" class="group_operation_ids_{{$operation->seller_id}}" />
        <ul>
            {{-- <li>
                <div class="checkimg">
                    <input type="checkbox" name="ofr_type" id="ofrcheck2">
                    <label for="ofrcheck2"><img src="{{ asset('images/mipo/exp_mipo.svg') }}" alt="no-image"></label>
                </div>
            </li> --}}

            @if($operation->operation_type == 'Cheque')
            <li>
                <div class="retention">
                    <input type="text" data-currency-type="{{$currency}}" style="cursor: not-allowed" readonly disabled data-name="retention" data-offer-type="operation" data-operation-id="{{$operation->id}}"  data-seller-id="{{$operation->seller_id}}" id="retention_{{$operation->id}}" class="input_oprt {{ ($operation->preferred_currency == 'USD') ? 'dollar' : 'gs' }} single_retention retention_{{$operation->seller_id}} total_seller_group_{{$operation->seller_id}} evt_calculation_single evt_validate_decimal">
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
                    <input type="text" data-currency-type="{{$currency}}" data-name="retention" data-offer-type="operation" data-operation-id="{{$operation->id}}"  data-seller-id="{{$operation->seller_id}}" id="retention_{{$operation->id}}" class="text-14-medium {{ ($operation->preferred_currency == 'USD') ? 'dollar' : 'gs' }} single_retention retention_{{$operation->seller_id}} total_seller_group_{{$operation->seller_id}} evt_input evt_calculation_single evt_validate_decimal">
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
                    <select data-name="payment_method" data-currency-type="{{$currency}}" data-offer-type="operation" data-operation-id="{{$operation->id}}" data-seller-id="{{$operation->seller_id}}" id="deal_mode_{{$operation->id}}" class="select_transfer text-14-medium single_deal_model evt_change deal_mode_offer_{{$operation->seller_id}}">
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
                    <input type="text" data-currency-type="{{$currency}}" data-name="offer_time" data-offer-type="operation" data-operation-id="{{$operation->id}}" data-seller-id="{{$operation->seller_id}}" maxlength="2" id="offer_time_{{$operation->id}}" class="text-14-medium single_offer_time offer_time_{{$operation->seller_id}} evt_input">
    
                    <select data-name="offer_hour_day" data-currency-type="{{$currency}}" data-offer-type="operation" data-operation-id="{{$operation->id}}" data-seller-id="{{$operation->seller_id}}" id="offer_day_hour_{{$operation->id}}" 
                        class="validityofr_select text-14-medium single_offer_day_hour day_hour_offer_{{$operation->seller_id}} evt_change">
                        <option value="hour">{{ __('hour') }}</option>
                        <option value="day">{{ __('day') }}</option>
                    </select>
                </div>
            </li>

            <li>
                <div class="retention ofdlr">
                    <input type="text" data-name="offer_amount" data-currency-type="{{$currency}}" data-operation-amount="{{$operation->amount}}" data-offer-type="operation" data-operation-id="{{$operation->id}}" data-seller-id="{{$operation->seller_id}}" id="offer_amount_{{$operation->id}}" class="text-14-medium {{ ($operation->preferred_currency == 'USD') ? 'dollar' : 'gs' }} single_offer_amount offer_amount_{{$operation->seller_id}} evt_input evt_validate_decimal">
                    <div class="dolr">
                        @if($currency == 'USD')
                        <img src="{{ asset('images/mipo/ofr_dollar.svg') }}" alt="no-image">
                        @else
                            <img src="{{ asset('images/mipo/gs-offer.svg') }}" alt="no-image">
                        @endif
                    </div>
                    
                    <a href="javascript:void(0)" data-offer-type="operation" data-currency-type="{{$currency}}" data-operation-id="{{$operation->id}}" data-seller-id="{{$operation->seller_id}}" class="closed_btn evt_remove_offer">
                        <img src="{{ asset('images/mipo/ofrcloseicon.svg') }}" alt="no-image">
                    </a>
                
                </div>
            </li>
        </ul>
            <div class="offerboxlink">
                <a href="javascript:void(0)" disabled data-currency-type="{{$currency}}" data-offer-type="operation" id="btn_sent_offer_{{$operation->id}}" data-operation-id="{{$operation->id}}" data-operation-amount="{{$operation->amount}}" data-seller-id="{{$operation->seller_id}}" class="text-14-medium evt_submit_sent_offer sent_offer_{{$operation->seller_id}}">{!! __('OFFER') !!}</a>
            </div>
    </div>
</div>