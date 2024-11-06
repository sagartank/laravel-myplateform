<x-app-admin-layout>
@section('pageTitle', 'Progress List')
@section('custom_style')
<link href="{{ asset('plugins/DataTables/DataTables-1.12.1/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
<link href="{{ asset('plugins/DataTables/Responsive-2.3.0/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">
<style>
    .row_seller, .row_buyer{
        cursor: pointer;
    }
</style>
@endsection

    <x-slot name="header">
        <x-header>
            {{ __('Progress') }}
            @permission('add-progress')
            <x-slot name="right">
                <a href="{{ route('admin.progress.create') }}">
                    <button type="button" class="btn btn-sm btn-dark">{{ __('Add Progress') }}</button>
                </a>
            </x-slot>
            @endpermission
        </x-header>
    </x-slot>
    @include('components.message')
    <div class="py-2">
        <div class="container-fluid">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-seller-tab" data-coreui-toggle="tab" data-coreui-target="#nav-seller" type="button" role="tab" aria-controls="nav-seller" aria-selected="true">{{ __('Seller') }}</button>
                    <button class="nav-link" id="nav-buyer-tab" data-coreui-toggle="tab" data-coreui-target="#nav-buyer" type="button" role="tab" aria-controls="nav-buyer" aria-selected="false">{{ __('Buyer') }}</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-seller" role="tabpanel" aria-labelledby="nav-seller-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="no-sort">Title EN</th>
                                                    <th class="no-sort">Title ES</th>
                                                    <th class="no-sort">Step Links Buyer</th>
                                                    <th class="no-sort">{{ __('Is File') }}</th>
                                                    <th class="no-sort">{{ __('Is Cashed') }}</th>
                                                    <th class="no-sort">{{ __('Is QrCode') }}</th>
                                                    <th class="no-sort">{{ __('Is Payment') }}</th>
                                                    <th class="no-sort">{{ __('Is Mipo Payment') }}</th>
                                                    <th class="no-sort">{{ __('Is Rate') }}</th>
                                                    <th class="no-sort">{{ __('Tigger By') }}</th>
                                                    <th class="no-sort">{{ __('Is Active') }}</th>
                                                    <th class="no-sort text-center">{{ __('Actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_seller">
                                                @if($progress->isNotEmpty())
                                                    @foreach($progress->where('step_type', 'Seller')->sortBy('order_position') as $val)
                                                    <tr class="row_seller" data-id="{{ $val->id }}" id="row-{{$val->slug}}" title="sortable" data-order="{{ $val->order_position }}">
                                                            <td>{{ $val->title_en }}</td>
                                                            <td>{{ $val->title_es }}</td>
                                                            <td>
                                                                @php
                                                                    $step_links_buyer_ids = $val->step_links ? json_decode($val->step_links) : [];
                                                                @endphp
                                                                @if($step_links_buyer_ids)
                                                                    @foreach ($step_links_buyer_ids as $step_links_buyer_id)
                                                                            <p>{{ $progress->pluck( 'title_en', 'id')->toArray()[$step_links_buyer_id] }}<b>,</b></p>
                                                                            {{-- <p>{{ $progress->where('step_type', 'Buyer')->pluck( 'title_en', 'id')->toArray()[$step_links_buyer_id] }}<b>,</b></p> --}}
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                            <td><span class="text-white badge text-bg-{{ ($val->file_upload == 'Yes') ? 'success' : 'danger' }}">{{ $val->file_upload }}</span></td>
                                                            <td><span class="text-white badge text-bg-{{ ($val->cashed == 'Yes') ? 'success' : 'danger' }}">{{ $val->cashed }}</span></td>
                                                            <td><span class="text-white badge text-bg-{{ ($val->qr_code == 'Yes') ? 'success' : 'danger' }}">{{ $val->qr_code }}</span></td>
                                                            <td><span class="text-white badge text-bg-{{ ($val->payment == 'Yes') ? 'success' : 'danger' }}">{{ $val->payment }}</span></td>
                                                            <td><span class="text-white badge text-bg-{{ ($val->mipo_commission_payment == 'Yes') ? 'success' : 'danger' }}">{{ $val->mipo_commission_payment }}</span></td>
                                                            <td><span class="text-white badge text-bg-{{ ($val->rate == 'Yes') ? 'success' : 'danger' }}">{{ $val->rate }}</span></td>
                                                            <td><span>{{ $val->manual_trigger }}</span></td>
                                                            <td><span class="text-white badge text-bg-{{ ($val->is_active == 'Yes') ? 'success' : 'danger' }}">{{ $val->is_active }}</span></td>
                                                            <td align="center">
                                                                @permission('edit-progress')
                                                                <a href="{{ route('admin.progress.edit', $val) }}"><button type="button" class="btn btn-sm btn-primary">{{ __('Edit')}}</button></a>
                                                                @endpermission
                                                                @permission('delete-progress')
                                                                <a href="javascript:;" data-href="{{ route('admin.progress.forcedelete', $val->slug) }}" onclick="permanentDeleteRecord(this)" data-slug="{{$val->slug}}" class="text-white btn btn-sm btn-danger">{{ __('Delete') }}</a>
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
                    <div class="tab-pane fade" id="nav-buyer" role="tabpanel" aria-labelledby="nav-buyer-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="no-sort">Title EN</th>
                                                    <th class="no-sort">Title ES</th>
                                                    <th class="no-sort">Step Links Seller</th>
                                                    <th class="no-sort">{{ __('Is File') }}</th>
                                                    <th class="no-sort">{{ __('Is Cashed') }}</th>
                                                    <th class="no-sort">{{ __('Is QrCode') }}</th>
                                                    <th class="no-sort">{{ __('Is Payment') }}</th>
                                                    <th class="no-sort">{{ __('Is Mipo Payment') }}</th>
                                                    <th class="no-sort">{{ __('Is Rate') }}</th>
                                                    <th class="no-sort">{{ __('Tigger By') }}</th>
                                                    <th class="no-sort">{{ __('Is Active') }}</th>
                                                    <th class="no-sort text-center">{{ __('Actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_buyer">
                                                @if($progress->isNotEmpty())
                                                    @foreach($progress->where('step_type', 'Buyer')->sortBy('order_position') as $val)
                                                    <tr class="row_buyer" data-id="{{ $val->id }}" id="row-{{$val->slug}}" title="sortable" data-order="{{ $val->order_position }}">
                                                            <td>{{ $val->title_en }}</td>
                                                            <td>{{ $val->title_es }}</td>
                                                            <td>
                                                                @php
                                                                    $step_links_seller_ids = $val->step_links ? json_decode($val->step_links) : [];
                                                                @endphp
                                                                @if($step_links_seller_ids)
                                                                    @foreach ($step_links_seller_ids as $step_links_seller_id)
                                                                            <p>{{ $progress->pluck( 'title_en', 'id')->toArray()[$step_links_seller_id] }}<b>,</b></p>
                                                                            {{-- <p>{{ $progress->where('step_type', 'Seller')->pluck( 'title_en', 'id')->toArray()[$step_links_seller_id] }}<b>,</b></p> --}}
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                            <td><span class="text-white badge text-bg-{{ ($val->file_upload == 'Yes') ? 'success' : 'danger' }}">{{ $val->file_upload }}</span></td>
                                                            <td><span class="text-white badge text-bg-{{ ($val->cashed == 'Yes') ? 'success' : 'danger' }}">{{ $val->cashed }}</span></td>
                                                            <td><span class="text-white badge text-bg-{{ ($val->qr_code == 'Yes') ? 'success' : 'danger' }}">{{ $val->qr_code }}</span></td>
                                                            <td><span class="text-white badge text-bg-{{ ($val->payment == 'Yes') ? 'success' : 'danger' }}">{{ $val->payment }}</span></td>
                                                            <td><span class="text-white badge text-bg-{{ ($val->mipo_commission_payment == 'Yes') ? 'success' : 'danger' }}">{{ $val->mipo_commission_payment }}</span></td>
                                                            <td><span class="text-white badge text-bg-{{ ($val->rate == 'Yes') ? 'success' : 'danger' }}">{{ $val->rate }}</span></td>
                                                            <td><span>{{ $val->manual_trigger }}</span></td>
                                                            <td><span class="text-white badge text-bg-{{ ($val->is_active == 'Yes') ? 'success' : 'danger' }}">{{ $val->is_active }}</span></td>
                                                            <td align="center">
                                                                @permission('edit-progress')
                                                                <a href="{{ route('admin.progress.edit', $val) }}"><button type="button" class="btn btn-sm btn-primary">{{ __('Edit') }}</button></a>
                                                                @endpermission
                                                                @permission('delete-progress')
                                                                <a href="javascript:;" data-href="{{ route('admin.progress.forcedelete', $val->slug) }}" onclick="permanentDeleteRecord(this)" data-slug="{{$val->slug}}" class="text-white btn btn-sm btn-danger">{{ __('Delete') }}</a>
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
        </div>
    </div>
@section('custom_script')
<script src="{{ asset('plugins/DataTables/DataTables-1.12.1/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/DataTables-1.12.1/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/Responsive-2.3.0/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/Responsive-2.3.0/js/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-ui.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#table_buyer").sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
                sendOrderToServer('Buyer');
            }
        });

        $("#table_seller").sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
                sendOrderToServer('Seller');
            }
        });
    });

    function sendOrderToServer(step_type) {
        var order = [];
        var token = $('meta[name="csrf-token"]').attr('content');

        if(step_type == 'Buyer') {
            $('tr.row_buyer').each(function(index,element) {
                order.push({
                    id: $(this).attr('data-id'),
                    position: index+1
                });
            });
        }

        if(step_type == 'Seller') {
            $('tr.row_seller').each(function(index,element) {
                order.push({
                    id: $(this).attr('data-id'),
                    position: index+1
                });
            });
        }

        $.ajax({
            type: "POST", 
            dataType: "json", 
            url: "{{ route('admin.progress.ajax-sortable') }}",
            data: {
                order : order,
                step_type : step_type,
                _token : token
            },
            success: function(res) {
                if (res.status == true) {
                    $('#ajax_res_success').show();
                    $('#ajax_msg_success').text(res.message);
                    $('#ajax_res_success').fadeOut(5000);
                } else if (res.status == false) {
                    $('#ajax_res_danger').show();
                    $('#ajax_msg_danger').text(res.message);
                    $('#ajax_res_danger').fadeOut(5000);
                } else {
                    alert('Error ! something went wrong please try again later');
                }
            },
            error: function (xhr) {
                alert('Errors ! something went wrong please try again later');
                console.log(xhr);
            }
        });
    }
</script>
@endsection
</x-app-admin-layout>
