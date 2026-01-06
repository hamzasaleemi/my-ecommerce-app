<?php

return [
    'defaults' => [
        'name' => env('ADMIN_DEFAULT_NAME', 'Admin'),
        'password' => env('ADMIN_DEFAULT_PASSWORD', '12345678'),
        'email' => env('ADMIN_DEFAULT_EMAIL', 'admin@gmail.com')
    ],
];
