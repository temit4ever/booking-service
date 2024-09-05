<?php

return [
    'service'          => env('APP_SERVICE'),
    'key'              => env('WEB_BEARER_KEY'),
    'guest_public_key' => env('GUEST_PUBLIC_KEY'),
    'user_private_key' => env('USER_PRIVATE_KEY'),
    'user_public_key' => env('USER_PUBLIC_KEY'),
    'cookie_domain'    => env('COOKIE_DOMAIN'),
    'booking_url'    => env('BOOKING_URL')
];
