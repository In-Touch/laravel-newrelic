<?php
namespace Intouch\LaravelNewrelic\Facades;

use Illuminate\Support\Facades\Facade;

class Newrelic extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'newrelic';
    }

}