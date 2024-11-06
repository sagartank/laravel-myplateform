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
                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'name', $sortColumn) }}" data-column-name="name">{{ __('Name') }}</th>
{{--                <th class="sorting {{ getSortingClassBySortColumn($sortType, 'role_id', $sortColumn) }}" data-column-name="role_id">Role</th>--}}
                <th>{{ __('Email')}}</th>
                <th>{{ __('Phone') }}</th>
                <th>{{ __('Is Active')}}</th>
{{--                <th class="no-sort text-center">Status</th>--}}
                <th class="no-sort text-center">{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($users->isNotEmpty())
                @foreach($users as $user)
                    <tr id="row-{{$user->slug}}">
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>
                            @if($user->is_active == '1')
                                <span class="text-white badge text-bg-success">{{ __('Yes') }}</span>
                            @else
                                <span class="text-white badge text-bg-danger">{{ __('No') }}</span>
                            @endif
                        </td>
                        <td class="actions" align="center">
                            @permission('edit-user')
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                            @endpermission
                            @if($user->trashed())
                                <a href="javascript:;" data-href="{{ route('admin.users.delete', $user->slug) }}" onclick="deleteRecord(this)" data-name="restore" class="text-white btn btn-sm btn-success">{{ __('Restore')}}</a>
                            @else
                                @permission('delete-user')
                                <a href="javascript:;"data-href="{{ route('admin.users.delete', $user->slug) }}" onclick="deleteRecord(this)" data-name="delete" class="text-white btn btn-sm btn-danger">{{ __('Delete')}}</a>
                                @endpermission
                            @endif
                            @permission('permanent-delete-user')
                            <a href="javascript:;" data-href="{{ route('admin.users.forcedelete', $user->slug) }}" onclick="permanentDeleteRecord(this)" data-slug="{{$user->slug}}" class="text-white btn btn-sm btn-danger">{{ __('Permanent Delete') }}</a>
                            @endpermission
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="pt-1">
        <div class="d-flex justify-content-center justify-content-sm-between flex-wrap flex-sm-nowrap align-items-center">
            <div class="text-center text-sm-left">{{ $users->links() }}</div>
            @if($users->isNotEmpty())
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
