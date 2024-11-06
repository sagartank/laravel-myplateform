@php
$sold = $unsold = $draft = $rejected = $approved = $pending = $counter = $completed = 0;
if(isset($operations_dashboard)) {

 /*    $sold = $operations_dashboard->pluck('offers')->flatten()->where('offer_status', 'Approved')->count();
    $unsold = $operations_dashboard->pluck('offers')->flatten()->where('offer_status', '!=', 'Approved')->count();
    $counter = $operations_dashboard->pluck('offers')->flatten()->where('offer_status', 'Counter')->count();
    $completed = $operations_dashboard->pluck('offers')->flatten()->where('offer_status', 'Completed')->count(); */
    // $sold = $operations_dashboard->pluck('offers')->flatten()->where('offer_status', 'Approved')->count();
    $draft = $operations_dashboard->where('operations_status', 'Draft')->count();
    $rejected = $operations_dashboard->where('operations_status', 'Rejected')->count();
    $approved = $operations_dashboard->where('operations_status', 'Approved')->count();
    $pending = $operations_dashboard->where('operations_status', 'Pending')->count();
    $unsold = $operations_dashboard->filter(function ($item) {
                    return \Carbon\Carbon::parse($item['expiration_date'])->lte(date('Y-m-d'));
                })->where('operations_status', '!=', 'Approved')->count();
    // $unsold = $operations_dashboard->where('expiration_date', '<', date('Y-m-d'))->where('operations_status', '!=', 'Approved')->count();
}
@endphp
<ul class="drafts_filter_right">
    {{-- <li><a href="javascript:;" class="evt_operation_status" data-status-name="Sold">{{ __('Sold') }} <span class="count">{{ $sold }}</span></a></li> --}}
    <li><a href="javascript:;" class="evt_operation_status" data-status-name="Unsold" data-info="Unsold as expire operation">{{ __('Unsold') }} <span class="count">{{ $unsold }}</span></a></li>
    <li><a href="javascript:;" class="evt_operation_status" data-status-name="Draft">{{ __('Draft') }} <span class="count">{{ $draft }}</span></a></li>
    <li><a href="javascript:;" class="evt_operation_status" data-status-name="Rejected">{{ __('Rejected') }} <span class="count">{{ $rejected }}</span></a></li>
    <li><a href="javascript:;" class="evt_operation_status" data-status-name="Approved">{{ __('Approved') }} <span class="count">{{ $approved  }}</span></a></li>
    <li><a href="javascript:;" class="evt_operation_status" data-status-name="Pending">{{ __('Pending') }} <span class="count">{{ $pending }}</span></a></li>
    {{-- <li><a href="javascript:;" class="evt_operation_status" data-status-name="Counter">{{ __('Counter') }} <span class="count">{{ $counter }}</span></a></li> --}}
</ul>