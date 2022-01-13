<?php

namespace AlirezaH\LaravelDevTools\Lib;

use Illuminate\Container\Container;

trait Application
{
    public function app($abstract = null, array $parameters = [])
    {
        return is_null($abstract) ? $this->container() : $this->container()->make($abstract, $parameters);
    }

    /**
     * @return mixed|\Illuminate\Contracts\Foundation\Application
     */
    private function container()
    {
        return Container::getInstance();
    }
}
