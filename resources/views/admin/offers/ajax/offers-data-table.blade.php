@php
function getSortingClassBySortColumn($sortType, $column, $reqColumn = '')
{
	if ($reqColumn && $reqColumn == $column && $sortType) {
		return $sortType == 'asc' ? 'sorting_asc' : 'sorting_desc';
	} else {
		return null;
	}
}
@endphp

<div>
    <table class="table table-bordered table-hover dt-responsive nowrap" id="data-table-list">
        <thead>
            <tr>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'operation_number', $sortColumn) }}" data-column-name="operation_number">{{ __('Operation') }} <br> {{ __('Number')}}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'seller_id', $sortColumn) }}" data-column-name="seller_id">{{ __('Seller') }} <br> {{ __('Name') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'buyer_id', $sortColumn) }}" data-column-name="buyer_id">{{ __('Offer') }} <br> {{ __('Buyer Name') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'preferred_payment_method', $sortColumn) }}" data-column-name="preferred_payment_method">{{ __('Offer') }} <br> {{ __('Payment Type') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'amount', $sortColumn) }}" data-column-name="amount">{{ __('Document') }} <br> {{ __('Amount') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'amount', $sortColumn) }}" data-column-name="amount">{{ __('Offer') }} <br> {{ __('Amount') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'created_at', $sortColumn) }}" data-column-name="created_at">{{ __('Offer') }} <br> {{ __('Created At') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'expires_at', $sortColumn) }}" data-column-name="expires_at">{{ __('Offer') }} <br> {{ __('Expired At') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'offer_status', $sortColumn) }}" data-column-name="offer_status">{{ __('Offer') }} <br> {{ __('Status') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($data->isNotEmpty())
                @foreach($data as $val)
                    @php
                        $currency_symbol = app('common')->currencyBySymbol($val->operations?->first()->preferred_currency);
                        $operation_amount = app('common')->currencyNumberFormat($val->operations?->first()->preferred_currency, $val->operations?->first()->amount);
                        $offer_amount = app('common')->currencyNumberFormat($val->operations?->first()->preferred_currency, $val->amount);
                    @endphp
                    <tr id="row-{{$val->slug}}">
                        <td>{{ $val->operations?->first()->operation_number ?? '-' }}</td>
                        <td>{{ $val->operations?->first()->seller?->name ?? '-' }}</td>
                        <td>{{ ($val->buyer)? $val->buyer?->name : '-' }}</td>
                        <td>{{ $val->preferred_payment_method }}</td>
                        <td>{{ $currency_symbol. ''.$operation_amount }}</td>
                        <td>{{ $currency_symbol.''.$offer_amount }}</td>
                        <td>{{ $val->created_at }}</td>
                        <td>{{ $val->expires_at }}</td>
                        <td>
                            @if($val->offer_status == 'Approved')
                            <span class="text-white badge text-bg-success">{{ $val->offer_status  }}</span>
                            @elseif($val->offer_status == 'Rejected')
                            <span class="text-white badge text-bg-danger">{{ $val->offer_status  }}</span>
                            @elseif($val->offer_status == 'Pending')
                            <span class="text-white badge text-bg-warning">{{ $val->offer_status  }}</span>
                            @elseif($val->offer_status == 'Counter' || $val->offer_status == 'Completed')
                            <span class="text-white badge text-bg-info">{{ $val->offer_status  }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="pt-1">
        <div class="d-flex justify-content-center justify-content-sm-between flex-wrap flex-sm-nowrap align-items-center">
            <div class="text-center text-sm-left">{{ $data->links() }}</div>
            @if($data->isNotEmpty())
                <div class="mt-2 mt-sm-0 text-center text-sm-right">
                    <span>Entries per page:&nbsp;</span>
                    <select name="per_page" id="per-page" form="form-filter-user">
                        <option value="15" @if($perPage == 15) selected @endif>15</option>
                        <option value="25" @if($perPage == 25) selected @endif>25</option>
                        <option value="50" @if($perPage == 50) selected @endif>50</option>
                        <option value="100" @if($perPage == 100) selected @endif>100</option>
                    </select>
                </div>
            @endif
        </div>
    </div>
</div>
