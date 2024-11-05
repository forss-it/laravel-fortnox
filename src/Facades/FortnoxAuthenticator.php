<?php

namespace KFoobar\Fortnox\Facades;

use Illuminate\Support\Facades\Facade;

class FortnoxAuthenticator extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \KFoobar\Fortnox\Services\Authenticator::class;
    }
}
