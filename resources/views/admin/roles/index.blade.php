<x-app-admin-layout>
    @section('pageTitle', 'Roles List')
@section('custom_style')
<link href="{{ asset('plugins/DataTables/DataTables-1.12.1/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
<link href="{{ asset('plugins/DataTables/Responsive-2.3.0/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">
@endsection

    <x-slot name="header">
        <x-header>
            {{ __('Roles') }}
            @permission('add-role')
            <x-slot name="right">
                <a href="{{ route('admin.roles.create') }}">
                    <button type="button" class="btn btn-sm btn-dark">{{ __('Add')}} {{ __('Role')}}</button>
                </a>
            </x-slot>
            @endpermission
        </x-header>
    </x-slot>

    <div class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-hover dataTable">
                                <thead>
                                    <tr>
                                        <th>{{ __('Role Name') }}</th>
{{--                                        <th class="no-sort text-center">Status</th>--}}
                                        <th class="no-sort text-center">{{ __('Actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($roles->isNotEmpty())
                                        @foreach($roles as $role)
                                            <tr>
                                                <td>{{ $role->display_name }}</td>
{{--                                                <td class="text-center"><a href="{{ route('admin.roles.edit', $role) }}"><x-active-status :status="$role->is_active" /></a></td>--}}
                                                <td class="actions" align="center">
                                                    @permission('edit-role')
                                                    <a href="{{ route('admin.roles.edit', $role) }}"><button type="button" class="btn btn-sm btn-primary">{{ __('Edit') }}</button></a>
                                                    @endpermission
                                                    @permission('delete-role')
                                                    <a href="" onclick="if(confirm('Are you sure, you want to delete this?')){ event.preventDefault(); document.getElementById('delete-form-{{ $role->slug }}').submit(); }
                                                    else{ event.preventDefault(); }">
                                                        <form id="delete-form-{{ $role->slug }}" method="POST" action="{{ route('admin.roles.destroy', $role) }}" class="d-none">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button type="button" class="btn btn-sm btn-danger text-white">{{ __('Delete') }}</button>
                                                    </a>
                                                    @endpermission
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('custom_script')
<script src="{{ asset('plugins/DataTables/DataTables-1.12.1/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/DataTables-1.12.1/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/Responsive-2.3.0/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/Responsive-2.3.0/js/responsive.bootstrap5.min.js') }}"></script>
@endsection
</x-app-admin-layout>
