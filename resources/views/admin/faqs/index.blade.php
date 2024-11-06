<x-app-admin-layout>
    @section('pageTitle', 'Marketing FAQs List')
    @section('custom_style')
        <link href="{{ asset('plugins/DataTables/DataTables-1.12.1/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/DataTables/Responsive-2.3.0/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('FAQs') }}
            @permission('add-faq')
            <x-slot name="right">
                <a href="{{ route('admin.faqs.create') }}">
                    <button type="button" class="btn btn-sm btn-dark">Add FAQ</button>
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
                                    <th>Question</th>
                                    <th>Type</th>
                                    <th class="no-sort text-center">Active</th>
                                    <th class="no-sort text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($faqs->isNotEmpty())
                                    @foreach($faqs as $faq)
                                        <tr id="row-{{ $faq->slug }}">
                                            <td>{{ $faq->question }}</td>
                                            <td>{{ $faq->type->name }}</td>
                                            <td align="center"><x-active-status :status="$faq->is_active" /></td>
                                            <td class="actions" align="center">
                                                @permission('edit-faq')
                                                <a href="{{ route('admin.faqs.edit', $faq) }}"><button type="button" class="btn btn-sm btn-primary">Edit</button></a>
                                                @endpermission
                                                {{-- <a href="" onclick="if(confirm('Are you sure, you want to delete this?')){ event.preventDefault(); document.getElementById('delete-form-{{ $faq->slug }}').submit(); }
                                                    else{ event.preventDefault(); }">
                                                    <form id="delete-form-{{ $faq->slug }}" method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type="button" class="text-white btn btn-sm btn-danger">Delete</button>
                                                </a> --}}
                                                @permission('delete-faq')
                                                <a href="javascript:;" data-href="{{ route('admin.faqs.forcedelete', $faq->slug) }}" onclick="permanentDeleteRecord(this)" data-slug="{{ $faq->slug }}" class="text-white btn btn-sm btn-danger">Delete</a>
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
