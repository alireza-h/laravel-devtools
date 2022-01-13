<?php

namespace AlirezaH\LaravelDevTools\Business\Cmds;

use Illuminate\Support\Facades\Cache;

class CacheCmd extends Cmd
{
    public function flushTag(string $tag)
    {
        Cache::tags($tag)->flush();
    }

    public function flushKey(string $key)
    {
        Cache::forget($key);
    }
}
