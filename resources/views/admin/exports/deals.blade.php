<table>
    <thead>
        <tr>
            <th>{{ __('Operation Number') }}</th>
            <th>{{ __('Seller Name') }}</th>
            <th>{{ __('Document Amount') }}</th>
            <th>{{ __('Deal Amount') }}</th>
            <th>{{ __('Buyer Name') }}</th>
            <th>{{ __('Buyer Gross Profit') }}</th>
            <th>{{ __('Retention') }}</th>
            <th>{{ __('MIPO+') }}</th>
            <th>{{ __('MIPO Comission') }}</th>
            <th>{{ __('MI Coins Seller') }}</th>
            <th>{{ __('MI Coins Buyer') }}</th>
            <th>{{ __('Seller Cashed?') }}</th>
            <th>{{ __('Buyer Cashed?') }}</th>
            <th>{{ __('Dispute?') }}</th>
            <th>{{ __('Reviewed?') }}</th>
            <th>{{ __('Deal Type') }}</th>
            <th>{{ __('Deal Created At') }}</th>
            <th>{{ __('Deal Expired At') }}</th>
            <th>{{ __('Deal Status') }}</th>
        </tr>
    </thead>
    <tbody>
        @if ($data->isNotEmpty())
            @foreach ($data as $val)
                @php
                    $currency_symbol = app('common')->currencyBySymbol($val->operations?->first()->preferred_currency);
                    $operation_amount = app('common')->currencyNumberFormat($val->operations?->first()->preferred_currency, $val->operations?->first()->amount);
                    $offer_amount = app('common')->currencyNumberFormat($val->operations?->first()->preferred_currency, $val->amount);
                    $net_profit = app('common')->currencyNumberFormat($val->operations?->first()->preferred_currency, $val->net_profit);
                    $retention = app('common')->currencyNumberFormat($val->operations?->first()->preferred_currency, $val->retention);
                    $mipo_commission = app('common')->currencyNumberFormat($val->operations?->first()->preferred_currency, $val->mipo_commission);
                    $mi_coins_seller =  $val->operations?->first()->seller?->mi_coins_poinst?->sum('points');
                    $mi_coins_buyer =  $val->buyer?->mi_coins_poinst?->sum('points');
                @endphp
                <tr>
                    <td>{{ $val->operations->first()?->operation_number }}</td>
                    <td>{{ $val->operations->first()?->seller->name }}</td>
                    <td>{{ $currency_symbol.''.$operation_amount }}</td>
                    <td>{{ $currency_symbol.''.$offer_amount }}</td>
                    <td>{{ $val->buyer?->name }}</td>
                    <td>{{ $currency_symbol.''.$net_profit }}</td>
                    <td>{{ $currency_symbol.''.$retention }}</td>
                    <td>
                        @if($val->is_mipo_plus == 'Yes')
                        <span>{{ __('Yes')}}</span>
                        @else
                        <span>{{ __('No') }}</span>
                        @endif
                    </td>
                    
                    <td>{{ $currency_symbol.''.$mipo_commission }}</td>
                    <td>{{ $mi_coins_seller }}</td>
                    <td>{{ $mi_coins_buyer }}</td>
                    <td>
                        @if($val->is_cashed_seller == 'Yes')
                        <span>{{ __('Yes')}}</span>
                        @else
                        <span>{{ __('No') }}</span>
                        @endif
                    </td>
                    <td>
                        @if($val->is_cashed_buyer == 'Yes')
                        <span>{{ __('Yes')}}</span>
                        @else
                        <span>{{ __('No') }}</span>
                        @endif
                    </td>
                    <td>
                        @if($val->offer_status == 'Completed')
                        <span>{{ __('Yes')}}</span>
                        @else
                        <span>{{ __('No') }}</span>
                        @endif
                    </td>
                    <td>
                        @if($val->is_disputed == 'Yes')
                        <span>{{ __('Yes')}}</span>
                        @else
                        <span>{{ __('No') }}</span>
                        @endif
                    </td>
                    <td>{{ $val->offer_type }}</td>
                    <td>{{ $val->created_at }}</td>
                    <td>{{ $val->expires_at }}</td>
                    <td>{{ $val->offer_status }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
