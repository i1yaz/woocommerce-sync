<?php

return [
    'url' => env('WOO_URL', ''),
    'consumer_key' => env('WOO_CONSUMER_KEY', ''),
    'consumer_secret' => env('WOO_CONSUMER_SECRET', ''),
    'options' => [
        'version' => 'wc/v3',
    ]
];
