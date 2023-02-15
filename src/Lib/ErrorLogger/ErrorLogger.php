<?php

namespace AlirezaH\LaravelDevTools\Lib\ErrorLogger;

use Illuminate\Contracts\Foundation\ExceptionRenderer;
use Illuminate\Support\Collection;
use Throwable;

abstract class ErrorLogger
{
    protected const CLEAR_OLDER_THAN = 3600 * 72;

    abstract public function getError(string $id, string $type = 'error'): ErrorLogItem;

    abstract public function logError(Throwable $exception, string $type = 'error'): void;

    abstract public function getAllErrors(string $type = 'error'): Collection;

    abstract public function getErrorCount(Throwable $exception, string $type = 'error'): int;

    abstract public function remove(string $id, string $type = 'error'): void;

    abstract public function clear(string $type = 'error'): void;

    abstract public function clearOld(string $type = 'error'): void;

    public function getId(Throwable $exception): string
    {
        return md5(
            implode(
                ':',
                [
                    get_class($exception),
                    $this->getErrorMessage($exception),
                    $exception->getFile(),
                    $exception->getLine(),
                ]
            )
        );
    }

    protected function getErrorMessage(Throwable $exception): string
    {
        return $exception->getMessage() ?: get_class($exception);
    }

    protected function getClearOlderThan(): int
    {
        return config('devtools.error_logger.clear_older_than', self::CLEAR_OLDER_THAN);
    }

    protected function getPreview(Throwable $exception): string
    {
        return app(ExceptionRenderer::class)->render($exception);
    }
}
