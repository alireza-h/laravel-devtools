<?php

namespace AlirezaH\LaravelDevTools\Facades;

use AlirezaH\LaravelDevTools\DevTools;
use Illuminate\Support\Facades\Facade;

class LaravelDevTools extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return DevTools::class;
    }
}
