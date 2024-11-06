<x-app-admin-layout>
    @section('pageTitle', 'Plans List')
@section('custom_style')
<link href="{{ asset('plugins/DataTables/DataTables-1.12.1/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
<link href="{{ asset('plugins/DataTables/Responsive-2.3.0/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">
@endsection

    <x-slot name="header">
        <x-header>
            {{ __('Plans') }}
            @permission('add-plans')
            <x-slot name="right">
                <a href="{{ route('admin.plans.create') }}">
                    <button type="button" class="btn btn-sm btn-dark">Add Plan</button>
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
                                        <th>{{ __('Plan Name') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Duration') }}</th>
                                        <th class="no-sort text-center">{{ __('Status') }}</th>
                                        <th class="no-sort text-center">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($plans->isNotEmpty())
                                        @foreach($plans as $plan)
                                            <tr>
                                                <td>{{ $plan->name }}</td>
                                                <td>{{ $plan->price }}</td>
                                                <td>{{ ucfirst($plan->duration) }}</td>
                                                <td class="text-center"><a href="{{ route('admin.plans.edit', $plan) }}"><x-active-status :status="$plan->is_active" /></a></td>
                                                <td class="actions" align="center">
                                                    @permission('edit-plans')
                                                    <a href="{{ route('admin.plans.edit', $plan) }}"><button type="button" class="btn btn-sm btn-primary">{{ __('Edit') }}</button></a>
                                                    @endpermission
                                                    @permission('delete-plans')
                                                    <a href="" onclick="if(confirm('Are you sure, you want to delete this?')){ event.preventDefault(); document.getElementById('delete-form-{{ $plan->slug }}').submit(); }
                                                    else{ event.preventDefault(); }">
                                                        <form id="delete-form-{{ $plan->slug }}" method="POST" action="{{ route('admin.plans.destroy', $plan) }}" class="d-none">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button type="button" class="btn btn-sm btn-danger text-white">Delete</button>
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
