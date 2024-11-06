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
                <th>
                    <div class="form-check">
                        <input class="form-check-input" value="1"  type="checkbox" id="evt_select_all_chk_box_delete">
                        <label class="form-check-label" for="evt_select_all_chk_box_delete">
                            {{-- {{ __('Select All')}} --}}
                        </label>
                    </div>
                </th>
                @if(!in_array('seller_name', $column_names))
                    <th class="sorting {{ getSortingClassBySortColumn($sortType, 'seller_id', $sortColumn) }}" data-column-name="seller_id">{!!__('Seller') !!} <br> {{ __('Name')}}</th>
                @endif
                @if(!in_array('ruc_id', $column_names))
                    <th class="sorting {{ getSortingClassBySortColumn($sortType, 'ruc_text_id', $sortColumn) }}" data-column-name="ruc_text_id">{{ __('RUC ID')}}</th>
                @endif
                @if(!in_array('opt_number', $column_names))
                    <th class="sorting {{ getSortingClassBySortColumn($sortType, 'operation_number', $sortColumn) }}" data-column-name="operation_number">{!! __('Operation') !!} <br> {{ __('Number')}}</th>
                @endif
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'operation_type', $sortColumn) }}" data-column-name="operation_type">{!! __('Operation') !!} <br> {{ __('Type') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'amount', $sortColumn) }}" data-column-name="amount">{{ __('Amount') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'amount_requested', $sortColumn) }}" data-column-name="amount_requested">{!! __('Amount') !!} <br> {{ __('Requested')}}</th>
                @if(!in_array('payers_name', $column_names))
                    <th class="sorting {{ getSortingClassBySortColumn($sortType, 'issuer_id', $sortColumn) }}" data-column-name="issuer_id">{!! __('Payers') !!} <br> {{ __('Name') }}</th>
                @endif
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'mipo_verified', $sortColumn) }}" data-column-name="mipo_verified">{!!__('Mipo') !!} <br> {{ __('Verified') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'extra_expiration_days', $sortColumn) }}" data-column-name="extra_expiration_days">{!! __('Extra') !!} <br> {{ __('Days') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'expiration_date', $sortColumn) }}" data-column-name="expiration_date">{!! __('Expiration') !!} <br> {{ __('Date') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'operations_status', $sortColumn) }}" data-column-name="operations_status">{{ __('Status') }}</th>
                <th class="no-sort text-center">{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($data->isNotEmpty())
                @foreach($data as $val)
                    <tr id="row-{{$val->slug}}">
                        <td>
                            @if($val->offers_count == 0 || $val->operations_status !='Approved')
                            {{-- @if($val->offers->count() == 0) --}}
                            <div class="form-check">
                                <input class="form-check-input evt_single_chk_box_delete" type="checkbox" name="chk_box_delete[]" value="{{$val->id}}" id="operation_{{$val->id}}">
                            </div>
                            @else
                                <div class="form-check"></div>
                            @endif
                        </td>
                        @if(!in_array('seller_name', $column_names))
                            <td>{{ $val->seller?->name ?? '-' }}</td>
                        @endif
                        @if(!in_array('ruc_id', $column_names))
                            <td>{{ $val->issuer?->ruc_text_id ?? '-' }}</td>
                        @endif
                        @if(!in_array('opt_number', $column_names))
                            <td>{{ $val->operation_number }}</td>
                        @endif
                        <td>{{ $val->operation_type }}</td>
                        <td>{{ app('common')->currencyBySymbol($val->preferred_currency).''.app('common')->currencyNumberFormat($val->preferred_currency, $val->amount) }}</td>
                        <td>{{ app('common')->currencyBySymbol($val->preferred_currency).''.app('common')->currencyNumberFormat($val->preferred_currency, $val->amount_requested) }}
                        <br>
                            <h6><span class="text-white badge text-bg-{{ ($val->accept_below_requested =='1')? 'success' : 'danger' }}">{{ ($val->accept_below_requested =='1')? 'Yes' : 'No' }}</span></h6>
                        </td>
                        @if(!in_array('payers_name', $column_names))
                            <td>{{ $val->issuer?->company_name ?? '-' }}</td>
                        @endif
                        <td>
                            <span class="text-white badge text-bg-{{ ($val->mipo_verified =='Yes')? 'success' : 'danger' }}">{{ $val->mipo_verified }}</span>
                        </td>
                        <td>{{ $val->extra_expiration_days }}</td>
                        <td>{{ $val->expire_date_iso }}</td>
                        <td>
                            <span class="text-white badge text-bg-{{ app('common')->operationStatusBgcolor($val->operations_status) }}">{{ $val->operations_status }}</span>
                        </td>
                        <td align="center">
                            @if($val->offers->count() > 0)
                            <span class="text-white badge text-bg-warning">{{ __('Offered') }}</span>
                            <a href="{{ route('admin.operations.show', $val) }}" class="text-white btn btn-sm btn-info">{{ __('Details') }}</a>
                            @else
                            @permission('edit-operation')
                            <a href="{{ route('admin.operations.edit', $val) }}" class="text-white btn btn-sm btn-primary">{{ __('Edit') }}</a>
                            @endpermission
                            {{-- @permission('operation_master') --}}
                            <a href="{{ route('admin.operations.show', $val) }}" class="text-white btn btn-sm btn-info">{{ __('Details') }}</a>

                            <a  href="javascript:void(0);" 
                                class="text-white btn btn-sm btn-primary evt_download_pdf_btn"
                                data-href="{{ route('admin.operations.export-operations-detail', $val->slug) }}"
                                data-file-name="{{ $val->operation_number }}"
                            >{{ __('Export Details') }}</a>
                            {{-- @endpermission  --}}
                            @permission('delete-operation')
                            @if($val->offers_count == 0 || $val->operations_status !='Approved')
                            {{-- @if($val->offers->count() == 0) --}}
                                {{-- @if($val->operations_status != 'Approved') --}}
                                    <a href="javascript:;" data-href="{{ route('admin.operations.delete', $val->slug) }}" onclick="permanentDeleteRecord(this)" data-slug="{{$val->slug}}" class="text-white btn btn-sm btn-danger">{{ __('Delete')}}</a>
                                @endif
                            @endpermission
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
                    <span>{{ __('Entries per page') }}:&nbsp;</span>
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
