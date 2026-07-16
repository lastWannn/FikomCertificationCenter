<?php

/**
 * Konfigurasi Livewire untuk FCC UMI.
 * Livewire digunakan untuk: Auth (Login, Register) dan Admin tools.
 * Semua guard multi-auth (admin/peserta/instruktur) tetap dipertahankan.
 */
return [

    'class_namespace'  => 'App\\Livewire',
    'class_path'       => app_path('Livewire'),
    'view_path'        => resource_path('views/livewire'),

    'component_layout' => 'layouts::auth',

    // Auto-inject Livewire JS/CSS tanpa perlu @livewireStyles/@livewireScripts manual
    'inject_assets'       => true,
    'inject_morph_markers'=> true,

    'legacy_model_binding' => false,
    'smart_wire_keys'      => true,

    'navigate' => [
        'show_progress_bar'  => true,
        'progress_bar_color' => '#FFC81A',  // warna brand FCC
    ],

    'temporary_file_upload' => [
        'disk'       => null,
        'rules'      => null,
        'directory'  => null,
        'middleware' => null,
        'preview_mimes' => ['png','gif','bmp','svg','wav','mp4','mov','avi','wmv','mp3','m4a','jpg','jpeg','mpga','webp','wma'],
        'max_upload_time' => 5,
        'cleanup'         => true,
    ],

    'render_on_redirect' => false,
    'component_placeholder' => null,
    'pagination_theme' => 'tailwind',
    'release_token'    => env('LIVEWIRE_RELEASE_TOKEN', 'fcc-lw-1'),
    'csp_safe'         => false,

    'payload' => [
        'max_size'          => 1024 * 1024,
        'max_nesting_depth' => 10,
        'max_calls'         => 50,
        'max_components'    => 200,
    ],

    'make_command' => [
        'type'  => 'mfc',
        'emoji' => false,
        'with'  => ['js' => false, 'css' => false, 'test' => false],
    ],
];
