<x-app-admin-layout>
    @section('pageTitle', 'Company Type List')
@section('custom_style')
<link href="{{ asset('plugins/DataTables/DataTables-1.12.1/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
<link href="{{ asset('plugins/DataTables/Responsive-2.3.0/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">
@endsection

    <x-slot name="header">
        <x-header>
            {{ __('Company') }}
            @permission('add-company-types')
            <x-slot name="right">
                <a href="{{ route('admin.companies.create') }}">
                    <button type="button" class="btn btn-sm btn-dark">{{ __('Add Company') }}</button>
                </a>
            </x-slot>
            @endpermission
        </x-header>
    </x-slot>
    @include('components.message')
    <div class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-hover dataTable">
                                <thead>
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th class="no-sort text-center">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($companies->isNotEmpty())
                                        @foreach($companies as $val)
                                        <tr id="row-{{$val->slug}}">
                                                <td>{{ $val->name }}</td>
                                                <td align="center">
                                                    @permission('edit-company-types')
                                                    <a href="{{ route('admin.companies.edit', $val) }}"><button type="button" class="btn btn-sm btn-primary">{{ __('Edit') }}</button></a>
                                                    @endpermission
                                                    @permission('delete-company-types')
                                                    <a href="javascript:;" data-href="{{ route('admin.companies.forcedelete', $val->slug) }}" onclick="permanentDeleteRecord(this)" data-slug="{{$val->slug}}" class="text-white btn btn-sm btn-danger">{{ __('Delete') }}</a>
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
