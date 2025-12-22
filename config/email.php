<?php

declare(strict_types=1);
return [
    'driver' => env('MAIL_DRIVER', 'smtp'),
    'host' => env('MAIL_HOST', 'localhost'),
    'port' => env('MAIL_PORT', '1025'),
    'username' => env('MAIL_USERNAME', ''),
    'password' => env('MAIL_PASSWORD', ''),
    'encryption' => env('MAIL_ENCRYPTION', 'null'),
    'from_address' => env('MAIL_FROM_ADDRESS', 'noreply@example.com'),
];
