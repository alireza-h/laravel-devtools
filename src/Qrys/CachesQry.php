<?php


namespace AlirezaH\LaravelDevTools\Qrys;


class CachesQry extends Qry
{
    public function getModelCacheTags(): array
    {
        return [
            'tags' => config('devtools.cache_tags')
        ];
    }
}
