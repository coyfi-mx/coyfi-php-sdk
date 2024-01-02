<?php

use Coyfi\Coyfi;

return [
    'env' => Coyfi::env('COYFI_ENV', 'testing'),
    'key' => Coyfi::env('COYFI_KEY', 'bd7a37da-ad0a-4a6f-9662-04d341703d45'),
    'secret' => Coyfi::env('COYFI_SECRET', 'sandbox'),
];
