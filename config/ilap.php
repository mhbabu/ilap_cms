<?php

return [

    'admin_email' => env('ADMIN_EMAIL', 'admin@ilap-cms.com'),
    'admin_password' => env('ADMIN_PASSWORD', 'Admin@2025'),
    'payment_deadline' => 30,
    'deadline_grace_days' => 14,
    'reports_auto_send' => false,
    'email_notification' => true,
    'auto_approve_documents' => false,
    'mail_layout' => 'default',

];
