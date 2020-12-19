<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * Class UrlEncoder
 * @package App\Facades
 */
class UrlEncoder extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'url-encrypt';
    }
}