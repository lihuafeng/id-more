<?php


namespace IdMoreInfo\Facades;
use Illuminate\Support\Facades\Facade;

class IdInfo extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        self::clearResolvedInstance('idinfo');

        return 'idinfo';
    }
}