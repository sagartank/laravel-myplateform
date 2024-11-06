<x-app-admin-layout>
    @section('pageTitle', 'Marketing Social Media List')
    @section('custom_style')
    {{-- <link href="{{ asset('plugins/DataTables/DataTables-1.12.1/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/DataTables/Responsive-2.3.0/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('plugins/jquery-ui-1.13.2/jquery-ui.min.css') }}" rel="stylesheet">
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Social Media') }}
            @permission('add-social-media')
            <x-slot name="right">
                <a href="{{ route('admin.social-media.create') }}">
                    <button type="button" class="btn btn-sm btn-dark">Add Social Media</button>
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
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>{{ __('Rearrange') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th class="no-sort text-center">{{ __('Active') }}</th>
                                    <th class="no-sort text-center">{{ __('Actions') }}</th>
                                </tr>
                                </thead>
                                <tbody id="socialmedia-sortable">
                                @if($social_media->isNotEmpty())
                                    @foreach($social_media as $val)
                                        <tr id="row-{{ $val->slug }}" data-id="{{ $val->slug }}" class="socialmedia">
                                            <td><span class="handle cursor-move"><i class="icon icon-2xl cil-elevator"></i></span></td>
                                            <td>{{ $val->name }}</td>
                                            <td align="center"><x-active-status :status="$val->is_active" /></td>
                                            <td class="actions" align="center">
                                                @permission('edit-social-media')
                                                <a href="{{ route('admin.social-media.edit', $val->slug) }}"><button type="button" class="btn btn-sm btn-primary">{{ __('Edit') }}</button></a>
                                                @endpermission
                                                {{-- <a href="" onclick="if(confirm('Are you sure, you want to delete this?')){ event.preventDefault(); document.getElementById('delete-form-{{ $socialMed->slug }}').submit(); }
                                                    else{ event.preventDefault(); }">
                                                    <form id="delete-form-{{ $socialMed->slug }}" method="POST" action="{{ route('admin.social-media.destroy', $socialMed) }}" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type="button" class="text-white btn btn-sm btn-danger">Delete</button>
                                                </a> --}}
                                                @permission('delete-social-media')
                                                <a href="javascript:;" data-href="{{ route('admin.social-media.forcedelete', $val->slug) }}" onclick="permanentDeleteRecord(this)" data-slug="{{ $val->slug }}" class="text-white btn btn-sm btn-danger">{{ __('Delete') }}</a>
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
        {{-- <script src="{{ asset('plugins/DataTables/DataTables-1.12.1/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/DataTables/DataTables-1.12.1/js/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('plugins/DataTables/Responsive-2.3.0/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('plugins/DataTables/Responsive-2.3.0/js/responsive.bootstrap5.min.js') }}"></script> --}}
        <script src="{{ asset('plugins/jquery-ui-1.13.2/jquery-ui.min.js') }}"></script>
        <script>
            $(document).ready(function () {
                $socialmediaSortable = $("#socialmedia-sortable").sortable({
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
                $('tr.socialmedia').each(function(index, element) {
                    order.push($(this).attr('data-id'));
                });

                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-Token': "{{ csrf_token() }}",
                    },
                    url: "{{ route('admin.social-media.ajax-update-step-number') }}",
                    data: {step_numbers: order},
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
