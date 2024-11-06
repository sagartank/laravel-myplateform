<x-app-admin-layout>
    @section('pageTitle', 'Marketing Home Slides List')
    @section('custom_style')
    {{-- <link href="{{ asset('plugins/DataTables/DataTables-1.12.1/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/DataTables/Responsive-2.3.0/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('plugins/jquery-ui-1.13.2/jquery-ui.min.css') }}" rel="stylesheet">
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Home Slides') }}
            <x-slot name="right">
                <a href="{{ route('admin.home-slides.create') }}">
                    <button type="button" class="btn btn-sm btn-dark">Add Home Slide</button>
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
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Rearrange</th>
                                    <th>Title</th>
                                    <th class="no-sort text-center">Active</th>
                                    <th class="no-sort text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody id="slide-sortable">
                                @if($homeSlides->isNotEmpty())
                                    @foreach($homeSlides as $homeSlide)
                                        <tr id="row-{{ $homeSlide->slug }}" data-id="{{ $homeSlide->slug }}" class="slide">
                                            <td><span class="handle cursor-move"><i class="icon icon-2xl cil-elevator"></i></span></td>
                                            <td>{{ $homeSlide->title }}</td>
                                            <td align="center"><x-active-status :status="$homeSlide->is_active" /></td>
                                            <td class="actions" align="center">
                                                <a href="{{ route('admin.home-slides.edit', $homeSlide) }}"><button type="button" class="btn btn-sm btn-primary">Edit</button></a>

                                                {{-- <a href="" onclick="if(confirm('Are you sure, you want to delete this?')){ event.preventDefault(); document.getElementById('delete-form-{{ $homeSlide->slug }}').submit(); }
                                                    else{ event.preventDefault(); }">
                                                    <form id="delete-form-{{ $homeSlide->slug }}" method="POST" action="{{ route('admin.home-slides.destroy', $homeSlide) }}" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type="button" class="text-white btn btn-sm btn-danger">Delete</button>
                                                </a> --}}

                                                <a href="javascript:;" data-href="{{ route('admin.home-slides.forcedelete', $homeSlide->slug) }}" onclick="permanentDeleteRecord(this)" data-slug="{{ $homeSlide->slug }}" class="text-white btn btn-sm btn-danger">Delete</a>
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
        {{-- <script src="{{ asset('plugins/DataTables/DataTables-1.12.1/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/DataTables/DataTables-1.12.1/js/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('plugins/DataTables/Responsive-2.3.0/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('plugins/DataTables/Responsive-2.3.0/js/responsive.bootstrap5.min.js') }}"></script> --}}
        <script src="{{ asset('plugins/jquery-ui-1.13.2/jquery-ui.min.js') }}"></script>
        <script>
            $(document).ready(function () {
                $slideSortable = $("#slide-sortable").sortable({
                    handle: ".handle",
                    // items: "tr",
                    cursor: 'move',
                    opacity: 0.6,
                    update: function(event, ui) {
                        sendOrderToServer();
                    },
                });
            });

            function sendOrderToServer() {

                let order = [];
                $('tr.slide').each(function(index, element) {
                    order.push($(this).attr('data-id'));
                });

                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-Token': "{{ csrf_token() }}",
                    },
                    url: "{{ route('admin.home-slides.ajax-update-step-number') }}",
                    data: {slider_steps: order},
                    success: function (res) {
                        if (res.success) {
                            console.log(res.message);
                            toastr.success(res.message);
                        }
                        else {
                            alert('Error '+ res.status + ': ' + res.message);
                        }
                    }
                });
            }
        </script>
    @endsection
</x-app-admin-layout>
