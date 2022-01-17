<?php

namespace AlirezaH\LaravelDevTools\Business\Cmds;

use AlirezaH\LaravelDevTools\Lib\ErrorLogger\ErrorLogger;
use Illuminate\Support\Facades\Log;
use Throwable;

class ErrorLogCmd extends Cmd
{
    private ErrorLogger $errorLogger;

    public function __construct()
    {
        $this->errorLogger = $this->app(ErrorLogger::class);
    }

    public function remove(string $id, string $type = 'error'): void
    {
        $this->errorLogger->remove($id, $type);
    }

    public function clear(string $type = 'error'): void
    {
        $this->errorLogger->clear($type);
    }

    public function clearOld(string $type = 'error'): void
    {
        $this->errorLogger->clearOld($type);
    }

    public function log(Throwable $exception): void
    {
        if (!config('devtools.error_logger.enabled')) {
            return;
        }

        if ($this->shouldntLog($exception)) {
            return;
        }

        $logType = $this->getLogType($exception);
        $this->errorLogger->logError($exception, $logType['type']);

        $logType['log_to_slack'] && $this->logToSlack($exception);
    }

    private function shouldntLog(Throwable $exception): bool
    {
        return in_array(get_class($exception), config('devtools.error_logger.dont_log', []));
    }

    private function logToSlack(Throwable $exception): void
    {
        if (!$this->isProduction()) {
            return;
        }

        $errorCount = $this->errorLogger->getErrorCount($exception);

        if (!in_array($errorCount, config('devtools.error_logger.error_count_to_notify', []))) {
            return;
        }

        Log::channel('slack')->error(
            $this->createExceptionMessage(
                $exception,
                $errorCount,
                $this->errorLogger->getId($exception)
            )
        );
    }

    private function getLogType(Throwable $exception): array
    {
        foreach (config('devtools.error_logger.types') as $type => $config) {
            if (in_array(get_class($exception), $config['exceptions'])) {
                return [
                    'type' => $type,
                    'log_to_slack' => $config['log_to_slack']
                ];
            }
        }

        return [
            'type' => 'error',
            'log_to_slack' => true
        ];
    }

    private function createExceptionMessage(Throwable $exception, int $count, string $id): string
    {
        return implode(
            PHP_EOL,
            [
                '<!here>',
                "Count: *$count*",
                'Url: '.route('devtools.errors.preview', ['id' => $id]),
                'Env: '."`{$this->env()}`",
                'Message: `'.get_class($exception).'` , '.$exception->getMessage(),
                "File: {$exception->getFile()}:{$exception->getLine()}",
            ]
        );
    }
}
