<?php

namespace Apiation\ApiationLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Apiation\ApiationLaravel\ApiationLaravel
 */
class ApiationLaravel extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Apiation\ApiationLaravel\ApiationLaravel::class;
    }
}
