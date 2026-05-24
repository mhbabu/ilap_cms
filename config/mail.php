<?php

return [


    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'noreply@ilap-cms.com'),
        'name' => env('MAIL_FROM_NAME', 'iLAP CMS'),
    ],

    'to' => [
        'admin' => env('ADMIN_EMAIL', 'admin@ilap-cms.com'),
        'hq' => env('HQ_EMAIL', 'hq@ilap-cms.com'),
    ],

    'accounts' => new stdClass,

];
