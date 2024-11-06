<x-app-admin-layout>
    @section('pageTitle', 'Payer Issuer List')
    @section('custom_style')
        <link href="{{ asset('plugins/DataTables/DataTables-1.12.1/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/DataTables/Responsive-2.3.0/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Payer Issuer') }}
            @permission('add-payer-issuer')
                <x-slot name="right">
                    <a href="{{ route('admin.payer-issuer.create') }}">
                        <button type="button" class="btn btn-sm btn-dark">{{ __('Add Payer Issuer') }}</button>
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
                                        <th>{{ __('Owner of Company') }}</th>
                                        <th>{{ __('Payer Issuer Name') }}</th>
                                        <th>{{ __('Trade Name') }}</th>
                                        <th>{{ __('RUC') }}</th>
                                        <th class="no-sort text-center">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($issuer->isNotEmpty())
                                        @foreach ($issuer as $val)
                                            <tr id="row-{{ $val->slug }}">
                                                <td>{{ $val->first_name . ' ' . $val->last_name }}</td>
                                                <td>{{ $val->company_name }}</td>
                                                <td>{{ $val->tradename }}</td>
                                                <td>{{ $val->ruc_text_id }}</td>
                                                <td class="actions" align="center">
                                                    @permission('edit-payer-issuer')
                                                        <a href="{{ route('admin.payer-issuer.edit', $val) }}"
                                                            class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                                                    @endpermission
                                                    @if ($val->trashed())
                                                        <a href="javascript:;"
                                                            data-href="{{ route('admin.payer-issuer.delete', $val->slug) }}"
                                                            onclick="deleteRecord(this)" data-name="restore"
                                                            class="text-white btn btn-sm btn-success">{{ __('Restore') }}</a>
                                                    @else
                                                        @permission('delete-payer-issuer')
                                                            <a href="javascript:;"data-href="{{ route('admin.payer-issuer.delete', $val->slug) }}"
                                                                onclick="deleteRecord(this)" data-name="delete"
                                                                class="text-white btn btn-sm btn-danger">{{ __('Delete') }}</a>
                                                        @endpermission
                                                    @endif
                                                    
                                                    @permission('delete-payer-issuer')
                                                    <a href="javascript:;" data-href="{{ route('admin.payer-issuer.forcedelete', $val->slug) }}" onclick="permanentDeleteRecord(this)" data-slug="{{$val->slug}}" class="text-white btn btn-sm btn-danger">Permanent Delete</a>
                                                    @endpermission

                                                    <a href="javascript:;" data-issuer-id="{{ $val->id }}"
                                                        class="text-white btn btn-sm btn-info evt_add_edit_contract_sign_modal">{{ __('Add Contract Sign') }}</a>
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

    <div class="modal fade" id="add_edit_contract_sign_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Add / Edit Contract Sign') }}</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="add_edit_contract_sign_form" id="add_edit_contract_sign_form" method="post">
                        @csrf
                        <input type="hidden" name="issuer_id" id="issuer_id" value="" />
                        <input type="hidden" name="edit_id" id="edit_id" value="" />
                        <div class="row">
                            <div class="col-md-4">
                                {{-- <label for="name" class="col-form-label">{{ __('Name') }}</label> --}}
                                <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                    <option value="">Select user</option>
                                    @foreach ($users as $userObj)
                                    <option  value="{{ $userObj->slug }}"> {{ $userObj->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" id="cmd_btn_txt" class="btn btn-primary">{{ __('Add') }}</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div id="ajax_user_contract_sign_list" class="mt-4"></div>
                </div>
            </div>
        </div>
    </div>
    @section('custom_script')
        <script src="{{ asset('plugins/DataTables/DataTables-1.12.1/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/DataTables/DataTables-1.12.1/js/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('plugins/DataTables/Responsive-2.3.0/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('plugins/DataTables/Responsive-2.3.0/js/responsive.bootstrap5.min.js') }}"></script>
        <script>
            $(document).ready(function() {

                $(document).on('click', '.evt_edit_user_contract_sing', function(e) {
                    e.preventDefault();
                    var el = $(this);
                    var name = el.attr('data-name');
                    var email = el.attr('data-email');
                    var mobile = el.attr('data-mobile-number');
                    var id = el.attr('data-id');
                    var issure_id = el.attr('data-issure-id');
                    var user_id = el.attr('data-user-id');
                    console.log(user_id);
                    $('#issuer_id').val(issure_id);
                    $('#user_id').val(user_id);
                    $('#name').val(name);
                    $('#email').val(email);
                    $('#mobile_number').val(mobile);
                    $('#edit_id').val(id);
                    $('#cmd_btn_txt').text('Update');
                });

                $(document).on('click', '.evt_add_edit_contract_sign_modal', function(e) {
                    e.preventDefault();
                    $('#add_edit_contract_sign_modal').modal('show');
                    $('#add_edit_contract_sign_form')[0].reset();
                    var issuer_id = $(this).attr('data-issuer-id');
                    $('#issuer_id').val(issuer_id);
                    $('#cmd_btn_txt').text('Add');
                    $('#edit_id').val('');
                    initTableUserContract(issuer_id);
                });

                $('#add_edit_contract_sign_form').submit(function(e) {
                    e.preventDefault();
                    var formData = $('#add_edit_contract_sign_form').serialize();
                    $.ajax({
                        type: 'POST',
                        data: formData,
                        url: "{{ route('admin.user-contract-sing.store') }}",
                        success: function(res) {
                            if (res.status == true) {
                                toastr.success(res.message);
                                $('#user_id').val('');
                                $('#name').val('');
                                $('#email').val('');
                                $('#mobile_number').val('');
                                $('#edit_id').val('');
                                var issuer_id = $('#issuer_id').val();
                                $('#cmd_btn_txt').text('Add');
                                initTableUserContract(issuer_id);
                                // $('#add_edit_contract_sign_modal').modal('hide');
                            }
                        },
                        error: function(xhr) {
                            ajaxErrorMsg(xhr);
                        }
                    });
                });

                function initTableUserContract(issuer_id) {
                    $.ajax({
                        type: 'GET',
                        data: {
                            'issuer_id': issuer_id
                        },
                        url: "{{ route('admin.user-contract-sing.index') }}",
                        success: function(res) {
                            if(res.status == true) {
                                $('#ajax_user_contract_sign_list').html(res.data.dhtml);
                            } else {
                                toastr.error(res.message);
                            }
                        },
                        error: function(xhr) {
                            ajaxErrorMsg(xhr);
                        }
                    });
                }
            });
        </script>
    @endsection
</x-app-admin-layout>
