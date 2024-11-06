<x-app-admin-layout>
@section('pageTitle', 'User List')
@section('custom_style')
<link href="{{ asset('plugins/DataTables/DataTables-1.12.1/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
<link href="{{ asset('plugins/DataTables/Responsive-2.3.0/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">
<link href="{{ asset('plugins/multiselect/jquery.multiselect.css') }}" rel="stylesheet">
<style>
    #data-table-list{
    width: 100% !important
}
</style>
@endsection
    <x-slot name="header">
        <x-header>
            {{ __('Users') }}
            @permission('add-user')
            <x-slot name="right">
                <a href="{{ route('admin.users.create') }}">
                    <button type="button" class="btn btn-default btn-sm btn-dark">{{ __('Add User') }}</button>
                </a>
            </x-slot>
            @endpermission
        </x-header>
    </x-slot>
    @include('components.message')
    <div class="py-4">
        <div class="container-fluid">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-user-tab" data-coreui-toggle="tab" data-coreui-target="#nav-user" type="button" role="tab" aria-controls="nav-user" aria-selected="false">{{ __('User')}}</button>
                    <button class="nav-link" id="nav-admin-tab" data-coreui-toggle="tab" data-coreui-target="#nav-admin" type="button" role="tab" aria-controls="nav-admin" aria-selected="true">{{ __('Admin')}}</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                
                <div class="tab-pane fade show active" id="nav-user" role="tabpanel" aria-labelledby="nav-user-tab" tabindex="1">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <form action="#" method="POST" id="form-filter-users" class="filter-form">
                                        @csrf
                                        <input type="hidden" name="sort_column" id="sort-column" value="">
                                        <input type="hidden" name="sort_type" id="sort-type" value="">
                                        <div class="row ">
                                            <div class="col-md-4">
                                                <input class="form-control" placeholder="{{ __('Search...') }}" type="search" name="search">
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-multi-select form-control" name="column_names[]" id="column_names" multiple data-coreui-search="true">
                                                    @foreach ($users_column_names as $key => $column_name)
                                                        <option value="{{$key}}">{{ __($column_name) }}</option>
                                                    @endforeach 
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                    <x-submit-button class="mr-2 btn-md btn-primary evt_btn_search" id="btn-filter-submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="80" height="80" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <circle cx="10" cy="10" r="7" />
                                                    <line x1="21" y1="21" x2="15" y2="15" />
                                                    </svg>
                                                        {{ __('Submit') }}
                                                    </x-submit-button>
                                                    <button type="reset" class="btn waves-effect waves-light btn-outline-dark rounded-md btn-md evt_btn_reset" id="btn-filter-reset">{{ __('Reset') }}</button>
                                                    @permission('export-users')
                                                    <button type="button" class="btn waves-effect waves-light btn-outline-dark rounded-md btn-md" id="btn-filter-export">{{ __('Export')}}</button>
                                                    @endpermission
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-body">
                                    <div id="load-user-ajax"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-admin" role="tabpanel" aria-labelledby="nav-admin-tab" tabindex="0">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <form action="#" method="POST" id="form-filter-user" class="filter-form">
                                        @csrf
                                        <input type="hidden" name="sort_column" id="sort-column" value="">
                                        <input type="hidden" name="sort_type" id="sort-type" value="">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input class="form-control" placeholder="{{ __('Search...') }}" type="search" name="search">
                                            </div>
                                            <div class="col-md-4">
                                                <x-submit-button class="mr-2 btn-md btn-primary" id="btn-filter-submit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="80" height="80" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <circle cx="10" cy="10" r="7" />
                                                <line x1="21" y1="21" x2="15" y2="15" />
                                                </svg>
                                                    {{ __('Submit') }}
                                                </x-submit-button>
                                                <button type="reset" class="btn btn-default waves-effect waves-light btn-outline-dark rounded-md btn-md" id="btn-filter-reset">{{ __('Reset')}}</button>
                                            </div>
                                            <div class="col-md-4"></div>
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
        </div>
    </div>
    <!-- Modal User Plan -->
    <div class="modal fade" id="userPlans" tabindex="-1" role="dialog" aria-labelledby="userPlansModalLabel" aria-hidden="true">
    
    </div>
