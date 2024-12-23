<?php

use Coyfi\Coyfi;

return [
    'path' => __DIR__ . '/../',
    'key' => Coyfi::env('COYFI_KEY'),
    'secret' => Coyfi::env('COYFI_SECRET'),
    'api_url' => Coyfi::env('COYFI_API_URL', 'https://api.coyfi.mx/api/'),
];
