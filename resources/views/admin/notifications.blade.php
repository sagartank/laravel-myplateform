<x-app-admin-layout>
    @section('custom_style')
        <link href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
        <style>
            div.icon>img {
                max-width: 100%;
                max-height: 100%;
                width: 100%;
                height: auto;
            }
        </style>
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Notification') }}
            <x-slot name="right">
            </x-slot>
        </x-header>
    </x-slot>

    <div class="container-lg">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    {{-- <th>{{ __('Name') }}</th> --}}
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Time') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($notifications->count() > 0 && $is_send_admin_notification == true)
                                    @foreach ($notifications as $key => $notification) 
                                        <tr>
                                            {{-- <td>{!! $notification->data['name'] ?? $notification->data['email'] !!}</td> --}}
                                            <td>{!! $notification->data['title'] ?? '' !!}</td>
                                            <td>{!!  $notification->created_at->diffForHumans() !!}</td>
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

    @section('custom_script')
     <script>
        $(document).ready(function() {
        setInterval(function () {
                location.reload();
            }, 9000);
        });
    </script>
    @endsection
</x-app-admin-layout>
