<?php

return [
    'defaults' => [
        'guard'     => 'peserta',
        'passwords' => 'peserta',
    ],

    'guards' => [
        'peserta' => [
            'driver'   => 'session',
            'provider' => 'peserta',
        ],
        'admin' => [
            'driver'   => 'session',
            'provider' => 'admins',
        ],
        'instruktur' => [
            'driver'   => 'session',
            'provider' => 'instruktur',
        ],
    ],

    'providers' => [
        'peserta' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Peserta::class,
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Admin::class,
        ],
        'instruktur' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Instruktur::class,
        ],
    ],

    'passwords' => [
        'peserta' => [
            'provider' => 'peserta',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
        'admins' => [
            'provider' => 'admins',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