@section('custom_script')
<script>
    const ajaxDataTableUrl = "{{ route('admin.users.ajax-load-admin') }}";
    const ajaxUserDataTableUrl = "{{ route('admin.users.ajax-load-user') }}";
    $(document).ready(function () {
        $('.form-multi-select').multiselect();
        initDataTable();
        initUserDataTable();
    });
</script>
<script src="{{ asset('plugins/DataTables/DataTables-1.12.1/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/DataTables-1.12.1/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/Responsive-2.3.0/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/Responsive-2.3.0/js/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('plugins/multiselect/jquery.multiselect.js') }}"></script>
<script src="{{ asset('js/user-datatable.js') }}"></script>
<script src="{{ asset('js/custom-datatable.js') }}"></script>
<script>
    $('#btn-filter-export').click(function(e){
        e.preventDefault();
        var formData = $('#form-filter-users').serialize();
        $.ajax({
            type: 'POST',
            data: formData,
            url: "{{ route('admin.users.ajax-export-users') }}",
            success: function (res) {
                if(res.status  == true)
                {
                    fileDownload(res.file_downalod, 'export_users_');
                }
            },
            error: function (xhr) {
                ajaxErrorMsg(xhr);
            }
        });
    });

    /* $(document).on('click', '.evt_send_email_address', function(e) {
        e.preventDefault();
        var self = $(this);
        var user_id = $(this).attr('data-user-id');
        setLoadin();
        $.ajax({
            type: 'GET',
            data: {},
            url: $(this).attr('data-href'),
            success: function(res) {
                unsetLoadin();
                if (res.status == true) {
                    toastr.success(res.message);
                    self.text('Resend');
                } else {
                    toastr.error(res.message);
                }
            },
            error: function(xhr) {
                unsetLoadin();
                ajaxErrorMsg(xhr);
            }
        });
    }); */

   /*  $(document).on('click', '.evt_download_kyc_address', function(e) {
        e.preventDefault();
        var self = $(this);
        var user_id = $(this).attr('data-user-id');
        setLoadin();
        $.ajax({
            type: 'GET',
            data: {},
            url: $(this).attr('data-href'),
            success: function(res) {
                unsetLoadin();
                if (res.status == true) {
                    toastr.success(res.message);
                    self.text('Resend');
                } else {
                    toastr.error(res.message);
                }
            },
            error: function(xhr) {
                unsetLoadin();
                ajaxErrorMsg(xhr);
            }
        });
    }) */
    $(document).on('click', '.get-user-plan-detail', function(e) {
        e.preventDefault();
        var self = $(this);
        $('#userPlans').html();
        setLoadin();
        $.ajax({
            type: 'GET',
            data: {},
            url: $(this).attr('href'),
            success: function(res) {
                unsetLoadin();
                if (res.status == true) {
                    $('#userPlans').html(res.view);
                    $('#userPlans').modal('show');
                } else {
                    toastr.error(res.message);
                }
            },
            error: function(xhr) {
                unsetLoadin();
                ajaxErrorMsg(xhr);
            }
        });
    }) 
    //Send reset password link to user's email
    $(document).on('click', '.send-user-reset-password-link', function(e) {
        e.preventDefault();
        var self = $(this);
        Swal.fire({
            title: 'Do you want to reset password for this user?',
            //showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Reset',
            //denyButtonText: `Don't reset`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                setLoadin();
                $.ajax({
                    type: 'GET',
                    data: {},
                    url: $(this).attr('href'),
                    success: function(res) {
                        unsetLoadin();
                        if (res.status == true) {
                            toastr.success(res.message);
                        } else {
                            toastr.error(res.message);
                        }
                    },
                    error: function(xhr) {
                        unsetLoadin();
                        ajaxErrorMsg(xhr);
                    }
                });
            }
        })
    }) 
</script>
@endsection
</x-app-admin-layout>
