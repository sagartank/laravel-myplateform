<x-app-admin-layout>
    @section('pageTitle', 'Offers List')
    @section('custom_style')
    <link href="{{ asset('plugins/DataTables/DataTables-1.12.1/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/DataTables/Responsive-2.3.0/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">
    @endsection
        <x-slot name="header">
            <x-header>
                {{ __('Offers') }}
                <x-slot name="right">
                    <a href="javascript:;">
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
                                            <select class="form-control" name="preferred_currency" id="preferred_currency">
                                                <option value="">{{ __('Select Currency') }}</option>
                                                @if(config('constants.CURRENCY_TYPE'))
                                                    @foreach (config('constants.CURRENCY_TYPE') as $key => $val)
                                                    <option value="{{$val}}">{{$val}}</option>
                                                    @endforeach 
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control" name="offer_status" id="offer_status">
                                                <option value="">{{ __('Select Offer Status') }}</option>
                                                @if(config('constants.DEALS_STATUS'))
                                                    @foreach (config('constants.DEALS_STATUS') as $key => $val)
                                                        <option value="{{$val}}">{{$val}}</option>
                                                    @endforeach 
                                                @endif
                                            </select>
                                            </div>
                                            <div class="col-md-3">
                                                <x-submit-button class="mr-2 btn-sm" id="btn-filter-submit">
                                                    {{ __('Submit') }}
                                                </x-submit-button>
                                                <button type="reset" class="btn waves-effect waves-light btn-outline-dark rounded-md btn-sm" id="btn-filter-reset">{{ __('Reset')}}</button>
                                                @permission('export-offer')
                                                <button type="button" class="btn waves-effect waves-light btn-outline-dark rounded-md btn-sm" id="btn-filter-export">{{ __('Export') }}</button>
                                                @endpermission
                                            </div>
                                        </div>
                                </form>
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
    const ajaxDataTableUrl = "{{ route('admin.offers.ajax-load-offers-data') }}";
    $(document).ready(function () {
        initDataTable();
    });
</script>
<script src="{{ asset('plugins/DataTables/DataTables-1.12.1/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/DataTables-1.12.1/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/Responsive-2.3.0/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/Responsive-2.3.0/js/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('js/custom-datatable.js') }}"></script>
<script>
    $('#btn-filter-export').click(function(e){
        e.preventDefault();
        var formData = $('#form-filter-user').serialize();
        $.ajax({
            type: 'POST',
            data: formData,
            url: "{{ route('admin.offers.ajax-export-offers') }}",
            success: function (res) {
                if(res.status  == true)
                {
                    fileDownload(res.file_downalod, 'export_offer_');
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
