import _ from 'lodash';
window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
    // key: 'staging',
    // wsHost: window.location.hostname,
    // wsPort: 6001,
    // forceTLS: false,
    disableStats: false,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
});

window.Echo.private(`App.Models.User.${login_user_id}`)
    .notification((notification) => {
        var name = null;
            if(notification.name) {
                name = notification.name;
            } else if(notification.user_name) {
                name = notification.user_name;
            }
        console.log('notification', notification);
        var notify_template = `<div class="notify_item flxrow">
                                    <div class="notify_user flxrow">
                                    <div class="user flxfix"></div>
                                        <div class="info flxflexi">
                                            <h6>${name}</h6>
                                            <p>${notification.title}</p>
                                        </div>
                                    </div>
                                </div>`;

    $('#ajax_header_notify_list').append(notify_template);
});
