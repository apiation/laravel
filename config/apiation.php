<?php

return [

    'token' => env('APIATION_TOKEN'),

    // Whether the API call should be made asynchronously
    'async' => true,

    'queue' => null,
    //    'queue' => [
    //        'queue' => '',
    //        'connection' => ''
    //    ],

    'sample_rate' => env('APIATION_SAMPLE_RATE', 0.03),
];
