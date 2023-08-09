<?php

namespace AlirezaH\LaravelDevTools\Lib\ErrorLogger;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Exceptions\WhoopsHandler;
use Illuminate\Support\Collection;
use Throwable;
use Whoops\Handler\HandlerInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;
use Whoops\Run as Whoops;

abstract class ErrorLogger
{
    protected const CLEAR_OLDER_THAN = 3600 * 72;

    abstract public function getError(string $id, string $type = 'error'): ?ErrorLogItem;

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
        return substr(
            config('devtools.error_logger.preview') == 'ignition' ?
                $this->getIgnitionPreview($exception) :
                $this->getWhoopsPreview($exception),
            0,
            1500000
        );
    }

    private function getWhoopsPreview(Throwable $exception): string
    {
        $whoops = new Run();
        $handler = new PrettyPageHandler();
        $this->registerBlacklist($handler);

        $handler->handleUnconditionally(true);
        $handler->setEditor(
            function ($file, $line) {
                return [
                    'url' => "phpstorm://open?file=$file&line=$line",
                ];
            }
        );

        $whoops->pushHandler($handler);
        $whoops->writeToOutput(false);
        $whoops->allowQuit(false);

        return $whoops->handleException($exception);
    }

    private function getIgnitionPreview(Throwable $e)
    {
        return tap(
            new Whoops(),
            function ($whoops) {
                $whoops->appendHandler($this->whoopsHandler());

                $whoops->writeToOutput(false);

                $whoops->allowQuit(false);
            }
        )->handleException($e);
    }

    private function whoopsHandler()
    {
        try {
            return app(HandlerInterface::class);
        } catch (BindingResolutionException $e) {
            return (new WhoopsHandler())->forDebug();
        }
    }

    private function registerBlacklist(PrettyPageHandler $handler): void
    {
        foreach (config('app.debug_blacklist', []) as $key => $secrets) {
            foreach ($secrets as $secret) {
                $handler->blacklist($key, $secret);
            }
        }
    }
}
