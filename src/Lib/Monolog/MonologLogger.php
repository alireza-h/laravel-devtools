<?php

namespace AlirezaH\LaravelDevTools\Lib\Monolog;

use Monolog\Logger;

class MonologLogger
{
    public function __invoke(array $config)
    {
        return (new Logger('devtools'))
            ->pushHandler(new MonologHandler());
    }
}
