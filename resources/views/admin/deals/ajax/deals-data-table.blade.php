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
                <th class="no-sort text-center">{{ __('Actions') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'offer_status', $sortColumn) }}" data-column-name="offer_status">{{ __('Deal') }} <br> {{ __('Status') }}</th>
                @if(!in_array('opt_number', $column_names))
                    <th class="sorting {{ getSortingClassBySortColumn($sortType, 'id', $sortColumn) }}" data-column-name="id">{{ __('Operation') }} <br> {{ __('Number') }}</th>
                @endif
                @if(!in_array('seller_name', $column_names))
                    <th class="sorting {{ getSortingClassBySortColumn($sortType, 'id', $sortColumn) }}" data-column-name="id">{{ __('Seller') }} <br> {{ __('Name') }}</th>
                @endif
                @if(!in_array('doc_amount', $column_names))
                    <th class="sorting {{ getSortingClassBySortColumn($sortType, 'id', $sortColumn) }}" data-column-name="id">{{ __('Document') }} <br> {{ __('Amount') }}</th>
                @endif
                @if(!in_array('deal_amount', $column_names))
                    <th class="sorting {{ getSortingClassBySortColumn($sortType, 'amount', $sortColumn) }}" data-column-name="buyer_id">{{  __('Deal') }} <br> {{ __('Amount') }}</th>
                @endif
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'buyer_id', $sortColumn) }}" data-column-name="buyer_id">{{ __('Buyer') }} <br> {{ __('Name') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'amount', $sortColumn) }}" data-column-name="buyer_id">{{  __('Buyer') }} <br> {{ __('Gross Profit') }}</th>
                @if(!in_array('retention', $column_names))
                    <th class="sorting {{ getSortingClassBySortColumn($sortType, 'retention', $sortColumn) }}" data-column-name="retention">{{  __('Retention') }}</th>
                @endif
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'is_mipo_plus', $sortColumn) }}" data-column-name="is_mipo_plus">{{  __('MIPO+') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'mipo_commission', $sortColumn) }}" data-column-name="mipo_commission">{{  __('MIPO') }} <br> {{ __('Comission') }}</th>
                @if(!in_array('mi_coins_seller', $column_names))
                    <th class="sorting {{ getSortingClassBySortColumn($sortType, 'id', $sortColumn) }}" data-column-name="id">{{  __('MI Coins') }} <br> {{ __('(Seller)')}}</th>
                @endif
                @if(!in_array('mi_coins_buyer', $column_names))
                    <th class="sorting {{ getSortingClassBySortColumn($sortType, 'id', $sortColumn) }}" data-column-name="id">{{  __('MI Coins') }} <br> {{ __('(Buyer)')}}</th>
                @endif

                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'is_cashed_seller', $sortColumn) }}" data-column-name="is_cashed_seller">{{  __('Seller') }} <br> {{ __('Cashed?')}}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'is_cashed_buyer', $sortColumn) }}" data-column-name="is_cashed_buyer">{{  __('Buyer') }} <br> {{ __('Cashed?')}}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'is_disputed', $sortColumn) }}" data-column-name="is_disputed">{{  __('Dispute?') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'is_cashed_buyer', $sortColumn) }}" data-column-name="is_cashed_buyer">{{  __('Reviewed?') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'offer_type', $sortColumn) }}" data-column-name="offer_type">{{ __('Deal') }} <br> {{ __('Type') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'created_at', $sortColumn) }}" data-column-name="created_at">{{ __('Deal') }} <br> {{ __('Created At') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'expires_at', $sortColumn) }}" data-column-name="expires_at">{{ __('Deal') }} <br> {{ __('Expired At') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($data->isNotEmpty())
                @foreach($data as $val)
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
                    <tr id="row-{{$val->slug}}">
                        <td align="center">
                            @if($val->offer_status == 'Approved' || $val->offer_status == 'Completed')
                                @permission('view-deal')
                                <a href="{{ route('admin.deals.details', $val->slug) }}" class="text-white btn btn-sm btn-info">{{ __('Details') }}</a>
                                @endpermission
                                @else
                                <span>-</span>
                            @endif
                        </td>
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
                        @if(!in_array('opt_number', $column_names))
                            <td>{{ $val->operations?->first()->operation_number ?? '' }}</td>
                        @endif
                        @if(!in_array('seller_name', $column_names))
                            <td>{{ $val->operations?->first()->seller?->name  ?? ''}}</td>
                        @endif
                        @if(!in_array('doc_amount', $column_names))
                            <td>{{  $currency_symbol.''.$operation_amount }}</td>
                        @endif
                        @if(!in_array('deal_amount', $column_names))
                            <td>{{ $currency_symbol.''.$offer_amount }}</td>
                        @endif
                        <td>{{ $val->buyer?->name }}</td>
                        <td>{{ $currency_symbol.''.$net_profit }}</td>
                        @if(!in_array('retention', $column_names))
                            <td>{{ $currency_symbol.''.$retention }}</td>
                        @endif
                        <td>
                            @if($val->is_mipo_plus == 'Yes')
                            <span class="text-white badge text-bg-success">{{ __('Yes')}}</span>
                            @else
                            <span class="text-white badge text-bg-danger">{{ __('No') }}</span>
                            @endif
                        </td>
                        <td>{{ $currency_symbol.''.$mipo_commission }}</td>
                        @if(!in_array('mi_coins_seller', $column_names))
                            <td>{{ $mi_coins_seller }}</td>
                        @endif
                        @if(!in_array('mi_coins_buyer', $column_names))
                            <td>{{ $mi_coins_buyer }}</td>
                        @endif
                        <td>
                            @if($val->is_cashed_seller == 'Yes')
                            <span class="text-white badge text-bg-success">{{ __('Yes')}}</span>
                            @else
                            <span class="text-white badge text-bg-danger">{{ __('No') }}</span>
                            @endif
                        </td>
                        <td>
                            @if($val->is_cashed_buyer == 'Yes')
                            <span class="text-white badge text-bg-success">{{ __('Yes')}}</span>
                            @else
                            <span class="text-white badge text-bg-danger">{{ __('No') }}</span>
                            @endif
                        </td>
                        <td>
                            @if($val->offer_status == 'Completed')
                            <span class="text-white badge text-bg-success">{{ __('Yes')}}</span>
                            @else
                            <span class="text-white badge text-bg-danger">{{ __('No') }}</span>
                            @endif
                        </td>
                        <td>
                            @if($val->is_disputed == 'Yes')
                            <span class="text-white badge text-bg-success">{{ __('Yes')}}</span>
                            @else
                            <span class="text-white badge text-bg-danger">{{ __('No') }}</span>
                            @endif
                        </td>
                        <td>{{ $val->offer_type }}</td>
                        <td>{{ $val->created_at }}</td>
                        <td>{{ $val->expires_at }}</td>
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
