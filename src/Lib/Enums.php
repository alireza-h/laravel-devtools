<?php

namespace AlirezaH\LaravelDevTools\Lib;

final class Enums
{
    public const ENV_LOCAL = 'local';
    public const ENV_DEMO = 'demo';
    public const ENV_PRODUCTION = 'production';

    public const ENV_ALL = [
        self::ENV_LOCAL,
        self::ENV_DEMO,
        self::ENV_PRODUCTION
    ];
}
