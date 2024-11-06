    @if ($offers && $offers->count() > 0)
        @php
            $high_amount = $offers->max('amount');
            $currency = app('common')->currencyBySymbol($offers->first()->preferred_currency);
            $high = app('common')->currencyNumberFormat($offers->first()->preferred_currency, $offers->max('amount'));
            $min = app('common')->currencyNumberFormat($offers->first()->preferred_currency, $offers->min('amount'));
            $avg = app('common')->currencyNumberFormat($offers->first()->preferred_currency, $offers->avg('amount'));
        @endphp
        <input type="hidden" name="offer_high_value" value="{{ $currency }}{{ $high }}" id="offer_high_value">
        <input type="hidden" name="offer_low_value" value="{{ $currency }}{{ $min }}" id="offer_low_value">
        <input type="hidden" name="offer_avg_value" value="{{ $currency }}{{ $avg }}" id="offer_avg_value">
        @foreach ($offers as $key => $offer)
            <a href="javascript:;" id="row_offer_remove_{{ $offer->id }}" data-offer-id="{{ $offer->id }}"
                data-operation-id="{{ $offer->operations->first()->id }}"
                class="opera_oction evt_send_offer_single {{ $high_amount <= $offer->amount ? 'high_price' : '' }}">
                <div class="opera_leftpart">
                    <div class="oction_head">
                        <h6 class="text-14-medium"> {{ app('common')->lockOfferDetail($offer, ['buyer_name']) }}</h6>
                        @if ($offer->offer_status == 'Counter')
                            <div class="tag text-12-medium">{!! __('Counter offer') !!}</div>
                        @endif
                    </div>
                    <p class="text-14-medium"> 
                        {{ app('common')->diffForHumans($offer->expires_at) }}
                        {{-- {{ __('Expire in') }} {{ $offer->offer_expire_hour }}
                        {{ __('hour') }} --}}
                    </p>
                </div>
                <div class="opera_rightpart">
                    <h6 class="text-14-medium">
                        {{ app('common')->currencyBySymbol($offer->preferred_currency) }}{{ app('common')->currencyNumberFormat($offer->preferred_currency, $offer->amount) }}
                    </h6>
                    <p class="text-14-medium">
                        {{ __($offer->preferred_payment_method) }}
                    </p>
                </div>
            </a>
        @endforeach
    @else
    @endif
