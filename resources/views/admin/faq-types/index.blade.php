<x-app-admin-layout>
    @section('pageTitle', 'Marketing FAQ Types List')
    @section('custom_style')
    <link href="{{ asset('plugins/DataTables/DataTables-1.12.1/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/DataTables/Responsive-2.3.0/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('FAQ Types') }}
            @permission('add-faq-type')
            <x-slot name="right">
                <a href="{{ route('admin.faq-types.create') }}">
                    <button type="button" class="btn btn-sm btn-dark">Add FAQ Type</button>
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
                                    <th>Name</th>
                                    <th class="no-sort text-center">Active</th>
                                    <th class="no-sort text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody id="partner-sortable">
                                @if($faqTypes->isNotEmpty())
                                    @foreach($faqTypes as $faqType)
                                        <tr id="row-{{ $faqType->slug }}">
                                            <td>{{ $faqType->name }}</td>
                                            <td align="center"><x-active-status :status="$faqType->is_active" /></td>
                                            <td class="actions" align="center">
                                                @permission('edit-faq-type')
                                                <a href="{{ route('admin.faq-types.edit', $faqType) }}"><button type="button" class="btn btn-sm btn-primary">Edit</button></a>
                                                @endpermission
                                                {{-- <a href="" onclick="if(confirm('Are you sure, you want to delete this?')){ event.preventDefault(); document.getElementById('delete-form-{{ $faqType->slug }}').submit(); }
                                                    else{ event.preventDefault(); }">
                                                    <form id="delete-form-{{ $faqType->slug }}" method="POST" action="{{ route('admin.faq-types.destroy', $faqType) }}" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type="button" class="text-white btn btn-sm btn-danger">Delete</button>
                                                </a> --}}
                                                @permission('delete-faq-type')
                                                <a href="javascript:;" data-href="{{ route('admin.faq-types.forcedelete', $faqType->slug) }}" onclick="permanentDeleteRecord(this)" data-slug="{{ $faqType->slug }}" class="text-white btn btn-sm btn-danger">Delete</a>
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
