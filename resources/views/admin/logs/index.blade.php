<x-app-admin-layout>
    @section('pageTitle', 'Logs List')
@section('custom_style')
<link href="{{ asset('plugins/DataTables/DataTables-1.12.1/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
<link href="{{ asset('plugins/DataTables/Responsive-2.3.0/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">
@endsection

    <x-slot name="header">
        <x-header>
            {{ __('Logs') }}
            <x-slot name="right">
                {{-- <a href="{{ route('admin.issuer-bank.create') }}">
                    <button type="button" class="btn btn-sm btn-dark">{{ __('Add Logs')}}</button>
                </a> --}}
            </x-slot>
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
                                        <th>{{ __('Title')}}</th>
                                        <th>{{ __('Ip Address')}}</th>
                                        <th>{{ __('Device Info')}}</th>
                                        <th>{{ __('Created At')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($logs->isNotEmpty())
                                        @foreach($logs as $val)
                                        <tr>
                                            <td>{{ $val->title }}</td>
                                            <td>{{ $val->user_ip_address }}</td>
                                            <td>{{ $val->user_device }}</td>
                                            <td>{{ $val->created_at }}</td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="pt-1">
                                <div class="d-flex justify-content-center justify-content-sm-between flex-wrap flex-sm-nowrap align-items-center">
                                    <div class="text-center text-sm-left">{{ $logs->links() }}</div>
                                </div>
                            </div>
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
@endsection
</x-app-admin-layout>
