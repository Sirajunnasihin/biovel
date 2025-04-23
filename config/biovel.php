<?php

// config for AKM/Biovel
return [
    /*
    |--------------------------------------------------------------------------
    | Fingerprint Machine Connection Settings
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk koneksi ke mesin fingerprint ZKTeco
    |
    */

    // IP Address dari mesin fingerprint
    'ip' => env('FINGERPRINT_IP', '192.168.1.201'),

    // Port koneksi (default ZKTeco: 4370)
    'port' => env('FINGERPRINT_PORT', 4370),
];
