<x-app-admin-layout>
    @section('pageTitle', 'Marketing Blogs List')
    @section('custom_style')
        <link href="{{ asset('plugins/DataTables/DataTables-1.12.1/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/DataTables/Responsive-2.3.0/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Blogs') }}
            @permission('add-blog')
            <x-slot name="right">
                <a href="{{ route('admin.blogs.create') }}">
                    <button type="button" class="btn btn-sm btn-dark">{{ __('Add Blog') }}</button>
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
                                    <th>{{ __('Title') }}</th>
                                    {{-- <th class="no-sort text-center">Excerpt</th> --}}
                                    <th class="no-sort text-center">{{ __('Active') }}</th>
                                    <th class="no-sort text-center">{{ __('Actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($blogs->isNotEmpty())
                                    @foreach($blogs as $blog)
                                        <tr id="row-{{ $blog->slug }}">
                                            <td>{{ $blog->getTranslation('title','es') }}</td>
                                            {{-- <td class="text-center"><a href="{{ route('admin.blogs.edit', $blog) }}">{{ $blog->excerpt }}</td> --}}
                                            <td align="center"><x-active-status :status="$blog->is_active" /></td>
                                            <td class="actions" align="center">
                                                @permission('edit-blog')
                                                <a href="{{ route('admin.blogs.edit', $blog) }}"><button type="button" class="btn btn-sm btn-primary">{{ __('Edit') }}</button></a>
                                                @endpermission
                                                {{-- <a href="" onclick="if(confirm('Are you sure, you want to delete this?')){ event.preventDefault(); document.getElementById('delete-form-{{ $blog->slug }}').submit(); }
                                                    else{ event.preventDefault(); }">
                                                    <form id="delete-form-{{ $blog->slug }}" method="POST" action="{{ route('admin.blogs.destroy', $blog) }}" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type="button" class="text-white btn btn-sm btn-danger">Delete</button>
                                                </a> --}}
                                                @permission('delete-blog')
                                                <a href="javascript:;" data-href="{{ route('admin.blogs.forcedelete', $blog->slug) }}" onclick="permanentDeleteRecord(this)" data-slug="{{ $blog->slug }}" class="text-white btn btn-sm btn-danger">{{ __('Delete') }}</a>
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
