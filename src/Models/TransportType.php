<?php

namespace Coyfi\Models;

use Coyfi\Model;

class TransportType extends Model
{
    protected static $table = 'transport_types';

    public $id;
    public $name;
    public $code;
    public $available_at;
    public $revoked_at;
    public $transport_license_types;

    public static function query(array $attributes = [], $offset = 0, $limit = 50, $like = false): array
    {
        $transport_types = parent::query($attributes, $offset, $limit, $like);

        return array_map(function ($transport_type) {
            $transport_license_types = TransportLicenseType::query(['transport_type_id' => $transport_type->id]);
            $transport_type->transport_license_types = $transport_license_types;

            return $transport_type;
        }, $transport_types);
    }
}
