<div class="sort_list_block">
    <div class="data_title">
        <h4>{{ __('Deals') }}</h4>
        <span>{{ $deals_dashboard_buyer->count() }}</span>
    </div>
    <div class="list_body">
        <ul>
            <li>
                <a href="javascript:void(0)" class="evt_deals_status" data-status-name="Approved">
                    <h4>{{ __('On Going Deals') }}</h4>
                    <span>{{ $deals_dashboard_buyer->where('offer_status', 'Approved')->count() }}</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" class="evt_deals_status" data-status-name="mipo_deals">
                    <h4>{{ __('MIPO+ Deals') }}</h4>
                    <span>{{ $deals_dashboard_buyer->whereIn('offer_status', ['Approved','Completed'])->where('is_mipo_plus', 'Yes')->count() }}</span>
                </a>
            </li>
        {{--  <li>
                <a href="javascript:void(0)">
                    <h4>{{ __('Pending Due Date') }}</h4>
                    <span>{{ $deals_dashboard_buyer->whereIn('offer_status', ['Approved','Completed'])->count() }}</span>
                </a>
            </li> --}}
            <li>
                <a href="javascript:void(0)" class="evt_deals_status" data-status-name="Completed">
                    <h4>{{ __('Finalized Deals') }}</h4>
                    <span>{{ $deals_dashboard_buyer->where('offer_status', 'Completed')->count() }}</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" class="evt_deals_status" data-status-name="Rejected">
                    <h4>{{ __('Disputes') }}</h4>
                    <span>{{ $deals_dashboard_buyer->where('is_disputed', 'Yes')->count() }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>