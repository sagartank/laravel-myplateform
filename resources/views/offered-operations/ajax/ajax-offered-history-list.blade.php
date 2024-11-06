<table>
    <thead>
        <tr class="forbg">
            <th class="text-14-medium">{{ __('Offered By') }}</th>
            <th class="text-14-medium">{{ __('Amount') }}</th>
            <th class="text-14-medium">{{ __('Retention') }} </th>
            <th class="text-14-medium">{{ __('Payment Method')}}</th>
            <th class="text-14-medium">{{ __('MIPO+') }}</th>
            <th class="text-14-medium">{{ __('Date and Time of Offer')}}</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($offers_histories) && $offers_histories->count() > 0)
            @foreach ($offers_histories as $key => $offers_history)
                <tr>
                    {{--   <td class="text-12-medium">{{ app('common')->lockOfferBy($offers_history->offer_by->name, ['offer_by']) }}
                        <br>
                        <span>{{ $offers_history->offer_status == 'Counter' ? 'Counter' : 'Pending' }}</span>
                    </td> --}}
                    <td class="text-12-medium">
                        @if($offers_history->created_by == Auth()->user()?->id)
                        {{ __('You')}}
                        @else
                        {{ app('common')->lockOfferBy($offers_history->offer_by->name, ['offer_by']) }}
                        @endif
                        {{-- <span>{{ __($offers_history->offer_status == 'Counter' ? 'Counter' : 'Pending') }}</span> --}}
                    </td>
                    <td class="text-12-medium">{{ $currency_symblos[$currency_name] }}{{ app('common')->currencyNumberFormat($currency_name, $offers_history->amount) }}
                    </td>
                    <td class="text-12-medium">{{ $currency_symblos[$currency_name] }}{{ app('common')->currencyNumberFormat($currency_name, $offers_history->retention) }}</td>
                    <td class="text-12-medium highlight">{{ __($offers_history->preferred_payment_method) }}</td>
                    <td class="text-12-medium">{{ __($offers_history->is_mipo_plus) }}</td>
                    <td class="text-12-medium">{{ $offers_history->offer_create_date_iso }}
                        {{--   <br>
                        <span> {{ __('Expire in ')}} {{ $offers_history->offer_expire }}</span> --}}
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6">
                    <p class="text-center font-weight-bold text-danger mt-3">
                        {{ __('No Record Found.') }}
                    </p>
                </td>
            </tr>
        @endif
    </tbody>
</table>

{{-- mobile history table:st --}}
<div class="mobile_history_table">
    @if (isset($offers_histories) && $offers_histories->count() > 0)
        @foreach ($offers_histories as $key => $offers_history)
            <div class="open_mobile_content">
                <div class="mobile_lr">
                    <p class="text-14-medium">{{ __('Offered By') }}</p>
                    <h6 class="text-14-medium">
                        @if($offers_history->created_by == Auth()->user()?->id)
                        {{ __('You')}}
                        @else
                        {{ app('common')->lockOfferBy($offers_history->offer_by->name, ['offer_by']) }}
                        @endif
                        {{-- <span>{{ __($offers_history->offer_status == 'Counter' ? 'Counter' : 'Pending') }}</span> --}}
                    </h6>
                </div>
                <div class="mobile_lr">
                    <p class="text-14-medium">{{ __('Offer Amount') }}</p>
                    <h6 class="text-14-medium">{{ $currency_symblos[$currency_name] }}{{ app('common')->currencyNumberFormat($currency_name, $offers_history->amount) }}</h6>
                </div>
                <div class="mobile_lr">
                    <p class="text-14-medium">{{ __('Retention') }}</p>
                    <h6 class="text-14-medium">{{ $currency_symblos[$currency_name] }}{{ app('common')->currencyNumberFormat($currency_name, $offers_history->retention) }}</h6>
                </div>
                <div class="mobile_lr">
                    <p class="text-14-medium">{{ __('Payment Method') }}</p>
                    <h6 class="text-14-medium">{{ __($offers_history->preferred_payment_method) }}</h6>
                </div>
                <div class="mobile_lr">
                    <p class="text-14-medium">{{ __('MIPO+') }}</p>
                    <h6 class="text-14-medium">{{ __($offers_history->is_mipo_plus) }}</h6>
                </div>
                <div class="mobile_lr">
                    <p class="text-14-medium">{{ __('Date and Time of Offer') }}</p>
                    <h6 class="text-14-medium">{{ $offers_history->offer_create_date_iso }}</h6>
                </div>
            </div>
        @endforeach
    @endif
   {{--  <div class="open_mobile_content">
        <div class="mobile_lr">
            <p class="text-14-medium">Offered By</p>
            <h6 class="text-14-medium">R*****</h6>
        </div>
        <div class="mobile_lr">
            <p class="text-14-medium">Offer Amount</p>
            <h6 class="text-14-medium">0</h6>
        </div>
        <div class="mobile_lr">
            <p class="text-14-medium">Retention</p>
            <h6 class="text-14-medium">0</h6>
        </div>
        <div class="mobile_lr">
            <p class="text-14-medium">Payment Method</p>
            <h6 class="text-14-medium">Cash</h6>
        </div>
        <div class="mobile_lr">
            <p class="text-14-medium">MIPO+</p>
            <h6 class="text-14-medium">NO</h6>
        </div>
        <div class="mobile_lr">
            <p class="text-14-medium">Date and Time of Offer</p>
            <h6 class="text-14-medium">May 00, 0000 00:00 AM</h6>
        </div>
    </div> --}}
</div>
{{-- mobile history table:nd --}}
