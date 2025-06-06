<?php

namespace Warbio\Fortnox\Facades;

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
        return \Warbio\Fortnox\Services\Authenticator::class;
    }
}
