<div class="notify_dropdon">
    <div class="notify_title">
        <h4>{{ __('Notifications') }}</h4>
        <p><a href="javascript:;" id="mark_all_as_read" class="evt_mark_all_as_read">{{ __('Mark all as read') }}</a></p>
    </div>
    {{-- <div class="push_noti">
        <div class="pushbox">
            <a href="#">
                <div class="not_push">
                    <div class="Icon">
                    <svg width="22" height="24" viewBox="0 0 22 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3332 17.929C16.507 17.6716 18.6427 17.1586 20.6962 16.4007C18.9572 14.4743 17.9962 11.9702 18.0001 9.375V8.55833V8.5C18.0001 6.64348 17.2626 4.86301 15.9498 3.55025C14.6371 2.2375 12.8566 1.5 11.0001 1.5C9.14355 1.5 7.36308 2.2375 6.05032 3.55025C4.73757 4.86301 4.00007 6.64348 4.00007 8.5V9.375C4.00359 11.9704 3.04222 14.4744 1.30273 16.4007C3.32457 17.1473 5.45607 17.6665 7.6669 17.929M14.3332 17.929C12.1189 18.1917 9.88125 18.1917 7.6669 17.929M14.3332 17.929C14.5014 18.4538 14.5432 19.011 14.4553 19.555C14.3673 20.0991 14.1522 20.6147 13.8273 21.0598C13.5025 21.505 13.0771 21.8672 12.5858 22.1169C12.0945 22.3666 11.5512 22.4967 11.0001 22.4967C10.449 22.4967 9.90564 22.3666 9.41434 22.1169C8.92304 21.8672 8.49765 21.505 8.17279 21.0598C7.84793 20.6147 7.63279 20.0991 7.54488 19.555C7.45697 19.011 7.49878 18.4538 7.6669 17.929" stroke="#A0A4A7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    </div>
                    <div class="info">
                    <h6>{{ __('Notification settings') }}</h6>
                    <p>{{ __('Automatically send new notifications') }}</p>
                    </div>
                </div>
                <form>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="plan_switch" name="plan_switch" value="yes">
                        <label class="form-check-label" for="plan_switch"></label>
                    </div>
                </form>
            </a>
        </div>
    </div> --}}
    <div class="notify_list" id="ajax_header_notify_list">
        @if($notifications->count() > 0)
            @foreach($notifications as $key => $notification)
            <div class="notify_item flxrow">
                <div class="notify_user flxrow">
                    <div class="user flxfix"></div>
                    <div class="info flxflexi">
                        <h6>{!! $notification->data['user_name'] ?? ''  !!}</h6>
                        <p>{!! $notification->data['title'] ?? '' !!}</p>
                    </div>
                </div>
                <div class="min_ago">{!!  $notification->created_at->diffForHumans() !!}</div>
            </div>
            @endforeach
        @endif
    </div>
    <div class="seeallbtn" id="sell_all_notification"><a href="{{ route('notifications.index')}}">{!! __('See all notifications') !!}</a></div>
</div>