window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';
//
// window.Pusher = require('pusher-js');
//
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
// var pusher = new Pusher('API_KEY_HERE', {
//     encrypted: true
// });
//
// // Subscribe to the channel we specified in our Laravel Event
// var channel = pusher.subscribe('status-liked');
//
// // Bind a function to a Event (the full Laravel class)
// channel.bind('App\\Events\\StatusLiked', function(data) {
//     // this is called when the event notification is received...
// });
// import Pusher from "pusher-js"
// // Enable pusher logging - don't include this in production
// Pusher.logToConsole = true;
//
// var pusher = new Pusher('1e567bfd239edc66230b', {
//     // encrypted: true;
//     cluster: 'us3'
// });
//
// // Subscribe to the channel we specified in our Laravel Event
// var channel = pusher.subscribe('message');
//
// // Bind a function to a Event (the full Laravel class)
// channel.bind('App\\Events\\SendMessageEvent', function (data) {
//     console.log(data);
// })
