<table>
    <thead>
        <tr>
            <th>{{ __('Seller Name') }}</th>
            <th>{{ __('RUC ID') }}</th>
            <th>{{ __('Operation Number') }}</th>
            <th>{{ __('Operation Type') }}</th>
            <th>{{ __('Amount') }}</th>
            <th>{{ __('Amount Requested') }}</th>
            <th>{{ __('Accept Below Requested') }}</th>
            <th>{{ __('Payers Name') }}</th>
            <th>{{ __('Mipo Verified') }}</th>
            <th>{{ __('Extra  Days') }}</th>
            <th>{{ __('Expiration Date') }}</th>
            <th>{{ __('Status') }}</th>
        </tr>
    </thead>
    <tbody>
        @if($data->isNotEmpty())
            @foreach($data as $val)
                <tr>
                    <td>{{ $val->seller?->name }}</td>
                    <td>{{ $val->issuer?->ruc_text_id }}</td>
                    <td>{{ $val->operation_number }}</td>
                    <td>{{ $val->operation_type }}</td>
                    <td>{{ app('common')->currencyBySymbol($val->preferred_currency).''.app('common')->currencyNumberFormat($val->preferred_currency, $val->amount) }}</td>
                    <td>{{ app('common')->currencyBySymbol($val->preferred_currency).''.app('common')->currencyNumberFormat($val->preferred_currency, $val->amount_requested) }}</td>
                    <td>{{ ($val->accept_below_requested =='1')? 'Yes' : 'No' }}</td>
                    <td>{{ $val->issuer?->company_name ?? '-' }}</td>
                    <td>{{ $val->mipo_verified }}</td>
                    <td>{{ $val->extra_expiration_days }}</td>
                    <td>{{ $val->expire_date_iso }}</td>
                    <td>{{ $val->operations_status }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
