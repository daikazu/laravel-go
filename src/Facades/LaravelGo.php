<?php

namespace Daikazu\LaravelGo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Daikazu\LaravelGo\LaravelGo
 */
class LaravelGo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Daikazu\LaravelGo\LaravelGo::class;
    }
}
