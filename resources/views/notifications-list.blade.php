<x-app-layout>
    @section('pageTitle', 'Notifications')
    @section('custom_style')
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="deals_progress_main notification_page">
        <div class="container">
            <div class="notify_title flxrow">
                <h4>
                    <a href="{{ route('dashboard') }}"><img src="{{ asset('images/mipo/dashboardsubpageleft.svg') }}" alt="no-image"></a>
                    {{ __('Notifications') }}
                </h4>
                <p><a href="javascript:;">{!! __('Mark all as read') !!}</a></p>
            </div>
            <div class="notifications_row">
                @if ($notifications->count() > 0)
                    @foreach ($notifications as $key => $notification)
                        <div class="noti_wrap  {{ (is_null($notification->read_at)) ? 'noti_read' : '' }}">
                            <div class="notify_user">
                                <div class="info">
                                    <h6>{!! $notification->data['user_name'] ?? '' !!}</h6>
                                    <span>{!!  $notification->created_at->diffForHumans() !!}</span>
                                </div>
                                <div class="not_text">
                                    <p>{!! $notification->data['title'] ?? '' !!}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif 
            </div>
            @if ($notifications->count() > 0)
            <div class="secttion_wrapper">
                <div class="image"><img src="{{ asset('images/mipo/notification_section.svg') }}" alt="no-image"></div>
                <p>{!! __('¡Manténgase informado con nuestras últimas actualizaciones! Te mantendremos informado con todas las notificaciones interesantes, pero recuerda que las notificaciones caducan a los 30 días. No te lo pierdas') !!}</p>
            </div>
            @endif
        </div>
    </div>
    </div>
    @section('custom_script')
    @endsection
</x-app-layout>
