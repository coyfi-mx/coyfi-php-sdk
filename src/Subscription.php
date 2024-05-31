<?php

namespace Coyfi;

class Subscription extends CoyfiObject
{
    public $expires_at;

    /**
     * @var array<>
     */
    public $benefits;

    public static function retrieve()
    {
        $account = ApiResource::get('account');

        return new self($account['activeSubscription']);
    }
}
