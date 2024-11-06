@props(['operation', 'currency'])
<div class="table_content remove_mipo_group_by_seller_{{$operation->seller_id}}" data-currency-type="{{$currency}}" id="row_offer_remove_{{$operation->id}}">
    <div class="infobox">
        <div class="cheque">
            <p class="text-12-medium">{{ $operation->operation_type_number }} <span>{{ __($operation->preferred_payment_method) }}</span></p>
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
        <input type="hidden" value="{{$operation->id}}" data-currency-type="{{$currency}}" data-offer-type="mipo" data-accept-below-requested="{{$operation->accept_below_requested}}" data-operation-amount="{{$operation->amount}}" data-amount-requested="{{$operation->amount_requested}}" data-operation-id="{{$operation->id}}" data-operation-type="{{$operation->operation_type}}" data-operation-number="{{$operation->operation_number}}" data-seller-id="{{$operation->seller_id}}" data-seller-name="{{$operation->seller?->name}}" data-issuer-name="{{ $operation->issuer?->company_name }}" id="single_operation_info_{{$operation->id}}" class="group_mipo_operation_ids_{{$operation->seller_id}}" name="group_operation_ids[]" />
        <ul>
            <li>
                <div class="checkimg">
                    <input data-name="mipo" data-currency-type="{{$currency}}" data-offer-type="mipo" type="checkbox" {{ ($operation->mipo_verified == 'Yes') ? 'checked' : '' }} data-operation-id="{{$operation->id}}" data-seller-id="{{$operation->seller_id}}" class="single_mipo_verified_{{$operation->seller_id}} evt_click_single_mipo" id="mipo_verified_{{$operation->id}}">
                    <label for="mipo_verified_{{$operation->id}}"><img src="{{ asset('images/mipo/exp_mipo.svg') }}" alt="no-image"></label>
                </div>
            </li>

            <li>
                <div class="retention">
                    @if($operation->operation_type == 'Cheque')
                    <input style="cursor: not-allowed" type="text" data-currency-type="{{$currency}}" readonly disabled data-name="retention" data-offer-type="mipo" data-operation-id="{{$operation->id}}"  data-seller-id="{{$operation->seller_id}}" id="retention_{{$operation->id}}" class="text-14-medium {{ ($operation->preferred_currency == 'USD') ? 'dollar' : 'gs' }} single_retention retention_mipo_{{$operation->seller_id}} total_seller_mipo_group_{{$operation->seller_id}} evt_input evt_calculation_single_mipo_retention evt_validate_decimal">
                    @else
                    <input type="text" data-name="retention" data-currency-type="{{$currency}}" data-offer-type="mipo" data-operation-id="{{$operation->id}}"  data-seller-id="{{$operation->seller_id}}" id="retention_{{$operation->id}}" class="text-14-medium {{ ($operation->preferred_currency == 'USD') ? 'dollar' : 'gs' }} single_retention retention_mipo_{{$operation->seller_id}} total_seller_mipo_group_{{$operation->seller_id}} evt_input evt_calculation_single_mipo_retention evt_validate_decimal">
                    @endif
                    <div class="dolr">
                        @if($currency == 'USD')
                            <img src="{{ asset('images/mipo/ofr_dollar.svg') }}" alt="no-image">
                        @else
                            <img src="{{ asset('images/mipo/gs-offer.svg') }}" alt="no-image">
                        @endif
                    </div>
                </div>
            </li>

            <li>
                <div class="banktrans">
                    <select data-name="payment_method" data-currency-type="{{$currency}}" data-offer-type="mipo" data-operation-id="{{$operation->id}}" data-seller-id="{{$operation->seller_id}}" id="deal_mode_{{$operation->id}}" class="select_transfer text-14-medium single_deal_model evt_change deal_mode_offer_mipo_{{$operation->seller_id}}">
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
                    <input type="text" data-currency-type="{{$currency}}" data-name="offer_time" data-offer-type="mipo" data-offer_type="mipo" data-operation-id="{{$operation->id}}" data-seller-id="{{$operation->seller_id}}" maxlength="2" id="offer_time_{{$operation->id}}" class="text-14-medium single_offer_time evt_input offer_time_mipo_{{$operation->seller_id}}">

                    <select data-name="offer_hour_day" data-currency-type="{{$currency}}" data-offer-type="mipo" data-operation-id="{{$operation->id}}" data-seller-id="{{$operation->seller_id}}" id="offer_day_hour_{{$operation->id}}" class="validityofr_select text-14-medium single_offer_day_hour day_hour_offer_mipo_{{$operation->seller_id}} evt_change">
                        <option value="hour">{{ __('hour') }}</option>
                        <option value="day">{{ __('day') }}</option>
                    </select>
                </div>
            </li>

            <li>
                <div class="retention ofdlr">
                    <input type="text" data-currency-type="{{$currency}}" data-name="offer_amount" data-operation-amount="{{$operation->amount}}" data-offer-type="mipo" data-operation-id="{{$operation->id}}" data-seller-id="{{$operation->seller_id}}" id="offer_amount_{{$operation->id}}" class="text-14-medium {{ ($operation->preferred_currency == 'USD') ? 'dollar' : 'gs' }} single_offer_amount offer_amount_mipo_{{$operation->seller_id}} evt_input evt_validate_decimal">
                    <div class="dolr">
                        @if($currency == 'USD')
                            <img src="{{ asset('images/mipo/ofr_dollar.svg') }}" alt="no-image">
                        @else
                            <img src="{{ asset('images/mipo/gs-offer.svg') }}" alt="no-image">
                        @endif
                    </div>

                    <a href="javascript:void(0)" data-currency-type="{{$currency}}" data-offer-type="mipo" data-operation-id="{{$operation->id}}" data-seller-id="{{$operation->seller_id}}" class="closed_btn evt_remove_offer">
                        <img src="{{ asset('images/mipo/ofrcloseicon.svg') }}" alt="no-image">
                    </a>
                </div>
            </li>
        </ul>
        <div class="offerboxlink">
            <a href="javascript:void(0)" disabled data-currency-type="{{$currency}}" data-offer-type="mipo" id="btn_sent_offer_{{$operation->id}}" data-operation-id="{{$operation->id}}" data-operation-amount="{{$operation->amount}}" data-seller-id="{{$operation->seller_id}}" class="evt_submit_sent_offer sent_offer_mipo_{{$operation->seller_id}}">{!! __('OFFER') !!}</a>
        </div>
    </div>
</div>