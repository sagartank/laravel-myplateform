<x-app-admin-layout>
    @section('custom_style')
        <link href="{{ asset('plugins/DataTables/DataTables-1.12.1/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/DataTables/Responsive-2.3.0/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Permissions') }}
            <x-slot name="right">
                <a href="{{ route('admin.permissions.create') }}">
                    <button type="button" class="btn btn-sm btn-dark">Add Permission</button>
                </a>
            </x-slot>
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
                                    <th>Permission Name</th>
                                    {{--                                        <th class="no-sort text-center">Status</th>--}}
                                    <th class="no-sort text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($permissions->isNotEmpty())
                                    @foreach($permissions as $permission)
                                        <tr>
                                            <td>{{ $permission->display_name }}</td>
                                            {{--                                                <td class="text-center"><a href="{{ route('admin.roles.edit', $permission) }}"><x-active-status :status="$permission->is_active" /></a></td>--}}
                                            <td class="actions" align="center">
                                                <a href="{{ route('admin.permissions.edit', $permission) }}"><button type="button" class="btn btn-sm btn-primary">Edit</button></a>

                                                <a href="" onclick="if(confirm('Are you sure, you want to delete this?')){ event.preventDefault(); document.getElementById('delete-form-{{ $permission->slug }}').submit(); }
                                                    else{ event.preventDefault(); }">
                                                    <form id="delete-form-{{ $permission->slug }}" method="POST" action="{{ route('admin.permissions.destroy', $permission) }}" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type="button" class="btn btn-sm btn-danger text-white">Delete</button>
                                                </a>
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