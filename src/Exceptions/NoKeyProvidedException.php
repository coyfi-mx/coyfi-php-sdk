<?php

namespace Coyfi\Exceptions;

use Exception;

class NoKeyProvidedException extends Exception
{
    public function __construct()
    {
        parent::__construct('COYFI_KEY y COYFI_SECRET no configurados');
    }
}
