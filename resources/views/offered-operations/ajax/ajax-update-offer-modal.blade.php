@php
    $operation = $result->operations->first();
    $operation_amount = $result->operations->first()->amount;
    $payment_type = $result->preferred_payment_method;
@endphp
<input type="hidden" 
    data-currency-type="{{ $operation->preferred_currency }}"
    data-offer-type="{{ $result->mipo_verified == 'Yes' ? 'mipo' : 'operation' }}"
    data-accept-below-requested="{{ $result->accept_below_requested }}" value="{{ $result->id }}"
    data-operation-amount="{{ $operation_amount }}" data-amount-requested="{{ $operation->amount_requested }}"
    data-operation-id="{{ $operation->id }}" data-operation-type="{{ $operation->operation_type }}"
    data-operation-number="{{ $operation->operation_number }}" data-seller-id="{{ $operation->seller_id }}"
    data-seller-name="{{ $operation->seller?->company_name }}"
    data-issuer-name="{{ $operation->issuer?->company_name }}"
    data-offer-id="{{ $result->id }}"
    id="single_operation_info_{{ $operation->id }}"
    class="group_operation_ids_{{ $operation->seller_id }}"
    data-investor-commission="{{ $investor_commission }}"
    data-mipo-commission="{{ $mipo_commission }}"
    />

