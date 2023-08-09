<?php

/** @noinspection PhpDynamicAsStaticMethodCallInspection */

namespace AlirezaH\LaravelDevTools\Lib\ErrorLogger;

use AlirezaH\LaravelDevTools\Entities\ErrorLog;
use Illuminate\Support\Collection;
use Throwable;

class DBErrorLogger extends ErrorLogger
{
    public function getError(string $id, string $type = 'error'): ?ErrorLogItem
    {
        return $this->getErrorLogItem(
            $this->getErrorLogEntity($id),
            true
        );
    }

    public function logError(Throwable $exception, string $type = 'error'): void
    {
        $errorLog = $this->getErrorLogEntity($this->getId($exception));

        $log = [
            'message' => $this->getErrorMessage($exception),
            'count' => 1,
            'type' => $type,
            'preview' => $this->getPreview($exception),
        ];

        if ($errorLog) {
            $log['count'] = ++$errorLog->count;
            $errorLog->update($log);
        } else {
            $log['key'] = $this->getId($exception);
            ErrorLog::create($log);
        }
    }

    public function getAllErrors(string $type = 'error'): Collection
    {
        $errorLogs = ErrorLog::where('type', '=', $type)
            ->select(['id', 'key', 'type', 'count', 'message', 'updated_at'])
            ->get();
        $errorLogItems = collect([]);
        foreach ($errorLogs as $errorLog) {
            $errorLogItems->push(
                $this->getErrorLogItem($errorLog)
            );
        }

        return $errorLogItems;
    }

    public function getErrorCount(Throwable $exception, string $type = 'error'): int
    {
        return $this->getErrorLogEntity($this->getId($exception))->count;
    }

    public function remove(string $id, string $type = 'error'): void
    {
        $this->getErrorLogEntity($id)->delete();
    }

    public function clear(string $type = 'error'): void
    {
        ErrorLog::where('type', '=', $type)
            ->delete();
    }

    public function clearOld(string $type = 'error'): void
    {
        ErrorLog::where('type', '=', $type)
            ->where(
                'updated_at',
                '<=',
                now()->subSeconds($this->getClearOlderThan())
            )
            ->delete();
    }

    private function getErrorLogEntity(string $id): ?ErrorLog
    {
        return ErrorLog::where('key', '=', $id)->first();
    }

    private function getErrorLogItem(ErrorLog $errorLog, bool $withPreview = false)
    {
        return new ErrorLogItem(
            $errorLog->key,
            $errorLog->type,
            $errorLog->message,
            $errorLog->count,
            $errorLog->updated_at->timestamp,
            $withPreview ? $errorLog->preview : null
        );
    }
}
