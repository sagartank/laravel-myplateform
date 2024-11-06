<table>
    <thead>
        <tr>
            <th>{{ __('Operation Number') }}</th>
            <th>{{ __('Offer Seller Name') }}</th>
            <th>{{ __('Offer Buyer Name') }}</th>
            <th>{{ __('Offer Payment Type') }}</th>
            <th>{{ __('Document Amount') }}</th>
            <th>{{ __('Offer Amount') }}</th>
            <th>{{ __('Offer Created At') }}</th>
            <th>{{ __('Offer Expired At') }}</th>
            <th>{{ __('Offer Status') }}</th>
        </tr>
    </thead>
    <tbody>
        @if ($data->isNotEmpty())
            @foreach ($data as $val)
                @php
                    $currency_symbol = app('common')->currencyBySymbol($val->operations?->first()->preferred_currency);
                    $operation_amount = app('common')->currencyNumberFormat($val->operations?->first()->preferred_currency, $val->operations?->first()->amount);
                    $offer_amount = app('common')->currencyNumberFormat($val->operations?->first()->preferred_currency, $val->amount);
                @endphp
                <tr>
                    <td>{{ $val->operations->first()?->operation_number }}</td>
                    <td>{{  $val->operations->first()?->seller?->name }}</td>
                    <td>{{ $val->buyer?->name }}</td>
                    <td>{{ $val->preferred_payment_method }}</td>
                    <td>{{ $currency_symbol . ' ' . $operation_amount }}</td>
                    <td>{{ $currency_symbol . ' ' . $offer_amount }}</td>
                    <td>{{ $val->created_at }}</td>
                    <td>{{ $val->expires_at }}</td>
                    <td>{{ $val->offer_status }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
