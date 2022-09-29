import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

declare global {
    interface Window {
        Pusher: typeof Pusher;
        Echo: Echo;
    }
}

window.Pusher = Pusher;

window.Echo = new Echo({
    namespace: 'Waterhole.Events',
    ...window.Waterhole.echoConfig,
});

window.Echo.registerTurboRequestInterceptor();
