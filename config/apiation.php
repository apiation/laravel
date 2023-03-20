<?php

return [
    'token' => env('APIATION_TOKEN'),

    // Whether the API call should be made asynchronously
    'async' => true,

    //     To optimize performance you can queue the API call. To do so you can make an array and enter the desired queue and connection you want to push the job on.
    //        'queue' => [
    //        'queue' => '',
    //        'connection' => ''
    //    ],
    //     If you want to use the default queue settings you can do the following:
    //     'queue' => true,
    //     Alternatively, if you don't want to utilize the queue, leave the value null
    'queue' => null,

    'sample_rate' => env('APIATION_SAMPLE_RATE', 0.03),
];
