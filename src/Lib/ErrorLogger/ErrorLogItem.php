<?php


namespace AlirezaH\LaravelDevTools\Lib\ErrorLogger;


class ErrorLogItem
{
    public string $key;
    public string $type;
    public string $message;
    public int $count;
    public string $timestamp;
    public ?string $preview;

    public function __construct(
        string $key,
        string $type,
        string $message,
        int $count,
        string $timestamp,
        ?string $preview = null
    ) {
        $this->key = $key;
        $this->type = $type;
        $this->message = $message;
        $this->count = $count;
        $this->timestamp = $timestamp;
        $this->preview = $preview;
    }
}
