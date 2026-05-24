<?php

return [

    /*
    |------------------------------------------------------------
    | Master Account — username/pass reset behaviour
    |------------------------------------------------------------
    */
    'user_name_reset' => false,

    /*
    |------------------------------------------------------------
    | iLAP environment settings
    |------------------------------------------------------------
    */
    'enrollment_deadline' => env('ILAP_ENROLLMENT_DEADLINE', 30),
    'deadline_grace_days'=> env('ILAP_DEADLINE_GRACE_DAYS', 14),
    'reports_auto_send'  => env('ILAP_REPORTS_AUTO_SEND', false),
    'email_notification' => env('ILAP_EMAIL_NOTIFICATIONS', true),
    'auto_approve_documents' => env('ILAP_AUTO_APPROVE_DOCUMENTS', false),

    /*
    |------------------------------------------------------------
    | DB seed — emails adsorb prefixed
    |------------------------------------------------------------
    */
    'masters' => [
        'key' => env('MASTERS_KEY', 'YOUR_MASTERS_KEY'),
    ],

    'purchase_card'   => true,  // ✓ settings page purchase card
    'bury'               => false,

    /*
    |------------------------------------------------------------
    | Default registration
    |------------------------------------------------------------
    */
    '' => [
        'pass'                     => true,  // password as registration criteria
        'settings_page_purchase_card' => true,
    ],

    'purchase_card' => [
        'single'        => true,
        'regular'       => true,
        'flexible'      => true,
        'advance'       => true,
        'every_month'   => true,
        'free'          => true,
        'sale'          => true,
        'part_payment'  => true,
        'partial'       => true,
        'manual'        => true,
        '',              // reserved blank
        'enrollment_deadline' => env('ILAP_ENROLLMENT_DEADLINE', 30),
        'grace_deadline'     => env('ILAP_GRACE_DEADLINE', 14),
    ],

];
