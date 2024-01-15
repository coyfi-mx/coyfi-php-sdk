<?php

namespace Coyfi\Models;

use Coyfi\Model;

class ItemType extends Model
{
    protected static $table = 'item_types';

    public $id;
    public $name;
    public $code;
    public $iva;
    public $ieps;
    public $complement;
    public $similar;
    public $available_at;
    public $revoked_at;
    public $border_fiscal_stimulus;
}
