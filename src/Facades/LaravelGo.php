<?php

namespace Daikazu\LaravelGo\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelGo extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelgo';
    }
}
