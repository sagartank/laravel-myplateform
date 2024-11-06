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
    <table class="table table-bordered table-hover dt-responsive nowrap" id="activity-logs-table">
        <thead>
            <tr>                
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'created_at', $sortColumn) }}" data-column-name="created_at">{{ __('Time') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'event', $sortColumn) }}" data-column-name="event">{{ __('Event') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'subject_type', $sortColumn) }}" data-column-name="subject_type">{{ __('Subject') }}</th>
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'causer_id', $sortColumn) }}" data-column-name="causer_id">{{ __('Causer') }}</th>
                <th class="no-sort text-center">{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($activityLogs->isNotEmpty())
                @foreach($activityLogs as $activeLog)
                    <tr>
                        <td>{{ date('d-m-Y H:i:s',strtotime($activeLog->created_at)) }}</td>
                        <td>{{ $activeLog->event }}</td>
                        <td>{{ ($activeLog->subject_type == 'App\Models\CaseModel') ? 'CaseNumber' : str_replace('App\Models\\', '', $activeLog->subject_type) }}</td>
                        <td>{{ $activeLog->causer->name }}</td>
                        <td class="actions" align="center">
                            
                            <a href="{{route('admin.activity-logs.ajax-show-activity-log',$activeLog->id)}}" class="show-activity-log-btn" 
                                data-activity-log-id="{{ $activeLog->id }}">
                                <button type="button" class="btn btn-sm btn-primary">{{ __('Detail') }}</button>
                            </a>

                            <a href="{{route('admin.activity-log.export', $activeLog->id)}}" class="" data-activity-log-id="{{ $activeLog->id }}">
                                <button type="button" class="btn btn-sm btn-danger text-white">{{ __('Export') }}</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="pt-1">
        <div class="d-flex justify-content-center justify-content-sm-between flex-wrap flex-sm-nowrap align-items-center">
            <div class="text-center text-sm-left">{{ $activityLogs->links() }}</div>
            @if($activityLogs->isNotEmpty())
                <div class="mt-2 mt-sm-0 text-center text-sm-right">
                    <span>Entries per page:&nbsp;</span>
                    <select name="per_page" id="per-page" form="form-filter-activity-log">
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
