<x-app-admin-layout>
    @section('pageTitle', 'Operations List')
    @section('custom_style')
    <link href="{{ asset('plugins/DataTables/DataTables-1.12.1/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/DataTables/Responsive-2.3.0/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/multiselect/jquery.multiselect.css') }}" rel="stylesheet">
    <style>
        .full-select { width:100%; overflow: hidden;text-overflow: ellipsis;-webkit-line-clamp: 2;-webkit-box-orient: vertical;white-space: nowrap; }
    </style>
    @endsection
        <x-slot name="header">
            <x-header>
                {{ __('Operations') }}
                <x-slot name="right">
                    <a href="javascript:;">
                        {{-- <button type="button" class="btn btn-sm btn-dark">Add Operations</button> --}}
                    </a>
                </x-slot>
            </x-header>
        </x-slot>
        @include('components.message')
        <div class="py-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <form action="#" method="POST" id="form-filter-user" class="filter-form">
                                    @csrf
                                    <input type="hidden" name="sort_column" id="sort-column" value="">
                                    <input type="hidden" name="sort_type" id="sort-type" value="">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input class="form-control" placeholder="{{ __('Search...') }}" type="search" name="search">
                                        </div>
                                        <div class="col-md-3">
                                            <select name="operation_type" id="operation_type" class="form-control">
                                                <option value="">{{ __('Select Operation Type') }}</option>
                                                @if(config('constants.TYPE_OF_DOCUMENT'))
                                                    @foreach (config('constants.TYPE_OF_DOCUMENT') as $key => $val)
                                                        <option value="{{$val}}">{{$val}}</option>
                                                    @endforeach 
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="operations_status" id="operations_status" class="form-control">
                                                <option value="">{{ __('Select Operation Status') }}</option>
                                                @if(config('constants.OPERATION_STATUS'))
                                                    @foreach (config('constants.OPERATION_STATUS') as $key => $val)
                                                        <option value="{{$val}}">{{$val}}</option>
                                                    @endforeach 
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-multi-select form-control" name="column_names[]" id="column_names" multiple data-coreui-search="true">
                                                @foreach ($operations_column_names as $key => $column_name)
                                                    <option value="{{$key}}">{{$column_name}}</option>
                                                @endforeach 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-9"></div>
                                        <div class="col-md-3">
                                            <x-submit-button class="mr-2 btn-sm" id="btn-filter-submit">
                                                {{ __('Submit') }}
                                            </x-submit-button>
                                            <button type="reset" class="btn waves-effect waves-light btn-outline-dark rounded-md btn-sm" id="btn-filter-reset">{{ __('Reset')}}</button>
                                            <button type="button" class="btn waves-effect waves-light btn-outline-dark rounded-md btn-sm" id="btn-filter-export">{{ __('Export')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-header">
                                <button type="button" role="button" data-href="{{ route('admin.operations.ajax-delete-all')}}" class="btn waves-effect waves-light btn-outline-danger rounded-md btn-sm evt_btn_delete_all" disabled>{{ __('Delete All')}}</button>
                            </div>
                            <div class="card-body">
                                <div id="load-ajax"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @section('custom_script')
<script>
    const ajaxDataTableUrl = "{{ route('admin.operations.ajax-load-operations-data') }}";
    $(document).ready(function () {
        initDataTable();
    });
</script>
<script src="{{ asset('plugins/DataTables/DataTables-1.12.1/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/DataTables-1.12.1/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/Responsive-2.3.0/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/Responsive-2.3.0/js/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('plugins/multiselect/jquery.multiselect.js') }}"></script>
<script src="{{ asset('js/custom-datatable.js') }}"></script>
<script>
    $(document).ready(function() {  
        $('.form-multi-select').multiselect();  
    });  
    
    $('#btn-filter-export').click(function(e){
        e.preventDefault();
        var operation_ids = [];
        
        $('body .evt_btn_delete_all').prop('disabled', true);
        var formData = $('#form-filter-user').serializeArray();

        $("body .evt_single_chk_box_delete").each(function () {
            if ($(this).is(':visible') && $(this).prop('checked')) {
                operation_ids.push($(this).val());
            }
        });
        
        formData.push({name: 'action', value: 'export'});
        formData.push({name: 'operation_ids', value: operation_ids});
        
        $.ajax({
            type: 'POST',
            data: formData,
            url: "{{ route('admin.operations.ajax-export-operations') }}",
            success: function (res) {
                $('body #evt_select_all_chk_box_delete').prop('checked', false);
                $('body .evt_single_chk_box_delete').prop('checked', false);
                if(res.status  == true)
                {
                    fileDownload(res.file_downalod, 'export_operation_');
                }
            },
            error: function (xhr) {
                ajaxErrorMsg(xhr);
            }
        });
    });
</script>
@endsection
</x-app-admin-layout>