<div class="offerbox">

    <div class="offer_field">
        <div class="title text-14-medium">{!! __('Payment Method') !!}</div>
        <div class="select">
            <select data-seller-id="{{ $operation->seller_id }}" data-operation-id="{{ $operation->id }}" name="offer_payment_method" id="offer_dealmode_{{ $result->id }}" class="selectbox init-nice-select form-select inputfield evt_change">
                @if (config('constants.PREFERRED_MODE'))
                    @foreach (config('constants.PREFERRED_MODE') as $key => $val)
                        <option {{ $payment_type == $val ? 'selected' : '' }}
                            value="{{ $val }}"> {{ __($key) }} </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>

    <div class="offer_field">
        <div class="title text-14-medium">{!! __('Offer Time') !!}</div>
        <div class="inputfield">
            <div class="multifield">
                <div class="ofrtime text-16-semibold">
                    <input type="number" name="offer_day_hour" maxlength="2" id="offer_day_hour_{{ $result->id }}" class="evt_input" data-seller-id="{{ $operation->seller_id }}" data-operation-id="{{ $operation->id }}">
                </div>
                <div class="timeoption">
                    <div class="select">
                        <select name="hour" id="offer_till_{{ $result->id }}" class="selectbox init-nice-select form-select evt_change" data-seller-id="{{ $operation->seller_id }}" data-operation-id="{{ $operation->id }}">
                            <option value="hour">{{ __('hour') }}</option>
                            <option value="day">{{ __('day') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="offer_field">
        <div class="title text-14-medium">{!! __('Retention Value') !!}</div>
            <div class="inputfield">
            <div class="ofr">
                @if ($operation->operation_type == 'Cheque')
                    <input type="text" disabled style="cursor: not-allowed" id="offer_retention_{{ $result->id }}" data-operation-amount="{{ $operation_amount }}" data-seller-id="{{ $operation->seller_id }}" data-operation-id="{{ $operation->id }}" data-currency-type="{{ $operation->preferred_currency }}" class="single_retention evt_change">
                @else
                    <input type="text" id="offer_retention_{{ $result->id }}" data-currency-type="{{ $operation->preferred_currency }}" data-operation-amount="{{ $operation_amount }}" data-seller-id="{{ $operation->seller_id }}" data-operation-id="{{ $operation->id }}" class="single_retention evt_change">
                @endif
                <div class="gs"><img src="{{ app('common')->currencyByImg($operation->preferred_currency) }}" alt="no-image"></div>
            </div>
        </div>
    </div>

    <div class="offer_field">
        <div class="title text-14-medium">{!! __('Offer Value') !!}</div>
        <div class="inputfield">
            <div class="ofr">
                <input type="text" id="offer_amount_{{ $result->id }}" data-seller-id="{{ $operation->seller_id }}" data-operation-id="{{ $operation->id }}" data-currency-type="{{ $operation->preferred_currency }}" class="single_offer_amount evt_change">
                <div class="gs"><img src="{{ app('common')->currencyByImg($operation->preferred_currency) }}" alt="no-image"></div>
            </div>
        </div>
    </div>

    <div class="offer_field ftrbtm">
        <div class="checkmipo">
            @if ($result->is_mipo_plus == 'Yes')
                <input type="checkbox" {{ $result->is_mipo_plus == 'Yes' ? 'checked' : '' }} data-seller-id="{{ $operation->seller_id }}" data-operation-id="{{ $operation->id }}" id="offer_mipo_{{ $result->id }}" class="group_mipo_checked_{{ $result->id }} evt_is_mipo_plus" name="is_mipo_plus" value="{{ $result->id }}">
                <label for="offer_mipo_{{ $result->id }}">
                    <div class="imgbox"><img src="{{ asset('images/mipo/exp_mipo.svg') }}" alt="no-image"></div>
                </label>
            @endif
        </div>
        <div class="modal-footer">
            <button type="button" class="text-16-medium close" data-bs-dismiss="modal">{!! __('Close') !!}</button>
            <button type="button" class="updtofr text-16-medium update_offered_operations" data-offer-id="{{ $result->id }}" id="offer_btn_{{ $result->id }}">{!! __('Update Offer') !!}</button>
        </div>
    </div>

</div>

<div class="summary_wrapper">
    <div class="summary_title"><strong class="text-20-medium">{!! __('Operation Summary') !!}</strong></div>
    <div class="operation_summary">
        <div class="sumry_item">
            <div class="lft invoiceName text-16-medium">
                <a href="javascript:;" class="invid">{!! __($operation->operation_type_number) !!}</a>
                <p>{!! __($result->preferred_payment_method) !!}</p>
                <a href="javascript:;" class="ez">{!! __($operation->seller->name) !!}</a>
            </div>
            <div class="rght text-16-medium">
                {{ app('common')->currencyNumberFormat($operation->preferred_currency, $operation_amount) }} {{ $currency_symblos[$operation->preferred_currency] }} 
            </div>
        </div>
        <div class="sumry_item">
            <div class="lft text-14-medium">{{ __('Operation Retention') }}</div>
            <div class="rght text-14-medium"><span id="current_rentention_amount">0</span> {{ $currency_symblos[$operation->preferred_currency] }}</div>
        </div>
        <div class="sumry_item">
            <div class="lft text-14-medium">{{ __('Real Time Offer') }}</div>
            <div class="rght text-14-medium"><span id="current_real_time_offer">0</span> {{ $currency_symblos[$operation->preferred_currency] }}</div>
        </div>
        <div class="sumry_item">
            <div class="lft text-14-medium">{{ __('Mipo Commission') }} {{ "($investor_commission %)"}}</div>
            <div class="rght text-14-medium"><span id="current_mipo_commission">0</span> {{ $currency_symblos[$operation->preferred_currency] }}</div>
        </div>
        <div class="sumry_item">
            <div class="lft text-14-medium">{{ __('MIPO+ Guaranteed Repurchase') }} {{ "($mipo_commission %)" }}</div>
            <div class="rght text-14-medium"><span id="current_add_mipo_commission">0</span> {{ $currency_symblos[$operation->preferred_currency] }}</div>
        </div>
        <div class="sumry_item net">
            <div class="lft text-16-medium">{{ __('Net Profit')}}</div>
            <div class="rght text-16-medium"><span id="current_net_profit">0</span> {{ $currency_symblos[$operation->preferred_currency] }}</div>
        </div>
    </div>
</div>
